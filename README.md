# Portfolio Nicolas Rodriguez

Application Symfony 8 pour présenter un portfolio développeur, avec une vitrine publique, un formulaire de contact, et une interface d'administration sécurisée pour gérer le contenu.

## Presentation

Ce projet permet de :
- Afficher une page portfolio (hero, a propos, competences, projets, contact).
- Gerer dynamiquement les projets et le profil depuis un back-office admin.
- Envoyer les messages du formulaire de contact via Symfony Mailer.
- Stocker les donnees avec Doctrine (SQLite en local par defaut).

Stack principale :
- PHP 8.4
- Symfony 8
- Doctrine ORM + Migrations
- Twig
- AssetMapper (JS/CSS)

## Features

Fonctionnalites cote public :
- Page d'accueil unique avec sections portfolio.
- Affichage des projets ordonnes.
- Affichage du profil (texte, competences, photo, CV).
- Formulaire de contact serveur avec envoi d'email.

Fonctionnalites cote admin :
- Authentification admin (`/admin/login`).
- Tableau de bord admin.
- CRUD projets : creation, edition, suppression.
- Reordonnancement des projets.
- Upload et suppression d'images projets.
- Edition du profil (a propos, competences frontend/backend).
- Upload/remplacement photo de profil et CV (PDF).

Securite :
- Acces `/admin` reserve au role `ROLE_ADMIN`.
- Protection CSRF sur la suppression des projets.

## Installation

### 1) Prerequis

- PHP 8.4+
- Composer
- Symfony CLI (recommande)

### 2) Cloner et installer les dependances

```bash
git clone https://github.com/buzzer93/portfolio.git
cd portfolio
composer install
```

### 3) Configurer l'environnement

Le projet fournit deja un `.env` de base (SQLite local et Mailer null).

Optionnel pour du local personnalise :
```bash
cp .env .env.local
```

Variables utiles :
- `DATABASE_URL` (par defaut: SQLite dans `var/data.db`)
- `ADMIN_EMAIL`
- `ADMIN_PASSWORD`
- `MAILER_DSN`

### 4) Initialiser la base de donnees

```bash
php bin/console doctrine:database:create --if-not-exists
php bin/console doctrine:migrations:migrate -n
php bin/console doctrine:fixtures:load -n
```

Les fixtures creent notamment :
- un utilisateur admin (`ADMIN_EMAIL` / `ADMIN_PASSWORD`)
- des projets de demonstration
- un profil de demonstration

### 5) Lancer le serveur

```bash
symfony serve
```

Puis ouvrir :
- Site public : http://127.0.0.1:8000
- Admin : http://127.0.0.1:8000/admin/login

### 6) Lancer les tests

```bash
php bin/phpunit
```

## Notes

- Les images sont stockees dans `public/images`.
- Les photos de profil sont stockees dans `public/images/profile`.
- Les CV sont stockes dans `public/files`.
- En production, configurez un vrai `MAILER_DSN`.
