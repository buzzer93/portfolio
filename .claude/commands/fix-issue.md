---
name: fix-issue
argument-hint: [issue-number]
description: Investigate and fix a GitHub issue
---

## Issue #$ARGUMENTS

!`gh issue view $ARGUMENTS`

## Current branch status

!`git status`

Read the issue above, then:
1. Find the relevant source files (controllers, services, entities, templates).
2. Implement the minimal fix that solves the reported problem.
3. Write or update a test that covers the fixed behavior.
4. Run the test suite (command defined in `.claude/project-profile.md`, fallback: `php bin/phpunit`) and verify all tests pass.
5. Propose a commit message: `fix: [short description] (closes #$ARGUMENTS)`.

Rules:
- Do not fix more than what the issue describes.
- Do not refactor unrelated code.
- Explain the root cause before changing anything.
- If the fix touches a sensitive area (auth, payment, migration), explain the plan first.
