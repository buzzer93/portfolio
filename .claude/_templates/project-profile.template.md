# Project Profile

## Project identity

Project name: TODO
Project type: TODO
Main domain: TODO
Repository: TODO
Main users: TODO

## Stack

PHP version: TODO
Symfony version: TODO
Database: TODO
Frontend: TODO
CSS framework: TODO
Asset handling: TODO
API Platform: yes/no
Tests: TODO

## Architecture

Selected architecture: TODO

Possible values:
- classic-symfony
- service-manager
- ddd-light

Architecture notes:
- TODO

## Main features

Important features:
- TODO

Sensitive features:
- payment: yes/no
- authentication: yes/no
- authorization/voters: yes/no
- admin area: yes/no
- file uploads: yes/no
- API: yes/no
- emails: yes/no

## Main conventions

- Use Symfony native features first.
- Use Tailwind for new UI unless the project already uses another framework.
- Use Stimulus for reusable frontend interactions.
- Use DTOs when they improve clarity, especially for complex forms, API inputs, or use cases.
- Avoid creating interfaces unless there are at least three implementations or a strong decoupling need.
- Keep controllers thin.
- Keep Twig focused on presentation.
- Test meaningful business logic.

## Local commands

Install dependencies:

```bash
composer install
```
Run tests:
```bash
php bin/phpunit
```
Run quality checks:
```bash
vendor/bin/grumphp run
```
Build frontend assets:
```bash
npm run build
```
Database

Local database: TODO
Production database: TODO

Migration policy:

never edit an old migration that has already been executed;
always create a new migration;
use Symfony Maker or Doctrine tooling to generate migrations;
check foreign keys before applying migrations;
avoid destructive migrations without explicit confirmation.
Deployment

Deployment target: TODO
Web server: TODO
PHP runtime: TODO
Database: TODO

Project path: TODO
Production domain: TODO
PHP-FPM socket: TODO
Deployment branch: TODO

Security notes

Claude may read .env when it is used as a template.

Claude must not read:

.env.local
.env.prod
secrets/**
private keys
production dumps

Sensitive changes require a plan before code edits:

payment;
authentication;
authorization;
admin access;
file uploads;
migrations;
deployment.
