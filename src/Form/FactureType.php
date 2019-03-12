<?php

namespace App\Form;

use App\Entity\Facture;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FactureType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('contract_name')
            ->add('max_time')
            ->add('max_km')
            ->add('price')
            ->add('km_penalty')
            ->add('time_penalty')
            ->add('city_name')
            ->add('start')
            ->add('end')
            ->add('km_end')
            ->add('vehicule_name')
            ->add('user_email')
            ->add('user_lastname')
            ->add('user_firstname')
            ->add('user_address')
            ->add('user_phone')
            ->add('brand')
            ->add('serie')
            ->add('licence_plate')
            ->add('pdf')
            ->add('tva')
            ->add('final_price')
            ->add('end_final')
            ->add('km_final')
            ->add('status')
            ->add('user_id')
            ->add('vehicule_id')
            ->add('contract_id')
            ->add('location_id')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Facture::class,
        ]);
    }
}
