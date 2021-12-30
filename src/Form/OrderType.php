<?php

namespace App\Form;

use App\Entity\Order;
use App\Entity\OrderDetail;
use App\Entity\User;
use App\Form\OrderDetailType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class OrderType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('OrderDate' , DateType::class,
        [
            
                'label' => 'Order Date',
                 'required' => true,
                 'widget' => 'single_text'
                 
                 
             
            
        ]
        )
        ->add('User', EntityType::class,
        [
            'label' => 'User',
            'required' => true,
            'choice_label' => 'email',
            'class' => User::class,
            'multiple' => false
        ])
        ->add('orderDetail', OrderDetailType::class)
        ->add('Add', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Order::class,
        ]);
    }
}
