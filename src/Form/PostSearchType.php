<?php


namespace App\Form;


use App\Entity\City;
use App\Entity\SearchPost;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PostSearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder


         /*   ->add('postType',EntityType::class,[
                'required' => false,
                'label'	 =>false,
                'class' => \App\Entity\PostType::class,
                'choice_label' => 'type',
                'multiple' => true,

            ])*/

            ->add('city',EntityType::class,[
                'required' => false,
                'label'	 =>false,
                'class' => City::class,
                'choice_label' => 'name',
                'multiple' => true,

            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => SearchPost::class,
            'method' => 'get',
            'crsf protection' => false,
        ]);
    }
    public function getBlockPrefix(){
        return '';
    }
}