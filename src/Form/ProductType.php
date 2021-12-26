<?php

namespace App\Form;

use App\Entity\Product;
use App\Entity\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'ProductName',
                TextType::class,
                [
                    'label' => 'Name',
                    'required' => true
                ]
            )
            ->add(
                'ProductQuantity',
                IntegerType::class,
                [
                    'label' => 'Quantity',
                    'required' => true
                ]
            )
            ->add(
                'ProductPrice',
                MoneyType::class,
                [
                    'label' => 'Price',
                    'required' => true,
                    'currency' => 'VND'
                ]
            )
            ->add(
                'ProductImage',
                TextType::class,
                [
                    'label' => 'Image',
                    'data_class' => null,
                    'required' => is_null($builder->getData()->getProductImage())
                ]
            )
            ->add(
                'ProductDescription',
                TextType::class,
                [
                    'label' => 'Name',
                    'required' => true
                ]
            )
            ->add(
                'category', 
                EntityType::class,
                [
                    'label' => 'Category',
                    'required' => true,
                    'class' => Category::class,
                    'multiple' => false
                ]
            )
            ->add(
                'category',
                EntityType::class,
            
                [
                    'label' => 'Category',
                    'required' => true,
                    'class' => Category::class,
                    'multiple' => false
                ]
            )
            ->add('Add', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
