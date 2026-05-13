# Quality

## Goal

Every change should improve or preserve:
- readability;
- maintainability;
- architecture consistency;
- testability;
- security;
- performance when relevant.

## Before editing

- Understand the existing implementation before changing it.
- Search for similar patterns in the project.
- Reuse existing conventions when they are clean and consistent.
- If the existing code is inconsistent, prefer the simplest improvement that does not create a large refactor.

## During implementation

- Keep changes focused on the requested task.
- Avoid mixing feature work, refactoring, formatting, and unrelated fixes in the same change.
- Prefer small, understandable functions.
- Prefer explicit business names over generic names like `handle`, `process`, or `manage` when possible.
- Avoid hiding important behavior behind overly generic abstractions.

## After implementation

Claude should review its own changes and check:
- Is the code easy to read?
- Is the business logic in the right place?
- Are tests needed or updated?
- Are there security implications?
- Are there possible regressions?
- Does this follow the selected architecture?

## Completion criteria

A task is not complete if:
- the code is untested when business logic changed;
- there are obvious edge cases ignored;
- the implementation duplicates existing logic unnecessarily;
- security-sensitive code was changed without explanation;
- the code would likely fail GrumPHP or project quality checks.
