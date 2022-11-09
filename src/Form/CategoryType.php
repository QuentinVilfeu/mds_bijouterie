<?php

namespace App\Form;

use App\Entity\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class CategoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom Category',
                'attr' => [
                    'placeholder' => 'saisir la categorie',
                    'class' => 'border border-primary'
                ],
                'required' => false
            ])

            // ->add('titre', TextareaType::class, [
            //     'mapped' => false
            // ])

            ->add("Ajouter", SubmitType::class, [
                'attr' => [
                    'class' => 'd-block mx-auto btn-primary'// on rajoute des classes pour centrer notre bouton
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Category::class,
        ]);
    }
}
