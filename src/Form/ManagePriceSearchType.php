<?php

declare(strict_types=1);

namespace Vinium\SyliusManagePricePlugin\Form;

use Sylius\Bundle\ProductBundle\Form\Type\ProductAutocompleteChoiceType;
use Sylius\Component\Core\Model\Channel;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class ManagePriceSearchType extends AbstractType
{
    private DataTransformerInterface $productsToCodesTransformer;

    public function __construct(DataTransformerInterface $productsToCodesTransformer)
    {
        $this->productsToCodesTransformer = $productsToCodesTransformer;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('channelCode', EntityType::class, [
                'label' => 'sylius.ui.channel',
                'class' => Channel::class,
                'required' => false,
                'choice_value' => 'code',
            ])
            ->add('productsCode', ProductAutocompleteChoiceType::class, [
                'label' => 'sylius.ui.products',
                'multiple' => true,
                'required' => false,
            ])
        ;
        $builder->get('productsCode')->addModelTransformer($this->productsToCodesTransformer);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => null,
            'validation_groups' => ['sylius_manage_price'],
        ]);
    }
}
