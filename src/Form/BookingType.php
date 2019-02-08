<?php

namespace App\Form;

use App\Entity\Booking;
use App\Form\ApplicationType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class BookingType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('startDate' , DateType::class , 
            ['widget' => 'single_text'],
            $this->getConfigurationFormulaire("Date d'arrivée" , "1 janvier 2019"))
            ->add('endDate' , DateType::class , 
            ['widget' => 'single_text'],
            $this->getConfigurationFormulaire("Date de départ" , "5 janvier 2019"))
            ->add('comment' , TextareaType::class,
            $this->getConfigurationFormulaire(false , "Vous pouvez saisir un commentaire"))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Booking::class,
        ]);
    }
}
