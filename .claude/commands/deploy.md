---
name: deploy
argument-hint: [install|update]
description: Generate a Symfony deployment checklist from the project profile
---

## Project deployment profile

!`cat .claude/project-profile.md`

---

Prepare a Symfony deployment checklist for this project.

Mode: $ARGUMENTS (use "install" for initial setup, "update" for a production update)

Based on the profile above:
1. If mode is "install": generate a full initial installation checklist (clone, composer, .env, database, migrations, cache, Caddy, permissions).
2. If mode is "update": generate an update checklist (git pull, composer install, frontend build if needed, migrations, cache clear, permissions, reload check).
3. Use placeholders for all secrets and passwords.
4. Include a verification command after each critical step.

Rules:
- Never include real credentials or tokens.
- Never suggest `chmod -R 777`.
- Flag any migration step as requiring manual review before execution.
- Do not execute anything on the server directly.
