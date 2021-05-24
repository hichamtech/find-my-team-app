<?php

namespace App\Form;

use App\Entity\City;
use App\Entity\Post;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PostType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('type',EntityType::class,[
                'class' => \App\Entity\PostType::class,
                'label' =>false
            ])
            ->add('city',EntityType::class,[
                    'class' =>City::class,
                    'label' =>false
                ]
            )
            ->add('description',TextareaType::class,[
                'label'=>false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Post::class,
        ]);
    }
}
