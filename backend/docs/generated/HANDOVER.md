# PROJECT HANDOVER DOCUMENT

## 1. Executive Summary

# Project Summary

Project: EgyptNet ISP Management System

Technology
- Laravel 13
- PHP 8.4
- Docker
- MikroTik RouterOS

Statistics
- Models: 19
- Services: 88


---

# Project Architecture

app/
├── Console
├── Contracts
├── Events
├── Http
├── Jobs
├── Listeners
├── Models
├── Policies
├── Providers
├── Repositories
├── Services
│   ├── Billing
│   ├── Customer
│   ├── Dashboard
│   ├── Documentation
│   ├── Invoice
│   ├── Network
│   ├── Payment
│   ├── Subscription
│   └── Wallet

---

# Project Statistics

Models: 19
Services: 88

---

# AI Context

Project Name
EgyptNet ISP Management System

Technology Stack
- Laravel 13
- PHP 8.4
- Docker
- MySQL
- MikroTik RouterOS API

Architecture
- Enterprise Architecture
- Service Layer
- Repository Pattern
- Documentation Engine
- Reflection Engine

Implemented Modules
- Customers
- Packages
- Subscriptions
- Billing
- Invoices
- Payments
- Wallet
- Dashboard
- Notifications
- Inventory
- Tickets

Documentation
- ProjectScanner
- ReflectionEngine
- MarkdownBuilder
- DocumentationWriter
- DocumentationGenerators

Development Rules
- Never bypass the Service Layer.
- Reuse existing services whenever possible.
- Keep Enterprise Architecture intact.
- Keep tests passing.
- Update generated documentation after structural changes.

Current Statistics
Models: 19
Services: 88

---

# Business Rules

## AIContextGenerator

**Namespace**
App\Services\Documentation\Knowledge

**Dependencies**
- App\Services\Documentation\Scanner\ProjectScanner

**Methods**
- __construct(1 params) : mixed
- generate(0 params) : string
- filename(0 params) : string

---

## AbstractHandoverSection

**Namespace**
App\Services\Documentation\Handover

**Dependencies**
- None

**Methods**

---

## ActionDocumentationGenerator

**Namespace**
App\Services\Documentation\Generators

**Dependencies**
- App\Services\Documentation\Scanner\ProjectScanner

**Methods**
- __construct(1 params) : mixed
- priority(0 params) : int
- generate(0 params) : string
- filename(0 params) : string

---

## ActivityLogService

**Namespace**
App\Services

**Dependencies**
- None

**Methods**
- log(5 params) : void

---

## AiStartPromptExport

**Namespace**
App\Services\Documentation\Exports

**Dependencies**
- None

**Methods**
- filename(0 params) : string
- content(0 params) : string
- isAiExport(0 params) : bool

---

## ApiDocumentationGenerator

**Namespace**
App\Services\Documentation\Generators

**Dependencies**
- None

**Methods**
- priority(0 params) : int
- filename(0 params) : string
- generate(0 params) : string

---

## ArchitectureGenerator

**Namespace**
App\Services\Documentation\Knowledge

**Dependencies**
- None

**Methods**
- generate(0 params) : string
- filename(0 params) : string

---

## AutomaticBillingService

**Namespace**
App\Services\Billing

**Dependencies**
- App\Services\Billing\BillingEngine
- App\Services\Subscription\SubscriptionRenewalService
- App\Services\InvoiceService
- App\Services\NotificationService

**Methods**
- __construct(4 params) : mixed
- run(1 params) : void
- processSubscription(1 params) : void

---

## BillingCycleService

**Namespace**
App\Services\Billing

**Dependencies**
- None

**Methods**
- calculateNextBillingDate(2 params) : Carbon\Carbon
- calculateGraceDate(2 params) : Carbon\Carbon
- isDue(1 params) : bool
- isExpired(1 params) : bool

---

## BillingEngine

**Namespace**
App\Services\Billing

**Dependencies**
- None

**Methods**
- status(2 params) : App\Enums\BillingStatus
- nextDueDate(2 params) : Carbon\Carbon

---

## BusinessRuleExtractor

**Namespace**
App\Services\Documentation\Knowledge

**Dependencies**
- None

**Methods**
- extract(1 params) : array

---

## BusinessRulesGenerator

**Namespace**
App\Services\Documentation\Knowledge

**Dependencies**
- App\Services\Documentation\Scanner\ProjectScanner
- App\Services\Documentation\Knowledge\BusinessRuleExtractor

**Methods**
- __construct(2 params) : mixed
- filename(0 params) : string
- generate(0 params) : string

---

## ClassDocumentationGenerator

**Namespace**
App\Services\Documentation\Generators

**Dependencies**
- App\Services\Documentation\Scanner\ProjectScanner

**Methods**
- __construct(1 params) : mixed
- generate(0 params) : string

---

## ClassFinder

**Namespace**
App\Services\Documentation\Scanner

**Dependencies**
- None

**Methods**
- find(1 params) : ?string
- findMany(1 params) : array

---

## ClassReflector

**Namespace**
App\Services\Documentation\Reflection

**Dependencies**
- None

**Methods**
- methods(1 params) : array

---

## ConstructorReflector

**Namespace**
App\Services\Documentation\Reflection

**Dependencies**
- None

**Methods**
- reflect(1 params) : array

---

## ControllerDocumentationGenerator

**Namespace**
App\Services\Documentation\Generators

**Dependencies**
- App\Services\Documentation\Scanner\ProjectScanner

**Methods**
- __construct(1 params) : mixed
- priority(0 params) : int
- generate(0 params) : string
- filename(0 params) : string

---

## ControllersKnowledgeGenerator

**Namespace**
App\Services\Documentation\Knowledge

**Dependencies**
- App\Services\Documentation\Scanner\ProjectScanner
- App\Services\Documentation\Reflection\ReflectionEngine

**Methods**
- __construct(2 params) : mixed
- filename(0 params) : string
- generate(0 params) : string

---

## CustomerDashboardService

**Namespace**
App\Services\Dashboard

**Dependencies**
- None

**Methods**
- getDashboardData(1 params) : array

---

## CustomerService

**Namespace**
App\Services\Customer

**Dependencies**
- None

**Methods**
- create(1 params) : App\Models\Customer
- update(2 params) : App\Models\Customer
- delete(1 params) : bool

---

## DashboardService

**Namespace**
App\Services\Dashboard

**Dependencies**
- None

**Methods**
- getDashboardData(0 params) : array

---

## DatabaseExtractor

**Namespace**
App\Services\Documentation\Knowledge

**Dependencies**
- None

**Methods**
- extract(0 params) : array

---

## DatabaseKnowledgeGenerator

**Namespace**
App\Services\Documentation\Knowledge

**Dependencies**
- App\Services\Documentation\Knowledge\DatabaseExtractor

**Methods**
- __construct(1 params) : mixed
- filename(0 params) : string
- generate(0 params) : string

---

## DependencyGraphExtractor

**Namespace**
App\Services\Documentation\Knowledge

**Dependencies**
- App\Services\Documentation\Scanner\ProjectScanner

**Methods**
- __construct(1 params) : mixed
- extract(0 params) : array

---

## DependencyGraphKnowledgeGenerator

**Namespace**
App\Services\Documentation\Knowledge

**Dependencies**
- App\Services\Documentation\Knowledge\DependencyGraphExtractor

**Methods**
- __construct(1 params) : mixed
- filename(0 params) : string
- generate(0 params) : string

---

## DocumentationDirectoryManager

**Namespace**
App\Services\Documentation\Filesystem

**Dependencies**
- None

**Methods**
- generatedPath(0 params) : string
- ensureExists(0 params) : void
- file(1 params) : string

---

## DocumentationGeneratorManager

**Namespace**
App\Services\Documentation\Manager

**Dependencies**
- App\Services\Documentation\Registry\DocumentationGeneratorRegistry
- App\Services\Documentation\Writer\DocumentationWriter

**Methods**
- __construct(2 params) : mixed
- generate(0 params) : void

---

## DocumentationGeneratorRegistry

**Namespace**
App\Services\Documentation\Registry

**Dependencies**
- None

**Methods**
- register(1 params) : self
- all(0 params) : array

---

## DocumentationIndexGenerator

**Namespace**
App\Services\Documentation\Index

**Dependencies**
- None

**Methods**
- generate(1 params) : string

---

## DocumentationWriter

**Namespace**
App\Services\Documentation\Writer

**Dependencies**
- None

**Methods**
- __construct(1 params) : mixed
- write(2 params) : void
- exists(1 params) : bool
- read(1 params) : string
- delete(1 params) : void

---

## ExecutiveSummarySection

**Namespace**
App\Services\Documentation\Handover

**Dependencies**
- None

**Methods**
- generate(0 params) : string

---

## ExportRegistry

**Namespace**
App\Services\Documentation\Exports

**Dependencies**
- None

**Methods**
- __construct(0 params) : mixed
- register(1 params) : self
- exports(0 params) : array

---

## FileScanner

**Namespace**
App\Services\Documentation\Scanner

**Dependencies**
- None

**Methods**
- scan(1 params) : array

---

## FinanceService

**Namespace**
App\Services\Finance

**Dependencies**
- None

**Methods**
- record(1 params) : void

---

## HandoverDocumentGenerator

**Namespace**
App\Services\Documentation\Knowledge

**Dependencies**
- None

**Methods**
- filename(0 params) : string
- generate(0 params) : string

---

## InvoiceGenerator

**Namespace**
App\Services\Billing

**Dependencies**
- App\Services\InvoiceNumberService

**Methods**
- __construct(1 params) : mixed
- generate(1 params) : App\Models\Invoice

---

## InvoiceNumberService

**Namespace**
App\Services

**Dependencies**
- None

**Methods**
- generate(0 params) : string

---

## InvoiceService

**Namespace**
App\Services\Invoice

**Dependencies**
- None

**Methods**
- create(1 params) : App\Models\Invoice
- update(2 params) : App\Models\Invoice
- delete(1 params) : bool

---

## KnowledgeExporter

**Namespace**
App\Services\Documentation\Knowledge

**Dependencies**
- App\Services\Documentation\Writer\DocumentationWriter

**Methods**
- __construct(1 params) : mixed
- export(0 params) : void

---

## KnowledgeGeneratorManager

**Namespace**
App\Services\Documentation\Knowledge

**Dependencies**
- App\Services\Documentation\Knowledge\KnowledgeGeneratorRegistry
- App\Services\Documentation\Writer\DocumentationWriter

**Methods**
- __construct(2 params) : mixed
- generate(0 params) : void

---

## KnowledgeGeneratorRegistry

**Namespace**
App\Services\Documentation\Knowledge

**Dependencies**
- App\Services\Documentation\Scanner\ProjectScanner

**Methods**
- __construct(1 params) : mixed
- register(1 params) : self
- generators(0 params) : array

---

## KnowledgeIndexGenerator

**Namespace**
App\Services\Documentation\Knowledge

**Dependencies**
- None

**Methods**
- filename(0 params) : string
- generate(0 params) : string

---

## MarkdownBuilder

**Namespace**
App\Services\Documentation\Builder

**Dependencies**
- None

**Methods**
- title(1 params) : self
- h2(1 params) : self
- h3(1 params) : self
- text(1 params) : self
- bullet(1 params) : self
- numbered(2 params) : self
- code(2 params) : self
- table(2 params) : self
- separator(0 params) : self
- newline(0 params) : self
- render(0 params) : string

---

## MetadataExtractor

**Namespace**
App\Services\Documentation\Scanner

**Dependencies**
- None

**Methods**
- extract(1 params) : array

---

## MethodReflector

**Namespace**
App\Services\Documentation\Reflection

**Dependencies**
- None

**Methods**
- reflect(1 params) : array

---

## MigrationExtractor

**Namespace**
App\Services\Documentation\Knowledge

**Dependencies**
- None

**Methods**
- extract(0 params) : array

---

## MigrationsKnowledgeGenerator

**Namespace**
App\Services\Documentation\Knowledge

**Dependencies**
- App\Services\Documentation\Knowledge\MigrationExtractor

**Methods**
- __construct(1 params) : mixed
- filename(0 params) : string
- generate(0 params) : string

---

## MikrotikConnection

**Namespace**
App\Services\Network

**Dependencies**
- None

**Methods**
- client(0 params) : RouterOS\Client
- execute(1 params) : array

---

## MikrotikService

**Namespace**
App\Services\Network

**Dependencies**
- None

**Methods**
- connect(4 params) : bool
- createUser(4 params) : bool
- disableUser(1 params) : bool
- enableUser(1 params) : bool
- deleteUser(1 params) : bool
- getAllUsers(0 params) : array
- getActiveSessions(0 params) : array
- updateUserQueue(3 params) : bool
- getDeviceStats(0 params) : array
- ping(1 params) : bool
- disconnectUser(1 params) : bool
- updateDeviceStatus(1 params) : void
- getHotspotUsers(0 params) : array
- getHotspotActiveSessions(0 params) : array
- createHotspotUser(4 params) : bool
- disableHotspotUser(1 params) : bool
- enableHotspotUser(1 params) : bool

---

## ModelDocumentationGenerator

**Namespace**
App\Services\Documentation\Generators

**Dependencies**
- App\Services\Documentation\Scanner\ProjectScanner

**Methods**
- __construct(1 params) : mixed
- generate(0 params) : string
- priority(0 params) : int
- filename(0 params) : string

---

## ModelRelationExtractor

**Namespace**
App\Services\Documentation\Knowledge

**Dependencies**
- App\Services\Documentation\Scanner\ProjectScanner

**Methods**
- __construct(1 params) : mixed
- extract(0 params) : array

---

## ModelRelationsKnowledgeGenerator

**Namespace**
App\Services\Documentation\Knowledge

**Dependencies**
- App\Services\Documentation\Knowledge\ModelRelationExtractor

**Methods**
- __construct(1 params) : mixed
- filename(0 params) : string
- generate(0 params) : string

---

## ModelsKnowledgeGenerator

**Namespace**
App\Services\Documentation\Knowledge

**Dependencies**
- App\Services\Documentation\Scanner\ProjectScanner
- App\Services\Documentation\Reflection\ReflectionEngine

**Methods**
- __construct(2 params) : mixed
- filename(0 params) : string
- generate(0 params) : string

---

## ModelsSection

**Namespace**
App\Services\Documentation\Sections

**Dependencies**
- None

**Methods**
- generate(0 params) : string

---

## ModuleExtractor

**Namespace**
App\Services\Documentation\Knowledge

**Dependencies**
- App\Services\Documentation\Scanner\ProjectScanner

**Methods**
- __construct(1 params) : mixed
- extract(0 params) : array

---

## ModulesKnowledgeGenerator

**Namespace**
App\Services\Documentation\Knowledge

**Dependencies**
- App\Services\Documentation\Scanner\ProjectScanner

**Methods**
- __construct(1 params) : mixed
- filename(0 params) : string
- generate(0 params) : string

---

## NotificationService

**Namespace**
App\Services

**Dependencies**
- None

**Methods**
- createReminder(2 params) : mixed

---

## PackageService

**Namespace**
App\Services\Package

**Dependencies**
- None

**Methods**
- paginate(0 params) : Illuminate\Contracts\Pagination\LengthAwarePaginator
- create(1 params) : App\Models\Package
- update(2 params) : App\Models\Package
- delete(1 params) : void

---

## PaymentService

**Namespace**
App\Services\Payment

**Dependencies**
- None

**Methods**
- create(1 params) : App\Models\Payment

---

## ProjectBibleService

**Namespace**
App\Services\Documentation

**Dependencies**
- None

**Methods**
- generate(0 params) : string

---

## ProjectScanner

**Namespace**
App\Services\Documentation\Scanner

**Dependencies**
- App\Services\Documentation\Scanner\FileScanner
- App\Services\Documentation\Scanner\ClassFinder
- App\Services\Documentation\Scanner\MetadataExtractor

**Methods**
- __construct(3 params) : mixed
- models(0 params) : array
- services(0 params) : array
- controllers(0 params) : array
- repositories(0 params) : array
- actions(0 params) : array
- all(0 params) : array

---

## ProjectStateExtractor

**Namespace**
App\Services\Documentation\Knowledge

**Dependencies**
- App\Services\Documentation\Scanner\ProjectScanner

**Methods**
- __construct(1 params) : mixed
- extract(0 params) : array

---

## ProjectStateKnowledgeGenerator

**Namespace**
App\Services\Documentation\Knowledge

**Dependencies**
- App\Services\Documentation\Knowledge\ProjectStateExtractor

**Methods**
- __construct(1 params) : mixed
- filename(0 params) : string
- generate(0 params) : string

---

## ProjectSummaryGenerator

**Namespace**
App\Services\Documentation\Knowledge

**Dependencies**
- App\Services\Documentation\Scanner\ProjectScanner

**Methods**
- __construct(1 params) : mixed
- generate(0 params) : string
- filename(0 params) : string

---

## PropertyReflector

**Namespace**
App\Services\Documentation\Reflection

**Dependencies**
- None

**Methods**
- reflect(1 params) : array

---

## ReflectionEngine

**Namespace**
App\Services\Documentation\Reflection

**Dependencies**
- App\Services\Documentation\Reflection\MethodReflector
- App\Services\Documentation\Reflection\PropertyReflector
- App\Services\Documentation\Reflection\ConstructorReflector

**Methods**
- __construct(3 params) : mixed
- reflect(1 params) : array

---

## RepositoryDocumentationGenerator

**Namespace**
App\Services\Documentation\Generators

**Dependencies**
- App\Services\Documentation\Scanner\ProjectScanner

**Methods**
- __construct(1 params) : mixed
- priority(0 params) : int
- generate(0 params) : string
- filename(0 params) : string

---

## RouteExtractor

**Namespace**
App\Services\Documentation\Knowledge

**Dependencies**
- None

**Methods**
- extract(0 params) : array

---

## RoutesKnowledgeGenerator

**Namespace**
App\Services\Documentation\Knowledge

**Dependencies**
- App\Services\Documentation\Knowledge\RouteExtractor

**Methods**
- __construct(1 params) : mixed
- filename(0 params) : string
- generate(0 params) : string

---

## ServiceDocumentationGenerator

**Namespace**
App\Services\Documentation\Generators

**Dependencies**
- App\Services\Documentation\Scanner\ProjectScanner

**Methods**
- __construct(1 params) : mixed
- generate(0 params) : string
- priority(0 params) : int
- filename(0 params) : string

---

## ServiceUsageExtractor

**Namespace**
App\Services\Documentation\Knowledge

**Dependencies**
- App\Services\Documentation\Scanner\ProjectScanner

**Methods**
- __construct(1 params) : mixed
- extract(0 params) : array

---

## ServiceUsageKnowledgeGenerator

**Namespace**
App\Services\Documentation\Knowledge

**Dependencies**
- App\Services\Documentation\Knowledge\ServiceUsageExtractor

**Methods**
- __construct(1 params) : mixed
- filename(0 params) : string
- generate(0 params) : string

---

## ServicesKnowledgeGenerator

**Namespace**
App\Services\Documentation\Knowledge

**Dependencies**
- App\Services\Documentation\Scanner\ProjectScanner
- App\Services\Documentation\Reflection\ReflectionEngine

**Methods**
- __construct(2 params) : mixed
- filename(0 params) : string
- generate(0 params) : string

---

## ServicesSection

**Namespace**
App\Services\Documentation\Sections

**Dependencies**
- None

**Methods**
- generate(0 params) : string

---

## StatisticsGenerator

**Namespace**
App\Services\Documentation\Knowledge

**Dependencies**
- App\Services\Documentation\Scanner\ProjectScanner

**Methods**
- __construct(1 params) : mixed
- generate(0 params) : string
- filename(0 params) : string

---

## SubscriptionActivationService

**Namespace**
App\Services\Subscription

**Dependencies**
- App\Contracts\MikrotikServiceInterface

**Methods**
- __construct(1 params) : mixed
- activate(1 params) : bool

---

## SubscriptionActivityService

**Namespace**
App\Services\Activity

**Dependencies**
- None

**Methods**
- log(4 params) : App\Models\ActivityLog

---

## SubscriptionExpirationService

**Namespace**
App\Services\Subscription

**Dependencies**
- App\Actions\Subscription\ExpireSubscriptionAction

**Methods**
- __construct(1 params) : mixed
- expire(1 params) : bool

---

## SubscriptionLifecycleService

**Namespace**
App\Services\Subscription

**Dependencies**
- App\Actions\Subscription\ActivateSubscriptionAction
- App\Actions\Subscription\SuspendSubscriptionAction
- App\Actions\Subscription\ExpireSubscriptionAction
- App\Actions\Subscription\RenewSubscriptionAction
- App\Actions\Subscription\RestoreSubscriptionAction

**Methods**
- __construct(5 params) : mixed
- activate(1 params) : bool
- suspend(1 params) : bool
- expire(1 params) : bool
- renew(2 params) : bool
- restore(1 params) : bool

---

## SubscriptionRenewalService

**Namespace**
App\Services

**Dependencies**
- App\Contracts\MikrotikServiceInterface

**Methods**
- __construct(1 params) : mixed
- renewPppoe(1 params) : bool
- renewHotspot(1 params) : bool

---

## SubscriptionService

**Namespace**
App\Services\Subscription

**Dependencies**
- App\Contracts\Repositories\SubscriptionRepositoryInterface
- App\Services\Network\MikrotikService
- App\Actions\Subscription\ActivateSubscriptionAction
- App\Actions\Subscription\SuspendSubscriptionAction
- App\Actions\Subscription\ExpireSubscriptionAction
- App\Actions\Subscription\RestoreSubscriptionAction
- App\Actions\Subscription\RenewSubscriptionAction

**Methods**
- __construct(7 params) : mixed
- getAllSubscriptions(2 params) : mixed
- getSubscriptionById(1 params) : ?App\Models\Subscription
- getCustomerSubscriptions(1 params) : array
- getActiveSubscriptions(0 params) : array
- getExpiredSubscriptions(0 params) : array
- createSubscription(1 params) : App\Models\Subscription
- updateSubscription(2 params) : App\Models\Subscription
- renewSubscription(2 params) : App\Models\Subscription
- cancelSubscription(1 params) : bool
- getSubscriptionStats(0 params) : array
- getExpiringSubscriptions(1 params) : array
- autoExpireSubscriptions(0 params) : int
- searchSubscriptions(2 params) : mixed
- activate(1 params) : bool
- suspend(1 params) : bool
- expire(1 params) : bool
- restore(1 params) : bool
- renew(2 params) : bool

---

## SubscriptionSuspensionService

**Namespace**
App\Services\Subscription

**Dependencies**
- App\Actions\Subscription\SuspendSubscriptionAction

**Methods**
- __construct(1 params) : mixed
- suspend(1 params) : bool

---

## TelegramNotificationService

**Namespace**
App\Services

**Dependencies**
- None

**Methods**
- __construct(0 params) : mixed
- sendMessage(1 params) : mixed
- sendDeviceAlert(1 params) : mixed

---

## TestCoverageExtractor

**Namespace**
App\Services\Documentation\Knowledge

**Dependencies**
- None

**Methods**
- extract(0 params) : array

---

## TicketService

**Namespace**
App\Services\Ticket

**Dependencies**
- None

**Methods**
- createFromAdmin(2 params) : App\Models\Ticket
- createFromCustomer(2 params) : App\Models\Ticket
- updateFromAdmin(3 params) : App\Models\Ticket
- delete(2 params) : void
- replyAsStaff(3 params) : App\Models\TicketReply
- replyAsCustomer(3 params) : App\Models\TicketReply
- changeStatus(3 params) : App\Models\Ticket
- closeByCustomer(1 params) : App\Models\Ticket
- assign(3 params) : App\Models\Ticket
- adminDashboardStats(0 params) : array
- customerDashboardStats(1 params) : array

---

## TodoGenerator

**Namespace**
App\Services\Documentation\Knowledge

**Dependencies**
- None

**Methods**
- extract(0 params) : array

---

## TodoKnowledgeGenerator

**Namespace**
App\Services\Documentation\Knowledge

**Dependencies**
- App\Services\Documentation\Knowledge\TodoGenerator

**Methods**
- __construct(1 params) : mixed
- filename(0 params) : string
- generate(0 params) : string

---

## WalletService

**Namespace**
App\Services

**Dependencies**
- None

**Methods**
- deposit(4 params) : void
- deduct(4 params) : void

---

---

# Models

---

## ActivityLog

**Namespace**

```
App\Models
```

**File**

```
/var/www/app/Models/ActivityLog.php
```

**Properties**

- $fillable : mixed
- $appends : mixed
- $connection : mixed
- $table : mixed
- $primaryKey : mixed
- $keyType : mixed
- $incrementing : mixed
- $with : mixed
- $withCount : mixed
- $preventsLazyLoading : mixed
- $perPage : mixed
- $exists : mixed
- $wasRecentlyCreated : mixed
- $escapeWhenCastingToString : mixed
- $resolver : mixed
- $dispatcher : mixed
- $booting : mixed
- $booted : mixed
- $bootedCallbacks : mixed
- $traitInitializers : mixed
- $globalScopes : mixed
- $ignoreOnTouch : mixed
- $modelsShouldPreventLazyLoading : mixed
- $modelsShouldAutomaticallyEagerLoadRelationships : mixed
- $lazyLoadingViolationCallback : mixed
- $modelsShouldPreventSilentlyDiscardingAttributes : mixed
- $discardedAttributeViolationCallback : mixed
- $modelsShouldPreventAccessingMissingAttributes : mixed
- $missingAttributeViolationCallback : mixed
- $isBroadcasting : mixed
- $builder : string
- $collectionClass : string
- $isSoftDeletable : array
- $isPrunable : array
- $isMassPrunable : array
- $classAttributes : array
- $attributes : mixed
- $original : mixed
- $changes : mixed
- $previous : mixed
- $casts : mixed
- $classCastCache : mixed
- $attributeCastCache : mixed
- $primitiveCastTypes : mixed
- $dateFormat : mixed
- $snakeAttributes : mixed
- $mutatorCache : mixed
- $attributeMutatorCache : mixed
- $getAttributeMutatorCache : mixed
- $setAttributeMutatorCache : mixed
- $castTypeCache : mixed
- $encrypter : mixed
- $dispatchesEvents : mixed
- $observables : mixed
- $relations : mixed
- $touches : mixed
- $relationAutoloadCallback : mixed
- $relationAutoloadContext : mixed
- $manyMethods : mixed
- $relationResolvers : mixed
- $timestamps : mixed
- $ignoreTimestampsOn : mixed
- $usesUniqueIds : mixed
- $hidden : mixed
- $visible : mixed
- $guarded : mixed
- $unguarded : mixed
- $guardableColumns : mixed
- $recursionCache : mixed
- $resolvedCollectionClasses : array

**Methods**

- getIconAttribute()
- getColorAttribute()
- getTitleAttribute()
- tenant()
- user()

---

## Customer

**Namespace**

```
App\Models
```

**File**

```
/var/www/app/Models/Customer.php
```

**Properties**

- $fillable : mixed
- $hidden : mixed
- $casts : mixed
- $connection : mixed
- $table : mixed
- $primaryKey : mixed
- $keyType : mixed
- $incrementing : mixed
- $with : mixed
- $withCount : mixed
- $preventsLazyLoading : mixed
- $perPage : mixed
- $exists : mixed
- $wasRecentlyCreated : mixed
- $escapeWhenCastingToString : mixed
- $resolver : mixed
- $dispatcher : mixed
- $booting : mixed
- $booted : mixed
- $bootedCallbacks : mixed
- $traitInitializers : mixed
- $globalScopes : mixed
- $ignoreOnTouch : mixed
- $modelsShouldPreventLazyLoading : mixed
- $modelsShouldAutomaticallyEagerLoadRelationships : mixed
- $lazyLoadingViolationCallback : mixed
- $modelsShouldPreventSilentlyDiscardingAttributes : mixed
- $discardedAttributeViolationCallback : mixed
- $modelsShouldPreventAccessingMissingAttributes : mixed
- $missingAttributeViolationCallback : mixed
- $isBroadcasting : mixed
- $builder : string
- $collectionClass : string
- $isSoftDeletable : array
- $isPrunable : array
- $isMassPrunable : array
- $classAttributes : array
- $attributes : mixed
- $original : mixed
- $changes : mixed
- $previous : mixed
- $classCastCache : mixed
- $attributeCastCache : mixed
- $primitiveCastTypes : mixed
- $dateFormat : mixed
- $appends : mixed
- $snakeAttributes : mixed
- $mutatorCache : mixed
- $attributeMutatorCache : mixed
- $getAttributeMutatorCache : mixed
- $setAttributeMutatorCache : mixed
- $castTypeCache : mixed
- $encrypter : mixed
- $dispatchesEvents : mixed
- $observables : mixed
- $relations : mixed
- $touches : mixed
- $relationAutoloadCallback : mixed
- $relationAutoloadContext : mixed
- $manyMethods : mixed
- $relationResolvers : mixed
- $timestamps : mixed
- $ignoreTimestampsOn : mixed
- $usesUniqueIds : mixed
- $visible : mixed
- $guarded : mixed
- $unguarded : mixed
- $guardableColumns : mixed
- $recursionCache : mixed
- $resolvedCollectionClasses : array
- $authPasswordName : mixed
- $rememberTokenName : mixed
- $accessToken : mixed

**Methods**

- subscriptions()
- walletTransactions()
- notifications()
- factory()
- tokens()
- tokenCan()
- tokenCant()
- createToken()
- generateTokenString()
- currentAccessToken()
- withAccessToken()
- readNotifications()
- unreadNotifications()
- notify()
- notifyNow()
- routeNotificationFor()

---

## Device

**Namespace**

```
App\Models
```

**File**

```
/var/www/app/Models/Device.php
```

**Properties**

- $fillable : mixed
- $connection : mixed
- $table : mixed
- $primaryKey : mixed
- $keyType : mixed
- $incrementing : mixed
- $with : mixed
- $withCount : mixed
- $preventsLazyLoading : mixed
- $perPage : mixed
- $exists : mixed
- $wasRecentlyCreated : mixed
- $escapeWhenCastingToString : mixed
- $resolver : mixed
- $dispatcher : mixed
- $booting : mixed
- $booted : mixed
- $bootedCallbacks : mixed
- $traitInitializers : mixed
- $globalScopes : mixed
- $ignoreOnTouch : mixed
- $modelsShouldPreventLazyLoading : mixed
- $modelsShouldAutomaticallyEagerLoadRelationships : mixed
- $lazyLoadingViolationCallback : mixed
- $modelsShouldPreventSilentlyDiscardingAttributes : mixed
- $discardedAttributeViolationCallback : mixed
- $modelsShouldPreventAccessingMissingAttributes : mixed
- $missingAttributeViolationCallback : mixed
- $isBroadcasting : mixed
- $builder : string
- $collectionClass : string
- $isSoftDeletable : array
- $isPrunable : array
- $isMassPrunable : array
- $classAttributes : array
- $attributes : mixed
- $original : mixed
- $changes : mixed
- $previous : mixed
- $casts : mixed
- $classCastCache : mixed
- $attributeCastCache : mixed
- $primitiveCastTypes : mixed
- $dateFormat : mixed
- $appends : mixed
- $snakeAttributes : mixed
- $mutatorCache : mixed
- $attributeMutatorCache : mixed
- $getAttributeMutatorCache : mixed
- $setAttributeMutatorCache : mixed
- $castTypeCache : mixed
- $encrypter : mixed
- $dispatchesEvents : mixed
- $observables : mixed
- $relations : mixed
- $touches : mixed
- $relationAutoloadCallback : mixed
- $relationAutoloadContext : mixed
- $manyMethods : mixed
- $relationResolvers : mixed
- $timestamps : mixed
- $ignoreTimestampsOn : mixed
- $usesUniqueIds : mixed
- $hidden : mixed
- $visible : mixed
- $guarded : mixed
- $unguarded : mixed
- $guardableColumns : mixed
- $recursionCache : mixed
- $resolvedCollectionClasses : array

**Methods**

- tenant()
- customer()

---

## DeviceAssignment

**Namespace**

```
App\Models
```

**File**

```
/var/www/app/Models/DeviceAssignment.php
```

**Properties**

- $fillable : mixed
- $casts : mixed
- $connection : mixed
- $table : mixed
- $primaryKey : mixed
- $keyType : mixed
- $incrementing : mixed
- $with : mixed
- $withCount : mixed
- $preventsLazyLoading : mixed
- $perPage : mixed
- $exists : mixed
- $wasRecentlyCreated : mixed
- $escapeWhenCastingToString : mixed
- $resolver : mixed
- $dispatcher : mixed
- $booting : mixed
- $booted : mixed
- $bootedCallbacks : mixed
- $traitInitializers : mixed
- $globalScopes : mixed
- $ignoreOnTouch : mixed
- $modelsShouldPreventLazyLoading : mixed
- $modelsShouldAutomaticallyEagerLoadRelationships : mixed
- $lazyLoadingViolationCallback : mixed
- $modelsShouldPreventSilentlyDiscardingAttributes : mixed
- $discardedAttributeViolationCallback : mixed
- $modelsShouldPreventAccessingMissingAttributes : mixed
- $missingAttributeViolationCallback : mixed
- $isBroadcasting : mixed
- $builder : string
- $collectionClass : string
- $isSoftDeletable : array
- $isPrunable : array
- $isMassPrunable : array
- $classAttributes : array
- $attributes : mixed
- $original : mixed
- $changes : mixed
- $previous : mixed
- $classCastCache : mixed
- $attributeCastCache : mixed
- $primitiveCastTypes : mixed
- $dateFormat : mixed
- $appends : mixed
- $snakeAttributes : mixed
- $mutatorCache : mixed
- $attributeMutatorCache : mixed
- $getAttributeMutatorCache : mixed
- $setAttributeMutatorCache : mixed
- $castTypeCache : mixed
- $encrypter : mixed
- $dispatchesEvents : mixed
- $observables : mixed
- $relations : mixed
- $touches : mixed
- $relationAutoloadCallback : mixed
- $relationAutoloadContext : mixed
- $manyMethods : mixed
- $relationResolvers : mixed
- $timestamps : mixed
- $ignoreTimestampsOn : mixed
- $usesUniqueIds : mixed
- $hidden : mixed
- $visible : mixed
- $guarded : mixed
- $unguarded : mixed
- $guardableColumns : mixed
- $recursionCache : mixed
- $resolvedCollectionClasses : array

**Methods**

- tenant()
- customer()
- device()

---

## HotspotSubscription

**Namespace**

```
App\Models
```

**File**

```
/var/www/app/Models/HotspotSubscription.php
```

**Properties**

- $fillable : mixed
- $casts : mixed
- $connection : mixed
- $table : mixed
- $primaryKey : mixed
- $keyType : mixed
- $incrementing : mixed
- $with : mixed
- $withCount : mixed
- $preventsLazyLoading : mixed
- $perPage : mixed
- $exists : mixed
- $wasRecentlyCreated : mixed
- $escapeWhenCastingToString : mixed
- $resolver : mixed
- $dispatcher : mixed
- $booting : mixed
- $booted : mixed
- $bootedCallbacks : mixed
- $traitInitializers : mixed
- $globalScopes : mixed
- $ignoreOnTouch : mixed
- $modelsShouldPreventLazyLoading : mixed
- $modelsShouldAutomaticallyEagerLoadRelationships : mixed
- $lazyLoadingViolationCallback : mixed
- $modelsShouldPreventSilentlyDiscardingAttributes : mixed
- $discardedAttributeViolationCallback : mixed
- $modelsShouldPreventAccessingMissingAttributes : mixed
- $missingAttributeViolationCallback : mixed
- $isBroadcasting : mixed
- $builder : string
- $collectionClass : string
- $isSoftDeletable : array
- $isPrunable : array
- $isMassPrunable : array
- $classAttributes : array
- $attributes : mixed
- $original : mixed
- $changes : mixed
- $previous : mixed
- $classCastCache : mixed
- $attributeCastCache : mixed
- $primitiveCastTypes : mixed
- $dateFormat : mixed
- $appends : mixed
- $snakeAttributes : mixed
- $mutatorCache : mixed
- $attributeMutatorCache : mixed
- $getAttributeMutatorCache : mixed
- $setAttributeMutatorCache : mixed
- $castTypeCache : mixed
- $encrypter : mixed
- $dispatchesEvents : mixed
- $observables : mixed
- $relations : mixed
- $touches : mixed
- $relationAutoloadCallback : mixed
- $relationAutoloadContext : mixed
- $manyMethods : mixed
- $relationResolvers : mixed
- $timestamps : mixed
- $ignoreTimestampsOn : mixed
- $usesUniqueIds : mixed
- $hidden : mixed
- $visible : mixed
- $guarded : mixed
- $unguarded : mixed
- $guardableColumns : mixed
- $recursionCache : mixed
- $resolvedCollectionClasses : array

**Methods**

- tenant()
- customer()
- package()
- invoices()

---

## HotspotUser

**Namespace**

```
App\Models
```

**File**

```
/var/www/app/Models/HotspotUser.php
```

**Properties**

- $table : mixed
- $fillable : mixed
- $casts : mixed
- $hidden : mixed
- $connection : mixed
- $primaryKey : mixed
- $keyType : mixed
- $incrementing : mixed
- $with : mixed
- $withCount : mixed
- $preventsLazyLoading : mixed
- $perPage : mixed
- $exists : mixed
- $wasRecentlyCreated : mixed
- $escapeWhenCastingToString : mixed
- $resolver : mixed
- $dispatcher : mixed
- $booting : mixed
- $booted : mixed
- $bootedCallbacks : mixed
- $traitInitializers : mixed
- $globalScopes : mixed
- $ignoreOnTouch : mixed
- $modelsShouldPreventLazyLoading : mixed
- $modelsShouldAutomaticallyEagerLoadRelationships : mixed
- $lazyLoadingViolationCallback : mixed
- $modelsShouldPreventSilentlyDiscardingAttributes : mixed
- $discardedAttributeViolationCallback : mixed
- $modelsShouldPreventAccessingMissingAttributes : mixed
- $missingAttributeViolationCallback : mixed
- $isBroadcasting : mixed
- $builder : string
- $collectionClass : string
- $isSoftDeletable : array
- $isPrunable : array
- $isMassPrunable : array
- $classAttributes : array
- $attributes : mixed
- $original : mixed
- $changes : mixed
- $previous : mixed
- $classCastCache : mixed
- $attributeCastCache : mixed
- $primitiveCastTypes : mixed
- $dateFormat : mixed
- $appends : mixed
- $snakeAttributes : mixed
- $mutatorCache : mixed
- $attributeMutatorCache : mixed
- $getAttributeMutatorCache : mixed
- $setAttributeMutatorCache : mixed
- $castTypeCache : mixed
- $encrypter : mixed
- $dispatchesEvents : mixed
- $observables : mixed
- $relations : mixed
- $touches : mixed
- $relationAutoloadCallback : mixed
- $relationAutoloadContext : mixed
- $manyMethods : mixed
- $relationResolvers : mixed
- $timestamps : mixed
- $ignoreTimestampsOn : mixed
- $usesUniqueIds : mixed
- $visible : mixed
- $guarded : mixed
- $unguarded : mixed
- $guardableColumns : mixed
- $recursionCache : mixed
- $resolvedCollectionClasses : array
- $forceDeleting : mixed

**Methods**

- customer()
- device()
- scopeActive()
- scopeOnline()
- scopeExpired()
- isActive()
- isOnline()
- getUptimeFormatted()
- getTrafficFormatted()
- forceDelete()
- forceDestroy()
- factory()
- bootSoftDeletes()
- initializeSoftDeletes()
- forceDeleteQuietly()
- restore()
- restoreQuietly()
- trashed()
- softDeleted()
- restoring()
- restored()
- forceDeleting()
- forceDeleted()
- isForceDeleting()
- getDeletedAtColumn()
- getQualifiedDeletedAtColumn()

---

## Inventory

**Namespace**

```
App\Models
```

**File**

```
/var/www/app/Models/Inventory.php
```

**Properties**

- $fillable : mixed
- $connection : mixed
- $table : mixed
- $primaryKey : mixed
- $keyType : mixed
- $incrementing : mixed
- $with : mixed
- $withCount : mixed
- $preventsLazyLoading : mixed
- $perPage : mixed
- $exists : mixed
- $wasRecentlyCreated : mixed
- $escapeWhenCastingToString : mixed
- $resolver : mixed
- $dispatcher : mixed
- $booting : mixed
- $booted : mixed
- $bootedCallbacks : mixed
- $traitInitializers : mixed
- $globalScopes : mixed
- $ignoreOnTouch : mixed
- $modelsShouldPreventLazyLoading : mixed
- $modelsShouldAutomaticallyEagerLoadRelationships : mixed
- $lazyLoadingViolationCallback : mixed
- $modelsShouldPreventSilentlyDiscardingAttributes : mixed
- $discardedAttributeViolationCallback : mixed
- $modelsShouldPreventAccessingMissingAttributes : mixed
- $missingAttributeViolationCallback : mixed
- $isBroadcasting : mixed
- $builder : string
- $collectionClass : string
- $isSoftDeletable : array
- $isPrunable : array
- $isMassPrunable : array
- $classAttributes : array
- $attributes : mixed
- $original : mixed
- $changes : mixed
- $previous : mixed
- $casts : mixed
- $classCastCache : mixed
- $attributeCastCache : mixed
- $primitiveCastTypes : mixed
- $dateFormat : mixed
- $appends : mixed
- $snakeAttributes : mixed
- $mutatorCache : mixed
- $attributeMutatorCache : mixed
- $getAttributeMutatorCache : mixed
- $setAttributeMutatorCache : mixed
- $castTypeCache : mixed
- $encrypter : mixed
- $dispatchesEvents : mixed
- $observables : mixed
- $relations : mixed
- $touches : mixed
- $relationAutoloadCallback : mixed
- $relationAutoloadContext : mixed
- $manyMethods : mixed
- $relationResolvers : mixed
- $timestamps : mixed
- $ignoreTimestampsOn : mixed
- $usesUniqueIds : mixed
- $hidden : mixed
- $visible : mixed
- $guarded : mixed
- $unguarded : mixed
- $guardableColumns : mixed
- $recursionCache : mixed
- $resolvedCollectionClasses : array

**Methods**

- tenant()
- isLowStock()

---

## Invoice

**Namespace**

```
App\Models
```

**File**

```
/var/www/app/Models/Invoice.php
```

**Properties**

- $fillable : mixed
- $casts : mixed
- $connection : mixed
- $table : mixed
- $primaryKey : mixed
- $keyType : mixed
- $incrementing : mixed
- $with : mixed
- $withCount : mixed
- $preventsLazyLoading : mixed
- $perPage : mixed
- $exists : mixed
- $wasRecentlyCreated : mixed
- $escapeWhenCastingToString : mixed
- $resolver : mixed
- $dispatcher : mixed
- $booting : mixed
- $booted : mixed
- $bootedCallbacks : mixed
- $traitInitializers : mixed
- $globalScopes : mixed
- $ignoreOnTouch : mixed
- $modelsShouldPreventLazyLoading : mixed
- $modelsShouldAutomaticallyEagerLoadRelationships : mixed
- $lazyLoadingViolationCallback : mixed
- $modelsShouldPreventSilentlyDiscardingAttributes : mixed
- $discardedAttributeViolationCallback : mixed
- $modelsShouldPreventAccessingMissingAttributes : mixed
- $missingAttributeViolationCallback : mixed
- $isBroadcasting : mixed
- $builder : string
- $collectionClass : string
- $isSoftDeletable : array
- $isPrunable : array
- $isMassPrunable : array
- $classAttributes : array
- $attributes : mixed
- $original : mixed
- $changes : mixed
- $previous : mixed
- $classCastCache : mixed
- $attributeCastCache : mixed
- $primitiveCastTypes : mixed
- $dateFormat : mixed
- $appends : mixed
- $snakeAttributes : mixed
- $mutatorCache : mixed
- $attributeMutatorCache : mixed
- $getAttributeMutatorCache : mixed
- $setAttributeMutatorCache : mixed
- $castTypeCache : mixed
- $encrypter : mixed
- $dispatchesEvents : mixed
- $observables : mixed
- $relations : mixed
- $touches : mixed
- $relationAutoloadCallback : mixed
- $relationAutoloadContext : mixed
- $manyMethods : mixed
- $relationResolvers : mixed
- $timestamps : mixed
- $ignoreTimestampsOn : mixed
- $usesUniqueIds : mixed
- $hidden : mixed
- $visible : mixed
- $guarded : mixed
- $unguarded : mixed
- $guardableColumns : mixed
- $recursionCache : mixed
- $resolvedCollectionClasses : array

**Methods**

- tenant()
- customer()
- subscription()
- payments()
- hotspotSubscription()
- factory()

---

## NetworkDevice

**Namespace**

```
App\Models
```

**File**

```
/var/www/app/Models/NetworkDevice.php
```

**Properties**

- $fillable : mixed
- $casts : mixed
- $hidden : mixed
- $connection : mixed
- $table : mixed
- $primaryKey : mixed
- $keyType : mixed
- $incrementing : mixed
- $with : mixed
- $withCount : mixed
- $preventsLazyLoading : mixed
- $perPage : mixed
- $exists : mixed
- $wasRecentlyCreated : mixed
- $escapeWhenCastingToString : mixed
- $resolver : mixed
- $dispatcher : mixed
- $booting : mixed
- $booted : mixed
- $bootedCallbacks : mixed
- $traitInitializers : mixed
- $globalScopes : mixed
- $ignoreOnTouch : mixed
- $modelsShouldPreventLazyLoading : mixed
- $modelsShouldAutomaticallyEagerLoadRelationships : mixed
- $lazyLoadingViolationCallback : mixed
- $modelsShouldPreventSilentlyDiscardingAttributes : mixed
- $discardedAttributeViolationCallback : mixed
- $modelsShouldPreventAccessingMissingAttributes : mixed
- $missingAttributeViolationCallback : mixed
- $isBroadcasting : mixed
- $builder : string
- $collectionClass : string
- $isSoftDeletable : array
- $isPrunable : array
- $isMassPrunable : array
- $classAttributes : array
- $attributes : mixed
- $original : mixed
- $changes : mixed
- $previous : mixed
- $classCastCache : mixed
- $attributeCastCache : mixed
- $primitiveCastTypes : mixed
- $dateFormat : mixed
- $appends : mixed
- $snakeAttributes : mixed
- $mutatorCache : mixed
- $attributeMutatorCache : mixed
- $getAttributeMutatorCache : mixed
- $setAttributeMutatorCache : mixed
- $castTypeCache : mixed
- $encrypter : mixed
- $dispatchesEvents : mixed
- $observables : mixed
- $relations : mixed
- $touches : mixed
- $relationAutoloadCallback : mixed
- $relationAutoloadContext : mixed
- $manyMethods : mixed
- $relationResolvers : mixed
- $timestamps : mixed
- $ignoreTimestampsOn : mixed
- $usesUniqueIds : mixed
- $visible : mixed
- $guarded : mixed
- $unguarded : mixed
- $guardableColumns : mixed
- $recursionCache : mixed
- $resolvedCollectionClasses : array
- $forceDeleting : mixed

**Methods**

- pppoeUsers()
- isOnline()
- updateOnlineStatus()
- scopeActive()
- scopeOnline()
- scopeMikrotik()
- forceDelete()
- forceDestroy()
- factory()
- bootSoftDeletes()
- initializeSoftDeletes()
- forceDeleteQuietly()
- restore()
- restoreQuietly()
- trashed()
- softDeleted()
- restoring()
- restored()
- forceDeleting()
- forceDeleted()
- isForceDeleting()
- getDeletedAtColumn()
- getQualifiedDeletedAtColumn()

---

## Notification

**Namespace**

```
App\Models
```

**File**

```
/var/www/app/Models/Notification.php
```

**Properties**

- $fillable : mixed
- $casts : mixed
- $connection : mixed
- $table : mixed
- $primaryKey : mixed
- $keyType : mixed
- $incrementing : mixed
- $with : mixed
- $withCount : mixed
- $preventsLazyLoading : mixed
- $perPage : mixed
- $exists : mixed
- $wasRecentlyCreated : mixed
- $escapeWhenCastingToString : mixed
- $resolver : mixed
- $dispatcher : mixed
- $booting : mixed
- $booted : mixed
- $bootedCallbacks : mixed
- $traitInitializers : mixed
- $globalScopes : mixed
- $ignoreOnTouch : mixed
- $modelsShouldPreventLazyLoading : mixed
- $modelsShouldAutomaticallyEagerLoadRelationships : mixed
- $lazyLoadingViolationCallback : mixed
- $modelsShouldPreventSilentlyDiscardingAttributes : mixed
- $discardedAttributeViolationCallback : mixed
- $modelsShouldPreventAccessingMissingAttributes : mixed
- $missingAttributeViolationCallback : mixed
- $isBroadcasting : mixed
- $builder : string
- $collectionClass : string
- $isSoftDeletable : array
- $isPrunable : array
- $isMassPrunable : array
- $classAttributes : array
- $attributes : mixed
- $original : mixed
- $changes : mixed
- $previous : mixed
- $classCastCache : mixed
- $attributeCastCache : mixed
- $primitiveCastTypes : mixed
- $dateFormat : mixed
- $appends : mixed
- $snakeAttributes : mixed
- $mutatorCache : mixed
- $attributeMutatorCache : mixed
- $getAttributeMutatorCache : mixed
- $setAttributeMutatorCache : mixed
- $castTypeCache : mixed
- $encrypter : mixed
- $dispatchesEvents : mixed
- $observables : mixed
- $relations : mixed
- $touches : mixed
- $relationAutoloadCallback : mixed
- $relationAutoloadContext : mixed
- $manyMethods : mixed
- $relationResolvers : mixed
- $timestamps : mixed
- $ignoreTimestampsOn : mixed
- $usesUniqueIds : mixed
- $hidden : mixed
- $visible : mixed
- $guarded : mixed
- $unguarded : mixed
- $guardableColumns : mixed
- $recursionCache : mixed
- $resolvedCollectionClasses : array

---

## PPPoEUser

**Namespace**

```
App\Models
```

**File**

```
/var/www/app/Models/PPPoEUser.php
```

**Properties**

- $table : mixed
- $fillable : mixed
- $casts : mixed
- $hidden : mixed
- $connection : mixed
- $primaryKey : mixed
- $keyType : mixed
- $incrementing : mixed
- $with : mixed
- $withCount : mixed
- $preventsLazyLoading : mixed
- $perPage : mixed
- $exists : mixed
- $wasRecentlyCreated : mixed
- $escapeWhenCastingToString : mixed
- $resolver : mixed
- $dispatcher : mixed
- $booting : mixed
- $booted : mixed
- $bootedCallbacks : mixed
- $traitInitializers : mixed
- $globalScopes : mixed
- $ignoreOnTouch : mixed
- $modelsShouldPreventLazyLoading : mixed
- $modelsShouldAutomaticallyEagerLoadRelationships : mixed
- $lazyLoadingViolationCallback : mixed
- $modelsShouldPreventSilentlyDiscardingAttributes : mixed
- $discardedAttributeViolationCallback : mixed
- $modelsShouldPreventAccessingMissingAttributes : mixed
- $missingAttributeViolationCallback : mixed
- $isBroadcasting : mixed
- $builder : string
- $collectionClass : string
- $isSoftDeletable : array
- $isPrunable : array
- $isMassPrunable : array
- $classAttributes : array
- $attributes : mixed
- $original : mixed
- $changes : mixed
- $previous : mixed
- $classCastCache : mixed
- $attributeCastCache : mixed
- $primitiveCastTypes : mixed
- $dateFormat : mixed
- $appends : mixed
- $snakeAttributes : mixed
- $mutatorCache : mixed
- $attributeMutatorCache : mixed
- $getAttributeMutatorCache : mixed
- $setAttributeMutatorCache : mixed
- $castTypeCache : mixed
- $encrypter : mixed
- $dispatchesEvents : mixed
- $observables : mixed
- $relations : mixed
- $touches : mixed
- $relationAutoloadCallback : mixed
- $relationAutoloadContext : mixed
- $manyMethods : mixed
- $relationResolvers : mixed
- $timestamps : mixed
- $ignoreTimestampsOn : mixed
- $usesUniqueIds : mixed
- $visible : mixed
- $guarded : mixed
- $unguarded : mixed
- $guardableColumns : mixed
- $recursionCache : mixed
- $resolvedCollectionClasses : array
- $forceDeleting : mixed

**Methods**

- customer()
- device()
- isActive()
- isOnline()
- updateOnlineStatus()
- scopeActive()
- scopeOnline()
- scopeDisabled()
- forceDelete()
- forceDestroy()
- factory()
- bootSoftDeletes()
- initializeSoftDeletes()
- forceDeleteQuietly()
- restore()
- restoreQuietly()
- trashed()
- softDeleted()
- restoring()
- restored()
- forceDeleting()
- forceDeleted()
- isForceDeleting()
- getDeletedAtColumn()
- getQualifiedDeletedAtColumn()

---

## Package

**Namespace**

```
App\Models
```

**File**

```
/var/www/app/Models/Package.php
```

**Properties**

- $fillable : mixed
- $connection : mixed
- $table : mixed
- $primaryKey : mixed
- $keyType : mixed
- $incrementing : mixed
- $with : mixed
- $withCount : mixed
- $preventsLazyLoading : mixed
- $perPage : mixed
- $exists : mixed
- $wasRecentlyCreated : mixed
- $escapeWhenCastingToString : mixed
- $resolver : mixed
- $dispatcher : mixed
- $booting : mixed
- $booted : mixed
- $bootedCallbacks : mixed
- $traitInitializers : mixed
- $globalScopes : mixed
- $ignoreOnTouch : mixed
- $modelsShouldPreventLazyLoading : mixed
- $modelsShouldAutomaticallyEagerLoadRelationships : mixed
- $lazyLoadingViolationCallback : mixed
- $modelsShouldPreventSilentlyDiscardingAttributes : mixed
- $discardedAttributeViolationCallback : mixed
- $modelsShouldPreventAccessingMissingAttributes : mixed
- $missingAttributeViolationCallback : mixed
- $isBroadcasting : mixed
- $builder : string
- $collectionClass : string
- $isSoftDeletable : array
- $isPrunable : array
- $isMassPrunable : array
- $classAttributes : array
- $attributes : mixed
- $original : mixed
- $changes : mixed
- $previous : mixed
- $casts : mixed
- $classCastCache : mixed
- $attributeCastCache : mixed
- $primitiveCastTypes : mixed
- $dateFormat : mixed
- $appends : mixed
- $snakeAttributes : mixed
- $mutatorCache : mixed
- $attributeMutatorCache : mixed
- $getAttributeMutatorCache : mixed
- $setAttributeMutatorCache : mixed
- $castTypeCache : mixed
- $encrypter : mixed
- $dispatchesEvents : mixed
- $observables : mixed
- $relations : mixed
- $touches : mixed
- $relationAutoloadCallback : mixed
- $relationAutoloadContext : mixed
- $manyMethods : mixed
- $relationResolvers : mixed
- $timestamps : mixed
- $ignoreTimestampsOn : mixed
- $usesUniqueIds : mixed
- $hidden : mixed
- $visible : mixed
- $guarded : mixed
- $unguarded : mixed
- $guardableColumns : mixed
- $recursionCache : mixed
- $resolvedCollectionClasses : array

**Methods**

- tenant()
- factory()

---

## Payment

**Namespace**

```
App\Models
```

**File**

```
/var/www/app/Models/Payment.php
```

**Properties**

- $fillable : mixed
- $casts : mixed
- $connection : mixed
- $table : mixed
- $primaryKey : mixed
- $keyType : mixed
- $incrementing : mixed
- $with : mixed
- $withCount : mixed
- $preventsLazyLoading : mixed
- $perPage : mixed
- $exists : mixed
- $wasRecentlyCreated : mixed
- $escapeWhenCastingToString : mixed
- $resolver : mixed
- $dispatcher : mixed
- $booting : mixed
- $booted : mixed
- $bootedCallbacks : mixed
- $traitInitializers : mixed
- $globalScopes : mixed
- $ignoreOnTouch : mixed
- $modelsShouldPreventLazyLoading : mixed
- $modelsShouldAutomaticallyEagerLoadRelationships : mixed
- $lazyLoadingViolationCallback : mixed
- $modelsShouldPreventSilentlyDiscardingAttributes : mixed
- $discardedAttributeViolationCallback : mixed
- $modelsShouldPreventAccessingMissingAttributes : mixed
- $missingAttributeViolationCallback : mixed
- $isBroadcasting : mixed
- $builder : string
- $collectionClass : string
- $isSoftDeletable : array
- $isPrunable : array
- $isMassPrunable : array
- $classAttributes : array
- $attributes : mixed
- $original : mixed
- $changes : mixed
- $previous : mixed
- $classCastCache : mixed
- $attributeCastCache : mixed
- $primitiveCastTypes : mixed
- $dateFormat : mixed
- $appends : mixed
- $snakeAttributes : mixed
- $mutatorCache : mixed
- $attributeMutatorCache : mixed
- $getAttributeMutatorCache : mixed
- $setAttributeMutatorCache : mixed
- $castTypeCache : mixed
- $encrypter : mixed
- $dispatchesEvents : mixed
- $observables : mixed
- $relations : mixed
- $touches : mixed
- $relationAutoloadCallback : mixed
- $relationAutoloadContext : mixed
- $manyMethods : mixed
- $relationResolvers : mixed
- $timestamps : mixed
- $ignoreTimestampsOn : mixed
- $usesUniqueIds : mixed
- $hidden : mixed
- $visible : mixed
- $guarded : mixed
- $unguarded : mixed
- $guardableColumns : mixed
- $recursionCache : mixed
- $resolvedCollectionClasses : array

**Methods**

- tenant()
- invoice()
- factory()

---

## Subscription

**Namespace**

```
App\Models
```

**File**

```
/var/www/app/Models/Subscription.php
```

**Properties**

- $fillable : mixed
- $casts : mixed
- $connection : mixed
- $table : mixed
- $primaryKey : mixed
- $keyType : mixed
- $incrementing : mixed
- $with : mixed
- $withCount : mixed
- $preventsLazyLoading : mixed
- $perPage : mixed
- $exists : mixed
- $wasRecentlyCreated : mixed
- $escapeWhenCastingToString : mixed
- $resolver : mixed
- $dispatcher : mixed
- $booting : mixed
- $booted : mixed
- $bootedCallbacks : mixed
- $traitInitializers : mixed
- $globalScopes : mixed
- $ignoreOnTouch : mixed
- $modelsShouldPreventLazyLoading : mixed
- $modelsShouldAutomaticallyEagerLoadRelationships : mixed
- $lazyLoadingViolationCallback : mixed
- $modelsShouldPreventSilentlyDiscardingAttributes : mixed
- $discardedAttributeViolationCallback : mixed
- $modelsShouldPreventAccessingMissingAttributes : mixed
- $missingAttributeViolationCallback : mixed
- $isBroadcasting : mixed
- $builder : string
- $collectionClass : string
- $isSoftDeletable : array
- $isPrunable : array
- $isMassPrunable : array
- $classAttributes : array
- $attributes : mixed
- $original : mixed
- $changes : mixed
- $previous : mixed
- $classCastCache : mixed
- $attributeCastCache : mixed
- $primitiveCastTypes : mixed
- $dateFormat : mixed
- $appends : mixed
- $snakeAttributes : mixed
- $mutatorCache : mixed
- $attributeMutatorCache : mixed
- $getAttributeMutatorCache : mixed
- $setAttributeMutatorCache : mixed
- $castTypeCache : mixed
- $encrypter : mixed
- $dispatchesEvents : mixed
- $observables : mixed
- $relations : mixed
- $touches : mixed
- $relationAutoloadCallback : mixed
- $relationAutoloadContext : mixed
- $manyMethods : mixed
- $relationResolvers : mixed
- $timestamps : mixed
- $ignoreTimestampsOn : mixed
- $usesUniqueIds : mixed
- $hidden : mixed
- $visible : mixed
- $guarded : mixed
- $unguarded : mixed
- $guardableColumns : mixed
- $recursionCache : mixed
- $resolvedCollectionClasses : array

**Methods**

- tenant()
- customer()
- package()
- invoices()
- payments()
- notifications()
- activityLogs()
- activate()
- suspend()
- expire()
- restore()
- isActive()
- canActivate()
- canSuspend()
- canRenew()
- factory()

---

## Tenant

**Namespace**

```
App\Models
```

**File**

```
/var/www/app/Models/Tenant.php
```

**Properties**

- $fillable : mixed
- $connection : mixed
- $table : mixed
- $primaryKey : mixed
- $keyType : mixed
- $incrementing : mixed
- $with : mixed
- $withCount : mixed
- $preventsLazyLoading : mixed
- $perPage : mixed
- $exists : mixed
- $wasRecentlyCreated : mixed
- $escapeWhenCastingToString : mixed
- $resolver : mixed
- $dispatcher : mixed
- $booting : mixed
- $booted : mixed
- $bootedCallbacks : mixed
- $traitInitializers : mixed
- $globalScopes : mixed
- $ignoreOnTouch : mixed
- $modelsShouldPreventLazyLoading : mixed
- $modelsShouldAutomaticallyEagerLoadRelationships : mixed
- $lazyLoadingViolationCallback : mixed
- $modelsShouldPreventSilentlyDiscardingAttributes : mixed
- $discardedAttributeViolationCallback : mixed
- $modelsShouldPreventAccessingMissingAttributes : mixed
- $missingAttributeViolationCallback : mixed
- $isBroadcasting : mixed
- $builder : string
- $collectionClass : string
- $isSoftDeletable : array
- $isPrunable : array
- $isMassPrunable : array
- $classAttributes : array
- $attributes : mixed
- $original : mixed
- $changes : mixed
- $previous : mixed
- $casts : mixed
- $classCastCache : mixed
- $attributeCastCache : mixed
- $primitiveCastTypes : mixed
- $dateFormat : mixed
- $appends : mixed
- $snakeAttributes : mixed
- $mutatorCache : mixed
- $attributeMutatorCache : mixed
- $getAttributeMutatorCache : mixed
- $setAttributeMutatorCache : mixed
- $castTypeCache : mixed
- $encrypter : mixed
- $dispatchesEvents : mixed
- $observables : mixed
- $relations : mixed
- $touches : mixed
- $relationAutoloadCallback : mixed
- $relationAutoloadContext : mixed
- $manyMethods : mixed
- $relationResolvers : mixed
- $timestamps : mixed
- $ignoreTimestampsOn : mixed
- $usesUniqueIds : mixed
- $hidden : mixed
- $visible : mixed
- $guarded : mixed
- $unguarded : mixed
- $guardableColumns : mixed
- $recursionCache : mixed
- $resolvedCollectionClasses : array

**Methods**

- users()
- factory()

---

## Ticket

**Namespace**

```
App\Models
```

**File**

```
/var/www/app/Models/Ticket.php
```

**Properties**

- $fillable : mixed
- $casts : mixed
- $connection : mixed
- $table : mixed
- $primaryKey : mixed
- $keyType : mixed
- $incrementing : mixed
- $with : mixed
- $withCount : mixed
- $preventsLazyLoading : mixed
- $perPage : mixed
- $exists : mixed
- $wasRecentlyCreated : mixed
- $escapeWhenCastingToString : mixed
- $resolver : mixed
- $dispatcher : mixed
- $booting : mixed
- $booted : mixed
- $bootedCallbacks : mixed
- $traitInitializers : mixed
- $globalScopes : mixed
- $ignoreOnTouch : mixed
- $modelsShouldPreventLazyLoading : mixed
- $modelsShouldAutomaticallyEagerLoadRelationships : mixed
- $lazyLoadingViolationCallback : mixed
- $modelsShouldPreventSilentlyDiscardingAttributes : mixed
- $discardedAttributeViolationCallback : mixed
- $modelsShouldPreventAccessingMissingAttributes : mixed
- $missingAttributeViolationCallback : mixed
- $isBroadcasting : mixed
- $builder : string
- $collectionClass : string
- $isSoftDeletable : array
- $isPrunable : array
- $isMassPrunable : array
- $classAttributes : array
- $attributes : mixed
- $original : mixed
- $changes : mixed
- $previous : mixed
- $classCastCache : mixed
- $attributeCastCache : mixed
- $primitiveCastTypes : mixed
- $dateFormat : mixed
- $appends : mixed
- $snakeAttributes : mixed
- $mutatorCache : mixed
- $attributeMutatorCache : mixed
- $getAttributeMutatorCache : mixed
- $setAttributeMutatorCache : mixed
- $castTypeCache : mixed
- $encrypter : mixed
- $dispatchesEvents : mixed
- $observables : mixed
- $relations : mixed
- $touches : mixed
- $relationAutoloadCallback : mixed
- $relationAutoloadContext : mixed
- $manyMethods : mixed
- $relationResolvers : mixed
- $timestamps : mixed
- $ignoreTimestampsOn : mixed
- $usesUniqueIds : mixed
- $hidden : mixed
- $visible : mixed
- $guarded : mixed
- $unguarded : mixed
- $guardableColumns : mixed
- $recursionCache : mixed
- $resolvedCollectionClasses : array

**Methods**

- tenant()
- customer()
- user()
- replies()

---

## TicketReply

**Namespace**

```
App\Models
```

**File**

```
/var/www/app/Models/TicketReply.php
```

**Properties**

- $fillable : mixed
- $casts : mixed
- $connection : mixed
- $table : mixed
- $primaryKey : mixed
- $keyType : mixed
- $incrementing : mixed
- $with : mixed
- $withCount : mixed
- $preventsLazyLoading : mixed
- $perPage : mixed
- $exists : mixed
- $wasRecentlyCreated : mixed
- $escapeWhenCastingToString : mixed
- $resolver : mixed
- $dispatcher : mixed
- $booting : mixed
- $booted : mixed
- $bootedCallbacks : mixed
- $traitInitializers : mixed
- $globalScopes : mixed
- $ignoreOnTouch : mixed
- $modelsShouldPreventLazyLoading : mixed
- $modelsShouldAutomaticallyEagerLoadRelationships : mixed
- $lazyLoadingViolationCallback : mixed
- $modelsShouldPreventSilentlyDiscardingAttributes : mixed
- $discardedAttributeViolationCallback : mixed
- $modelsShouldPreventAccessingMissingAttributes : mixed
- $missingAttributeViolationCallback : mixed
- $isBroadcasting : mixed
- $builder : string
- $collectionClass : string
- $isSoftDeletable : array
- $isPrunable : array
- $isMassPrunable : array
- $classAttributes : array
- $attributes : mixed
- $original : mixed
- $changes : mixed
- $previous : mixed
- $classCastCache : mixed
- $attributeCastCache : mixed
- $primitiveCastTypes : mixed
- $dateFormat : mixed
- $appends : mixed
- $snakeAttributes : mixed
- $mutatorCache : mixed
- $attributeMutatorCache : mixed
- $getAttributeMutatorCache : mixed
- $setAttributeMutatorCache : mixed
- $castTypeCache : mixed
- $encrypter : mixed
- $dispatchesEvents : mixed
- $observables : mixed
- $relations : mixed
- $touches : mixed
- $relationAutoloadCallback : mixed
- $relationAutoloadContext : mixed
- $manyMethods : mixed
- $relationResolvers : mixed
- $timestamps : mixed
- $ignoreTimestampsOn : mixed
- $usesUniqueIds : mixed
- $hidden : mixed
- $visible : mixed
- $guarded : mixed
- $unguarded : mixed
- $guardableColumns : mixed
- $recursionCache : mixed
- $resolvedCollectionClasses : array

**Methods**

- ticket()
- customer()
- user()

---

## User

**Namespace**

```
App\Models
```

**File**

```
/var/www/app/Models/User.php
```

**Properties**

- $fillable : mixed
- $connection : mixed
- $table : mixed
- $primaryKey : mixed
- $keyType : mixed
- $incrementing : mixed
- $with : mixed
- $withCount : mixed
- $preventsLazyLoading : mixed
- $perPage : mixed
- $exists : mixed
- $wasRecentlyCreated : mixed
- $escapeWhenCastingToString : mixed
- $resolver : mixed
- $dispatcher : mixed
- $booting : mixed
- $booted : mixed
- $bootedCallbacks : mixed
- $traitInitializers : mixed
- $globalScopes : mixed
- $ignoreOnTouch : mixed
- $modelsShouldPreventLazyLoading : mixed
- $modelsShouldAutomaticallyEagerLoadRelationships : mixed
- $lazyLoadingViolationCallback : mixed
- $modelsShouldPreventSilentlyDiscardingAttributes : mixed
- $discardedAttributeViolationCallback : mixed
- $modelsShouldPreventAccessingMissingAttributes : mixed
- $missingAttributeViolationCallback : mixed
- $isBroadcasting : mixed
- $builder : string
- $collectionClass : string
- $isSoftDeletable : array
- $isPrunable : array
- $isMassPrunable : array
- $classAttributes : array
- $attributes : mixed
- $original : mixed
- $changes : mixed
- $previous : mixed
- $casts : mixed
- $classCastCache : mixed
- $attributeCastCache : mixed
- $primitiveCastTypes : mixed
- $dateFormat : mixed
- $appends : mixed
- $snakeAttributes : mixed
- $mutatorCache : mixed
- $attributeMutatorCache : mixed
- $getAttributeMutatorCache : mixed
- $setAttributeMutatorCache : mixed
- $castTypeCache : mixed
- $encrypter : mixed
- $dispatchesEvents : mixed
- $observables : mixed
- $relations : mixed
- $touches : mixed
- $relationAutoloadCallback : mixed
- $relationAutoloadContext : mixed
- $manyMethods : mixed
- $relationResolvers : mixed
- $timestamps : mixed
- $ignoreTimestampsOn : mixed
- $usesUniqueIds : mixed
- $hidden : mixed
- $visible : mixed
- $guarded : mixed
- $unguarded : mixed
- $guardableColumns : mixed
- $recursionCache : mixed
- $resolvedCollectionClasses : array
- $authPasswordName : mixed
- $rememberTokenName : mixed
- $accessToken : mixed
- $roleClass : ?string
- $permissionClass : ?string
- $wildcardClass : ?string
- $wildcardPermissionsIndex : array

**Methods**

- tenant()
- scopeForCurrentTenant()
- tokens()
- tokenCan()
- tokenCant()
- createToken()
- generateTokenString()
- currentAccessToken()
- withAccessToken()
- factory()
- notifications()
- readNotifications()
- unreadNotifications()
- notify()
- notifyNow()
- routeNotificationFor()
- bootHasRoles()
- getRoleClass()
- roles()
- scopeRole()
- scopeWithoutRole()
- teams()
- scopeTeam()
- scopeWithoutTeam()
- assignRole()
- removeRole()
- syncRoles()
- hasRole()
- hasAnyRole()
- hasAllRoles()
- hasExactRoles()
- getDirectPermissions()
- getRoleNames()
- bootHasPermissions()
- getPermissionClass()
- getWildcardClass()
- permissions()
- scopePermission()
- scopeWithoutPermission()
- filterPermission()
- hasPermissionTo()
- checkPermissionTo()
- hasAnyPermission()
- hasAllPermissions()
- hasDirectPermission()
- getPermissionsViaRoles()
- getAllPermissions()
- givePermissionTo()
- forgetWildcardPermissionIndex()
- syncPermissions()
- revokePermissionTo()
- getPermissionNames()
- forgetCachedPermissions()
- hasAllDirectPermissions()
- hasAnyDirectPermission()

---

## WalletTransaction

**Namespace**

```
App\Models
```

**File**

```
/var/www/app/Models/WalletTransaction.php
```

**Properties**

- $fillable : mixed
- $connection : mixed
- $table : mixed
- $primaryKey : mixed
- $keyType : mixed
- $incrementing : mixed
- $with : mixed
- $withCount : mixed
- $preventsLazyLoading : mixed
- $perPage : mixed
- $exists : mixed
- $wasRecentlyCreated : mixed
- $escapeWhenCastingToString : mixed
- $resolver : mixed
- $dispatcher : mixed
- $booting : mixed
- $booted : mixed
- $bootedCallbacks : mixed
- $traitInitializers : mixed
- $globalScopes : mixed
- $ignoreOnTouch : mixed
- $modelsShouldPreventLazyLoading : mixed
- $modelsShouldAutomaticallyEagerLoadRelationships : mixed
- $lazyLoadingViolationCallback : mixed
- $modelsShouldPreventSilentlyDiscardingAttributes : mixed
- $discardedAttributeViolationCallback : mixed
- $modelsShouldPreventAccessingMissingAttributes : mixed
- $missingAttributeViolationCallback : mixed
- $isBroadcasting : mixed
- $builder : string
- $collectionClass : string
- $isSoftDeletable : array
- $isPrunable : array
- $isMassPrunable : array
- $classAttributes : array
- $attributes : mixed
- $original : mixed
- $changes : mixed
- $previous : mixed
- $casts : mixed
- $classCastCache : mixed
- $attributeCastCache : mixed
- $primitiveCastTypes : mixed
- $dateFormat : mixed
- $appends : mixed
- $snakeAttributes : mixed
- $mutatorCache : mixed
- $attributeMutatorCache : mixed
- $getAttributeMutatorCache : mixed
- $setAttributeMutatorCache : mixed
- $castTypeCache : mixed
- $encrypter : mixed
- $dispatchesEvents : mixed
- $observables : mixed
- $relations : mixed
- $touches : mixed
- $relationAutoloadCallback : mixed
- $relationAutoloadContext : mixed
- $manyMethods : mixed
- $relationResolvers : mixed
- $timestamps : mixed
- $ignoreTimestampsOn : mixed
- $usesUniqueIds : mixed
- $hidden : mixed
- $visible : mixed
- $guarded : mixed
- $unguarded : mixed
- $guardableColumns : mixed
- $recursionCache : mixed
- $resolvedCollectionClasses : array

**Methods**

- customer()

---

# Services

---

## AIContextGenerator

**Namespace**

```
App\Services\Documentation\Knowledge
```

**File**

```
/var/www/app/Services/Documentation/Knowledge/AIContextGenerator.php
```

**Constructor Dependencies**

- ProjectScanner $scanner

**Properties**

- $scanner : App\Services\Documentation\Scanner\ProjectScanner

**Methods**

- generate() : string
- filename() : string

---

## AbstractHandoverSection

**Namespace**

```
App\Services\Documentation\Handover
```

**File**

```
/var/www/app/Services/Documentation/Handover/AbstractHandoverSection.php
```

---

## ActionDocumentationGenerator

**Namespace**

```
App\Services\Documentation\Generators
```

**File**

```
/var/www/app/Services/Documentation/Generators/ActionDocumentationGenerator.php
```

**Constructor Dependencies**

- ProjectScanner $scanner

**Properties**

- $scanner : App\Services\Documentation\Scanner\ProjectScanner

**Methods**

- priority() : int
- generate() : string
- filename() : string

---

## ActivityLogService

**Namespace**

```
App\Services
```

**File**

```
/var/www/app/Services/ActivityLogService.php
```

**Methods**

- log() : void

---

## AiStartPromptExport

**Namespace**

```
App\Services\Documentation\Exports
```

**File**

```
/var/www/app/Services/Documentation/Exports/AiStartPromptExport.php
```

**Methods**

- filename() : string
- content() : string
- isAiExport() : bool

---

## ApiDocumentationGenerator

**Namespace**

```
App\Services\Documentation\Generators
```

**File**

```
/var/www/app/Services/Documentation/Generators/ApiDocumentationGenerator.php
```

**Methods**

- priority() : int
- filename() : string
- generate() : string

---

## ArchitectureGenerator

**Namespace**

```
App\Services\Documentation\Knowledge
```

**File**

```
/var/www/app/Services/Documentation/Knowledge/ArchitectureGenerator.php
```

**Methods**

- generate() : string
- filename() : string

---

## AutomaticBillingService

**Namespace**

```
App\Services\Billing
```

**File**

```
/var/www/app/Services/Billing/AutomaticBillingService.php
```

**Constructor Dependencies**

- BillingEngine $billingEngine
- SubscriptionRenewalService $renewalService
- InvoiceService $invoiceService
- NotificationService $notificationService

**Properties**

- $billingEngine : App\Services\Billing\BillingEngine
- $renewalService : App\Services\Subscription\SubscriptionRenewalService
- $invoiceService : App\Services\InvoiceService
- $notificationService : App\Services\NotificationService

**Methods**

- run() : void
- processSubscription() : void

---

## BillingCycleService

**Namespace**

```
App\Services\Billing
```

**File**

```
/var/www/app/Services/Billing/BillingCycleService.php
```

**Methods**

- calculateNextBillingDate() : Carbon\Carbon
- calculateGraceDate() : Carbon\Carbon
- isDue() : bool
- isExpired() : bool

---

## BillingEngine

**Namespace**

```
App\Services\Billing
```

**File**

```
/var/www/app/Services/Billing/BillingEngine.php
```

**Methods**

- status() : App\Enums\BillingStatus
- nextDueDate() : Carbon\Carbon

---

## BusinessRuleExtractor

**Namespace**

```
App\Services\Documentation\Knowledge
```

**File**

```
/var/www/app/Services/Documentation/Knowledge/BusinessRuleExtractor.php
```

**Methods**

- extract() : array

---

## BusinessRulesGenerator

**Namespace**

```
App\Services\Documentation\Knowledge
```

**File**

```
/var/www/app/Services/Documentation/Knowledge/BusinessRulesGenerator.php
```

**Constructor Dependencies**

- ProjectScanner $scanner
- BusinessRuleExtractor $extractor

**Properties**

- $scanner : App\Services\Documentation\Scanner\ProjectScanner
- $extractor : App\Services\Documentation\Knowledge\BusinessRuleExtractor

**Methods**

- filename() : string
- generate() : string

---

## ClassDocumentationGenerator

**Namespace**

```
App\Services\Documentation\Generators
```

**File**

```
/var/www/app/Services/Documentation/Generators/ClassDocumentationGenerator.php
```

**Constructor Dependencies**

- ProjectScanner $scanner

**Properties**

- $scanner : App\Services\Documentation\Scanner\ProjectScanner

**Methods**

- generate() : string

---

## ClassFinder

**Namespace**

```
App\Services\Documentation\Scanner
```

**File**

```
/var/www/app/Services/Documentation/Scanner/ClassFinder.php
```

**Methods**

- find() : ?string
- findMany() : array

---

## ClassReflector

**Namespace**

```
App\Services\Documentation\Reflection
```

**File**

```
/var/www/app/Services/Documentation/Reflection/ClassReflector.php
```

**Methods**

- methods() : array

---

## ConstructorReflector

**Namespace**

```
App\Services\Documentation\Reflection
```

**File**

```
/var/www/app/Services/Documentation/Reflection/ConstructorReflector.php
```

**Methods**

- reflect() : array

---

## ControllerDocumentationGenerator

**Namespace**

```
App\Services\Documentation\Generators
```

**File**

```
/var/www/app/Services/Documentation/Generators/ControllerDocumentationGenerator.php
```

**Constructor Dependencies**

- ProjectScanner $scanner

**Properties**

- $scanner : App\Services\Documentation\Scanner\ProjectScanner

**Methods**

- priority() : int
- generate() : string
- filename() : string

---

## ControllersKnowledgeGenerator

**Namespace**

```
App\Services\Documentation\Knowledge
```

**File**

```
/var/www/app/Services/Documentation/Knowledge/ControllersKnowledgeGenerator.php
```

**Constructor Dependencies**

- ProjectScanner $scanner
- ReflectionEngine $reflection

**Properties**

- $scanner : App\Services\Documentation\Scanner\ProjectScanner
- $reflection : ?App\Services\Documentation\Reflection\ReflectionEngine

**Methods**

- filename() : string
- generate() : string

---

## CustomerDashboardService

**Namespace**

```
App\Services\Dashboard
```

**File**

```
/var/www/app/Services/Dashboard/CustomerDashboardService.php
```

**Methods**

- getDashboardData() : array

---

## CustomerService

**Namespace**

```
App\Services\Customer
```

**File**

```
/var/www/app/Services/Customer/CustomerService.php
```

**Methods**

- create() : App\Models\Customer
- update() : App\Models\Customer
- delete() : bool

---

## DashboardService

**Namespace**

```
App\Services\Dashboard
```

**File**

```
/var/www/app/Services/Dashboard/DashboardService.php
```

**Methods**

- getDashboardData() : array

---

## DatabaseExtractor

**Namespace**

```
App\Services\Documentation\Knowledge
```

**File**

```
/var/www/app/Services/Documentation/Knowledge/DatabaseExtractor.php
```

**Methods**

- extract() : array

---

## DatabaseKnowledgeGenerator

**Namespace**

```
App\Services\Documentation\Knowledge
```

**File**

```
/var/www/app/Services/Documentation/Knowledge/DatabaseKnowledgeGenerator.php
```

**Constructor Dependencies**

- DatabaseExtractor $extractor

**Properties**

- $extractor : App\Services\Documentation\Knowledge\DatabaseExtractor

**Methods**

- filename() : string
- generate() : string

---

## DependencyGraphExtractor

**Namespace**

```
App\Services\Documentation\Knowledge
```

**File**

```
/var/www/app/Services/Documentation/Knowledge/DependencyGraphExtractor.php
```

**Constructor Dependencies**

- ProjectScanner $scanner

**Properties**

- $scanner : App\Services\Documentation\Scanner\ProjectScanner

**Methods**

- extract() : array

---

## DependencyGraphKnowledgeGenerator

**Namespace**

```
App\Services\Documentation\Knowledge
```

**File**

```
/var/www/app/Services/Documentation/Knowledge/DependencyGraphKnowledgeGenerator.php
```

**Constructor Dependencies**

- DependencyGraphExtractor $extractor

**Properties**

- $extractor : App\Services\Documentation\Knowledge\DependencyGraphExtractor

**Methods**

- filename() : string
- generate() : string

---

## DocumentationDirectoryManager

**Namespace**

```
App\Services\Documentation\Filesystem
```

**File**

```
/var/www/app/Services/Documentation/Filesystem/DocumentationDirectoryManager.php
```

**Methods**

- generatedPath() : string
- ensureExists() : void
- file() : string

---

## DocumentationGeneratorManager

**Namespace**

```
App\Services\Documentation\Manager
```

**File**

```
/var/www/app/Services/Documentation/Manager/DocumentationGeneratorManager.php
```

**Constructor Dependencies**

- DocumentationGeneratorRegistry $registry
- DocumentationWriter $writer

**Properties**

- $registry : App\Services\Documentation\Registry\DocumentationGeneratorRegistry
- $writer : App\Services\Documentation\Writer\DocumentationWriter

**Methods**

- generate() : void

---

## DocumentationGeneratorRegistry

**Namespace**

```
App\Services\Documentation\Registry
```

**File**

```
/var/www/app/Services/Documentation/Registry/DocumentationGeneratorRegistry.php
```

**Properties**

- $generators : array

**Methods**

- register() : self
- all() : array

---

## DocumentationIndexGenerator

**Namespace**

```
App\Services\Documentation\Index
```

**File**

```
/var/www/app/Services/Documentation/Index/DocumentationIndexGenerator.php
```

**Methods**

- generate() : string

---

## DocumentationWriter

**Namespace**

```
App\Services\Documentation\Writer
```

**File**

```
/var/www/app/Services/Documentation/Writer/DocumentationWriter.php
```

**Constructor Dependencies**

- ?string $basePath

**Properties**

- $basePath : string

**Methods**

- write() : void
- exists() : bool
- read() : string
- delete() : void

---

## ExecutiveSummarySection

**Namespace**

```
App\Services\Documentation\Handover
```

**File**

```
/var/www/app/Services/Documentation/Handover/ExecutiveSummarySection.php
```

**Methods**

- generate() : string

---

## ExportRegistry

**Namespace**

```
App\Services\Documentation\Exports
```

**File**

```
/var/www/app/Services/Documentation/Exports/ExportRegistry.php
```

**Properties**

- $exports : array

**Methods**

- register() : self
- exports() : array

---

## FileScanner

**Namespace**

```
App\Services\Documentation\Scanner
```

**File**

```
/var/www/app/Services/Documentation/Scanner/FileScanner.php
```

**Methods**

- scan() : array

---

## FinanceService

**Namespace**

```
App\Services\Finance
```

**File**

```
/var/www/app/Services/Finance/FinanceService.php
```

**Methods**

- record() : void

---

## HandoverDocumentGenerator

**Namespace**

```
App\Services\Documentation\Knowledge
```

**File**

```
/var/www/app/Services/Documentation/Knowledge/HandoverDocumentGenerator.php
```

**Methods**

- filename() : string
- generate() : string

---

## InvoiceGenerator

**Namespace**

```
App\Services\Billing
```

**File**

```
/var/www/app/Services/Billing/InvoiceGenerator.php
```

**Constructor Dependencies**

- InvoiceNumberService $invoiceNumberService

**Properties**

- $invoiceNumberService : App\Services\InvoiceNumberService

**Methods**

- generate() : App\Models\Invoice

---

## InvoiceNumberService

**Namespace**

```
App\Services
```

**File**

```
/var/www/app/Services/InvoiceNumberService.php
```

**Methods**

- generate() : string

---

## InvoiceService

**Namespace**

```
App\Services\Invoice
```

**File**

```
/var/www/app/Services/Invoice/InvoiceService.php
```

**Methods**

- create() : App\Models\Invoice
- update() : App\Models\Invoice
- delete() : bool

---

## KnowledgeExporter

**Namespace**

```
App\Services\Documentation\Knowledge
```

**File**

```
/var/www/app/Services/Documentation/Knowledge/KnowledgeExporter.php
```

**Constructor Dependencies**

- DocumentationWriter $writer

**Properties**

- $writer : App\Services\Documentation\Writer\DocumentationWriter

**Methods**

- export() : void

---

## KnowledgeGeneratorManager

**Namespace**

```
App\Services\Documentation\Knowledge
```

**File**

```
/var/www/app/Services/Documentation/Knowledge/KnowledgeGeneratorManager.php
```

**Constructor Dependencies**

- KnowledgeGeneratorRegistry $registry
- DocumentationWriter $writer

**Properties**

- $registry : App\Services\Documentation\Knowledge\KnowledgeGeneratorRegistry
- $writer : App\Services\Documentation\Writer\DocumentationWriter

**Methods**

- generate() : void

---

## KnowledgeGeneratorRegistry

**Namespace**

```
App\Services\Documentation\Knowledge
```

**File**

```
/var/www/app/Services/Documentation/Knowledge/KnowledgeGeneratorRegistry.php
```

**Constructor Dependencies**

- ProjectScanner $scanner

**Properties**

- $generators : array

**Methods**

- register() : self
- generators() : array

---

## KnowledgeIndexGenerator

**Namespace**

```
App\Services\Documentation\Knowledge
```

**File**

```
/var/www/app/Services/Documentation/Knowledge/KnowledgeIndexGenerator.php
```

**Methods**

- filename() : string
- generate() : string

---

## MarkdownBuilder

**Namespace**

```
App\Services\Documentation\Builder
```

**File**

```
/var/www/app/Services/Documentation/Builder/MarkdownBuilder.php
```

**Properties**

- $lines : array

**Methods**

- title() : self
- h2() : self
- h3() : self
- text() : self
- bullet() : self
- numbered() : self
- code() : self
- table() : self
- separator() : self
- newline() : self
- render() : string

---

## MetadataExtractor

**Namespace**

```
App\Services\Documentation\Scanner
```

**File**

```
/var/www/app/Services/Documentation/Scanner/MetadataExtractor.php
```

**Methods**

- extract() : array

---

## MethodReflector

**Namespace**

```
App\Services\Documentation\Reflection
```

**File**

```
/var/www/app/Services/Documentation/Reflection/MethodReflector.php
```

**Methods**

- reflect() : array

---

## MigrationExtractor

**Namespace**

```
App\Services\Documentation\Knowledge
```

**File**

```
/var/www/app/Services/Documentation/Knowledge/MigrationExtractor.php
```

**Methods**

- extract() : array

---

## MigrationsKnowledgeGenerator

**Namespace**

```
App\Services\Documentation\Knowledge
```

**File**

```
/var/www/app/Services/Documentation/Knowledge/MigrationsKnowledgeGenerator.php
```

**Constructor Dependencies**

- MigrationExtractor $extractor

**Properties**

- $extractor : App\Services\Documentation\Knowledge\MigrationExtractor

**Methods**

- filename() : string
- generate() : string

---

## MikrotikConnection

**Namespace**

```
App\Services\Network
```

**File**

```
/var/www/app/Services/Network/MikrotikConnection.php
```

**Properties**

- $client : ?RouterOS\Client

**Methods**

- client() : RouterOS\Client
- execute() : array

---

## MikrotikService

**Namespace**

```
App\Services\Network
```

**File**

```
/var/www/app/Services/Network/MikrotikService.php
```

**Properties**

- $client : mixed
- $device : mixed

**Methods**

- connect() : bool
- createUser() : bool
- disableUser() : bool
- enableUser() : bool
- deleteUser() : bool
- getAllUsers() : array
- getActiveSessions() : array
- updateUserQueue() : bool
- getDeviceStats() : array
- ping() : bool
- disconnectUser() : bool
- updateDeviceStatus() : void
- getHotspotUsers() : array
- getHotspotActiveSessions() : array
- createHotspotUser() : bool
- disableHotspotUser() : bool
- enableHotspotUser() : bool

---

## ModelDocumentationGenerator

**Namespace**

```
App\Services\Documentation\Generators
```

**File**

```
/var/www/app/Services/Documentation/Generators/ModelDocumentationGenerator.php
```

**Constructor Dependencies**

- ProjectScanner $scanner

**Properties**

- $scanner : App\Services\Documentation\Scanner\ProjectScanner

**Methods**

- generate() : string
- priority() : int
- filename() : string

---

## ModelRelationExtractor

**Namespace**

```
App\Services\Documentation\Knowledge
```

**File**

```
/var/www/app/Services/Documentation/Knowledge/ModelRelationExtractor.php
```

**Constructor Dependencies**

- ProjectScanner $scanner

**Properties**

- $scanner : App\Services\Documentation\Scanner\ProjectScanner

**Methods**

- extract() : array

---

## ModelRelationsKnowledgeGenerator

**Namespace**

```
App\Services\Documentation\Knowledge
```

**File**

```
/var/www/app/Services/Documentation/Knowledge/ModelRelationsKnowledgeGenerator.php
```

**Constructor Dependencies**

- ModelRelationExtractor $extractor

**Properties**

- $extractor : App\Services\Documentation\Knowledge\ModelRelationExtractor

**Methods**

- filename() : string
- generate() : string

---

## ModelsKnowledgeGenerator

**Namespace**

```
App\Services\Documentation\Knowledge
```

**File**

```
/var/www/app/Services/Documentation/Knowledge/ModelsKnowledgeGenerator.php
```

**Constructor Dependencies**

- ProjectScanner $scanner
- ReflectionEngine $reflection

**Properties**

- $scanner : App\Services\Documentation\Scanner\ProjectScanner
- $reflection : ?App\Services\Documentation\Reflection\ReflectionEngine

**Methods**

- filename() : string
- generate() : string

---

## ModelsSection

**Namespace**

```
App\Services\Documentation\Sections
```

**File**

```
/var/www/app/Services/Documentation/Sections/ModelsSection.php
```

**Methods**

- generate() : string

---

## ModuleExtractor

**Namespace**

```
App\Services\Documentation\Knowledge
```

**File**

```
/var/www/app/Services/Documentation/Knowledge/ModuleExtractor.php
```

**Constructor Dependencies**

- ProjectScanner $scanner

**Properties**

- $scanner : App\Services\Documentation\Scanner\ProjectScanner

**Methods**

- extract() : array

---

## ModulesKnowledgeGenerator

**Namespace**

```
App\Services\Documentation\Knowledge
```

**File**

```
/var/www/app/Services/Documentation/Knowledge/ModulesKnowledgeGenerator.php
```

**Constructor Dependencies**

- ProjectScanner $scanner

**Properties**

- $scanner : App\Services\Documentation\Scanner\ProjectScanner

**Methods**

- filename() : string
- generate() : string

---

## NotificationService

**Namespace**

```
App\Services
```

**File**

```
/var/www/app/Services/NotificationService.php
```

**Methods**

- createReminder() : mixed

---

## PackageService

**Namespace**

```
App\Services\Package
```

**File**

```
/var/www/app/Services/Package/PackageService.php
```

**Methods**

- paginate() : Illuminate\Contracts\Pagination\LengthAwarePaginator
- create() : App\Models\Package
- update() : App\Models\Package
- delete() : void

---

## PaymentService

**Namespace**

```
App\Services\Payment
```

**File**

```
/var/www/app/Services/Payment/PaymentService.php
```

**Methods**

- create() : App\Models\Payment

---

## ProjectBibleService

**Namespace**

```
App\Services\Documentation
```

**File**

```
/var/www/app/Services/Documentation/ProjectBibleService.php
```

**Methods**

- generate() : string

---

## ProjectScanner

**Namespace**

```
App\Services\Documentation\Scanner
```

**File**

```
/var/www/app/Services/Documentation/Scanner/ProjectScanner.php
```

**Constructor Dependencies**

- FileScanner $files
- ClassFinder $finder
- MetadataExtractor $extractor

**Properties**

- $files : App\Services\Documentation\Scanner\FileScanner
- $finder : App\Services\Documentation\Scanner\ClassFinder
- $extractor : App\Services\Documentation\Scanner\MetadataExtractor

**Methods**

- models() : array
- services() : array
- controllers() : array
- repositories() : array
- actions() : array
- all() : array

---

## ProjectStateExtractor

**Namespace**

```
App\Services\Documentation\Knowledge
```

**File**

```
/var/www/app/Services/Documentation/Knowledge/ProjectStateExtractor.php
```

**Constructor Dependencies**

- ProjectScanner $scanner

**Properties**

- $scanner : App\Services\Documentation\Scanner\ProjectScanner

**Methods**

- extract() : array

---

## ProjectStateKnowledgeGenerator

**Namespace**

```
App\Services\Documentation\Knowledge
```

**File**

```
/var/www/app/Services/Documentation/Knowledge/ProjectStateKnowledgeGenerator.php
```

**Constructor Dependencies**

- ProjectStateExtractor $extractor

**Properties**

- $extractor : App\Services\Documentation\Knowledge\ProjectStateExtractor

**Methods**

- filename() : string
- generate() : string

---

## ProjectSummaryGenerator

**Namespace**

```
App\Services\Documentation\Knowledge
```

**File**

```
/var/www/app/Services/Documentation/Knowledge/ProjectSummaryGenerator.php
```

**Constructor Dependencies**

- ProjectScanner $scanner

**Properties**

- $scanner : App\Services\Documentation\Scanner\ProjectScanner

**Methods**

- generate() : string
- filename() : string

---

## PropertyReflector

**Namespace**

```
App\Services\Documentation\Reflection
```

**File**

```
/var/www/app/Services/Documentation/Reflection/PropertyReflector.php
```

**Methods**

- reflect() : array

---

## ReflectionEngine

**Namespace**

```
App\Services\Documentation\Reflection
```

**File**

```
/var/www/app/Services/Documentation/Reflection/ReflectionEngine.php
```

**Constructor Dependencies**

- MethodReflector $methods
- PropertyReflector $properties
- ConstructorReflector $constructor

**Properties**

- $methods : App\Services\Documentation\Reflection\MethodReflector
- $properties : App\Services\Documentation\Reflection\PropertyReflector
- $constructor : App\Services\Documentation\Reflection\ConstructorReflector

**Methods**

- reflect() : array

---

## RepositoryDocumentationGenerator

**Namespace**

```
App\Services\Documentation\Generators
```

**File**

```
/var/www/app/Services/Documentation/Generators/RepositoryDocumentationGenerator.php
```

**Constructor Dependencies**

- ProjectScanner $scanner

**Properties**

- $scanner : App\Services\Documentation\Scanner\ProjectScanner

**Methods**

- priority() : int
- generate() : string
- filename() : string

---

## RouteExtractor

**Namespace**

```
App\Services\Documentation\Knowledge
```

**File**

```
/var/www/app/Services/Documentation/Knowledge/RouteExtractor.php
```

**Methods**

- extract() : array

---

## RoutesKnowledgeGenerator

**Namespace**

```
App\Services\Documentation\Knowledge
```

**File**

```
/var/www/app/Services/Documentation/Knowledge/RoutesKnowledgeGenerator.php
```

**Constructor Dependencies**

- RouteExtractor $extractor

**Properties**

- $extractor : App\Services\Documentation\Knowledge\RouteExtractor

**Methods**

- filename() : string
- generate() : string

---

## ServiceDocumentationGenerator

**Namespace**

```
App\Services\Documentation\Generators
```

**File**

```
/var/www/app/Services/Documentation/Generators/ServiceDocumentationGenerator.php
```

**Constructor Dependencies**

- ProjectScanner $scanner

**Properties**

- $scanner : App\Services\Documentation\Scanner\ProjectScanner

**Methods**

- generate() : string
- priority() : int
- filename() : string

---

## ServiceUsageExtractor

**Namespace**

```
App\Services\Documentation\Knowledge
```

**File**

```
/var/www/app/Services/Documentation/Knowledge/ServiceUsageExtractor.php
```

**Constructor Dependencies**

- ProjectScanner $scanner

**Properties**

- $scanner : App\Services\Documentation\Scanner\ProjectScanner

**Methods**

- extract() : array

---

## ServiceUsageKnowledgeGenerator

**Namespace**

```
App\Services\Documentation\Knowledge
```

**File**

```
/var/www/app/Services/Documentation/Knowledge/ServiceUsageKnowledgeGenerator.php
```

**Constructor Dependencies**

- ServiceUsageExtractor $extractor

**Properties**

- $extractor : App\Services\Documentation\Knowledge\ServiceUsageExtractor

**Methods**

- filename() : string
- generate() : string

---

## ServicesKnowledgeGenerator

**Namespace**

```
App\Services\Documentation\Knowledge
```

**File**

```
/var/www/app/Services/Documentation/Knowledge/ServicesKnowledgeGenerator.php
```

**Constructor Dependencies**

- ProjectScanner $scanner
- ReflectionEngine $reflection

**Properties**

- $scanner : App\Services\Documentation\Scanner\ProjectScanner
- $reflection : ?App\Services\Documentation\Reflection\ReflectionEngine

**Methods**

- filename() : string
- generate() : string

---

## ServicesSection

**Namespace**

```
App\Services\Documentation\Sections
```

**File**

```
/var/www/app/Services/Documentation/Sections/ServicesSection.php
```

**Methods**

- generate() : string

---

## StatisticsGenerator

**Namespace**

```
App\Services\Documentation\Knowledge
```

**File**

```
/var/www/app/Services/Documentation/Knowledge/StatisticsGenerator.php
```

**Constructor Dependencies**

- ProjectScanner $scanner

**Properties**

- $scanner : App\Services\Documentation\Scanner\ProjectScanner

**Methods**

- generate() : string
- filename() : string

---

## SubscriptionActivationService

**Namespace**

```
App\Services\Subscription
```

**File**

```
/var/www/app/Services/Subscription/SubscriptionActivationService.php
```

**Constructor Dependencies**

- MikrotikServiceInterface $mikrotikService

**Properties**

- $mikrotikService : App\Contracts\MikrotikServiceInterface

**Methods**

- activate() : bool

---

## SubscriptionActivityService

**Namespace**

```
App\Services\Activity
```

**File**

```
/var/www/app/Services/Activity/SubscriptionActivityService.php
```

**Methods**

- log() : App\Models\ActivityLog

---

## SubscriptionExpirationService

**Namespace**

```
App\Services\Subscription
```

**File**

```
/var/www/app/Services/Subscription/SubscriptionExpirationService.php
```

**Constructor Dependencies**

- ExpireSubscriptionAction $action

**Properties**

- $action : App\Actions\Subscription\ExpireSubscriptionAction

**Methods**

- expire() : bool

---

## SubscriptionLifecycleService

**Namespace**

```
App\Services\Subscription
```

**File**

```
/var/www/app/Services/Subscription/SubscriptionLifecycleService.php
```

**Constructor Dependencies**

- ActivateSubscriptionAction $activateAction
- SuspendSubscriptionAction $suspendAction
- ExpireSubscriptionAction $expireAction
- RenewSubscriptionAction $renewAction
- RestoreSubscriptionAction $restoreAction

**Properties**

- $activateAction : App\Actions\Subscription\ActivateSubscriptionAction
- $suspendAction : App\Actions\Subscription\SuspendSubscriptionAction
- $expireAction : App\Actions\Subscription\ExpireSubscriptionAction
- $renewAction : App\Actions\Subscription\RenewSubscriptionAction
- $restoreAction : App\Actions\Subscription\RestoreSubscriptionAction

**Methods**

- activate() : bool
- suspend() : bool
- expire() : bool
- renew() : bool
- restore() : bool

---

## SubscriptionRenewalService

**Namespace**

```
App\Services
```

**File**

```
/var/www/app/Services/SubscriptionRenewalService.php
```

**Constructor Dependencies**

- MikrotikServiceInterface $mikrotik

**Properties**

- $mikrotik : App\Contracts\MikrotikServiceInterface

**Methods**

- renewPppoe() : bool
- renewHotspot() : bool

---

## SubscriptionService

**Namespace**

```
App\Services\Subscription
```

**File**

```
/var/www/app/Services/Subscription/SubscriptionService.php
```

**Constructor Dependencies**

- SubscriptionRepositoryInterface $subscriptionRepository
- MikrotikService $mikrotikService
- ActivateSubscriptionAction $activateAction
- SuspendSubscriptionAction $suspendAction
- ExpireSubscriptionAction $expireAction
- RestoreSubscriptionAction $restoreAction
- RenewSubscriptionAction $renewAction

**Properties**

- $activateAction : App\Actions\Subscription\ActivateSubscriptionAction
- $suspendAction : App\Actions\Subscription\SuspendSubscriptionAction
- $expireAction : App\Actions\Subscription\ExpireSubscriptionAction
- $restoreAction : App\Actions\Subscription\RestoreSubscriptionAction
- $renewAction : App\Actions\Subscription\RenewSubscriptionAction
- $subscriptionRepository : App\Contracts\Repositories\SubscriptionRepositoryInterface
- $mikrotikService : App\Services\Network\MikrotikService

**Methods**

- getAllSubscriptions() : mixed
- getSubscriptionById() : ?App\Models\Subscription
- getCustomerSubscriptions() : array
- getActiveSubscriptions() : array
- getExpiredSubscriptions() : array
- createSubscription() : App\Models\Subscription
- updateSubscription() : App\Models\Subscription
- renewSubscription() : App\Models\Subscription
- cancelSubscription() : bool
- getSubscriptionStats() : array
- getExpiringSubscriptions() : array
- autoExpireSubscriptions() : int
- searchSubscriptions() : mixed
- activate() : bool
- suspend() : bool
- expire() : bool
- restore() : bool
- renew() : bool

---

## SubscriptionSuspensionService

**Namespace**

```
App\Services\Subscription
```

**File**

```
/var/www/app/Services/Subscription/SubscriptionSuspensionService.php
```

**Constructor Dependencies**

- SuspendSubscriptionAction $action

**Properties**

- $action : App\Actions\Subscription\SuspendSubscriptionAction

**Methods**

- suspend() : bool

---

## TelegramNotificationService

**Namespace**

```
App\Services
```

**File**

```
/var/www/app/Services/TelegramNotificationService.php
```

**Properties**

- $botToken : mixed
- $chatId : mixed

**Methods**

- sendMessage() : mixed
- sendDeviceAlert() : mixed

---

## TestCoverageExtractor

**Namespace**

```
App\Services\Documentation\Knowledge
```

**File**

```
/var/www/app/Services/Documentation/Knowledge/TestCoverageExtractor.php
```

**Methods**

- extract() : array

---

## TicketService

**Namespace**

```
App\Services\Ticket
```

**File**

```
/var/www/app/Services/Ticket/TicketService.php
```

**Methods**

- createFromAdmin() : App\Models\Ticket
- createFromCustomer() : App\Models\Ticket
- updateFromAdmin() : App\Models\Ticket
- delete() : void
- replyAsStaff() : App\Models\TicketReply
- replyAsCustomer() : App\Models\TicketReply
- changeStatus() : App\Models\Ticket
- closeByCustomer() : App\Models\Ticket
- assign() : App\Models\Ticket
- adminDashboardStats() : array
- customerDashboardStats() : array

---

## TodoGenerator

**Namespace**

```
App\Services\Documentation\Knowledge
```

**File**

```
/var/www/app/Services/Documentation/Knowledge/TodoGenerator.php
```

**Methods**

- extract() : array

---

## TodoKnowledgeGenerator

**Namespace**

```
App\Services\Documentation\Knowledge
```

**File**

```
/var/www/app/Services/Documentation/Knowledge/TodoKnowledgeGenerator.php
```

**Constructor Dependencies**

- TodoGenerator $extractor

**Properties**

- $extractor : App\Services\Documentation\Knowledge\TodoGenerator

**Methods**

- filename() : string
- generate() : string

---

## WalletService

**Namespace**

```
App\Services
```

**File**

```
/var/www/app/Services/WalletService.php
```

**Methods**

- deposit() : void
- deduct() : void

---

# Controllers

---

## ActivityLogController

**Namespace**

```
App\Http\Controllers\Api
```

**File**

```
/var/www/app/Http/Controllers/Api/ActivityLogController.php
```

**Public Methods**

- index()
- show()

---

## AuthController

**Namespace**

```
App\Http\Controllers\Api
```

**File**

```
/var/www/app/Http/Controllers/Api/AuthController.php
```

**Public Methods**

- login()
- me()
- logout()

---

## Controller

**Namespace**

```
App\Http\Controllers
```

**File**

```
/var/www/app/Http/Controllers/Controller.php
```

**Public Methods**

- authorize()
- authorizeForUser()
- authorizeResource()

---

## CustomerAuthController

**Namespace**

```
App\Http\Controllers\Api
```

**File**

```
/var/www/app/Http/Controllers/Api/CustomerAuthController.php
```

**Public Methods**

- login()
- me()

---

## CustomerController

**Namespace**

```
App\Http\Controllers\Api
```

**File**

```
/var/www/app/Http/Controllers/Api/CustomerController.php
```

**Dependencies**

- CustomerService $customerService

**Public Methods**

- index()
- store()
- show()
- update()
- destroy()

---

## CustomerDashboardController

**Namespace**

```
App\Http\Controllers\Api
```

**File**

```
/var/www/app/Http/Controllers/Api/CustomerDashboardController.php
```

**Dependencies**

- CustomerDashboardService $dashboardService

**Public Methods**

- index()

---

## CustomerInvoiceController

**Namespace**

```
App\Http\Controllers\Api
```

**File**

```
/var/www/app/Http/Controllers/Api/CustomerInvoiceController.php
```

**Public Methods**

- index()
- show()

---

## CustomerNotificationController

**Namespace**

```
App\Http\Controllers\Api
```

**File**

```
/var/www/app/Http/Controllers/Api/CustomerNotificationController.php
```

**Public Methods**

- index()
- markAsRead()
- markAllAsRead()

---

## CustomerSubscriptionController

**Namespace**

```
App\Http\Controllers\Api
```

**File**

```
/var/www/app/Http/Controllers/Api/CustomerSubscriptionController.php
```

**Public Methods**

- current()

---

## CustomerTicketController

**Namespace**

```
App\Http\Controllers\Api
```

**File**

```
/var/www/app/Http/Controllers/Api/CustomerTicketController.php
```

**Dependencies**

- TicketService $ticketService

**Public Methods**

- index()
- dashboard()
- show()
- messages()
- store()
- reply()
- close()

---

## CustomerWalletController

**Namespace**

```
App\Http\Controllers\Api
```

**File**

```
/var/www/app/Http/Controllers/Api/CustomerWalletController.php
```

**Public Methods**

- show()

---

## DashboardController

**Namespace**

```
App\Http\Controllers\Api
```

**File**

```
/var/www/app/Http/Controllers/Api/DashboardController.php
```

**Dependencies**

- DashboardService $dashboardService

**Public Methods**

- index()

---

## DashboardController

**Namespace**

```
App\Http\Controllers
```

**File**

```
/var/www/app/Http/Controllers/DashboardController.php
```

**Public Methods**

- index()

---

## DeviceAssignmentController

**Namespace**

```
App\Http\Controllers\Api
```

**File**

```
/var/www/app/Http/Controllers/Api/DeviceAssignmentController.php
```

**Public Methods**

- index()
- store()
- returnDevice()
- show()
- update()
- destroy()

---

## DeviceController

**Namespace**

```
App\Http\Controllers\Api
```

**File**

```
/var/www/app/Http/Controllers/Api/DeviceController.php
```

**Public Methods**

- index()
- store()
- show()
- update()
- destroy()

---

## HotspotController

**Namespace**

```
App\Http\Controllers\Api
```

**File**

```
/var/www/app/Http/Controllers/Api/HotspotController.php
```

**Public Methods**

- onlineUsers()
- stats()

---

## HotspotSubscriptionController

**Namespace**

```
App\Http\Controllers\Api
```

**File**

```
/var/www/app/Http/Controllers/Api/HotspotSubscriptionController.php
```

**Public Methods**

- index()
- store()
- show()
- destroy()
- suspend()
- activate()

---

## InventoryController

**Namespace**

```
App\Http\Controllers\Api
```

**File**

```
/var/www/app/Http/Controllers/Api/InventoryController.php
```

**Public Methods**

- index()
- store()
- show()
- update()
- destroy()

---

## InvoiceController

**Namespace**

```
App\Http\Controllers\Api
```

**File**

```
/var/www/app/Http/Controllers/Api/InvoiceController.php
```

**Dependencies**

- InvoiceService $invoiceService

**Public Methods**

- index()
- store()
- show()
- update()
- destroy()

---

## MikrotikController

**Namespace**

```
App\Http\Controllers\Api
```

**File**

```
/var/www/app/Http/Controllers/Api/MikrotikController.php
```

**Dependencies**

- MikrotikServiceInterface $mikrotik
- MikrotikConnection $connection

**Public Methods**

- test()
- pppoeUsers()
- createPppoeUser()
- hotspotUsers()
- activeUsers()
- createHotspotUser()
- deleteHotspotUser()
- suspendHotspotUser()
- activateHotspotUser()
- dhcpLeases()
- dashboardStats()

---

## NotificationController

**Namespace**

```
App\Http\Controllers\Api
```

**File**

```
/var/www/app/Http/Controllers/Api/NotificationController.php
```

**Public Methods**

- index()
- show()
- markAsRead()
- markAllAsRead()
- destroy()

---

## PackageController

**Namespace**

```
App\Http\Controllers\Api
```

**File**

```
/var/www/app/Http/Controllers/Api/PackageController.php
```

**Dependencies**

- PackageService $packageService

**Public Methods**

- index()
- store()
- show()
- update()
- destroy()

---

## PaymentController

**Namespace**

```
App\Http\Controllers\Api
```

**File**

```
/var/www/app/Http/Controllers/Api/PaymentController.php
```

**Dependencies**

- PaymentService $paymentService

**Public Methods**

- index()
- store()
- show()
- update()
- destroy()

---

## ReportController

**Namespace**

```
App\Http\Controllers\Api
```

**File**

```
/var/www/app/Http/Controllers/Api/ReportController.php
```

**Public Methods**

- dashboard()
- revenue()
- invoices()
- inventory()
- tickets()

---

## SubscriptionController

**Namespace**

```
App\Http\Controllers\Api
```

**File**

```
/var/www/app/Http/Controllers/Api/SubscriptionController.php
```

**Dependencies**

- SubscriptionService $subscriptionService

**Public Methods**

- activate()
- suspend()
- renew()
- restore()
- expire()

---

## TenantController

**Namespace**

```
App\Http\Controllers\Api
```

**File**

```
/var/www/app/Http/Controllers/Api/TenantController.php
```

**Public Methods**

- index()
- store()
- show()
- update()
- destroy()

---

## TicketController

**Namespace**

```
App\Http\Controllers\Api
```

**File**

```
/var/www/app/Http/Controllers/Api/TicketController.php
```

**Dependencies**

- TicketService $ticketService

**Public Methods**

- index()
- store()
- show()
- update()
- destroy()
- dashboard()
- messages()
- reply()
- changeStatus()
- assign()

---

## UserController

**Namespace**

```
App\Http\Controllers\Api
```

**File**

```
/var/www/app/Http/Controllers/Api/UserController.php
```

**Public Methods**

- index()
- store()
- show()
- destroy()

---

# Routes

## sanctum/csrf-cookie

- Method: GET|HEAD
- Name: sanctum.csrf-cookie
- Action: Laravel\Sanctum\Http\Controllers\CsrfCookieController@show
- Middleware: web

## api/login

- Method: POST
- Name: generated::WZGPNqFTuHqZifDC
- Action: App\Http\Controllers\Api\AuthController@login
- Middleware: api

## api/customer/login

- Method: POST
- Name: generated::fJhmESJ286OK29I4
- Action: App\Http\Controllers\Api\CustomerAuthController@login
- Middleware: api

## api/me

- Method: GET|HEAD
- Name: generated::6fLLvvIBLgF0wpZP
- Action: App\Http\Controllers\Api\AuthController@me
- Middleware: api, auth:sanctum

## api/logout

- Method: POST
- Name: generated::xHViytP4z1LyuMv4
- Action: App\Http\Controllers\Api\AuthController@logout
- Middleware: api, auth:sanctum

## api/tickets/{ticket}/reply

- Method: POST
- Name: generated::yUDI8V4apeX8popJ
- Action: App\Http\Controllers\Api\TicketController@reply
- Middleware: api, auth:sanctum

## api/tickets/{ticket}/messages

- Method: GET|HEAD
- Name: generated::bUZZz7ph1KkplHOa
- Action: App\Http\Controllers\Api\TicketController@messages
- Middleware: api, auth:sanctum

## api/dashboard

- Method: GET|HEAD
- Name: generated::Ww2h2bugmGvNZBZZ
- Action: App\Http\Controllers\Api\DashboardController@index
- Middleware: api, auth:sanctum

## api/dashboard/stats

- Method: GET|HEAD
- Name: generated::4zP7Iqq7F206i6NH
- Action: App\Http\Controllers\Api\MikrotikController@dashboardStats
- Middleware: api, auth:sanctum

## api/users

- Method: GET|HEAD
- Name: users.index
- Action: App\Http\Controllers\Api\UserController@index
- Middleware: api, auth:sanctum

## api/users

- Method: POST
- Name: users.store
- Action: App\Http\Controllers\Api\UserController@store
- Middleware: api, auth:sanctum

## api/users/{user}

- Method: GET|HEAD
- Name: users.show
- Action: App\Http\Controllers\Api\UserController@show
- Middleware: api, auth:sanctum

## api/users/{user}

- Method: PUT|PATCH
- Name: users.update
- Action: App\Http\Controllers\Api\UserController@update
- Middleware: api, auth:sanctum

## api/users/{user}

- Method: DELETE
- Name: users.destroy
- Action: App\Http\Controllers\Api\UserController@destroy
- Middleware: api, auth:sanctum

## api/tenants

- Method: GET|HEAD
- Name: tenants.index
- Action: App\Http\Controllers\Api\TenantController@index
- Middleware: api, auth:sanctum

## api/tenants

- Method: POST
- Name: tenants.store
- Action: App\Http\Controllers\Api\TenantController@store
- Middleware: api, auth:sanctum

## api/tenants/{tenant}

- Method: GET|HEAD
- Name: tenants.show
- Action: App\Http\Controllers\Api\TenantController@show
- Middleware: api, auth:sanctum

## api/tenants/{tenant}

- Method: PUT|PATCH
- Name: tenants.update
- Action: App\Http\Controllers\Api\TenantController@update
- Middleware: api, auth:sanctum

## api/tenants/{tenant}

- Method: DELETE
- Name: tenants.destroy
- Action: App\Http\Controllers\Api\TenantController@destroy
- Middleware: api, auth:sanctum

## api/customers

- Method: GET|HEAD
- Name: customers.index
- Action: App\Http\Controllers\Api\CustomerController@index
- Middleware: api, auth:sanctum

## api/customers

- Method: POST
- Name: customers.store
- Action: App\Http\Controllers\Api\CustomerController@store
- Middleware: api, auth:sanctum

## api/customers/{customer}

- Method: GET|HEAD
- Name: customers.show
- Action: App\Http\Controllers\Api\CustomerController@show
- Middleware: api, auth:sanctum

## api/customers/{customer}

- Method: PUT|PATCH
- Name: customers.update
- Action: App\Http\Controllers\Api\CustomerController@update
- Middleware: api, auth:sanctum

## api/customers/{customer}

- Method: DELETE
- Name: customers.destroy
- Action: App\Http\Controllers\Api\CustomerController@destroy
- Middleware: api, auth:sanctum

## api/packages

- Method: GET|HEAD
- Name: packages.index
- Action: App\Http\Controllers\Api\PackageController@index
- Middleware: api, auth:sanctum

## api/packages

- Method: POST
- Name: packages.store
- Action: App\Http\Controllers\Api\PackageController@store
- Middleware: api, auth:sanctum

## api/packages/{package}

- Method: GET|HEAD
- Name: packages.show
- Action: App\Http\Controllers\Api\PackageController@show
- Middleware: api, auth:sanctum

## api/packages/{package}

- Method: PUT|PATCH
- Name: packages.update
- Action: App\Http\Controllers\Api\PackageController@update
- Middleware: api, auth:sanctum

## api/packages/{package}

- Method: DELETE
- Name: packages.destroy
- Action: App\Http\Controllers\Api\PackageController@destroy
- Middleware: api, auth:sanctum

## api/subscriptions

- Method: GET|HEAD
- Name: subscriptions.index
- Action: App\Http\Controllers\Api\SubscriptionController@index
- Middleware: api, auth:sanctum

## api/subscriptions

- Method: POST
- Name: subscriptions.store
- Action: App\Http\Controllers\Api\SubscriptionController@store
- Middleware: api, auth:sanctum

## api/subscriptions/{subscription}

- Method: GET|HEAD
- Name: subscriptions.show
- Action: App\Http\Controllers\Api\SubscriptionController@show
- Middleware: api, auth:sanctum

## api/subscriptions/{subscription}

- Method: PUT|PATCH
- Name: subscriptions.update
- Action: App\Http\Controllers\Api\SubscriptionController@update
- Middleware: api, auth:sanctum

## api/subscriptions/{subscription}

- Method: DELETE
- Name: subscriptions.destroy
- Action: App\Http\Controllers\Api\SubscriptionController@destroy
- Middleware: api, auth:sanctum

## api/hotspot-subscriptions

- Method: GET|HEAD
- Name: hotspot-subscriptions.index
- Action: App\Http\Controllers\Api\HotspotSubscriptionController@index
- Middleware: api, auth:sanctum

## api/hotspot-subscriptions

- Method: POST
- Name: hotspot-subscriptions.store
- Action: App\Http\Controllers\Api\HotspotSubscriptionController@store
- Middleware: api, auth:sanctum

## api/hotspot-subscriptions/{hotspot_subscription}

- Method: GET|HEAD
- Name: hotspot-subscriptions.show
- Action: App\Http\Controllers\Api\HotspotSubscriptionController@show
- Middleware: api, auth:sanctum

## api/hotspot-subscriptions/{hotspot_subscription}

- Method: PUT|PATCH
- Name: hotspot-subscriptions.update
- Action: App\Http\Controllers\Api\HotspotSubscriptionController@update
- Middleware: api, auth:sanctum

## api/hotspot-subscriptions/{hotspot_subscription}

- Method: DELETE
- Name: hotspot-subscriptions.destroy
- Action: App\Http\Controllers\Api\HotspotSubscriptionController@destroy
- Middleware: api, auth:sanctum

## api/invoices

- Method: GET|HEAD
- Name: invoices.index
- Action: App\Http\Controllers\Api\InvoiceController@index
- Middleware: api, auth:sanctum

## api/invoices

- Method: POST
- Name: invoices.store
- Action: App\Http\Controllers\Api\InvoiceController@store
- Middleware: api, auth:sanctum

## api/invoices/{invoice}

- Method: GET|HEAD
- Name: invoices.show
- Action: App\Http\Controllers\Api\InvoiceController@show
- Middleware: api, auth:sanctum

## api/invoices/{invoice}

- Method: PUT|PATCH
- Name: invoices.update
- Action: App\Http\Controllers\Api\InvoiceController@update
- Middleware: api, auth:sanctum

## api/invoices/{invoice}

- Method: DELETE
- Name: invoices.destroy
- Action: App\Http\Controllers\Api\InvoiceController@destroy
- Middleware: api, auth:sanctum

## api/payments

- Method: GET|HEAD
- Name: payments.index
- Action: App\Http\Controllers\Api\PaymentController@index
- Middleware: api, auth:sanctum

## api/payments

- Method: POST
- Name: payments.store
- Action: App\Http\Controllers\Api\PaymentController@store
- Middleware: api, auth:sanctum

## api/payments/{payment}

- Method: GET|HEAD
- Name: payments.show
- Action: App\Http\Controllers\Api\PaymentController@show
- Middleware: api, auth:sanctum

## api/payments/{payment}

- Method: PUT|PATCH
- Name: payments.update
- Action: App\Http\Controllers\Api\PaymentController@update
- Middleware: api, auth:sanctum

## api/payments/{payment}

- Method: DELETE
- Name: payments.destroy
- Action: App\Http\Controllers\Api\PaymentController@destroy
- Middleware: api, auth:sanctum

## api/devices

- Method: GET|HEAD
- Name: devices.index
- Action: App\Http\Controllers\Api\DeviceController@index
- Middleware: api, auth:sanctum

## api/devices

- Method: POST
- Name: devices.store
- Action: App\Http\Controllers\Api\DeviceController@store
- Middleware: api, auth:sanctum

## api/devices/{device}

- Method: GET|HEAD
- Name: devices.show
- Action: App\Http\Controllers\Api\DeviceController@show
- Middleware: api, auth:sanctum

## api/devices/{device}

- Method: PUT|PATCH
- Name: devices.update
- Action: App\Http\Controllers\Api\DeviceController@update
- Middleware: api, auth:sanctum

## api/devices/{device}

- Method: DELETE
- Name: devices.destroy
- Action: App\Http\Controllers\Api\DeviceController@destroy
- Middleware: api, auth:sanctum

## api/inventories

- Method: GET|HEAD
- Name: inventories.index
- Action: App\Http\Controllers\Api\InventoryController@index
- Middleware: api, auth:sanctum

## api/inventories

- Method: POST
- Name: inventories.store
- Action: App\Http\Controllers\Api\InventoryController@store
- Middleware: api, auth:sanctum

## api/inventories/{inventory}

- Method: GET|HEAD
- Name: inventories.show
- Action: App\Http\Controllers\Api\InventoryController@show
- Middleware: api, auth:sanctum

## api/inventories/{inventory}

- Method: PUT|PATCH
- Name: inventories.update
- Action: App\Http\Controllers\Api\InventoryController@update
- Middleware: api, auth:sanctum

## api/inventories/{inventory}

- Method: DELETE
- Name: inventories.destroy
- Action: App\Http\Controllers\Api\InventoryController@destroy
- Middleware: api, auth:sanctum

## api/device-assignments

- Method: GET|HEAD
- Name: device-assignments.index
- Action: App\Http\Controllers\Api\DeviceAssignmentController@index
- Middleware: api, auth:sanctum

## api/device-assignments

- Method: POST
- Name: device-assignments.store
- Action: App\Http\Controllers\Api\DeviceAssignmentController@store
- Middleware: api, auth:sanctum

## api/device-assignments/{device_assignment}

- Method: GET|HEAD
- Name: device-assignments.show
- Action: App\Http\Controllers\Api\DeviceAssignmentController@show
- Middleware: api, auth:sanctum

## api/device-assignments/{device_assignment}

- Method: PUT|PATCH
- Name: device-assignments.update
- Action: App\Http\Controllers\Api\DeviceAssignmentController@update
- Middleware: api, auth:sanctum

## api/device-assignments/{device_assignment}

- Method: DELETE
- Name: device-assignments.destroy
- Action: App\Http\Controllers\Api\DeviceAssignmentController@destroy
- Middleware: api, auth:sanctum

## api/tickets

- Method: GET|HEAD
- Name: tickets.index
- Action: App\Http\Controllers\Api\TicketController@index
- Middleware: api, auth:sanctum

## api/tickets

- Method: POST
- Name: tickets.store
- Action: App\Http\Controllers\Api\TicketController@store
- Middleware: api, auth:sanctum

## api/tickets/{ticket}

- Method: GET|HEAD
- Name: tickets.show
- Action: App\Http\Controllers\Api\TicketController@show
- Middleware: api, auth:sanctum

## api/tickets/{ticket}

- Method: PUT|PATCH
- Name: tickets.update
- Action: App\Http\Controllers\Api\TicketController@update
- Middleware: api, auth:sanctum

## api/tickets/{ticket}

- Method: DELETE
- Name: tickets.destroy
- Action: App\Http\Controllers\Api\TicketController@destroy
- Middleware: api, auth:sanctum

## api/tickets/{ticket}/assign

- Method: POST
- Name: generated::yMCwqKM1mpvWwTj3
- Action: App\Http\Controllers\Api\TicketController@assign
- Middleware: api, auth:sanctum

## api/tickets/{ticket}/status

- Method: POST
- Name: generated::UFCj0vMNpps9vFrP
- Action: App\Http\Controllers\Api\TicketController@changeStatus
- Middleware: api, auth:sanctum

## api/tickets/dashboard/statistics

- Method: GET|HEAD
- Name: generated::QzKn9ecpkYouvO0m
- Action: App\Http\Controllers\Api\TicketController@dashboard
- Middleware: api, auth:sanctum

## api/notifications

- Method: GET|HEAD
- Name: notifications.index
- Action: App\Http\Controllers\Api\NotificationController@index
- Middleware: api, auth:sanctum

## api/notifications

- Method: POST
- Name: notifications.store
- Action: App\Http\Controllers\Api\NotificationController@store
- Middleware: api, auth:sanctum

## api/notifications/{notification}

- Method: GET|HEAD
- Name: notifications.show
- Action: App\Http\Controllers\Api\NotificationController@show
- Middleware: api, auth:sanctum

## api/notifications/{notification}

- Method: PUT|PATCH
- Name: notifications.update
- Action: App\Http\Controllers\Api\NotificationController@update
- Middleware: api, auth:sanctum

## api/notifications/{notification}

- Method: DELETE
- Name: notifications.destroy
- Action: App\Http\Controllers\Api\NotificationController@destroy
- Middleware: api, auth:sanctum

## api/activity-logs

- Method: GET|HEAD
- Name: activity-logs.index
- Action: App\Http\Controllers\Api\ActivityLogController@index
- Middleware: api, auth:sanctum

## api/activity-logs/{activity_log}

- Method: GET|HEAD
- Name: activity-logs.show
- Action: App\Http\Controllers\Api\ActivityLogController@show
- Middleware: api, auth:sanctum

## api/subscriptions/available-pppoe-users

- Method: GET|HEAD
- Name: generated::JUKpm9S7kfcAYT3u
- Action: App\Http\Controllers\Api\SubscriptionController@availablePppoeUsers
- Middleware: api, auth:sanctum

## api/subscriptions/{subscription}/link-pppoe

- Method: POST
- Name: generated::cOazQCZMfcT9m2wt
- Action: App\Http\Controllers\Api\SubscriptionController@linkPppoe
- Middleware: api, auth:sanctum

## api/subscriptions/{subscription}/activate

- Method: POST
- Name: generated::qUBKKPYPUsCzv5KB
- Action: App\Http\Controllers\Api\SubscriptionController@activate
- Middleware: api, auth:sanctum

## api/subscriptions/{subscription}/suspend

- Method: POST
- Name: generated::8nQ57nTUq3yMtnJN
- Action: App\Http\Controllers\Api\SubscriptionController@suspend
- Middleware: api, auth:sanctum

## api/subscriptions/{subscription}/renew

- Method: POST
- Name: generated::Ll3b71bDJnKxoa91
- Action: App\Http\Controllers\Api\SubscriptionController@renew
- Middleware: api, auth:sanctum

## api/hotspot-subscriptions/{hotspotSubscription}/activate

- Method: POST
- Name: generated::CX1AEnsmX4RSlf7Q
- Action: App\Http\Controllers\Api\HotspotSubscriptionController@activate
- Middleware: api, auth:sanctum

## api/hotspot-subscriptions/{hotspotSubscription}/suspend

- Method: POST
- Name: generated::qW6hLzAYpxiCi28n
- Action: App\Http\Controllers\Api\HotspotSubscriptionController@suspend
- Middleware: api, auth:sanctum

## api/device-assignments/{device_assignment}/return

- Method: POST
- Name: generated::dEI30Y7F4UGs5qfz
- Action: App\Http\Controllers\Api\DeviceAssignmentController@returnDevice
- Middleware: api, auth:sanctum

## api/notifications/{notification}/read

- Method: POST
- Name: generated::S4NeKjvHu0lts9B6
- Action: App\Http\Controllers\Api\NotificationController@markAsRead
- Middleware: api, auth:sanctum

## api/notifications/read-all

- Method: POST
- Name: generated::1jAMNnIrujukrhpW
- Action: App\Http\Controllers\Api\NotificationController@markAllAsRead
- Middleware: api, auth:sanctum

## api/reports/dashboard

- Method: GET|HEAD
- Name: generated::XYT0dFGwVbSdtfMN
- Action: App\Http\Controllers\Api\ReportController@dashboard
- Middleware: api, auth:sanctum

## api/reports/revenue

- Method: GET|HEAD
- Name: generated::xfB6UkqgzoIChdwZ
- Action: App\Http\Controllers\Api\ReportController@revenue
- Middleware: api, auth:sanctum

## api/reports/invoices

- Method: GET|HEAD
- Name: generated::SJukSA1wnyp4ApRG
- Action: App\Http\Controllers\Api\ReportController@invoices
- Middleware: api, auth:sanctum

## api/reports/inventory

- Method: GET|HEAD
- Name: generated::GjL6YK9LoSmmgD1T
- Action: App\Http\Controllers\Api\ReportController@inventory
- Middleware: api, auth:sanctum

## api/reports/tickets

- Method: GET|HEAD
- Name: generated::h2mo2eFXcVeGxFcM
- Action: App\Http\Controllers\Api\ReportController@tickets
- Middleware: api, auth:sanctum

## api/mikrotik/test

- Method: GET|HEAD
- Name: generated::Danx9QiYBlAruRPo
- Action: App\Http\Controllers\Api\MikrotikController@test
- Middleware: api, auth:sanctum

## api/mikrotik/dashboard-stats

- Method: GET|HEAD
- Name: generated::PHvFv4sI5j69UksE
- Action: App\Http\Controllers\Api\MikrotikController@dashboardStats
- Middleware: api, auth:sanctum

## api/mikrotik/pppoe-users

- Method: GET|HEAD
- Name: generated::AcNIS5heHQILq6Oh
- Action: App\Http\Controllers\Api\MikrotikController@pppoeUsers
- Middleware: api, auth:sanctum

## api/mikrotik/pppoe-users

- Method: POST
- Name: generated::d557l0BTuAaQOYvb
- Action: App\Http\Controllers\Api\MikrotikController@createPppoeUser
- Middleware: api, auth:sanctum

## api/mikrotik/hotspot-users

- Method: GET|HEAD
- Name: generated::p5JlQCFJ6yRo78zK
- Action: App\Http\Controllers\Api\MikrotikController@hotspotUsers
- Middleware: api, auth:sanctum

## api/mikrotik/hotspot-users/active

- Method: GET|HEAD
- Name: generated::mdnnaS1nF4XD0jgG
- Action: App\Http\Controllers\Api\MikrotikController@activeUsers
- Middleware: api, auth:sanctum

## api/mikrotik/hotspot-users

- Method: POST
- Name: generated::GpTIKttwHxOaBoK7
- Action: App\Http\Controllers\Api\MikrotikController@createHotspotUser
- Middleware: api, auth:sanctum

## api/mikrotik/hotspot-users/{username}

- Method: DELETE
- Name: generated::4GdeluGb1yTit909
- Action: App\Http\Controllers\Api\MikrotikController@deleteHotspotUser
- Middleware: api, auth:sanctum

## api/mikrotik/hotspot-users/{username}/activate

- Method: POST
- Name: generated::XCPoTGyYD5Z6GpHi
- Action: App\Http\Controllers\Api\MikrotikController@activateHotspotUser
- Middleware: api, auth:sanctum

## api/mikrotik/hotspot-users/{username}/suspend

- Method: POST
- Name: generated::A8eBxGkhYgYcktak
- Action: App\Http\Controllers\Api\MikrotikController@suspendHotspotUser
- Middleware: api, auth:sanctum

## api/customer/me

- Method: GET|HEAD
- Name: generated::L98Ze7RbowGW58xc
- Action: App\Http\Controllers\Api\CustomerAuthController@me
- Middleware: api, auth:sanctum

## api/customer/logout

- Method: POST
- Name: generated::u8ouNSmiP5FXeY1e
- Action: App\Http\Controllers\Api\CustomerAuthController@logout
- Middleware: api, auth:sanctum

## api/customer/profile

- Method: PUT
- Name: generated::kFasEvdfYutvW5BZ
- Action: App\Http\Controllers\Api\CustomerAuthController@updateProfile
- Middleware: api, auth:sanctum

## api/customer/change-password

- Method: POST
- Name: generated::AyD6wYOzUd9iptcu
- Action: App\Http\Controllers\Api\CustomerAuthController@changePassword
- Middleware: api, auth:sanctum

## api/customer/dashboard

- Method: GET|HEAD
- Name: generated::z3k7tVj4yYBzPhhQ
- Action: App\Http\Controllers\Api\CustomerDashboardController@index
- Middleware: api, auth:sanctum

## api/customer/subscription

- Method: GET|HEAD
- Name: generated::ouJJ0HKbcZSfaFon
- Action: App\Http\Controllers\Api\CustomerSubscriptionController@current
- Middleware: api, auth:sanctum

## api/customer/subscription/renew

- Method: POST
- Name: generated::JSSD8AtAxQRl7vBH
- Action: App\Http\Controllers\Api\CustomerSubscriptionController@renew
- Middleware: api, auth:sanctum

## api/customer/wallet

- Method: GET|HEAD
- Name: generated::NOFH1RytgGTAs46D
- Action: App\Http\Controllers\Api\CustomerWalletController@show
- Middleware: api, auth:sanctum

## api/customer/wallet/transactions

- Method: GET|HEAD
- Name: generated::FNCRdlhT7nkRUALH
- Action: App\Http\Controllers\Api\CustomerWalletController@transactions
- Middleware: api, auth:sanctum

## api/customer/invoices

- Method: GET|HEAD
- Name: generated::CFWSYmCHKDtVXZR5
- Action: App\Http\Controllers\Api\CustomerInvoiceController@index
- Middleware: api, auth:sanctum

## api/customer/invoices/{invoice}

- Method: GET|HEAD
- Name: generated::v5V2LmqpkRP94ekM
- Action: App\Http\Controllers\Api\CustomerInvoiceController@show
- Middleware: api, auth:sanctum

## api/customer/notifications

- Method: GET|HEAD
- Name: generated::Gs9peBfMks2cNRxF
- Action: App\Http\Controllers\Api\CustomerNotificationController@index
- Middleware: api, auth:sanctum

## api/customer/notifications/{id}/read

- Method: POST
- Name: generated::CHmgCa5M04xV3Ap4
- Action: App\Http\Controllers\Api\CustomerNotificationController@markAsRead
- Middleware: api, auth:sanctum

## api/customer/notifications/read-all

- Method: POST
- Name: generated::sr863w9HLnUaBntK
- Action: App\Http\Controllers\Api\CustomerNotificationController@markAllAsRead
- Middleware: api, auth:sanctum

## api/customer/tickets/dashboard

- Method: GET|HEAD
- Name: generated::1MQdd6xVLdEQvFGj
- Action: App\Http\Controllers\Api\CustomerTicketController@dashboard
- Middleware: api, auth:sanctum

## api/customer/tickets

- Method: GET|HEAD
- Name: generated::4YHOKIoa13MyfeeF
- Action: App\Http\Controllers\Api\CustomerTicketController@index
- Middleware: api, auth:sanctum

## api/customer/tickets

- Method: POST
- Name: generated::THz6ubynz3XdmObC
- Action: App\Http\Controllers\Api\CustomerTicketController@store
- Middleware: api, auth:sanctum

## api/customer/tickets/{ticket}

- Method: GET|HEAD
- Name: generated::IetEBWPcFE5PE9hq
- Action: App\Http\Controllers\Api\CustomerTicketController@show
- Middleware: api, auth:sanctum

## api/customer/tickets/{ticket}/messages

- Method: GET|HEAD
- Name: generated::TLWwenZmh41TTRht
- Action: App\Http\Controllers\Api\CustomerTicketController@messages
- Middleware: api, auth:sanctum

## api/customer/tickets/{ticket}/reply

- Method: POST
- Name: generated::jofGkfOKSMs4efnS
- Action: App\Http\Controllers\Api\CustomerTicketController@reply
- Middleware: api, auth:sanctum

## api/customer/tickets/{ticket}/close

- Method: POST
- Name: generated::LLKmVyZuMTCPDyrl
- Action: App\Http\Controllers\Api\CustomerTicketController@close
- Middleware: api, auth:sanctum

## api/network/dhcp/leases

- Method: GET|HEAD
- Name: generated::sxhCUkw2nNEePJ93
- Action: App\Http\Controllers\Api\MikrotikController@dhcpLeases
- Middleware: api, auth:sanctum

## api/hotspot/online

- Method: GET|HEAD
- Name: generated::oOA9tBztXGL42vLi
- Action: App\Http\Controllers\Api\HotspotController@onlineUsers
- Middleware: api

## api/hotspot/stats

- Method: GET|HEAD
- Name: generated::vXYRSFjDvSgVCaqN
- Action: App\Http\Controllers\Api\HotspotController@stats
- Middleware: api

## /

- Method: GET|HEAD
- Name: generated::XKttrL4yTn6aXQzQ
- Action: Closure
- Middleware: web

## dashboard

- Method: GET|HEAD
- Name: dashboard
- Action: App\Http\Controllers\DashboardController@index
- Middleware: web

## broadcasting/auth

- Method: GET|POST|HEAD
- Name: generated::X3tJ2N4d8kasoDB9
- Action: \Illuminate\Broadcasting\BroadcastController@authenticate
- Middleware: web

## storage/{path}

- Method: GET|HEAD
- Name: storage.local
- Action: Closure
- Middleware: 

## storage/{path}

- Method: PUT
- Name: storage.local.upload
- Action: Closure
- Middleware: