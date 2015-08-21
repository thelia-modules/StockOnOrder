<?php

namespace StockOnOrder\Loop;

use Propel\Runtime\ActiveQuery\Criteria;
use StockOnOrder\Loop\Base\StockOnOrderConfig as BaseStockOnOrderConfigLoop;
use Thelia\Core\Template\Loop\Argument\Argument;

/**
 * Class StockOnOrderConfig
 * @package StockOnOrder\Loop
 * @author Etienne Perriere - OpenStudio <eperriere@openstudio.fr>
 */
class StockOnOrderConfig extends BaseStockOnOrderConfigLoop
{
    public function getArgDefinitions()
    {
        $arguments = parent::getArgDefinitions();
        $arguments->addArgument(
            Argument::createAnyTypeArgument("exclude_behavior")
        );

        return $arguments;
    }

    public function buildModelCriteria()
    {
        $query = parent::buildModelCriteria();

        if (null !== $behavior = $this->getExcludeBehavior()) {
            $query->filterByBehavior($behavior, Criteria::NOT_IN);
        }

        return $query;
    }
}
