<?php

namespace App\Form;

use App\Entity\Vehicule;
use App\Entity\TypeVehicule;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class VehiculeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('brand')
            ->add('serie')
            ->add('serial_number')
            ->add('color')
            ->add('license_plate')
            ->add('kilometers')
            ->add('purchase_date')
            ->add('purchase_price')
            ->add('type', EntityType::class, [
                'class' => TypeVehicule::class,
                'choice_label' => 'name',
                // 'multiple' => true,
                // 'expanded' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Vehicule::class,
        ]);
    }
}
