<?php

declare(strict_types=1);

namespace App\Form\Admin;

use App\Entity\Project;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
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
            ->add('techStack', HiddenType::class, [
                'required' => false,
            ])
            ->add('position', IntegerType::class, [
                'label' => 'Position',
            ])
            ->add('isActive', CheckboxType::class, [
                'label' => 'Projet actif (visible sur le site)',
                'required' => false,
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
            static fn(array $tech): string => json_encode(self::normalizeTechStack($tech), JSON_UNESCAPED_UNICODE) ?: '{}',
            static fn(string $tech): array => self::normalizeTechStack(self::decodeTechStack($tech)),
        ));
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Project::class,
        ]);
    }

    /**
     * @param array<string, mixed>|list<mixed> $value
     *
     * @return array{frontend: list<string>, backend: list<string>, tools: list<string>}
     */
    private static function normalizeTechStack(array $value): array
    {
        $frontend = self::sanitizeTechCategory($value['frontend'] ?? []);
        $backend = self::sanitizeTechCategory($value['backend'] ?? []);
        $tools = self::sanitizeTechCategory($value['tools'] ?? []);

        if (array_key_exists('frontend', $value) || array_key_exists('backend', $value) || array_key_exists('tools', $value)) {
            return [
                'frontend' => $frontend,
                'backend' => $backend,
                'tools' => $tools,
            ];
        }

        foreach (self::sanitizeTechCategory($value) as $tech) {
            $tools[] = $tech;
        }

        return [
            'frontend' => $frontend,
            'backend' => $backend,
            'tools' => array_values(array_unique($tools)),
        ];
    }

    /**
     * @return array<string, mixed>|list<mixed>
     */
    private static function decodeTechStack(string $value): array
    {
        if (trim($value) === '') {
            return [];
        }

        $decoded = json_decode($value, true);

        return is_array($decoded) ? $decoded : [];
    }

    /**
     * @param mixed $values
     *
     * @return list<string>
     */
    private static function sanitizeTechCategory(mixed $values): array
    {
        if (!is_array($values)) {
            return [];
        }

        $normalized = array_map(
            static fn (mixed $item): string => trim((string) $item),
            array_filter($values, static fn (mixed $item): bool => is_string($item) || is_numeric($item)),
        );

        return array_values(array_unique(array_filter($normalized, static fn (string $item): bool => $item !== '')));
    }
}
