---
name: init-project-context
description: Initialize or update the Claude project context for a Symfony project by asking useful questions and updating project-profile, architecture, stack, commands, and conventions.
disable-model-invocation: true
---

# Init Project Context

## Purpose

Use this skill when starting a new Symfony project or when the project context is outdated.

This skill should help update:
- `CLAUDE.md`;
- `.claude/project-profile.md`;
- `.claude/rules/architecture.md`;
- stack-specific notes;
- common commands;
- deployment notes when relevant.

## Behavior

Claude should not guess important project details when they are missing.

Claude should inspect the project first when possible:
- `composer.json`;
- `symfony.lock`;
- `package.json`;
- `importmap.php`;
- `assets/`;
- `src/`;
- `templates/`;
- `tests/`.

## Questions to ask

Ask only questions that are useful for the current project.

Important topics:
- project name and purpose;
- Symfony version;
- PHP version;
- database engine;
- frontend stack;
- CSS framework;
- API Platform usage;
- selected architecture;
- testing strategy;
- deployment target;
- sensitive features such as payment, auth, uploads, or admin.

## Architecture selection

Help the user choose one:
- classic Symfony;
- service/manager Symfony;
- DDD-light Symfony.

Once selected, update `.claude/rules/architecture.md` from the matching template.

## Output

When finished, provide:
- updated project summary;
- selected stack;
- selected architecture;
- missing decisions;
- next recommended setup steps.

Do not create personal preferences here.
Personal response style belongs in the user's local Claude configuration.
