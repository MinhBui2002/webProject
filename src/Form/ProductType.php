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
use Symfony\Component\Form\Extension\Core\Type\FileType;
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
                FileType::class,
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
                    'label' => 'Description',
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
                    'choice_label' => 'CategoryName',
                    'multiple' => false,
                    'expanded' => false
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
