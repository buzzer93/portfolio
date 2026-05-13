---
name: github-workflow
description: Manage the full GitHub lifecycle for a task: read issue, implement fix, open PR, respond to review comments, merge. Use when working with GitHub issues and pull requests.
user-invocable: true
---

Handle the full GitHub workflow for a task.

Issue phase:
1. `gh issue view [number]` — read the full issue with comments.
2. Identify affected files and root cause before touching anything.
3. If the issue is ambiguous, list clarifying questions before implementing.

Implementation phase:
1. Create a branch: `git checkout -b fix/[short-description]` or `feature/[short-description]`.
2. Implement the minimal change. Use the plan-and-execute skill for complex tasks.
3. Write or update tests covering the changed behavior.
4. Run the test suite.

Pull request phase:
1. `git push -u origin [branch]`
2. `gh pr create --title "[type]: [description]" --body "[summary + test plan]"`
3. Link the issue: include `Closes #[number]` in the PR body.

Review phase:
1. `gh pr view [number] --comments` — read review comments.
2. Address each comment. Do not dismiss without a clear reason.
3. `gh pr review [number] --approve` only when all comments are resolved.

Do not force-push to shared branches. Do not merge without passing CI.
