# EgyptNet — Master Project Completion Roadmap

> **Status:** FROZEN FOR EXECUTION

> **Purpose:** This document is the single canonical source of truth for completing the EgyptNet Enterprise ISP Platform.

> **Rule:** Never invent historical work or historical phase numbers.

> **Rule:** Never reopen a GREEN completed phase unless new evidence proves that its contract has regressed.

> **Completion Rule:** EgyptNet is complete only when all required phases reach GREEN / DONE and the Final Architecture Certification passes.

---

# EXECUTION MODEL

EgyptNet follows the Fast Architecture Loop:

```text
Quick Audit

→ Gap / No Gap

→ Minimal Fix

→ Targeted Tests

→ Regression

→ Runtime Evidence

→ Green Gate

→ DONE

→ STOP
```

### Status Markers

* `[x]` DONE / GREEN
* `[~]` IN PROGRESS
* `[ ]` PENDING
* `[!]` BLOCKED
* `DEFERRED` = intentionally postponed and documented

---

# 0. ROADMAP BASELINE

* [x] Establish `docs/MASTER_ROADMAP.md` as the canonical roadmap.
* [x] Establish Fast Architecture Loop.
* [x] Establish evidence-first development.
* [x] Establish no-speculation rule.
* [x] Establish minimal-change rule.
* [x] Establish explicit Green Gates.
* [x] Establish sequential execution from current verified state to completion.

**Status:** GREEN / DONE

---

# 1. VERIFIED COMPLETED ARCHITECTURE WORK

This section records work already completed and must not be reopened without new regression evidence.

## 1.1 Core Architecture Hardening

* [x] Core architecture hardening work completed.
* [x] Workflow Engine implementation completed.
* [x] WorkflowContext established.
* [x] WorkflowResult established.
* [x] Transaction Manager abstraction established.
* [x] Laravel Transaction Manager implemented.
* [x] Workflow Executor established.
* [x] Workflow Pipeline established.
* [x] Legacy Workflow Step compatibility handled where required.
* [x] Core architecture freeze work completed.

## 1.2 Kernel Boundary Hardening

* [x] Kernel registration boundary audited.
* [x] Kernel resources audited.
* [x] Kernel contracts audited.
* [x] Resource compilation coverage verified.
* [x] Runtime-only resources verified.
* [x] Module manifest registration verified.
* [x] Module lifecycle verified.
* [x] Kernel failure lifecycle verified.
* [x] Kernel validation verified.
* [x] Kernel health verified.
* [x] Kernel diagnostics verified.
* [x] Kernel cache lifecycle verified.
* [x] Kernel cache-clear command migrated to Infrastructure.
* [x] Targeted Kernel tests GREEN.
* [x] 40C.81 Kernel Boundary Hardening completed GREEN.

### Current Kernel Evidence

Historical Kernel checkpoints remain historical evidence only.

The current project-wide Green Gate is the later full regression:

```text
546 passed

1416 assertions

0 failures
```

Completed Kernel work remains CLOSED.

## 1.3 Module Model Consolidation

* [x] Ticket model consolidation.
* [x] TicketReply model consolidation.
* [x] PPPoEUser model consolidation.
* [x] Account model consolidation.
* [x] JournalEntryLine model consolidation.
* [x] Report model consolidation.
* [x] ReportExport model consolidation.
* [x] Task model consolidation.

## 1.4 Customer Module Cleanup

* [x] Customer Module structure audited.
* [x] Customer Workflows removed where obsolete.
* [x] Customer Application Services removed where obsolete.
* [x] `CreateCustomerCommandHandler` delegates to Action.
* [x] Customer ownership boundary verified.
* [x] Customer tests GREEN.

## 1.5 ReportExport Migration

* [x] ReportExport Module model established.
* [x] ReportExport factory established.
* [x] Legacy ReportExport files removed.
* [x] ReportExport boundary verified.

## 1.6 UsageSnapshot Ownership

* [x] UsageSnapshot ownership assigned to Usage Module.
* [x] Root `App\Models\UsageSnapshot` removed.
* [x] `App\Models\UsageSnapshot` references removed.
* [x] UsageService uses Module model.
* [x] SyncUsageSnapshots uses Module model.
* [x] Migration ownership verified.
* [x] Targeted architectural verification completed.
* [x] Regression GREEN.
* [x] UsageSnapshot Ownership completed GREEN.

## 1.7 CRUD Architecture Cleanup

* [x] Invoice CRUD architecture cleaned.
* [x] Payment CRUD architecture cleaned.
* [x] Package CRUD architecture cleaned.
* [x] Trivial CRUD Workflows removed where Actions are sufficient.
* [x] Subscription invoice creation moved through InvoiceService.
* [x] Invoice ownership rule preserved.

**Phase Status:** GREEN / DONE

### Important Historical Rule

Historical phase `2.3D` is NOT reconstructed.

Its original scope was not recoverable from verified project evidence.

Therefore it remains permanently recorded as an unrecoverable historical label and is not treated as an implementation task.

---

# 2. CURRENT ARCHITECTURE GAP AUDIT

**Status:** CLOSED / GREEN

The architecture audit was completed using evidence-first verification.

## Objective

Perform an evidence-first audit of the current repository and identify only real architectural gaps.

## Completed Scope

* [x] Core — audited / NO GAP
* [x] Kernel — audited / NO GAP
* [x] Module Registry — audited / NO GAP
* [x] Module Loader — audited / NO GAP
* [x] Module Manifest — audited / NO GAP
* [x] Module Resources — audited / NO GAP
* [x] Module Discovery — audited / NO GAP
* [x] Module Source — audited / NO GAP
* [x] Manifest Collection / Compilation — audited / NO GAP
* [x] Network Provider registration boundary — NO GAP
* [x] Network Provider Resolver — NO GAP
* [x] Network Infrastructure service placement — NO GAP
* [x] NetworkDevice repository boundary — NO GAP
* [x] Network Controller / NetworkDevice persistence — GREEN / CLOSED
* [x] Security / Authorization Policy boundary — GREEN / NO GAP
* [x] Subscription lifecycle boundary — NO GAP
* [x] Legacy `app/Models` — NO GAP
* [x] Duplicate wrappers — NO GAP
* [x] Legacy `app/Services` — audited / NO GAP
* [x] Legacy Workflows — audited / CLOSED
* [x] Cross-module ownership — NO GAP
* [x] Aggregate ownership — NO GAP
* [x] Actions — audited / CLOSED
* [x] Commands / Handlers — audited / NO GAP
* [x] Queries / Handlers — audited / NO GAP
* [x] Domain Services — audited
* [x] Repositories — audited
* [x] Events / Listeners — audited
* [x] Infrastructure — audited
* [x] Presentation — audited
* [x] Authorization — audited
* [x] Scheduling — audited
* [x] RouterOS integration boundaries — audited
* [x] Documentation boundaries — classified
* [x] Tests — classified

## Proven Architectural GAP Fixed

### InvoicePolicy Ownership

* [x] Invoice aggregate ownership verified.
* [x] `InvoicePolicy` moved from Billing to Invoice Module.
* [x] Policy now lives at:

```text
app/Modules/Invoice/Policies/InvoicePolicy.php
```

* [x] Billing policy registration removed.
* [x] Invoice Module owns and registers the policy.
* [x] Targeted authorization evidence:

```text
29 passed
70 assertions
```

* [x] Runtime Gate resolves:

```text
Invoice::class
    =>
App\Modules\Invoice\Policies\InvoicePolicy
```

## Tenant Context Evidence

The previous TenantScope failures were confirmed as test/fixture drift, not a production architecture defect.

Production behavior was verified through Sanctum runtime:

```text
1 passed
3 assertions

user_id => 1
user_tenant_id => 1
context_tenant_id => 1
context_is_global => false
default_guard_user => 1
sanctum_guard_user => 1
```

Minimal test-only correction:

```php
app('request')->setUserResolver(fn () => $user);
```

Targeted TenantScope evidence:

```text
5 passed
8 assertions
```

No production TenantContext change was required.

## Cross-Module Ownership Evidence

* [x] No direct cross-module aggregate creation found.
* [x] No direct cross-module aggregate mutation found.
* [x] No cross-module ownership violation found.
* [x] Invoice ownership preserved.
* [x] Cross-module application contracts remain valid.

The existing static boundary test using non-recursive `glob()` is not accepted as architectural proof. It is not a Green Gate dependency.

## Module Source of Truth

Runtime evidence:

```text
SOURCE_COUNT=18
```

Discovered Modules:

```text
Accounting

Activity

Billing

Customer

Dashboard

Documentation

Inventory

Invoice

Network

Notification

Package

Payment

Reports

Subscription

Task

Ticket

Usage

Wallet
```

`Policies` remains a structural directory and is not a discovered Module.

## Phase 2 Green Gate

* [x] Architecture map completed.
* [x] Relevant areas classified.
* [x] Real GAP identified.
* [x] Proven GAP fixed minimally.
* [x] No-Gap areas recorded.
* [x] Deferred items classified.
* [x] Targeted tests GREEN.
* [x] Runtime evidence GREEN.
* [x] Full regression GREEN.

**Phase Status:** CLOSED / GREEN

> **Decision:** Do not reopen the architecture audit without new evidence of regression or an explicit architectural contract change.

---

# 3. LEGACY BOUNDARY ELIMINATION

**Status:** CLOSED FOR AUDITED LEGACY BOUNDARIES

## Objective

Remove remaining legacy architectural paths only where the audit proves they are obsolete.

## Audited Targets

* [x] Legacy `app/Models` — NO GAP
* [x] Legacy `app/Services` — NO GAP
* [x] Legacy Workflows — CLOSED
* [x] Duplicate model wrappers — NO GAP
* [x] Duplicate repositories — classified
* [x] Duplicate business logic — classified
* [x] Obsolete compatibility layers — classified
* [x] Framework-bound business logic outside proper boundaries — classified

### Legacy `app/Services`

Evidence:

```text
app/Services directory: ABSENT

App\Services references: NONE
```

The remaining Automation service boundary is valid and is not classified as legacy merely because it contains a service.

### Legacy Workflows

Only legitimate Workflow infrastructure/lifecycle workflows remain.

Valid Subscription lifecycle Workflows:

```text
ActivateWorkflow

EnterGraceWorkflow

ExpireWorkflow

RenewWorkflow

RestoreWorkflow

SuspendWorkflow
```

Targeted subscription workflow/orchestrator evidence:

```text
16 passed

47 assertions
```

## Deferred Legacy Model Boundaries

The following are intentionally deferred to their owning domains:

```text
JournalEntry

ActivityLog

Notification

WalletTransaction
```

These are not permitted to trigger opportunistic refactoring.

**Boundary Status:** GREEN / CLOSED FOR AUDITED SCOPE

---

# 4. MODULE OWNERSHIP COMPLETION

**Status:** CLOSED FOR VERIFIED OWNERSHIP BOUNDARIES

## Verified Ownership

* [x] Customer
* [x] Package
* [x] Invoice
* [x] Payment
* [x] Subscription
* [x] Network
* [x] Accounting
* [x] Wallet
* [x] Notification
* [x] Activity
* [x] Task
* [x] Ticket
* [x] Report
* [x] ReportExport
* [x] UsageSnapshot
* [x] JournalEntryLine

## Ownership Rules

* [x] Canonical Module model locations verified.
* [x] Factory ownership verified where migrated.
* [x] Repository ownership verified.
* [x] Aggregate ownership audited.
* [x] Cross-module ownership violations audited.
* [x] Legacy duplicate wrappers removed/classified.
* [x] Invoice aggregate ownership explicitly enforced.

## Deferred Ownership Items

The following remain intentionally deferred where they require their owning domain phase:

```text
JournalEntry

ActivityLog

Notification

WalletTransaction
```

**Ownership Verdict:** GREEN / NO ACTIVE GAP

---

# 5. APPLICATION / USE-CASE ARCHITECTURE

**Status:** CLOSED FOR AUDITED CURRENT ARCHITECTURE

Preferred structure:

```text
Command

↓

Handler

↓

Action / Workflow

↓

Domain

↓

Repository
```

## Verified

* [x] Commands audited.
* [x] Command Handlers audited.
* [x] Actions audited.
* [x] Queries audited.
* [x] Query Handlers audited.
* [x] Workflows audited.
* [x] Domain Services audited.
* [x] Repositories audited.
* [x] Controllers remain thin in audited surfaces.
* [x] Trivial CRUD Workflows removed where Actions are sufficient.
* [x] No repository business orchestration GAP identified.
* [x] No duplicated use-case GAP identified.

### Actions

Subscription lifecycle Actions are established:

```text
ActivateSubscriptionAction

EnterGraceSubscriptionAction

ExpireSubscriptionAction

RenewSubscriptionAction

RestoreSubscriptionAction

SuspendSubscriptionAction
```

Actions remain thin and delegate domain state changes appropriately.

**Application Architecture Verdict:** GREEN / NO ACTIVE GAP

---

# 6. BILLING & SUBSCRIPTION DOMAIN

**Status:** CLOSED / GREEN

## Scope

* [x] Subscription lifecycle ownership
* [x] Activate / Suspend / Grace / Expire / Renew / Restore
* [x] Renewal scheduler / command lifecycle
* [x] Queue / asynchronous execution boundary
* [x] Failure / rollback behavior
* [x] Cross-module boundaries
* [x] Invoice creation ownership
* [x] Payment interaction
* [x] Wallet interaction
* [x] Runtime scheduler verification
* [x] Targeted tests
* [x] Full regression
* [x] Green Gate

---

## 6.1 Subscription Lifecycle

Verified lifecycle Actions:

```text
Activate

Suspend

Enter Grace

Expire

Renew

Restore
```

Subscription state transitions remain owned by the Subscription aggregate.

Repository eligibility methods:

```text
findEligibleForAutoRenew()

findEligibleForGracePeriod()

findEligibleForExpiration()
```

Lifecycle Workflows orchestrate Actions through the existing Workflow / ActionDispatcher boundary.

---

## 6.2 Renewal Scheduler

Runtime scheduler registration verified:

```text
5  0 * * *  php artisan subscriptions:auto-renew

10 0 * * *  php artisan subscriptions:auto-grace

15 0 * * *  php artisan subscriptions:auto-expire
```

All three commands use:

```text
withoutOverlapping()
```

Ordering is explicitly:

```text
Renew

→ Grace

→ Expire
```

No scheduling architecture GAP identified.

---

## 6.3 Invoice Ownership

Critical architectural rule:

> The Invoice Module is the sole owner of the Invoice aggregate.

Verified:

* [x] No `Invoice::create()` from Billing/Subscription.
* [x] No direct invoice number generation from Billing/Subscription.
* [x] Renewal invoice creation flows through `InvoiceService`.
* [x] `SubscriptionRenewedListener` uses `InvoiceServiceInterface`.
* [x] Invoice creation delegates to `CreateInvoiceAction`.

Renewal flow:

```text
Subscription

↓

RenewWorkflow

↓

SubscriptionRenewed

↓

SubscriptionRenewedListener

↓

InvoiceService

↓

CreateInvoiceAction

↓

Invoice Module
```

---

## 6.4 Renewal Invoice Idempotency

`renewal_key` is unique at persistence level.

Verified behavior:

```text
Same renewal key

→ same invoice

→ no duplicate invoice

Different renewal keys

→ separate invoices
```

Targeted evidence:

```text
9 passed

21 assertions
```

### Verdict

```text
Renewal Invoice Idempotency = NO GAP

Invoice Ownership = NO GAP
```

---

## 6.5 Payment Boundary

`CreatePaymentAction` owns payment creation and settlement orchestration.

Verified:

* [x] Payment created through Payment Module.
* [x] Invoice retrieved through Invoice boundary.
* [x] Invoice settlement delegated to Invoice service.
* [x] Overpayment delegated to Wallet service.
* [x] Payment operation is transactional.
* [x] No direct cross-module Invoice creation.
* [x] No direct Wallet model mutation from Payment.

Targeted evidence:

```text
2 passed

6 assertions
```

---

## 6.6 Wallet Boundary

Verified:

* [x] Wallet balance mutation remains Wallet-owned.
* [x] Wallet repository boundary exists.
* [x] Deposit / Deduct actions own wallet mutation.
* [x] Wallet transaction ledger remains Wallet-owned.
* [x] Payment uses `WalletServiceInterface` for wallet interaction.
* [x] No cross-module Wallet model mutation identified.

Existing Wallet service coverage remains GREEN.

---

## 6.7 Queue Boundary

`SubscriptionRenewed` and `SubscriptionSuspended` implement Laravel `ShouldQueue`.

The custom EventDispatcher itself remains synchronous by contract.

Verified:

* [x] No production queue dispatch implementation bypassing the established boundary.
* [x] No contract requiring the custom EventDispatcher to implement Laravel queue semantics.
* [x] Queue marker ambiguity classified as non-blocking/deferred.

**Queue Boundary:** NO ACTIVE GAP

---

## 6.8 Failure / Rollback

Workflow execution is transaction-wrapped:

```text
WorkflowExecutor

↓

TransactionStep

↓

DB::transaction(...)

↓

WorkflowExecutionStep

↓

AbstractWorkflow::execute()

├── rules

├── before

├── perform

│   └── Action

└── after

    └── EventDispatcher

        └── listeners

↓

COMMIT
```

Targeted rollback test:

```text
test_workflow_rolls_back_subscription_when_after_event_fails
```

Evidence:

```text
1 passed

4 assertions
```

**Failure / Rollback:** GREEN / NO GAP

---

## 6.9 Subscription Listener Integration

`SubscriptionRenewedListener` verified to:

* [x] create renewal invoice
* [x] create notification
* [x] create activity log
* [x] preserve idempotency
* [x] avoid direct Invoice aggregate creation

Targeted evidence included in:

```text
9 passed

21 assertions
```

---

## 6.10 Reports ExecuteReportAction Regression Correction

A regression was identified in `ExecuteReportAction` where the Action attempted to persist `ReportExport` data using fields that do not belong to the established `ReportExport` persistence contract.

Verified evidence showed:

* [x] The existing `ReportExport` persistence contract requires `report_id`, `filename`, `disk`, `path`, `mime_type`, `size`, `exported_by`, and `exported_at`.
* [x] `ExecuteReportAction` had no valid producer for the required persistence fields.
* [x] No production caller of `ExecuteReportAction` was found.
* [x] No existing storage abstraction exists for this flow.
* [x] No new Report/Storage architecture was introduced.

### Minimal Fix

* [x] Removed the invalid `ReportExportRepository` persistence side-effect from `ExecuteReportAction`.
* [x] Preserved the Action responsibility:
  `ReportManager -> ExportManager -> ExportResult`.
* [x] No changes made to `Report`, `ReportExport`, migrations, factories, repositories, exporters, `ExportManager`, or storage architecture.
* [x] `ReportExport Migration` remains CLOSED / GREEN.
* [x] Phase 6 remains CLOSED / GREEN.

### Evidence

Targeted Action test:

```text
3 tests
20 assertions
OK
```

Reports test suite:

```text
24 tests
90 assertions
OK
```

Full regression:

```text
546 tests
1416 assertions
0 failures
PHPUnit Notices: 5
```

The 5 PHPUnit Notices are non-failing notices and do not invalidate the GREEN test gate.

**Regression Correction Verdict:** GREEN / CLOSED

> **Decision:** This correction is complete. Do not reopen the ReportExport migration, Phase 6, or the broader architecture audit without new regression evidence or an explicit architectural contract change.

---

## Phase 6 Green Gate

```text
Payment Boundary

2 passed / 6 assertions

Renewal Invoice / Listener

9 passed / 21 assertions

Rollback

1 passed / 4 assertions

Reports ExecuteReportAction

3 passed / 20 assertions

Reports Module Regression

24 passed / 90 assertions

Full Regression

546 passed / 1416 assertions

0 failures
```

**Phase 6 Verdict: CLOSED / GREEN**

> **Decision:** Billing & Subscription Domain is complete. No further Phase 6 refactoring is authorized without new regression evidence.

---

# 7. BUSINESS RULES & STATE MACHINES

**Status:** ACTIVE — BROADER DOMAIN VALIDATION

Phase 6 has already proven the Subscription lifecycle path.

The remaining Phase 7 scope is the broader business-rule audit across all domains.

## Objective

Validate behavior, not only architecture.

## Domains

* [x] Subscription lifecycle — verified
* [x] Billing lifecycle — verified within Phase 6
* [x] Renewal — verified
* [x] Grace period — verified
* [x] Expiration — verified
* [x] Customer lifecycle — verified / NO GAP
* [x] Invoice business rules — verified / NO GAP
* [x] Payment business rules — verified / NO GAP
* [x] Wallet business rules — verified / NO GAP
* [x] Accounting business rules — verified / NO GAP
* [x] Network business rules — verified / NO GAP
* [x] Package business rules — verified / NO GAP
* [ ] Cancellation
* [ ] Activation / Deactivation
* [ ] Remaining domain-specific rules

## Validate

* [ ] Business rules.
* [ ] State transitions.
* [ ] Domain Services.
* [ ] Aggregate transitions.
* [ ] Domain Events.
* [ ] Scheduled operations outside completed Phase 6 scope.
* [ ] Error handling across remaining domains.

**Exit Gate:** Business rules have clear owners and executable tests.

---

# 8. INFRASTRUCTURE & NETWORK INTEGRATION

**Status:** PENDING — BROADER INFRASTRUCTURE / ROUTEROS SCOPE

## Objective

Ensure Infrastructure owns framework and external-system concerns.

## Verified Sub-Boundaries

* [x] Network Provider registration boundary — NO GAP.
* [x] Network Provider Resolver — NO GAP.
* [x] Network services Infrastructure placement — NO GAP.
* [x] NetworkDevice repository boundary — NO GAP.
* [x] Network Controller → NetworkDevice persistence — GREEN / CLOSED.

These completed sub-boundaries do not close the entire Infrastructure / Network phase.

## Network Provider Resolver

Targeted evidence:

```text
5 passed

7 assertions
```

Runtime:

```text
AVAILABLE=mikrotik

MIKROTIK_CLASS=
App\Modules\Network\Infrastructure\Providers\MikroTik\MikroTikProvider
```

Unsupported provider behavior:

```text
UNSUPPORTED_PROVIDER=RuntimeException

MESSAGE=Unsupported network provider: unsupported
```

## Network Services

Verified Infrastructure placement:

```text
App\Modules\Network\Infrastructure\Services\NetworkManager

App\Modules\Network\Infrastructure\Services\MikrotikServiceAdapter
```

Runtime:

```text
MIKROTIK_SERVICE_CLASS=
App\Modules\Network\Infrastructure\Services\MikrotikServiceAdapter

SERVICE_OK=YES

NETWORK_MANAGER_CLASS=
App\Modules\Network\Infrastructure\Services\NetworkManager
```

Current RouterOS connection state:

```text
CONNECTED=NO

PROVIDER=NULL
```

This is runtime environment state and is not classified as an architectural service-boundary failure.

## NetworkDevice Repository

Runtime:

```text
REPOSITORY=
App\Modules\Network\Infrastructure\Repositories\NetworkDeviceRepository

ACTIVE_TYPE=
Illuminate\Database\Eloquent\Collection

ACTIVE_COUNT=1

FIND_1=FOUND

FIND_OR_FAIL_1=OK
```

Binding:

```text
REPOSITORY_CLASS=
App\Modules\Network\Infrastructure\Repositories\NetworkDeviceRepository

CONTRACT_OK=YES
```

## Network Controllers

Targeted regression:

```text
14 passed

83 assertions
```

Covered:

```text
DhcpApiControllerTest

FirewallApiControllerTest

QueueApiControllerTest

MikrotikControllerTest

Network/DHCPControllerTest

Network/FirewallControllerTest

Network/QueueControllerTest
```

### Remaining Infrastructure Scope

* [ ] MikroTik runtime connection behavior
* [ ] RouterOS API integration
* [ ] PPPoE lifecycle
* [ ] Hotspot lifecycle
* [ ] Profiles
* [ ] Queues / speed enforcement
* [ ] Synchronization
* [ ] Disconnect / expiry enforcement
* [ ] Runtime router evidence
* [ ] Infrastructure failure handling
* [ ] Fail-safe behavior
* [ ] Remaining scheduled infrastructure operations

### Special Rule

Schedule is a runtime resource.

It must not be incorrectly treated as a compiled resource.

**Exit Gate:** Infrastructure and Network runtime behavior GREEN.

---

# 9. API / PRESENTATION / AUTHORIZATION

**Status:** PENDING — BROADER PRESENTATION SURFACE

## Already Verified

* [x] Core User/Tenant policy ownership.
* [x] Module policy ownership.
* [x] PolicyResource registration.
* [x] Runtime Gate policy mapping.
* [x] Network controller persistence boundary.
* [x] Sanctum TenantContext runtime behavior.

Security policy evidence:

```text
29 passed

70 assertions
```

Tenant runtime evidence:

```text
1 passed

3 assertions
```

## Remaining Audit

* [ ] Controllers.
* [ ] Requests.
* [ ] Resources.
* [ ] Responses.
* [ ] Routes.
* [ ] Policies.
* [ ] Permissions.
* [ ] Roles.
* [ ] Sanctum.
* [ ] Validation.
* [ ] API contracts.
* [ ] Pagination.
* [ ] Filtering.
* [ ] Sorting.
* [ ] Error contracts.
* [ ] Complete presentation authorization behavior.

## Rules

* [ ] Controllers remain thin across complete API surface.
* [ ] Authorization explicit.
* [ ] Validation separated from business logic.
* [ ] Presentation does not own domain rules.

**Exit Gate:** Presentation and Authorization GREEN.

---

# 10. TEST ARCHITECTURE & FULL REGRESSION

**Status:** ACTIVE AS A CONTINUOUS GATE / CURRENT REGRESSION GREEN

## Objective

Maintain final confidence that architecture and behavior remain GREEN.

## Test Layers

* [x] Unit
* [x] Feature
* [x] Integration coverage where available
* [x] Architecture
* [x] Module
* [x] Workflow
* [x] Action
* [x] Repository
* [x] Policy
* [x] Regression

## Required Sequence

```text
Targeted Tests

↓

Module Regression

↓

Full Test Suite

↓

GREEN
```

## Current Full Regression

```text
546 passed

1416 assertions

0 failures

PHPUnit Notices: 5
```

This is the current project-wide Green Gate.

### Reports Regression Correction

The Reports `ExecuteReportAction` regression correction was validated through:

```text
ExecuteReportActionTest

3 tests
20 assertions
OK
```

Reports regression suite:

```text
24 tests
90 assertions
OK
```

Full project regression:

```text
546 tests
1416 assertions
0 failures
PHPUnit Notices: 5
```

The 5 PHPUnit Notices are non-failing notices and do not invalidate the GREEN test gate.

### Important Regression Correction

The old baseline:

```text
528 passed

2 failed

1245 assertions
```

is historical evidence and is no longer the current regression state.

The two former `TenantScopeTest` failures were resolved as test/fixture drift through a minimal test-only correction.

Current state:

```text
TenantScopeTest

5 passed

8 assertions
```

Production TenantContext runtime:

```text
1 passed

3 assertions
```

No production Tenant Boundary change was required.

**Current Regression Verdict:** GREEN

---

# 11. DOCUMENTATION & OPERATIONAL READINESS

**Status:** PENDING

## Objective

Documentation must reflect actual GREEN code.

## Required Documentation

* [ ] `PROJECT_BIBLE.md`
* [ ] `PROJECT_STATE.md`
* [ ] `PROJECT_SUMMARY.md`
* [ ] `ARCHITECTURE.md`
* [ ] `STATISTICS.md`
* [ ] `BUSINESS_RULES.md`
* [ ] `MODELS_FULL.md`
* [ ] `SERVICES_FULL.md`
* [ ] `CONTROLLERS_FULL.md`
* [ ] `ROUTES_FULL.md`
* [ ] `SERVICE_USAGE.md`
* [ ] `MODEL_RELATIONS.md`
* [ ] `DEPENDENCY_GRAPH.md`
* [ ] `DATABASE.md`
* [ ] `MIGRATIONS.md`
* [ ] `MODULES.md`
* [ ] `HANDOVER.md`
* [ ] `TODO.md`
* [ ] `INDEX.md`
* [ ] `AI_START_PROMPT.md`
* [x] `MASTER_ROADMAP.md`

## Operational Readiness

* [x] Subscription scheduler registration verified.
* [x] Kernel cache lifecycle verified.
* [x] Kernel cache-clear runtime verified.
* [x] TenantContext runtime verified.
* [ ] Complete queue production behavior.
* [ ] Complete RouterOS runtime behavior.
* [ ] Complete runtime command inventory.
* [ ] Error logging reviewed.
* [ ] No unexplained recurring runtime errors remain.
* [ ] Backup / restore operational verification.
* [ ] Production monitoring verification.

**Exit Gate:** Documentation and operational state accurately reflect GREEN architecture.

---

# 12. FINAL ARCHITECTURE CERTIFICATION

**Status:** PENDING

Final audit after all remaining roadmap phases are completed.

## Certification Checklist

* [ ] Architecture GREEN.
* [x] Core GREEN.
* [x] Kernel GREEN.
* [x] Module boundaries GREEN for audited scope.
* [x] Aggregate ownership GREEN for audited scope.
* [x] Legacy boundaries GREEN for audited scope.
* [x] Application architecture GREEN for audited scope.
* [x] Cross-module architecture GREEN for audited scope.
* [x] Billing / Subscription lifecycle GREEN.
* [x] Invoice ownership GREEN.
* [x] Subscription failure / rollback GREEN.
* [ ] Remaining business rules GREEN.
* [ ] Infrastructure GREEN.
* [ ] Network integration GREEN.
* [ ] Presentation GREEN.
* [ ] Authorization GREEN across complete surface.
* [x] Current full PHPUnit regression GREEN.
* [ ] Documentation GREEN.
* [ ] Operational readiness GREEN.
* [ ] No unexplained architectural gaps.
* [x] Deferred items explicitly documented.
* [ ] Final certification regression suite GREEN.

When every item passes:

# EGYPTNET — ARCHITECTURE COMPLETE

---

# CHANGE CONTROL

## Rule 1 — Architecture First

Never modify architecture before auditing the current implementation.

## Rule 2 — Gap / No Gap

Every proposed change must answer:

> Is there an architectural gap?

If:

```text
NO GAP
```

Then:

```text
Do not change the code.
```

## Rule 3 — Minimal Fix

Fix only the verified GAP.

## Rule 4 — Evidence First

Evidence must come from:

* source code
* references
* tests
* architecture checks
* generated documentation
* ADRs
* runtime evidence

## Rule 5 — Green Gate

A phase is not DONE until its targeted tests are GREEN.

## Rule 6 — Stop Condition

When:

```text
Contract ✓

Implementation ✓

Evidence ✓

Targeted Tests ✓

Regression ✓

Runtime Evidence ✓
```

Then:

```text
GREEN

DONE

STOP
```

## Rule 7 — No Speculation

Unknown historical work is recorded as UNKNOWN.

It is never converted into an invented implementation task.

## Rule 8 — No Regression of Completed Work

A completed phase remains DONE.

It is reopened only if new evidence demonstrates an actual regression.

## Rule 9 — Sequential Execution

Only one phase is actively executed at a time.

Do not jump forward.

Do not reopen unrelated completed phases.

## Rule 10 — Roadmap Update

At the end of every phase record:

* Phase
* Objective
* Findings
* Changes
* Evidence
* Tests
* Status
* Deferred Items
* Current Execution Position

---

# CURRENT EXECUTION POSITION

## Current Phase

**Phase 7 — Business Rules & State Machines**

**Status:** `[ ] ACTIVE — BROADER DOMAIN VALIDATION`

Phase 6 — Billing & Subscription Domain remains:

```text
[x] CLOSED / GREEN
```

No Phase 6 reopening has occurred.

### Completed Previous Phase

* [x] Subscription lifecycle ownership.
* [x] Activate / Suspend / Grace / Expire / Renew / Restore.
* [x] Renewal scheduler / command lifecycle.
* [x] Queue boundary audited.
* [x] Failure / rollback behavior verified.
* [x] Cross-module boundaries audited.
* [x] Invoice creation ownership verified.
* [x] Renewal invoice idempotency verified.
* [x] Payment interaction audited.
* [x] Wallet interaction audited.
* [x] Runtime scheduler verified.
* [x] Reports ExecuteReportAction regression correction completed.
* [x] Targeted tests GREEN.
* [x] Full regression GREEN.
* [x] Green Gate achieved.

## Current Evidence

### Renewal / Invoice

```text
9 passed

21 assertions
```

### Payment Boundary

```text
2 passed

6 assertions
```

### Rollback

```text
1 passed

4 assertions
```

### Reports ExecuteReportAction

```text
3 tests

20 assertions

OK
```

### Reports Module Regression

```text
24 tests

90 assertions

OK
```

### Scheduler

```text
5  0 * * *  php artisan subscriptions:auto-renew

10 0 * * *  php artisan subscriptions:auto-grace

15 0 * * *  php artisan subscriptions:auto-expire
```

```text
withoutOverlapping()
```

### TenantScope

```text
5 passed

8 assertions
```

### TenantContext Runtime

```text
1 passed

3 assertions
```

### Authorization

```text
29 passed

70 assertions
```

### Full Regression

```text
546 passed

1416 assertions

0 failures

PHPUnit Notices: 5
```

---

# ARCHITECTURAL POSITION

The following boundaries are closed and must not be reopened without new regression evidence:

```text
Core / Kernel

Module Registry

Module Loader

Module Discovery

Module Source

Module Manifest

Module Resources

Manifest Collection / Compilation

Network Provider registration

Network Provider Resolver

Network Infrastructure service placement

NetworkDevice repository boundary

Network Controller → NetworkDevice persistence

Security / Authorization Policy ownership

Legacy app/Models

Legacy app/Services

Legacy Workflows

Duplicate model wrappers

Customer Module cleanup

Invoice CRUD architecture

Payment CRUD architecture

Package CRUD architecture

UsageSnapshot ownership

Subscription Lifecycle

Invoice ownership

Renewal Invoice idempotency

Payment / Wallet interaction boundary

Subscription rollback boundary

Reports ExecuteReportAction persistence boundary
```

---

# DEFERRED ITEMS

Deferred items are not failures.

They must be handled only inside their owning roadmap phase.

Current deferred/remaining architectural items include:

```text
JournalEntry

ActivityLog

Notification

WalletTransaction
```

Additional broader remaining work:

```text
Complete Business Rules audit

Complete Infrastructure audit

Complete RouterOS runtime audit

Complete API / Presentation audit

Complete Documentation audit

Complete Operational Readiness

Final Architecture Certification
```

No deferred item authorizes speculative refactoring in a completed phase.

---

# NEXT CONCRETE WORK

The next execution phase is:

```text
Phase 7 — Business Rules & State Machines
```

### Immediate Action

```text
Payment Business Rules

→ Quick Audit

→ Business Rule Inventory

→ Ownership Classification

→ State Transition Audit

→ Gap / No Gap

→ Minimal Fix only if GAP exists

→ Targeted Tests

→ Regression

→ Runtime Evidence where applicable

→ Green Gate

→ STOP
```

### First Audit Target

**Payment business rules**

Customer lifecycle and Invoice business rules are CLOSED / DONE / GREEN. The next domain is Payment business rules.


Begin with the remaining business-rule surface **outside the already-closed Subscription/Billing lifecycle scope**.

Do not reopen Phase 6.

Do not modify Subscription lifecycle code without new regression evidence.

---

# PROJECT COMPLETION EQUATION

```text
Architecture

*

Core

*

Kernel

*

Modules

*

Ownership

*

Application

*

Business Rules

*

Infrastructure

*

Network

*

Presentation

*

Authorization

*

Tests

*

Documentation

*

Operational Readiness

*

Roadmap

=

GREEN
```

---

# FINAL PRINCIPLE

EgyptNet is not finished because the tests pass alone.

EgyptNet is finished only when:

1. Architecture is GREEN.
2. Ownership is GREEN.
3. Application boundaries are GREEN.
4. Business behavior is GREEN.
5. Infrastructure is GREEN.
6. Network integration is GREEN.
7. Presentation and authorization are GREEN.
8. Tests are GREEN.
9. Documentation is GREEN.
10. Operational readiness is GREEN.
11. Final Architecture Certification is GREEN.

Then, and only then:

# EGYPTNET — PROJECT COMPLETE
