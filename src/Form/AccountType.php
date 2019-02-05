<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class AccountType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName' , TextType::class ,
            $this->getConfigurationFormulaire('Prénom :' , 'Modifier')) 
            ->add('lastName' , TextType::class ,
            $this->getConfigurationFormulaire('Nom :' , 'Modifier'))
            ->add('email' , EmailType::class ,
            $this->getConfigurationFormulaire('Email :' , 'Modifier'))
            ->add('picture' , UrlType::class ,
            $this->getConfigurationFormulaire('URL image :' , 'Modifier'))
            ->add('introduction' , TextType::class ,
            $this->getConfigurationFormulaire('Introduction de votre profil :' , 'Modifier'))
            ->add('description' , TextareaType::class ,
            $this->getConfigurationFormulaire('Description de votre profil :' , 'Modifier'))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
