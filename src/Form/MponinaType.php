<?php
/**
 * © Julkwel <julienrajerison5@gmail.com>
 *
 * Fokontany form.
 */

namespace App\Form;

use App\Constant\MponinaConstant;
use App\Entity\Mponina;
use App\Form\Transformer\MponinaTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class MponinaType.
 */
class MponinaType extends AbstractType
{
    /** @var MponinaTransformer */
    private $mponinaTransformer;

    /**
     * MponinaType constructor.
     *
     * @param MponinaTransformer $mponinaTransformer
     */
    public function __construct(MponinaTransformer $mponinaTransformer)
    {
        $this->mponinaTransformer = $mponinaTransformer;
    }

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
                'dad',
                TextType::class,
                [
                    'label' => 'Ray niteraka',
                    'required' => false,
                ]
            )
            ->add(
                'mum',
                TextType::class,
                [
                    'label' => 'Reny niteraka',
                    'required' => false,
                ]
            );

        $builder->get('dad')->addModelTransformer($this->mponinaTransformer);
        $builder->get('mum')->addModelTransformer($this->mponinaTransformer);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['data_class' => Mponina::class]);
    }
}
