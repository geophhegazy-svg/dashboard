# Models

---

## Account

**Namespace**

```
App\Models
```

**File**

```
/var/www/app/Models/Account.php
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

## JournalEntry

**Namespace**

```
App\Models
```

**File**

```
/var/www/app/Models/JournalEntry.php
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
- factory()

---

## JournalEntryLine

**Namespace**

```
App\Models
```

**File**

```
/var/www/app/Models/JournalEntryLine.php
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

## Report

**Namespace**

```
App\Models
```

**File**

```
/var/www/app/Models/Report.php
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

---

## ReportExport

**Namespace**

```
App\Models
```

**File**

```
/var/www/app/Models/ReportExport.php
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

---

## ScheduledReport

**Namespace**

```
App\Models
```

**File**

```
/var/www/app/Models/ScheduledReport.php
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

- user()
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

## Task

**Namespace**

```
App\Models
```

**File**

```
/var/www/app/Models/Task.php
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

## UsageSnapshot

**Namespace**

```
App\Models
```

**File**

```
/var/www/app/Models/UsageSnapshot.php
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
