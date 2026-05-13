<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Project;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private const PROJECTS = [
        [
            'title'       => 'PMS-Itylon',
            'description' => 'Gestion de réservations de locations saisonnières avec tableau de bord, suivi des clients et statistiques via graphiques interactifs.',
            'images'      => ['PMS-itylon.png'],
            'techStack'   => ['PHP', 'MySQL', 'JavaScript', 'ChartJS'],
        ],
        [
            'title'       => 'Gestion de stock',
            'description' => 'Inventaire et étiquetage de produits avec recherche, filtres et impression d\'étiquettes depuis l\'interface.',
            'images'      => ['inventaire.png'],
            'techStack'   => ['Symfony', 'Doctrine', 'MySQL'],
        ],
        [
            'title'       => 'Atlantis-RP',
            'description' => 'Site communautaire GTA-RP présentant les règles, l\'équipe et les actualités du serveur roleplay.',
            'images'      => ['atlantis.png'],
            'techStack'   => ['HTML', 'CSS', 'JavaScript'],
        ],
        [
            'title'       => 'Résidence Itylon',
            'description' => 'Site vitrine de location saisonnière avec galerie, tarifs et formulaire de contact intégré.',
            'images'      => ['itylon.png'],
            'techStack'   => ['PHP', 'HTML', 'CSS'],
        ],
        [
            'title'       => 'Portfolio',
            'description' => 'Portfolio personnel développé sous Symfony, présentant mes projets, compétences et un formulaire de contact.',
            'images'      => ['portfolio.png'],
            'techStack'   => ['Symfony', 'PHP', 'HTML/CSS'],
        ],
        [
            'title'       => "Trièves Connect'",
            'description' => 'Site vitrine pour un magasin informatique local, avec présentation des services, produits et coordonnées.',
            'images'      => ['trieves.png'],
            'techStack'   => ['PHP', 'HTML', 'CSS'],
        ],
    ];

    public function __construct(
        private readonly UserPasswordHasherInterface $passwordHasher,
    ) {
    }

    public function load(ObjectManager $manager): void
    {
        $this->loadProjects($manager);
        $this->loadAdminUser($manager);

        $manager->flush();
    }

    private function loadProjects(ObjectManager $manager): void
    {
        foreach (self::PROJECTS as $position => $data) {
            $project = new Project();
            $project->setTitle($data['title']);
            $project->setDescription($data['description']);
            $project->setImages($data['images']);
            $project->setTechStack($data['techStack']);
            $project->setPosition($position);

            $manager->persist($project);
        }
    }

    private function loadAdminUser(ObjectManager $manager): void
    {
        $email    = $_ENV['ADMIN_EMAIL']    ?? 'admin@portfolio.local';
        $password = $_ENV['ADMIN_PASSWORD'] ?? 'changeme';

        $user = new User();
        $user->setEmail($email);
        $user->setRoles(['ROLE_ADMIN']);
        $user->setPassword($this->passwordHasher->hashPassword($user, $password));

        $manager->persist($user);
    }
}
