---
name: symfony-debug
description: Debug Symfony, Doctrine, Twig, AssetMapper, API Platform, forms, services, controllers, PHP errors, and runtime issues.
---

# Symfony Debug

## Purpose

Use this skill when investigating a Symfony or PHP error.

## First steps

Before proposing a fix:
- read the full error message;
- identify the failing file and line;
- inspect related classes;
- check configuration if relevant;
- search for similar patterns in the project.

## Useful checks

Depending on the issue, inspect:
- `composer.json`;
- `.env`;
- `config/`;
- `src/Controller/`;
- `src/Entity/`;
- `src/Repository/`;
- `src/Form/`;
- `src/Service/`;
- `templates/`;
- `migrations/`.

## Common Symfony areas

Check:
- service autowiring;
- route names;
- form field mapping;
- Doctrine relations;
- entity metadata;
- migration status;
- Twig variable names;
- security access control;
- AssetMapper paths;
- API Platform resources.

## Debugging rules

- Do not guess when the project can be inspected.
- Prefer the smallest reliable fix.
- Explain the root cause clearly.
- Avoid hiding the real issue with defensive code.
- If the issue comes from config, fix config instead of adding workaround code.

## Output

Provide:
1. likely cause;
2. evidence found in the code;
3. proposed fix;
4. files to modify;
5. command to verify the fix.
