<?php

namespace StockOnOrder\Hook;

use StockOnOrder\Form\StockOnOrderDecreaseOnCreationUpdateForm;
use StockOnOrder\Model\StockOnOrderConfigQuery;
use StockOnOrder\Model\StockOnOrderDecreaseOnCreationQuery;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;
use Thelia\Core\Event\Hook\HookRenderEvent;
use Thelia\Core\Form\TheliaFormFactory;
use Thelia\Core\Hook\BaseHook;
use Thelia\Core\Template\Parser\ParserResolver;
use Thelia\Model\ModuleQuery;

/**
 * Class StockOnOrderHook
 * @package StockOnOrder\Hook
 * @author Etienne Perriere - OpenStudio <eperriere@openstudio.fr>
 */
class StockOnOrderHook extends BaseHook
{
    public function __construct(
        private readonly TheliaFormFactory $formFactory,
        ?EventDispatcherInterface $dispatcher = null,
        ?ParserResolver $parserResolver = null,
    ) {
        parent::__construct($dispatcher, $parserResolver);
    }

    public static function getSubscribedHooks(): array
    {
        return [
            'module.configuration' => [['type' => 'back', 'method' => 'onModuleConfig']],
            'module.config-js'     => [['type' => 'back', 'method' => 'onModuleConfigJs']],
        ];
    }

    public function onModuleConfig(HookRenderEvent $event): void
    {
        $paymentModules = ModuleQuery::create()
            ->filterByType(3)
            ->orderById()
            ->find();

        $rows = [];

        foreach ($paymentModules as $module) {
            $moduleId = $module->getId();

            $decreaseEntry = StockOnOrderDecreaseOnCreationQuery::create()
                ->filterByModuleId($moduleId)
                ->findOne();

            $isModified = StockOnOrderConfigQuery::create()
                ->filterByModuleId($moduleId)
                ->filterByBehavior('default', \Propel\Runtime\ActiveQuery\Criteria::NOT_IN)
                ->count() > 0;

            $form = $this->formFactory->createForm(
                StockOnOrderDecreaseOnCreationUpdateForm::getName(),
                data: [
                    'id'                          => $decreaseEntry?->getId(),
                    'module_id'                   => $moduleId,
                    'decrease_on_order_creation'  => (bool) $decreaseEntry?->getDecreaseOnOrderCreation(),
                ]
            );

            $rows[] = [
                'id'                          => $moduleId,
                'code'                        => $module->getCode(),
                'has_decrease_entry'          => null !== $decreaseEntry,
                'decrease_on_order_creation'  => (bool) $decreaseEntry?->getDecreaseOnOrderCreation(),
                'is_modified'                 => $isModified,
                'form'                        => $form->createView()->getView(),
            ];
        }

        $event->add($this->render('StockOnOrder/stock-on-order-configs.html.twig', [
            'rows' => $rows,
        ]));
    }

    public function onModuleConfigJs(HookRenderEvent $event): void
    {
        $event->add($this->render('StockOnOrder/stock-on-order-config-js.html.twig'));
    }
}
