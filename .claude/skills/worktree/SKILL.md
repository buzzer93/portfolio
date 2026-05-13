---
name: worktree
description: Set up a git worktree for parallel development. Use when working on a feature that should stay isolated from the current branch, or when testing a migration without blocking ongoing work.
user-invocable: true
---

Create a git worktree to work in isolation.

Steps:
1. Run `git worktree list` to see existing worktrees.
2. Choose a branch name for the new work: `feature/[name]` or `fix/[name]`.
3. Create the worktree: `git worktree add ../[project]-[branch] -b [branch]`.
4. Copy environment files if present: `.env.local`, `.env.test.local`.
5. Run `composer install` in the new worktree if dependencies differ.
6. Confirm the worktree is ready and tell the user which directory to open.

Cleanup when done:
- Merge or delete the branch.
- Remove the worktree: `git worktree remove ../[project]-[branch]`.
- Prune stale entries: `git worktree prune`.

Do not create a worktree if the task can be done safely on the current branch.
