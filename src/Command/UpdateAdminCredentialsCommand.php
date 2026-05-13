<?php

declare(strict_types=1);

namespace App\Command;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[AsCommand(
    name: 'app:admin:update-credentials',
    description: 'Met a jour les credentials du compte administrateur (email + mot de passe).',
)]
class UpdateAdminCredentialsCommand extends Command
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly UserPasswordHasherInterface $passwordHasher,
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        if (!$input->isInteractive()) {
            $io->error('Cette commande doit etre executee en mode interactif.');

            return Command::FAILURE;
        }

        /** @var list<User> $users */
        $users = $this->entityManager->getRepository(User::class)->findAll();
        $admins = array_values(array_filter(
            $users,
            static fn (User $user): bool => in_array('ROLE_ADMIN', $user->getRoles(), true)
        ));

        if ([] === $admins) {
            $io->error('Aucun utilisateur avec le role ROLE_ADMIN n\'a ete trouve.');

            return Command::FAILURE;
        }

        $admin = $admins[0];

        if (count($admins) > 1) {
            $choices = array_map(
                static fn (User $user): string => (string) $user->getEmail(),
                $admins
            );

            $selectedEmail = $io->choice('Plusieurs admins detectes. Lequel voulez-vous modifier ?', $choices, $admin->getEmail());

            foreach ($admins as $candidate) {
                if ($candidate->getEmail() === $selectedEmail) {
                    $admin = $candidate;
                    break;
                }
            }
        }

        $newEmail = (string) $io->ask('Nouvel identifiant (email)', $admin->getEmail(), static function (mixed $value): string {
            $email = trim((string) $value);

            if ('' === $email) {
                throw new \RuntimeException('L\'identifiant ne peut pas etre vide.');
            }

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                throw new \RuntimeException('Veuillez saisir un email valide.');
            }

            return $email;
        });

        $existingUser = $this->entityManager->getRepository(User::class)->findOneBy(['email' => $newEmail]);
        if ($existingUser instanceof User && $existingUser->getId() !== $admin->getId()) {
            $io->error('Cet email est deja utilise par un autre compte.');

            return Command::FAILURE;
        }

        $newPassword = $this->askAndValidatePassword($io);

        $admin->setEmail($newEmail);
        $admin->setPassword($this->passwordHasher->hashPassword($admin, $newPassword));

        $this->entityManager->flush();

        $io->success(sprintf('Credentials admin mis a jour pour %s.', $admin->getEmail()));

        return Command::SUCCESS;
    }

    private function askAndValidatePassword(SymfonyStyle $io): string
    {
        $password = (string) $io->askHidden('Nouveau mot de passe (minimum 8 caracteres)');
        $passwordConfirmation = (string) $io->askHidden('Confirmez le nouveau mot de passe');

        if ('' === trim($password)) {
            throw new \RuntimeException('Le mot de passe ne peut pas etre vide.');
        }

        if (strlen($password) < 8) {
            throw new \RuntimeException('Le mot de passe doit contenir au moins 8 caracteres.');
        }

        if ($password !== $passwordConfirmation) {
            throw new \RuntimeException('Les mots de passe ne correspondent pas.');
        }

        return $password;
    }
}
