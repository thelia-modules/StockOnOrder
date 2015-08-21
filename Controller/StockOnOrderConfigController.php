<?php

namespace StockOnOrder\Controller;

use StockOnOrder\Controller\Base\StockOnOrderConfigController as BaseStockOnOrderConfigController;
use StockOnOrder\Model\StockOnOrderConfigQuery;
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

        // Get configuration for current module
        $conf = StockOnOrderConfigQuery::create()
            ->findByModuleId($moduleId);

        $datas = $conf->getData();

        $behaviorList = [];
        foreach ($datas as $data) {
            $behaviorList[$data->getStatusId()] = $data->getBehavior();
        }

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
     * @return mixed
     */
    public function editAction()
    {
        if (null !== $response = $this->checkAuth(array(AdminResources::MODULE), 'StockOnOrder', AccessManager::UPDATE)) {
            return $response;
        }

        $form = $this->createForm('stock_on_order_config');

        $formEdit = $this->validateForm($form, 'POST');

        $datas = $formEdit->getData();

        foreach ($datas as $data) {
            $config = StockOnOrderConfigQuery::create();
        }
        
    }
}
