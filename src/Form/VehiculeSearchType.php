<?php

namespace App\Form;

use App\Entity\VehiculeSearch;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class VehiculeSearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('ville', ChoiceType::class, [
                'choices'  => [
                'Paris' => 1,
                'Lyon' => 2,]
                ])
            ->add('typeVehicule', ChoiceType::class, [
                'choices'  => [
                'Voiture' => 1,
                'Scooter' => 2,
                'Trottinette' => 3,]
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => VehiculeSearch::class,
            'method' => 'get',
            'csrf_protection' => false
        ]);
    }

    public function getBlockPrefix()
    {
        return '';
    }
}
