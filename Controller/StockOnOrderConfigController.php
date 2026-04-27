<?php

namespace StockOnOrder\Controller;

use StockOnOrder\Controller\Base\StockOnOrderConfigController as BaseStockOnOrderConfigController;
use StockOnOrder\Form\StockOnOrderConfigForm;
use StockOnOrder\Model\StockOnOrderConfig;
use StockOnOrder\Model\StockOnOrderConfigQuery;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;
use Symfony\Contracts\Translation\TranslatorInterface;
use Thelia\Core\HttpFoundation\Request;
use Thelia\Core\Security\AccessManager;
use Thelia\Core\Security\Resource\AdminResources;
use Thelia\Core\Template\ParserContext;
use Thelia\Tools\TokenProvider;

/**
 * Class StockOnOrderConfigController
 * @package StockOnOrder\Controller
 * @author Etienne Perriere - OpenStudio <eperriere@openstudio.fr>
 */
class StockOnOrderConfigController extends BaseStockOnOrderConfigController
{
    #[Route('/admin/module/StockOnOrder/stock_on_order_config', name: 'stockonorder.stock_on_order_config.list', methods: ['GET'])]
    public function defaultAction(): Response
    {
        return parent::defaultAction();
    }

    #[Route('/admin/module/StockOnOrder/stock_on_order_config', name: 'stockonorder.stock_on_order_config.create', methods: ['POST'])]
    public function createAction(EventDispatcherInterface $eventDispatcher, TranslatorInterface $translator): RedirectResponse|Response
    {
        return parent::createAction($eventDispatcher, $translator);
    }

    #[Route('/admin/module/StockOnOrder/stock_on_order_config/edit', name: 'stockonorder.stock_on_order_config.view', methods: ['GET'])]
    public function updateAction(ParserContext $parserContext): Response
    {
        return parent::updateAction($parserContext);
    }

    #[Route('/admin/module/StockOnOrder/stock_on_order_config/edit', name: 'stockonorder.stock_on_order_config.edit', methods: ['POST'])]
    public function processUpdateAction(Request $request, EventDispatcherInterface $eventDispatcher, TranslatorInterface $translator): Response|RedirectResponse
    {
        return parent::processUpdateAction($request, $eventDispatcher, $translator);
    }

    #[Route('/admin/module/StockOnOrder/stock_on_order_config/delete', name: 'stockonorder.stock_on_order_config.delete', methods: ['POST'])]
    public function deleteAction(Request $request, TokenProvider $tokenProvider, EventDispatcherInterface $eventDispatcher, ParserContext $parserContext): Response|RedirectResponse
    {
        return parent::deleteAction($request, $tokenProvider, $eventDispatcher, $parserContext);
    }

    /**
     * Get payment module configuration to display it and return the view
     *
     * @param Request $request
     * @return Response|null
     */
    #[Route('/admin/module/StockOnOrder/viewModule/{id}', name: 'stockonorder.config.view', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function viewModuleAction(Request $request): ?Response
    {
        if (null !== $response = $this->checkAuth(array(AdminResources::MODULE), 'StockOnOrder', AccessManager::VIEW)) {
            return $response;
        }

        $moduleId = $request->get('id');

        // Get current module's configuration
        $stockOnOrderConfigList = StockOnOrderConfigQuery::create()
            ->findByModuleId($moduleId)
            ->getData();

        $behaviorList = [];

        /** @var StockOnOrderConfig $stockOnOrderConfig */
        foreach ($stockOnOrderConfigList as $stockOnOrderConfig) {
            $behaviorList[$stockOnOrderConfig->getStatusId()] = $stockOnOrderConfig->getBehavior();
        }

        // Fill and send the form into the view
        $form = $this->createForm('stock_on_order_config', FormType::class, [
            'module_id' => $moduleId,
            'behavior' => $behaviorList]
        );

        $this->getParserContext()->addForm($form);

        return $this->render('stock-on-order-config-edit', ['moduleId' => $moduleId]);
    }

    /**
     * Update payment module configuration for each order status
     *
     * @param $moduleId
     * @return mixed|Response
     */
    #[Route('/admin/module/StockOnOrder/edit/{moduleId}', name: 'stockonorder.config.edit', methods: ['POST'])]
    public function editAction($moduleId): Response|RedirectResponse
    {
        if (null !== $response = $this->checkAuth(array(AdminResources::MODULE), 'StockOnOrder', AccessManager::UPDATE)) {
            return $response;
        }

        $form = $this->createForm(StockOnOrderConfigForm::getName());

        try {
            $formEdit = $this->validateForm($form, 'POST');

            $formData = $formEdit->getData();

            foreach ($formData['behavior'] as $key => $behavior) {
                StockOnOrderConfigQuery::create()
                    ->filterByModuleId($formData['module_id'])
                    ->filterByStatusId($key)
                    ->update(['Behavior' => $behavior]);
            }

            // Redirect
            if ($this->getRequest()->get('save_mode') == 'stay') {
                return new RedirectResponse($form->getSuccessUrl());
            } else {
                return $this->generateRedirect('/admin/module/StockOnOrder');
            }
        } catch (\Exception $e) {
            $this->setupFormErrorContext(
                get_class($form),
                $e->getMessage(),
                $form
            );

            return $this->render('stock-on-order-config-edit', ['moduleId' => $moduleId]);
        }
    }
}
