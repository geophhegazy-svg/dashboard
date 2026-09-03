# EgyptNet — Master Project Completion Roadmap

> **Status:** FROZEN FOR EXECUTION

> **Purpose:** This document is the single canonical source of truth for
> completing the EgyptNet Enterprise ISP Platform.

> **Rule:** Never invent historical work or historical phase numbers.

> **Rule:** Never reopen a GREEN completed phase unless new evidence proves
> that its contract has regressed.

> **Completion Rule:** EgyptNet is complete only when all required phases
> reach GREEN / DONE and the Final Architecture Certification passes.

---

# EXECUTION MODEL

EgyptNet follows the Fast Architecture Loop:

```text
Quick Audit
→ Gap / No Gap
→ Minimal Fix
→ Targeted Tests
→ Regression
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

This section records work already completed and must not be reopened
without new regression evidence.

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
* [x] CreateCustomerCommandHandler delegates to Action.
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

### Important

Historical phase `2.3D` is NOT reconstructed.

Its original scope was not recoverable from verified project evidence.

Therefore it is permanently closed as an unrecoverable historical label,
not treated as an implementation task.

---

# 2. CURRENT ARCHITECTURE GAP AUDIT

**Status:** IN PROGRESS

This is the current execution phase.

## Objective

Perform one final evidence-first audit of the current repository and identify
only real remaining architectural gaps.

## Scope

* [x] Core — audited / NO GAP
* [x] Kernel — audited / NO GAP
* [x] Module Registry — audited / NO GAP
* [x] Module Loader — audited / NO GAP
* [x] Module Manifest — audited / NO GAP
* [x] Module Resources — audited / NO GAP
* [x] Module Discovery — audited / NO GAP
* [x] Module Source — audited / NO GAP
* [x] Manifest Collection / Compilation — audited / NO GAP
* [x] Network Provider registration boundary — audited / NO GAP
* [x] Network Controller / NetworkDevice persistence boundary — audited / GREEN / CLOSED
* [x] Security / Authorization Policy boundary — audited / NO GAP
* [x] Subscription Lifecycle boundary — audited / NO GAP
* [x] Legacy `app/Models` audit — NO GAP; `User` and `Tenant` are Core platform models
* [x] Duplicate wrappers — audited / NO GAP
* [ ] Legacy `app/Services`
* [ ] Legacy Workflows
* [ ] Modules
* [ ] Aggregate ownership
* [ ] Actions
* [ ] Commands / Handlers
* [ ] Queries / Handlers
* [ ] Workflows
* [ ] Domain Services
* [ ] Repositories
* [ ] Events / Listeners
* [ ] Infrastructure
* [ ] Presentation
* [ ] Authorization
* [ ] Scheduling
* [ ] RouterOS integration
* [ ] Documentation
* [ ] Tests

## Audit Table

Every finding must follow:

| Component                                | Current State                                                                                                                                  | Expected Boundary                                                                                                        | Gap / No Gap | Evidence                                                                                                                                                                         | Action    | Test                                                                           |
| ---------------------------------------- | ---------------------------------------------------------------------------------------------------------------------------------------------- | ------------------------------------------------------------------------------------------------------------------------ | ------------ | -------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- | --------- | ------------------------------------------------------------------------------ |
| Core / Kernel                            | Core contracts and Kernel implementation are separated from Laravel-specific Infrastructure                                                    | Core owns abstractions; Infrastructure owns framework bindings                                                           | **NO GAP**   | `app/Core/Kernel` tree; no legacy Core references found                                                                                                                          | No change | Existing Core/Kernel test suite                                                |
| Module Registry                          | Runtime collection only; does not own discovery or ordering                                                                                    | Registry stores loaded Modules; Discovery owns ordering                                                                  | **NO GAP**   | `ModuleRegistry.php`; previous 40C.81 ordering evidence                                                                                                                          | No change | `ModuleRegistryTest`, `ModuleLoaderTest`                                       |
| Module Loader                            | Loads discovered Modules into Registry                                                                                                         | Loader delegates discovery/loading; does not become discovery authority                                                  | **NO GAP**   | `ModuleLoader.php` + `ModuleLoaderInterface`                                                                                                                                     | No change | `ModuleLoaderTest`                                                             |
| Module Discovery                         | Owns Module discovery and dependency/topological ordering                                                                                      | Discovery is authoritative for source ordering                                                                           | **NO GAP**   | `ModuleDiscovery.php`; `ModuleSourceInterface`; `SOURCE_COUNT=18` evidence                                                                                                       | No change | `ModuleDiscoveryTest`                                                          |
| Module Source                            | Core depends on `ModuleSourceInterface`; Laravel implementation lives in Infrastructure                                                        | Framework-specific source implementation outside Core                                                                    | **NO GAP**   | `LaravelModuleSource.php`; Infrastructure binding                                                                                                                                | No change | `LaravelModuleSourceTest`                                                      |
| Module Manifest                          | Declarative Module resource definition                                                                                                         | Modules declare resources through typed Manifest API                                                                     | **NO GAP**   | `ModuleManifest.php`; `ResourceType.php`                                                                                                                                         | No change | Manifest/compiler tests                                                        |
| Module Resources                         | Typed resource definitions with matching compilation handlers                                                                                  | Resource type → matching handler                                                                                         | **NO GAP**   | 9 compilable resource types covered                                                                                                                                              | No change | `CompilableResourceHandlerCoverageTest`, `CompiledResourceHandlerBehaviorTest` |
| Manifest Collection / Compilation        | Collection and compilation preserve Module semantics and ordering                                                                              | Compiler produces derived compiled representation                                                                        | **NO GAP**   | 26 targeted tests / 57 assertions                                                                                                                                                | No change | `ManifestCollectorTest`, `ModuleManifestCompilerTest`                          |
| Network Provider Boundary                | MikroTik provider implements Network Provider contract and is exposed through compiled Module registration                                     | Provider remains Infrastructure; Module registration remains Kernel boundary                                             | **NO GAP**   | `NETWORK_MODULE=FOUND`, `COMPILED_NETWORK=FOUND`, `COMPILED_RESOURCES=3`, `PROVIDER_CONTRACT=PASS`, `PROVIDER_NAME=mikrotik`                                                     | No change | `MikroTikProviderTest` + Kernel compilation tests                              |
| Security / Authorization Policy Boundary | Core User/Tenant policies are owned by Core; Module policies remain Module-owned and are registered through Kernel PolicyResource registration | Core-owned authorization policies belong under Core Security; Module-specific policies remain inside their owning Module | **NO GAP**   | `UserPolicy` and `TenantPolicy` moved to `app/Core/Security/Authorization/Policies`; runtime Gate map resolves both Core policies; Module PolicyResource pipeline remains active | No change | 22 targeted tests / 49 assertions                                              |
| Legacy `app/Models`                      | `app/Models` contains only `User` and `Tenant`; both are platform-level identity/tenant persistence models, not obsolete Module models         | Core platform identity and tenancy models remain centrally owned; obsolete duplicate models should not remain            | **NO GAP**   | `User` implements Core authorization contract; `Tenant` remains platform model; canonical migrations/factories and active references confirmed                                   | No change | Existing authorization, tenancy, controller, and model coverage                |
| Duplicate Wrappers                       | No duplicate model wrappers found; Module models have canonical locations under their owning Modules                                           | Each aggregate/persistence model has one canonical owner; compatibility wrappers only remain when explicitly justified   | **NO GAP**   | Model tree contains canonical Module models only; wrapper searches returned no model-wrapper matches                                                                             | No change | Existing Module model and regression coverage                                  |
| Network Provider Resolver                | Provider resolution is owned by Network Infrastructure and exposed through the domain contract                                                 | Core/Domain consumes resolver contract; provider implementation remains Infrastructure                                   | **NO GAP**   | `NetworkProviderResolverInterface`; Infrastructure implementation; runtime `AVAILABLE=mikrotik`; unsupported provider throws expected exception                                  | No change | 5 tests / 7 assertions                                                         |
| Network Services Boundary                | `NetworkManager` and `MikrotikServiceAdapter` moved from Application to Infrastructure                                                         | RouterOS/provider/framework integration belongs to Infrastructure                                                        | **NO GAP**   | Both classes live under `Network/Infrastructure/Services`; Module binding verified; runtime service resolution successful                                                        | No change | Targeted Network tests                                                         |
| NetworkDevice Repository                 | NetworkDevice persistence access is exposed through a module-owned repository contract                                                         | Controllers/Application consume repository contract; Eloquent persistence remains Infrastructure                         | **NO GAP**   | `NetworkDeviceRepositoryInterface`; Infrastructure implementation; NetworkModule binding; runtime binding and repository behavior verified                                       | No change | Targeted repository/controller tests                                           |
| Network Controllers                      | Network API and web controllers no longer access `NetworkDevice` directly                                                                      | Presentation consumes repository/application boundaries rather than direct persistence                                   | **NO GAP**   | 7 controllers migrated; direct `NetworkDevice` access removed; repository injected and used                                                                                      | No change | 14 tests / 83 assertions                                                       |

---

## Verified Evidence — Network Provider / NetworkDevice Boundary

### Network Provider Resolver

* [x] Network Provider Resolver boundary audited.
* [x] `NetworkProviderResolverInterface` remains in Network Domain Contracts.
* [x] `NetworkProviderResolver` remains in Network Infrastructure.
* [x] Resolver no longer depends directly on `NetworkDevice`.
* [x] `resolve()` delegates provider lookup through the resolver contract.
* [x] `resolveByName()` validates provider implementation against `NetworkProviderInterface`.
* [x] Runtime available provider verified as `mikrotik`.
* [x] Runtime MikroTik provider resolution verified.
* [x] Unsupported provider behavior verified.

**Targeted evidence:**

```text
5 passed
7 assertions
```

### Network Services

* [x] `NetworkManager` moved to Infrastructure.
* [x] `MikrotikServiceAdapter` moved to Infrastructure.
* [x] Application layer no longer owns RouterOS/provider infrastructure services.
* [x] `NetworkModule` binds `MikrotikServiceInterface` to the Infrastructure adapter.
* [x] Composer autoload regenerated successfully.
* [x] Runtime service resolution verified.

Runtime:

```text
MIKROTIK_SERVICE_CLASS=App\Modules\Network\Infrastructure\Services\MikrotikServiceAdapter
SERVICE_OK=YES
NETWORK_MANAGER_CLASS=App\Modules\Network\Infrastructure\Services\NetworkManager
CONNECTED=NO
PROVIDER=NULL
```

`CONNECTED=NO` and `PROVIDER=NULL` represent the runtime environment's
current RouterOS connection state and are not classified as an architectural
failure of the service boundary.

### NetworkDevice Repository

* [x] `NetworkDeviceRepositoryInterface` established under Network Domain Contracts.
* [x] `NetworkDeviceRepository` established under Network Infrastructure.
* [x] Repository registered through `NetworkModule`.
* [x] `find()` verified.
* [x] `findOrFail()` verified.
* [x] `active()` verified using the existing `NetworkDevice::active()` scope.
* [x] No speculative `getActive()` repository API introduced.

Runtime:

```text
REPOSITORY=App\Modules\Network\Infrastructure\Repositories\NetworkDeviceRepository
ACTIVE_TYPE=Illuminate\Database\Eloquent\Collection
ACTIVE_COUNT=1
FIND_1=FOUND
FIND_OR_FAIL_1=OK
```

Binding:

```text
REPOSITORY_CLASS=App\Modules\Network\Infrastructure\Repositories\NetworkDeviceRepository
CONTRACT_OK=YES
```

### Network API Controllers

* [x] `DhcpApiController` migrated away from direct NetworkDevice persistence.
* [x] `FirewallApiController` migrated away from direct NetworkDevice persistence.
* [x] `QueueApiController` migrated away from direct NetworkDevice persistence.
* [x] `MikrotikController` migrated away from direct NetworkDevice persistence.
* [x] Existing `FirewallServiceInterface::getRules()` contract verified and respected.
* [x] `QueueServiceInterface::getAll()` contract verified and respected.
* [x] `MikrotikController` uses `QueryDispatcher` for invoice dashboard metrics.
* [x] Invoice dashboard query handler registration verified at runtime.

Runtime QueryBus evidence:

```text
DISPATCHER=App\Core\QueryBus\QueryDispatcher
QUERY_REGISTERED=YES
HANDLER=App\Modules\Invoice\Application\Queries\Handlers\GetInvoiceDashboardMetricsQueryHandler
```

Targeted API controller evidence:

```text
DhcpApiControllerTest       2 tests / 16 assertions
FirewallApiControllerTest   2 tests / 14 assertions
QueueApiControllerTest      2 tests / 14 assertions
MikrotikControllerTest      2 tests / 12 assertions
```

### Network Web Controllers

* [x] `Network/DHCPController` migrated away from direct NetworkDevice persistence.
* [x] `Network/FirewallController` migrated away from direct NetworkDevice persistence.
* [x] `Network/QueueController` migrated away from direct NetworkDevice persistence.
* [x] All use `NetworkDeviceRepositoryInterface`.
* [x] `find()`, `findOrFail()`, and `active()` repository usage verified.
* [x] Direct NetworkDevice model access removed.

Targeted web controller evidence:

```text
Network/DHCPControllerTest       2 tests / 9 assertions
Network/FirewallControllerTest   2 tests / 9 assertions
Network/QueueControllerTest      2 tests / 9 assertions
```

### Targeted Network Controller Regression

```text
14 passed
83 assertions
24.77s
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

### Full Regression Evidence

Latest full regression after the Network controller boundary work:

```text
528 passed
2 failed
1245 assertions
```

The two failures are both in `Tests\Unit\Scopes\TenantScopeTest` and were
independently confirmed as unrelated to the Network boundary:

```text
2 failed
3 passed
5 assertions
```

Known failures:

1. Tenant user sees only packages belonging to their tenant.
   Expected `1`, actual `2`.

2. Tenant user automatically receives tenant ID when creating a package.
   Database error: missing `tenant_id` default.

These failures are explicitly classified as **unrelated baseline failures**
and are not to be fixed inside the current Network boundary audit.

### Network Boundary Verdict

**Network Controller → NetworkDevice persistence boundary: GREEN / CLOSED.**

**Important:** This closes only the audited Network controller/device-persistence
boundary. The broader Network / RouterOS / infrastructure scope remains
subject to its own evidence-based audit.

---

## Verified Progress — Core / Kernel

### Completed Audit

* [x] Core audited — **NO GAP**
* [x] Kernel audited — **NO GAP**
* [x] Module Registry audited — **NO GAP**
* [x] Module Loader audited — **NO GAP**
* [x] Module Discovery audited — **NO GAP**
* [x] Module Source boundary audited — **NO GAP**
* [x] Module Manifest audited — **NO GAP**
* [x] Module Resources audited — **NO GAP**
* [x] Manifest Collection / Compilation audited — **NO GAP**
* [x] Network Provider registration boundary verified — **NO GAP**
* [x] Network Provider Resolver boundary verified — **NO GAP**
* [x] Network services Infrastructure boundary verified — **NO GAP**
* [x] NetworkDevice repository boundary verified — **NO GAP**
* [x] Network Controller / NetworkDevice persistence boundary — **GREEN / CLOSED**

### Evidence

```text
26 passed
57 assertions
```

Runtime:

```text
NETWORK_MODULE=FOUND
COMPILED_NETWORK=FOUND
COMPILED_RESOURCES=3
PROVIDER_CONTRACT=PASS
PROVIDER_NAME=mikrotik
```

Network resolver:

```text
AVAILABLE=mikrotik
MIKROTIK_CLASS=App\Modules\Network\Infrastructure\Providers\MikroTik\MikroTikProvider
UNSUPPORTED_PROVIDER=RuntimeException
MESSAGE=Unsupported network provider: unsupported
```

Network controller regression:

```text
14 passed
83 assertions
```

### Architectural Decision

No further implementation change is required for the already audited
Core / Kernel or closed Network controller boundary.

Previously GREEN work remains closed.

---

# Verified Progress — Security / Authorization Policy Boundary

### Completed Audit

* [x] Core Security authorization structure audited — **NO GAP**
* [x] UserPolicy ownership audited — **NO GAP**
* [x] TenantPolicy ownership audited — **NO GAP**
* [x] Module-owned policies audited — **NO GAP**
* [x] PolicyResource registration pipeline audited — **NO GAP**
* [x] Runtime Gate policy registration verified — **NO GAP**
* [x] Legacy `App\Modules\Policies\UserPolicy` reference removed.
* [x] Legacy `App\Modules\Policies\TenantPolicy` reference removed.
* [x] `UserPolicy` moved to `App\Core\Security\Authorization\Policies`.
* [x] `TenantPolicy` moved to `App\Core\Security\Authorization\Policies`.
* [x] `AuthServiceProvider` updated to the Core policy namespace.
* [x] Module policies remain under their owning Modules.
* [x] Kernel `PolicyResourceHandler` remains responsible for compiled Module policy registration.
* [x] `LaravelModuleRegistrar::registerPolicy()` continues to use Laravel Gate registration.
* [x] Runtime User policy map verified.
* [x] Runtime Tenant policy map verified.

### Evidence

Runtime policy map:

```text
App\Models\User
    => App\Core\Security\Authorization\Policies\UserPolicy

App\Models\Tenant
    => App\Core\Security\Authorization\Policies\TenantPolicy
```

Compiled Module policy resources remain present for:

```text
Subscription
Billing
Customer
Inventory
Package
Payment
Ticket
```

Targeted verification:

```text
22 passed
49 assertions
```

Covered tests:

```text
UserTenantPolicyTest
UserControllerAuthorizationTest
TenantControllerAuthorizationTest
PolicyResourceTest
HotspotSubscriptionPolicyRegistrationTest
```

### Architectural Decision

The Core / Module authorization ownership boundary is GREEN.

Core-owned `UserPolicy` and `TenantPolicy` now live under:

```text
app/Core/Security/Authorization/Policies/
```

Module-specific policies remain inside their respective Modules.

No further change is required for this audited boundary.

**Security / Authorization Policy Boundary: GREEN / NO GAP — STOP.**

### Important Boundary Rule

The successful completion of this policy boundary does **not** close the
entire Authorization phase.

Phase 2 records the architecture-map audit only.

The broader Phase 9 Authorization audit remains pending until the complete
API / Presentation / Authorization surface has been reviewed.

---

# Legacy `app/Models` Boundary

* [x] `app/Models` audited.
* [x] Only platform-level `User` and `Tenant` models remain there.
* [x] `User` remains a Core platform identity model.
* [x] `Tenant` remains a Core platform tenancy model.
* [x] Module-owned obsolete models are not retained under `app/Models`.
* [x] Active references verified.
* [x] Canonical migrations/factories verified.

**Verdict: NO GAP / CLOSED.**

This boundary must not be reopened unless new evidence demonstrates regression.

---

# Duplicate Wrappers Boundary

* [x] Duplicate model wrapper audit completed.
* [x] No duplicate Module model wrappers found.
* [x] Canonical Module model ownership verified.
* [x] Compatibility wrappers remain only where explicitly justified.
* [x] Duplicate class-name search results that were not model wrappers were
  correctly classified as unrelated classes.

**Verdict: NO GAP / CLOSED.**

---

## Rules

* No speculative refactoring.
* No cleanup merely for aesthetics.
* No reopening GREEN work.
* No historical reconstruction.
* No phase completion without evidence.
* No unrelated fixes inside the current audit.

---

# Phase 2 Exit Gate

* [ ] Current architecture map complete.
* [ ] Every relevant area classified.
* [ ] Gaps identified.
* [ ] No-Gap areas recorded.
* [ ] Deferred items recorded.
* [ ] Targeted tests identified.
* [ ] Final Phase 2 regression position reconciled.
* [ ] Phase 2 Green Gate achieved.

**Phase 2 remains IN PROGRESS.**

---

# 3. LEGACY BOUNDARY ELIMINATION

**Status:** PENDING

## Objective

Remove remaining legacy architectural paths only where the audit proves
they are obsolete.

## Targets

* [x] Legacy `app/Models` — audited / NO GAP
* [ ] Legacy `app/Services`
* [ ] Legacy Workflows
* [ ] Duplicate model wrappers
* [ ] Duplicate repositories
* [ ] Duplicate business logic
* [ ] Obsolete compatibility layers
* [ ] Framework-bound business logic outside Infrastructure/Presentation

## For every removal

* [ ] Reference search.
* [ ] Replacement verified.
* [ ] Targeted tests.
* [ ] Regression tests.
* [ ] Runtime verification where applicable.

**Exit Gate:** No unexplained legacy boundary remains.

---

# 4. MODULE OWNERSHIP COMPLETION

**Status:** PENDING

## Objective

Every aggregate must have exactly one authoritative owner.

## Aggregates

* [ ] Customer
* [ ] Package
* [ ] Invoice
* [ ] Payment
* [ ] Subscription
* [ ] Network
* [ ] Accounting
* [ ] Wallet
* [ ] Notification
* [ ] Activity
* [ ] Task
* [ ] Ticket
* [ ] Report
* [ ] ReportExport
* [ ] JournalEntry
* [ ] ActivityLog
* [ ] WalletTransaction

## Verify

* [ ] Model ownership.
* [ ] Factory ownership.
* [ ] Repository ownership.
* [ ] Aggregate ownership.
* [ ] Relationships.
* [ ] Migrations.
* [ ] Imports.
* [ ] Tests.

**Exit Gate:** Every aggregate has one clear owner.

---

# 5. APPLICATION / USE-CASE ARCHITECTURE

**Status:** PENDING

## Objective

Every business use case must have a clear application boundary.

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

## Audit

* [ ] Commands.
* [ ] Command Handlers.
* [ ] Actions.
* [ ] Queries.
* [ ] Query Handlers.
* [ ] Workflows.
* [ ] Domain Services.
* [ ] Repositories.

## Rules

* [ ] Controllers remain thin.
* [ ] No trivial CRUD Workflow where Action is sufficient.
* [ ] No business orchestration inside repositories.
* [ ] No duplicated use-case logic.
* [ ] One clear application boundary per use case.

**Exit Gate:** Application architecture GREEN.

---

# 6. CROSS-MODULE ARCHITECTURE & OWNERSHIP

**Status:** PENDING

## Objective

Ensure modules communicate through explicit application/domain boundaries
without violating aggregate ownership.

## Critical Rule — Invoice

The Invoice Module is the sole owner of the Invoice aggregate.

Other modules must NOT:

* [ ] call `Invoice::create()` directly.
* [ ] generate invoice numbers directly.
* [ ] bypass Invoice application boundaries.

Invoice creation must use the approved Invoice application/service boundary.

## Dependencies to audit

* [ ] Subscription → Invoice
* [ ] Billing → Invoice
* [ ] Payment → Invoice
* [ ] Wallet → Accounting
* [ ] Network → Subscription
* [ ] Notifications → Domain Events
* [ ] Reports → Read / Query boundaries

**Exit Gate:** No cross-module ownership violation remains.

---

# 7. BUSINESS RULES & STATE MACHINES

**Status:** PENDING

## Objective

Validate behavior, not only architecture.

## Domains

* [ ] Customer lifecycle.
* [ ] Subscription lifecycle.
* [ ] Billing.
* [ ] Invoice.
* [ ] Payment.
* [ ] Wallet.
* [ ] Accounting.
* [ ] Network.
* [ ] Package.
* [ ] Expiration.
* [ ] Suspension.
* [ ] Grace period.
* [ ] Renewal.
* [ ] Cancellation.
* [ ] Activation / Deactivation.

## Validate

* [ ] Business rules.
* [ ] State transitions.
* [ ] Domain Services.
* [ ] Aggregate transitions.
* [ ] Domain Events.
* [ ] Scheduled operations.
* [ ] Error handling.

**Exit Gate:** Business rules have clear owners and executable tests.

---

# 8. INFRASTRUCTURE & NETWORK INTEGRATION

**Status:** PENDING

## Objective

Ensure Infrastructure owns framework and external-system concerns.

## Scope

* [ ] Laravel bindings.
* [ ] Service Providers.
* [ ] Persistence.
* [ ] Eloquent.
* [ ] Database.
* [ ] Queue.
* [ ] Cache.
* [ ] Events.
* [ ] Scheduling.
* [ ] RouterOS integration.
* [ ] External integrations.

## Verified Sub-boundaries

The following Network-related sub-boundaries have already been audited
inside Phase 2:

* [x] Network Provider registration boundary — NO GAP.
* [x] Network Provider Resolver boundary — NO GAP.
* [x] Network services Infrastructure boundary — NO GAP.
* [x] NetworkDevice repository boundary — NO GAP.
* [x] Network Controller → NetworkDevice persistence boundary — GREEN / CLOSED.

These do **not** close the entire Infrastructure / Network phase.

## Special Rule

Schedule is a runtime resource.

It must not be incorrectly treated as a compiled resource.

## Runtime Operations

Audit all scheduled commands, including:

* [ ] Subscription automation.
* [ ] Usage synchronization.
* [ ] MikroTik synchronization.
* [ ] Network synchronization.
* [ ] Other scheduled commands.

**Exit Gate:** Infrastructure boundaries and runtime operations GREEN.

---

# 9. API / PRESENTATION / AUTHORIZATION

**Status:** PENDING

## Audit

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

## Verified Sub-boundaries

The Core / Module **Policy Ownership and Registration Boundary** has already
been audited and is GREEN / NO GAP.

The Network Controller → NetworkDevice persistence boundary has also been
audited and is GREEN / CLOSED.

These do not complete the entire Phase 9 audit.

Remaining Phase 9 work must verify the complete presentation and security
surface, including:

* runtime authorization behavior,
* route protection,
* permissions,
* roles,
* Sanctum,
* request validation,
* controller boundaries,
* API responses/resources.

## Rules

* [ ] Controllers remain thin.
* [ ] Authorization explicit.
* [ ] Validation separated from business logic.
* [ ] Presentation does not own domain rules.

**Exit Gate:** Presentation and Authorization GREEN.

---

# 10. TEST ARCHITECTURE & FULL REGRESSION

**Status:** PENDING

## Objective

Create final confidence that the architecture and behavior are GREEN.

## Test Layers

* [ ] Unit.
* [ ] Feature.
* [ ] Integration.
* [ ] Architecture.
* [ ] Module.
* [ ] Workflow.
* [ ] Action.
* [ ] Repository.
* [ ] Policy.
* [ ] Regression.

## Required sequence

```text
Targeted Tests
↓
Module Regression
↓
Full Test Suite
↓
GREEN
```

## Rule

Every architectural change requires targeted tests before completion.

### Current Regression Baseline

Latest regression checkpoint after the Network controller boundary work:

```text
528 passed
2 failed
1245 assertions
```

The two failures are known `TenantScopeTest` baseline failures:

```text
2 failed
3 passed
5 assertions
```

They remain classified as unrelated to the Network boundary sprint.

**Exit Gate:** Full regression GREEN with no unexplained failures.

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
* [ ] `MASTER_ROADMAP.md`

## Operational Readiness

* [ ] Scheduled commands verified.
* [ ] Cache lifecycle verified.
* [ ] Queue behavior verified.
* [ ] Runtime commands verified.
* [ ] Error logging reviewed.
* [ ] No unexplained recurring runtime errors remain.

**Exit Gate:** Documentation and operational state accurately reflect GREEN
architecture.

---

# 12. FINAL ARCHITECTURE CERTIFICATION

**Status:** PENDING

Final audit.

## Certification Checklist

* [ ] Architecture GREEN.
* [ ] Core GREEN.
* [ ] Kernel GREEN.
* [ ] Module boundaries GREEN.
* [ ] Aggregate ownership GREEN.
* [ ] Legacy boundaries GREEN.
* [ ] Application architecture GREEN.
* [ ] Cross-module architecture GREEN.
* [ ] Business rules GREEN.
* [ ] Infrastructure GREEN.
* [ ] Network integration GREEN.
* [ ] Presentation GREEN.
* [ ] Authorization GREEN.
* [ ] Tests GREEN.
* [ ] Documentation GREEN.
* [ ] Operational readiness GREEN.
* [ ] No unexplained architectural gaps.
* [ ] Deferred items explicitly documented.
* [ ] Final regression suite GREEN.

When every item passes:

# EGYPTNET — ARCHITECTURE COMPLETE

---

# CHANGE CONTROL

## Rule 1 — Architecture First

Never modify architecture before auditing the current implementation.

## Rule 2 — Gap / No Gap

Every proposed change must answer:

> Is there an architectural gap?

If NO GAP:

> Do not change the code.

## Rule 3 — Minimal Fix

Fix only the verified gap.

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

**Current Phase:** 2 — Current Architecture Gap Audit

**Status:** `[~] IN PROGRESS`

## Completed in Current Phase

* Core / Kernel boundary — **NO GAP**
* Module Registry — **NO GAP**
* Module Loader — **NO GAP**
* Module Discovery — **NO GAP**
* Module Source — **NO GAP**
* Module Manifest — **NO GAP**
* Module Resources — **NO GAP**
* Manifest Collection / Compilation — **NO GAP**
* Network Provider registration boundary — **NO GAP**
* Network Provider Resolver boundary — **NO GAP**
* Network services Infrastructure boundary — **NO GAP**
* NetworkDevice repository boundary — **NO GAP**
* Network Controller / NetworkDevice persistence boundary — **GREEN / CLOSED**
* Security / Authorization Policy boundary — **NO GAP**
* Subscription Lifecycle boundary — **NO GAP**
* Legacy `app/Models` audit — **NO GAP**
* Duplicate wrappers — **NO GAP**

## Network Evidence

```text
Network Provider Resolver:
5 passed / 7 assertions

Network Controller targeted regression:
14 passed / 83 assertions

Latest full regression:
528 passed
2 failed
1245 assertions
```

Known unrelated regression failures:

```text
Tests\Unit\Scopes\TenantScopeTest

2 failed
3 passed
5 assertions
```

These failures remain outside the Network boundary and must not be fixed
inside the current audit scope.

## Security / Authorization Evidence

```text
22 passed
49 assertions
```

Runtime:

```text
App\Models\User
    => App\Core\Security\Authorization\Policies\UserPolicy

App\Models\Tenant
    => App\Core\Security\Authorization\Policies\TenantPolicy
```

## Architectural Position

The following audited boundaries are closed and must not be reopened without
new regression evidence:

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
Subscription Lifecycle
Legacy app/Models
Duplicate Wrappers
```

## Next Action

Continue Phase 2 Architecture Map with the remaining Legacy Boundary audit:

```text
Legacy app/Services
→ Legacy Workflows
→ Modules
→ Aggregate ownership
→ Actions
→ Commands / Handlers
→ Queries / Handlers
→ Workflows
→ Domain Services
→ Repositories
→ Events / Listeners
→ Infrastructure
→ Presentation
→ Authorization
→ Scheduling
→ RouterOS integration
→ Documentation
→ Tests
```

### Immediate Next Step

**Quick Audit — Legacy `app/Services`**

Audit only:

```text
Inventory
→ Namespace classification
→ Class/interface/trait classification
→ Application references
→ Test references
→ Duplicate/compatibility analysis
→ Replacement/ownership evidence
→ Gap / No Gap
```

**No implementation change until the audit identifies a real Gap.**

No deletion, movement, replacement, or refactoring is authorized merely
because a file exists under `app/Services`.

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
6. Presentation and authorization are GREEN.
7. Tests are GREEN.
8. Documentation is GREEN.
9. Operational readiness is GREEN.
10. Final certification is GREEN.

Then, and only then:

# EGYPTNET — PROJECT COMPLETE
