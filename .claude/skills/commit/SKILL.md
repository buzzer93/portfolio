---
name: commit
description: Stage, GrumPHP-check, fix, and commit changes in small logical units with conventional commit messages.
user-invocable: true
---

Commit the current changes in small, clean logical units.

## Steps

1. Run `git status` and `git diff` to understand what changed.
2. Group changes into the smallest logical unit (one feature, one fix, one refactor — never mix).
3. Stage only the files for this unit: `git add [specific files]`.
4. Run GrumPHP: `vendor/bin/grumphp run` (or `vendor/bin/grumphp run --files [files]` if available).
5. If GrumPHP fails:
   - Read each error carefully.
   - Fix the issue (CS fixer, PHPStan, dump statements, unused imports, etc.).
   - Re-stage the fixed files.
   - Re-run GrumPHP until it passes.
6. Write a conventional commit message: `type(scope): short description` (max 72 chars).
   - `feat` — new feature
   - `fix` — bug fix
   - `refactor` — code change with no behavior change
   - `test` — adding or updating tests
   - `chore` — config, dependencies, tooling
   - `docs` — documentation only
7. Commit: `git commit -m "type: description"`.
8. If more changes remain, repeat from step 2 for the next logical unit.

## Rules

- Never use `git add .` or `git add -A` — always stage specific files by name.
- Never skip GrumPHP.
- Never commit `var_dump`, `dd`, `dump`, `die`, or `exit`.
- Never mix a feature and a bug fix in the same commit.
- Do not push — that is a separate, deliberate action.
