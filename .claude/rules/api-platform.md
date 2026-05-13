---
paths:
  - "src/ApiResource/**"
  - "src/Api/**"
  - "src/State/**"
---

# API Platform
Scope

Use this file only when API Platform is installed or planned.
If API Platform is not used in the project, do not introduce it without asking.

Resources
Keep API resources explicit and readable.
Do not expose internal entities blindly if the API contract needs control.
Use serialization groups carefully.
Avoid leaking sensitive fields.
Keep public API fields stable when possible.
Input and output

Use DTOs when they improve API clarity or safety:

custom input payloads;
write operations;
public output models;
cases where entities should not be exposed directly.
State providers and processors

Use providers for custom reads.
Use processors for custom writes.
Keep business logic in application services when it is reused outside the API.

Validation
Use Symfony Validator constraints.
Validate API input server-side.
Return clear validation errors.
Do not rely on frontend validation.
Security

Check:

operation-level security;
object-level permissions;
voters when ownership matters;
hidden fields;
admin-only operations;
write restrictions.
Performance

Use pagination for collections.
Watch for N+1 queries.
Add filters only when useful and documented.
