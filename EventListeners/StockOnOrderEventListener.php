<?php

namespace StockOnOrder\EventListeners;

use StockOnOrder\Model\StockOnOrderConfigQuery;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Thelia\Core\Event\Order\OrderEvent;
use Thelia\Core\Event\TheliaEvents;

/**
 * Class StockOnOrderEventListener
 * @package StockOnOrder\EventListener
 * @author Etienne Perriere - OpenStudio <eperriere@openstudio.fr>
 */
class StockOnOrderEventListener implements EventSubscriberInterface
{
    public function updateStock(OrderEvent $event)
    {
        $order = $event->getOrder();
        $orderModule = $order->getPaymentModuleId();
        $orderStatus = $order->getStatusId();
        $newStatus = $event->getStatus();

        $behavior = StockOnOrderConfigQuery::create()
            ->filterByModuleId($orderModule)
            ->filterByStatusId($newStatus)
            ->select('behavior')
            ->find();
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
            TheliaEvents::ORDER_UPDATE_STATUS => ["updateStock", 100]
        ];
    }
}