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

### Historical Kernel Evidence

Historical Kernel checkpoints remain historical evidence only.

The later project regression checkpoints supersede them as current project state.

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

Finance

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

Historical Phase 6 regression:

```text
546 tests

1416 assertions

0 failures

PHPUnit Notices: 5
```

The 5 PHPUnit Notices were non-failing notices and did not invalidate the historical GREEN test gate.

**Regression Correction Verdict:** GREEN / CLOSED

> **Decision:** This correction is complete. Do not reopen the ReportExport migration, Phase 6, or the broader architecture audit without new regression evidence or an explicit architectural contract change.

---

## Phase 6 Green Gate

Historical Phase 6 evidence:

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

**Status:** CLOSED / GREEN

Phase 6 already proved the Subscription lifecycle path.

Phase 7 completed the broader business-rule audit across the remaining domains.

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
* [x] Cancellation — verified / GREEN
* [x] Activation / Deactivation — verified / NO GAP
* [x] Remaining domain-specific rules

Remaining domain-specific evidence:

```text
Inventory business-rule coverage: 4 tests / 8 assertions.

Ticket business-rule coverage: 6 tests / 13 assertions.

Task: existing business-rule coverage verified — NO GAP / GREEN.

Reports: no Phase-7 business-state gap.

Usage: no Phase-7 business-state gap.
```

Phase 7 final regression:

```text
578 passed

1492 assertions

0 failures
```

Phase 7 full regression duration:

```text
406.92s
```

## Activation / Deactivation Evidence

* Activation verified as a complete Subscription lifecycle operation:

  `SubscriptionStatus::ACTIVE` + `ActivateSubscriptionAction` + `ActivateWorkflow` + `SubscriptionActivated` + `SubscriptionPolicy::activate()` + controller endpoint + route + tests.

* Deactivation was audited against the Subscription domain state machine.

* No `DEACTIVATED` Subscription state exists in the domain.

* No Subscription `deactivate()` transition, Action, Workflow, Event, Policy, endpoint, route, or test exists.

* `SUSPENDED` is the existing explicit non-active Subscription lifecycle state, with `ACTIVE → SUSPENDED → ACTIVE` transitions and corresponding Network disable/enable behavior.

* No domain evidence defines Subscription Deactivation as a separate business operation.

* Therefore no new `DEACTIVATED` state or Deactivation use case was introduced; doing so would invent an unsupported business rule.

* Decision: **NO GAP / GREEN**.

## Cancellation Evidence

* Confirmed GAP: no executable cancellation use case existed.
* Added `CancelSubscriptionAction`.
* Added `CancelWorkflow`.
* Added `SubscriptionCancelled`.
* Added `SubscriptionPolicy::cancel()`.
* Added `POST /subscriptions/{subscription}/cancel`.
* Added `subscriptions.cancel` permission for Super Admin.
* Added controller feature coverage.
* Targeted tests: **9 passed / 145 assertions**.
* Full regression at Phase 7 cancellation checkpoint: **568 passed / 1471 assertions**.
* No Network cancellation listener was introduced; no cross-module behavior was inferred without evidence.

## Validate

* [x] Business rules.
* [x] State transitions.
* [x] Domain Services.
* [x] Aggregate transitions.
* [x] Domain Events.
* [x] Scheduled operations outside completed Phase 6 scope — no Phase-7 GAP identified.
* [x] Error handling across remaining domains.

**Exit Gate:** Business rules have clear owners and executable tests.

**Phase 7 Verdict: CLOSED / GREEN**

> **Decision:** Do not reopen Phase 7 without new regression evidence or an explicit business-rule contract change.

---

# 8. INFRASTRUCTURE & NETWORK INTEGRATION

**Status:** [x] CLOSED / GREEN

## Objective

Ensure Infrastructure owns framework and external-system concerns.

## Verified Sub-Boundaries

* [x] Network Provider registration boundary — NO GAP.
* [x] Network Provider Resolver — NO GAP.
* [x] Network services Infrastructure placement — NO GAP.
* [x] NetworkDevice repository boundary — NO GAP.
* [x] Network Controller → NetworkDevice persistence — GREEN / CLOSED.

These completed sub-boundaries were followed by the complete Phase 8 Infrastructure / Network audit.

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

---

## Phase 8 Audit Progress

### Audit 1 — MikroTik Runtime Connection Behavior

* [x] NetworkManager connection boundary verified.
* [x] NetworkProviderResolver verified.
* [x] MikroTikProvider verified.
* [x] MikroTikConnectionService verified as the sole RouterOS client creator.
* [x] Connection failure handling verified.
* [x] NetworkModule bindings verified.
* [x] Adapter boundary verified.
* [x] Targeted evidence GREEN.
* [x] No RouterOS client creation outside the Infrastructure boundary.

**Status: CLOSED / GREEN**

### Audit 2 — RouterOS API Integration

* [x] RouterOS `Client` creation centralized.
* [x] RouterOS `Query` creation remains inside Network Infrastructure services.
* [x] Query execution centralized through `MikroTikQueryService`.
* [x] No RouterOS references outside the Network boundary, except documentation evidence.
* [x] RouterOS API integration tests GREEN.

**Status: CLOSED / GREEN**

### Audit 3 — PPPoE Lifecycle

* [x] PPPoE service contract verified.
* [x] `/ppp/secret/*` lifecycle verified.
* [x] `/ppp/active/*` session handling verified.
* [x] Subscription Network lifecycle listener verified.
* [x] Subscription layer contains no direct RouterOS integration.
* [x] NetworkModule/provider/adapter boundaries verified.
* [x] Tests GREEN.

**Status: CLOSED / GREEN**

### Audit 4 — Hotspot Lifecycle

* [x] Hotspot service contract verified.
* [x] `/ip/hotspot/user/*` lifecycle verified.
* [x] `/ip/hotspot/active/*` session handling verified.
* [x] Hotspot subscription lifecycle listener verified.
* [x] Empty username produces no RouterOS side effect.
* [x] SubscriptionModule registration verified.
* [x] Tests GREEN.

**Status: CLOSED / GREEN**

### Audit 5 — Profiles

* [x] Profile references classified as assignment/configuration.
* [x] No unsupported RouterOS profile CRUD requirement identified.
* [x] `mikrotik_profile` classified as subscription/package/user configuration.
* [x] No infrastructure ownership GAP identified.

**Status: CLOSED / GREEN**

### Audit 6 — Queues / Speed Enforcement

* [x] Queue service contract verified.
* [x] RouterOS `/queue/simple/*` boundary verified.
* [x] `updateSpeed()` mapping verified.
* [x] Adapter delegation verified.
* [x] Queue controller boundary verified.
* [x] Speed enforcement behavior verified.

**Status: CLOSED / GREEN**

### Audit 7 — Synchronization

* [x] Synchronization ownership moved to Network Module.
* [x] `SyncMikroTikUsersAction` established.
* [x] `SyncHotspotUsersAction` established.
* [x] `mikrotik:sync` established.
* [x] `mikrotik:sync-hotspot` established.
* [x] NetworkModule owns registration and schedules.
* [x] Legacy Console Kernel sync registrations removed.
* [x] Legacy sync commands/jobs removed.
* [x] Schedule uses `withoutOverlapping()`.

Evidence:

```text
Targeted gate:

7 passed / 51 assertions

Full regression at synchronization checkpoint:

585 passed / 1543 assertions / 0 failures

Runtime scheduler evidence:

GREEN
```

**Status: CLOSED / GREEN**

### Audit 8 — Disconnect / Expiry Enforcement

* [x] `SubscriptionExpired` boundary audited.
* [x] Subscription expiry disables the PPPoE user.
* [x] Active PPPoE session is disconnected.
* [x] PPPoE active sessions are removed through RouterOS `/ppp/active/remove`.
* [x] `MikrotikServiceInterface::disconnectUser()` delegates correctly.
* [x] Auto-expiry orchestrator expectation verified.
* [x] Runtime command/schedule registration verified.
* [x] No real RouterOS mutation side effects executed during runtime evidence.

Evidence:

```text
Targeted listener gate:

6 passed / 8 assertions

AutoExpireSubscriptionsOrchestratorTest:

2 passed / 4 assertions

Full regression:

585 passed / 1544 assertions / 0 failures
```

**Status: CLOSED / GREEN**

### Audit 9 — Runtime Router Evidence

Runtime device:

```text
MikroTik Router 1

NetworkDevice ID: 1

Type: mikrotik

Endpoint: 2.2.2.2:8728
```

Runtime path verified:

```text
NetworkManagerInterface

→ NetworkManager

→ NetworkProviderResolver

→ MikroTikProvider

→ MikroTikConnectionService

→ RouterOS
```

Runtime evidence:

```text
CONNECT_RESULT=SUCCESS

CONNECTED_STATE=CONNECTED

PROVIDER=mikrotik

CONNECTED_AFTER_DISCONNECT=DISCONNECTED
```

Capabilities:

```text
pppoe,queue,hotspot,firewall,dhcp,monitoring
```

The RouterOS connection test used:

```text
/system/resource/print
```

No RouterOS mutation commands were executed.

**Status: CLOSED / GREEN**

### Audit 10 — Infrastructure Failure Handling

* [x] RouterOS read failures no longer become silent empty collections.
* [x] `MikroTikQueryService::execute()` raises `QueryException` on RouterOS query failure.
* [x] `first()` preserves `null` only for a successful empty result.
* [x] `write()` continues to return `false` on write failure.
* [x] `MikroTikException` supports the context required by `QueryException`.
* [x] PPPoE synchronization failure does not mark existing users offline.
* [x] Hotspot synchronization failure does not mark existing users offline.
* [x] Failed reads do not advance synchronization timestamps.

Targeted Network regression:

```text
32 passed

101 assertions

0 failures
```

Historical Audit 10 regression checkpoint:

```text
587 passed

1558 assertions

0 failures
```

Runtime evidence:

```text
CONNECT_RESULT=SUCCESS

CONNECTED_STATE=CONNECTED

PROVIDER=mikrotik

CONNECTED_AFTER_DISCONNECT=DISCONNECTED
```

Runtime evidence used only the read-only RouterOS connection health path.

No RouterOS mutation commands were executed.

**Status: CLOSED / GREEN**

### Audit 11 — Fail-safe Behavior

**Status: CLOSED / GREEN**

Audit 11 verified failure behavior for RouterOS write operations and listener propagation.

Audit sequence completed:

```text
Infrastructure / Network boundary inventory

→ Runtime ownership classification

→ Failure-state analysis

→ Gap / No Gap

→ Minimal Fix

→ Targeted Tests

→ Regression

→ Runtime Evidence

→ Green Gate

→ STOP
```

Verified:

* [x] MikroTik PPPoE write-result propagation.
* [x] MikroTik Hotspot write-result propagation.
* [x] Queue/write-result propagation through the established Network boundary.
* [x] Adapter result propagation.
* [x] Subscription lifecycle listeners do not silently ignore failed RouterOS writes.
* [x] Hotspot subscription lifecycle listener does not silently ignore failed RouterOS writes.
* [x] Existing `MikroTikException` convention reused.
* [x] No new write-failure-specific exception hierarchy introduced.
* [x] EventBus does not swallow listener exceptions.
* [x] EventDispatcher exception propagation verified.
* [x] Failure behavior is fail-fast where the infrastructure contract requires successful external state transition.
* [x] No false successful state advancement was introduced.

### Audit 11 Minimal Fix

The verified GAP was limited to lifecycle listeners ignoring `false` results returned by Network infrastructure write operations.

Minimal correction:

```text
SubscriptionNetworkLifecycleListener

→ checks enableUser()

→ checks disableUser()

→ checks disconnectUser()

HotspotSubscriptionNetworkLifecycleListener

→ checks enableUser()

→ checks disableUser()
```

Failed writes now raise the existing:

```text
App\Exceptions\Network\MikroTikException
```

with operation context.

No unrelated Network architecture was changed.

### Audit 11 Test Evidence

Targeted listener tests:

```text
15 passed

32 assertions
```

Network regression:

```text
38 passed

121 assertions
```

Historical project-wide regression at Audit 11:

```text
593 passed

1578 assertions

0 failures

Duration: 477.61s
```

### Audit 11 Runtime Evidence

An isolated EventBus runtime probe registered only the Network listener and used a mocked `MikrotikServiceInterface` returning `false`.

Evidence:

```text
EVENT=App\Modules\Subscription\Domain\Events\SubscriptionActivated

LISTENERS=1

DISPATCHING...

RESULT=MIKROTIK_EXCEPTION

MESSAGE=Failed to enable PPPoE user on MikroTik.

CODE=500

CONTEXT={"username":"runtime-a11-user","event":"App\\Modules\\Subscription\\Domain\\Events\\SubscriptionActivated"}
```

The runtime evidence confirms:

```text
EventDispatcher

→ Network listener

→ MikrotikServiceInterface

→ enableUser() = false

→ MikroTikException

→ exception propagated
```

No real RouterOS mutation was executed during this probe.

**Audit 11 Verdict: CLOSED / GREEN**

> **Decision:** Do not reopen Audit 11 without new evidence of regression or an explicit infrastructure contract change.

### Audit 12 — Remaining Scheduled Infrastructure Operations

**Status: CLOSED / GREEN**

Audit 12 completed the remaining scheduled infrastructure-operation inventory and runtime verification.

### Objective

Audit all remaining scheduled infrastructure operations and determine whether ownership, registration, execution boundary, and runtime behavior are correctly placed.

### Inventory Findings

Verified candidates included:

```text
app/Console/Kernel.php

app/Console/Commands/PingMikroTik.php

app/Console/Commands/CleanupMikroTik.php

app/Console/Commands/SendDailyReport.php
```

Current module-owned schedules were also verified across:

```text
Network

Subscription

Usage
```

### Audit Findings

```text
A12.1 Module schedules

NO GAP / GREEN

A12.2 Root scheduled operations

GAP CONFIRMED

A12.3 Module runtime schedule registration

GREEN

A12.4 Runtime schedule inventory

GREEN

A12.5 Legacy command availability

GREEN
```

### Confirmed GAP

`app/Console/Kernel.php` contained stale root schedule definitions for:

```text
mikrotik:ping

mikrotik:cleanup

report:daily
```

Runtime evidence established that these commands were not active in the runtime scheduler.

The active runtime schedule was already owned by the appropriate Modules:

```text
Network

→ mikrotik:sync

→ mikrotik:sync-hotspot

Usage

→ usage:sync

Subscription

→ subscriptions:auto-renew

→ subscriptions:auto-grace

→ subscriptions:auto-expire
```

### Minimal Fix

* [x] Removed only the stale root schedule definitions from `app/Console/Kernel.php`.
* [x] Kept `PingMikroTik.php`.
* [x] Kept `CleanupMikroTik.php`.
* [x] Kept `SendDailyReport.php`.
* [x] Preserved manual availability of the legacy commands.
* [x] Did not move commands speculatively into Modules.
* [x] Did not delete command functionality without evidence.
* [x] Did not modify Network, Subscription, or Usage schedule ownership.

### Targeted Tests

Network registration:

```text
3 passed

8 assertions
```

Usage registration:

```text
4 passed

10 assertions
```

### Root Schedule Verification

No legacy root schedule registration remains.

The only remaining references in `app/Console/Commands` are command signatures:

```text
mikrotik:cleanup

mikrotik:ping

report:daily
```

These remain manually available and are not registered as active runtime schedules.

### Runtime Schedule Evidence

After the minimal fix:

```text
*/5  * * * *  php artisan mikrotik:sync-hotspot

*/5  * * * *  php artisan mikrotik:sync

*/15 * * * *  php artisan usage:sync

5    0 * * *  php artisan subscriptions:auto-renew

10   0 * * *  php artisan subscriptions:auto-grace

15   0 * * *  php artisan subscriptions:auto-expire
```

Exactly six runtime schedules remain.

### Legacy Command Availability

The following commands remain manually available:

```text
mikrotik:ping

mikrotik:cleanup

report:daily
```

No runtime schedule registration remains for them.

### Schedule Runtime Rule

Schedule is a runtime resource.

It is not treated as a compiled resource.

No scheduled command was executed during Audit 12 validation.

No RouterOS mutation was performed.

Runtime evidence used:

```text
php artisan schedule:list

php artisan list
```

### Audit 12 Full Regression

```text
593 passed

1578 assertions

0 failures

Duration: 334.18s
```

This regression remains the historical Phase 8 / Audit 12 checkpoint.

**Audit 12 Verdict: CLOSED / GREEN**

> **Decision:** The only proven Audit 12 GAP was stale root schedule registration. It was removed minimally. Legacy command files remain available manually. No speculative command migration or deletion is authorized.

---

## Phase 8 Exit Gate

* [x] Infrastructure runtime behavior GREEN.
* [x] Network integration GREEN.
* [x] RouterOS integration GREEN.
* [x] Synchronization GREEN.
* [x] Disconnect / expiry enforcement GREEN.
* [x] Infrastructure failure handling GREEN.
* [x] Fail-safe behavior GREEN.
* [x] Remaining scheduled infrastructure operations GREEN.
* [x] Runtime schedule inventory GREEN.
* [x] Targeted tests GREEN.
* [x] Full regression GREEN.
* [x] Runtime evidence GREEN.
* [x] Phase 8 CLOSED.

### Final Phase 8 Regression

```text
593 passed

1578 assertions

0 failures

Duration: 334.18s
```

**Phase 8 Verdict: CLOSED / GREEN**

> **Decision:** Phase 8 is complete. Do not reopen Phase 8 or Audits 1–12 without new evidence proving regression or an explicit architectural decision change.

---

## Remaining Infrastructure Scope

* [x] MikroTik runtime connection behavior
* [x] RouterOS API integration
* [x] PPPoE lifecycle
* [x] Hotspot lifecycle
* [x] Profiles
* [x] Queues / speed enforcement
* [x] Synchronization
* [x] Disconnect / expiry enforcement
* [x] Runtime router evidence
* [x] Infrastructure failure handling
* [x] Fail-safe behavior
* [x] Remaining scheduled infrastructure operations

**Special Rule**

Schedule is a runtime resource.

It must not be incorrectly treated as a compiled resource.

**Exit Gate:** Infrastructure and Network runtime behavior GREEN.

---

# 9. API / PRESENTATION / AUTHORIZATION

**Status: [~] IN PROGRESS — BROADER PRESENTATION SURFACE**

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

---

## GAP-9.1 — API Authentication Exposure

**Status: CLOSED / GREEN**

The previously identified public API exposure was limited to:

```text
api/hotspot/*
api/dashboard/stats
api/tasks/*
```

These routes were outside the required `auth:sanctum` boundary.

### Minimal Fix

* [x] Protected the affected routes with `auth:sanctum`.
* [x] Preserved existing route behavior.
* [x] No authorization model was invented as part of authentication hardening.

### Runtime Evidence

Protected routes were verified through Laravel runtime route inspection:

```text
api/hotspot/online
api/hotspot/stats
api/dashboard/stats
api/tasks/*
```

All verified routes resolve with:

```text
api
auth:sanctum
```

### Verdict

```text
GAP-9.1 = CLOSED / GREEN
```

Do not reopen GAP-9.1 without new evidence of regression or an explicit authentication contract change.

---

## GAP-9.2 — Network Mutation Application Boundary

**Status: CLOSED / GREEN**

### Confirmed GAP

Network DHCP, Firewall, and Queue controllers were directly executing mutation operations through the Network provider.

The confirmed gap was specifically the controller-to-provider mutation boundary.

Read-only provider paths were not part of this gap and were intentionally preserved.

### Minimal Fix

10 dedicated Network Application Actions were introduced:

```text
CreateDhcpLeaseAction
UpdateDhcpLeaseAction
DeleteDhcpLeaseAction

CreateFirewallRuleAction
UpdateFirewallRuleAction
DeleteFirewallRuleAction

CreateQueueAction
UpdateQueueAction
ToggleQueueAction
DeleteQueueAction
```

Existing synchronization Actions remain:

```text
SyncMikroTikUsersAction
SyncHotspotUsersAction
```

Therefore NetworkModule now registers 12 Actions in total.

### Application Boundary

The mutation flow is now:

```text
Controller
    ↓
Network Application Action
    ↓
NetworkManagerInterface
    ↓
NetworkManager
    ↓
NetworkProviderResolver
    ↓
MikroTikProvider
    ↓
Network Domain Service
    ↓
MikroTik Infrastructure
```

### Production Boundary Verification

* [x] DHCP mutation calls removed from controller.
* [x] Firewall mutation calls removed from controller.
* [x] Queue mutation calls removed from controller.
* [x] Mutation use-cases delegated to dedicated Application Actions.
* [x] NetworkModule registers all 12 Actions.
* [x] RouterOS implementation was not moved.
* [x] Read-only provider paths remain intentionally available.
* [x] No speculative Application Query migration was performed.
* [x] No unrelated Network architecture was changed.
* [x] Production Actions remain `final`.

Direct mutation verification returned no remaining controller mutation calls.

### Targeted Evidence

Network suite after the production boundary correction:

```text
9 passed
65 assertions
0 failures
Duration: 46.24s
```

Controller fixture regression correction:

```text
6 passed
27 assertions
0 failures
Duration: 21.05s
```

### Full Regression

Final project-wide regression after GAP-9.2:

```text
593 passed
1578 assertions
0 failures
Duration: 336.97s
```

Compared with the Phase 8 current checkpoint of `334.18s`, the current regression increased by approximately `2.79s`.

No performance regression requiring architectural action was identified.

### GAP-9.2 Verdict

```text
CLOSED / GREEN
```

> **Decision:** GAP-9.2 is complete. Do not reopen the Network mutation Application boundary without new evidence of regression or an explicit architectural contract change.

---

## GAP-9.3-A — HotspotSubscription Controller Authorization

**Status: CLOSED / GREEN**

### Objective

Verify that the `HotspotSubscriptionController` explicitly enforces the already-established `HotspotSubscriptionPolicy` contract.

No new permission model was introduced.

No new Policy was introduced.

The existing policy and permission architecture were reused.

### Existing Policy Contract

The existing `HotspotSubscriptionPolicy` provides:

```text
viewAny
view
create
update
delete
activate
suspend
```

The policy uses the established permission boundary:

```text
subscriptions.view
subscriptions.create
subscriptions.update
subscriptions.delete
subscriptions.activate
subscriptions.suspend
```

Super Admin continues to receive the established policy bypass through the existing authorization convention.

### Runtime Policy Contract Evidence

Runtime policy evaluation confirmed:

```text
=== HOTSPOT SUBSCRIPTION POLICY CONTRACT ===

USER_ID=1
HAS_SUPER_ADMIN=YES

viewAny => ALLOWED
create => ALLOWED

SUBSCRIPTION_ID=2

view => ALLOWED
delete => ALLOWED
activate => ALLOWED
suspend => ALLOWED
```

### Confirmed GAP

`HotspotSubscriptionController` exposed policy-protected operations without explicit controller authorization calls.

The Policy existed and was correctly registered, but the controller was not enforcing it consistently.

This was a real Presentation / Authorization boundary gap.

### Minimal Fix

Authorization was added only to the existing controller operations:

```text
index
    → authorize(viewAny)

store
    → authorize(create)

show
    → authorize(view)

destroy
    → authorize(delete)

suspend
    → authorize(suspend)

activate
    → authorize(activate)
```

### Production Boundary

The controller now follows:

```text
HTTP Request
    ↓
Sanctum Authentication
    ↓
Controller
    ↓
Policy Authorization
    ↓
Existing Action / Repository
```

No business logic was moved into the controller.

No Action architecture was changed.

No repository architecture was changed.

No permission names were invented.

### Production Verification

Controller authorization calls verified at:

```text
index
store
show
destroy
suspend
activate
```

PHP syntax verification:

```text
No syntax errors detected in
app/Http/Controllers/Api/HotspotSubscriptionController.php
```

### Unauthorized Endpoint Evidence

A dedicated authorization feature test was added.

Verified endpoints:

```text
GET    /api/hotspot-subscriptions
POST   /api/hotspot-subscriptions
GET    /api/hotspot-subscriptions/{hotspotSubscription}
DELETE /api/hotspot-subscriptions/{hotspotSubscription}
POST   /api/hotspot-subscriptions/{hotspotSubscription}/suspend
POST   /api/hotspot-subscriptions/{hotspotSubscription}/activate
```

Unauthorized requests:

```text
6 / 6
```

All returned:

```text
HTTP 403
```

### Targeted Evidence

Authorization and Policy tests:

```text
8 passed
15 assertions
0 failures
Duration: 104.88s
```

Coverage included:

```text
HotspotSubscriptionControllerAuthorizationTest

HotspotSubscriptionPolicyRegistrationTest
```

### Final Project-Wide Regression

```text
599 passed
1584 assertions
0 failures
Duration: 490.81s
```

The regression increase is primarily attributable to the newly added Feature authorization coverage and its execution cost.

No production performance refactor is justified by this test-duration change.

### GAP-9.3-A Verdict

```text
[x] CLOSED / GREEN
```

> **Decision:** GAP-9.3-A is complete.
>
> Do not reopen the HotspotSubscription authorization boundary without new regression evidence or an explicit architectural contract change.

---
## GAP-9.3-E — MikroTik Controller Authorization**

## Status: CLOSED / GREEN**

### Scope

MikroTik controller authorization was audited and enforced for the existing read / health endpoints without introducing a new Policy, middleware, or permission architecture.

### Existing Permission Contract

The existing permission contract provides:

* `mikrotik.view`
* `mikrotik.pppoe.view`
* `mikrotik.pppoe.create`
* `mikrotik.pppoe.update`
* `mikrotik.pppoe.delete`
* `mikrotik.hotspot.view`
* `mikrotik.hotspot.create`
* `mikrotik.hotspot.update`
* `mikrotik.hotspot.delete`

No new permission architecture was introduced.

### Controller Enforcement

`app/Http/Controllers/Api/MikrotikController.php`

* `test()` → `$this->authorize('mikrotik.view')`
* `pppoeUsers()` → `$this->authorize('mikrotik.pppoe.view')`
* `hotspotUsers()` → `$this->authorize('mikrotik.hotspot.view')`

Production syntax validation:

```text
No syntax errors detected in app/Http/Controllers/Api/MikrotikController.php
Test Evidence

Targeted MikroTik authorization:

6 passed
19 assertions
0 failures
Duration: 124.12s

Security regression:

77 passed
138 assertions
0 failures
Duration: 133.72s

Existing unit controller contract test adaptation:

1 passed
8 assertions
0 failures
Duration: 56.12s

Final project-wide regression:

634 passed
1643 assertions
0 failures
Duration: 545.01s
Verdict
MikroTik Controller Authorization
Targeted authorization tests
Security regression
Existing unit controller contract test
Full regression GREEN

Decision: GAP-9.3-E is CLOSED / GREEN and must not be reopened without new regression evidence or an explicit architectural contract change.

GAP-9.3-B — Remaining API / Presentation / Authorization Surface

Status: [~] CURRENT EXECUTION POSITION

GAP-9.3-B continues the Phase 9 presentation and authorization audit without reopening completed Phase 9 boundaries.

Completed GAP-9.3 Authorization Surfaces

The following authorization surfaces have already been audited and are CLOSED / GREEN:

GAP-9.3-A — HotspotSubscription Controller Authorization
[x] CLOSED / GREEN

GAP-9.3-B — Dashboard Controller Authorization
[x] CLOSED / GREEN

GAP-9.3-C — Reports Controller Authorization
[x] CLOSED / GREEN

GAP-9.3-D — Scheduled Reports Controller Authorization
[x] CLOSED / GREEN

GAP-9.3-E — MikroTik Controller Authorization
[x] CLOSED / GREEN

GAP-9.3-F — Notification Controller Authorization
[x] CLOSED / GREEN
Remaining Authorization Candidates

The remaining candidate identified by the controller authorization audit is:

Task

This candidate requires separate contract analysis.

No Policy or permission will be invented before evidence proves that it is required.

GAP-9.3-F — Notification Controller Authorization
[x] CLOSED / GREEN

Authorization contract:

NotificationController@index
    → authorize('notifications.view')

NotificationController@show
    → authorize('notifications.view')

NotificationController@markAsRead
    → authorize('notifications.read')

NotificationController@markAllAsRead
    → authorize('notifications.read')

NotificationController@destroy
    → authorize('notifications.delete')

Existing permissions were reused without introducing a new permission contract:

notifications.view
notifications.read
notifications.delete

Customer notification access remains separate and unchanged:

CustomerNotificationController
    → Sanctum authentication
    → customer-scoped notifications relationship

No new Policy, Middleware, Role, or Authorization abstraction was introduced.

Targeted authorization tests:

10 passed
13 assertions
0 failures
Duration: 100.96s

Security regression:

87 passed
151 assertions
0 failures
Duration: 227.62s

Full regression after Notification authorization:

644 passed
1656 assertions
0 failures
Duration: 558.87s
Verdict
Notification Controller Authorization
Existing notification permissions reused
Targeted authorization tests
Security regression
Full regression GREEN

Decision: GAP-9.3-F is CLOSED / GREEN and must not be reopened without new regression evidence or an explicit architectural contract change.

GAP-9.3-B — Dashboard Controller Authorization
[x] CLOSED / GREEN

Existing permissions:

dashboard.view
dashboard.statistics

Controller enforcement:

DashboardController@index
    → authorize('dashboard.view')

DashboardController@stats
    → authorize('dashboard.statistics')

Targeted authorization tests:

4 passed
13 assertions
0 failures
Duration: 63.48s

Security regression:

46 passed
92 assertions
0 failures
Duration: 127.99s

Full regression after Dashboard authorization:

603 passed
1597 assertions
0 failures
Duration: 360.93s

No new Policy, Core abstraction, middleware, or authorization mechanism was introduced.

GAP-9.3-C — Reports Controller Authorization
[x] CLOSED / GREEN

Existing permissions:

reports.dashboard
reports.revenue
reports.inventory
reports.invoices
reports.tickets

Controller enforcement:

dashboard()  → authorize('reports.dashboard')

revenue()    → authorize('reports.revenue')

invoices()   → authorize('reports.invoices')

inventory()  → authorize('reports.inventory')

tickets()    → authorize('reports.tickets')

Targeted Reports authorization:

10 passed
10 assertions
0 failures
Duration: 51.94s

Security regression:

56 passed
102 assertions
0 failures
Duration: 97.07s

Full regression after Reports authorization:

613 passed
1607 assertions
0 failures
Duration: 375.37s

All report routes remain under the existing auth:sanctum API context.

No new Report Policy, Core abstraction, middleware, or authorization mechanism was introduced.

GAP-9.3-D — Scheduled Reports Controller Authorization
[x] CLOSED / GREEN

Independent permission contract established:

scheduled_reports.view
scheduled_reports.create
scheduled_reports.update
scheduled_reports.delete
scheduled_reports.activate
scheduled_reports.deactivate

Role contract:

Super Admin / Tenant Admin
    → all six permissions

Manager
    → all six permissions

Accountant
    → scheduled_reports.view only

Controller enforcement:

index()      → scheduled_reports.view
store()      → scheduled_reports.create
show()       → scheduled_reports.view
update()     → scheduled_reports.update
destroy()    → scheduled_reports.delete
activate()   → scheduled_reports.activate
deactivate() → scheduled_reports.deactivate

Targeted Scheduled Reports authorization:

15 passed
17 assertions
0 failures
Duration: 55.38s

Security regression:

71 passed
119 assertions
0 failures
Duration: 98.03s

Full regression:

628 passed
1624 assertions
0 failures
Duration: 396.84s

No new Policy, Core abstraction, middleware, or authorization mechanism was introduced.

GAP-9.3-E — MikroTik Controller Authorization
[x] CLOSED / GREEN

Existing permissions:

mikrotik.view
mikrotik.pppoe.view
mikrotik.pppoe.create
mikrotik.pppoe.update
mikrotik.pppoe.delete
mikrotik.hotspot.view
mikrotik.hotspot.create
mikrotik.hotspot.update
mikrotik.hotspot.delete

Controller enforcement:

test()
    → authorize('mikrotik.view')

pppoeUsers()
    → authorize('mikrotik.pppoe.view')

hotspotUsers()
    → authorize('mikrotik.hotspot.view')

Targeted MikroTik authorization:

6 passed
19 assertions
0 failures
Duration: 124.12s

Security regression:

77 passed
138 assertions
0 failures
Duration: 133.72s

Existing unit controller contract test adaptation:

1 passed
8 assertions
0 failures
Duration: 56.12s

Full regression:

634 passed
1643 assertions
0 failures
Duration: 545.01s

No new Policy, Core abstraction, middleware, or authorization mechanism was introduced.

GAP-9.3-F — Notification Controller Authorization
[x] CLOSED / GREEN

Existing permissions:

notifications.view
notifications.read
notifications.delete

Controller enforcement:

index()
    → authorize('notifications.view')

show()
    → authorize('notifications.view')

markAsRead()
    → authorize('notifications.read')

markAllAsRead()
    → authorize('notifications.read')

destroy()
    → authorize('notifications.delete')

Targeted Notification authorization:

10 passed
13 assertions
0 failures
Duration: 100.96s

Security regression:

87 passed
151 assertions
0 failures
Duration: 227.62s

Full regression:

644 passed
1656 assertions
0 failures
Duration: 558.87s

No new Policy, Core abstraction, middleware, or authorization mechanism was introduced.

Important Classification Rule

The following are already classified and must not be reopened:

GAP-9.1 — API Authentication Exposure
[x] CLOSED / GREEN

GAP-9.2 — Network Mutation Application Boundary
[x] CLOSED / GREEN

GAP-9.3-A — HotspotSubscription Controller Authorization
[x] CLOSED / GREEN

GAP-9.3-B — Dashboard Controller Authorization
[x] CLOSED / GREEN

GAP-9.3-C — Reports Controller Authorization
[x] CLOSED / GREEN

GAP-9.3-D — Scheduled Reports Controller Authorization
[x] CLOSED / GREEN

GAP-9.3-E — MikroTik Controller Authorization
[x] CLOSED / GREEN

GAP-9.3-F — Notification Controller Authorization
[x] CLOSED / GREEN

Network DHCP / Firewall / Queue authorization is not reopened merely because those controllers were part of GAP-9.2.

Their Application mutation boundary is already GREEN.

Remaining Audit Sequence
Quick Audit
    ↓
Controller / Route Contract
    ↓
Existing Policy Evidence
    ↓
Existing Permission Evidence
    ↓
Existing Role Evidence
    ↓
Sanctum Authentication Evidence
    ↓
Ownership / Scope Evidence
    ↓
Request Validation Evidence
    ↓
Resource / Response Evidence
    ↓
API Contract Evidence
    ↓
Pagination / Filtering / Sorting Evidence
    ↓
Error Contract Evidence
    ↓
Gap / No Gap
    ↓
Minimal Fix only if GAP exists
    ↓
Targeted Tests
    ↓
Regression if production code changes
    ↓
Runtime Evidence
    ↓
Green Gate
    ↓
STOP
Current Rule

Do not create:

new Policy
new Permission
new Middleware
new Role
new Authorization abstraction

unless the audit proves that the existing architecture cannot satisfy the required authorization contract.

Remaining Presentation Audit

The broader Phase 9 presentation surface remains:

Controllers.
Requests.
Resources.
Responses.
Routes.
Policies.
Permissions.
Roles.
Sanctum.
Validation.
API contracts.
Pagination.
Filtering.
Sorting.
Error contracts.
Complete presentation authorization behavior.

Completed authorization surfaces:

API Authentication Exposure — GAP-9.1.
Network Mutation Application Boundary — GAP-9.2.
HotspotSubscription Controller Authorization — GAP-9.3-A.
Dashboard Controller Authorization — GAP-9.3-B.
Reports Controller Authorization — GAP-9.3-C.
Scheduled Reports Controller Authorization — GAP-9.3-D.
MikroTik Controller Authorization — GAP-9.3-E.
Notification Controller Authorization — GAP-9.3-F.
Ticket Authorization — GAP-9.3-G.
Hotspot Read Authorization — GAP-9.3-H.
Web Network Authorization — GAP-9.3-I.
Task Authorization — GAP-9.3-J.

Remaining authorization candidates:

None within the currently audited Phase 9 authorization scope.
Phase 9 Rules
Controllers remain thin across the complete API surface.
Authorization is explicit where the existing contract requires it.
Validation is separated from business logic.
Presentation does not own domain rules.
Existing policies and permissions are reused where valid.
No speculative authorization architecture is introduced.

Exit Gate: Presentation and Authorization GREEN.

10. TEST ARCHITECTURE & FULL REGRESSION

Status: ACTIVE AS A CONTINUOUS GATE / CURRENT REGRESSION GREEN

Objective

Maintain final confidence that architecture and behavior remain GREEN.

Test Layers
Unit
Feature
Integration coverage where available
Architecture
Module
Workflow
Action
Repository
Policy
Regression
Required Sequence
Targeted Tests
    ↓
Module Regression
    ↓
Full Test Suite
    ↓
GREEN
Current Full Regression
693 passed
1768 assertions
0 failures
Duration: 536.53s

This is the current project-wide regression Green Gate after GAP-9.3-J Task authorization.

Historical Phase 9 checkpoints remain historical evidence only.

Historical Regression Checkpoints

Phase 6:

546 passed
1416 assertions
0 failures
PHPUnit Notices: 5

Cancellation checkpoint:

568 passed
1471 assertions
0 failures

Phase 7 final:

578 passed
1492 assertions
0 failures

Synchronization checkpoint:

585 passed
1543 assertions
0 failures

Disconnect / expiry checkpoint:

585 passed
1544 assertions
0 failures

Audit 10 historical checkpoint:

587 passed
1558 assertions
0 failures

Audit 11 historical checkpoint:

593 passed
1578 assertions
0 failures
Duration: 477.61s

Audit 12 / Phase 8 historical checkpoint:

593 passed
1578 assertions
0 failures
Duration: 334.18s

Phase 9 GAP-9.2 checkpoint:

593 passed
1578 assertions
0 failures
Duration: 336.97s

Phase 9 GAP-9.3-A checkpoint:

599 passed
1584 assertions
0 failures
Duration: 490.81s

Phase 9 GAP-9.3-B Dashboard checkpoint:

603 passed
1597 assertions
0 failures
Duration: 360.93s

Phase 9 GAP-9.3-C Reports checkpoint:

613 passed
1607 assertions
0 failures
Duration: 375.37s

Phase 9 GAP-9.3-D Scheduled Reports checkpoint:

628 passed
1624 assertions
0 failures
Duration: 396.84s

Phase 9 GAP-9.3-E MikroTik checkpoint:

634 passed
1643 assertions
0 failures
Duration: 545.01s

Phase 9 GAP-9.3-F Notification checkpoint:

644 passed
1656 assertions
0 failures
Duration: 558.87s
GAP-9.3-A Authorization Evidence
HotspotSubscription Policy Contract
    GREEN

HotspotSubscription Policy Registration
    GREEN

Controller Authorization
    GREEN

Unauthorized Requests
    6 / 6 → HTTP 403

Targeted Tests
    8 passed / 15 assertions

Full Regression
    599 passed / 1584 assertions
GAP-9.3-B Dashboard Authorization Evidence
Dashboard authorization
    GREEN

Controller Authorization
    GREEN

Unauthorized Requests
    2 / 2 → HTTP 403

Authorized Requests
    2 / 2 → HTTP 200

Targeted Tests
    4 passed / 13 assertions

Full Regression
    603 passed / 1597 assertions
GAP-9.3-C Reports Authorization Evidence
Reports authorization
    GREEN

Controller Authorization
    GREEN

Unauthorized Requests
    5 / 5 → HTTP 403

Authorized Requests
    5 / 5 → HTTP 200

Targeted Tests
    10 passed / 10 assertions

Security Regression
    56 passed / 102 assertions

Full Regression
    613 passed / 1607 assertions
GAP-9.3-D Scheduled Reports Authorization Evidence
Scheduled Reports authorization
    GREEN

Controller Authorization
    GREEN

Unauthorized Requests
    verified by targeted authorization suite

Authorized Requests
    verified by targeted authorization suite

Role Contract
    Manager → full management permissions
    Accountant → view only

Targeted Tests
    15 passed / 17 assertions

Security Regression
    71 passed / 119 assertions

Full Regression
    628 passed / 1624 assertions
GAP-9.3-E MikroTik Authorization Evidence
MikroTik authorization
    GREEN

Controller Authorization
    GREEN

Unauthorized Requests
    verified by targeted authorization suite

Authorized Requests
    verified by targeted authorization suite

Targeted Tests
    6 passed / 19 assertions

Security Regression
    77 passed / 138 assertions

Existing Unit Controller Contract Test
    1 passed / 8 assertions

Full Regression
    634 passed / 1643 assertions
GAP-9.3-F Notification Authorization Evidence
Notification authorization
    GREEN

Controller Authorization
    GREEN

Unauthorized Requests
    verified by targeted authorization suite

Authorized Requests
    verified by targeted authorization suite

Existing Permission Contract
    notifications.view
    notifications.read
    notifications.delete

Targeted Tests
    10 passed / 13 assertions

Security Regression
    87 passed / 151 assertions

Full Regression
    644 passed / 1656 assertions
Reports Regression Correction

The Reports ExecuteReportAction regression correction was validated through:

ExecuteReportActionTest

3 tests
20 assertions
OK

Reports regression suite:

24 tests
90 assertions
OK

The historical Phase 6 regression was:

546 tests
1416 assertions
0 failures
PHPUnit Notices: 5

The 5 PHPUnit Notices were non-failing notices and did not invalidate that historical GREEN test gate.

Important Regression Correction

The old baseline:

528 passed
2 failed
1245 assertions

is historical evidence and is no longer the current regression state.

The two former TenantScopeTest failures were resolved as test/fixture drift through a minimal test-only correction.

Current TenantScope state:

5 passed
8 assertions

Production TenantContext runtime:

1 passed
3 assertions

No production Tenant Boundary change was required.

Current Regression Verdict: GREEN

11. DOCUMENTATION & OPERATIONAL READINESS

Status: PENDING

Objective

Documentation must reflect actual GREEN code.

Required Documentation
PROJECT_BIBLE.md
PROJECT_STATE.md
PROJECT_SUMMARY.md
ARCHITECTURE.md
STATISTICS.md
BUSINESS_RULES.md
MODELS_FULL.md
SERVICES_FULL.md
CONTROLLERS_FULL.md
ROUTES_FULL.md
SERVICE_USAGE.md
MODEL_RELATIONS.md
DEPENDENCY_GRAPH.md
DATABASE.md
MIGRATIONS.md
MODULES.md
HANDOVER.md
TODO.md
INDEX.md
AI_START_PROMPT.md
MASTER_ROADMAP.md
Operational Readiness
Subscription scheduler registration verified.
Kernel cache lifecycle verified.
Kernel cache-clear runtime verified.
TenantContext runtime verified.
Complete queue production behavior.
Complete RouterOS runtime behavior.
Complete runtime command inventory — Phase 8 Audit 12.
Error logging reviewed.
No unexplained recurring runtime errors remain.
Backup / restore operational verification.
Production monitoring verification.

Exit Gate: Documentation and operational state accurately reflect GREEN architecture.

12. FINAL ARCHITECTURE CERTIFICATION

Status: PENDING

Final audit after all remaining roadmap phases are completed.

Certification Checklist
Architecture GREEN.
Core GREEN.
Kernel GREEN.
Module boundaries GREEN for audited scope.
Aggregate ownership GREEN for audited scope.
Legacy boundaries GREEN for audited scope.
Application architecture GREEN for audited scope.
Cross-module architecture GREEN for audited scope.
Billing / Subscription lifecycle GREEN.
Invoice ownership GREEN.
Subscription failure / rollback GREEN.
Remaining business rules GREEN.
Infrastructure GREEN.
Network integration GREEN.
Presentation GREEN.
Authorization GREEN across complete surface.
Current full PHPUnit regression GREEN.
Documentation GREEN.
Operational readiness GREEN.
No unexplained architectural gaps.
Deferred items explicitly documented.
Final certification regression suite GREEN.

When every item passes:

EGYPTNET — ARCHITECTURE COMPLETE
CHANGE CONTROL
Rule 1 — Architecture First

Never modify architecture before auditing the current implementation.

Rule 2 — Gap / No Gap

Every proposed change must answer:

Is there an architectural gap?

If:

NO GAP

Then:

Do not change the code.
Rule 3 — Minimal Fix

Fix only the verified GAP.

Rule 4 — Evidence First

Evidence must come from:

source code
references
tests
architecture checks
generated documentation
ADRs
runtime evidence
Rule 5 — Green Gate

A phase is not DONE until its targeted tests are GREEN.

Rule 6 — Stop Condition

When:

Contract ✓

Implementation ✓

Evidence ✓

Targeted Tests ✓

Regression ✓

Runtime Evidence ✓

Then:

GREEN

DONE

STOP
Rule 7 — No Speculation

Unknown historical work is recorded as UNKNOWN.

It is never converted into an invented implementation task.

Rule 8 — No Regression of Completed Work

A completed phase remains DONE.

It is reopened only if new evidence demonstrates an actual regression.

Rule 9 — Sequential Execution

Only one phase is actively executed at a time.

Do not jump forward.

Do not reopen unrelated completed phases.

Rule 10 — Roadmap Update

At the end of every phase record:

Phase
Objective
Findings
Changes
Evidence
Tests
Status
Deferred Items
Current Execution Position
CURRENT EXECUTION POSITION
Current Phase

Phase 9 — API / Presentation / Authorization

Status: [x] CLOSED / GREEN

Phase 9 Progress
GAP-9.1 — API Authentication Exposure
[x] CLOSED / GREEN

GAP-9.2 — Network Mutation Application Boundary
[x] CLOSED / GREEN

GAP-9.3-A — HotspotSubscription Controller Authorization
[x] CLOSED / GREEN

GAP-9.3-B — Dashboard Controller Authorization
[x] CLOSED / GREEN

GAP-9.3-C — Reports Controller Authorization
[x] CLOSED / GREEN

GAP-9.3-D — Scheduled Reports Controller Authorization
[x] CLOSED / GREEN

GAP-9.3-E — MikroTik Controller Authorization
[x] CLOSED / GREEN

GAP-9.3-F — Notification Controller Authorization
[x] CLOSED / GREEN

GAP-9.3-G — Ticket Authorization
[x] CLOSED / GREEN

GAP-9.3-H — Hotspot Read Authorization
[x] CLOSED / GREEN

GAP-9.3-I — Web Network Authorization
[x] CLOSED / GREEN

GAP-9.3-J — Task Authorization
[x] CLOSED / GREEN

Remaining Presentation / Authorization Audit
[x] CLOSED / GREEN

Phase 9 final presentation / authorization audit completed.

Phase 8 — Infrastructure & Network Integration:

[x] CLOSED / GREEN

593 passed
1578 assertions
0 failures
Duration: 334.18s

Phase 7 — Business Rules & State Machines:

[x] CLOSED / GREEN

578 passed
1492 assertions
0 failures

Phase 6 — Billing & Subscription Domain:

[x] CLOSED / GREEN

No Phase 6 reopening has occurred.

No Phase 7 reopening has occurred.

No Phase 8 reopening has occurred.

No GAP-9.1 reopening has occurred.

No GAP-9.2 reopening has occurred.

No GAP-9.3-A reopening has occurred.

No GAP-9.3-B reopening has occurred.

No GAP-9.3-C reopening has occurred.

No GAP-9.3-D reopening has occurred.

No GAP-9.3-E reopening has occurred.

No GAP-9.3-F reopening has occurred.

Phase 9 Current Green Gate

710 passed
1817 assertions
0 failures
Duration: 508.57s

Final Phase 9 Green Gate:
- API authentication exposure verified
- Customer web authentication boundary verified
- Controller authorization surface verified
- Customer API ownership verified
- HotspotSubscription cross-tenant creation boundary verified
- Direct controller persistence audit GREEN
- Authorization / Policy / Permission classification GREEN
- Route middleware classification GREEN
- Presentation / Authorization remaining candidates: NONE
Phase 8 Final Evidence

All Phase 8 audits are closed:

Audit 1  — MikroTik Runtime Connection Behavior
[x] CLOSED / GREEN

Audit 2  — RouterOS API Integration
[x] CLOSED / GREEN

Audit 3  — PPPoE Lifecycle
[x] CLOSED / GREEN

Audit 4  — Hotspot Lifecycle
[x] CLOSED / GREEN

Audit 5  — Profiles
[x] CLOSED / GREEN

Audit 6  — Queues / Speed Enforcement
[x] CLOSED / GREEN

Audit 7  — Synchronization
[x] CLOSED / GREEN

Audit 8  — Disconnect / Expiry Enforcement
[x] CLOSED / GREEN

Audit 9  — Runtime Router Evidence
[x] CLOSED / GREEN

Audit 10 — Infrastructure Failure Handling
[x] CLOSED / GREEN

Audit 11 — Fail-safe Behavior
[x] CLOSED / GREEN

Audit 12 — Remaining Scheduled Infrastructure Operations
[x] CLOSED / GREEN
GAP-9.3-A Final Evidence

Policy runtime contract:

HAS_SUPER_ADMIN=YES

viewAny => ALLOWED
create => ALLOWED
view => ALLOWED
delete => ALLOWED
activate => ALLOWED
suspend => ALLOWED

Controller enforcement:

index    → authorize(viewAny)
store    → authorize(create)
show     → authorize(view)
destroy  → authorize(delete)
suspend  → authorize(suspend)
activate → authorize(activate)

Unauthorized endpoint verification:

6 / 6 → HTTP 403

Targeted tests:

8 passed
15 assertions
0 failures
Duration: 104.88s

Full regression:

599 passed
1584 assertions
0 failures
Duration: 490.81s

Verdict:

[x] GAP-9.3-A CLOSED / GREEN
GAP-9.3-B Final Evidence

Dashboard authorization:

[x] CLOSED / GREEN

Permissions:

dashboard.view
dashboard.statistics

Controller enforcement:

DashboardController@index
    → authorize('dashboard.view')

DashboardController@stats
    → authorize('dashboard.statistics')

Targeted tests:

4 passed
13 assertions
0 failures
Duration: 63.48s

Full regression:

603 passed
1597 assertions
0 failures
Duration: 360.93s

Verdict:

[x] GAP-9.3-B CLOSED / GREEN
GAP-9.3-C Final Evidence

Reports authorization:

[x] CLOSED / GREEN

Permissions:

reports.dashboard
reports.revenue
reports.inventory
reports.invoices
reports.tickets

Controller enforcement:

dashboard()  → authorize('reports.dashboard')
revenue()    → authorize('reports.revenue')
invoices()   → authorize('reports.invoices')
inventory()  → authorize('reports.inventory')
tickets()    → authorize('reports.tickets')

Targeted tests:

10 passed
10 assertions
0 failures
Duration: 51.94s

Security regression:

56 passed
102 assertions
0 failures
Duration: 97.07s

Full regression:

613 passed
1607 assertions
0 failures
Duration: 375.37s

Verdict:

[x] GAP-9.3-C CLOSED / GREEN
GAP-9.3-D Final Evidence

Scheduled Reports authorization:

[x] CLOSED / GREEN

Permissions:

scheduled_reports.view
scheduled_reports.create
scheduled_reports.update
scheduled_reports.delete
scheduled_reports.activate
scheduled_reports.deactivate

Role contract:

Super Admin / Tenant Admin
    → all six permissions

Manager
    → all six permissions

Accountant
    → scheduled_reports.view only

Controller enforcement:

index()      → scheduled_reports.view
store()      → scheduled_reports.create
show()       → scheduled_reports.view
update()     → scheduled_reports.update
destroy()    → scheduled_reports.delete
activate()   → scheduled_reports.activate
deactivate() → scheduled_reports.deactivate

Targeted tests:

15 passed
17 assertions
0 failures
Duration: 55.38s

Security regression:

71 passed
119 assertions
0 failures
Duration: 98.03s

Full regression:

628 passed
1624 assertions
0 failures
Duration: 396.84s

Verdict:

[x] GAP-9.3-D CLOSED / GREEN
GAP-9.3-E Final Evidence

MikroTik authorization:

[x] CLOSED / GREEN

Permissions:

mikrotik.view
mikrotik.pppoe.view
mikrotik.pppoe.create
mikrotik.pppoe.update
mikrotik.pppoe.delete
mikrotik.hotspot.view
mikrotik.hotspot.create
mikrotik.hotspot.update
mikrotik.hotspot.delete

Controller enforcement:

test()
    → authorize('mikrotik.view')

pppoeUsers()
    → authorize('mikrotik.pppoe.view')

hotspotUsers()
    → authorize('mikrotik.hotspot.view')

Targeted tests:

6 passed
19 assertions
0 failures
Duration: 124.12s

Security regression:

77 passed
138 assertions
0 failures
Duration: 133.72s

Existing unit controller contract test:

1 passed
8 assertions
0 failures
Duration: 56.12s

Full regression:

634 passed
1643 assertions
0 failures
Duration: 545.01s

Verdict:

[x] GAP-9.3-E CLOSED / GREEN
GAP-9.3-F Final Evidence

Notification authorization:

[x] CLOSED / GREEN

Permissions:

notifications.view
notifications.read
notifications.delete

Controller enforcement:

index()
    → authorize('notifications.view')

show()
    → authorize('notifications.view')

markAsRead()
    → authorize('notifications.read')

markAllAsRead()
    → authorize('notifications.read')

destroy()
    → authorize('notifications.delete')

Targeted tests:

10 passed
13 assertions
0 failures
Duration: 100.96s

Security regression:

87 passed
151 assertions
0 failures
Duration: 227.62s

Full regression:

644 passed
1656 assertions
0 failures
Duration: 558.87s

Verdict:

[x] GAP-9.3-F CLOSED / GREEN
Audit 11 Evidence

Targeted listener tests:

15 passed
32 assertions

Network regression:

38 passed
121 assertions

Historical project-wide checkpoint:

593 passed
1578 assertions
0 failures
Duration: 477.61s
Audit 12 Evidence

Targeted Network registration:

3 passed
8 assertions

Targeted Usage registration:

4 passed
10 assertions

Runtime schedule:

*/5  * * * *  php artisan mikrotik:sync-hotspot
*/5  * * * *  php artisan mikrotik:sync
*/15 * * * *  php artisan usage:sync
5    0 * * *  php artisan subscriptions:auto-renew
10   0 * * *  php artisan subscriptions:auto-grace
15   0 * * *  php artisan subscriptions:auto-expire

Exactly six active runtime schedules remain.

Legacy commands remain manually available:

mikrotik:ping
mikrotik:cleanup
report:daily

They are not registered in the active runtime scheduler.

ARCHITECTURAL POSITION

The following boundaries are closed and must not be reopened without new regression evidence:

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
Phase 7 Business Rules & State Machines
MikroTik runtime connection behavior
RouterOS API integration
PPPoE lifecycle
Hotspot lifecycle
Profiles
Queues / speed enforcement
Synchronization
Disconnect / expiry enforcement
Runtime router evidence
Infrastructure failure handling
Fail-safe behavior
Remaining scheduled infrastructure operations
Phase 8 Infrastructure & Network Integration
GAP-9.1 API Authentication Exposure
GAP-9.2 Network Mutation Application Boundary
GAP-9.3-A HotspotSubscription Controller Authorization
GAP-9.3-B Dashboard Controller Authorization
GAP-9.3-C Reports Controller Authorization
GAP-9.3-D Scheduled Reports Controller Authorization
GAP-9.3-E MikroTik Controller Authorization
GAP-9.3-F Notification Controller Authorization

Completed Phase 8 audits:

MikroTik runtime connection behavior
RouterOS API integration
PPPoE lifecycle
Hotspot lifecycle
Profiles
Queues / speed enforcement
Synchronization
Disconnect / expiry enforcement
Runtime router evidence
Infrastructure failure handling
Fail-safe behavior
Remaining scheduled infrastructure operations

Completed Phase 9 boundaries:

GAP-9.1 — API Authentication Exposure
[x] CLOSED / GREEN

GAP-9.2 — Network Mutation Application Boundary
[x] CLOSED / GREEN

GAP-9.3-A — HotspotSubscription Controller Authorization
[x] CLOSED / GREEN

GAP-9.3-B — Dashboard Controller Authorization
[x] CLOSED / GREEN

GAP-9.3-C — Reports Controller Authorization
[x] CLOSED / GREEN

GAP-9.3-D — Scheduled Reports Controller Authorization
[x] CLOSED / GREEN

GAP-9.3-E — MikroTik Controller Authorization
[x] CLOSED / GREEN

GAP-9.3-F — Notification Controller Authorization
[x] CLOSED / GREEN

Current open Phase 8 audits:

NONE

Current active phase:

Phase 10 — Frontend Readiness Gate

Current execution position:

Frontend Readiness Evidence Audit

Current authorization candidates:

NONE — Phase 9 authorization scope is CLOSED / GREEN
DEFERRED ITEMS

Deferred items are not failures.

They must be handled only inside their owning roadmap phase.

Current deferred domain model boundaries:

JournalEntry
ActivityLog
Notification
WalletTransaction

Current broader remaining work:

Frontend Readiness Gate

Complete Documentation audit

Complete Operational Readiness

Final Architecture Certification

Phase 7 Business Rules audit is:

[x] CLOSED / GREEN

Phase 8 Infrastructure / Network audit is:

[x] CLOSED / GREEN

RouterOS Infrastructure runtime evidence is:

[x] GREEN

GAP-9.1 API Authentication Exposure is:

[x] CLOSED / GREEN

GAP-9.2 Network Mutation Application Boundary is:

[x] CLOSED / GREEN

GAP-9.3-A HotspotSubscription Controller Authorization is:

[x] CLOSED / GREEN

GAP-9.3-B Dashboard Controller Authorization is:

[x] CLOSED / GREEN

GAP-9.3-C Reports Controller Authorization is:

[x] CLOSED / GREEN

GAP-9.3-D Scheduled Reports Controller Authorization is:

[x] CLOSED / GREEN

GAP-9.3-E MikroTik Controller Authorization is:

[x] CLOSED / GREEN

GAP-9.3-F Notification Controller Authorization is:

[x] CLOSED / GREEN

No deferred item authorizes speculative refactoring in a completed phase.

NEXT CONCRETE WORK

The current execution phase is:

Phase 10 — Frontend Readiness Gate

The current execution position is:

Frontend Readiness Evidence Audit

Immediate Action

Phase 10 — Frontend Readiness Gate

→ Quick Audit

→ Backend API contract readiness

→ Authentication / token / session integration readiness

→ CORS / frontend-backend boundary readiness

→ Route surface readiness

→ Resource / DTO / response contract readiness

→ Validation / error contract readiness

→ Pagination / filtering / sorting readiness

→ Frontend integration entrypoint readiness

→ Gap / No Gap

→ Minimal Fix only if GAP exists

→ Targeted Tests

→ Regression if production code changes

→ Runtime Evidence

→ Green Gate

→ STOP


COMPLETED AUDIT TARGETS

Task

Task audit result:

[x] Task route/controller contract verified — CLOSED / GREEN
- `apiResource('tasks', ...)` was restricted to the implemented controller methods only:
`index`, `store`, `update`, `destroy`.
- `tasks.show` was removed because `TaskController::show()` does not exist.
- Runtime route verification shows exactly 4 Task API routes.
- Existing TaskController feature contract remains green:
4 tests / 7 assertions.

[x] Task authorization contract forensics completed.

[x] No existing Task-specific permissions found.

[x] No existing Task-specific role contract found.

[x] No Task Policy found.

[x] No Task ownership / assignment authorization contract found.
- `user_id` is nullable and client-writable.
- No contract was found requiring authorization based on the assigned user.
- Tenant isolation exists through the existing tenant scope, but tenant isolation is not evidence of a Task-specific authorization policy.

[x] No external / documented Task authorization requirement found.

[x] Runtime authorization evidence recorded:
- All 7 existing roles reached `GET /api/tasks` with HTTP 200.
- No Task-specific permissions were attached to those roles.

[x] GAP-9.3-J — Task Authorization Contract — CLOSED / GREEN

Authorization contract:

Permission-based authorization is enforced at the TaskController boundary using Spatie permissions.

No TaskPolicy, ownership rule, or assignment-based authorization is introduced because no resource-level authorization contract was established.

Role matrix:

* Super Admin:
  - task.view
  - task.create
  - task.update
  - task.delete

* Tenant Admin:
  - task.view
  - task.create
  - task.update
  - task.delete

* Manager:
  - task.view
  - task.create
  - task.update

* Support:
  - task.view

* Technician:
  - task.view
  - task.update

* Accountant:
  - none

* Customer:
  - none

Implementation boundary:

* `TaskController::index()` requires `task.view`.
* `TaskController::store()` requires `task.create`.
* `TaskController::update()` requires `task.update`.
* `TaskController::destroy()` requires `task.delete`.
* Existing `auth:sanctum` Task routes are preserved.
* No Task Policy was introduced.
* No ownership / assignment authorization was introduced.
* No unrelated Task service, route, or domain changes were made.

Security test evidence:

* `TaskControllerAuthorizationTest`: 17 passed / 44 assertions.

Full regression evidence:

* 693 passed
* 1768 assertions
* 0 failures
* Duration: 536.53s

Verdict:

[x] GAP-9.3-J — CLOSED / GREEN

Task authorization is now part of the completed Phase 9 authorization scope.

Do not reopen GAP-9.3-J without new regression evidence or an explicit authorization contract change.


Ticket

[x] GAP-9.3-G — Ticket Authorization Contract — CLOSED / GREEN

[x] Ticket route/controller contract verified.

[x] Ticket authorization contract implemented and verified.

[x] Existing Ticket permission contract reused.
- `tickets.view`
- `tickets.create`
- `tickets.update`
- `tickets.delete`
- `tickets.reply`
- `tickets.change_status`

[x] Ticket controller authorization verified for:
- `index`
- `store`
- `show`
- `update`
- `destroy`
- `dashboard`
- `messages`
- `reply`
- `changeStatus`
- `assign`

[x] Ticket assignment continues to use the existing `tickets.update` authorization contract.
- Existing TicketAssignmentOwnershipTest verifies this contract.
- No new `tickets.assign` authorization was invented.

[x] Ticket tenant ownership / assignment behavior remains GREEN.

[x] TicketControllerAuthorizationTest:
19 passed / 25 assertions.

[x] TicketAssignmentOwnershipTest:
3 passed.

[x] Combined Ticket authorization targeted tests:
22 passed / 25 assertions.

[x] Security Regression:
106 passed / 170 assertions.

[x] Full Regression:
663 passed / 1675 assertions / 0 failures / 411.99s.

[x] Ticket Authorization Green Gate achieved.

No Ticket authorization gap remains.

No Ticket Policy redesign is required.

No Ticket permission redesign is required.

No Ticket ownership refactor is required.

Ticket authorization is CLOSED and must not be reopened without new regression evidence or an explicit architectural decision.


Hotspot Read Authorization

[x] GAP-9.3-H — Hotspot Read Authorization — CLOSED / GREEN

[x] Hotspot read routes verified:
- `GET /api/hotspot/online`
- `GET /api/hotspot/stats`

[x] Both routes are protected by:
- `auth:sanctum`

[x] Hotspot controller authorization verified.

[x] `HotspotController::onlineUsers()` explicitly requires:
- `mikrotik.hotspot.view`

[x] `HotspotController::stats()` explicitly requires:
- `mikrotik.hotspot.view`

[x] Existing `mikrotik.hotspot.view` permission contract was reused.

[x] No new Hotspot permission was introduced.

[x] No new Hotspot Policy was introduced.

[x] No new authorization middleware or abstraction was introduced.

[x] Existing role contract was preserved:
- Super Admin / Tenant Admin have `mikrotik.hotspot.view`.
- Technician has `mikrotik.hotspot.view`.
- Roles without the permission are denied.

[x] HotspotControllerAuthorizationTest:
6 passed / 8 assertions / 0 failures / 52.17s.

[x] Security Regression:
112 passed / 178 assertions / 0 failures / 136.95s.

[x] Full Regression:
669 passed / 1683 assertions / 0 failures / 442.15s.

[x] Hotspot Read Authorization Green Gate achieved.

No Hotspot read authorization gap remains.

No Hotspot Policy redesign is required.

No Hotspot permission redesign is required.

No Hotspot ownership or tenant-scope refactor is required.

GAP-9.3-H is CLOSED and must not be reopened without new regression evidence or an explicit architectural decision.


GAP-9.5 — Customer Self-Service Presentation / Authentication Boundary

[x] GAP-9.5 — CLOSED / GREEN

Objective:

Close the verified Customer self-service presentation and authentication boundary gaps while preserving the existing Customer Module, Sanctum/API authentication, customer guard, validation, and self-service contracts.

Finding:

Two concrete gaps were identified:

1. `CustomerProfileController` contained direct Customer persistence mutations:

* `$customer->update()`
* `$customer->update(['password' => Hash::make(...)])`

2. Customer web self-service routes were registered with `web` only and lacked:

* `auth:customer`

The API customer routes were already protected by:

* `auth:sanctum`

Therefore, no API authentication gap was identified at GAP-9.5.

Architectural decision:

Do not create:

* `app/Modules/User`
* `app/Modules/Tenant`
* new Repository architecture
* new Core abstractions
* new authorization mechanisms
* new Customer Policy for self-service profile access

Use the existing Customer Module Application boundary and the existing `customer` authentication guard.

Production changes:

Created:

* `app/Modules/Customer/Application/Actions/UpdateCustomerProfileAction.php`
* `app/Modules/Customer/Application/Actions/ChangeCustomerPasswordAction.php`

Updated:

* `app/Http/Controllers/CustomerProfileController.php`
* Customer web route authentication boundary

Controller responsibilities remain limited to:

* Request validation
* Current-password verification
* Authenticated customer resolution
* Response handling

Application Actions own:

* Customer profile persistence
* New password hashing and persistence

Web customer route boundary:

Protected by:

* `web`
* `auth:customer`

Protected surfaces include:

* customer logout
* customer invoices
* customer tickets
* customer profile
* customer profile update
* customer password change

Public surfaces remain:

* `customer/login`
* `customer/login` POST

API customer routes remain protected by:

* `auth:sanctum`

Runtime route evidence:

* Customer web protected routes show `Illuminate\Auth\Middleware\Authenticate:customer`.
* Customer login routes remain public.
* API customer routes show `Illuminate\Auth\Middleware\Authenticate:sanctum`.

Direct mutation evidence:

* No direct Customer persistence mutation remains in `CustomerProfileController`.
* Profile persistence is delegated to `UpdateCustomerProfileAction`.
* Password persistence is delegated to `ChangeCustomerPasswordAction`.

Targeted security evidence:

* `CustomerProfileSecurityTest`: 5 passed
* 15 assertions
* 0 failures
* Duration: 42.00s

Production regression evidence at GAP-9.5:

* 702 passed
* 1793 assertions
* 0 failures
* Duration: 407.29s

Verdict:

[x] GAP-9.5 — CLOSED / GREEN

Do not reopen GAP-9.5 without new regression evidence or an explicit Customer self-service authentication/presentation contract change.

Do not reopen GAP-9.1 through GAP-9.4 because of GAP-9.5.


GAP-9.6-A — Customer API Ownership Contract

[x] GAP-9.6-A — CLOSED / GREEN

Objective:

Verify the Customer API ownership boundary, route/controller contract, authenticated customer self-service operations, and Customer subscription renewal ownership without introducing a new authorization architecture.

Findings:

Two concrete API presentation gaps were confirmed:

1. `CustomerAuthController` was referenced by Customer API routes but was missing:

* `logout`
* `updateProfile`
* `changePassword`

2. `CustomerSubscriptionController` was referenced by the Customer API route:

* `POST /api/customer/subscription/renew`

but was missing:

* `renew`

Customer API ownership itself was already based on the authenticated Sanctum Customer and did not require a new ownership abstraction.

Existing Customer API routes remain protected by:

* `auth:sanctum`

Ownership boundary:

* Customer operations resolve the authenticated Customer from the request.
* Customer profile operations operate on the authenticated Customer.
* Customer password changes operate on the authenticated Customer.
* Customer subscription renewal resolves the Subscription belonging to the authenticated Customer.
* Customer API operations do not accept a client-supplied `customer_id` for ownership.
* Customer subscription renewal does not use a client-supplied foreign Subscription ID to establish ownership.

Architectural decision:

Do not create:

* new Customer Policy
* new Customer permission
* new Customer authorization middleware
* new Repository architecture
* new Core authorization abstraction
* new ownership abstraction

Reuse the existing:

* Customer Module Application Actions
* Sanctum authentication
* `customer` / Customer authentication model
* Subscription domain Action / Workflow architecture
* existing tenant scope
* existing Network boundary

Production changes:

Updated:

* `app/Http/Controllers/Api/CustomerAuthController.php`
* `app/Http/Controllers/Api/CustomerSubscriptionController.php`

CustomerAuthController now provides:

* `logout`
* `updateProfile`
* `changePassword`

Profile persistence delegates to:

* `UpdateCustomerProfileAction`

Password persistence delegates to:

* `ChangeCustomerPasswordAction`

Logout removes only the current Sanctum access token.

CustomerSubscriptionController now provides:

* `renew`

Renewal uses the existing:

* `RenewWorkflow`

The authenticated Customer is used to resolve the owned Subscription before renewal.

No direct foreign Subscription ownership path was introduced.

Route evidence:

The following Customer API routes resolve to implemented controller methods:

* `POST /api/customer/logout`
* `PUT /api/customer/profile`
* `POST /api/customer/change-password`
* `POST /api/customer/subscription/renew`

Existing Customer API routes remain under:

* `auth:sanctum`

Test isolation evidence:

The renewal tests initially exposed fixture-level tenant-scope mismatches.

The final test fixtures were corrected so that:

* Customer and owned Subscription share the same `tenant_id`.
* Customer and owned Package share the same `tenant_id`.
* Foreign Customer, Subscription, and Package use the foreign Customer tenant.
* MikroTik lifecycle behavior is mocked at the existing `MikrotikServiceInterface` boundary.

No production Network behavior was changed.

This preserves the existing `TenantScope` and Network contracts.

Targeted security evidence:

`CustomerApiOwnershipContractTest`:

* 6 passed
* 18 assertions
* 0 failures
* Duration: 56.97s

Coverage includes:

* Customer can logout the current Sanctum token.
* Customer can update own profile.
* Customer can change own password.
* Wrong current password is rejected.
* Customer subscription renewal uses authenticated customer ownership.
* Foreign subscription ID does not override authenticated customer ownership.

Full regression evidence:

* 708 passed
* 1811 assertions
* 0 failures
* Duration: 520.49s

Verdict:

[x] GAP-9.6-A — CLOSED / GREEN

Customer API ownership and route/controller contract are GREEN.

No Customer API ownership gap remains from GAP-9.6-A.

No new authorization abstraction is required.

No Customer Policy redesign is required.

No Subscription ownership redesign is required.

No Network production change is required.

Do not reopen GAP-9.6-A without new regression evidence or an explicit Customer API ownership contract change.


REMAINING PRESENTATION / AUTHORIZATION AUDIT

The following items remain subject to the Phase 9 audit process:

→ Remaining controller classification

→ Web Network route middleware / authorization contract verification

→ Any other controller or route surface discovered by evidence

→ Request validation contract verification

→ Resource / response contract verification

→ API contract verification

→ Pagination / filtering / sorting contract verification

→ Error contract verification

Only a verified GAP may produce an implementation change.

If no contract gap is proven, record NO GAP and continue.

If a contract is missing, do not invent permissions, roles, Policies, ownership rules, or middleware without an explicit architectural decision.


TASK AUTHORIZATION BOUNDARY

Task authorization is explicitly established and closed under GAP-9.3-J.

The approved contract is permission-based authorization at the TaskController boundary.

Established permissions:

* task.view
* task.create
* task.update
* task.delete

Established role matrix:

* Super Admin: task.view, task.create, task.update, task.delete
* Tenant Admin: task.view, task.create, task.update, task.delete
* Manager: task.view, task.create, task.update
* Support: task.view
* Technician: task.view, task.update
* Accountant: none
* Customer: none

No Task Policy, ownership rule, assignment-based authorization rule, or additional Task permission may be introduced unless new evidence or an explicit architectural decision changes the established contract.

GAP-9.3-J is CLOSED / GREEN and remains part of the completed Phase 9 authorization scope.

A different verified Presentation gap may be audited and fixed without reopening Task authorization.


PHASE 9 EXECUTION RULES

Do not infer a Policy merely because a controller lacks `authorize()`.

Do not infer a missing Permission merely because a controller is authenticated.

Do not infer admin-only access without checking the existing role, permission, policy, route, and ownership contracts.

Do not create new permission names before evidence proves they are required.

Do not create new Policies before verifying that an existing Policy cannot satisfy the contract.

Do not modify ownership semantics without explicit evidence.

Do not modify request validation merely for stylistic consistency.

Do not modify API response structure without a proven contract gap.

Do not modify pagination/filtering/sorting behavior without a proven contract gap.

Do not modify error behavior without a proven contract gap.

Do not perform speculative refactoring.

Do not reopen completed GAPs without new regression evidence.

Do not reopen completed phases without new regression evidence or an explicit architectural decision.


CLOSED PHASE / GAP PROTECTION

Do not reopen GAP-9.1.

Do not reopen GAP-9.2.

Do not reopen GAP-9.3-A.

Do not reopen GAP-9.3-B.

Do not reopen GAP-9.3-C.

Do not reopen GAP-9.3-D.

Do not reopen GAP-9.3-E.

Do not reopen GAP-9.3-F.

Do not reopen GAP-9.3-G.

Do not reopen GAP-9.3-H.

Do not reopen GAP-9.3-I.

Do not reopen GAP-9.3-J.

Do not reopen GAP-9.4.

Do not reopen GAP-9.5.

Do not reopen GAP-9.6-A.

Do not reopen Phase 8.

Do not reopen Phase 7.

Do not reopen Phase 6.

Do not reopen completed Audits 1–12 without new regression evidence.

Do not modify Subscription lifecycle code without new regression evidence.

Do not perform speculative migration of legacy manual commands.

Do not reopen completed authorization boundaries because of test-suite duration alone.


CURRENT EXECUTION POSITION

Phase 10 — Frontend Readiness Gate

Status:

[~] IN PROGRESS

Current execution position:

[~] Phase 10 — Frontend Readiness Gate
    GAP-10.1 CLOSED / GREEN
    GAP-10.2 CLOSED / GREEN

GAP-10.1 — Response Contract Authority:

[x] CLOSED / GREEN

Contract authority:
- `docs/API_CONTRACT.md`
- `tests/Feature/Api/Contract/ApiResponseContractTest.php`

Contract evidence:
- 5 passed
- 24 assertions
- 0 failures
- Contract families covered:
  - Lifecycle envelope
  - Paginated Resource collection
  - Dashboard metrics
  - Authentication token/user contract
  - No Content

Targeted regression:
- 25 passed
- 76 assertions
- 0 failures
- Duration: 82.39s

Full regression:
- 715 passed
- 1841 assertions
- 0 failures
- Duration: 582.21s

Runtime/API evidence:
- 130 API routes
- `POST /api/login` is public.
- `POST /api/customer/login` is public.
- Remaining API routes are protected by `auth:sanctum`.
- Contract runtime suite: 5 passed / 24 assertions / 0 failures / 62.75s.

Production behavior:
- No API response behavior was changed.
- No pagination behavior was changed.
- No filtering or sorting behavior was changed.
- No frontend application architecture was introduced.

Environment note:
- `git status --short` could not execute because `/var/www`
  is not a Git repository in the current runtime.
- This is not an application failure and does not affect the Green Gate.

GAP-10.1 Green Gate:

[x] Contract authority established
[x] Targeted contract tests GREEN
[x] Targeted regression GREEN
[x] Full regression GREEN
[x] Runtime/API evidence GREEN
[x] Production behavior unchanged

No further GAP-10.1 implementation work is authorized.

The Phase 10 execution position does not reopen any completed Phase 9 GAP.

GAP-10.2 — Frontend Build / Integration Readiness:

[x] CLOSED / GREEN

Integration evidence:

- `@vite(['resources/css/app.css', 'resources/js/app.js'])` is present in:
  - `resources/views/layouts/app.blade.php`
  - `resources/views/welcome.blade.php`
- `php artisan view:cache` completed successfully after the integration fix.
- Application layout Vite integration is therefore valid at the Blade compilation boundary.

Build environment evidence:

- Application container does not provide Node or npm.
- Windows host build environment provides:
  - Node `v24.13.1`
  - npm `11.8.0`
- Project source tree verified at:
  - `D:\EgyptNet\backend`
- `package.json` present.
- `vite.config.js` present.
- No Dockerfile or Docker Compose build definition exists in the project repository.
- No Node/npm installation was added to the application container.
- The existing project setup contract already defines:
  - `npm install --ignore-scripts`
  - `npm run build`

Dependency installation evidence:

- `npm install --ignore-scripts` completed successfully.
- 60 packages added.
- 0 vulnerabilities reported.
- `node_modules` created.
- `package-lock.json` created.

Production build evidence:

- `npm run build` completed successfully.
- Vite version: `8.3.0`.
- Build duration: `2.79s`.
- `public/build/manifest.json` generated.
- Manifest size: `1478` bytes.
- `public/build/fonts-manifest.json` generated.
- CSS, JavaScript, font, and font stylesheet assets generated.
- The optional `fontaine` optimization message did not prevent a successful production build and does not authorize an additional dependency change.

Runtime artifact evidence:

- Laravel application container sees `public/build/manifest.json`.
- Laravel application container sees `public/build` and all generated assets.
- Manifest contains valid entries for:
  - `resources/css/app.css`
  - `resources/js/app.js`
- `php artisan view:cache` completed successfully with the production manifest present.

Laravel Vite rendering evidence:

- Rendering `layouts.app` through Laravel produced:
  - `/build/assets/app-BBTr62Y9.css`
  - `/build/assets/app-BvRk9kiK.js`
- Laravel generated:
  - stylesheet preload
  - modulepreload
  - stylesheet link
  - module script
- This verifies the complete Vite source → build artifact → manifest → Laravel resolver → Blade HTML integration path.

Regression evidence:

- 715 passed
- 1841 assertions
- 0 failures
- Duration: 577.00s

Production scope:

- No frontend framework was introduced.
- No React/Vue/Angular architecture was introduced.
- No SPA router or state-management architecture was introduced.
- No API response contract was changed.
- No pagination/filtering/sorting behavior was changed.
- No backend production architecture was refactored.
- No Node/npm installation was added to the PHP application container.
- The only production integration fix was adding the existing Vite entrypoint to the application layout.

GAP-10.2 Green Gate:

[x] Frontend Vite entrypoint integration verified
[x] Blade compilation GREEN
[x] Build environment authority identified
[x] Dependencies installed successfully
[x] Production Vite build GREEN
[x] Build manifest generated
[x] Runtime build artifact verified
[x] Laravel Vite rendering verified
[x] Full regression GREEN
[x] No unrelated architecture changes introduced

No further GAP-10.2 implementation work is authorized.

### Phase 10 Dashboard Legacy Surface Cleanup

**Status: CLOSED / GREEN**

Decision:
- The Dashboard product contract is API-first.
- `GET /api/dashboard` and `GET /api/dashboard/stats` remain the authoritative Dashboard API surfaces.
- The stale Web `/dashboard` route was removed.
- The orphan legacy `resources/views/dashboard/index.blade.php` was removed.
- Stale Dashboard links were removed from the application layout and welcome page.
- The root `/` entry now renders the existing `welcome` view instead of redirecting to `/dashboard`.
- No Dashboard API controller, service, authorization contract, or API response contract was changed.

Static evidence:
- Web `/dashboard` route absent.
- `/api/dashboard` present.
- `/api/dashboard/stats` present.
- No stale Dashboard route/view references remain.
- Legacy Dashboard Blade removed.
- `php artisan view:cache` completed successfully.

Targeted regression:
- 19 passed
- 47 assertions
- 0 failures
- Duration: 145.58s

Full regression:
- 715 passed
- 1831 assertions
- 0 failures
- Duration: 563.33s

Runtime environment note:
- HTTP probing from the application container could not connect to `localhost:80`.
- This was an environment/runtime-listener limitation, not an application failure.
- Route inspection and Laravel view-cache evidence remained GREEN.
- No additional HTTP infrastructure or frontend architecture change is authorized from this observation.

Green Gate:
- [x] Stale Web Dashboard route removed
- [x] Legacy Dashboard Blade removed
- [x] Stale Dashboard links removed
- [x] Root entry contract updated
- [x] Dashboard API routes preserved
- [x] Targeted tests GREEN
- [x] Full regression GREEN
- [x] View compilation/cache GREEN
- [x] No Dashboard API contract regression
- [x] No unrelated architecture changes introduced

Decision:
- Dashboard Legacy Surface Cleanup is CLOSED / GREEN.
- Do not reopen this cleanup without new regression evidence or an explicit product/architecture decision.
- Do not introduce a Blade Dashboard replacement.
- Do not add CORS, Sanctum stateful middleware, or frontend architecture as part of this cleanup.

STOP.

NEXT CONCRETE WORK

Continue Phase 10 — Frontend Readiness Gate.

Authentication / Token / Session Integration Readiness:

[x] CLOSED / GREEN

Evidence:

* Real Bearer token lifecycle verified for Admin API authentication.
* Real Bearer token lifecycle verified for Customer API authentication.
* Admin lifecycle:

  * login
  * real Bearer token
  * authenticated `/api/me`
  * logout
  * same token rejected afterward
* Customer lifecycle:

  * login
  * real Bearer token
  * authenticated `/api/customer/me`
  * logout
  * same token rejected afterward
* Token revocation uses:
  `PersonalAccessToken::findToken($request->bearerToken())?->delete()`
* `currentAccessToken()->delete()` is not used for Bearer-token revocation.
* Sanctum configuration remains unchanged.
* No Sanctum stateful middleware change was introduced.
* No session architecture change was introduced.
* Temporary authentication diagnostics were removed.
* Token table schema was verified.

Contract test:

`tests/Feature/Api/Contract/AuthenticationTokenLifecycleContractTest.php`

Targeted Green Gate:

* 2 passed
* 22 assertions
* 0 failures
* Duration: 57.52s

Full regression:

* 717 passed
* 1853 assertions
* 0 failures
* Duration: 564.60s

Final evidence:

`AUTHENTICATION TOKEN SESSION READINESS = GREEN`

Decision:

* Authentication / Token / Session Integration Readiness is CLOSED / GREEN.
* No further implementation or audit work is authorized for this item.
* Do not reopen without new regression evidence or an explicit authentication architecture contract change.

STOP.

Immediate next action:

→ CORS / frontend-backend boundary readiness

→ Route surface readiness

→ Resource / DTO / response contract readiness

→ Validation / error contract readiness

→ Pagination / filtering / sorting readiness

→ Identify GAP / NO GAP

→ Perform a minimal implementation only when a real GAP and explicit contract exist

→ Add targeted tests

→ Run regression if production code changes

→ Collect runtime evidence

→ Green Gate

→ STOP

Other remaining Presentation / Authorization surfaces must continue to follow the same evidence-first process.

No completed GAP may be reopened without direct regression evidence or an explicit architectural decision.

LATEST FULL REGRESSION EVIDENCE

The latest complete PHPUnit regression is:

717 passed

1853 assertions

0 failures

Duration: 564.60s

This regression is the current project-wide Green Gate after
Authentication / Token / Session Integration Readiness.

Previous project-wide Green Gate after GAP-10.2:

715 passed

1841 assertions

0 failures

Duration: 577.00s

Previous project-wide Green Gate after GAP-10.1:

715 passed

1841 assertions

0 failures

Duration: 582.21s

Previous project-wide Green Gate after GAP-9.5:

702 passed

1793 assertions

0 failures

Duration: 407.29s

Previous project-wide Green Gate after GAP-9.4:

697 passed

1778 assertions

0 failures

Duration: 450.39s

Historical authorization checkpoints:

GAP-9.3-J Task Authorization:

693 passed

1768 assertions

0 failures

Duration: 536.53s

GAP-9.3-I Web Network Authorization:

676 passed

1724 assertions

0 failures

Duration: 391.64s

Historical regression checkpoints remain evidence for their respective
completed GAPs only.

The current project-wide Green Gate is:

717 passed / 1853 assertions / 0 failures / 564.60s

This is the current project-wide Green Gate after
Authentication / Token / Session Integration Readiness.

The Authentication / Token / Session readiness work added the dedicated
real Bearer lifecycle contract test covering both Admin and Customer
authentication and token revocation.

The full regression remains GREEN with zero failures.

The regression duration decreased from the GAP-10.2 checkpoint.
No production performance conclusion is inferred from test-suite duration.

Test-suite duration alone does not establish a production performance gap.

No production performance refactor is justified by test-suite duration alone.

Do not reopen completed authorization gaps because of regression duration.

PROJECT COMPLETION EQUATION

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

=======

GREEN

FINAL PRINCIPLE

EgyptNet is not finished because the tests pass alone.

EgyptNet is finished only when:

Architecture is GREEN.

Ownership is GREEN.

Application boundaries are GREEN.

Business behavior is GREEN.

Infrastructure is GREEN.

Network integration is GREEN.

Presentation and authorization are GREEN.

Tests are GREEN.

Documentation is GREEN.

Operational readiness is GREEN.

Final Architecture Certification is GREEN.

Then, and only then:

EGYPTNET — PROJECT COMPLETE
