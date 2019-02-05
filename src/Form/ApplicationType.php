<?php 

namespace App\Form;
use Symfony\Component\Form\AbstractType;

class ApplicationType extends AbstractType
{
    /**
     * Function qui configure le formulaire
     *
     * @param string $label
     * @param string $placeholder
     * @param array $option
     * @return array
     */
    protected  function getConfigurationFormulaire($label , $placeholder)
    {
        return [
            'label' => $label,
            'attr' => [
                'placeholder' => $placeholder,
            ]
        ];
    }

}