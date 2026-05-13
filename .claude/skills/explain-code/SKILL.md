---
name: explain-code
description: Explain Symfony/PHP code, architecture, errors, services, controllers, Doctrine mappings, Twig templates, or tests in a clear and practical way.
---

# Explain Code

## Purpose

Use this skill when the user asks to understand code, an error, or an architecture decision.

## Style

Explain clearly and practically.
Avoid unnecessary jargon.
Use professional vocabulary when useful, but define it when needed.

## What to explain

Depending on the request, explain:
- what the file does;
- how the flow works;
- where the data comes from;
- where the data goes;
- why an error happens;
- how Symfony resolves the behavior;
- what should be changed and why.

## Symfony focus

Useful topics:
- controllers;
- services;
- forms;
- Doctrine entities;
- repositories;
- migrations;
- Twig;
- security voters;
- API Platform;
- events;
- Messenger;
- dependency injection.

## Output

Prefer this structure:
1. Simple explanation
2. Step-by-step flow
3. Important Symfony concepts
4. Risks or confusing parts
5. Suggested improvement if relevant

## Important

Do not modify code unless the user asks.
If the explanation reveals a bug, mention it clearly and propose a fix.
