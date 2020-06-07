<?php

namespace App\Form;

use App\Entity\Posts;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use function Sodium\add;

class PostsType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('titulo')
                ->add('foto',FileType::class,[
                    'label' => 'Seleccione una imagen',
                    'mapped' => false,
                    'required' => false,
                    ])
                ->add('contenido',TextareaType::class, [
                    'attr' => ['class' => 'tinymce'],
                ])
                ->add('Guardar',SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
            'data_class' => Posts::class,
        ]);
    }

}
