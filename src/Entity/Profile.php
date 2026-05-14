<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\ProfileRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProfileRepository::class)]
#[ORM\Table(name: 'profile')]
class Profile
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'text')]
    private string $aboutText = '';

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $photoPath = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $cvPath = null;

    #[ORM\Column(type: 'json')]
    private array $frontendSkills = [];

    #[ORM\Column(type: 'json')]
    private array $backendSkills = [];

    #[ORM\Column(type: 'json')]
    private array $toolsSkills = [];

    #[ORM\Column(type: 'integer', options: ['default' => 0])]
    private int $heroImageX = 0;

    #[ORM\Column(type: 'integer', options: ['default' => -120])]
    private int $heroImageY = -120;

    #[ORM\Column(type: 'integer', options: ['default' => 120])]
    private int $heroImageScale = 120;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAboutText(): string
    {
        return $this->aboutText;
    }

    public function setAboutText(string $aboutText): static
    {
        $this->aboutText = $aboutText;

        return $this;
    }

    public function getPhotoPath(): ?string
    {
        return $this->photoPath;
    }

    public function setPhotoPath(?string $photoPath): static
    {
        $this->photoPath = $photoPath;

        return $this;
    }

    public function getCvPath(): ?string
    {
        return $this->cvPath;
    }

    public function setCvPath(?string $cvPath): static
    {
        $this->cvPath = $cvPath;

        return $this;
    }

    public function getFrontendSkills(): array
    {
        return $this->frontendSkills;
    }

    public function setFrontendSkills(array $frontendSkills): static
    {
        $this->frontendSkills = $frontendSkills;

        return $this;
    }

    public function getBackendSkills(): array
    {
        return $this->backendSkills;
    }

    public function setBackendSkills(array $backendSkills): static
    {
        $this->backendSkills = $backendSkills;

        return $this;
    }

    public function getToolsSkills(): array
    {
        return $this->toolsSkills;
    }

    public function setToolsSkills(array $toolsSkills): static
    {
        $this->toolsSkills = $toolsSkills;

        return $this;
    }

    public function getHeroImageX(): int
    {
        return $this->heroImageX;
    }

    public function setHeroImageX(int $heroImageX): static
    {
        $this->heroImageX = $heroImageX;

        return $this;
    }

    public function getHeroImageY(): int
    {
        return $this->heroImageY;
    }

    public function setHeroImageY(int $heroImageY): static
    {
        $this->heroImageY = $heroImageY;

        return $this;
    }

    public function getHeroImageScale(): int
    {
        return $this->heroImageScale;
    }

    public function setHeroImageScale(int $heroImageScale): static
    {
        $this->heroImageScale = $heroImageScale;

        return $this;
    }
}
