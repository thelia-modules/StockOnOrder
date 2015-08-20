<?php

namespace StockOnOrder\Controller;

use StockOnOrder\Controller\Base\StockOnOrderConfigController as BaseStockOnOrderConfigController;
use Thelia\Core\HttpFoundation\Request;

/**
 * Class StockOnOrderConfigController
 * @package StockOnOrder\Controller
 * @author Etienne Perriere - OpenStudio <eperriere@openstudio.fr>
 */
class StockOnOrderConfigController extends BaseStockOnOrderConfigController
{
    public function viewModuleAction(Request $request)
    {
        $moduleId = $request->get('id');

        return  $this->render('stock-on-order-config-edit', []);
    }
}
