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

## GAP-9.3-B — Remaining API / Presentation / Authorization Surface

**Status: [~] CURRENT EXECUTION POSITION**

GAP-9.3-B continues the Phase 9 audit without reopening completed Phase 9 boundaries.

### Remaining Authorization Candidates

The remaining candidates identified by the controller authorization audit are:

```text
Dashboard
Hotspot
Mikrotik
Notification
Report
ScheduledReport
Task
```

These candidates require separate contract analysis.

No Policy or permission will be invented before evidence proves that it is required.

### Important Classification Rule

The following are already classified and must not be reopened:

```text
GAP-9.1 — API Authentication Exposure
[x] CLOSED / GREEN

GAP-9.2 — Network Mutation Application Boundary
[x] CLOSED / GREEN

GAP-9.3-A — HotspotSubscription Controller Authorization
[x] CLOSED / GREEN
```

Network DHCP / Firewall / Queue authorization is not reopened merely because those controllers were part of GAP-9.2.

Their Application mutation boundary is already GREEN.

### Remaining Audit Sequence

```text
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
```

### Current Rule

Do not create:

```text
new Policy
new Permission
new Middleware
new Role
new Authorization abstraction
```

unless the audit proves that the existing architecture cannot satisfy the required authorization contract.

---

## Remaining Presentation Audit

The broader Phase 9 presentation surface remains:

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

Already completed:

* [x] API Authentication Exposure — GAP-9.1.
* [x] Network Mutation Application Boundary — GAP-9.2.
* [x] HotspotSubscription Controller Authorization — GAP-9.3-A.

### Phase 9 Rules

* [ ] Controllers remain thin across the complete API surface.
* [ ] Authorization is explicit where the existing contract requires it.
* [ ] Validation is separated from business logic.
* [ ] Presentation does not own domain rules.
* [ ] Existing policies and permissions are reused where valid.
* [ ] No speculative authorization architecture is introduced.

**Exit Gate:** Presentation and Authorization GREEN.

---

# 10. TEST ARCHITECTURE & FULL REGRESSION

**Status: ACTIVE AS A CONTINUOUS GATE / CURRENT REGRESSION GREEN**

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
599 passed
1584 assertions
0 failures
Duration: 490.81s
```

This is the **current project-wide regression Green Gate** after the Phase 9 GAP-9.3-A production change.

Historical Phase 8 checkpoints remain historical evidence only.

### Historical Regression Checkpoints

Phase 6:

```text
546 passed
1416 assertions
0 failures
PHPUnit Notices: 5
```

Cancellation checkpoint:

```text
568 passed
1471 assertions
0 failures
```

Phase 7 final:

```text
578 passed
1492 assertions
0 failures
```

Synchronization checkpoint:

```text
585 passed
1543 assertions
0 failures
```

Disconnect / expiry checkpoint:

```text
585 passed
1544 assertions
0 failures
```

Audit 10 historical checkpoint:

```text
587 passed
1558 assertions
0 failures
```

Audit 11 historical checkpoint:

```text
593 passed
1578 assertions
0 failures
Duration: 477.61s
```

Audit 12 / Phase 8 historical checkpoint:

```text
593 passed
1578 assertions
0 failures
Duration: 334.18s
```

Phase 9 GAP-9.2 checkpoint:

```text
593 passed
1578 assertions
0 failures
Duration: 336.97s
```

Phase 9 GAP-9.3-A checkpoint:

```text
599 passed
1584 assertions
0 failures
Duration: 490.81s
```

### GAP-9.3-A Authorization Evidence

```text
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
```

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

The historical Phase 6 regression was:

```text
546 tests
1416 assertions
0 failures
PHPUnit Notices: 5
```

The 5 PHPUnit Notices were non-failing notices and did not invalidate that historical GREEN test gate.

### Important Regression Correction

The old baseline:

```text
528 passed
2 failed
1245 assertions
```

is historical evidence and is no longer the current regression state.

The two former `TenantScopeTest` failures were resolved as test/fixture drift through a minimal test-only correction.

Current TenantScope state:

```text
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

**Status: PENDING**

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
* [x] Complete runtime command inventory — Phase 8 Audit 12.
* [ ] Error logging reviewed.
* [ ] No unexplained recurring runtime errors remain.
* [ ] Backup / restore operational verification.
* [ ] Production monitoring verification.

**Exit Gate:** Documentation and operational state accurately reflect GREEN architecture.

---

# 12. FINAL ARCHITECTURE CERTIFICATION

**Status: PENDING**

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
* [x] Remaining business rules GREEN.
* [x] Infrastructure GREEN.
* [x] Network integration GREEN.
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

**Phase 9 — API / Presentation / Authorization**

**Status:** `[~] IN PROGRESS`

### Phase 9 Progress

```text
GAP-9.1 — API Authentication Exposure
[x] CLOSED / GREEN

GAP-9.2 — Network Mutation Application Boundary
[x] CLOSED / GREEN

GAP-9.3-A — HotspotSubscription Controller Authorization
[x] CLOSED / GREEN

GAP-9.3-B — Remaining API / Presentation / Authorization Surface
[~] CURRENT EXECUTION POSITION
```

Phase 8 — Infrastructure & Network Integration:

```text
[x] CLOSED / GREEN

593 passed
1578 assertions
0 failures
Duration: 334.18s
```

Phase 7 — Business Rules & State Machines:

```text
[x] CLOSED / GREEN

578 passed
1492 assertions
0 failures
```

Phase 6 — Billing & Subscription Domain:

```text
[x] CLOSED / GREEN
```

No Phase 6 reopening has occurred.

No Phase 7 reopening has occurred.

No Phase 8 reopening has occurred.

No GAP-9.1 reopening has occurred.

No GAP-9.2 reopening has occurred.

No GAP-9.3-A reopening has occurred.

## Phase 9 Current Green Gate

```text
599 passed
1584 assertions
0 failures
Duration: 490.81s
```

## Phase 8 Final Evidence

All Phase 8 audits are closed:

```text
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
```

## GAP-9.3-A Final Evidence

Policy runtime contract:

```text
HAS_SUPER_ADMIN=YES

viewAny => ALLOWED
create => ALLOWED
view => ALLOWED
delete => ALLOWED
activate => ALLOWED
suspend => ALLOWED
```

Controller enforcement:

```text
index    → authorize(viewAny)
store    → authorize(create)
show     → authorize(view)
destroy  → authorize(delete)
suspend  → authorize(suspend)
activate → authorize(activate)
```

Unauthorized endpoint verification:

```text
6 / 6 → HTTP 403
```

Targeted tests:

```text
8 passed
15 assertions
0 failures
Duration: 104.88s
```

Full regression:

```text
599 passed
1584 assertions
0 failures
Duration: 490.81s
```

Verdict:

```text
[x] GAP-9.3-A CLOSED / GREEN
```

## Audit 11 Evidence

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

Historical project-wide checkpoint:

```text
593 passed
1578 assertions
0 failures
Duration: 477.61s
```

## Audit 12 Evidence

Targeted Network registration:

```text
3 passed
8 assertions
```

Targeted Usage registration:

```text
4 passed
10 assertions
```

Runtime schedule:

```text
*/5  * * * *  php artisan mikrotik:sync-hotspot

*/5  * * * *  php artisan mikrotik:sync

*/15 * * * *  php artisan usage:sync

5    0 * * *  php artisan subscriptions:auto-renew

10   0 * * *  php artisan subscriptions:auto-grace

15   0 * * *  php artisan subscriptions:auto-expire
```

Exactly six active runtime schedules remain.

Legacy commands remain manually available:

```text
mikrotik:ping
mikrotik:cleanup
report:daily
```

They are not registered in the active runtime scheduler.

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
```

Completed Phase 8 audits:

```text
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
```

Completed Phase 9 boundaries:

```text
GAP-9.1 — API Authentication Exposure
[x] CLOSED / GREEN

GAP-9.2 — Network Mutation Application Boundary
[x] CLOSED / GREEN

GAP-9.3-A — HotspotSubscription Controller Authorization
[x] CLOSED / GREEN
```

Current open Phase 8 audits:

```text
NONE
```

Current active phase:

```text
Phase 9 — API / Presentation / Authorization
```

Current execution position:

```text
GAP-9.3-B — Remaining API / Presentation / Authorization Surface
```

---

# DEFERRED ITEMS

Deferred items are not failures.

They must be handled only inside their owning roadmap phase.

Current deferred domain model boundaries:

```text
JournalEntry
ActivityLog
Notification
WalletTransaction
```

Current broader remaining work:

```text
Complete API / Presentation audit
Complete Authorization audit
Complete Documentation audit
Complete Operational Readiness
Final Architecture Certification
```

Phase 7 Business Rules audit is:

```text
[x] CLOSED / GREEN
```

Phase 8 Infrastructure / Network audit is:

```text
[x] CLOSED / GREEN
```

RouterOS Infrastructure runtime evidence is:

```text
[x] GREEN
```

GAP-9.1 API Authentication Exposure is:

```text
[x] CLOSED / GREEN
```

GAP-9.2 Network Mutation Application Boundary is:

```text
[x] CLOSED / GREEN
```

GAP-9.3-A HotspotSubscription Controller Authorization is:

```text
[x] CLOSED / GREEN
```

No deferred item authorizes speculative refactoring in a completed phase.

---

# NEXT CONCRETE WORK

The current execution phase is:

```text
Phase 9 — API / Presentation / Authorization
```

The current execution position is:

```text
GAP-9.3-B — Remaining API / Presentation / Authorization Surface
```

## Immediate Action

```text
Phase 9 — API / Presentation / Authorization

→ Quick Audit

→ Remaining controller classification

→ Route / controller contract verification

→ Existing Policy classification

→ Permission / Role classification

→ Sanctum authorization classification

→ Ownership / scope classification

→ Request validation classification

→ Resource / Response classification

→ API contract classification

→ Pagination / Filtering / Sorting classification

→ Error contract classification

→ Gap / No Gap

→ Minimal Fix only if GAP exists

→ Targeted Tests

→ Regression if production code changes

→ Runtime Evidence

→ Green Gate

→ STOP
```

## First Audit Target

**GAP-9.3-B — Remaining API / Presentation / Authorization Surface**

Remaining authorization candidates:

```text
Dashboard
Hotspot
Mikrotik
Notification
Report
ScheduledReport
Task
```

These must be audited individually.

Do not infer a Policy merely because a controller lacks `authorize()`.

Do not infer a missing Permission merely because a controller is authenticated.

Do not infer admin-only access without checking the existing role, permission, policy, route, and ownership contracts.

Do not create new permission names before evidence proves they are required.

Do not create new Policies before verifying that an existing Policy cannot satisfy the contract.

Do not reopen GAP-9.1.

Do not reopen GAP-9.2.

Do not reopen GAP-9.3-A.

Do not reopen Phase 8.

Do not reopen Phase 7.

Do not reopen Phase 6.

Do not reopen Audits 1–12 without new regression evidence.

Do not modify Subscription lifecycle code without new regression evidence.

Do not perform speculative migration of legacy manual commands.

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
