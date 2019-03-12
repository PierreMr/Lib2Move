<?php

namespace App\Form;

use App\Entity\Contrat;
use App\Entity\TypeVehicule;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class ContratType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('max_km')
            ->add('max_time')
            ->add('price')
            ->add('km_penalty')
            ->add('time_penalty')
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
            'data_class' => Contrat::class,
        ]);
    }
}
