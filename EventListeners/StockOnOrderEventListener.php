<?php

namespace StockOnOrder\EventListeners;

use StockOnOrder\Model\StockOnOrder as StockOnOrderModel;
use StockOnOrder\Model\StockOnOrderConfigQuery;
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
    public function updateStatus(OrderEvent $event)
    {
        $order = $event->getOrder();
        $orderModule = $order->getPaymentModuleId();
        $orderStatus = $order->getStatusId();
        $newStatus = $event->getStatus();

        $behavior = StockOnOrderConfigQuery::create()
            ->filterByModuleId($orderModule)
            ->filterByStatusId($newStatus)
            ->select('behavior')
            ->findOne();

        switch ($behavior) {
            case 'do_nothing':
                // Don't modify stock ; update order status and stop propagation
                $order->setStatusId($newStatus);
                $order->save();
                $event->setOrder($order);
                $event->stopPropagation();
                break;

            case 'decrease':
            case 'increase':
                $this->updateStock($order, $behavior);
                $event->stopPropagation();
                break;

            case 'default':
                break;

            default:
                break;
        }

        $order->setStatusId($newStatus);
        $order->save();

        $event->setOrder($order);

    }

    public function updateStock(Order $order, $behavior)
    {
        $orderProductList = $order->getOrderProducts();

        /** @var OrderProduct $orderProduct */
        foreach ($orderProductList as $orderProduct) {
            $productSaleElementsId = $orderProduct->getProductSaleElementsId();

            // If the PSE exists
            /** @var ProductSaleElements $productSaleElements */
            if (null !== $productSaleElements = ProductSaleElementsQuery::create()->findPk($productSaleElementsId)) {
                switch ($behavior) {
                    case 'decrease':
                        $this->decreaseStock($order, $orderProduct, $productSaleElements);
                        break;

                    case 'increase':
                        $this->increaseStock($order, $orderProduct, $productSaleElements);
                        break;
                }
            }
        }
    }

    public function decreaseStock(Order $order, OrderProduct $orderProduct, ProductSaleElements $productSaleElements)
    {
        // Check if there is enough stock
        if ($orderProduct->getQuantity() > $productSaleElements->getQuantity() && true === ConfigQuery::checkAvailableStock()) {
            throw new TheliaProcessException($productSaleElements->getRef() . " : Not enough stock");
        }

        // Decrease stock and save
        $productSaleElements->setQuantity($productSaleElements->getQuantity() - $orderProduct->getQuantity());
        $productSaleElements->save();

        (new StockOnOrderModel)
            ->setOrderId($order->getId());
    }

    public function increaseStock(Order $order, OrderProduct $orderProduct, ProductSaleElements $productSaleElements)
    {
        // Increase stock and save
        $productSaleElements->setQuantity($productSaleElements->getQuantity() + $orderProduct->getQuantity());
        $productSaleElements->save();
    }

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
            TheliaEvents::ORDER_UPDATE_STATUS => ["updateStatus", 256]
        ];
    }
}