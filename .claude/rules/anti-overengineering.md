# Anti-Overengineering

## Main rule

Prefer the simplest solution that is clear, testable, and aligned with the business need.

## Avoid unnecessary complexity

Do not create abstractions just because they are possible.
Avoid:
- interfaces with only one implementation;
- factories for simple object creation;
- managers that only forward calls;
- services with no real responsibility;
- generic helpers hiding business intent;
- premature DDD layers in small features;
- configuration-driven code when simple code is clearer.

## Interfaces

Create an interface when:
- there are at least three implementations;
- the project clearly needs swappable infrastructure;
- testing or architecture requires a stable contract;
- the dependency crosses an important boundary.

Do not create an interface by default for every service.

## Traits

Use a trait only when:
- at least three classes share the same concern;
- they share at least two meaningful fields or methods;
- the trait represents a clear reusable concept.

Good examples:
- `TimestampableTrait`;
- `BlameableTrait`;
- shared price fields when the domain justifies it.

## DTOs

DTOs are not mandatory by default.
Use DTOs when they improve clarity:
- complex forms;
- API inputs/outputs;
- command/use-case data;
- when exposing an entity directly would be unsafe or confusing.

## Refactoring

Refactor when it improves understanding or reduces real duplication.
Do not refactor large parts of the project unless the task requires it.
