---
name: test-implementation
description: Add or update PHPUnit unit, functional, or integration tests for Symfony business logic, controllers, forms, security, Doctrine, or API Platform behavior.
---

# Test Implementation

## Purpose

Use this skill when tests are needed after code changes or when implementing a new tested behavior.

## Test strategy

Choose the simplest useful test type:
- unit test for isolated business logic;
- functional test for controller or HTTP flow;
- integration test when Doctrine or Symfony services are involved.

## Priorities

Prioritize tests for:
- business rules;
- pricing;
- orders;
- bookings;
- payments;
- security voters;
- access control;
- forms;
- validators;
- API Platform resources;
- commands;
- emails when behavior matters.

## Test style

Tests should be:
- readable;
- explicit;
- focused;
- complete enough to prevent regressions.

Avoid tests that only check implementation details.

## Fixtures and data

Use realistic test data.
Keep test setup understandable.
Use fixtures or factories only when they reduce duplication.

## Mocks

Mocks are allowed when useful.
Prefer real objects for simple domain behavior.
Avoid excessive mocking.

## Verification

Use the test command from `.claude/project-profile.md`.

If no command is defined, suggest:

```bash
php bin/phpunit
```

## Output

When adding tests, explain:
- what behavior is covered;
- what edge cases are covered;
- how to run the tests;
- any remaining untested risk.
