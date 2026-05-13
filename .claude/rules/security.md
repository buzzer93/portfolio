
Security
Main rule

For sensitive changes, Claude must explain the plan before editing code.

Sensitive areas:

authentication;
authorization;
admin access;
payment;
webhooks;
file uploads;
user data;
migrations;
deployment.
Secrets

Claude may read .env when it is used as a template.
Claude must not read:

.env.local;
.env.prod;
secrets/**;
private keys;
production dumps.
Symfony security

Check:

access control;
voters;
CSRF protection;
form validation;
password handling;
remember-me behavior;
admin-only routes;
user ownership checks.
Twig and XSS
Rely on auto-escaping.
Avoid |raw.
Sanitize user-generated HTML before rendering.
Do not trust frontend-only validation.
Uploads

For file uploads, check:

MIME type;
size limit;
generated filename;
storage location;
public/private access;
deletion of old files when relevant.
Payments

For Stripe or payment logic:

explain the plan first;
verify webhook handling;
avoid trusting client-side payment status;
log useful events without exposing secrets.
