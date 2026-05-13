---
name: doctrine-review
description: Review Doctrine entities, repositories, relations, migrations, and queries. Use when designing a new entity, modifying an existing one, generating a migration, or diagnosing query performance.
disable-model-invocation: true
---

# Doctrine Review

## Entity design

Check:
- Typed properties, no unnecessary nullable.
- Collections initialized in the constructor.
- Relation ownership on the correct side.
- `#[ORM\Index]` on columns used in WHERE, ORDER BY, or JOIN.
- `#[ORM\UniqueConstraint]` for business-level uniqueness.
- Cascade `persist` and `remove` justified by domain behavior.
- `orphanRemoval: true` only when the child cannot exist without the parent.

## Repository review

Repositories contain data access methods only.
Flag any repository that sends emails, dispatches payments, or coordinates full workflows.

## Query review

- Paginate collections exposed in lists or APIs.
- Detect N+1: check if a loop calls a relation not JOIN fetched.
- Use `->getQuery()->toIterable()` for large dataset processing.

## Migration review

Rules:
- Never edit an executed migration.
- Always generate a new migration for schema changes.
- Review generated migrations before running them.

Check:
- Table creation/removal, column type changes, nullable changes.
- Indexes, unique constraints, foreign keys, cascade behavior.
- Data loss risk, production compatibility.

Flag explicitly:
- Dropping tables or columns.
- Nullable → non-nullable changes.
- Renamed columns without data migration.
- Enum value changes used in production.
- Foreign key or primary key changes.

## Commands

```bash
php bin/console make:migration
php bin/console doctrine:migrations:status
php bin/console doctrine:migrations:migrate
php bin/console doctrine:schema:validate
```

## Output

Return:
1. Entity issues
2. Repository issues
3. Query or performance concerns
4. Migration risks
5. Safe command sequence
6. Rollback considerations
