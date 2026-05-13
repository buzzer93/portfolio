---
name: plan-and-execute
description: Write an explicit implementation plan before touching any code. Use for features that span multiple layers (entity, service, controller, template, tests, migration) or carry significant risk.
user-invocable: true
---

Write a plan first. Execute only after validation.

Planning phase:
1. Understand the full scope: what layers are touched? (entity, migration, service, controller, form, template, tests)
2. Identify dependencies and order of changes.
3. Flag sensitive areas: auth, payment, migrations, public API.
4. Write the plan as a numbered list of concrete steps with file names.
5. Estimate risk per step (low / medium / high).
6. Present the plan to the user and wait for explicit confirmation.

Execution phase (only after confirmation):
1. Execute steps in order.
2. After each step, confirm the result before moving to the next.
3. Run tests after steps that change business logic.
4. Flag any unexpected discovery mid-execution and re-confirm before continuing.

Do not start execution if the plan contains unresolved questions about architecture or sensitive behavior.
