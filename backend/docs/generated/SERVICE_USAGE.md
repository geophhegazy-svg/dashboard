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

## AccountResolverService

**Class**

```
App\Services\Accounting\AccountResolverService
```

**Public Methods**

- accountsReceivable
- assets
- cash
- customerWalletLiability
- equity
- expenses
- liabilities
- networkExpenses
- ownerEquity
- revenue
- subscriptionRevenue

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

## ChartOfAccountsService

**Class**

```
App\Services\Accounting\ChartOfAccountsService
```

**Public Methods**

- createDefaultAccounts

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

- __construct
- getDashboardData

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

## JournalEntryNumberService

**Class**

```
App\Services\Finance\JournalEntryNumberService
```

**Public Methods**

- generate

## JournalPostingService

**Class**

```
App\Services\Accounting\JournalPostingService
```

**Public Methods**

- __construct
- post

## JournalValidationService

**Class**

```
App\Services\Accounting\JournalValidationService
```

**Public Methods**

- validate

## JournalValidator

**Class**

```
App\Services\Finance\Accounting\JournalValidator
```

**Public Methods**

- validate

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

## MikroTikConnectionService

**Class**

```
App\Services\Network\Providers\MikroTik\MikroTikConnectionService
```

**Public Methods**

- client
- connect
- disconnect
- isConnected
- ping

## MikroTikDhcpService

**Class**

```
App\Services\Network\Providers\MikroTik\MikroTikDhcpService
```

**Public Methods**

- __construct
- activeClients
- create
- delete
- find
- findByMac
- getAll
- makeStatic
- removeStatic
- search
- statistics
- update

## MikroTikFirewallService

**Class**

```
App\Services\Network\Providers\MikroTik\MikroTikFirewallService
```

**Public Methods**

- __construct
- create
- createNat
- delete
- deleteNat
- disable
- enable
- find
- findNat
- getNatRules
- getRules
- search
- statistics
- update
- updateNat

## MikroTikHotspotService

**Class**

```
App\Services\Network\Providers\MikroTik\MikroTikHotspotService
```

**Public Methods**

- __construct
- createUser
- deleteUser
- disableUser
- disconnectUser
- enableUser
- findUser
- getActiveSession
- getActiveSessions
- getUsers
- search
- statistics
- status
- updatePassword
- updateProfile
- updateUser

## MikroTikMonitoringService

**Class**

```
App\Services\Network\Providers\MikroTik\MikroTikMonitoringService
```

**Public Methods**

- __construct
- getIdentity
- getInterfaceTraffic
- getInterfaces
- getSystemResource
- healthCheck
- ping
- summary

## MikroTikPppoeService

**Class**

```
App\Services\Network\Providers\MikroTik\MikroTikPppoeService
```

**Public Methods**

- __construct
- createUser
- deleteUser
- disableUser
- disconnectUser
- enableUser
- getActiveSession
- getActiveSessions
- getAllUsers
- getUser
- searchUsers
- status
- updatePassword
- updateProfile
- updateUser

## MikroTikProvider

**Class**

```
App\Services\Network\Providers\MikroTik\MikroTikProvider
```

**Public Methods**

- __construct
- capabilities
- connect
- dhcp
- disconnect
- firewall
- hotspot
- isConnected
- monitoring
- name
- pppoe
- queue

## MikroTikQueryService

**Class**

```
App\Services\Network\Providers\MikroTik\MikroTikQueryService
```

**Public Methods**

- __construct
- execute
- first
- write

## MikroTikQueueService

**Class**

```
App\Services\Network\Providers\MikroTik\MikroTikQueueService
```

**Public Methods**

- __construct
- create
- delete
- disable
- enable
- find
- getAll
- getUsage
- getUserQueue
- resetCounters
- search
- statistics
- update
- updateSpeed

## MikrotikServiceAdapter

**Class**

```
App\Services\Network\MikrotikServiceAdapter
```

**Public Methods**

- __construct
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
- getQueueUsage
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

## NetworkDeviceConnectionManager

**Class**

```
App\Services\Network\NetworkDeviceConnectionManager
```

**Public Methods**

- __construct
- connect
- connectById

## NetworkManager

**Class**

```
App\Services\Network\NetworkManager
```

**Public Methods**

- __construct
- capabilities
- connect
- connected
- device
- disconnect
- provider
- providerName

## NetworkProviderResolver

**Class**

```
App\Services\Network\NetworkProviderResolver
```

**Public Methods**

- available
- register
- resolve
- resolveByName

## NotificationService

**Class**

```
App\Services\Notification\NotificationService
```

**Public Methods**

- billingFailed
- create
- createReminder
- subscriptionRenewed

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

## SubscriptionActivityService

**Class**

```
App\Services\Activity\SubscriptionActivityService
```

**Public Methods**

- log

## TelegramNotificationService

**Class**

```
App\Services\Notification\TelegramNotificationService
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
