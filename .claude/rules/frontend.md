---
paths:
  - "templates/**"
  - "assets/**"
---

# Frontend

## Default stack

Prefer the frontend stack defined in `.claude/project-profile.md`.

For new projects, prefer:
- Tailwind CSS;
- Twig;
- Stimulus for reusable interactions;
- AssetMapper when used by the project.

## Tailwind

- Prefer utility classes when they keep the markup readable.
- Extract repeated UI patterns into Twig components or partials.
- Avoid huge unreadable class strings when a component would be clearer.
- Keep spacing, typography, border radius, and states consistent.

## Stimulus

Use Stimulus for:
- reusable interactions;
- dynamic forms;
- modals;
- dropdowns;
- AJAX/fetch interactions;
- UI state.

Avoid inline JavaScript in Twig except for very small, justified cases.

## AJAX / fetch

AJAX is allowed when it improves UX.
Keep it organized:
- use Stimulus controllers for reusable behavior;
- handle loading and error states;
- avoid duplicating backend validation in JavaScript;
- keep routes and responses predictable.

## Design

If a design brief exists, follow it.
Claude should translate design requirements into clean Twig/Tailwind/Stimulus code.
Do not invent a heavy design system unless requested.

## Compatibility

Do not introduce Bootstrap, jQuery, or another UI framework unless the project already uses it or the project profile requests it.
