# Project Profile

## Project identity

Project name: Portfolio Nicolas Rodriguez
Project type: Portfolio personnel
Main domain: nicolas-rodriguez.fr
Repository: https://github.com/buzzer93/portfolio
Main users: Visiteurs, recruteurs

## Stack

PHP version: 8.4
Symfony version: 8.0
Database: aucune
Frontend: Vanilla JS + CSS custom
CSS framework: CSS custom (migration Tailwind possible ultérieurement)
Asset handling: AssetMapper
API Platform: no
Tests: PHPUnit

## Architecture

Selected architecture: classic-symfony

Architecture notes:
- Controller unique (HomeController) qui gère la page principale et le formulaire de contact
- Pas d'entité Doctrine — les projets sont un tableau statique dans HomeController::PROJECTS
- Le formulaire de contact utilise Symfony Form + Symfony Mailer (remplace EmailJS)

## Main features

Important features:
- Page one-page : Hero, À propos, Compétences, Projets, Contact
- Formulaire de contact côté serveur (Symfony Mailer)
- Téléchargement du CV (public/CV-Rodriguez-nicolas.pdf)
- Animations ScrollReveal (installé via AssetMapper importmap)

Sensitive features:
- payment: no
- authentication: no
- authorization/voters: no
- admin area: no
- file uploads: no
- API: no
- emails: yes (formulaire de contact → Symfony Mailer)

## Main conventions

- Une seule page Twig composée de partials dans templates/_partials/
- Les projets sont déclarés dans HomeController::PROJECTS (tableau statique)
- Pour ajouter un projet : modifier la constante et déposer l'image dans public/images/
- Le Mailer utilise MAILER_DSN dans .env.local pour la production

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

Compile assets for production:
```bash
php bin/console asset-map:compile
```

Clear cache:
```bash
php bin/console cache:clear
```

## Database

Local database: aucune
Production database: aucune

Migration policy: N/A (pas de base de données)

## Deployment

Deployment target: VPS / hébergement
Web server: Apache ou Nginx (pointer sur public/)
PHP runtime: PHP 8.4 FPM
Database: aucune

Production domain: nicolas-rodriguez.fr

Variables d'environnement à configurer en production (.env.local) :
- APP_SECRET
- MAILER_DSN (ex: smtp://user:pass@smtp.example.com:587)
- APP_ENV=prod

## Security notes

Claude may read `.env` when it is used as a template.

Claude must not read:
- `.env.local`
- `.env.prod`
- `secrets/**`

Sensitive changes require a plan before code edits:
- configuration du Mailer
- déploiement
