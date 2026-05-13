---
name: frontend-page
description: Build or improve Symfony frontend pages using Twig, Tailwind CSS, Stimulus, AssetMapper, and a provided design brief.
---

# Frontend Page

## Purpose

Use this skill when creating or improving a Symfony page UI.

## Inputs

When available, use:
- design brief;
- screenshots;
- existing layout;
- Tailwind conventions;
- brand colors;
- target users;
- page goal.

## Stack

Default preference:
- Twig;
- Tailwind CSS;
- Stimulus for reusable interactions;
- AssetMapper.

Do not introduce Bootstrap or jQuery unless the project already uses them.

## Implementation rules

- Keep markup readable.
- Extract repeated sections into partials/components.
- Use semantic HTML.
- Add basic accessibility.
- Keep responsive behavior clean.
- Avoid overcomplicated UI logic.

## Stimulus

Use Stimulus for:
- modals;
- dropdowns;
- dynamic forms;
- AJAX/fetch interactions;
- UI state;
- reusable behaviors.

## Design translation

Claude should translate design requirements into practical Symfony frontend code.

When a design brief exists, follow it instead of inventing a new style.

## Design files

Before creating or modifying UI, check if these files exist:

- `DESIGN.md`
- `.claude/design/design-brief.md`

Use `DESIGN.md` as the active design system.
Use `.claude/design/design-brief.md` for project-specific adjustments.

Do not inspect the full `.claude/_templates/design/` catalog unless the user asks to choose a design template.

## Output

Return:
1. Page structure
2. Components created
3. Responsive behavior
4. Stimulus behavior if any
5. Manual visual checks
