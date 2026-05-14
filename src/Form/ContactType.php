<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('website', TextType::class, [
                'mapped' => false,
                'required' => false,
                'attr' => [
                    'autocomplete' => 'off',
                    'tabindex' => '-1',
                    'aria-hidden' => 'true',
                    'class' => 'contact-honeypot',
                ],
            ])
            ->add('formStartedAt', HiddenType::class, [
                'mapped' => false,
                'data' => (string) $options['form_started_at'],
            ])
            ->add('name', TextType::class, [
                'constraints' => [
                    new NotBlank(message: 'Veuillez entrer votre nom.'),
                    new Length(min: 2, max: 100, minMessage: 'Le nom doit contenir au moins {{ limit }} caractères.'),
                ],
            ])
            ->add('email', EmailType::class, [
                'constraints' => [
                    new NotBlank(message: 'Veuillez entrer votre email.'),
                    new Email(message: 'Adresse email invalide.'),
                ],
            ])
            ->add('message', TextareaType::class, [
                'constraints' => [
                    new NotBlank(message: 'Veuillez écrire un message.'),
                    new Length(min: 10, max: 2000, minMessage: 'Le message doit contenir au moins {{ limit }} caractères.'),
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'form_started_at' => null,
        ]);
        $resolver->setAllowedTypes('form_started_at', ['null', 'int']);
    }
}
