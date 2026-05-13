---
name: twig-component
description: Create or refactor Twig partials or components for reusable Symfony UI elements while keeping templates readable and presentation-focused.
---

# Twig Component

## Purpose

Use this skill when creating or refactoring reusable Twig UI.

## Good use cases

Create a component or partial for:
- cards;
- buttons;
- badges;
- alerts;
- modals;
- product blocks;
- form rows;
- navigation items;
- repeated layout sections.

## Before implementation

Check:
- existing template conventions;
- existing components/partials;
- Tailwind or CSS conventions;
- variables already available;
- accessibility needs.

## Rules

Twig should focus on presentation.
Avoid business logic in templates.

Use clear variable names.
Avoid passing large unclear arrays when a view model or explicit variables would be clearer.

## Tailwind

Keep class usage consistent.
Extract repeated markup when class strings become duplicated or hard to read.

## Security

Avoid `|raw`.
Do not render user-generated HTML unless sanitized.

## Output

Return:
- component or partial created;
- expected variables;
- example usage;
- accessibility notes;
- security notes when relevant.
