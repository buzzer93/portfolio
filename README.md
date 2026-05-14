Portfolio Nicolas Rodriguez

Application Symfony 8 pour présenter un portfolio développeur, avec une vitrine publique, un formulaire de contact et une interface d'administration sécurisée pour gérer le contenu.

Présentation

Ce projet permet de :

Afficher une page portfolio : hero, à propos, compétences, projets, contact.
Gérer dynamiquement les projets et le profil depuis un back-office admin.
Envoyer les messages du formulaire de contact via Symfony Mailer.
Stocker les données avec Doctrine, SQLite par défaut en local.
Stack principale
PHP 8.4
Symfony 8
Doctrine ORM + Migrations
Twig
Tailwind CSS
AssetMapper
SQLite par défaut
Symfony Mailer
Fonctionnalités
Côté public
Page d'accueil unique avec sections portfolio.
Affichage des projets actifs ordonnés.
Affichage du profil : texte, compétences, photo, CV.
Formulaire de contact serveur avec envoi d'email.
Côté administration
Authentification admin : /admin/login.
Tableau de bord admin.
CRUD projets : création, édition, suppression.
Statut projet actif/inactif : les projets inactifs sont masqués du site public.
Section "Projets inactifs" dans le dashboard avec action de réactivation en un clic.
Réordonnancement des projets.
Upload, suppression et réorganisation des images projets.
Edition du profil : à propos, compétences frontend/backend/outils.
Upload/remplacement photo de profil.
Upload/remplacement CV PDF.
Nettoyage automatique des anciens fichiers remplacés sur le disque.
Commande console pour mettre à jour les credentials admin : email + mot de passe.
Sécurité
Accès /admin réservé au rôle ROLE_ADMIN.
Protection CSRF sur la suppression des projets.
Protection CSRF sur la bascule actif/inactif des projets.
Authentification Symfony Security.
Installation locale
1) Prérequis
PHP 8.4+
Composer
Symfony CLI recommandé
Extension PHP SQLite activée
Extension PHP intl recommandée
2) Cloner le projet
git clone https://github.com/buzzer93/portfolio.git
cd portfolio
3) Installer les dépendances
composer install
4) Configurer l'environnement

Le projet fournit un .env de base.

Pour une configuration locale personnalisée :

cp .env .env.local

Variables utiles :

APP_ENV=dev
APP_DEBUG=1
DATABASE_URL="sqlite:///%kernel.project_dir%/var/data.db"
ADMIN_EMAIL="admin@example.com"
ADMIN_PASSWORD="Admin1234!"
MAILER_DSN=null://null
Base de données SQLite

Le projet utilise SQLite par défaut.

Avec SQLite, la commande suivante peut ne pas fonctionner selon la version de Doctrine DBAL :

php bin/console doctrine:database:create

SQLite fonctionne avec un simple fichier de base de données. Il faut donc créer le fichier manuellement si besoin :

mkdir -p var
touch var/data.db

Puis lancer les migrations :

php bin/console doctrine:migrations:migrate -n
Fixtures

Les fixtures permettent de charger :

un utilisateur admin ;
des projets de démonstration ;
un profil de démonstration.

Commande :

php bin/console doctrine:fixtures:load -n

Attention : cette commande vide les tables avant de recharger les données.

Pour ajouter les données sans vider la base :

php bin/console doctrine:fixtures:load --append -n

Si la commande doctrine:fixtures:load n'existe pas, installer le bundle :

composer require doctrine/doctrine-fixtures-bundle --dev

Puis relancer :

php bin/console doctrine:fixtures:load -n

En production, les fixtures ne sont généralement pas utilisées, car le bundle est installé en dépendance dev.

Assets Tailwind / AssetMapper

Après installation ou après un git pull, reconstruire les assets :

php bin/console tailwind:build

Pour la production :

APP_ENV=prod APP_DEBUG=0 php bin/console tailwind:build --minify
APP_ENV=prod APP_DEBUG=0 php bin/console asset-map:compile

Cette étape est importante : si les assets générés sont absents, le site peut être cassé visuellement, voire provoquer une erreur selon la configuration.

Lancer le serveur en local
symfony serve

Puis ouvrir :

Site public : http://127.0.0.1:8000
Admin : http://127.0.0.1:8000/admin/login
Lancer les tests
php bin/phpunit
Commandes utiles
Mettre à jour les credentials admin
php bin/console app:admin:update-credentials
Appliquer les migrations
php bin/console doctrine:migrations:migrate -n
Vider le cache
php bin/console cache:clear
Reconstruire Tailwind
php bin/console tailwind:build
Compiler les assets AssetMapper
php bin/console asset-map:compile
Déploiement production

Exemple de déploiement sur un VPS Ubuntu avec Caddy et PHP-FPM.

1) Se placer dans le projet
cd /opt/nicolas-rodriguez
2) Récupérer les dernières modifications
git pull

Si Git bloque à cause d'un fichier local non suivi, par exemple :

error: The following untracked working tree files would be overwritten by merge:
    assets/img/inventaire.png

Sauvegarder le fichier, puis le supprimer du projet avant de relancer le pull :

mkdir -p ~/backup-nicolas-rodriguez
cp assets/img/inventaire.png ~/backup-nicolas-rodriguez/inventaire.png
rm assets/img/inventaire.png
git pull
3) Installer les dépendances de production
composer install --no-dev --optimize-autoloader
4) Configurer .env.local

Créer ou modifier le fichier :

nano .env.local

Exemple :

APP_ENV=prod
APP_DEBUG=0
DATABASE_URL="sqlite:///%kernel.project_dir%/var/data.db"
MAILER_DSN="null://null"

En production réelle, remplacer MAILER_DSN par un vrai service d'envoi d'emails.

5) Initialiser SQLite
mkdir -p var
touch var/data.db
6) Régler les droits

Le serveur web doit pouvoir écrire dans var/, notamment pour le cache, les logs et la base SQLite.

sudo chown -R buzzer93:www-data var

sudo find var -type d -exec chmod 775 {} \;
sudo find var -type f -exec chmod 664 {} \;

sudo setfacl -R -m u:www-data:rwX -m u:buzzer93:rwX var
sudo setfacl -dR -m u:www-data:rwX -m u:buzzer93:rwX var
7) Appliquer les migrations
APP_ENV=prod APP_DEBUG=0 php bin/console doctrine:migrations:migrate --no-interaction
8) Compiler les assets
APP_ENV=prod APP_DEBUG=0 php bin/console tailwind:build --minify
APP_ENV=prod APP_DEBUG=0 php bin/console asset-map:compile
9) Vider le cache
APP_ENV=prod APP_DEBUG=0 php bin/console cache:clear
10) Redémarrer les services
sudo systemctl restart php8.4-fpm
sudo systemctl reload caddy
11) Tester
curl -I https://nicolas-rodriguez.fr

Réponse attendue :

HTTP/2 200
Configuration Caddy

Le fichier de configuration principal de Caddy se trouve généralement ici :

/etc/caddy/Caddyfile

L'ouvrir :

sudo nano /etc/caddy/Caddyfile

Exemple de configuration :

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

Attention : la directive correcte est :

file_server

et non :

file_servers

Vérifier la configuration :

sudo caddy validate --config /etc/caddy/Caddyfile

Formater le fichier :

sudo caddy fmt --overwrite /etc/caddy/Caddyfile

Recharger Caddy :

sudo systemctl reload caddy
Vérifier PHP-FPM

Vérifier les sockets disponibles :

ls /run/php/

Exemple attendu :

php8.4-fpm.sock

Si le socket est différent, adapter la ligne Caddy :

php_fastcgi unix//run/php/php8.4-fpm.sock

Vérifier le service :

sudo systemctl status php8.4-fpm

Voir les logs PHP-FPM :

sudo journalctl -u php8.4-fpm -n 80 --no-pager
Logs et diagnostic
Logs Symfony

En dev :

tail -n 80 var/log/dev.log

En prod :

tail -n 80 var/log/prod.log

Si prod.log n'existe pas, vérifier que l'application tourne bien en prod :

grep -E "APP_ENV|APP_DEBUG|DATABASE_URL" .env .env.local 2>/dev/null
Logs Caddy
sudo tail -n 80 /var/log/caddy/nicolas-rodriguez.log
Logs du service Caddy
sudo journalctl -u caddy -n 80 --no-pager
Erreur 500 en production

Une erreur HTTP/2 500 signifie généralement que Caddy fonctionne, mais que Symfony ou PHP rencontre une erreur.

Vérifications à faire :

tail -n 120 var/log/*.log
sudo journalctl -u php8.4-fpm -n 80 --no-pager
sudo tail -n 80 /var/log/caddy/nicolas-rodriguez.log

Causes fréquentes :

cache Symfony incorrect ;
permissions insuffisantes sur var/ ;
base SQLite non créée ;
migrations non appliquées ;
assets Tailwind ou AssetMapper non compilés ;
mauvais socket PHP-FPM dans Caddy ;
variable APP_ENV ou DATABASE_URL incorrecte.

Commandes de correction courantes :

cd /opt/nicolas-rodriguez

sudo chown -R buzzer93:www-data var

sudo find var -type d -exec chmod 775 {} \;
sudo find var -type f -exec chmod 664 {} \;

sudo setfacl -R -m u:www-data:rwX -m u:buzzer93:rwX var
sudo setfacl -dR -m u:www-data:rwX -m u:buzzer93:rwX var

APP_ENV=prod APP_DEBUG=0 php bin/console doctrine:migrations:migrate --no-interaction
APP_ENV=prod APP_DEBUG=0 php bin/console tailwind:build --minify
APP_ENV=prod APP_DEBUG=0 php bin/console asset-map:compile
APP_ENV=prod APP_DEBUG=0 php bin/console cache:clear

sudo systemctl restart php8.4-fpm
sudo systemctl reload caddy
Checklist après un git pull

Après chaque mise à jour du code en production :

cd /opt/nicolas-rodriguez

git pull

composer install --no-dev --optimize-autoloader

APP_ENV=prod APP_DEBUG=0 php bin/console doctrine:migrations:migrate --no-interaction

APP_ENV=prod APP_DEBUG=0 php bin/console tailwind:build --minify
APP_ENV=prod APP_DEBUG=0 php bin/console asset-map:compile

APP_ENV=prod APP_DEBUG=0 php bin/console cache:clear

sudo systemctl restart php8.4-fpm
sudo systemctl reload caddy
Structure des fichiers uploadés

Les fichiers publics sont stockés dans :

public/images

Les photos de profil sont stockées dans :

public/images/profile

Les CV sont stockés dans :

public/files

Quand un fichier est retiré depuis l'admin ou remplacé, il est supprimé physiquement du dossier correspondant.
