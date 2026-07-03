FROM dunglas/frankenphp:php8.4-alpine

# Composer must be run as root in Docker
ENV COMPOSER_ALLOW_SUPERUSER=1

# System deps needed by Composer and PHP extensions
RUN apk add --no-cache git unzip

# Install required PHP extensions
RUN install-php-extensions \
    pdo_sqlite \
    intl \
    zip \
    opcache \
    apcu

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app

# Install PHP dependencies (separate layer for caching)
COPY composer.json composer.lock symfony.lock ./
RUN composer install --no-dev --optimize-autoloader --no-scripts --no-interaction

# Copy application source
COPY . .

# Finalise Composer (scripts, dump-autoload)
RUN composer dump-env prod \
    && composer run-script post-install-cmd --no-dev

# Build frontend assets
RUN php bin/console tailwind:build --minify \
    && php bin/console asset-map:compile

# Custom PHP settings (upload limits, etc.)
COPY php.ini $PHP_INI_DIR/conf.d/app.ini

# FrankenPHP / Caddy config
COPY docker/Caddyfile /etc/caddy/Caddyfile

# Startup script
COPY docker/entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

# Ensure runtime directories exist and are writable
RUN mkdir -p var/cache var/log var/share public/images \
    && chown -R www-data:www-data var/ public/images/

ENTRYPOINT ["/entrypoint.sh"]
CMD ["frankenphp", "run", "--config", "/etc/caddy/Caddyfile"]
