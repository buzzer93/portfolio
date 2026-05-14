<?php

declare(strict_types=1);

namespace App\Form\Admin;

use App\Entity\Profile;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
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
            ->add('frontendSkills', HiddenType::class)
            ->add('backendSkills', HiddenType::class)
            ->add('toolsSkills', HiddenType::class)
            ->add('heroImageX', IntegerType::class, [
                'label' => 'Décalage horizontal (X)',
                'attr' => ['min' => -250, 'max' => 250],
            ])
            ->add('heroImageY', IntegerType::class, [
                'label' => 'Décalage vertical (Y)',
                'attr' => ['min' => -350, 'max' => 250],
            ])
            ->add('heroImageScale', IntegerType::class, [
                'label' => 'Zoom (%)',
                'attr' => ['min' => 60, 'max' => 180],
            ])
            ->add('photoFile', FileType::class, [
                'label' => 'Photo de profil',
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new File(
                        maxSize: '10M',
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

        $jsonTransformer = new CallbackTransformer(
            static fn(array $v): string => json_encode($v, JSON_UNESCAPED_UNICODE),
            static fn(string $v): array => json_decode($v, true) ?? [],
        );

        $builder->get('frontendSkills')->addModelTransformer($jsonTransformer);
        $builder->get('backendSkills')->addModelTransformer($jsonTransformer);
        $builder->get('toolsSkills')->addModelTransformer($jsonTransformer);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Profile::class,
        ]);
    }
}
