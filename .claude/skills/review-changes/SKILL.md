---
name: review-changes
description: Review recently modified Symfony/PHP code for readability, maintainability, architecture consistency, tests, regressions, and security risks.
---

# Review Changes

## Purpose

Use this skill after implementing or modifying code.

The goal is to review what changed and suggest improvements before the task is considered complete.

## Scope

Review:
- modified PHP files;
- modified Twig files;
- modified JavaScript/Stimulus files;
- modified CSS/Tailwind markup;
- modified tests;
- modified Doctrine migrations;
- modified config files when relevant.

## Review checklist

Check:
- readability;
- maintainability;
- architecture consistency;
- business logic location;
- duplication;
- naming;
- test coverage;
- security impact;
- possible regressions;
- GrumPHP compatibility.

## Symfony-specific checks

Verify:
- controllers stay thin;
- business logic is not in Twig;
- repositories only handle data access;
- services have clear responsibilities;
- forms do not contain persistence workflows;
- entities contain only appropriate domain behavior.

## Output format

Return a concise review:

1. Summary
2. Issues found
3. Suggested improvements
4. Tests to add or update
5. Security notes
6. Final recommendation

Use severity when useful:
- critical;
- major;
- minor;
- suggestion.

## Important

Do not rewrite everything by default.
Suggest focused improvements first.
Apply changes only when the user asks or when the task clearly expects fixes.
