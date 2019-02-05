<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class PasswordUpdateType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('oldPassword' , PasswordType::class , 
            $this->getConfigurationFormulaire('Votre ancien mot de passe' , '********'))
            ->add('newPassword' , PasswordType::class , 
            $this->getConfigurationFormulaire('Votre nouveau mot de passe' , '********'))
            ->add('confirmPassword' , PasswordType::class , 
            $this->getConfigurationFormulaire('Confirmez votre mot de passe' , '********'))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
