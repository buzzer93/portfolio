# Project Profile

## Project identity

Project name: Portfolio Nicolas Rodriguez
Project type: Portfolio personnel avec back-office admin
Main domain: nicolas-rodriguez.fr
Repository: https://github.com/buzzer93/portfolio
Main users: Visiteurs, recruteurs (public) — Nicolas Rodriguez (admin)

## Stack

PHP version: 8.4
Symfony version: 8.0
Database: SQLite (dev) — à confirmer pour production (MariaDB ou SQLite)
Frontend CSS: Tailwind CSS v4 (`@import "tailwindcss"`) via `symfonycasts/tailwind-bundle` + variables CSS custom
Frontend JS: Stimulus (2 controllers), Turbo, ScrollReveal, Vanilla JS
Asset handling: AssetMapper + importmap
API Platform: no
Tests: PHPUnit 13

## Architecture

Selected architecture: classic-symfony

Architecture notes:
- Controllers publics : `HomeController` (page principale + formulaire de contact), `SecurityController` (login/logout admin)
- Controllers admin (`src/Controller/Admin/`) : `DashboardController`, `ProjectController`, `ProfileController`
- Entités Doctrine : `User`, `Project`, `Profile`
- Repositories : `ProjectRepository` (`findActiveOrdered`, `findInactiveOrdered`), `ProfileRepository` (`findProfile`)
- Services : `FileUploader` (upload + suppression de fichiers)
- Forms : `ContactType` (public), `ProjectType`, `ProfileType` (admin)
- Stimulus controllers : `project_modal_controller.js`, `skill_list_controller.js`
- Templates : page publique one-page via `templates/_partials/`, back-office via `templates/admin/`
- Migrations Doctrine : dossier `migrations/` (9 migrations existantes)

## Main features

Features publiques :
- Page one-page : Hero, À propos, Compétences, Projets, Contact
- Formulaire de contact avec protection anti-spam (honeypot + timer)
- Téléchargement du CV

Features admin (zone `/admin`, accès `ROLE_ADMIN`) :
- Tableau de bord listant projets actifs/inactifs
- CRUD complet des projets (titre, description Markdown, images multiples, GitHub URL, tech stack, position, statut actif)
- Réordonnancement des projets par drag-and-drop (endpoint JSON `/admin/projects/reorder`)
- Suppression/réorganisation des images d'un projet
- Édition du profil (texte "À propos", photo, CV, compétences front/back/outils, position image hero)

Sensitive features :
- payment: no
- authentication: yes (form login Symfony Security, ROLE_ADMIN, User entity)
- authorization/voters: no (access_control yaml)
- admin area: yes (`/admin`, protégé par ROLE_ADMIN)
- file uploads: yes (images projets dans `public/images/`, photo profil, CV — via `FileUploader`)
- API: no
- emails: yes (formulaire de contact → Symfony Mailer via Brevo SMTP)

## Entities

### User
- `id`, `email` (unique), `roles` (JSON), `password` (hashé)
- Implémente `UserInterface` + `PasswordAuthenticatedUserInterface`
- Géré via commande `UpdateAdminCredentialsCommand`

### Project
- `id`, `title`, `description` (text), `githubUrl` (nullable), `images` (JSON array), `position`, `techStack` (text nullable), `isActive`, `createdAt`

### Profile
- `id`, `aboutText`, `photoPath` (nullable), `cvPath` (nullable)
- `frontendSkills`, `backendSkills`, `toolsSkills` (JSON arrays)
- `heroImageX`, `heroImageY`, `heroImageScale` (positionnement image hero)

## Main conventions

- CSS : Tailwind v4 avec variables CSS custom (hue/couleurs dans `assets/styles.css`), thème clair/sombre géré en JS via `localStorage`
- Admin : CSS inline dans `templates/admin/layout.html.twig` (pas d'AssetMapper pour l'admin)
- Markdown : descriptions projets rendues via `league/commonmark` + `twig/markdown-extra`
- Icônes : RemixIcon (CDN) + Devicon (CDN)
- Anti-spam contact : honeypot (`website` field) + timer (`formStartedAt` field, fenêtre 3s–2h)
- Mailer : Brevo SMTP (variables `MAILER_BREVO_LOGIN` + `MAILER_BREVO_KEY`)

## Local commands

Install dependencies:
```bash
composer install
```

Start dev server:
```bash
symfony server:start
```

Run tests:
```bash
php bin/phpunit
```

Compile assets (Tailwind + AssetMapper) for production:
```bash
php bin/console tailwind:build --minify
php bin/console asset-map:compile
```

Clear cache:
```bash
php bin/console cache:clear
```

Create/update admin credentials:
```bash
php bin/console app:update-admin-credentials
```

Run migrations:
```bash
php bin/console doctrine:migrations:migrate
```

## Database

Local database: SQLite (`var/data.db`)
Production database: à confirmer (SQLite ou MariaDB)

Migration policy: migrations Doctrine dans `migrations/`

## Deployment

Deployment target: VPS / hébergement
Web server: Apache ou Nginx (pointer sur `public/`)
PHP runtime: PHP 8.4 FPM
Database: à confirmer

Production domain: nicolas-rodriguez.fr

Variables d'environnement à configurer en production (`.env.local`) :
- `APP_SECRET`
- `APP_ENV=prod`
- `DATABASE_URL`
- `MAILER_FROM` (ex: `contact@nicolas-rodriguez.fr`)
- `MAILER_BREVO_LOGIN`
- `MAILER_BREVO_KEY`
- `ADMIN_EMAIL` + `ADMIN_PASSWORD` (utilisés par la commande `UpdateAdminCredentialsCommand`)

## Security notes

Claude may read `.env` when it is used as a template.

Claude must not read:
- `.env.local`
- `.env.prod`
- `secrets/**`

Sensitive changes require a plan before code edits:
- configuration du Mailer
- authentification / sécurité admin
- uploads de fichiers
- déploiement
- migrations
