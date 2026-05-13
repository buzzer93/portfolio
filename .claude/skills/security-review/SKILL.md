---
name: security-review
description: Review Symfony/PHP code for security risks involving authentication, authorization, CSRF, XSS, uploads, payments, webhooks, secrets, and user data.
disable-model-invocation: true
---

# Security Review

## Purpose

Use this skill when reviewing security-sensitive Symfony code.

This skill is mainly for analysis and recommendations.
Do not perform broad rewrites unless explicitly requested.

## Review scope

Check:
- authentication;
- authorization;
- voters;
- admin access;
- CSRF;
- forms and validation;
- Twig escaping;
- file uploads;
- payment logic;
- webhooks;
- secrets;
- user data exposure;
- API access control.

## Symfony checks

Verify:
- routes have correct access rules;
- object ownership is checked;
- admin-only actions are protected;
- forms use CSRF when needed;
- sensitive actions are not accessible by GET;
- voters are used when object-level authorization matters.

## Twig and XSS

Check:
- unsafe `|raw`;
- user-generated content rendering;
- escaped variables;
- injected HTML;
- JavaScript data injection.

## Uploads

Check:
- MIME type validation;
- file size limit;
- generated filename;
- storage location;
- public/private access;
- old file deletion when replacing files.

## Payments and webhooks

For payment logic:
- do not trust client-side status;
- verify webhook signatures;
- use server-side payment state;
- avoid logging secrets;
- handle duplicate webhook events safely.

## Output format

Return:
1. Summary
2. Critical issues
3. Major issues
4. Minor issues
5. Recommended fixes
6. Tests to add
7. Files to inspect next
