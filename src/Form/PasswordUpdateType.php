<?php

namespace App\Form;

use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PasswordUpdateType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('oldPassword', PasswordType::class, $this->getConfigs('Old Password', 'Enter your old password'))
            ->add('newPassword', PasswordType::class, $this->getConfigs('New Password', 'Enter your new password'))
            ->add('confirmPassword', PasswordType::class, $this->getConfigs('Password Confirmation', 'Comfirm your new Password'))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
