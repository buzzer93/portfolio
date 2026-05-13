<?php

declare(strict_types=1);

namespace App\Form\Admin;

use App\Entity\Profile;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class ProfileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('aboutText', TextareaType::class, [
                'label' => 'À propos de moi',
                'attr' => ['rows' => 10],
            ])
            ->add('frontendSkills', TextType::class, [
                'label' => 'Compétences Front-end',
                'help'  => 'Séparées par des virgules : HTML5, CSS3, JavaScript',
                'required' => false,
            ])
            ->add('backendSkills', TextType::class, [
                'label' => 'Compétences Back-end & Outils',
                'help'  => 'Séparées par des virgules : PHP 8, Symfony, MySQL',
                'required' => false,
            ])
            ->add('photoFile', FileType::class, [
                'label' => 'Photo de profil',
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new File(
                        maxSize: '1M',
                        mimeTypes: ['image/jpeg', 'image/png', 'image/webp'],
                        mimeTypesMessage: 'Format accepté : JPG, PNG, WEBP',
                    ),
                ],
            ])
            ->add('cvFile', FileType::class, [
                'label' => 'CV (PDF)',
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new File(
                        maxSize: '5M',
                        mimeTypes: ['application/pdf'],
                        mimeTypesMessage: 'Le CV doit être un fichier PDF',
                    ),
                ],
            ]);

        $arrayToString = new CallbackTransformer(
            static fn(array $v): string => implode(', ', $v),
            static fn(string $v): array => array_values(array_filter(array_map('trim', explode(',', $v)))),
        );

        $builder->get('frontendSkills')->addModelTransformer($arrayToString);
        $builder->get('backendSkills')->addModelTransformer($arrayToString);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Profile::class,
        ]);
    }
}
