<?php

namespace StockOnOrder\Hook;

use Thelia\Core\Event\Hook\HookRenderEvent;
use Thelia\Core\Hook\BaseHook;

/**
 * Class StockOnOrderHook
 * @package StockOnOrder\Hook
 * @author Etienne Perriere - OpenStudio <eperriere@openstudio.fr>
 */
class StockOnOrderHook extends BaseHook
{
    public static function getSubscribedHooks(): array
    {
        return [
            'module.configuration' => ['type' => 'back', 'method' => 'onModuleConfig'],
            'module.config-js'     => ['type' => 'back', 'method' => 'onModuleConfigJs'],
        ];
    }

    public function onModuleConfig(HookRenderEvent $event): void
    {
        $event->add($this->render('stock-on-order-configs.html'));
    }

    public function onModuleConfigJs(HookRenderEvent $event): void
    {
        $event->add($this->render('assets/js/stock-on-order-config-js.html'));
    }
}
