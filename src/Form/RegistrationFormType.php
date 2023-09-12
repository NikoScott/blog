<?php

namespace App\Form;

use App\Entity\User;
use Doctrine\DBAL\Types\DateType;
use Doctrine\DBAL\Types\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType as TypeDateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType as TypeTextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('firstName', TypeTextType::class, array(
            'label_attr' => ['class' => 'text-less-grey'],
            'attr' => array(
                'placeholder' => 'Votre prénom'),
            'label' => 'Prénom'
        ))
        ->add('lastName', TypeTextType::class, array(
            'label_attr' => ['class' => 'text-less-grey'],
            'attr' => array(
                'placeholder' => 'Votre nom'),
            'label' => 'Nom'
        ))
        ->add('dateOfBirth', TypeDateType::class, array(
            'label_attr' => ['class' => 'text-less-grey'],
            'attr' => array(
                'placeholder' => 'Votre date de naissance'),
            'data' => new \DateTime(),
            'label' => 'Date de naissance'
        ))
        ->add('email', EmailType::class, array(
            'attr' => array(
                'placeholder' => 'exmple@exemple.fr')
        ))
        ->add('sexe', ChoiceType::class, [
            'label_attr' => ['class' => 'text-less-grey'],
            'attr' => array(
                'placeholder' => 'Votre date de naissance'),
                'choices' => [
                    'Homme' => 'm',
                    'Femme' => 'f',
                    'Autre' => 'x'
                ],
        ])
        ->add('agreeTerms', CheckboxType::class, [
            'mapped' => false,
            'constraints' => [
                new IsTrue([
                    'message' => 'Vous devez accepter les conditions.',
                ]),
            ],
            'label' => 'Accepter les conditions'
        ])
        ->add('plainPassword', PasswordType::class, [
            'label' => 'Mot de passe',
            // instead of being set onto the object directly,
            // this is read and encoded in the controller
            'mapped' => false,
            'attr' => ['autocomplete' => 'new-password'],
            'constraints' => [
                new NotBlank([
                    'message' => 'Entrez un mot de passe',
                ]),
                new Length([
                    'min' => 6,
                    'minMessage' => 'Votre mot de passe doit être de {{ limit }} caractères',
                    // max length allowed by Symfony for security reasons
                    'max' => 4096,
                ]),
            ],
        ])
    ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
