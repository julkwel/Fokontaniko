<?php
/**
 * © Julkwel <julienrajerison5@gmail.com>
 *
 * Fokontany form.
 */

namespace App\Form;

use App\Entity\Employee;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class ResponsableType.
 */
class EmployeeType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'user',
                UserType::class,
                [
                    'hasUser' => $options['onEdit'],
                ]
            )
            ->add(
                'salary',
                TextType::class,
                [
                    'label' => 'Karama',
                ]
            );
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => Employee::class,
                'onEdit' => false,
            ]
        );
    }
}
