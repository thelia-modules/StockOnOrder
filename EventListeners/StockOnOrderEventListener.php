<?php

namespace StockOnOrder\EventListeners;

use StockOnOrder\Model\StockOnOrder as StockOnOrderModel;
use StockOnOrder\Model\StockOnOrder;
use StockOnOrder\Model\StockOnOrderConfigQuery;
use StockOnOrder\Model\StockOnOrderDecreaseOnCreationQuery;
use StockOnOrder\Model\StockOnOrderQuery;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Thelia\Core\Event\Order\OrderEvent;
use Thelia\Core\Event\TheliaEvents;
use Thelia\Exception\TheliaProcessException;
use Thelia\Model\ConfigQuery;
use Thelia\Model\Order;
use Thelia\Model\OrderProduct;
use Thelia\Model\ProductSaleElements;
use Thelia\Model\ProductSaleElementsQuery;

/**
 * Class StockOnOrderEventListener
 * @package StockOnOrder\EventListener
 * @author Etienne Perriere - OpenStudio <eperriere@openstudio.fr>
 */
class StockOnOrderEventListener implements EventSubscriberInterface
{
    protected static $stock;

    /**
     * Returns an array of event names this subscriber wants to listen to.
     *
     * @return array The event names to listen to
     *
     * @api
     */
    public static function getSubscribedEvents()
    {
        return [
            TheliaEvents::ORDER_PRODUCT_AFTER_CREATE => ['decreaseOnCreation', 128],
            TheliaEvents::ORDER_UPDATE_STATUS => [ ['getQuantities', 192], ['setQuantities', 64] ]
        ];
    }

    /**
     * Decrease PSE stock on order creation if needed
     *
     * @param OrderEvent $event
     * @throws \Exception
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function decreaseOnCreation(OrderEvent $event)
    {
        $decreaseOnCreation = StockOnOrderDecreaseOnCreationQuery::create()
            ->filterByModuleId($event->getOrder()->getPaymentModuleId())
            ->select('DecreaseOnOrderCreation')
            ->findOne();

        if ($decreaseOnCreation) {
            // Get order's product list
            $orderProductList = $event->getOrder()->getOrderProducts();

            /** @var OrderProduct $orderProduct */
            foreach ($orderProductList as $orderProduct) {
                $productSaleElementsId = $orderProduct->getProductSaleElementsId();

                // If the PSE exists, save its quantity before being changed
                /** @var ProductSaleElements $productSaleElements */
                if (null !== $productSaleElements = ProductSaleElementsQuery::create()->findPk($productSaleElementsId)) {
                    // Check if there is enough stock
                    if ($orderProduct->getQuantity() > $productSaleElements->getQuantity() && true === ConfigQuery::checkAvailableStock()) {
                        throw new TheliaProcessException($productSaleElements->getRef() . " : Not enough stock");
                    }

                    // Decrease stock and save
                    $productSaleElements->setQuantity($productSaleElements->getQuantity() - $orderProduct->getQuantity());
                    $productSaleElements->save();
                }
            }

            // Save that stock has been decreased
            (new StockOnOrderModel())
                ->setOrderId($event->getOrder()->getId())
                ->setIsStockDecreased(true)
                ->save();
        } else {
            // Don't decrease stock & save that it hasn't been decreased
            (new StockOnOrderModel())
                ->setOrderId($event->getOrder()->getId())
                ->setIsStockDecreased(false)
                ->save();
        }
    }

    /* ###################
     * 192 PRIORITY METHOD
     * ################### */

    /**
     * Get PSE stock before Thelia default behavior
     *
     * @param OrderEvent $event
     */
    public function getQuantities(OrderEvent $event)
    {
        // Get order's product list
        $orderProductList = $event->getOrder()->getOrderProducts();

        /** @var OrderProduct $orderProduct */
        foreach ($orderProductList as $orderProduct) {
            $productSaleElementsId = $orderProduct->getProductSaleElementsId();

            // If the PSE exists, save its quantity before being changed
            /** @var ProductSaleElements $productSaleElements */
            if (null !== $productSaleElements = ProductSaleElementsQuery::create()->findPk($productSaleElementsId)) {
                static::$stock[$productSaleElementsId] = $productSaleElements->getQuantity();
            }
        }
    }

    /* ###################
     * 64 PRIORITY METHODS
     * ################### */

    public function setQuantities(OrderEvent $event)
    {
        // Get new status, order & product list
        $newStatus = $event->getStatus();
        $order = $event->getOrder();

        // Get behavior according to module & status
        $behavior = StockOnOrderConfigQuery::create()
            ->filterByModuleId($order->getPaymentModuleId())
            ->filterByStatusId($newStatus)
            ->select('Behavior')
            ->findOne();

        // Get if the order's PSEs' stocks have already been decreased
        $stockOnOrder = StockOnOrderQuery::create()
            ->findOneByOrderId($order->getId());

        // If quantities have to be changed
        if (($behavior === 'decrease' && !$stockOnOrder->getIsStockDecreased()) ||
            ($behavior === 'increase' && $stockOnOrder->getIsStockDecreased())) {
            $this->actionOnQuantities($order, $behavior, $stockOnOrder);
        } else {
            $this->actionOnQuantities($order, 'do_nothing', $stockOnOrder);
        }
    }

    public function actionOnQuantities(Order $order, $behavior, $stockOnOrder)
    {
        // Get order products
        $orderProductList = $order->getOrderProducts();

        // For each PSE
        /** @var OrderProduct $orderProduct */
        foreach ($orderProductList as $orderProduct) {
            $productSaleElementsId = $orderProduct->getProductSaleElementsId();

            // If the PSE exists
            /** @var ProductSaleElements $productSaleElements */
            if (null !== $productSaleElements = ProductSaleElementsQuery::create()->findPk($productSaleElementsId)) {
                // Switch on behavior to know which action to do on PSE stock
                switch ($behavior) {
                    case 'do_nothing':
                        $this->doNothingOnQuantities($productSaleElements);
                        break;

                    case 'decrease':
                        $this->decreaseStock($orderProduct, $productSaleElements, $stockOnOrder);
                        break;

                    case 'increase':
                        $this->increaseStock($orderProduct, $productSaleElements, $stockOnOrder);
                        break;

                    default:
                        break;
                }
            }
        }
    }

    public function doNothingOnQuantities(ProductSaleElements $pse)
    {
        // Set quantity of before status update
        $pse->setQuantity(static::$stock[$pse->getId()]);
        $pse->save();
    }

    public function decreaseStock(OrderProduct $orderProduct, ProductSaleElements $pse, StockOnOrder $stockOnOrder)
    {
        // Check if there is enough stock
        if ($orderProduct->getQuantity() > static::$stock[$pse->getId()] && true === ConfigQuery::checkAvailableStock()) {
            throw new TheliaProcessException($pse->getRef() . " : Not enough stock");
        }

        // Decrease stock and save
        $pse
            ->setQuantity(static::$stock[$pse->getId()] - $orderProduct->getQuantity())
            ->save();

        // Save that stock has been decreased
        $stockOnOrder
            ->setIsStockDecreased(true)
            ->save();
    }

    public function increaseStock(OrderProduct $orderProduct, ProductSaleElements $pse, StockOnOrder $stockOnOrder)
    {
        // Increase stock and save
        $pse
            ->setQuantity(static::$stock[$pse->getId()] + $orderProduct->getQuantity())
            ->save();

        // Save that stock has not been decreased
        $stockOnOrder
            ->setIsStockDecreased(false)
            ->save();
    }
}
