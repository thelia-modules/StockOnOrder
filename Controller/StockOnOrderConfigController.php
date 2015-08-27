<?php

namespace StockOnOrder\Controller;

use StockOnOrder\Controller\Base\StockOnOrderConfigController as BaseStockOnOrderConfigController;
use StockOnOrder\Model\StockOnOrderConfig;
use StockOnOrder\Model\StockOnOrderConfigQuery;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Thelia\Core\HttpFoundation\Request;
use Thelia\Core\Security\AccessManager;
use Thelia\Core\Security\Resource\AdminResources;

/**
 * Class StockOnOrderConfigController
 * @package StockOnOrder\Controller
 * @author Etienne Perriere - OpenStudio <eperriere@openstudio.fr>
 */
class StockOnOrderConfigController extends BaseStockOnOrderConfigController
{
    /**
     * Get payment module configuration to display it and return the view
     *
     * @param Request $request
     * @return mixed|\Thelia\Core\HttpFoundation\Response
     */
    public function viewModuleAction(Request $request)
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

        // Fill and send form into the view
        $form = $this->createForm('stock_on_order_config', 'form', [
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
     * @return mixed|\Symfony\Component\HttpFoundation\Response|\Thelia\Core\HttpFoundation\Response
     */
    public function editAction($moduleId)
    {
        if (null !== $response = $this->checkAuth(array(AdminResources::MODULE), 'StockOnOrder', AccessManager::UPDATE)) {
            return $response;
        }

        // Validate form and get its data
        $form = $this->createForm('stock_on_order_config');

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
                null,
                $e->getMessage(),
                $form
            );

            return $this->render('stock-on-order-config-edit', ['moduleId' => $moduleId]);
        }
    }
}
