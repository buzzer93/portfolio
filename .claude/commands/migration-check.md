---
name: migration-check
description: Check pending Doctrine migrations and assess production risk before deploying
---

## Migrations status

!`php bin/console doctrine:migrations:status 2>&1`

## Migration files

!`ls -1 migrations/ 2>/dev/null || echo "No migrations/ folder found"`

Read the pending migrations listed above, then inspect each file in `migrations/` to assess the production risk.

For each pending migration:
1. Read the migration file.
2. Flag destructive operations: DROP TABLE, DROP COLUMN, nullable → non-nullable, renamed columns, removed indexes, foreign key changes.
3. Assign a risk level: SAFE / WARNING / CRITICAL.
4. Suggest a rollback strategy when applicable.

Output:
- Pending migration count
- Risk level per migration (SAFE / WARNING / CRITICAL)
- Dangerous operations detected
- Recommended actions before executing in production
