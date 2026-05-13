# Architecture: DDD Light Symfony

## When to use

Use this architecture for:
- complex business domains;
- long-term projects;
- SaaS applications;
- multi-tenant or workspace-based apps;
- pricing engines;
- booking systems;
- business rules that must stay stable and testable.

Do not use this architecture for simple CRUD projects.

## Main structure

Typical structure:

```text
src/
  Domain/
    Entity/
    ValueObject/
    Enum/
    Repository/
    Service/
  Application/
    Command/
    Query/
    Handler/
    DTO/
    Service/
  Infrastructure/
    Doctrine/
    Repository/
    Mailer/
    Payment/
    Storage/
  UI/
    Http/
      Controller/
      Form/
    Console/
templates/
assets/
migrations/
tests/
```

## Flow

Default flow:

```text
UI -> Application -> Domain
Application -> Domain Repository Interface
Infrastructure -> implements Domain Repository Interface
UI -> Twig/API response
```

## UI layer

The UI layer contains:
- controllers;
- form types;
- console commands;
- request/response glue.

The UI layer should not contain business logic.

Controllers should:
- receive the request;
- map input to command/DTO;
- call an application handler;
- return a response.

## Application layer

The Application layer coordinates use cases.

It may contain:
- commands;
- queries;
- handlers;
- application DTOs;
- orchestration services.

Handlers may coordinate:
- domain entities;
- repositories;
- domain services;
- infrastructure services through interfaces;
- transactions when needed.

## Domain layer

The Domain layer contains the business model.

It may contain:
- entities;
- value objects;
- enums;
- domain services;
- repository interfaces;
- business exceptions.

The Domain layer must not depend on Symfony, Doctrine, Twig, or infrastructure details.

## Infrastructure layer

The Infrastructure layer contains technical implementations:
- Doctrine repositories;
- mailers;
- payment clients;
- file storage;
- external APIs;
- Symfony adapters.

Infrastructure implements contracts needed by the Domain or Application layers.

## Entities

Domain entities should express business behavior.

Good examples:
- `Order::markAsPaid()`;
- `Booking::cancel()`;
- `PricingPeriod::isActiveAt()`;
- `Customer::canPlaceOrder()`.

Avoid anemic entities when the behavior clearly belongs to the domain.

## Value objects

Use value objects for concepts with rules:
- money;
- date ranges;
- email address;
- quantity;
- percentage;
- price adjustment.

Do not create value objects for every primitive without business value.

## Repositories

Domain may define repository interfaces when useful.
Infrastructure implements them with Doctrine.

Avoid repository interfaces if the project does not need this separation.

## Tests

Prioritize:
- domain unit tests;
- application handler tests;
- integration tests for infrastructure;
- functional tests for UI flows.

## Rule of thumb

Use DDD-light only when the domain complexity justifies the extra structure.
Keep it pragmatic and avoid ceremony.
