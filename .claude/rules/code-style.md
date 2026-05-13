# Code Style

## General principles

- Write clear, explicit, maintainable code.
- Prefer readability over clever shortcuts.
- Follow the existing project style before introducing a new convention.
- Use meaningful names for classes, methods, variables, services, and templates.
- Avoid magic strings when an enum, constant, or configuration value would be clearer.

## PHP

- Follow PSR-12.
- Use `declare(strict_types=1);` in PHP files when the project already follows this convention.
- Add explicit parameter types and return types whenever possible.
- Prefer constructor property promotion for simple service dependencies.
- Avoid nullable types unless the domain really allows `null`.
- Avoid `mixed` unless there is no better option.

## Naming

- Classes: `PascalCase`.
- Methods and variables: `camelCase`.
- Constants: `UPPER_SNAKE_CASE`.
- Booleans should be named clearly, for example `isActive`, `hasAccess`, `canEdit`.
- Method names should describe intent, not implementation details.

## Comments

- Do not add obvious comments.
- Comment only when explaining business intent, non-obvious tradeoffs, or external constraints.
- If a method needs a long comment to be understood, consider refactoring it into smaller, clearer methods.

## Forbidden in final code

- No `var_dump`, `dump`, `dd`, `die`, `exit`.
- No temporary debug code.
- No commented-out dead code.
- No unused imports, unused variables, or unused services.
- No dependency added without a clear reason.
