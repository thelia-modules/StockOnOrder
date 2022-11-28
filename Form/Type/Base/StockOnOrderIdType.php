<?php
/**
* This class has been generated by TheliaStudio
* For more information, see https://github.com/thelia-modules/TheliaStudio
*/

namespace StockOnOrder\Form\Type\Base;

use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Thelia\Core\Form\Type\Field\AbstractIdType;
use StockOnOrder\Model\StockOnOrderQuery;

/**
 * Class StockOnOrder
 * @package StockOnOrder\Form\Base
 * @author TheliaStudio
 */
class StockOnOrderIdType extends AbstractIdType
{
    const TYPE_NAME = "stock_on_order_id";

    protected function getQuery()
    {
        return new StockOnOrderQuery();
    }

    public function getName()
    {
        return static::TYPE_NAME;
    }

    public function getParent()
    {
        return IntegerType::class;
    }
}
