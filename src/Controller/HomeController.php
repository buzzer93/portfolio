<?php

declare(strict_types=1);

namespace App\Controller;

use App\Form\ContactType;
use App\Repository\ProfileRepository;
use App\Repository\ProjectRepository;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    public function __construct(
        private readonly ProjectRepository $projectRepository,
        private readonly ProfileRepository $profileRepository,
        #[Autowire(env: 'MAILER_FROM')]
        private readonly string $mailerFrom,
    ) {}

    #[Route('/', name: 'home')]
    public function index(Request $request, MailerInterface $mailer): Response
    {
        $form = $this->createForm(ContactType::class, null, [
            'form_started_at' => time(),
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $honeypot = (string) $form->get('website')->getData();
            $startedAtRaw = (string) $form->get('formStartedAt')->getData();
            $startedAt = ctype_digit($startedAtRaw) ? (int) $startedAtRaw : 0;
            $elapsedSeconds = time() - $startedAt;

            $isBotSubmission = '' !== trim($honeypot)
                || $startedAt <= 0
                || $elapsedSeconds < 3
                || $elapsedSeconds > 7200;

            if ($isBotSubmission) {
                $this->addFlash('error', 'Échec de vérification anti-spam. Merci de réessayer.');

                return $this->redirectToRoute('home', ['_fragment' => 'contact']);
            }
        }

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $email = (new TemplatedEmail())
                ->from($this->mailerFrom)
                ->replyTo($data['email'])
                ->to('ncls.rodriguez38@gmail.com')
                ->subject('Portfolio - Message de ' . $data['name'])
                ->htmlTemplate('emails/contact.html.twig')
                ->context(['data' => $data]);

            $mailer->send($email);

            $this->addFlash('success', 'Votre message a bien été envoyé ! Je vous répondrai dès que possible.');

            return $this->redirectToRoute('home', ['_fragment' => 'contact']);
        }

        return $this->render('home/index.html.twig', [
            'projects'    => $this->projectRepository->findActiveOrdered(),
            'profile'     => $this->profileRepository->findProfile(),
            'contactForm' => $form,
        ]);
    }
}
