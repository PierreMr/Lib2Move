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
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class LocationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('kilometers')
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
                'choice_label' => function (Vehicule $vehicule) {
                    return $vehicule->getFullname($vehicule);
                },
                'mapped' => true,
                // 'multiple' => true,
                // 'expanded' => true,
            ])
            ->add('contrat', EntityType::class, [
                'class' => Contrat::class,
                'choice_label' => 'name',
                // 'multiple' => true,
                // 'expanded' => true,
            ])
            // ->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
            //     $location = $event->getData();
            //     $form = $event->getForm();

            //     // checks if the Product object is "new"
            //     // If no data is passed to the form, the data is "null".
            //     // This should be considered a new "Product"
                
            //     $form->get('status')->setData('Test');
            //     $form->get('vehicule')->setData(20);
            // });
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Location::class,
        ]);
    }
}
