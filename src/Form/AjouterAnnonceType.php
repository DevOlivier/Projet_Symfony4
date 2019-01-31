<?php
//php bin/console make:form
namespace App\Form;

use App\Entity\Ad;
use App\Form\ImageType;
use Symfony\Component\Form\AbstractType;
use phpDocumentor\Reflection\Types\Integer;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class AjouterAnnonceType extends AbstractType
{
    /**
     * Function qui configure le formulaire
     *
     * @param [type] $label
     * @param [type] $placeholder
     * @return array
     */
    private function getConfigurationFormulaire($label , $placeholder)
    {
        return [
            'label' => $label,
            'attr' => [
                'placeholder' => $placeholder,
            ]
            ];
    }
   
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title' , TextType::class , 
            $this->getConfigurationFormulaire('Titre de l\'annonce :' , 'Titre') )
            ->add('slug' , TextType::class , 
            $this->getConfigurationFormulaire('Lien' , 'URL annonce') )
            ->add('introduction' , TextType::class , 
            $this->getConfigurationFormulaire('Introduction de l\'annonce', 'Intro '))
            ->add('content' , TextareaType::class , 
            $this->getConfigurationFormulaire('Votre annonce' , 'Annonce complète') )
            ->add('coverImage' , UrlType::class , 
            $this->getConfigurationFormulaire('Lien de l\'image' , 'URL une image'))
            ->add('rooms' , IntegerType::class , 
            $this->getConfigurationFormulaire('Nombre de pièce' , 'Combien de pièce compte votre appartement'))
             ->add('price' , MoneyType::class , 
             $this->getConfigurationFormulaire('Prix par nuit' , 'Quel est le prix par nuit ?'))
             //rajouter champ de type collection, ajouter plusieurs champs image, 
             //Permet d'ajouter au sein d'un formulaire plusieurs champs
             ->add('images' , CollectionType::class , [
                 'entry_type' => ImageType::class,
                 'allow_add' => true,
                 'allow_delete' => true,
             ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Ad::class,
        ]);
    }
}
