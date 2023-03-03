<?php

namespace App\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class NewsType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('title', TextType::class, [
            "label" => false,
            'attr' =>[
                "placeholder" => "Title of new..",
            ],
        ])
        ->add('text', TextType::class, [
            "label" => false,
            'attr' =>[
                "placeholder" => "Text..",
            ],
        ])
        ->add("category", null, [
            'label' => false,
        ])
        ->add('Create', SubmitType::class, [
            'attr' => [
                'class' => 'btn btn-success',
                    ],
            ]);
        
        
    }



}