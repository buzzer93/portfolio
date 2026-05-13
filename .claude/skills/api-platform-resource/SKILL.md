---
name: api-platform-resource
description: Create or review API Platform resources, operations, DTOs, providers, processors, validation, serialization groups, and security rules.
---

# API Platform Resource

## Purpose

Use this skill when working with API Platform.

## Before implementation

Check:
- API Platform is installed;
- Symfony and API Platform versions;
- existing resource conventions;
- serialization group strategy;
- security model;
- DTO usage;
- providers and processors.

## Resource design

Prefer explicit API contracts.
Do not expose internal entities blindly when the API needs control.

Consider DTOs for:
- input payloads;
- output models;
- custom operations;
- public API contracts;
- sensitive entities.

## Operations

For each operation, define:
- method;
- URI;
- input/output;
- validation;
- security;
- processor/provider if needed.

## Security

Check:
- collection access;
- item access;
- ownership;
- admin-only operations;
- hidden fields;
- write permissions.

Use voters when object-level checks matter.

## Validation

Use Symfony Validator.
Return clear validation errors.
Do not rely on frontend validation.

## Performance

Check:
- pagination;
- filters;
- N+1 queries;
- serialization depth;
- unnecessary joins.

## Tests

Add functional API tests for:
- success cases;
- validation errors;
- forbidden access;
- not found or ownership cases.

## Output

Return:
1. API contract
2. Files changed
3. Security rules
4. Tests added
5. Manual API checks
