<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\ProjectRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProjectRepository::class)]
#[ORM\Table(name: 'project')]
class Project
{
    private const FRONTEND_TECHS = [
        'HTML',
        'CSS',
        'JavaScript',
        'TypeScript',
        'Bootstrap',
        'Tailwind CSS',
        'React',
        'Vue.js',
    ];

    private const BACKEND_TECHS = [
        'PHP',
        'Symfony',
        'API Platform',
        'Node.js',
        'Express',
        'Python',
        'Laravel',
        'MySQL',
        'PostgreSQL',
        'ORM (Doctrine)',
    ];

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private string $title = '';

    #[ORM\Column(type: 'text')]
    private string $description = '';

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $githubUrl = null;

    #[ORM\Column(type: 'json')]
    private array $images = [];

    #[ORM\Column(type: 'json')]
    private array $techStack = [];

    #[ORM\Column(type: 'integer')]
    private int $position = 0;

    #[ORM\Column(type: 'boolean', options: ['default' => true])]
    private bool $isActive = true;

    #[ORM\Column(type: 'datetime_immutable')]
    private \DateTimeImmutable $createdAt;

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getGithubUrl(): ?string
    {
        return $this->githubUrl;
    }

    public function setGithubUrl(?string $githubUrl): static
    {
        $this->githubUrl = $githubUrl;

        return $this;
    }

    public function getImages(): array
    {
        return $this->images;
    }

    public function setImages(array $images): static
    {
        $this->images = $images;

        return $this;
    }

    public function getTechStack(): array
    {
        return $this->normalizeTechStack($this->techStack);
    }

    public function setTechStack(array $techStack): static
    {
        $this->techStack = $this->normalizeTechStack($techStack);

        return $this;
    }

    public function getFrontendTechStack(): array
    {
        return $this->getTechStack()['frontend'];
    }

    public function getBackendTechStack(): array
    {
        return $this->getTechStack()['backend'];
    }

    public function getToolsTechStack(): array
    {
        return $this->getTechStack()['tools'];
    }

    public function getAllTechStack(): array
    {
        $stack = $this->getTechStack();

        return array_values(array_unique([
            ...$stack['frontend'],
            ...$stack['backend'],
            ...$stack['tools'],
        ]));
    }

    public function getPosition(): int
    {
        return $this->position;
    }

    public function setPosition(int $position): static
    {
        $this->position = $position;

        return $this;
    }

    public function isActive(): bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): static
    {
        $this->isActive = $isActive;

        return $this;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @param array<string, mixed>|list<mixed> $techStack
     *
     * @return array{frontend: list<string>, backend: list<string>, tools: list<string>}
     */
    private function normalizeTechStack(array $techStack): array
    {
        $frontend = [];
        $backend = [];
        $tools = [];

        if (
            array_key_exists('frontend', $techStack)
            || array_key_exists('backend', $techStack)
            || array_key_exists('tools', $techStack)
        ) {
            $frontend = $this->sanitizeTechCategory($techStack['frontend'] ?? []);
            $backend = $this->sanitizeTechCategory($techStack['backend'] ?? []);
            $tools = $this->sanitizeTechCategory($techStack['tools'] ?? []);

            return [
                'frontend' => $frontend,
                'backend' => $backend,
                'tools' => $tools,
            ];
        }

        foreach ($this->sanitizeTechCategory($techStack) as $tech) {
            if (in_array($tech, self::FRONTEND_TECHS, true)) {
                $frontend[] = $tech;
                continue;
            }

            if (in_array($tech, self::BACKEND_TECHS, true)) {
                $backend[] = $tech;
                continue;
            }

            $tools[] = $tech;
        }

        return [
            'frontend' => $frontend,
            'backend' => $backend,
            'tools' => $tools,
        ];
    }

    /**
     * @param mixed $values
     *
     * @return list<string>
     */
    private function sanitizeTechCategory(mixed $values): array
    {
        if (!is_array($values)) {
            return [];
        }

        $normalized = array_map(
            static fn (mixed $value): string => trim((string) $value),
            array_filter($values, static fn (mixed $value): bool => is_string($value) || is_numeric($value)),
        );

        return array_values(array_unique(array_filter($normalized, static fn (string $value): bool => $value !== '')));
    }
}
