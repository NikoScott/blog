<?php

namespace App\Form;

use App\Entity\Comment;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CommentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            // ->add('date', DateType::class, [
            // ])
            // ->add('isValid', IntegerType::class, [
            // ])
            ->add('comment', TextareaType::class, [
                'label' => 'Commentaire :',
                'attr' => ['class' => 'text-grey'],
            ])
            // ->add('article', NumberType::class, [
            // ])
            // ->add('user', NumberType::class, [
            // ])
            
            ->add('ajouter', SubmitType::class, [
                'attr' => ['class' => 'ajouter btn-primary'],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Comment::class,
        ]);
    }
}
