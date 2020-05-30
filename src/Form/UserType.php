<?php
/**
 * © Julkwel <julienrajerison5@gmail.com>
 *
 * Fokontany form.
 */

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class UserType.
 */
class UserType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'firstName',
                TextType::class,
                [
                    'label' => 'Anarana',
                ]
            )
            ->add(
                'lastName',
                TextType::class,
                [
                    'label' => 'Fanampin\'anarana',

                ]
            )
            ->add(
                'contact',
                TextType::class,
                [
                    'label' => 'Laharan\'ny finday',
                ]
            )
            ->add(
                'adresse',
                TextType::class,
                [
                    'label' => 'Adiresy mazava',
                ]
            )
            ->add(
                'cin',
                TextType::class,
                [
                    'label' => 'Karapanondro',
                ]
            )
            ->add(
                'userName',
                TextType::class,
                [
                    'label' => 'Anarana fidirana',
                ])
            ->add(
                'password',
                TextType::class,
                [
                    'label' => 'Teny miafina',
                    'mapped' => false,
                ]
            );
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
