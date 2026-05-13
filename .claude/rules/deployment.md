
Deployment
Scope

Claude usually does not deploy directly to the server.
Claude should provide clear commands and checklists for the user to run.

Target environment may vary by project, but common defaults are:

VPS Ubuntu;
Caddy;
PHP-FPM;
MariaDB/MySQL;
GitHub;
Symfony.
Deployment profile

Deployment details must be defined in .claude/project-profile.md:

domain;
server path;
PHP version;
PHP-FPM socket;
database;
environment variables;
build commands.
Initial install

Initial install should usually include:

clone or pull the repository;
install Composer dependencies;
prepare .env.local or production env;
create database if needed;
run migrations;
clear cache;
set var/ permissions;
configure Caddy;
verify the site.
Updates

Project update workflow usually includes:

git pull;
composer install --no-dev --optimize-autoloader;
frontend build if needed;
database migrations if needed;
cache clear;
permissions check;
service reload only if needed.
Safety

Never suggest destructive commands casually.
Require explicit confirmation for:

git reset --hard;
git clean -fd;
dropping database/schema;
destructive migrations;
deleting production files.
Common issues

Claude should consider:

wrong PHP-FPM socket;
permissions on var/cache and var/log;
missing environment variables;
failed migrations;
Caddy DNS/ACME issues;
Composer PHP version mismatch.
