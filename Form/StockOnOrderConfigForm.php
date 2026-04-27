<?php

namespace StockOnOrder\Form;

use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
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
    protected function buildForm(): void
    {
        $this->formBuilder
            ->add(
                'module_id', IntegerType::class,
                ['constraints' => [new Constraints\NotBlank()]]
            )
            ->add(
                'behavior', CollectionType::class,
                [
                    'entry_type' => ChoiceType::class,
                    'allow_add'    => true,
                    'allow_delete' => true,
                    'entry_options' => [
                        'choices' => [
                            'Do nothing' => 'do_nothing',
                            'Decrease' => 'decrease',
                            'Increase' => 'increase',
                            'Default' => 'default'
                        ]
                    ],
                ]
            )
        ;
    }

    /**
     * @return string the name of you form. This name must be unique
     */
    public static function getName(): string
    {
        return "stock_on_order_config";
    }
}
