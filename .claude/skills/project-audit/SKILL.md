---
name: project-audit
description: Audit an existing Symfony project for code quality, architecture consistency, test gaps, security concerns, and deployment readiness. Use for ongoing review, not initial context setup.
disable-model-invocation: true
---

# Project Audit

## Purpose

Use this skill to perform a broad project review.

This is for analysis, not immediate rewriting.

## Inspect

When possible, inspect:
- `composer.json`;
- `symfony.lock`;
- `package.json`;
- `importmap.php`;
- `config/`;
- `src/`;
- `templates/`;
- `assets/`;
- `migrations/`;
- `tests/`;
- `.claude/project-profile.md`.

## Audit areas

Review:
- stack consistency;
- architecture consistency;
- controller thickness;
- service responsibilities;
- Doctrine mappings;
- migrations;
- Twig structure;
- frontend organization;
- tests;
- security;
- deployment readiness;
- GrumPHP or quality tools.

## Output format

Return a concise audit:

1. Project summary
2. Strong points
3. Main risks
4. Architecture issues
5. Test gaps
6. Security concerns
7. Deployment concerns
8. Recommended next actions

## Severity

Use severity labels:
- critical;
- major;
- minor;
- suggestion.

## Important

Do not propose a full rewrite by default.
Prioritize changes that bring real value with limited risk.
