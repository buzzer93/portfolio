---
name: refactor-service
description: Refactor Symfony services, managers, handlers, controllers, or domain logic to improve readability, maintainability, testability, and architecture consistency.
---

# Refactor Service

## Purpose

Use this skill when refactoring existing Symfony/PHP logic.

## Before refactoring

Claude should:
- understand the current behavior;
- identify existing tests;
- inspect related classes;
- identify the selected architecture;
- avoid changing behavior unintentionally.

## Refactoring goals

Improve:
- readability;
- naming;
- method size;
- responsibility boundaries;
- testability;
- duplication;
- architecture consistency.

## What to avoid

Do not:
- introduce abstractions without need;
- create interfaces by default;
- split code into too many tiny classes;
- mix refactoring with unrelated feature changes;
- rewrite large areas without clear benefit.

## Good refactors

Examples:
- move business logic from controller to service;
- split a large method into named private methods;
- extract a calculator service;
- extract a handler for a clear use case;
- move query logic to repository;
- improve names to reflect business intent.

## Tests

Before finishing:
- keep existing tests passing;
- add tests if behavior was previously untested;
- update tests only when behavior intentionally changes.

## Output

Return:
1. Refactoring goal
2. Behavior preserved
3. Files changed
4. Tests added or updated
5. Remaining improvements if any
