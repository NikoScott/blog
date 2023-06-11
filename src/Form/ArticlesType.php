<?php

namespace App\Form;

use App\Entity\Articles;
use App\Entity\Category;
use EasyCorp\Bundle\EasyAdminBundle\Form\Type\TextEditorType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class ArticlesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Titre',])
            ->add('catchPhrase', TextareaType::class, [
                'label' => "Phrase d'accroche",])
            ->add('date', DateType::class, [
                'data' => new \DateTime()])
            ->add('author', TextType::class, [
                'label' => "Auteur",])
            ->add('description', TextEditorType::class, [
                'label' => "Description",])
            
            ->add('relatedSubjects', CollectionType::class, [
                'label' => 'Hashtag/Sujet',
                'entry_type' => TextType::class,
                'allow_add' => true,
            ])
            ->add('authorWebsite', TextType::class, [
                'label' => "Site de l'auteur",])
            ->add('newCategory', TextType::class, array(
                'label' => 'Nouvelle catégorie',
                'required' => false,
                'mapped' => false, // n'est pas lié à une colonne en BDD
                'row_attr' => ['class' => 'show_category d-none']
            ))
            ->add('category', EntityType::class, [
                'label' => 'Catégorie',
                'placeholder' => '--',
                'class' => Category::class,
                'required' => false
            ])
            ->add('posterFile', FileType::class, array(
                'label' => 'Photo',
                'required' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez ajouter une image',
                    ]),
                ],
                ))
            ->add('legendMainPicture', TextType::class, [
                'label' => "Légende de la photo",])
            ->add('modifier', SubmitType::class, [
                'attr' => ['class' => 'save btn-primary'],
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Articles::class,
        ]);
    }
}