---
name: symfony-release
description: Prepare and tag a Symfony project release. Use when cutting a version tag, preparing a changelog, or verifying the project is ready for production deployment.
user-invocable: true
---

Prepare a release for this Symfony project.

Pre-release checks:
1. Run the `symfony-ci-check` skill — all checks must pass.
2. Verify no unexecuted migrations: `php bin/console doctrine:migrations:status`
3. Verify no local uncommitted changes: `git status`
4. Confirm the current branch is `main` or `master`.

Version:
1. Ask for the version number if not provided (semver: `MAJOR.MINOR.PATCH`).
2. Check the last tag: `git tag --sort=-version:refname | head -5`
3. Confirm the bump is correct relative to the changes (breaking = major, feature = minor, fix = patch).

Changelog:
1. `git log [last-tag]...HEAD --oneline` — list commits since last release.
2. Group by type: Features, Bug fixes, Breaking changes, Internal.
3. Propose the changelog content. Wait for validation before writing.
4. Write or update `CHANGELOG.md` if it exists.

Tagging:
1. `git tag -a v[version] -m "Release v[version]"`
2. `git push origin v[version]`

Do not push the tag without explicit user confirmation.
Do not write to `CHANGELOG.md` without showing the content first.
