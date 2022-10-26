<?php
/*************************************************************************************/
/*      This file is part of the Thelia package.                                     */
/*                                                                                   */
/*      Copyright (c) OpenStudio                                                     */
/*      email : dev@thelia.net                                                       */
/*      web : http://www.thelia.net                                                  */
/*                                                                                   */
/*      For the full copyright and license information, please view the LICENSE.txt  */
/*      file that was distributed with this source code.                             */
/*************************************************************************************/

namespace StockOnOrder;

use StockOnOrder\Model\StockOnOrderConfig;
use StockOnOrder\Model\StockOnOrderConfigQuery;
use StockOnOrder\Model\Map\StockOnOrderConfigTableMap;
use Symfony\Component\DependencyInjection\Loader\Configurator\ServicesConfigurator;
use Thelia\Model\Module;
use Thelia\Model\ModuleQuery;
use Thelia\Model\OrderStatus;
use Thelia\Model\OrderStatusQuery;
use Thelia\Module\BaseModule;
use Propel\Runtime\Connection\ConnectionInterface;
use Thelia\Install\Database;

/**
 * Class StockOnOrder
 * @package StockOnOrder
 * @author Etienne Perriere - OpenStudio <eperriere@openstudio.fr>
 */
class StockOnOrder extends BaseModule
{
    const MESSAGE_DOMAIN = "stockonorder";
    const ROUTER = "router.stockonorder";

    public function postActivation(ConnectionInterface $con = null): void
    {
        try {
            StockOnOrderConfigQuery::create()->findOne();
        } catch (\Exception $e) {
            $database = new Database($con);

            $database->insertSql(null, [__DIR__ . "/Config/create.sql", __DIR__ . "/Config/insert.sql"]);
        }

        // Inject default data for payment modules
        $paymentModuleList = ModuleQuery::create()
            ->findByType(3);

        $orderStatusList = OrderStatusQuery::create()
            ->find();

        /** @var Module $paymentModule */
        foreach ($paymentModuleList as $paymentModule) {
            $paymentStockOnOrderConfig = StockOnOrderConfigQuery::create()
                ->select(StockOnOrderConfigTableMap::STATUS_ID)
                ->filterByModuleId($paymentModule->getId())
                ->find()
                ->toArray();

            /** @var OrderStatus $orderStatus */
            foreach ($orderStatusList as $orderStatus) {
                if (!in_array($orderStatus->getId(), $paymentStockOnOrderConfig)) {
                    (new StockOnOrderConfig)
                        ->setModuleId($paymentModule->getId())
                        ->setStatusId($orderStatus->getId())
                        ->setBehavior('default')
                        ->save();
                }
            }
        }
    }

    public static function configureServices(ServicesConfigurator $servicesConfigurator): void
    {
        $servicesConfigurator->load(self::getModuleCode().'\\', __DIR__)
            ->exclude([THELIA_MODULE_DIR.ucfirst(self::getModuleCode()).'/I18n/*'])
            ->autowire(true)
            ->autoconfigure(true);
    }
}
