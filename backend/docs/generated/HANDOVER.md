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
- Models: 25
- Services: 11


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

Models: 25
Services: 11

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
Models: 25
Services: 11

---

# Business Rules

## BillingCycleService

**Namespace**
App\Modules\Billing\Application\Services

**Dependencies**
- None

**Methods**
- calculateNextBillingDate(3 params) : Carbon\Carbon
- calculateGraceDate(2 params) : Carbon\Carbon
- isDue(1 params) : bool
- isExpired(1 params) : bool

---

## CustomerDashboardService

**Namespace**
App\Modules\Dashboard\Application\Services

**Dependencies**
- App\Modules\Usage\UsageService
- App\Core\QueryBus\QueryDispatcher

**Methods**
- __construct(2 params) : mixed
- getDashboardData(1 params) : array

---

## DashboardService

**Namespace**
App\Modules\Dashboard\Application\Services

**Dependencies**
- App\Core\QueryBus\QueryDispatcher

**Methods**
- __construct(1 params) : mixed
- getDashboardData(0 params) : array

---

## InvoiceNumberService

**Namespace**
App\Modules\Invoice\Application\Services

**Dependencies**
- None

**Methods**
- generate(1 params) : string

---

## InvoiceService

**Namespace**
App\Modules\Invoice\Application\Services

**Dependencies**
- App\Modules\Invoice\Domain\Contracts\InvoiceRepositoryInterface
- App\Modules\Invoice\Application\Actions\CreateInvoiceAction
- App\Modules\Invoice\Application\Actions\UpdateInvoiceAction
- App\Modules\Invoice\Application\Actions\DeleteInvoiceAction
- App\Modules\Invoice\Application\Actions\SettleInvoiceAction

**Methods**
- __construct(5 params) : mixed
- findForPayment(1 params) : App\Modules\Invoice\Infrastructure\Persistence\Models\Invoice
- create(1 params) : App\Modules\Invoice\Infrastructure\Persistence\Models\Invoice
- createRenewal(1 params) : App\Modules\Invoice\Infrastructure\Persistence\Models\Invoice
- update(2 params) : App\Modules\Invoice\Infrastructure\Persistence\Models\Invoice
- delete(1 params) : bool
- settle(2 params) : App\Modules\Invoice\Infrastructure\Persistence\Models\Invoice

---

## JournalValidationService

**Namespace**
App\Modules\Accounting\Application\Services

**Dependencies**
- None

**Methods**
- validate(1 params) : void

---

## NotificationService

**Namespace**
App\Modules\Notification\Application\Services

**Dependencies**
- App\Modules\Notification\Application\Actions\CreateNotificationAction
- App\Modules\Notification\Application\Actions\CreateReminderAction
- App\Modules\Notification\Application\Actions\BillingFailedNotificationAction
- App\Modules\Notification\Application\Actions\SubscriptionRenewedNotificationAction

**Methods**
- __construct(4 params) : mixed
- create(1 params) : App\Modules\Notification\Infrastructure\Persistence\Models\Notification
- createReminder(2 params) : App\Modules\Notification\Infrastructure\Persistence\Models\Notification
- billingFailed(1 params) : App\Modules\Notification\Infrastructure\Persistence\Models\Notification
- subscriptionRenewed(1 params) : App\Modules\Notification\Infrastructure\Persistence\Models\Notification

---

## PaymentService

**Namespace**
App\Modules\Payment\Application\Services

**Dependencies**
- App\Modules\Payment\Application\Actions\CreatePaymentAction

**Methods**
- __construct(1 params) : mixed
- create(1 params) : App\Modules\Payment\Infrastructure\Persistence\Models\Payment
- createFromInvoice(5 params) : App\Modules\Payment\Infrastructure\Persistence\Models\Payment

---

## TaskService

**Namespace**
App\Modules\Task\Application\Services

**Dependencies**
- App\Modules\Task\Application\Actions\CreateTaskAction
- App\Modules\Task\Application\Actions\UpdateTaskAction
- App\Modules\Task\Application\Actions\DeleteTaskAction
- App\Modules\Task\Application\Actions\StartTaskAction
- App\Modules\Task\Application\Actions\CompleteTaskAction
- App\Modules\Task\Application\Actions\CancelTaskAction
- App\Modules\Task\Application\Actions\ReopenTaskAction

**Methods**
- __construct(7 params) : mixed
- paginate(0 params) : Illuminate\Contracts\Pagination\LengthAwarePaginator
- create(1 params) : App\Modules\Task\Infrastructure\Persistence\Models\Task
- update(2 params) : App\Modules\Task\Infrastructure\Persistence\Models\Task
- complete(1 params) : App\Modules\Task\Infrastructure\Persistence\Models\Task
- cancel(1 params) : App\Modules\Task\Infrastructure\Persistence\Models\Task
- reopen(1 params) : App\Modules\Task\Infrastructure\Persistence\Models\Task
- start(1 params) : App\Modules\Task\Infrastructure\Persistence\Models\Task
- delete(1 params) : bool

---

## TelegramNotificationService

**Namespace**
App\Modules\Notification\Application\Services

**Dependencies**
- None

**Methods**
- __construct(0 params) : mixed
- sendMessage(1 params) : mixed
- sendDeviceAlert(1 params) : mixed

---

## WalletService

**Namespace**
App\Modules\Wallet\Application\Services

**Dependencies**
- App\Modules\Wallet\Domain\Contracts\WalletRepositoryInterface
- App\Modules\Wallet\Application\Actions\DepositWalletAction

**Methods**
- __construct(2 params) : mixed
- credit(5 params) : void

---

---

# Models

---

## Account

**Namespace**

```
App\Modules\Accounting\Infrastructure\Persistence\Models
```

**File**

```
/var/www/app/Modules/Accounting/Infrastructure/Persistence/Models/Account.php
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

- parent()
- children()
- journalEntryLines()
- factory()

---

## ActivityLog

**Namespace**

```
App\Modules\Activity\Infrastructure\Persistence\Models
```

**File**

```
/var/www/app/Modules/Activity/Infrastructure/Persistence/Models/ActivityLog.php
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
App\Modules\Customer\Infrastructure\Persistence\Models
```

**File**

```
/var/www/app/Modules/Customer/Infrastructure/Persistence/Models/Customer.php
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
App\Modules\Inventory\Infrastructure\Persistence\Models
```

**File**

```
/var/www/app/Modules/Inventory/Infrastructure/Persistence/Models/Device.php
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
- factory()

---

## DeviceAssignment

**Namespace**

```
App\Modules\Inventory\Infrastructure\Persistence\Models
```

**File**

```
/var/www/app/Modules/Inventory/Infrastructure/Persistence/Models/DeviceAssignment.php
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
- factory()

---

## HotspotSubscription

**Namespace**

```
App\Modules\Subscription\Infrastructure\Persistence\Models
```

**File**

```
/var/www/app/Modules/Subscription/Infrastructure/Persistence/Models/HotspotSubscription.php
```

**Properties**

- $table : mixed
- $fillable : mixed
- $casts : mixed
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
- factory()

---

## HotspotUser

**Namespace**

```
App\Modules\Network\Infrastructure\Persistence\Models
```

**File**

```
/var/www/app/Modules/Network/Infrastructure/Persistence/Models/HotspotUser.php
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
App\Modules\Inventory\Infrastructure\Persistence\Models
```

**File**

```
/var/www/app/Modules/Inventory/Infrastructure/Persistence/Models/Inventory.php
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
- factory()

---

## Invoice

**Namespace**

```
App\Modules\Invoice\Infrastructure\Persistence\Models
```

**File**

```
/var/www/app/Modules/Invoice/Infrastructure/Persistence/Models/Invoice.php
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
- hotspotSubscription()
- factory()

---

## JournalEntry

**Namespace**

```
App\Modules\Accounting\Infrastructure\Persistence\Models
```

**File**

```
/var/www/app/Modules/Accounting/Infrastructure/Persistence/Models/JournalEntry.php
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
- creator()
- approver()
- lines()
- postedBy()
- factory()

---

## JournalEntryLine

**Namespace**

```
App\Modules\Accounting\Infrastructure\Persistence\Models
```

**File**

```
/var/www/app/Modules/Accounting/Infrastructure/Persistence/Models/JournalEntryLine.php
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

- journalEntry()
- account()
- factory()

---

## NetworkDevice

**Namespace**

```
App\Modules\Network\Infrastructure\Persistence\Models
```

**File**

```
/var/www/app/Modules/Network/Infrastructure/Persistence/Models/NetworkDevice.php
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
App\Modules\Notification\Infrastructure\Persistence\Models
```

**File**

```
/var/www/app/Modules/Notification/Infrastructure/Persistence/Models/Notification.php
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

---

## PPPoEUser

**Namespace**

```
App\Modules\Network\Infrastructure\Persistence\Models
```

**File**

```
/var/www/app/Modules/Network/Infrastructure/Persistence/Models/PPPoEUser.php
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
App\Modules\Package\Infrastructure\Persistence\Models
```

**File**

```
/var/www/app/Modules/Package/Infrastructure/Persistence/Models/Package.php
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
App\Modules\Payment\Infrastructure\Persistence\Models
```

**File**

```
/var/www/app/Modules/Payment/Infrastructure/Persistence/Models/Payment.php
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

## Report

**Namespace**

```
App\Modules\Reports\Infrastructure\Persistence\Models
```

**File**

```
/var/www/app/Modules/Reports/Infrastructure/Persistence/Models/Report.php
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

- exports()
- user()
- factory()

---

## ReportExport

**Namespace**

```
App\Modules\Reports\Infrastructure\Persistence\Models
```

**File**

```
/var/www/app/Modules/Reports/Infrastructure/Persistence/Models/ReportExport.php
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

- report()
- user()
- factory()

---

## ScheduledReport

**Namespace**

```
App\Modules\Reports\Infrastructure\Persistence\Models
```

**File**

```
/var/www/app/Modules/Reports/Infrastructure/Persistence/Models/ScheduledReport.php
```

**Properties**

- $table : mixed
- $fillable : mixed
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

- user()
- factory()

---

## Subscription

**Namespace**

```
App\Modules\Subscription\Infrastructure\Persistence\Models
```

**File**

```
/var/www/app/Modules/Subscription/Infrastructure/Persistence/Models/Subscription.php
```

**Properties**

- $table : mixed
- $fillable : mixed
- $casts : mixed
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
- transitionTo()
- activate()
- suspend()
- restore()
- expire()
- enterGrace()
- cancel()
- terminate()
- renew()
- isActive()
- isSuspended()
- isExpired()
- isGrace()
- isCancelled()
- isTerminated()
- isClosed()
- canActivate()
- canSuspend()
- canExpire()
- canRestore()
- canRenew()
- canCancel()
- scopeActive()
- scopeExpired()
- scopeSuspended()
- scopeGrace()
- scopeCancelled()
- scopeTerminated()
- factory()

---

## Task

**Namespace**

```
App\Modules\Task\Infrastructure\Persistence\Models
```

**File**

```
/var/www/app/Modules/Task/Infrastructure/Persistence/Models/Task.php
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
- user()
- factory()

---

## Ticket

**Namespace**

```
App\Modules\Ticket\Infrastructure\Persistence\Models
```

**File**

```
/var/www/app/Modules/Ticket/Infrastructure/Persistence/Models/Ticket.php
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
- factory()

---

## TicketReply

**Namespace**

```
App\Modules\Ticket\Infrastructure\Persistence\Models
```

**File**

```
/var/www/app/Modules/Ticket/Infrastructure/Persistence/Models/TicketReply.php
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
- factory()

---

## Wallet

**Namespace**

```
App\Modules\Wallet\Infrastructure\Persistence\Models
```

**File**

```
/var/www/app/Modules/Wallet/Infrastructure/Persistence/Models/Wallet.php
```

**Properties**

- $table : mixed
- $fillable : mixed
- $casts : mixed
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

## WalletTransaction

**Namespace**

```
App\Modules\Wallet\Infrastructure\Persistence\Models
```

**File**

```
/var/www/app/Modules/Wallet/Infrastructure/Persistence/Models/WalletTransaction.php
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

- customer()

---

# Services

---

## BillingCycleService

**Namespace**

```
App\Modules\Billing\Application\Services
```

**File**

```
/var/www/app/Modules/Billing/Application/Services/BillingCycleService.php
```

**Methods**

- calculateNextBillingDate() : Carbon\Carbon
- calculateGraceDate() : Carbon\Carbon
- isDue() : bool
- isExpired() : bool

---

## CustomerDashboardService

**Namespace**

```
App\Modules\Dashboard\Application\Services
```

**File**

```
/var/www/app/Modules/Dashboard/Application/Services/CustomerDashboardService.php
```

**Constructor Dependencies**

- UsageService $usageService
- QueryDispatcher $queryDispatcher

**Properties**

- $usageService : App\Modules\Usage\UsageService
- $queryDispatcher : App\Core\QueryBus\QueryDispatcher

**Methods**

- getDashboardData() : array

---

## DashboardService

**Namespace**

```
App\Modules\Dashboard\Application\Services
```

**File**

```
/var/www/app/Modules/Dashboard/Application/Services/DashboardService.php
```

**Constructor Dependencies**

- QueryDispatcher $queryDispatcher

**Properties**

- $queryDispatcher : App\Core\QueryBus\QueryDispatcher

**Methods**

- getDashboardData() : array

---

## InvoiceNumberService

**Namespace**

```
App\Modules\Invoice\Application\Services
```

**File**

```
/var/www/app/Modules/Invoice/Application/Services/InvoiceNumberService.php
```

**Methods**

- generate() : string

---

## InvoiceService

**Namespace**

```
App\Modules\Invoice\Application\Services
```

**File**

```
/var/www/app/Modules/Invoice/Application/Services/InvoiceService.php
```

**Constructor Dependencies**

- InvoiceRepositoryInterface $repository
- CreateInvoiceAction $createInvoice
- UpdateInvoiceAction $updateInvoice
- DeleteInvoiceAction $deleteInvoice
- SettleInvoiceAction $settleInvoice

**Properties**

- $repository : App\Modules\Invoice\Domain\Contracts\InvoiceRepositoryInterface
- $createInvoice : App\Modules\Invoice\Application\Actions\CreateInvoiceAction
- $updateInvoice : App\Modules\Invoice\Application\Actions\UpdateInvoiceAction
- $deleteInvoice : App\Modules\Invoice\Application\Actions\DeleteInvoiceAction
- $settleInvoice : App\Modules\Invoice\Application\Actions\SettleInvoiceAction

**Methods**

- findForPayment() : App\Modules\Invoice\Infrastructure\Persistence\Models\Invoice
- create() : App\Modules\Invoice\Infrastructure\Persistence\Models\Invoice
- createRenewal() : App\Modules\Invoice\Infrastructure\Persistence\Models\Invoice
- update() : App\Modules\Invoice\Infrastructure\Persistence\Models\Invoice
- delete() : bool
- settle() : App\Modules\Invoice\Infrastructure\Persistence\Models\Invoice

---

## JournalValidationService

**Namespace**

```
App\Modules\Accounting\Application\Services
```

**File**

```
/var/www/app/Modules/Accounting/Application/Services/JournalValidationService.php
```

**Methods**

- validate() : void

---

## NotificationService

**Namespace**

```
App\Modules\Notification\Application\Services
```

**File**

```
/var/www/app/Modules/Notification/Application/Services/NotificationService.php
```

**Constructor Dependencies**

- CreateNotificationAction $createNotification
- CreateReminderAction $createReminder
- BillingFailedNotificationAction $billingFailed
- SubscriptionRenewedNotificationAction $subscriptionRenewed

**Properties**

- $createNotification : App\Modules\Notification\Application\Actions\CreateNotificationAction
- $createReminder : App\Modules\Notification\Application\Actions\CreateReminderAction
- $billingFailed : App\Modules\Notification\Application\Actions\BillingFailedNotificationAction
- $subscriptionRenewed : App\Modules\Notification\Application\Actions\SubscriptionRenewedNotificationAction

**Methods**

- create() : App\Modules\Notification\Infrastructure\Persistence\Models\Notification
- createReminder() : App\Modules\Notification\Infrastructure\Persistence\Models\Notification
- billingFailed() : App\Modules\Notification\Infrastructure\Persistence\Models\Notification
- subscriptionRenewed() : App\Modules\Notification\Infrastructure\Persistence\Models\Notification

---

## PaymentService

**Namespace**

```
App\Modules\Payment\Application\Services
```

**File**

```
/var/www/app/Modules/Payment/Application/Services/PaymentService.php
```

**Constructor Dependencies**

- CreatePaymentAction $createPayment

**Properties**

- $createPayment : App\Modules\Payment\Application\Actions\CreatePaymentAction

**Methods**

- create() : App\Modules\Payment\Infrastructure\Persistence\Models\Payment
- createFromInvoice() : App\Modules\Payment\Infrastructure\Persistence\Models\Payment

---

## TaskService

**Namespace**

```
App\Modules\Task\Application\Services
```

**File**

```
/var/www/app/Modules/Task/Application/Services/TaskService.php
```

**Constructor Dependencies**

- CreateTaskAction $createTask
- UpdateTaskAction $updateTask
- DeleteTaskAction $deleteTask
- StartTaskAction $startTask
- CompleteTaskAction $completeTask
- CancelTaskAction $cancelTask
- ReopenTaskAction $reopenTask

**Properties**

- $createTask : App\Modules\Task\Application\Actions\CreateTaskAction
- $updateTask : App\Modules\Task\Application\Actions\UpdateTaskAction
- $deleteTask : App\Modules\Task\Application\Actions\DeleteTaskAction
- $startTask : App\Modules\Task\Application\Actions\StartTaskAction
- $completeTask : App\Modules\Task\Application\Actions\CompleteTaskAction
- $cancelTask : App\Modules\Task\Application\Actions\CancelTaskAction
- $reopenTask : App\Modules\Task\Application\Actions\ReopenTaskAction

**Methods**

- paginate() : Illuminate\Contracts\Pagination\LengthAwarePaginator
- create() : App\Modules\Task\Infrastructure\Persistence\Models\Task
- update() : App\Modules\Task\Infrastructure\Persistence\Models\Task
- complete() : App\Modules\Task\Infrastructure\Persistence\Models\Task
- cancel() : App\Modules\Task\Infrastructure\Persistence\Models\Task
- reopen() : App\Modules\Task\Infrastructure\Persistence\Models\Task
- start() : App\Modules\Task\Infrastructure\Persistence\Models\Task
- delete() : bool

---

## TelegramNotificationService

**Namespace**

```
App\Modules\Notification\Application\Services
```

**File**

```
/var/www/app/Modules/Notification/Application/Services/TelegramNotificationService.php
```

**Properties**

- $botToken : mixed
- $chatId : mixed

**Methods**

- sendMessage() : mixed
- sendDeviceAlert() : mixed

---

## WalletService

**Namespace**

```
App\Modules\Wallet\Application\Services
```

**File**

```
/var/www/app/Modules/Wallet/Application/Services/WalletService.php
```

**Constructor Dependencies**

- WalletRepositoryInterface $repository
- DepositWalletAction $depositWallet

**Properties**

- $repository : App\Modules\Wallet\Domain\Contracts\WalletRepositoryInterface
- $depositWallet : App\Modules\Wallet\Application\Actions\DepositWalletAction

**Methods**

- credit() : void

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

## CustomerAuthController

**Namespace**

```
App\Http\Controllers
```

**File**

```
/var/www/app/Http/Controllers/CustomerAuthController.php
```

**Public Methods**

- showLoginForm()
- login()
- logout()

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

- CommandDispatcher $commandDispatcher
- QueryDispatcher $queryDispatcher

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

**Dependencies**

- QueryDispatcher $queryDispatcher

**Public Methods**

- index()
- show()

---

## CustomerInvoiceController

**Namespace**

```
App\Http\Controllers
```

**File**

```
/var/www/app/Http/Controllers/CustomerInvoiceController.php
```

**Dependencies**

- QueryDispatcher $queryDispatcher

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

**Dependencies**

- MarkNotificationAsReadAction $markAsRead
- MarkAllNotificationsAsReadAction $markAllAsRead

**Public Methods**

- index()
- markAsRead()
- markAllAsRead()

---

## CustomerProfileController

**Namespace**

```
App\Http\Controllers
```

**File**

```
/var/www/app/Http/Controllers/CustomerProfileController.php
```

**Public Methods**

- show()
- update()
- changePassword()

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

- CreateCustomerTicketAction $createCustomerTicket
- ReplyAsCustomerAction $replyAsCustomer
- CloseTicketByCustomerAction $closeTicketByCustomer
- QueryDispatcher $queryDispatcher

**Public Methods**

- index()
- dashboard()
- show()
- messages()
- store()
- reply()
- close()

---

## CustomerTicketController

**Namespace**

```
App\Http\Controllers
```

**File**

```
/var/www/app/Http/Controllers/CustomerTicketController.php
```

**Dependencies**

- CreateCustomerTicketAction $createCustomerTicket
- ReplyAsCustomerAction $replyAsCustomer
- CloseTicketByCustomerAction $closeTicketByCustomer
- QueryDispatcher $queryDispatcher

**Public Methods**

- index()
- create()
- store()
- show()
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

**Dependencies**

- QueryDispatcher $queryDispatcher

**Public Methods**

- show()
- transactions()

---

## DHCPController

**Namespace**

```
App\Http\Controllers\Api\Network
```

**File**

```
/var/www/app/Http/Controllers/Api/Network/DHCPController.php
```

**Dependencies**

- NetworkManager $networkManager

**Public Methods**

- index()
- create()
- store()
- edit()
- update()
- destroy()

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

**Public Methods**

- index()
- stats()

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

**Dependencies**

- CommandDispatcher $commandDispatcher
- QueryDispatcher $queryDispatcher

**Public Methods**

- index()
- store()
- show()
- update()
- destroy()
- returnDevice()

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

**Dependencies**

- CommandDispatcher $commandDispatcher
- QueryDispatcher $queryDispatcher

**Public Methods**

- index()
- store()
- show()
- update()
- destroy()

---

## DhcpApiController

**Namespace**

```
App\Http\Controllers\Api
```

**File**

```
/var/www/app/Http/Controllers/Api/DhcpApiController.php
```

**Dependencies**

- NetworkManager $networkManager

**Public Methods**

- index()
- store()
- update()
- destroy()

---

## FirewallApiController

**Namespace**

```
App\Http\Controllers\Api
```

**File**

```
/var/www/app/Http/Controllers/Api/FirewallApiController.php
```

**Dependencies**

- NetworkManager $networkManager

**Public Methods**

- index()
- store()
- update()
- destroy()

---

## FirewallController

**Namespace**

```
App\Http\Controllers\Api\Network
```

**File**

```
/var/www/app/Http/Controllers/Api/Network/FirewallController.php
```

**Dependencies**

- NetworkManager $networkManager

**Public Methods**

- index()
- create()
- store()
- edit()
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

**Dependencies**

- CommandDispatcher $commandDispatcher
- QueryDispatcher $queryDispatcher

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

- CommandDispatcher $commandDispatcher
- QueryDispatcher $queryDispatcher

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

- NetworkManager $networkManager
- QueryDispatcher $queryDispatcher

**Public Methods**

- test()
- pppoeUsers()
- hotspotUsers()
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

**Dependencies**

- MarkNotificationAsReadAction $markAsRead
- MarkAllNotificationsAsReadAction $markAllAsRead
- DeleteNotificationAction $delete

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

- PackageRepositoryInterface $repository
- CreatePackageAction $createAction
- UpdatePackageAction $updateAction
- DeletePackageAction $deleteAction

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
- QueryDispatcher $queryDispatcher

**Public Methods**

- index()
- store()
- show()
- update()
- destroy()

---

## QueueApiController

**Namespace**

```
App\Http\Controllers\Api
```

**File**

```
/var/www/app/Http/Controllers/Api/QueueApiController.php
```

**Dependencies**

- NetworkManager $networkManager

**Public Methods**

- index()
- store()
- update()
- toggle()
- destroy()

---

## QueueController

**Namespace**

```
App\Http\Controllers\Api\Network
```

**File**

```
/var/www/app/Http/Controllers/Api/Network/QueueController.php
```

**Dependencies**

- NetworkManager $networkManager

**Public Methods**

- index()
- create()
- store()
- edit()
- update()
- toggle()
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

**Dependencies**

- QueryDispatcher $queryDispatcher

**Public Methods**

- dashboard()
- revenue()
- invoices()
- inventory()
- tickets()

---

## ScheduledReportController

**Namespace**

```
App\Http\Controllers\Api
```

**File**

```
/var/www/app/Http/Controllers/Api/ScheduledReportController.php
```

**Dependencies**

- ScheduledReportRepositoryInterface $repository
- CreateScheduledReportAction $createAction
- UpdateScheduledReportAction $updateAction
- DeleteScheduledReportAction $deleteAction
- ActivateScheduledReportAction $activateAction
- DeactivateScheduledReportAction $deactivateAction

**Public Methods**

- index()
- store()
- show()
- update()
- destroy()
- activate()
- deactivate()

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

- WorkflowEngine $engine
- ActivateWorkflow $activateWorkflow
- SuspendWorkflow $suspendWorkflow
- ExpireWorkflow $expireWorkflow
- RestoreWorkflow $restoreWorkflow
- RenewWorkflow $renewWorkflow

**Public Methods**

- activate()
- suspend()
- renew()
- restore()
- expire()

---

## TaskController

**Namespace**

```
App\Http\Controllers\Api\Task
```

**File**

```
/var/www/app/Http/Controllers/Api/Task/TaskController.php
```

**Dependencies**

- TaskService $service

**Public Methods**

- index()
- store()
- update()
- destroy()

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

- CreateAdminTicketAction $createAdminTicket
- UpdateTicketFromAdminAction $updateTicket
- DeleteTicketAction $deleteTicket
- ReplyAsStaffAction $replyAsStaff
- ChangeTicketStatusAction $changeTicketStatus
- AssignTicketAction $assignTicket
- QueryDispatcher $queryDispatcher

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
- Name: -
- Action: App\Http\Controllers\Api\AuthController@login
- Middleware: api

## api/customer/login

- Method: POST
- Name: -
- Action: App\Http\Controllers\Api\CustomerAuthController@login
- Middleware: api

## api/scheduled-reports

- Method: GET|HEAD
- Name: scheduled-reports.index
- Action: App\Http\Controllers\Api\ScheduledReportController@index
- Middleware: api, auth:sanctum

## api/scheduled-reports

- Method: POST
- Name: scheduled-reports.store
- Action: App\Http\Controllers\Api\ScheduledReportController@store
- Middleware: api, auth:sanctum

## api/scheduled-reports/{scheduled_report}

- Method: GET|HEAD
- Name: scheduled-reports.show
- Action: App\Http\Controllers\Api\ScheduledReportController@show
- Middleware: api, auth:sanctum

## api/scheduled-reports/{scheduled_report}

- Method: PUT|PATCH
- Name: scheduled-reports.update
- Action: App\Http\Controllers\Api\ScheduledReportController@update
- Middleware: api, auth:sanctum

## api/scheduled-reports/{scheduled_report}

- Method: DELETE
- Name: scheduled-reports.destroy
- Action: App\Http\Controllers\Api\ScheduledReportController@destroy
- Middleware: api, auth:sanctum

## api/scheduled-reports/{scheduledReport}/activate

- Method: PATCH
- Name: -
- Action: App\Http\Controllers\Api\ScheduledReportController@activate
- Middleware: api, auth:sanctum

## api/scheduled-reports/{scheduledReport}/deactivate

- Method: PATCH
- Name: -
- Action: App\Http\Controllers\Api\ScheduledReportController@deactivate
- Middleware: api, auth:sanctum

## api/me

- Method: GET|HEAD
- Name: -
- Action: App\Http\Controllers\Api\AuthController@me
- Middleware: api, auth:sanctum

## api/logout

- Method: POST
- Name: -
- Action: App\Http\Controllers\Api\AuthController@logout
- Middleware: api, auth:sanctum

## api/tickets/{ticket}/reply

- Method: POST
- Name: -
- Action: App\Http\Controllers\Api\TicketController@reply
- Middleware: api, auth:sanctum

## api/tickets/{ticket}/messages

- Method: GET|HEAD
- Name: -
- Action: App\Http\Controllers\Api\TicketController@messages
- Middleware: api, auth:sanctum

## api/dashboard

- Method: GET|HEAD
- Name: -
- Action: App\Http\Controllers\Api\DashboardController@index
- Middleware: api, auth:sanctum

## api/dashboard/stats

- Method: GET|HEAD
- Name: -
- Action: App\Http\Controllers\Api\DashboardController@stats
- Middleware: api

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
- Name: -
- Action: App\Http\Controllers\Api\TicketController@assign
- Middleware: api, auth:sanctum

## api/tickets/{ticket}/status

- Method: POST
- Name: -
- Action: App\Http\Controllers\Api\TicketController@changeStatus
- Middleware: api, auth:sanctum

## api/tickets/dashboard/statistics

- Method: GET|HEAD
- Name: -
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
- Name: -
- Action: App\Http\Controllers\Api\SubscriptionController@availablePppoeUsers
- Middleware: api, auth:sanctum

## api/subscriptions/{subscription}/link-pppoe

- Method: POST
- Name: -
- Action: App\Http\Controllers\Api\SubscriptionController@linkPppoe
- Middleware: api, auth:sanctum

## api/subscriptions/{subscription}/activate

- Method: POST
- Name: -
- Action: App\Http\Controllers\Api\SubscriptionController@activate
- Middleware: api, auth:sanctum

## api/subscriptions/{subscription}/suspend

- Method: POST
- Name: -
- Action: App\Http\Controllers\Api\SubscriptionController@suspend
- Middleware: api, auth:sanctum

## api/subscriptions/{subscription}/renew

- Method: POST
- Name: -
- Action: App\Http\Controllers\Api\SubscriptionController@renew
- Middleware: api, auth:sanctum

## api/subscriptions/{subscription}/restore

- Method: POST
- Name: -
- Action: App\Http\Controllers\Api\SubscriptionController@restore
- Middleware: api, auth:sanctum

## api/subscriptions/{subscription}/expire

- Method: POST
- Name: -
- Action: App\Http\Controllers\Api\SubscriptionController@expire
- Middleware: api, auth:sanctum

## api/hotspot-subscriptions/{hotspotSubscription}/activate

- Method: POST
- Name: -
- Action: App\Http\Controllers\Api\HotspotSubscriptionController@activate
- Middleware: api, auth:sanctum

## api/hotspot-subscriptions/{hotspotSubscription}/suspend

- Method: POST
- Name: -
- Action: App\Http\Controllers\Api\HotspotSubscriptionController@suspend
- Middleware: api, auth:sanctum

## api/device-assignments/{device_assignment}/return

- Method: POST
- Name: -
- Action: App\Http\Controllers\Api\DeviceAssignmentController@returnDevice
- Middleware: api, auth:sanctum

## api/notifications/{notification}/read

- Method: POST
- Name: -
- Action: App\Http\Controllers\Api\NotificationController@markAsRead
- Middleware: api, auth:sanctum

## api/notifications/read-all

- Method: POST
- Name: -
- Action: App\Http\Controllers\Api\NotificationController@markAllAsRead
- Middleware: api, auth:sanctum

## api/reports/dashboard

- Method: GET|HEAD
- Name: -
- Action: App\Http\Controllers\Api\ReportController@dashboard
- Middleware: api, auth:sanctum

## api/reports/revenue

- Method: GET|HEAD
- Name: -
- Action: App\Http\Controllers\Api\ReportController@revenue
- Middleware: api, auth:sanctum

## api/reports/invoices

- Method: GET|HEAD
- Name: -
- Action: App\Http\Controllers\Api\ReportController@invoices
- Middleware: api, auth:sanctum

## api/reports/inventory

- Method: GET|HEAD
- Name: -
- Action: App\Http\Controllers\Api\ReportController@inventory
- Middleware: api, auth:sanctum

## api/reports/tickets

- Method: GET|HEAD
- Name: -
- Action: App\Http\Controllers\Api\ReportController@tickets
- Middleware: api, auth:sanctum

## api/mikrotik/test

- Method: GET|HEAD
- Name: -
- Action: App\Http\Controllers\Api\MikrotikController@test
- Middleware: api, auth:sanctum

## api/mikrotik/dashboard-stats

- Method: GET|HEAD
- Name: -
- Action: App\Http\Controllers\Api\MikrotikController@dashboardStats
- Middleware: api, auth:sanctum

## api/mikrotik/pppoe-users

- Method: GET|HEAD
- Name: -
- Action: App\Http\Controllers\Api\MikrotikController@pppoeUsers
- Middleware: api, auth:sanctum

## api/mikrotik/pppoe-users

- Method: POST
- Name: -
- Action: App\Http\Controllers\Api\MikrotikController@createPppoeUser
- Middleware: api, auth:sanctum

## api/mikrotik/hotspot-users

- Method: GET|HEAD
- Name: -
- Action: App\Http\Controllers\Api\MikrotikController@hotspotUsers
- Middleware: api, auth:sanctum

## api/mikrotik/hotspot-users/active

- Method: GET|HEAD
- Name: -
- Action: App\Http\Controllers\Api\MikrotikController@activeUsers
- Middleware: api, auth:sanctum

## api/mikrotik/hotspot-users

- Method: POST
- Name: -
- Action: App\Http\Controllers\Api\MikrotikController@createHotspotUser
- Middleware: api, auth:sanctum

## api/mikrotik/hotspot-users/{username}

- Method: DELETE
- Name: -
- Action: App\Http\Controllers\Api\MikrotikController@deleteHotspotUser
- Middleware: api, auth:sanctum

## api/mikrotik/hotspot-users/{username}/activate

- Method: POST
- Name: -
- Action: App\Http\Controllers\Api\MikrotikController@activateHotspotUser
- Middleware: api, auth:sanctum

## api/mikrotik/hotspot-users/{username}/suspend

- Method: POST
- Name: -
- Action: App\Http\Controllers\Api\MikrotikController@suspendHotspotUser
- Middleware: api, auth:sanctum

## api/customer/me

- Method: GET|HEAD
- Name: -
- Action: App\Http\Controllers\Api\CustomerAuthController@me
- Middleware: api, auth:sanctum

## api/customer/logout

- Method: POST
- Name: -
- Action: App\Http\Controllers\Api\CustomerAuthController@logout
- Middleware: api, auth:sanctum

## api/customer/profile

- Method: PUT
- Name: -
- Action: App\Http\Controllers\Api\CustomerAuthController@updateProfile
- Middleware: api, auth:sanctum

## api/customer/change-password

- Method: POST
- Name: -
- Action: App\Http\Controllers\Api\CustomerAuthController@changePassword
- Middleware: api, auth:sanctum

## api/customer/dashboard

- Method: GET|HEAD
- Name: -
- Action: App\Http\Controllers\Api\CustomerDashboardController@index
- Middleware: api, auth:sanctum

## api/customer/subscription

- Method: GET|HEAD
- Name: -
- Action: App\Http\Controllers\Api\CustomerSubscriptionController@current
- Middleware: api, auth:sanctum

## api/customer/subscription/renew

- Method: POST
- Name: -
- Action: App\Http\Controllers\Api\CustomerSubscriptionController@renew
- Middleware: api, auth:sanctum

## api/customer/wallet

- Method: GET|HEAD
- Name: -
- Action: App\Http\Controllers\Api\CustomerWalletController@show
- Middleware: api, auth:sanctum

## api/customer/wallet/transactions

- Method: GET|HEAD
- Name: -
- Action: App\Http\Controllers\Api\CustomerWalletController@transactions
- Middleware: api, auth:sanctum

## api/customer/invoices

- Method: GET|HEAD
- Name: -
- Action: App\Http\Controllers\Api\CustomerInvoiceController@index
- Middleware: api, auth:sanctum

## api/customer/invoices/{invoice}

- Method: GET|HEAD
- Name: -
- Action: App\Http\Controllers\Api\CustomerInvoiceController@show
- Middleware: api, auth:sanctum

## api/customer/notifications

- Method: GET|HEAD
- Name: -
- Action: App\Http\Controllers\Api\CustomerNotificationController@index
- Middleware: api, auth:sanctum

## api/customer/notifications/{id}/read

- Method: POST
- Name: -
- Action: App\Http\Controllers\Api\CustomerNotificationController@markAsRead
- Middleware: api, auth:sanctum

## api/customer/notifications/read-all

- Method: POST
- Name: -
- Action: App\Http\Controllers\Api\CustomerNotificationController@markAllAsRead
- Middleware: api, auth:sanctum

## api/customer/tickets/dashboard

- Method: GET|HEAD
- Name: -
- Action: App\Http\Controllers\Api\CustomerTicketController@dashboard
- Middleware: api, auth:sanctum

## api/customer/tickets

- Method: GET|HEAD
- Name: -
- Action: App\Http\Controllers\Api\CustomerTicketController@index
- Middleware: api, auth:sanctum

## api/customer/tickets

- Method: POST
- Name: -
- Action: App\Http\Controllers\Api\CustomerTicketController@store
- Middleware: api, auth:sanctum

## api/customer/tickets/{ticket}

- Method: GET|HEAD
- Name: -
- Action: App\Http\Controllers\Api\CustomerTicketController@show
- Middleware: api, auth:sanctum

## api/customer/tickets/{ticket}/messages

- Method: GET|HEAD
- Name: -
- Action: App\Http\Controllers\Api\CustomerTicketController@messages
- Middleware: api, auth:sanctum

## api/customer/tickets/{ticket}/reply

- Method: POST
- Name: -
- Action: App\Http\Controllers\Api\CustomerTicketController@reply
- Middleware: api, auth:sanctum

## api/customer/tickets/{ticket}/close

- Method: POST
- Name: -
- Action: App\Http\Controllers\Api\CustomerTicketController@close
- Middleware: api, auth:sanctum

## api/network/dhcp/leases

- Method: GET|HEAD
- Name: -
- Action: App\Http\Controllers\Api\MikrotikController@dhcpLeases
- Middleware: api, auth:sanctum

## api/hotspot/online

- Method: GET|HEAD
- Name: -
- Action: App\Http\Controllers\Api\HotspotController@onlineUsers
- Middleware: api

## api/hotspot/stats

- Method: GET|HEAD
- Name: -
- Action: App\Http\Controllers\Api\HotspotController@stats
- Middleware: api

## api/tasks

- Method: GET|HEAD
- Name: tasks.index
- Action: App\Http\Controllers\Api\Task\TaskController@index
- Middleware: api

## api/tasks

- Method: POST
- Name: tasks.store
- Action: App\Http\Controllers\Api\Task\TaskController@store
- Middleware: api

## api/tasks/{task}

- Method: GET|HEAD
- Name: tasks.show
- Action: App\Http\Controllers\Api\Task\TaskController@show
- Middleware: api

## api/tasks/{task}

- Method: PUT|PATCH
- Name: tasks.update
- Action: App\Http\Controllers\Api\Task\TaskController@update
- Middleware: api

## api/tasks/{task}

- Method: DELETE
- Name: tasks.destroy
- Action: App\Http\Controllers\Api\Task\TaskController@destroy
- Middleware: api

## /

- Method: GET|HEAD|POST|PUT|PATCH|DELETE|OPTIONS
- Name: -
- Action: \Illuminate\Routing\RedirectController
- Middleware: web

## dashboard

- Method: GET|HEAD
- Name: dashboard
- Action: App\Http\Controllers\Api\DashboardController@index
- Middleware: web

## queues

- Method: GET|HEAD
- Name: queues.index
- Action: App\Http\Controllers\Api\Network\QueueController@index
- Middleware: web

## queues/create

- Method: GET|HEAD
- Name: queues.create
- Action: App\Http\Controllers\Api\Network\QueueController@create
- Middleware: web

## queues

- Method: POST
- Name: queues.store
- Action: App\Http\Controllers\Api\Network\QueueController@store
- Middleware: web

## queues/{name}/toggle

- Method: POST
- Name: queues.toggle
- Action: App\Http\Controllers\Api\Network\QueueController@toggle
- Middleware: web

## queues/{name}

- Method: DELETE
- Name: queues.destroy
- Action: App\Http\Controllers\Api\Network\QueueController@destroy
- Middleware: web

## firewall

- Method: GET|HEAD
- Name: firewall.index
- Action: App\Http\Controllers\Api\Network\FirewallController@index
- Middleware: web

## firewall/create

- Method: GET|HEAD
- Name: firewall.create
- Action: App\Http\Controllers\Api\Network\FirewallController@create
- Middleware: web

## firewall

- Method: POST
- Name: firewall.store
- Action: App\Http\Controllers\Api\Network\FirewallController@store
- Middleware: web

## firewall/{id}

- Method: DELETE
- Name: firewall.destroy
- Action: App\Http\Controllers\Api\Network\FirewallController@destroy
- Middleware: web

## dhcp

- Method: GET|HEAD
- Name: dhcp.index
- Action: App\Http\Controllers\Api\Network\DHCPController@index
- Middleware: web

## dhcp/create

- Method: GET|HEAD
- Name: dhcp.create
- Action: App\Http\Controllers\Api\Network\DHCPController@create
- Middleware: web

## dhcp

- Method: POST
- Name: dhcp.store
- Action: App\Http\Controllers\Api\Network\DHCPController@store
- Middleware: web

## dhcp/{id}

- Method: DELETE
- Name: dhcp.destroy
- Action: App\Http\Controllers\Api\Network\DHCPController@destroy
- Middleware: web

## queues/{name}/edit

- Method: GET|HEAD
- Name: queues.edit
- Action: App\Http\Controllers\Api\Network\QueueController@edit
- Middleware: web

## queues/{name}

- Method: PUT
- Name: queues.update
- Action: App\Http\Controllers\Api\Network\QueueController@update
- Middleware: web

## firewall/{id}/edit

- Method: GET|HEAD
- Name: firewall.edit
- Action: App\Http\Controllers\Api\Network\FirewallController@edit
- Middleware: web

## firewall/{id}

- Method: PUT
- Name: firewall.update
- Action: App\Http\Controllers\Api\Network\FirewallController@update
- Middleware: web

## dhcp/{id}/edit

- Method: GET|HEAD
- Name: dhcp.edit
- Action: App\Http\Controllers\Api\Network\DHCPController@edit
- Middleware: web

## dhcp/{id}

- Method: PUT
- Name: dhcp.update
- Action: App\Http\Controllers\Api\Network\DHCPController@update
- Middleware: web

## customer/login

- Method: GET|HEAD
- Name: customer.login
- Action: App\Http\Controllers\CustomerAuthController@showLoginForm
- Middleware: web

## customer/login

- Method: POST
- Name: customer.login.post
- Action: App\Http\Controllers\CustomerAuthController@login
- Middleware: web

## customer/logout

- Method: POST
- Name: customer.logout
- Action: App\Http\Controllers\CustomerAuthController@logout
- Middleware: web

## customer/invoices

- Method: GET|HEAD
- Name: customer.invoices
- Action: App\Http\Controllers\CustomerInvoiceController@index
- Middleware: web

## customer/invoices/{id}

- Method: GET|HEAD
- Name: customer.invoice.show
- Action: App\Http\Controllers\CustomerInvoiceController@show
- Middleware: web

## customer/tickets

- Method: GET|HEAD
- Name: customer.tickets
- Action: App\Http\Controllers\CustomerTicketController@index
- Middleware: web

## customer/tickets/create

- Method: GET|HEAD
- Name: customer.ticket.create
- Action: App\Http\Controllers\CustomerTicketController@create
- Middleware: web

## customer/tickets

- Method: POST
- Name: customer.ticket.store
- Action: App\Http\Controllers\CustomerTicketController@store
- Middleware: web

## customer/tickets/{id}

- Method: GET|HEAD
- Name: customer.ticket.show
- Action: App\Http\Controllers\CustomerTicketController@show
- Middleware: web

## customer/tickets/{id}/reply

- Method: POST
- Name: customer.ticket.reply
- Action: App\Http\Controllers\CustomerTicketController@reply
- Middleware: web

## customer/tickets/{id}/close

- Method: POST
- Name: customer.ticket.close
- Action: App\Http\Controllers\CustomerTicketController@close
- Middleware: web

## customer/profile

- Method: GET|HEAD
- Name: customer.profile
- Action: App\Http\Controllers\CustomerProfileController@show
- Middleware: web

## customer/profile

- Method: PUT
- Name: customer.profile.update
- Action: App\Http\Controllers\CustomerProfileController@update
- Middleware: web

## customer/profile/change-password

- Method: POST
- Name: customer.profile.change-password
- Action: App\Http\Controllers\CustomerProfileController@changePassword
- Middleware: web

## broadcasting/auth

- Method: GET|POST|HEAD
- Name: -
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