#!/usr/bin/env bash
#
# Script de déploiement du portfolio sur lab.
#
# Idempotent : peut être relancé sans danger.
# À lancer manuellement en SSH sur le serveur :
#
#   cd /opt/nicolas-rodriguez && bash bin/deploy.sh
#
# Pré-requis sur le serveur : git, composer, php8.4, PHP-FPM (pool php8.4-portfolio).
# Pour le reload OPcache : ajouter dans sudoers (visudo) :
#   buzzer93 ALL=(ALL) NOPASSWD: /usr/bin/systemctl reload php8.4-fpm

set -euo pipefail

DEPLOY_PATH="${DEPLOY_PATH:-/opt/nicolas-rodriguez}"
DEPLOY_BRANCH="${DEPLOY_BRANCH:-master}"
PHP="php8.4"
CONSOLE="${PHP} bin/console"

echo "==> Deploying branch '${DEPLOY_BRANCH}' to ${DEPLOY_PATH}"
cd "${DEPLOY_PATH}"

# public/files/ contient des PDFs (CV, lettre) modifiés côté serveur via l'admin.
# Ils sont suivis par git : on les sauvegarde avant le pull pour les restaurer après.
BACKUP_DIR=""
if [ -d public/files ] && [ -n "$(ls -A public/files 2>/dev/null)" ]; then
    BACKUP_DIR="${HOME}/portfolio-files-backup-$(date +%Y%m%d-%H%M%S)"
    echo "==> Backing up public/files → ${BACKUP_DIR}"
    cp -r public/files "${BACKUP_DIR}"
fi

echo "==> Updating sources (fast-forward only)"
git fetch --prune origin
git checkout "${DEPLOY_BRANCH}"
git pull --ff-only origin "${DEPLOY_BRANCH}"

if [ -n "${BACKUP_DIR}" ] && [ -d "${BACKUP_DIR}" ]; then
    echo "==> Restoring public/files from backup"
    cp -r "${BACKUP_DIR}/." public/files/
fi

echo "==> Installing PHP dependencies (prod)"
${PHP} $(which composer) install --no-dev --optimize-autoloader --no-interaction --no-progress --no-scripts
${PHP} $(which composer) dump-autoload --no-dev --optimize --no-scripts

echo "==> Resetting prod cache (before any bin/console call)"
rm -rf var/cache/prod
${CONSOLE} cache:warmup --env=prod --no-debug

echo "==> Building front assets"
${CONSOLE} tailwind:build --minify
${CONSOLE} asset-map:compile

echo "==> Running database migrations"
${CONSOLE} doctrine:migrations:migrate --no-interaction

echo "==> Setting permissions (var/ writable by www-data)"
find var/ -type d -exec chmod 775 {} \;
find var/ -type f -exec chmod 664 {} \;

echo "==> Reloading PHP-FPM to clear OPcache"
sudo systemctl reload php8.4-fpm 2>/dev/null \
    || echo "    (skipped — ajouter une entrée sudoers si nécessaire)"

echo "==> Post-deploy checks"
${PHP} -r 'echo "PHP: ", PHP_VERSION, PHP_EOL;'
curl -fsS -o /dev/null -w "HTTP %{http_code}: %{url_effective}\n" https://nicolas-rodriguez.fr/ \
    || echo "    (curl check failed — vérifier manuellement)"

echo "==> Deploy finished successfully"
