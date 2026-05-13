---
name: deploy-vps
description: Prepare a Symfony deployment checklist for a VPS (Ubuntu, Caddy, PHP-FPM, MariaDB). Use for initial installation or production updates. Project values come from .claude/project-profile.md.
disable-model-invocation: true
---

# Deploy VPS

## Purpose

Prepare safe deployment commands for the user to run.
Claude does not deploy directly. Claude produces a checklist.

Project-specific values come from `.claude/project-profile.md`.

## Mode: install (first deployment)

Steps:
1. Create project directory on server.
2. Configure GitHub deploy key if needed.
3. Clone repository.
4. `composer install --no-dev --optimize-autoloader`
5. Prepare `.env.local` with production values.
6. Create database and user.
7. `php bin/console doctrine:migrations:migrate --no-interaction --env=prod`
8. Build frontend assets if needed (`npm ci && npm run build`).
9. Set `var/` permissions safely.
10. Configure Caddy virtual host.
11. Reload services.
12. Verify the site responds correctly.

## Mode: update (existing deployment)

Steps:
1. `git status` — confirm no local changes.
2. `git pull`
3. `composer install --no-dev --optimize-autoloader`
4. Build frontend assets if needed.
5. `php bin/console doctrine:migrations:status --env=prod`
6. `php bin/console doctrine:migrations:migrate --no-interaction --env=prod` if needed.
7. `php bin/console cache:clear --env=prod`
8. Check `var/` permissions.
9. Reload services only if configuration changed.
10. Verify the site.

## Safety

Never include real secrets. Use placeholders for passwords and tokens.
Do not suggest `chmod -R 777`.
Flag migrations with destructive changes before including them in the checklist.
Warn about: Git conflicts, PHP version mismatch, missing env variables, modified `.env.local`.

## Output

Return:
- mode used (install / update);
- commands grouped by step;
- values to replace (placeholders);
- verification commands;
- risks and common failure points.
