---
paths:
  - "tests/**"
  - "src/**/*Test.php"
---

# Testing

## Main rule

Every meaningful business implementation should be tested.

## Test types

Prefer PHPUnit.
Use:
- unit tests for isolated business logic;
- functional tests for controllers, forms, security, and flows;
- integration tests when Doctrine or Symfony services are part of the behavior.

## When code changes

Claude should check whether tests need to be:
- added;
- updated;
- fixed;
- removed because they no longer match the behavior.

## What to test

Prioritize:
- business rules;
- pricing;
- booking or order flows;
- payment-related logic;
- security voters and access control;
- forms and validation;
- API resources and processors;
- commands;
- emails when behavior matters.

## Mocks

Mocks are allowed when useful.
Prefer real objects for simple domain logic.
Avoid excessive mocking that makes tests hard to understand.

## Projects without tests

If the project has no tests, Claude should propose adding tests for sensitive or important logic.
Do not create a large test architecture without asking.

## Commands

Use the test command defined in `.claude/project-profile.md`.
If missing, try:

```bash
php bin/phpunit
```
