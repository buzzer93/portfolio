---
name: symfony-ci-check
description: Run a full pre-merge verification loop on the current changes. Use before opening a PR or merging to main to catch issues before CI does.
user-invocable: true
---

Run a complete Symfony verification loop before merge.

Steps in order — stop and report if any step fails:

1. PHP syntax check on modified files:
   `git diff --name-only HEAD | grep '\.php$' | xargs -r php -l`

2. PHP-CS-Fixer dry-run (if configured):
   `vendor/bin/php-cs-fixer fix --dry-run --diff`

3. PHPStan analysis (if configured):
   `vendor/bin/phpstan analyse --no-progress`

4. Twig lint on modified templates:
   `php bin/console lint:twig templates/`

5. YAML lint:
   `php bin/console lint:yaml config/`

6. Doctrine schema check (no pending changes):
   `php bin/console doctrine:schema:validate`

7. Migration status (no unexecuted migrations):
   `php bin/console doctrine:migrations:status`

8. Full test suite:
   `php bin/phpunit` (or the command defined in `.claude/project-profile.md`)

9. GrumPHP (if configured):
   `vendor/bin/grumphp run`

Output: pass/fail per step with the exact error for failed steps. Do not suggest skipping a failing step.
