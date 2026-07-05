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

## MarkdownExporter

**Namespace**

```
App\Services\Documentation
```

**File**

```
/var/www/app/Services/Documentation/MarkdownExporter.php
```

**Constructor Dependencies**

- DocumentationDirectoryManager $directories

**Properties**

- $directories : App\Services\Documentation\Filesystem\DocumentationDirectoryManager

**Methods**

- export() : void

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

**Constructor Dependencies**

- MikrotikConnection $connection

**Properties**

- $connection : App\Services\Network\MikrotikConnection

**Methods**

- getPppoeUsers() : array
- createPppoe() : mixed
- findPppoe() : mixed
- deletePppoe() : bool
- enablePppoe() : bool
- disablePppoe() : bool
- getHotspotUsers() : array
- getActiveHotspotUsers() : array
- createHotspot() : mixed
- findHotspot() : mixed
- deleteHotspot() : bool
- enableHotspot() : bool
- disableHotspot() : bool
- getDhcpLeases() : array
- run() : array
- raw() : array

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

## SubscriptionRenewalService

**Namespace**

```
App\Services
```

**File**

```
/var/www/app/Services/SubscriptionRenewalService.php
```

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
- MikrotikServiceInterface $mikrotikService
- ActivateSubscriptionAction $activateAction
- SuspendSubscriptionAction $suspendAction
- ExpireSubscriptionAction $expireAction
- RenewSubscriptionAction $renewAction
- RestoreSubscriptionAction $restoreAction

**Properties**

- $subscriptionRepository : App\Contracts\Repositories\SubscriptionRepositoryInterface
- $mikrotikService : App\Contracts\MikrotikServiceInterface
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
- availablePppoeUsers() : array
- linkPppoe() : App\Models\Subscription

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
