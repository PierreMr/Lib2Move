<?php

namespace App\Form;

use App\Entity\Vehicule;
use App\Entity\TypeVehicule;
use App\Entity\Ville;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
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
            ->add('status')
            ->add('lat')
            ->add('lon')
            ->add('type', EntityType::class, [
                'class' => TypeVehicule::class,
                'choice_label' => 'name',
                // 'multiple' => true,
                // 'expanded' => true,
            ])
            ->add('ville', EntityType::class, [
                'class' => Ville::class,
                'choice_label' => 'name',
                // 'multiple' => true,
                // 'expanded' => true,
            ])
            ->add('image', FileType::class, [
                'data_class' => null,
                'label' => 'Image',
                'required' => false
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
