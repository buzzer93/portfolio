---
name: review-pr
description: Review the current branch diff for issues before merging
---

## Commits on this branch

!`git log main...HEAD --oneline`

## Files changed

!`git diff --name-only main...HEAD`

## Full diff

!`git diff main...HEAD`

Review the above changes before merge.

Check for:
- readability and naming;
- architecture consistency (controllers thin, services focused, repos for data access only);
- missing or broken tests;
- security issues (CSRF, XSS, auth, object ownership checks);
- regressions on existing behavior;
- Doctrine migrations safety (no destructive changes, no edited old migrations).

Apply rules from `.claude/rules/code-style.md`, `.claude/rules/security.md`, `.claude/rules/testing.md`.

Output format:
- Summary of changes
- CRITICAL issues (must fix before merge)
- WARNING issues (should fix)
- SUGGESTIONS (nice to have)
- Tests to add or update
- Final merge recommendation
