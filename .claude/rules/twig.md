---
paths:
  - "templates/**"
---

# Twig

## Purpose

Twig templates should focus on presentation.

They may contain:
- simple conditions;
- simple loops;
- formatting;
- includes;
- components;
- blocks.

They should not contain business logic.

## Template structure

- Keep templates readable and reasonably short.
- Extract reusable parts into partials or components.
- Use partial names starting with `_` when appropriate.
- Avoid deeply nested conditions.
- Avoid duplicating large HTML blocks.

## Variables

- Use clear variable names.
- Do not rely on unclear array structures if a DTO, view model, or object would be clearer.
- Avoid passing entire entities to templates when only a few fields are needed and exposure is sensitive.

## Components

Use Twig components or partials for reusable UI:
- cards;
- forms;
- navigation items;
- product blocks;
- status badges;
- modals.

## Security

- Rely on Twig auto-escaping.
- Do not use `|raw` unless strictly necessary and safe.
- Never render user-generated HTML without sanitization.
- Check authorization before showing sensitive actions.

## Forms

- Use Symfony form helpers when using Symfony Forms.
- Keep custom form rendering consistent with the project UI.
