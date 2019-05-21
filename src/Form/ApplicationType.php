<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;

class ApplicationType extends AbstractType {

    /**
     * Allows to have basic configurations inside our form
     *
     * @param $label
     * @param $placeholder
     * @param bool $required
     * @return array
     */
    protected function getConfigs($label, $placeholder, $required = TRUE){

        return [
            'label' => $label,
            'attr' => [
                'placeholder' => $placeholder
            ],
            'required' => $required
        ];


    }

}