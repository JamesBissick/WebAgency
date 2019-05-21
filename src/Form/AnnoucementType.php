<?php

namespace App\Form;

use App\Entity\Advertising;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AnnoucementType extends ApplicationType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('title', TextType::class, $this->getConfigs('Title', 'Enter the title of your advert'))
            ->add('slug', TextType::class, $this->getConfigs('Web URL', 'Enter the wanted URL string (auto)', FALSE))
            ->add('coverImage', UrlType::class, $this->getConfigs('Image URL', 'Enter the main picture of your property!'))
            ->add('introduction', TextType::class, $this->getConfigs('Intro', 'Write a short and global introduction of your property'))
            ->add('content', TextareaType::class, $this->getConfigs('Description', 'Enter a description of your property inside this field'))
            ->add('rooms', IntegerType::class, $this->getConfigs('Number of Rooms', 'Enter the number of rooms your property has'))
            ->add('price', MoneyType::class, $this->getConfigs('Price by nights', 'Enter your price for a night'))
            ->add('images', CollectionType::class, ['entry_type' => ImageType::class, 'allow_add' => TRUE, 'allow_delete' => TRUE])
        ;
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
            'data_class' => Advertising::class,
        ]);
    }
}
