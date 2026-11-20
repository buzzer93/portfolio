#!/usr/bin/env bash
#
# Script de déploiement du portfolio sur lab (FrankenPHP + Docker).
#
# Idempotent : peut être relancé sans danger.
# À lancer manuellement en SSH sur le serveur :
#
#   cd /opt/nicolas-rodriguez && bash bin/deploy.sh
#
# Pré-requis : docker (plugin compose), git.
# Variables de prod dans .env.local ou exportées avant l'appel :
#   SERVER_NAME, APP_SECRET, MAILER_*, ADMIN_EMAIL, ADMIN_PASSWORD
#
# Note : public/files/ (PDFs CV/lettre) n'est PAS un volume Docker.
# Tout fichier uploadé via l'admin dans public/files/ est perdu au prochain rebuild.
# → Committer les PDFs dans git ou ajouter un volume public_files dans docker-compose.yml.

set -euo pipefail

DEPLOY_PATH="${DEPLOY_PATH:-/opt/nicolas-rodriguez}"
DEPLOY_BRANCH="${DEPLOY_BRANCH:-master}"

echo "==> Deploying branch '${DEPLOY_BRANCH}' to ${DEPLOY_PATH}"
cd "${DEPLOY_PATH}"

if [ "${_DEPLOY_REEXEC:-0}" = "0" ]; then
    echo "==> Updating sources (fast-forward only)"
    git fetch --prune origin
    git checkout "${DEPLOY_BRANCH}"
    git pull --ff-only origin "${DEPLOY_BRANCH}"
    exec env _DEPLOY_REEXEC=1 bash "$0"
fi

echo "==> Building image with fresh base image (PHP 8.4.28+)"
docker compose build --pull

echo "==> Starting containers"
docker compose up -d --remove-orphans

echo "==> Post-deploy checks"
docker compose ps --format '{{.Name}}  {{.Status}}'
docker compose exec -T app php -r 'echo "PHP: ", PHP_VERSION, PHP_EOL;'
curl -fsS -o /dev/null -w "HTTP %{http_code}: %{url_effective}\n" https://nicolas-rodriguez.fr/ \
    || echo "    (curl check failed — vérifier manuellement)"

echo "==> Deploy finished successfully"
