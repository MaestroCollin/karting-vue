<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserPorfileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('username')
            ->add('email')
            ->add('voorletters')
            ->add('tussenvoegsel')
            ->add('achternaam')
            ->add('adres')
            ->add('postcode')
            ->add('woonplaats')
            ->add('telefoon')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'validation_groups' => array('edit'),
        ]);
    }
}
