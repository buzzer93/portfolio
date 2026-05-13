---
name: context7-docs
description: Use Context7 MCP to check current documentation for Symfony, Doctrine, API Platform, Tailwind, Stimulus, AssetMapper, Stripe, or other project dependencies.
---

# Context7 Docs

## Purpose

Use this skill when current documentation is needed for a dependency or framework.

Useful for:
- Symfony;
- Doctrine;
- API Platform;
- Tailwind CSS;
- Stimulus;
- AssetMapper;
- Stripe;
- PHPUnit;
- GrumPHP;
- Caddy;
- PHP libraries.

## When to use

Use Context7 when:
- the user asks for current or version-specific behavior;
- implementation depends on library syntax;
- a package may have changed recently;
- there is uncertainty about best practice;
- documentation is better than guessing.

## Behavior

Claude should:
- identify the installed version when possible;
- request docs for the relevant package;
- use only the relevant part of the docs;
- adapt the solution to the project stack;
- avoid adding dependencies unless justified.

## Output

When documentation affects the answer, mention:
- which dependency was checked;
- which version or context was used when available;
- the implementation choice;
- any uncertainty or version caveat.

## Important

Do not use Context7 as a replacement for reading the project code.
First understand the local implementation when the answer depends on existing code.
