<?php

namespace App\Form;

use App\Entity\City;
use App\Entity\Post;
use App\Entity\SearchData;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchForm extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('postTypes', EntityType::class, [
                'label' => false,
                'required' => false,
                'class' => \App\Entity\PostType::class,
                'placeholder'=> 'Type'


            ])
            ->add('city', EntityType::class, [
                'label' => false,
                'required' => false,
                'class' => City::class,
                'placeholder'=> 'Ville',


            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => SearchData::class,
            'method' => 'GET',
            'csrf_protection' => false
        ]);
    }

    public function getBlockPrefix()
    {
        return '';
    }

}