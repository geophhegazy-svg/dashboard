# EgyptNet API Contract

## Status

**Phase:** 10 — Frontend Readiness  
**Gap:** GAP-10.1 — Response Contract Authority  
**Status:** [x] CLOSED / GREEN

This document is the canonical authority for the currently exposed
API response families.

The initial contract is derived from existing production behavior
and existing feature/security tests.

This document does not introduce a global response wrapper and does
not require all endpoints to use `ApiResponse`.

---

# 1. Contract Principles

## 1.1 Existing behavior first

The initial API contract documents response behavior already present
in the application.

No response shape is changed solely to make endpoints uniform.

## 1.2 Resources remain authoritative for resource endpoints

Laravel `JsonResource` / `ResourceCollection` responses remain the
contract for resource-oriented endpoints.

Examples include:

- Customer
- Device
- DeviceAssignment
- Inventory
- Invoice
- Package
- Payment
- ScheduledReport
- Task
- Tenant
- Ticket
- User
- Customer self-service resources

## 1.3 ApiResponse is family-specific

`App\Support\ApiResponse` is an existing response helper.

It is currently used by Subscription lifecycle endpoints.

Its existence does not establish a requirement that every API
endpoint must use it.

## 1.4 Raw JSON is valid when the endpoint exposes a dedicated non-resource contract

Examples:

- authentication
- dashboards
- metrics
- reports
- composite ticket responses
- action messages
- deletion responses

These shapes are valid when they are explicitly documented and
covered by contract tests where appropriate.

## 1.5 No pagination behavior changes

Pagination behavior is not changed by this contract.

Existing `JsonResource::collection()` responses over paginators remain
the source of truth for paginated endpoints.

## 1.6 No filtering or sorting changes

This contract does not introduce a generic filtering or sorting
protocol.

Existing endpoint-specific behavior remains unchanged unless a
separate evidence-based contract gap is established.

---

# 2. Response Families

## Family A — Resource

### Shape

A resource endpoint returns the corresponding Laravel `JsonResource`.

Examples:

- `CustomerResource`
- `DeviceResource`
- `InvoiceResource`
- `PackageResource`
- `PaymentResource`
- `TicketResource`
- `UserResource`

### Contract

The resource class defines the exposed fields.

Controllers should return the resource rather than exposing the
underlying model directly for resource-oriented endpoints.

---

# 3. Family B — Paginated Resource Collection

### Shape

Paginated resource endpoints use:

```php
Resource::collection($paginator)

Laravel pagination metadata remains part of the framework-generated
response.

Contract

The following are contractually significant:

resource item shape
pagination metadata
HTTP status
endpoint-specific query behavior

No generic sorting/filtering contract is implied.

4. Family C — Lifecycle Envelope

Currently established by Subscription lifecycle endpoints.

Success shape
{
    "success": true,
    "message": "...",
    "data": {}
}
Implementation authority

App\Support\ApiResponse

Current consumers

SubscriptionController:

activate
cancel
suspend
renew
restore
expire
Test authority

tests/Feature/SubscriptionControllerTest.php

These endpoints must retain the established envelope unless an
explicit API contract change is approved.

5. Family D — Authentication
User login
Success
{
    "token": "...",
    "user": {}
}
Invalid credentials
{
    "message": "Invalid credentials"
}
Customer login
Success
{
    "token": "...",
    "customer": {}
}
Invalid credentials
{
    "message": "Invalid phone or password"
}
Current authenticated identity

The me endpoints return the authenticated user/customer payload.

Logout

Logout endpoints currently return a message response.

Authentication responses are intentionally distinct from resource
and lifecycle envelopes.

6. Family E — Customer Self-Service

Customer self-service endpoints may return:

dedicated Resources
authentication/session payloads
action message payloads
validation/error messages
dashboard/metric payloads
composite payloads

Examples:

/customer/subscription
/customer/wallet
/customer/wallet/transactions
/customer/tickets
/customer/tickets/{ticket}/messages
/customer/dashboard

Ownership remains based on the authenticated customer.

No client-supplied customer identifier may override the authenticated
customer boundary.

7. Family F — Dashboard / Metrics

Dashboard and reporting endpoints may return dedicated raw JSON
structures.

Examples:

GET /api/dashboard
GET /api/dashboard/stats
GET /api/reports/dashboard
GET /api/reports/revenue
GET /api/reports/invoices
GET /api/reports/inventory
GET /api/reports/tickets

These are metric/query contracts, not generic CRUD resource contracts.

Their field names are endpoint-specific and must not be normalized
without evidence of a consumer contract requiring the change.

8. Family G — Composite Responses

Composite endpoints may contain multiple independently structured
parts.

Example:

{
    "ticket": {},
    "messages": []
}

Current examples include ticket message endpoints.

The nested resources remain authoritative for the resource portions
of the response.

9. Family H — Mutation Message Responses

Some action endpoints currently return:

{
    "message": "..."
}

or:

{
    "message": "...",
    "data": {}
}

These responses are part of the existing endpoint contract.

They are not automatically converted to the ApiResponse envelope.

10. Family I — No Content

Some endpoints intentionally return:

204 No Content

Example:

DELETE /api/packages/{package}

A 204 response must not be changed into a JSON message without an
explicit contract decision.

11. Error Contract

Validation and authorization errors remain governed by Laravel's
existing exception / validation behavior and endpoint-specific
explicit JSON responses.

Current API JSON rendering is enabled for:

api/*

through the application's exception configuration.

No global error-envelope migration is introduced by this contract.

12. Frontend Boundary

The current frontend boundary is API-first for the Dashboard surface.

The previously existing legacy Web Dashboard view:

resources/views/dashboard/index.blade.php

was an orphaned presentation artifact with no current Dashboard
data provider and was removed during the Phase 10 Dashboard Legacy
Surface Cleanup.

The authoritative Dashboard API surfaces remain:

GET /api/dashboard
GET /api/dashboard/stats

The previous legacy view consumed:

fetch('/api/dashboard/stats')

but that Blade consumer is no longer part of the active product
surface.

No separate frontend API client, Axios layer, React application,
Vue application, or Angular application is currently established.

Therefore this contract documents the active API boundary rather
than introducing a frontend client abstraction.

13. Contract Change Rule

A response contract may change only when one of the following is
established:

A documented frontend/client requirement.
A failing contract test demonstrating an unintended mismatch.
An explicit architectural/API versioning decision.
A proven security or correctness defect in the existing response.

A response shape must not be changed merely for stylistic
consistency.

14. Explicit Non-Goals

This contract does NOT require:

migrating all endpoints to ApiResponse
wrapping all Resources inside data
replacing Resources with DTOs
introducing a response factory
introducing a base API controller
rewriting pagination
introducing generic filtering
introducing generic sorting
converting dashboards to Resources
converting authentication responses to Resources
creating a separate SPA frontend
15. Current Contract Authority

The API contract authority consists of:

This document.
Existing Laravel Resources.
Existing endpoint implementations.
Targeted API contract tests.
Existing authorization/security contract tests.

When these sources disagree, the mismatch must be investigated
before modifying production behavior.

16. GAP-10.1 Initial Evidence

The initial audit established:

multiple intentional response families exist
ApiResponse is currently used by Subscription lifecycle endpoints
Resource responses are widely used
paginated Resource collections are widely used
authentication has dedicated response shapes
dashboards/reports expose dedicated metric payloads
ticket endpoints expose composite responses
existing response assertions exist but are distributed
no dedicated API-wide response contract document existed before
this authority
no dedicated API-wide response contract test suite existed

Therefore:

GAP-10.1 is CLOSED / GREEN.

Closure evidence:

- API contract authority documented in this file.
- Central contract suite:
  `tests/Feature/Api/Contract/ApiResponseContractTest.php`
- Contract suite: 5 passed / 24 assertions.
- Targeted regression: 25 passed / 76 assertions / 0 failures / 82.39s.
- Full regression: 715 passed / 1841 assertions / 0 failures / 582.21s.
- Runtime API route evidence: 130 API routes.
- Authentication boundary verified:
  `POST /api/login` and `POST /api/customer/login` are public;
  remaining API routes are protected by `auth:sanctum`.
- Runtime contract suite: 5 passed / 24 assertions / 0 failures / 62.75s.
- No production API response behavior was changed.

The Git status command could not be evaluated because `/var/www`
is not a Git repository in the current runtime. This is an environment
observation only and is not an application failure.

Green Gate:

[x] Contract authority established
[x] Targeted contract tests GREEN
[x] Targeted regression GREEN
[x] Full regression GREEN
[x] Runtime/API evidence GREEN
[x] Production behavior unchanged

No further GAP-10.1 implementation work is authorized.

STOP.
