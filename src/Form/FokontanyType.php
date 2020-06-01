<?php
/**
 * © Julkwel <julienrajerison5@gmail.com>
 *
 * Fokontany form.
 */

namespace App\Form;

use App\Entity\Fokontany;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class FokontanyType.
 */
class FokontanyType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'name',
                TextType::class,
                [
                    'label' => 'Anaran\'ny fokontany',
                ]
            )
            ->add(
                'codeFkt',
                TextType::class,
                [
                    'label' => 'Kaodin\'ny fokontany',
                ]
            );
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Fokontany::class,
        ]);
    }
}
