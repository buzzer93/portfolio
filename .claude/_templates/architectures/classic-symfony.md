# Architecture: Classic Symfony

## When to use

Use this architecture for:
- small or medium Symfony projects;
- CRUD applications;
- simple websites;
- admin panels;
- prototypes;
- projects where speed and simplicity matter more than strict layering.

## Main structure

Typical structure:

```text
src/
  Controller/
  Entity/
  Repository/
  Form/
  Service/
  Security/
  EventSubscriber/
  Command/
templates/
assets/
migrations/
tests/
```

## Flow

Default flow:

```text
Controller -> Repository / Service -> Entity
Controller -> Form -> Entity
Controller -> Twig
```

For simple CRUD logic, the controller may directly use:
- repositories;
- forms;
- entity manager;
- simple redirects and responses.

## Controllers

Controllers may handle:
- routing;
- request reading;
- form creation and handling;
- simple persistence;
- redirects;
- responses.

Controllers must not contain:
- complex business rules;
- long calculations;
- payment logic;
- security decisions beyond standard checks;
- duplicated workflows.

If a controller action becomes hard to read, move the logic to a service.

## Services

Create a service when:
- logic is reused;
- logic is business-related;
- logic needs tests;
- the controller becomes too long;
- the operation involves several entities or dependencies.

Good service examples:
- `ProductPriceCalculator`;
- `BookingAvailabilityChecker`;
- `OrderMailer`;
- `CartManager`.

Avoid creating services that only wrap one obvious method call.

## Entities

Entities should contain:
- fields;
- relations;
- getters/setters;
- simple domain methods.

Good entity methods:
- `markAsPaid()`;
- `cancel()`;
- `isActive()`;
- `getFullName()`.

Avoid putting large workflows inside entities.

## Repositories

Repositories should contain data access methods only.

Good examples:
- `findActiveProducts()`;
- `findLatestOrders()`;
- `findByCategoryWithPagination()`.

Do not put business workflows in repositories.

## Tests

Prioritize:
- services with business rules;
- controllers with important flows;
- forms with validation;
- security access checks.

## Rule of thumb

Start simple.
Extract services only when the logic becomes meaningful, reusable, or difficult to test inside the controller.
