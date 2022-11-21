<?php

namespace StockOnOrder\Form;

use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Validator\Constraints;
use Thelia\Form\BaseForm;

/**
 * Class StockOnOrderConfigForm
 * @package StockOnOrder\Form
 * @author Etienne Perriere - OpenStudio <eperriere@openstudio.fr>
 */
class StockOnOrderConfigForm extends BaseForm
{
    protected function buildForm()
    {
        $this->formBuilder
            ->add(
                'module_id', IntegerType::class,
                ['constraints' => [new Constraints\NotBlank()]]
            )
            ->add(
                'behavior', 'collection',
                [
                    'type' => ChoiceType::class,
                    'allow_add'    => true,
                    'allow_delete' => true,
                    'options' => [
                        'choices' => [
                            'do_nothing' => 'Do nothing',
                            'decrease' => 'Decrease',
                            'increase' => 'Increase',
                            'default' => 'Default'
                        ]
                    ],
                ]
            )
        ;
    }

    /**
     * @return string the name of you form. This name must be unique
     */
    public static function getName()
    {
        return "stock_on_order_config";
    }
}
