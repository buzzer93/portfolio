# Portfolio Nicolas Rodriguez

Application Symfony 8 pour présenter un portfolio développeur, avec une vitrine publique, un formulaire de contact et une interface d'administration sécurisée pour gérer le contenu.

---

## Présentation

Ce projet permet de :

- Afficher une page portfolio : hero, à propos, compétences, projets, contact.
- Gérer dynamiquement les projets et le profil depuis un back-office admin.
- Envoyer les messages du formulaire de contact via Symfony Mailer.
- Stocker les données avec Doctrine, SQLite par défaut en local.

---

## Stack principale

### Backend
- **PHP 8.4** avec `strict_types`
- **Symfony 8.0** — Framework Bundle, Security, Form, Validator, Mailer, Messenger, HttpClient
- **Doctrine ORM 3** + Doctrine Migrations — entités `User`, `Project`, `Profile`
- **league/commonmark** — rendu Markdown des descriptions de projet (via `twig/markdown-extra`)

### Frontend
- **Tailwind CSS v4** (`@import "tailwindcss"`) via `symfonycasts/tailwind-bundle`, compilé avec AssetMapper
- **Twig** — templates partials dans `templates/_partials/`, back-office dans `templates/admin/`
- **Stimulus** (`@hotwired/stimulus` 3.2) — 2 controllers : `project_modal_controller`, `skill_list_controller`
- **ScrollReveal 4** — animations d'apparition au scroll
- **RemixIcon + Devicon** — icônes (CDN)
- **Thème clair/sombre** — géré en Vanilla JS via `localStorage`

### Base de données
- **SQLite** (`var/data.db`) en local et production
- 9 migrations Doctrine

### Infrastructure & outils
- **Symfony Mailer** + **Brevo SMTP** — envoi des messages du formulaire de contact
- **AssetMapper** — gestion des assets JS/CSS sans bundler
- **PHPUnit 13** — tests
- **Symfony CLI** — serveur de développement

---

## Fonctionnalités

### Côté public

- Page d'accueil unique avec sections portfolio.
- Affichage des projets actifs ordonnés avec une gestion du markdown pour les descriptions.
- Affichage du profil : texte, compétences, photo, CV.
- Formulaire de contact serveur avec envoi d'email.

### Côté administration

- Authentification admin : `/admin/login`.
- Tableau de bord admin.
- CRUD projets : création, édition, suppression.
- Description des projets en Markdown : titres, listes, liens, code, gras, italique.
- Statut projet actif/inactif : les projets inactifs sont masqués du site public.
- Section "Projets inactifs" dans le dashboard avec réactivation en un clic.
- Réordonnancement des projets.
- Upload, suppression et réorganisation des images projets.
- Édition du profil : à propos, compétences frontend/backend/outils.
- Upload / remplacement photo de profil.
- Upload / remplacement CV PDF.
- Nettoyage automatique des anciens fichiers remplacés sur le disque.
- Commande console pour mettre à jour les credentials admin : email + mot de passe.

### Sécurité

- Accès `/admin` réservé au rôle `ROLE_ADMIN`.
- Protection CSRF sur la suppression des projets.
- Protection CSRF sur la bascule actif/inactif des projets.
- Authentification Symfony Security.

---

## Installation locale

### 1. Prérequis

- PHP 8.4+
- Composer
- Symfony CLI (recommandé)
- Extension PHP SQLite activée
- Extension PHP `intl` (recommandée)

### 2. Cloner le projet

```bash
git clone https://github.com/buzzer93/portfolio.git
cd portfolio
```

### 3. Installer les dépendances

```bash
composer install
```

### 4. Configurer l'environnement

Le projet fournit un `.env` de base. Pour une configuration locale personnalisée :

```bash
cp .env .env.local
```

Variables utiles :

```dotenv
APP_ENV=dev
APP_DEBUG=1
DATABASE_URL="sqlite:///%kernel.project_dir%/var/data.db"
ADMIN_EMAIL="admin@example.com"
ADMIN_PASSWORD="Admin1234!"

# Mailer — laisser null://null pour désactiver l'envoi en local
# Pour tester avec Brevo, renseigner les trois variables ci-dessous
MAILER_FROM=contact@nicolas-rodriguez.fr
MAILER_BREVO_LOGIN=your_brevo_login%40example.com
MAILER_BREVO_KEY=your_brevo_smtp_key
MAILER_DSN=smtp://${MAILER_BREVO_LOGIN}:${MAILER_BREVO_KEY}@smtp-relay.brevo.com:587
```

> `ADMIN_EMAIL` et `ADMIN_PASSWORD` sont utilisées par les fixtures pour créer le compte administrateur. Définissez-les avant de lancer les fixtures.
>
> `MAILER_BREVO_LOGIN` doit être encodé en URL : remplacer `@` par `%40`.

### 5. Base de données SQLite

Le projet utilise SQLite par défaut. La commande `doctrine:database:create` peut ne pas fonctionner selon la version de Doctrine DBAL. Il faut alors créer le fichier manuellement :

```bash
mkdir -p var
touch var/data.db
```

Puis lancer les migrations :

```bash
php bin/console doctrine:migrations:migrate -n
```

### 6. Fixtures

Les fixtures permettent de charger un utilisateur admin, des projets de démonstration et un profil de démonstration.

```bash
php bin/console doctrine:fixtures:load -n
```

> **Attention :** cette commande vide les tables avant de recharger les données.

Le compte admin créé utilise les valeurs de `.env.local`. Si elles ne sont pas définies, les valeurs par défaut sont :

| Variable | Valeur par défaut |
| --- | --- |
| `ADMIN_EMAIL` | `admin@portfolio.local` |
| `ADMIN_PASSWORD` | `changeme` |

Pour ajouter les données sans vider la base :

```bash
php bin/console doctrine:fixtures:load --append -n
```

Si la commande `doctrine:fixtures:load` n'existe pas, installer le bundle :

```bash
composer require doctrine/doctrine-fixtures-bundle --dev
```

> En production, les fixtures ne sont généralement pas utilisées, car le bundle est installé en dépendance dev.

### 7. Assets Tailwind / AssetMapper

Après installation ou après un `git pull`, reconstruire les assets :

```bash
php bin/console tailwind:build
```

> **Important :** si les assets générés sont absents, le site peut être cassé visuellement, voire provoquer une erreur selon la configuration.

### 8. Lancer le serveur en local

```bash
symfony serve
```

| URL | Accès |
| --- | --- |
| `http://127.0.0.1:8000` | Site public |
| `http://127.0.0.1:8000/admin/login` | Interface admin |

---

## Tests

```bash
php bin/phpunit
```

---

## Commandes utiles

```bash
# Mettre à jour les credentials admin
php bin/console app:admin:update-credentials

# Appliquer les migrations
php bin/console doctrine:migrations:migrate -n

# Vider le cache
php bin/console cache:clear

# Reconstruire Tailwind
php bin/console tailwind:build

# Compiler les assets AssetMapper
php bin/console asset-map:compile
```

---

## Structure des fichiers uploadés

| Type | Dossier |
| --- | --- |
| Images projets | `public/images/` |
| Photos de profil | `public/images/profile/` |
| CV (PDF) | `public/files/` |

Quand un fichier est retiré depuis l'admin ou remplacé, il est supprimé physiquement du dossier correspondant.

Les descriptions de projets peuvent être rédigées en Markdown depuis l'administration. Le rendu est affiché sur la page d'accueil et dans la modale projet.

---

## Déploiement production

Exemple de déploiement sur un VPS Ubuntu avec Caddy et PHP-FPM.

### 1. Se placer dans le projet

```bash
cd /opt/nicolas-rodriguez
```

### 2. Récupérer les dernières modifications

```bash
git pull
```

### 3. Installer les dépendances de production

```bash
composer install --no-dev --optimize-autoloader
```

### 4. Configurer `.env.local`

```bash
nano .env.local
```

Exemple :

```dotenv
APP_ENV=prod
APP_DEBUG=0
DATABASE_URL="sqlite:///%kernel.project_dir%/var/data.db"
MAILER_FROM=contact@nicolas-rodriguez.fr
MAILER_BREVO_LOGIN=your_brevo_login%40example.com
MAILER_BREVO_KEY=your_brevo_smtp_key
MAILER_DSN=smtp://${MAILER_BREVO_LOGIN}:${MAILER_BREVO_KEY}@smtp-relay.brevo.com:587
```

> Remplacer `MAILER_BREVO_LOGIN` et `MAILER_BREVO_KEY` par les vraies valeurs issues de Brevo (**Settings → SMTP & API**). Le `@` du login doit être encodé en `%40`.

### 5. Initialiser SQLite

```bash
mkdir -p var
touch var/data.db
```

### 6. Régler les droits

Le serveur web doit pouvoir écrire dans `var/` (cache, logs, base SQLite) ainsi que dans les dossiers d'upload publics :

- `public/images/`
- `public/images/profile/`
- `public/files/`

Exemple avec PHP-FPM exécuté par `www-data` :

```bash
sudo chown -R buzzer93:www-data var
sudo chown -R buzzer93:www-data public/images public/files

sudo find var -type d -exec chmod 775 {} \;
sudo find var -type f -exec chmod 664 {} \;

sudo find public/images -type d -exec chmod 2775 {} \;
sudo find public/images -type f -exec chmod 664 {} \;
sudo find public/files -type d -exec chmod 2775 {} \;
sudo find public/files -type f -exec chmod 664 {} \;

sudo setfacl -R -m u:www-data:rwX -m u:buzzer93:rwX var
sudo setfacl -dR -m u:www-data:rwX -m u:buzzer93:rwX var
```

> Si les uploads échouent avec un message du type `Unable to write in the "/opt/.../public/images" directory`, le problème vient généralement des permissions Linux sur `public/images`, `public/images/profile` ou `public/files`, pas du code Symfony.

### 7. Appliquer les migrations

```bash
APP_ENV=prod APP_DEBUG=0 php bin/console doctrine:migrations:migrate --no-interaction
```

### 8. Compiler les assets

```bash
APP_ENV=prod APP_DEBUG=0 php bin/console tailwind:build --minify
APP_ENV=prod APP_DEBUG=0 php bin/console asset-map:compile
```

### 9. Vider le cache

```bash
APP_ENV=prod APP_DEBUG=0 php bin/console cache:clear
```

### 10. Redémarrer les services

```bash
sudo systemctl restart php8.4-fpm
sudo systemctl reload caddy
```

### 11. Tester

```bash
curl -I https://nicolas-rodriguez.fr
```

Réponse attendue :

```text
HTTP/2 200
```

---

## Configuration Caddy

Le fichier de configuration se trouve généralement ici :

```text
/etc/caddy/Caddyfile
```

```bash
sudo nano /etc/caddy/Caddyfile
```

Exemple de configuration :

```caddy
www.nicolas-rodriguez.fr, nicolas-rodriguez.fr {
    root * /opt/nicolas-rodriguez/public

    php_fastcgi unix//run/php/php8.4-fpm.sock

    file_server

    log {
        output file /var/log/caddy/nicolas-rodriguez.log
    }

    tls ncls.rodriguez38@gmail.com {
        protocols tls1.2 tls1.3
    }
}
```

> **Attention :** la directive correcte est `file_server` (et non `file_servers`).

```bash
# Vérifier la configuration
sudo caddy validate --config /etc/caddy/Caddyfile

# Formater le fichier
sudo caddy fmt --overwrite /etc/caddy/Caddyfile

# Recharger Caddy
sudo systemctl reload caddy
```

---

## Vérifier PHP-FPM

```bash
# Lister les sockets disponibles
ls /run/php/
```

Exemple attendu : `php8.4-fpm.sock`

Si le socket est différent, adapter la ligne Caddy :

```caddy
php_fastcgi unix//run/php/php8.4-fpm.sock
```

```bash
# Vérifier le service
sudo systemctl status php8.4-fpm

# Voir les logs PHP-FPM
sudo journalctl -u php8.4-fpm -n 80 --no-pager
```

---

## Logs et diagnostic

### Logs Symfony

```bash
# En dev
tail -n 80 var/log/dev.log

# En prod
tail -n 80 var/log/prod.log
```

Si `prod.log` n'existe pas, vérifier l'environnement actif :

```bash
grep -E "APP_ENV|APP_DEBUG|DATABASE_URL" .env .env.local 2>/dev/null
```

### Logs Caddy

```bash
sudo tail -n 80 /var/log/caddy/nicolas-rodriguez.log
sudo journalctl -u caddy -n 80 --no-pager
```

### Erreur 500 en production

Une erreur HTTP 500 signifie que Caddy fonctionne, mais que Symfony ou PHP rencontre une erreur.

Vérifications à faire :

```bash
tail -n 120 var/log/*.log
sudo journalctl -u php8.4-fpm -n 80 --no-pager
sudo tail -n 80 /var/log/caddy/nicolas-rodriguez.log
```

Causes fréquentes :

- Cache Symfony incorrect.
- Permissions insuffisantes sur `var/`.
- Permissions insuffisantes sur `public/images/`, `public/images/profile/` ou `public/files/`.
- Base SQLite non créée.
- Migrations non appliquées.
- Assets Tailwind ou AssetMapper non compilés.
- Mauvais socket PHP-FPM dans Caddy.
- Variable `APP_ENV` ou `DATABASE_URL` incorrecte.
- Dépendances Composer non réinstallées après ajout du support Markdown des descriptions de projet.

Commandes de correction courantes :

```bash
cd /opt/nicolas-rodriguez

sudo chown -R buzzer93:www-data var
sudo chown -R buzzer93:www-data public/images public/files

sudo find var -type d -exec chmod 775 {} \;
sudo find var -type f -exec chmod 664 {} \;

sudo find public/images -type d -exec chmod 2775 {} \;
sudo find public/images -type f -exec chmod 664 {} \;
sudo find public/files -type d -exec chmod 2775 {} \;
sudo find public/files -type f -exec chmod 664 {} \;

sudo setfacl -R -m u:www-data:rwX -m u:buzzer93:rwX var
sudo setfacl -dR -m u:www-data:rwX -m u:buzzer93:rwX var

APP_ENV=prod APP_DEBUG=0 php bin/console doctrine:migrations:migrate --no-interaction
APP_ENV=prod APP_DEBUG=0 php bin/console tailwind:build --minify
APP_ENV=prod APP_DEBUG=0 php bin/console asset-map:compile
APP_ENV=prod APP_DEBUG=0 php bin/console cache:clear

sudo systemctl restart php8.4-fpm
sudo systemctl reload caddy
```

---

## Checklist après un `git pull` en production

```bash
cd /opt/nicolas-rodriguez

git pull

composer install --no-dev --optimize-autoloader

APP_ENV=prod APP_DEBUG=0 php bin/console doctrine:migrations:migrate --no-interaction

sudo chown -R buzzer93:www-data public/images public/files
sudo find public/images -type d -exec chmod 2775 {} \;
sudo find public/images -type f -exec chmod 664 {} \;
sudo find public/files -type d -exec chmod 2775 {} \;
sudo find public/files -type f -exec chmod 664 {} \;

APP_ENV=prod APP_DEBUG=0 php bin/console tailwind:build --minify
APP_ENV=prod APP_DEBUG=0 php bin/console asset-map:compile

APP_ENV=prod APP_DEBUG=0 php bin/console cache:clear

sudo systemctl restart php8.4-fpm
sudo systemctl reload caddy
```

---

## Notes techniques

### Support Markdown des projets

Le rendu Markdown des descriptions de projet utilise `twig/markdown-extra` et `league/commonmark`.

Après un `git pull` contenant cette évolution, toujours relancer :

```bash
composer install --no-dev --optimize-autoloader
```

### Erreur Composer `Undefined array key "entrypoints"`

Si Symfony Flex remonte cette erreur pendant une commande Composer, vérifier que `assets/controllers.json` contient bien une structure valide :

```json
{
    "controllers": {},
    "entrypoints": []
}
```
