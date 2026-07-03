#!/bin/sh
set -e

# Ensure writable directories exist
mkdir -p /app/var/cache /app/var/log /app/var/share /app/public/images

if [ "$APP_ENV" = "prod" ]; then
    php /app/bin/console cache:warmup
fi

php /app/bin/console doctrine:migrations:migrate --no-interaction --allow-no-migration

exec "$@"
