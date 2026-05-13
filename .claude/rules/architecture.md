# Architecture

## Selected architecture

The selected architecture for this project must be described in `.claude/project-profile.md`.

If the selected architecture is missing or unclear, Claude should ask before performing a major structural change.

## Common architecture rules

- Keep controllers thin.
- Keep Twig templates focused on presentation.
- Keep entities focused on domain state and simple domain behavior.
- Move complex business logic to services, handlers, or use cases.
- Keep repositories focused on data access.
- Avoid circular dependencies.
- Avoid large classes with too many responsibilities.

## Default preference

Prefer a simple Symfony architecture unless the project profile says otherwise:

`Controller -> Service/Manager/Handler -> Repository/Entity`

Use DDD-light only when the project complexity justifies it.

## Entities

Entities may contain simple domain methods:
- `markAsPaid()`;
- `cancel()`;
- `isAvailable()`;
- `calculateTotal()` if simple and local to the entity.

Move complex workflows or coordination to services.

## Services and handlers

Use services for reusable business logic.
Use handlers or use cases for explicit application actions when it improves readability.

Examples:
- `CreateBookingHandler`;
- `UpdateProductStockHandler`;
- `OrderPaymentHandler`.

## Dependencies

- Application/business services may depend on repositories and other services.
- Entities must not depend on services.
- Repositories must not contain full application workflows.
