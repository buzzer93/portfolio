---
name: fill-todos
description: Inspect the Symfony project to auto-fill all TODO placeholders in project-profile.md. Auto-detects PHP version, Symfony version, database, frontend stack, and architecture from the codebase, then asks the user only for what cannot be inferred.
user-invocable: true
---

# Fill TODOs

## Purpose

Replace every `TODO` in `.claude/project-profile.md` by combining automated codebase inspection with targeted user questions.

Auto-fill what can be detected. Ask only for what cannot.

---

## Step 1 — Inspect the project

Read and extract information from:

| File | What to extract |
|---|---|
| `composer.json` | PHP constraint, Symfony version, installed packages |
| `composer.lock` | Exact installed versions when `composer.json` uses `^` ranges |
| `config/bundles.php` | Installed Symfony bundles |
| `.env` | DATABASE_URL pattern, MAILER_DSN, other env hints (never `.env.local` or `.env.prod`) |
| `importmap.php` | Confirms AssetMapper usage |
| `webpack.config.js` | Confirms Webpack Encore usage |
| `package.json` | Frontend deps: Tailwind, Bootstrap, Stimulus, etc. |
| `src/` directory listing | Architecture pattern detection |
| `git remote get-url origin` | Repository URL |

### PHP version

From `composer.json → require.php`. Clean to the minor version (e.g., `8.3`).

### Symfony version

From `composer.json → require.symfony/framework-bundle`. Clean to minor (e.g., `7.2`).
Fall back to `composer.lock` if the constraint is too broad.

### Database

From `composer.json`:
- `doctrine/dbal` → SQL database
- `doctrine/mongodb-odm-bundle` → MongoDB

Confirm the engine (MySQL / MariaDB / PostgreSQL / SQLite) from `.env → DATABASE_URL` driver prefix:
- `mysql://` → MySQL or MariaDB
- `postgresql://` → PostgreSQL
- `sqlite://` → SQLite

### Frontend

- `importmap.php` exists → Stimulus / AssetMapper
- `webpack.config.js` exists → Webpack Encore
- `package.json` → check for `@hotwired/stimulus`, `@symfony/stimulus-bridge`

### CSS framework

From `package.json` devDependencies / dependencies:
- `tailwindcss` → Tailwind CSS
- `bootstrap` → Bootstrap
- Nothing → plain CSS or unknown

### Asset handling

- `importmap.php` → AssetMapper
- `webpack.config.js` → Webpack Encore
- Neither → note as unknown

### API Platform

`api-platform/core` in `composer.json` → yes. Otherwise → no.

### Tests

`phpunit/phpunit` or `symfony/test-pack` in `composer.json` → PHPUnit.

### Repository URL

Run: `git remote get-url origin`

### Architecture detection

Inspect `src/` directory names:

- **ddd-light** — any of: `Domain/`, `Application/`, `Infrastructure/`, or dirs named `Command/` + `Handler/` at a top level
- **service-manager** — presence of `Manager/` directory, no Domain/ structure
- **classic-symfony** — default when neither above applies

### Sensitive features detection

| Feature | Signal |
|---|---|
| payment | `stripe` anywhere in `composer.json`, or `src/Payment/`, `src/Stripe/` |
| authentication | `symfony/security-bundle` in `composer.json` |
| authorization/voters | `src/Security/Voter/` directory exists |
| admin area | `easycorp/easyadmin-bundle` or `sonata-project/admin-bundle` in `composer.json`, or `src/Admin/` |
| file uploads | `vich/uploader-bundle` in `composer.json`, or `src/Upload/` |
| emails | `symfony/mailer` or `symfony/swiftmailer-bundle` in `composer.json` |
| API | `api-platform/core`, or REST controllers under `src/Api/`, `src/Controller/Api/` |

---

## Step 2 — Show what was detected

Display a clear summary table:

```
Auto-detected:
  PHP version:       8.3
  Symfony version:   7.2
  Database:          MariaDB (mysql:// in .env)
  CSS framework:     Tailwind CSS
  Asset handling:    AssetMapper
  API Platform:      no
  Tests:             PHPUnit
  Repository:        git@github.com:...
  Architecture:      classic-symfony (inferred)
  Authentication:    yes (symfony/security-bundle)
  Emails:            yes (symfony/mailer)

Still unknown (need your input):
  Project name, Project type, Main domain, Main users,
  Main features, Deployment details, Database DSN pattern
```

---

## Step 3 — Ask only for what is missing

Ask only the fields that could not be auto-detected. Group questions logically.

**Project identity** (if any are TODO):
- What is the project name?
- What type of project is it? (SaaS / e-commerce / intranet / API / mobile backend / other)
- In one sentence, what does the project do? (main domain)
- Who are the main users? (internal team / customers / admins / API clients)

**Main features** (if TODO):
- What are the 3–5 most important features of this project?

**Architecture** (if detection was ambiguous):
- Show the three options (classic-symfony / service-manager / ddd-light) with a one-line description each, and ask which applies.

**Deployment** (if all deployment fields are TODO, ask as a group):
- Deployment target (VPS / Platform.sh / Heroku / other)?
- Web server (Caddy / Nginx / Apache)?
- PHP runtime (PHP-FPM / FrankenPHP)?
- Project path on server (e.g., `/var/www/myproject`)?
- Production domain (e.g., `myproject.com`)?
- PHP-FPM socket path (e.g., `/run/php/php8.3-fpm.sock`)?
- Deployment branch (`main` / `master` / other)?

**Database** (if TODO):
- Local database DSN pattern (engine + host, no credentials)?
- Production database (same engine or different)?

Do not re-ask fields already detected.

---

## Step 4 — Write the updated file

Once all answers are collected, update `.claude/project-profile.md`:

- Replace each `TODO` with the correct value.
- Keep the existing file structure intact.
- Do not remove or rewrite sections that are already filled.
- If a value was not detected and the user did not provide it, leave `TODO` as-is.
- For sensitive features, replace `yes/no` placeholders with the detected or confirmed value.

---

## Step 5 — Report the result

After writing:

1. Confirm which fields were updated.
2. List any fields still `TODO` with a short note on what info is needed to fill them.
3. If deployment details are complete, mention the `deploy` skill as the next step.

---

## Constraints

- Never read `.env.local`, `.env.prod`, `secrets/**`, or private key files.
- Do not invent values — only write what was detected or explicitly confirmed by the user.
- Do not update `.claude/design/design-brief.md` — those TODOs are page-specific and must be filled before each individual design task.
- Do not commit changes — leave that to the user or the `commit` skill.
