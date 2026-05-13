<?php

declare(strict_types=1);

namespace App\Form\Admin;

use App\Entity\Project;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\All;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Url;

class ProjectType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Titre',
                'constraints' => [new NotBlank()],
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description',
                'constraints' => [new NotBlank()],
                'attr' => ['rows' => 4],
            ])
            ->add('githubUrl', UrlType::class, [
                'label' => 'Lien du repo GitHub',
                'required' => false,
                'default_protocol' => 'https',
                'constraints' => [
                    new Url(message: 'Veuillez saisir une URL valide.'),
                ],
            ])
            ->add('techStack', TextType::class, [
                'label' => 'Stack technique',
                'help' => 'Séparées par des virgules : PHP, Symfony, MySQL',
            ])
            ->add('position', IntegerType::class, [
                'label' => 'Position',
            ])
            ->add('imageFiles', FileType::class, [
                'label' => 'Ajouter des images',
                'multiple' => true,
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new All([
                        new File(
                            maxSize: '2M',
                            mimeTypes: ['image/jpeg', 'image/png', 'image/webp'],
                            mimeTypesMessage: 'Format accepté : JPG, PNG, WEBP',
                        ),
                    ]),
                ],
            ]);

        $builder->get('techStack')->addModelTransformer(new CallbackTransformer(
            static fn(array $tech): string => implode(', ', $tech),
            static fn(string $tech): array => array_values(array_filter(array_map('trim', explode(',', $tech)))),
        ));
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Project::class,
        ]);
    }
}
