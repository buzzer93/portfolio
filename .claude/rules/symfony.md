# Symfony

## General

- Prefer Symfony native features before adding dependencies.
- Follow the project's installed Symfony version and conventions.
- Use dependency injection instead of static helpers or service locators.
- Keep framework code and business logic clearly separated.
- Prefer explicit services over hidden global behavior.

## Controllers

Controllers should be thin.
They may:
- receive the request;
- validate basic input flow;
- call a service, manager, handler, or use case;
- create forms;
- return a response or redirect.

Controllers should not contain complex business logic.

## Services

Services should have clear responsibilities.
A service should not become a dumping ground.
Prefer business-oriented names:
- `BookingPriceCalculator`;
- `OrderPaymentHandler`;
- `ProductAvailabilityChecker`.

Use `Manager` only when it coordinates several operations and the name is meaningful in the project.

## Forms

- Use Symfony Forms for complex server-side forms.
- Keep form types focused on form configuration.
- Put business validation in validators or services when needed.
- Avoid putting persistence logic in form types.

## Validation

- Use Symfony Validator constraints for input validation.
- Use custom constraints for reusable business validation.
- Do not rely only on frontend validation.

## Events and messages

Use events, Messenger, or async processing only when there is a real need.
Do not introduce them for simple synchronous logic.
