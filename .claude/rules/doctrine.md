---
paths:
  - "src/Entity/**"
  - "src/Repository/**"
  - "migrations/**"
---

# Doctrine

## Entities

- Keep Doctrine entities readable and consistent.
- Use typed properties.
- Initialize collections in the constructor.
- Use clear relation names.
- Avoid nullable fields unless the domain allows missing data.
- Keep simple domain behavior inside entities when it improves clarity.

## Repositories

Repositories are for data access.
They may contain explicit query methods such as:
- `findActiveByWorkspace()`;
- `findVisibleProducts()`;
- `findOverlappingBookings()`.

Repositories should not:
- send emails;
- dispatch payments;
- handle request logic;
- coordinate full business workflows.

## Migrations

- Never edit an old migration that has already been executed.
- Always create a new migration for schema changes.
- Use Symfony Maker or Doctrine tooling to generate migrations.
- Review generated migrations before applying them.
- Check foreign keys, indexes, nullable changes, and default values.
- Avoid destructive migrations without explicit confirmation.

## Database compatibility

The project may use MySQL/MariaDB in production.
Local database engines may differ by project.
Do not assume SQLite compatibility unless the project profile says so.

## Fixtures

Fixtures may be created when useful for development, testing, or demos.
Keep fixtures realistic, small, and easy to understand.
Avoid hardcoding sensitive or production-like personal data.

## Performance

Use joins, indexes, and pagination when needed.
Avoid N+1 queries in lists and admin screens.
Do not optimize prematurely without evidence.
