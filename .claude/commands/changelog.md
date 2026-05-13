---
name: changelog
argument-hint: [from-tag]
description: Generate a structured changelog from git history since a tag or the last release
---

## Available tags

!`git tag --sort=-version:refname | head -10`

## Recent commits

!`git log $([ -n "$ARGUMENTS" ] && echo "$ARGUMENTS" || git describe --tags --abbrev=0 2>/dev/null)...HEAD --oneline --no-merges 2>/dev/null || git log --oneline --no-merges -50`

Generate a structured changelog from the commits above.

If an argument was provided, use it as the base tag. Otherwise use the latest available tag shown above.

Group commits into:
- **New features**
- **Bug fixes**
- **Breaking changes**
- **Improvements**
- **Other**

Output as Markdown, ready to paste into a `CHANGELOG.md` or GitHub release.

Rules:
- Clean up commit messages for readability.
- Do not invent changes not present in the git log.
- Skip purely automated or trivial chore commits unless meaningful.
