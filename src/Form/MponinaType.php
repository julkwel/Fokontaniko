<?php
/**
 * © Julkwel <julienrajerison5@gmail.com>
 *
 * Fokontany form.
 */

namespace App\Form;

use App\Constant\MponinaConstant;
use App\Entity\Mponina;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class MponinaType.
 */
class MponinaType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'type',
                ChoiceType::class,
                [
                    'label' => 'Inona ao anaty fianakaviana ?',
                    'choices' => array_flip(MponinaConstant::TYPE),
                ]
            )
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
                'function',
                TextType::class,
                [
                    'label' => 'Asa atao',
                ]
            )
            ->add(
                'adresse',
                TextType::class,
                [
                    'label' => 'Adiresy Mazava',
                ]
            )
            ->add(
                'cin',
                TextType::class,
                [
                    'label' => 'Karapanondro',
                    'required' => false,
                ]
            )
            ->add(
                'note',
                TextareaType::class,
                [
                    'label' => 'Fanamarihana',
                    'required' => false,
                ]
            )
            ->add(
                'contact',
                TextType::class,
                [
                    'label' => 'Fifandraisana',
                    'required' => false,
                ]
            );

        $builder->addEventListener(FormEvents::POST_SET_DATA, function (FormEvent $event) {
            /** @var Mponina $data */
            $data = $event->getData();
            $form = $event->getForm();

            $form->add(
                'dad',
                ChoiceType::class,
                [
                    'choices' => [
                        $data->getDad() => $data->getDad(),
                    ],
                    'attr' => [
                        'class' => 'select2-parent',
                    ],
                ]
            );
            $form->add(
                'mum',
                ChoiceType::class,
                [
                    'choices' => [
                        $data->getMum() => $data->getMum(),
                    ],
                    'attr' => [
                        'class' => 'select2-parent',
                    ],
                ]
            );
        });

        $builder->addEventListener(FormEvents::PRE_SUBMIT, function (FormEvent $events) {
            $data = $events->getData();
            $form = $events->getForm();

            $form->remove('dad');
            $form->remove('mum');

            $form->add('dad', ChoiceType::class, ['choices' => [$data['dad'] => $data['dad']]]);
            $form->add('mum', ChoiceType::class, ['choices' => [$data['mum'] => $data['mum']]]);
        });
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['data_class' => Mponina::class]);
    }
}
