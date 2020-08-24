<?php
/**
 * @author <Bocasay>.
 */

namespace App\Form;

use App\Constant\GlobalConstant;
use App\Entity\Adidy;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class AdidyType.
 */
class AdidyType extends AbstractType
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
                TextType::class,
                [
                    'label' => 'Karazan\'adidy',
                ]
            )
            ->add(
                'month',
                ChoiceType::class,
                [
                    'choices' => array_flip(GlobalConstant::MONTH_LIST),
                    'label' => 'Volana',
                ]
            )
            ->add(
                'amount',
                TextType::class,
                [
                    'label' => 'Vola naloha',
                ]
            );
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['data_class' => Adidy::class]);
    }
}
