<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Profile;
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
            'description' => 'Application de gestion de réservations de maisons de vacances.',
            'images'      => ['PMS-itylon.png'],
            'techStack'   => [
                'frontend' => ['HTML', 'CSS', 'JavaScript'],
                'backend' => ['PHP', 'MySQL'],
                'tools' => ['Chart.js'],
            ],
            'githubUrl'   => 'https://github.com/buzzer93/PMS-itylon',
        ],
        [
            'title'       => 'Logiciel de gestion des produits',
            'description' => "Solution Web d'inventaire et d'étiquetage de produits d'une boutique.",
            'images'      => ['inventaire.png'],
            'techStack'   => [
                'frontend' => ['HTML', 'CSS', 'JavaScript'],
                'backend' => ['Symfony'],
                'tools' => ['ORM (Doctrine)'],
            ],
            'githubUrl'   => null,
        ],
        [
            'title'       => 'Atlantis-rp',
            'description' => 'Site pour un serveur GTA-RP.',
            'images'      => ['atlantis.png'],
            'techStack'   => [
                'frontend' => ['HTML', 'CSS', 'JavaScript'],
                'backend' => [],
                'tools' => [],
            ],
            'githubUrl'   => null,
        ],
        [
            'title'       => 'Residence-Itylon',
            'description' => 'Site pour une résidence de location saisonnière.',
            'images'      => ['itylon.png'],
            'techStack'   => [
                'frontend' => ['HTML', 'CSS', 'JavaScript'],
                'backend' => ['PHP'],
                'tools' => [],
            ],
            'githubUrl'   => null,
        ],
        [
            'title'       => 'Portfolio',
            'description' => 'Mon propre Portfolio.',
            'images'      => ['portfolio.png'],
            'techStack'   => [
                'frontend' => ['HTML', 'CSS', 'JavaScript'],
                'backend' => [],
                'tools' => [],
            ],
            'githubUrl'   => 'https://github.com/buzzer93/portfolio',
        ],
        [
            'title'       => "Trièves Connect'",
            'description' => "Site pour un magasin d'informatique.",
            'images'      => ['trieves.png'],
            'techStack'   => [
                'frontend' => ['HTML', 'CSS', 'JavaScript'],
                'backend' => ['PHP'],
                'tools' => [],
            ],
            'githubUrl'   => null,
        ],
    ];

    public function __construct(
        private readonly UserPasswordHasherInterface $passwordHasher,
    ) {
    }

    public function load(ObjectManager $manager): void
    {
        $this->loadProjects($manager);
        $this->loadProfile($manager);
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
            $project->setGithubUrl($data['githubUrl']);
            $project->setPosition($position);

            $manager->persist($project);
        }
    }

    private function loadProfile(ObjectManager $manager): void
    {
        $profile = new Profile();
        $profile->setAboutText(
            "J'ai commencé à coder par curiosité, simplement pour comprendre… puis pour me simplifier la vie avec de petits scripts PHP. " .
            "En 2020, j'ai créé mon premier site web et là, ça a fait tilt : j'ai su que c'était ce que je voulais faire de ma vie.\n\n" .
            "En 2023, j'ai décidé de me lancer sérieusement dans une reconversion, en autodidacte, en parallèle de ma vie de famille et de mon travail. " .
            "J'ai alors commencé à créer des sites pour des amis, ainsi que des applications web pour l'entreprise familiale et la boutique d'un ami.\n\n" .
            "Curieux de nature, j'apprends vite, je m'adapte facilement et j'aime comprendre ce qui se cache derrière les outils que j'utilise. " .
            "Le web est pour moi un terrain de jeu infini, un espace d'exploration où chaque problème devient une occasion d'apprendre. " .
            "Patient, rigoureux et déterminé, je progresse en continu avec le souci de bien faire. " .
            "Mon parcours autodidacte reflète ma persévérance et ma volonté de toujours aller plus loin."
        );
        $profile->setFrontendSkills([
            ['label' => 'HTML',       'icon' => 'ri-html5-fill'],
            ['label' => 'CSS',        'icon' => 'ri-css3-fill'],
            ['label' => 'JavaScript', 'icon' => 'ri-javascript-fill'],
            ['label' => 'Boostrap',   'icon' => 'ri-bootstrap-fill'],
        ]);
        $profile->setBackendSkills([
            ['label' => 'PHP',    'icon' => 'ri-code-s-slash-line'],
            ['label' => 'Symfony','icon' => 'devicon-symfony-original'],
            ['label' => 'MySQL',  'icon' => 'ri-database-2-fill'],
        ]);
        $profile->setToolsSkills([
            ['label' => 'Git',    'icon' => 'ri-git-branch-line'],
            ['label' => 'GitHub', 'icon' => 'ri-github-fill'],
            ['label' => 'Docker', 'icon' => 'ri-tools-fill'],
        ]);

        $manager->persist($profile);
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
