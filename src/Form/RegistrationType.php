<?php

namespace App\Form;

use App\Entity\User;
use Doctrine\DBAL\Types\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegistrationType extends AbstractType
{
    /**
     * Allows to have basic configurations inside our form
     *
     * @param $label
     * @param $placeholder
     * @param bool $required
     * @return array
     */
    private function getConfigs($label, $placeholder, $required = TRUE){

        return [
            'label' => $label,
            'attr' => [
                'placeholder' => $placeholder
            ],
            'required' => $required
        ];


    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName', TextType::class, $this->getConfigs('Firstname', 'Enter your first name'))
            ->add('lastName', TextType::class, $this->getConfigs('Lastname', 'Enter your last name'))
            ->add('email', EmailType::class, $this->getConfigs('Email', 'Enter your email'))
            ->add('picture', UrlType::class, $this->getConfigs('Profil Picture', 'Enter the URL'))
            ->add('hash', PasswordType::class, $this->getConfigs('Password', 'Enter your password'))
            ->add('intro', TextType::class, $this->getConfigs('Intro', 'Introduce yourself quickly'))
            ->add('description', TextType::class, $this->getConfigs('Detailed description', 'Enter a detailed description of yourself here'))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
