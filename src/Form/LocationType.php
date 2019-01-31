<?php

namespace App\Form;

use App\Entity\Location;
use App\Entity\User;
use App\Entity\Vehicule;
use App\Entity\Contrat;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class LocationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('kilometers')
            ->add('time')
            ->add('status')
            // ->add('createdAt')
            // ->add('user', EntityType::class, [
            //     'class' => User::class,
            //     'choice_label' => 'email',
            //     // 'multiple' => true,
            //     // 'expanded' => true,
            // ])
            ->add('vehicule', EntityType::class, [
                'class' => Vehicule::class,
                'choice_label' => 'serial_number',
                // 'multiple' => true,
                // 'expanded' => true,
            ])
            ->add('contrat', EntityType::class, [
                'class' => Contrat::class,
                'choice_label' => 'name',
                // 'multiple' => true,
                // 'expanded' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Location::class,
        ]);
    }
}
