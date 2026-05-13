<?php

namespace App\Controller;

use App\Form\ContactType;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    private const PROJECTS = [
        [
            'title'       => 'PMS-Itylon',
            'description' => 'Gestion de réservations de locations saisonnières avec tableau de bord, suivi des clients et statistiques via graphiques interactifs.',
            'image'       => 'PMS-itylon.png',
            'url'         => 'https://github.com/buzzer93/PMS-itylon',
            'tech'        => ['PHP', 'MySQL', 'JavaScript', 'ChartJS'],
        ],
        [
            'title'       => 'Gestion de stock',
            'description' => 'Inventaire et étiquetage de produits avec recherche, filtres et impression d\'étiquettes depuis l\'interface.',
            'image'       => 'inventaire.png',
            'url'         => 'https://gestion-trieves.nicolas-rodriguez.fr/',
            'tech'        => ['Symfony', 'Doctrine', 'MySQL'],
        ],
        [
            'title'       => 'Atlantis-RP',
            'description' => 'Site communautaire GTA-RP présentant les règles, l\'équipe et les actualités du serveur roleplay.',
            'image'       => 'atlantis.png',
            'url'         => 'http://atlantis-rp.nicolas-rodriguez.fr/',
            'tech'        => ['HTML', 'CSS', 'JavaScript'],
        ],
        [
            'title'       => 'Résidence Itylon',
            'description' => 'Site vitrine de location saisonnière avec galerie, tarifs et formulaire de contact intégré.',
            'image'       => 'itylon.png',
            'url'         => 'https://www.residence-itylon.com/',
            'tech'        => ['PHP', 'HTML', 'CSS'],
        ],
        [
            'title'       => 'Portfolio',
            'description' => 'Portfolio personnel développé sous Symfony, présentant mes projets, compétences et un formulaire de contact.',
            'image'       => 'portfolio.png',
            'url'         => 'https://nicolas-rodriguez.fr/',
            'tech'        => ['Symfony', 'PHP', 'HTML/CSS'],
        ],
        [
            'title'       => "Trièves Connect'",
            'description' => 'Site vitrine pour un magasin informatique local, avec présentation des services, produits et coordonnées.',
            'image'       => 'trieves.png',
            'url'         => 'https://trievesconnect.fr/',
            'tech'        => ['PHP', 'HTML', 'CSS'],
        ],
    ];

    #[Route('/', name: 'home')]
    public function index(Request $request, MailerInterface $mailer): Response
    {
        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $email = (new TemplatedEmail())
                ->from($data['email'])
                ->to('ncls.rodriguez38@gmail.com')
                ->subject('Portfolio - Message de ' . $data['name'])
                ->htmlTemplate('emails/contact.html.twig')
                ->context(['data' => $data]);

            $mailer->send($email);

            $this->addFlash('success', 'Votre message a bien été envoyé ! Je vous répondrai dès que possible.');

            return $this->redirectToRoute('home', ['_fragment' => 'contact']);
        }

        return $this->render('home/index.html.twig', [
            'projects'    => self::PROJECTS,
            'contactForm' => $form,
        ]);
    }
}
