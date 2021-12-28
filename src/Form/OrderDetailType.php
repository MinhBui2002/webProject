<?php

namespace App\Form;

use App\Entity\Order;
use App\Entity\OrderDetail;
use App\Entity\Product;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OrderDetailType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('DetailPrice', MoneyType::class,
            [
                'label' => 'Detail price',
                'required' => true,
                
            ])
            ->add('DetailQuantity', IntegerType::class,
            [
                'label' => 'Detail quantity',
                'required' => true,
                
            ])
            ->add('DetailTotal', MoneyType::class,
            [
                'label' => 'Detail total',
                'required' => true,
            ])
            ->add('product', EntityType::class,
            
            [
                'label' => 'Product',
                'choice_label' => 'ProductName',
                'required' => true,
                'class' => Product::class,
                'multiple' => true
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => OrderDetail::class,
        ]);
    }
}
