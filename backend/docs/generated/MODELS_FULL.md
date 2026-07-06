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
- canExpire()
- canRestore()
- isSuspended()
- isExpired()
- isGrace()
- isPending()
- isDraft()
- isClosed()
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
