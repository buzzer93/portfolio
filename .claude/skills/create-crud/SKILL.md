---
name: create-crud
description: Create or improve a Symfony CRUD with controller, entity, repository, form, Twig templates, validation, security checks, and tests.
---

# Create CRUD

## Purpose

Use this skill when creating or improving a Symfony CRUD.

## Before implementation

Check:
- selected architecture;
- existing CRUD patterns;
- entity conventions;
- form conventions;
- Twig layout;
- security requirements;
- tests structure.

## CRUD components

A typical CRUD may include:
- entity;
- repository;
- form type;
- controller;
- Twig templates;
- validation constraints;
- access control;
- tests;
- fixtures if useful.

## Controller rules

Controllers should stay thin.
For simple CRUD, direct form handling and persistence may be acceptable.
For complex workflows, move logic to services or handlers.

## Templates

Templates should:
- follow existing layout;
- use reusable partials/components;
- avoid business logic;
- use consistent Tailwind or project UI conventions.

## Security

Check:
- who can list;
- who can view;
- who can create;
- who can edit;
- who can delete;
- object ownership when relevant;
- CSRF on destructive actions.

## Tests

Add or update:
- functional tests for main flows;
- form validation tests if important;
- security tests for restricted actions.

## Output

Return:
- generated files;
- behavior implemented;
- security decisions;
- tests added;
- manual verification steps.
