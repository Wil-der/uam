<?php

namespace App\Form;

use App\Entity\Elemento;
use Doctrine\ORM\Mapping\Id;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Elemento1Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nombre', TextType::class,[
                'attr' => [
                    'class' => 'form__field',
                    'placeholder' => 'Nombre'
                    ],
                'label_attr' => [
                    'class' => 'form__label'
                ],
                'label' => false
            ])
            ->add('html', TextareaType::class, [
                'attr' => [
                    'id' => 'elemento_html'
                ]
            ])
            ->add('css', TextAreaType::class, [
                'attr' => [
                    'id' => 'elemento_css'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Elemento::class,
            'attr' => ['id' => 'form_new']
        ]);
    }
}
