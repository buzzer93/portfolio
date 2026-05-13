---
name: search-first
description: Search existing code before implementing anything new. Use before writing a new service, helper, method, or feature to avoid duplicating logic that already exists.
user-invocable: true
---

Before writing new code, search what already exists — both in the codebase and in the PHP ecosystem.

## 1. Search existing project code

Steps:
1. Identify the intent: what business concept or action is needed?
2. Search by concept name: `grep -r "[concept]" src/ --include="*.php" -l`
3. Search by method pattern: look for similar verbs in services, handlers, repositories.
4. Check existing services in `src/Service/`, `src/Handler/`, `src/Manager/`.
5. Check existing repository methods.
6. Check existing Twig components and partials if frontend is involved.

Outcomes:
- If something equivalent exists: propose reusing or extending it.
- If something partial exists: propose completing it rather than creating a parallel.
- If nothing exists: continue to step 2.

Never skip this step for business logic, pricing, validation, or access control — these are the areas most likely to have silent duplicates.

## 2. Search Packagist for existing packages

Before implementing a non-trivial feature from scratch, check if a well-maintained Composer package already solves it.

Use the Packagist API via WebFetch:
```
https://packagist.org/search.json?q=[keyword]
https://packagist.org/packages/[vendor]/[package].json
```

Evaluate a package on:
- **Downloads and adoption**: high download count signals community trust.
- **Maintenance**: recent releases, open issues managed, active repository.
- **Symfony compatibility**: check `require` in `composer.json` for `symfony/*` version constraints.
- **PHP version**: must match the project's PHP requirement.
- **Scope**: the package should solve the problem without pulling in unnecessary complexity.

Good candidates to check before implementing from scratch:
- CSV/Excel import-export → `league/csv`, `phpspreadsheet`
- PDF generation → `dompdf/dompdf`, `knplabs/knp-snappy`
- Slugs → `cocur/slugify`
- Money/currency → `moneyphp/money`
- State machines → `winzou/state-machine-bundle`
- QR codes → `endroid/qr-code`
- Pagination → `knplabs/knp-paginator-bundle`
- Search → `stof/doctrine-extensions-bundle`

Outcomes:
- If a well-maintained package exists: propose adding it via Composer and explain the tradeoff.
- If no package fits or the overhead is not justified: confirm and proceed with a custom implementation.

Do not add a package just because it exists. Apply the same anti-overengineering judgement: a simple custom implementation is often better than a heavy dependency for a small use case.
