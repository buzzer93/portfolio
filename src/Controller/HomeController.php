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
            'subtitle' => 'PMS-Itylon',
            'title'    => "Application de gestion de réservations de maisons de vacances\nHTML, CSS, JS, Chartjs, MySQL et PHP",
            'image'    => 'PMS-itylon.png',
            'url'      => 'https://github.com/buzzer93/PMS-itylon',
        ],
        [
            'subtitle' => 'Logiciel de gestion des produits',
            'title'    => "Solution Web d'inventaire et d'étiquetage de produits d'une boutique\nSymfony, ORM (Doctrine), HTML, CSS, JS",
            'image'    => 'inventaire.png',
            'url'      => 'https://gestion-trieves.nicolas-rodriguez.fr/',
        ],
        [
            'subtitle' => 'Atlantis-rp',
            'title'    => "Site pour un serveur GTA-RP\nHTML, CSS, JS",
            'image'    => 'atlantis.png',
            'url'      => 'http://atlantis-rp.nicolas-rodriguez.fr/',
        ],
        [
            'subtitle' => 'Residence-Itylon',
            'title'    => "Site pour une résidence de location saisonnière\nHTML, CSS, JS et PHP",
            'image'    => 'itylon.png',
            'url'      => 'https://www.residence-itylon.com/',
        ],
        [
            'subtitle' => 'Portfolio',
            'title'    => "Mon propre Portfolio\nHTML, CSS et JS",
            'image'    => 'portfolio.png',
            'url'      => 'https://nicolas-rodriguez.fr/',
        ],
        [
            'subtitle' => "Trièves Connect'",
            'title'    => "Site pour un magasin d'informatique\nHTML, CSS, JS et PHP",
            'image'    => 'trieves.png',
            'url'      => 'https://trievesconnect.fr/',
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
