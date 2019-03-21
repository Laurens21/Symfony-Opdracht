<?php

namespace App\Form;

use App\Entity\Logboek;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LogboekType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('brief_nr')
            ->add('datum')
            ->add('kubs')
            ->add('laadplaats')
            ->add('vertrektijd')
            ->add('bestemming')
            ->add('evenement')
            ->add('userId')
            ->add('chauffeurId')
            ->add('truckId')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Logboek::class,
        ]);
    }
}
