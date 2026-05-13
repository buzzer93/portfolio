---
name: grumphp
description: Check modified files for GrumPHP compatibility before committing
---

## Modified files

!`git diff --name-only HEAD`

## Staged files

!`git diff --cached --name-only`

Check the files listed above for GrumPHP compatibility.

For each changed PHP file:
- no `var_dump`, `dump`, `dd`, `die`, `exit` left in code;
- no unused imports or variables;
- strict types declared if the project follows this convention;
- no commented-out dead code;
- PSR-12 formatting issues that PHP-CS-Fixer would flag;
- PHPStan issues if configured.

For Twig files: check for `|raw` usage, unsafe rendering, missing variables.
For YAML/config files: validate syntax.

If GrumPHP is installed, suggest running: `vendor/bin/grumphp run`

Output:
- List of issues per file
- Severity (blocks commit / warning)
- Suggested fix for each issue
- Command to run the full check manually
