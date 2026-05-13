---
name: codebase-onboarding
description: Analyze an unknown or unfamiliar Symfony codebase and produce a readable map of its architecture. Use when joining a project, auditing inherited code, or before a major refactor.
user-invocable: true
---

Produce a structured analysis of this codebase for a developer joining the project.

Analyze:
1. `composer.json` — PHP version, Symfony version, key dependencies.
2. `src/` structure — identify main domains, bundles, layers present.
3. Controllers — how many, how thin, what patterns (CRUD, invokable, REST)?
4. Services and handlers — how is business logic organized?
5. Entities — main domain objects, key relations, notable patterns.
6. Repositories — custom queries present? N+1 risks visible?
7. Templates — Twig structure, reusable components present?
8. Tests — test coverage present? What type (unit, functional, integration)?
9. Config — notable security, routing, or service configuration.
10. Migrations — how many, recent changes, destructive operations present?

Output:
- Architecture summary (which pattern: classic-symfony / service-manager / ddd-light)
- Main entry points (key controllers or commands)
- Sensitive areas requiring care
- Apparent tech debt or inconsistencies
- Suggested first steps before making changes

Do not modify any file. This skill is read-only.
