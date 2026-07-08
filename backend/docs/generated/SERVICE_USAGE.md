# Service Usage

## AIContextGenerator

**Class**

```
App\Services\Documentation\Knowledge\AIContextGenerator
```

**Public Methods**

- __construct
- filename
- generate

## AbstractHandoverSection

**Class**

```
App\Services\Documentation\Handover\AbstractHandoverSection
```

**Public Methods**

- generate

## ActionDocumentationGenerator

**Class**

```
App\Services\Documentation\Generators\ActionDocumentationGenerator
```

**Public Methods**

- __construct
- filename
- generate
- priority

## ActivityLogService

**Class**

```
App\Services\ActivityLogService
```

**Public Methods**

- log

## AiStartPromptExport

**Class**

```
App\Services\Documentation\Exports\AiStartPromptExport
```

**Public Methods**

- content
- filename
- isAiExport

## ApiDocumentationGenerator

**Class**

```
App\Services\Documentation\Generators\ApiDocumentationGenerator
```

**Public Methods**

- filename
- generate
- priority

## ArchitectureGenerator

**Class**

```
App\Services\Documentation\Knowledge\ArchitectureGenerator
```

**Public Methods**

- filename
- generate

## AutomaticBillingService

**Class**

```
App\Services\Billing\AutomaticBillingService
```

**Public Methods**

- __construct
- processSubscription
- run

## BillingCycleService

**Class**

```
App\Services\Billing\BillingCycleService
```

**Public Methods**

- calculateGraceDate
- calculateNextBillingDate
- isDue
- isExpired

## BillingEngine

**Class**

```
App\Services\Billing\BillingEngine
```

**Public Methods**

- nextDueDate
- status

## BusinessRuleExtractor

**Class**

```
App\Services\Documentation\Knowledge\BusinessRuleExtractor
```

**Public Methods**

- extract

## BusinessRulesGenerator

**Class**

```
App\Services\Documentation\Knowledge\BusinessRulesGenerator
```

**Public Methods**

- __construct
- filename
- generate

## ClassDocumentationGenerator

**Class**

```
App\Services\Documentation\Generators\ClassDocumentationGenerator
```

**Public Methods**

- __construct
- generate

## ClassFinder

**Class**

```
App\Services\Documentation\Scanner\ClassFinder
```

**Public Methods**

- find
- findMany

## ClassReflector

**Class**

```
App\Services\Documentation\Reflection\ClassReflector
```

**Public Methods**

- methods

## ConstructorReflector

**Class**

```
App\Services\Documentation\Reflection\ConstructorReflector
```

**Public Methods**

- reflect

## ControllerDocumentationGenerator

**Class**

```
App\Services\Documentation\Generators\ControllerDocumentationGenerator
```

**Public Methods**

- __construct
- filename
- generate
- priority

## ControllersKnowledgeGenerator

**Class**

```
App\Services\Documentation\Knowledge\ControllersKnowledgeGenerator
```

**Public Methods**

- __construct
- filename
- generate

## CustomerDashboardService

**Class**

```
App\Services\Dashboard\CustomerDashboardService
```

**Public Methods**

- getDashboardData

## CustomerService

**Class**

```
App\Services\Customer\CustomerService
```

**Public Methods**

- create
- delete
- update

## DashboardService

**Class**

```
App\Services\Dashboard\DashboardService
```

**Public Methods**

- getDashboardData

## DatabaseExtractor

**Class**

```
App\Services\Documentation\Knowledge\DatabaseExtractor
```

**Public Methods**

- extract

## DatabaseKnowledgeGenerator

**Class**

```
App\Services\Documentation\Knowledge\DatabaseKnowledgeGenerator
```

**Public Methods**

- __construct
- filename
- generate

## DependencyGraphExtractor

**Class**

```
App\Services\Documentation\Knowledge\DependencyGraphExtractor
```

**Public Methods**

- __construct
- extract

## DependencyGraphKnowledgeGenerator

**Class**

```
App\Services\Documentation\Knowledge\DependencyGraphKnowledgeGenerator
```

**Public Methods**

- __construct
- filename
- generate

## DocumentationDirectoryManager

**Class**

```
App\Services\Documentation\Filesystem\DocumentationDirectoryManager
```

**Public Methods**

- ensureExists
- file
- generatedPath

## DocumentationGeneratorManager

**Class**

```
App\Services\Documentation\Manager\DocumentationGeneratorManager
```

**Public Methods**

- __construct
- generate

## DocumentationGeneratorRegistry

**Class**

```
App\Services\Documentation\Registry\DocumentationGeneratorRegistry
```

**Public Methods**

- all
- register

## DocumentationIndexGenerator

**Class**

```
App\Services\Documentation\Index\DocumentationIndexGenerator
```

**Public Methods**

- generate

## DocumentationWriter

**Class**

```
App\Services\Documentation\Writer\DocumentationWriter
```

**Public Methods**

- __construct
- delete
- exists
- read
- write

## ExecutiveSummarySection

**Class**

```
App\Services\Documentation\Handover\ExecutiveSummarySection
```

**Public Methods**

- generate

## ExportRegistry

**Class**

```
App\Services\Documentation\Exports\ExportRegistry
```

**Public Methods**

- __construct
- exports
- register

## FileScanner

**Class**

```
App\Services\Documentation\Scanner\FileScanner
```

**Public Methods**

- scan

## FinanceService

**Class**

```
App\Services\Finance\FinanceService
```

**Public Methods**

- record

## HandoverDocumentGenerator

**Class**

```
App\Services\Documentation\Knowledge\HandoverDocumentGenerator
```

**Public Methods**

- filename
- generate

## InvoiceGenerator

**Class**

```
App\Services\Billing\InvoiceGenerator
```

**Public Methods**

- __construct
- generate

## InvoiceNumberService

**Class**

```
App\Services\InvoiceNumberService
```

**Public Methods**

- generate

## InvoiceService

**Class**

```
App\Services\Invoice\InvoiceService
```

**Public Methods**

- create
- delete
- update

## KnowledgeExporter

**Class**

```
App\Services\Documentation\Knowledge\KnowledgeExporter
```

**Public Methods**

- __construct
- export

## KnowledgeGeneratorManager

**Class**

```
App\Services\Documentation\Knowledge\KnowledgeGeneratorManager
```

**Public Methods**

- __construct
- generate

## KnowledgeGeneratorRegistry

**Class**

```
App\Services\Documentation\Knowledge\KnowledgeGeneratorRegistry
```

**Public Methods**

- __construct
- generators
- register

## KnowledgeIndexGenerator

**Class**

```
App\Services\Documentation\Knowledge\KnowledgeIndexGenerator
```

**Public Methods**

- filename
- generate

## MarkdownBuilder

**Class**

```
App\Services\Documentation\Builder\MarkdownBuilder
```

**Public Methods**

- bullet
- code
- h2
- h3
- newline
- numbered
- render
- separator
- table
- text
- title

## MetadataExtractor

**Class**

```
App\Services\Documentation\Scanner\MetadataExtractor
```

**Public Methods**

- extract

## MethodReflector

**Class**

```
App\Services\Documentation\Reflection\MethodReflector
```

**Public Methods**

- reflect

## MigrationExtractor

**Class**

```
App\Services\Documentation\Knowledge\MigrationExtractor
```

**Public Methods**

- extract

## MigrationsKnowledgeGenerator

**Class**

```
App\Services\Documentation\Knowledge\MigrationsKnowledgeGenerator
```

**Public Methods**

- __construct
- filename
- generate

## MikrotikConnection

**Class**

```
App\Services\Network\MikrotikConnection
```

**Public Methods**

- client
- execute

## MikrotikService

**Class**

```
App\Services\Network\MikrotikService
```

**Public Methods**

- connect
- createHotspotUser
- createUser
- deleteUser
- disableHotspotUser
- disableUser
- disconnectUser
- enableHotspotUser
- enableUser
- getActiveSessions
- getAllUsers
- getDeviceStats
- getHotspotActiveSessions
- getHotspotUsers
- ping
- updateDeviceStatus
- updateUserQueue

## ModelDocumentationGenerator

**Class**

```
App\Services\Documentation\Generators\ModelDocumentationGenerator
```

**Public Methods**

- __construct
- filename
- generate
- priority

## ModelRelationExtractor

**Class**

```
App\Services\Documentation\Knowledge\ModelRelationExtractor
```

**Public Methods**

- __construct
- extract

## ModelRelationsKnowledgeGenerator

**Class**

```
App\Services\Documentation\Knowledge\ModelRelationsKnowledgeGenerator
```

**Public Methods**

- __construct
- filename
- generate

## ModelsKnowledgeGenerator

**Class**

```
App\Services\Documentation\Knowledge\ModelsKnowledgeGenerator
```

**Public Methods**

- __construct
- filename
- generate

## ModelsSection

**Class**

```
App\Services\Documentation\Sections\ModelsSection
```

**Public Methods**

- generate

## ModuleExtractor

**Class**

```
App\Services\Documentation\Knowledge\ModuleExtractor
```

**Public Methods**

- __construct
- extract

## ModulesKnowledgeGenerator

**Class**

```
App\Services\Documentation\Knowledge\ModulesKnowledgeGenerator
```

**Public Methods**

- __construct
- filename
- generate

## NotificationService

**Class**

```
App\Services\NotificationService
```

**Public Methods**

- billingFailed
- create
- createReminder
- subscriptionRenewed

## PackageService

**Class**

```
App\Services\Package\PackageService
```

**Public Methods**

- create
- delete
- paginate
- update

## PaymentService

**Class**

```
App\Services\Payment\PaymentService
```

**Public Methods**

- create

## ProjectBibleService

**Class**

```
App\Services\Documentation\ProjectBibleService
```

**Public Methods**

- generate

## ProjectScanner

**Class**

```
App\Services\Documentation\Scanner\ProjectScanner
```

**Public Methods**

- __construct
- actions
- all
- controllers
- models
- repositories
- services

## ProjectStateExtractor

**Class**

```
App\Services\Documentation\Knowledge\ProjectStateExtractor
```

**Public Methods**

- __construct
- extract

## ProjectStateKnowledgeGenerator

**Class**

```
App\Services\Documentation\Knowledge\ProjectStateKnowledgeGenerator
```

**Public Methods**

- __construct
- filename
- generate

## ProjectSummaryGenerator

**Class**

```
App\Services\Documentation\Knowledge\ProjectSummaryGenerator
```

**Public Methods**

- __construct
- filename
- generate

## PropertyReflector

**Class**

```
App\Services\Documentation\Reflection\PropertyReflector
```

**Public Methods**

- reflect

## ReflectionEngine

**Class**

```
App\Services\Documentation\Reflection\ReflectionEngine
```

**Public Methods**

- __construct
- reflect

## RepositoryDocumentationGenerator

**Class**

```
App\Services\Documentation\Generators\RepositoryDocumentationGenerator
```

**Public Methods**

- __construct
- filename
- generate
- priority

## RouteExtractor

**Class**

```
App\Services\Documentation\Knowledge\RouteExtractor
```

**Public Methods**

- extract

## RoutesKnowledgeGenerator

**Class**

```
App\Services\Documentation\Knowledge\RoutesKnowledgeGenerator
```

**Public Methods**

- __construct
- filename
- generate

## ServiceDocumentationGenerator

**Class**

```
App\Services\Documentation\Generators\ServiceDocumentationGenerator
```

**Public Methods**

- __construct
- filename
- generate
- priority

## ServiceUsageExtractor

**Class**

```
App\Services\Documentation\Knowledge\ServiceUsageExtractor
```

**Public Methods**

- __construct
- extract

## ServiceUsageKnowledgeGenerator

**Class**

```
App\Services\Documentation\Knowledge\ServiceUsageKnowledgeGenerator
```

**Public Methods**

- __construct
- filename
- generate

## ServicesKnowledgeGenerator

**Class**

```
App\Services\Documentation\Knowledge\ServicesKnowledgeGenerator
```

**Public Methods**

- __construct
- filename
- generate

## ServicesSection

**Class**

```
App\Services\Documentation\Sections\ServicesSection
```

**Public Methods**

- generate

## StatisticsGenerator

**Class**

```
App\Services\Documentation\Knowledge\StatisticsGenerator
```

**Public Methods**

- __construct
- filename
- generate

## SubscriptionActivationService

**Class**

```
App\Services\Subscription\SubscriptionActivationService
```

**Public Methods**

- __construct
- activate

## SubscriptionActivityService

**Class**

```
App\Services\Activity\SubscriptionActivityService
```

**Public Methods**

- log

## SubscriptionExpirationService

**Class**

```
App\Services\Subscription\SubscriptionExpirationService
```

**Public Methods**

- __construct
- expire

## SubscriptionLifecycleService

**Class**

```
App\Services\Subscription\SubscriptionLifecycleService
```

**Public Methods**

- __construct
- activate
- expire
- renew
- restore
- suspend

## SubscriptionRenewalService

**Class**

```
App\Services\SubscriptionRenewalService
```

**Public Methods**

- __construct
- renewHotspot
- renewPppoe

## SubscriptionService

**Class**

```
App\Services\Subscription\SubscriptionService
```

**Public Methods**

- __construct
- activate
- autoExpireSubscriptions
- cancelSubscription
- createSubscription
- expire
- getActiveSubscriptions
- getAllSubscriptions
- getCustomerSubscriptions
- getExpiredSubscriptions
- getExpiringSubscriptions
- getSubscriptionById
- getSubscriptionStats
- renew
- renewSubscription
- restore
- searchSubscriptions
- suspend
- updateSubscription

## SubscriptionSuspensionService

**Class**

```
App\Services\Subscription\SubscriptionSuspensionService
```

**Public Methods**

- __construct
- suspend

## TelegramNotificationService

**Class**

```
App\Services\TelegramNotificationService
```

**Public Methods**

- __construct
- sendDeviceAlert
- sendMessage

## TestCoverageExtractor

**Class**

```
App\Services\Documentation\Knowledge\TestCoverageExtractor
```

**Public Methods**

- extract

## TicketService

**Class**

```
App\Services\Ticket\TicketService
```

**Public Methods**

- adminDashboardStats
- assign
- changeStatus
- closeByCustomer
- createFromAdmin
- createFromCustomer
- customerDashboardStats
- delete
- replyAsCustomer
- replyAsStaff
- updateFromAdmin

## TodoGenerator

**Class**

```
App\Services\Documentation\Knowledge\TodoGenerator
```

**Public Methods**

- extract

## TodoKnowledgeGenerator

**Class**

```
App\Services\Documentation\Knowledge\TodoKnowledgeGenerator
```

**Public Methods**

- __construct
- filename
- generate

## WalletService

**Class**

```
App\Services\WalletService
```

**Public Methods**

- deduct
- deposit
