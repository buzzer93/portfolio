---
name: implement-feature
description: Implement a Symfony feature while respecting project architecture, tests, security, Doctrine, Twig, and frontend conventions.
---

# Implement Feature

## Purpose

Use this skill when adding a new feature to a Symfony project.

## Before coding

Claude should:
- understand the requested behavior;
- inspect existing similar features;
- identify the selected architecture;
- identify affected layers;
- check if tests already exist;
- check security impact.

## Implementation principles

- Keep the change focused.
- Respect the selected architecture.
- Keep controllers thin.
- Put business logic in the right service, handler, or entity method.
- Avoid unnecessary abstractions.
- Prefer Symfony native features.
- Add dependencies only with a clear reason.

## Typical flow

For a backend feature:
1. identify domain behavior;
2. update entity/value object if needed;
3. update service/handler if needed;
4. update controller/form/API layer;
5. update Twig/frontend if needed;
6. add or update tests;
7. review changes.

## Sensitive features

For these areas, explain the plan before editing:
- payment;
- authentication;
- authorization;
- admin access;
- uploads;
- migrations;
- deployment.

## Tests

Every meaningful business implementation should have tests.

Prefer:
- unit tests for business rules;
- functional tests for HTTP flows;
- integration tests when Doctrine/Symfony services matter.

## Completion

Before finishing:
- run or suggest tests;
- run or suggest GrumPHP checks;
- review changed code;
- mention any remaining risk or manual verification.
