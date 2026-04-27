<?php

namespace StockOnOrder\Loop;

use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use StockOnOrder\Loop\Base\StockOnOrderConfig as BaseStockOnOrderConfigLoop;
use StockOnOrder\Model\StockOnOrderConfigQuery;
use Thelia\Core\Template\Loop\Argument\Argument;
use Thelia\Core\Template\Loop\Argument\ArgumentCollection;

/**
 * Class StockOnOrderConfig
 * @package StockOnOrder\Loop
 * @author Etienne Perriere - OpenStudio <eperriere@openstudio.fr>
 * @method getExcludeBehavior()
 */
class StockOnOrderConfig extends BaseStockOnOrderConfigLoop
{
    public function getArgDefinitions(): ArgumentCollection
    {
        $arguments = parent::getArgDefinitions();
        $arguments->addArgument(
            Argument::createAnyTypeArgument("exclude_behavior")
        );

        return $arguments;
    }

    public function buildModelCriteria(): StockOnOrderConfigQuery|ModelCriteria
    {
        $query = parent::buildModelCriteria();

        if (null !== $behavior = $this->getExcludeBehavior()) {
            $query->filterByBehavior($behavior, Criteria::NOT_IN);
        }

        return $query;
    }
}
