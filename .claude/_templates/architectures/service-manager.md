# Architecture: Service / Manager Symfony

## When to use

Use this architecture for:
- medium Symfony projects;
- projects with recurring business logic;
- e-commerce;
- booking systems;
- dashboards;
- apps with several workflows but not enough complexity for full DDD.

## Main structure

Typical structure:

```text
src/
  Controller/
  Entity/
  Repository/
  Form/
  Service/
  Manager/
  Handler/
  DTO/
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
Controller -> Service/Manager/Handler -> Repository/Entity
Controller -> Form/DTO -> Service/Manager/Handler
Service/Manager/Handler -> Repository -> Entity
```

## Controllers

Controllers should stay thin.

They may:
- receive the request;
- create and handle forms;
- call a service, manager, or handler;
- return a response;
- redirect after success.

They should not:
- coordinate complex workflows;
- contain business calculations;
- directly manipulate several entities for one business action;
- send emails or trigger payments directly.

## Services

Use services for focused business logic.

Good examples:
- `BookingPriceCalculator`;
- `ProductStockUpdater`;
- `OrderStatusResolver`;
- `CustomerEligibilityChecker`.

A service should have a clear responsibility.

## Managers

Use a manager when it coordinates a business workflow involving several steps.

Good examples:
- `OrderManager`;
- `BookingManager`;
- `CartManager`.

A manager may coordinate:
- repositories;
- entity changes;
- validation services;
- mailers;
- payment handlers;
- events.

Avoid managers that become generic dumping grounds.

## Handlers

Use handlers for explicit actions or use cases.

Good examples:
- `CreateBookingHandler`;
- `PayOrderHandler`;
- `CancelReservationHandler`.

Handlers are useful when an action has a clear beginning and end.

## DTOs

DTOs are optional.

Use DTOs for:
- complex forms;
- API input;
- commands/use cases;
- data that should not map directly to an entity;
- avoiding unsafe direct entity exposure.

Do not create DTOs for every simple form by default.

## Entities

Entities may contain simple domain methods.

Good examples:
- `markAsPaid()`;
- `cancel()`;
- `isExpired()`.

Complex workflows should stay in services, managers, or handlers.

## Repositories

Repositories handle queries and persistence access.
They should not coordinate complete application workflows.

## Tests

Prioritize tests for:
- services;
- managers;
- handlers;
- important controller flows;
- validation;
- security.

## Rule of thumb

Use this architecture when classic Symfony starts putting too much logic in controllers, but full DDD would be excessive.
