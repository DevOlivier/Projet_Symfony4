<?php

namespace App\Form;

use App\Entity\User;
use App\Form\ApplicationType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class RegistrationType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName' , TextType::class , 
            $this->getConfigurationFormulaire('Votre prénom' , 'Entrez votre prénom....'))
            ->add('lastName' , TextType::class ,
            $this->getConfigurationFormulaire('Votre nom' , 'Entrez votre nom ...'))
            ->add('email' , EmailType::class , 
            $this->getConfigurationFormulaire('Votre email' , 'Entrez votre email...'))
            ->add('picture' , UrlType::class , 
            $this->getConfigurationFormulaire('Photo de profil' , 'Insérer URL de votre photo de profil...'))
            ->add('hash' , PasswordType::class, 
             $this->getConfigurationFormulaire('Mot de passe' , 'Votre mot de passe ...'))
            ->add('passwordConfirm' , PasswordType::class,
            $this->getConfigurationFormulaire('Confirmez votre mot de passe' , 'Confirmation du mot de passe...'))
            ->add('introduction' , TextType::class , 
            $this->getConfigurationFormulaire('Introduction' , 'Présentez vous en quelques mots...'))
            ->add('description' , TextareaType::class , 
            $this->getConfigurationFormulaire('Description' , 'Présentation compléte...'))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
