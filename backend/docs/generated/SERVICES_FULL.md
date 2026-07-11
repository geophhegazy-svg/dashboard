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
App\Services\Activity
```

**File**

```
/var/www/app/Services/Activity/ActivityLogService.php
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
- NotificationService $notificationService

**Properties**

- $billingEngine : App\Services\Billing\BillingEngine
- $renewalService : App\Services\Subscription\SubscriptionRenewalService
- $notificationService : App\Services\Notification\NotificationService

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

**Constructor Dependencies**

- UsageService $usageService

**Properties**

- $usageService : App\Services\Usage\UsageService

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

- $invoiceNumberService : App\Services\Invoice\InvoiceNumberService

**Methods**

- generate() : App\Models\Invoice

---

## InvoiceNumberService

**Namespace**

```
App\Services\Invoice
```

**File**

```
/var/www/app/Services/Invoice/InvoiceNumberService.php
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

## JournalEntryNumberService

**Namespace**

```
App\Services\Finance
```

**File**

```
/var/www/app/Services/Finance/JournalEntryNumberService.php
```

**Methods**

- generate() : string

---

## JournalPostingService

**Namespace**

```
App\Services\Accounting
```

**File**

```
/var/www/app/Services/Accounting/JournalPostingService.php
```

**Constructor Dependencies**

- JournalValidationService $validationService
- ActivityLogService $activityLogService

**Properties**

- $validationService : App\Services\Accounting\JournalValidationService
- $activityLogService : App\Services\Activity\ActivityLogService

**Methods**

- post() : App\Models\JournalEntry

---

## JournalValidationService

**Namespace**

```
App\Services\Accounting
```

**File**

```
/var/www/app/Services/Accounting/JournalValidationService.php
```

**Methods**

- validate() : void

---

## JournalValidator

**Namespace**

```
App\Services\Finance\Accounting
```

**File**

```
/var/www/app/Services/Finance/Accounting/JournalValidator.php
```

**Methods**

- validate() : void

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

## MikroTikAdvancedService

**Namespace**

```
App\Services\Network
```

**File**

```
/var/www/app/Services/Network/MikroTikAdvancedService.php
```

**Properties**

- $client : mixed

**Methods**

- connect() : bool
- getSimpleQueues() : array
- createSimpleQueue() : bool
- updateSimpleQueue() : bool
- deleteSimpleQueue() : bool
- disableSimpleQueue() : bool
- enableSimpleQueue() : bool
- getFirewallRules() : array
- createFirewallRule() : bool
- deleteFirewallRule() : bool
- updateDHCPLease() : bool
- updateFirewallRule() : bool
- getNATRules() : array
- getDHCPLeases() : array
- addDHCPLease() : bool
- deleteDHCPLease() : bool

---

## MikroTikConnectionService

**Namespace**

```
App\Services\Network\Providers\MikroTik
```

**File**

```
/var/www/app/Services/Network/Providers/MikroTik/MikroTikConnectionService.php
```

**Properties**

- $client : ?RouterOS\Client

**Methods**

- connect() : bool
- client() : ?RouterOS\Client
- isConnected() : bool
- disconnect() : void
- ping() : bool

---

## MikroTikDhcpService

**Namespace**

```
App\Services\Network\Providers\MikroTik
```

**File**

```
/var/www/app/Services/Network/Providers/MikroTik/MikroTikDhcpService.php
```

**Constructor Dependencies**

- MikroTikQueryService $query

**Properties**

- $query : App\Services\Network\Providers\MikroTik\MikroTikQueryService

**Methods**

- getLeases() : array
- find() : ?array
- findByMac() : ?array
- create() : bool
- update() : bool
- delete() : bool
- makeStatic() : bool
- removeStatic() : bool
- search() : array
- statistics() : array
- activeClients() : array

---

## MikroTikFirewallService

**Namespace**

```
App\Services\Network\Providers\MikroTik
```

**File**

```
/var/www/app/Services/Network/Providers/MikroTik/MikroTikFirewallService.php
```

**Constructor Dependencies**

- MikroTikQueryService $query

**Properties**

- $query : App\Services\Network\Providers\MikroTik\MikroTikQueryService

**Methods**

- getRules() : array
- find() : ?array
- create() : bool
- update() : bool
- delete() : bool
- disable() : bool
- enable() : bool
- getNatRules() : array
- findNat() : ?array
- createNat() : bool
- updateNat() : bool
- deleteNat() : bool
- search() : array
- statistics() : array

---

## MikroTikHotspotService

**Namespace**

```
App\Services\Network\Providers\MikroTik
```

**File**

```
/var/www/app/Services/Network/Providers/MikroTik/MikroTikHotspotService.php
```

**Constructor Dependencies**

- MikroTikQueryService $query

**Properties**

- $query : App\Services\Network\Providers\MikroTik\MikroTikQueryService

**Methods**

- getUsers() : array
- findUser() : ?array
- getActiveSessions() : array
- getActiveSession() : ?array
- createUser() : bool
- disableUser() : bool
- enableUser() : bool
- deleteUser() : bool
- disconnectUser() : bool
- status() : array
- updateUser() : bool
- updateProfile() : bool
- updatePassword() : bool
- search() : array
- statistics() : array

---

## MikroTikMonitoringService

**Namespace**

```
App\Services\Network\Providers\MikroTik
```

**File**

```
/var/www/app/Services/Network/Providers/MikroTik/MikroTikMonitoringService.php
```

**Constructor Dependencies**

- MikroTikQueryService $query

**Properties**

- $query : App\Services\Network\Providers\MikroTik\MikroTikQueryService

**Methods**

- getSystemResource() : array
- getIdentity() : array
- getInterfaces() : array
- getInterfaceTraffic() : array
- ping() : bool
- healthCheck() : array
- summary() : array

---

## MikroTikPppoeService

**Namespace**

```
App\Services\Network\Providers\MikroTik
```

**File**

```
/var/www/app/Services/Network/Providers/MikroTik/MikroTikPppoeService.php
```

**Constructor Dependencies**

- MikroTikQueryService $query

**Properties**

- $query : App\Services\Network\Providers\MikroTik\MikroTikQueryService

**Methods**

- getAllUsers() : array
- getUser() : ?array
- createUser() : bool
- updateUser() : bool
- disableUser() : bool
- enableUser() : bool
- deleteUser() : bool
- getActiveSessions() : array
- getActiveSession() : ?array
- disconnectUser() : bool
- updateProfile() : bool
- updatePassword() : bool
- searchUsers() : array
- status() : array

---

## MikroTikProvider

**Namespace**

```
App\Services\Network\Providers\MikroTik
```

**File**

```
/var/www/app/Services/Network/Providers/MikroTik/MikroTikProvider.php
```

**Constructor Dependencies**

- MikroTikConnectionService $connection
- MikroTikPppoeService $pppoe
- MikroTikQueueService $queue
- MikroTikHotspotService $hotspot
- MikroTikFirewallService $firewall
- MikroTikDhcpService $dhcp
- MikroTikMonitoringService $monitoring

**Properties**

- $connection : App\Services\Network\Providers\MikroTik\MikroTikConnectionService
- $pppoe : App\Services\Network\Providers\MikroTik\MikroTikPppoeService
- $queue : App\Services\Network\Providers\MikroTik\MikroTikQueueService
- $hotspot : App\Services\Network\Providers\MikroTik\MikroTikHotspotService
- $firewall : App\Services\Network\Providers\MikroTik\MikroTikFirewallService
- $dhcp : App\Services\Network\Providers\MikroTik\MikroTikDhcpService
- $monitoring : App\Services\Network\Providers\MikroTik\MikroTikMonitoringService

**Methods**

- connect() : bool
- disconnect() : void
- isConnected() : bool
- name() : string
- capabilities() : array
- pppoe() : App\Services\Network\Providers\MikroTik\MikroTikPppoeService
- queue() : App\Services\Network\Providers\MikroTik\MikroTikQueueService
- hotspot() : App\Services\Network\Providers\MikroTik\MikroTikHotspotService
- firewall() : App\Services\Network\Providers\MikroTik\MikroTikFirewallService
- dhcp() : App\Services\Network\Providers\MikroTik\MikroTikDhcpService
- monitoring() : App\Services\Network\Providers\MikroTik\MikroTikMonitoringService

---

## MikroTikQueryService

**Namespace**

```
App\Services\Network\Providers\MikroTik
```

**File**

```
/var/www/app/Services/Network/Providers/MikroTik/MikroTikQueryService.php
```

**Constructor Dependencies**

- MikroTikConnectionService $connection

**Properties**

- $connection : App\Services\Network\Providers\MikroTik\MikroTikConnectionService

**Methods**

- execute() : array
- first() : ?array
- write() : bool

---

## MikroTikQueueService

**Namespace**

```
App\Services\Network\Providers\MikroTik
```

**File**

```
/var/www/app/Services/Network/Providers/MikroTik/MikroTikQueueService.php
```

**Constructor Dependencies**

- MikroTikQueryService $query

**Properties**

- $query : App\Services\Network\Providers\MikroTik\MikroTikQueryService

**Methods**

- getAll() : array
- find() : ?array
- create() : bool
- update() : bool
- delete() : bool
- disable() : bool
- enable() : bool
- getUsage() : array
- getUserQueue() : ?array
- updateSpeed() : bool
- resetCounters() : bool
- search() : array
- statistics() : array

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
- getQueueUsage() : array
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

## MikrotikServiceAdapter

**Namespace**

```
App\Services\Network
```

**File**

```
/var/www/app/Services/Network/MikrotikServiceAdapter.php
```

**Constructor Dependencies**

- MikroTikProvider $provider

**Properties**

- $provider : App\Services\Network\Providers\MikroTik\MikroTikProvider

**Methods**

- connect() : bool
- createUser() : bool
- disableUser() : bool
- enableUser() : bool
- deleteUser() : bool
- getAllUsers() : array
- getActiveSessions() : array
- updateUserQueue() : bool
- getQueueUsage() : array
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

## NetworkManager

**Namespace**

```
App\Services\Network
```

**File**

```
/var/www/app/Services/Network/NetworkManager.php
```

**Constructor Dependencies**

- NetworkProviderResolver $resolver

**Properties**

- $device : ?App\Models\NetworkDevice
- $provider : ?App\Contracts\Network\NetworkProviderInterface
- $resolver : App\Services\Network\NetworkProviderResolver

**Methods**

- connect() : bool
- disconnect() : void
- provider() : ?App\Contracts\Network\NetworkProviderInterface
- device() : ?App\Models\NetworkDevice
- connected() : bool
- providerName() : ?string
- capabilities() : array

---

## NetworkProviderResolver

**Namespace**

```
App\Services\Network
```

**File**

```
/var/www/app/Services/Network/NetworkProviderResolver.php
```

**Properties**

- $providers : array

**Methods**

- resolve() : App\Contracts\Network\NetworkProviderInterface
- resolveByName() : App\Contracts\Network\NetworkProviderInterface
- register() : void
- available() : array

---

## NotificationService

**Namespace**

```
App\Services\Notification
```

**File**

```
/var/www/app/Services/Notification/NotificationService.php
```

**Methods**

- create() : App\Models\Notification
- createReminder() : App\Models\Notification
- billingFailed() : App\Models\Notification
- subscriptionRenewed() : App\Models\Notification

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

## ReportExecutionService

**Namespace**

```
App\Services\Reports
```

**File**

```
/var/www/app/Services/Reports/ReportExecutionService.php
```

**Constructor Dependencies**

- ReportManager $reportManager
- ExportManager $exportManager
- ReportRepositoryInterface $reportRepository
- ReportExportRepositoryInterface $reportExportRepository

**Properties**

- $reportManager : App\Reports\Manager\ReportManager
- $exportManager : App\Reports\Export\ExportManager
- $reportRepository : App\Contracts\Repositories\ReportRepositoryInterface
- $reportExportRepository : App\Contracts\Repositories\ReportExportRepositoryInterface

**Methods**

- execute() : App\Reports\DTO\ExportResult

---

## ReportExportService

**Namespace**

```
App\Services\Reports
```

**File**

```
/var/www/app/Services/Reports/ReportExportService.php
```

**Constructor Dependencies**

- ReportExportRepositoryInterface $exports

**Properties**

- $exports : App\Contracts\Repositories\ReportExportRepositoryInterface

**Methods**

- paginate() : Illuminate\Contracts\Pagination\LengthAwarePaginator
- create() : App\Models\ReportExport
- find() : ?App\Models\ReportExport

---

## ReportService

**Namespace**

```
App\Services\Reports
```

**File**

```
/var/www/app/Services/Reports/ReportService.php
```

**Constructor Dependencies**

- ReportRepositoryInterface $reports

**Properties**

- $reports : App\Contracts\Repositories\ReportRepositoryInterface

**Methods**

- paginate() : Illuminate\Contracts\Pagination\LengthAwarePaginator
- create() : App\Models\Report
- update() : App\Models\Report
- delete() : bool
- find() : ?App\Models\Report

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

## RouterConnectionService

**Namespace**

```
App\Services\Network
```

**File**

```
/var/www/app/Services/Network/RouterConnectionService.php
```

**Constructor Dependencies**

- MikroTikAdvancedService $mikrotik

**Properties**

- $mikrotik : App\Services\Network\MikroTikAdvancedService

**Methods**

- connectByDeviceId() : App\Models\NetworkDevice
- connect() : App\Models\NetworkDevice
- service() : App\Services\Network\MikroTikAdvancedService

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

## ScheduledReportService

**Namespace**

```
App\Services\Reports
```

**File**

```
/var/www/app/Services/Reports/ScheduledReportService.php
```

**Methods**

- paginate() : Illuminate\Contracts\Pagination\LengthAwarePaginator
- create() : App\Models\ScheduledReport
- update() : App\Models\ScheduledReport
- delete() : void
- activate() : App\Models\ScheduledReport
- deactivate() : App\Models\ScheduledReport
- updateLastRun() : App\Models\ScheduledReport
- updateNextRun() : App\Models\ScheduledReport

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
App\Services\Subscription
```

**File**

```
/var/www/app/Services/Subscription/SubscriptionRenewalService.php
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

## TaskService

**Namespace**

```
App\Services\Task
```

**File**

```
/var/www/app/Services/Task/TaskService.php
```

**Methods**

- paginate() : Illuminate\Contracts\Pagination\LengthAwarePaginator
- create() : App\Models\Task
- update() : App\Models\Task
- complete() : App\Models\Task
- cancel() : App\Models\Task
- reopen() : App\Models\Task
- start() : App\Models\Task
- delete() : void

---

## TelegramNotificationService

**Namespace**

```
App\Services\Notification
```

**File**

```
/var/www/app/Services/Notification/TelegramNotificationService.php
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

## UsageService

**Namespace**

```
App\Services\Usage
```

**File**

```
/var/www/app/Services/Usage/UsageService.php
```

**Methods**

- getUsageForCustomer() : array

---

## WalletService

**Namespace**

```
App\Services\Wallet
```

**File**

```
/var/www/app/Services/Wallet/WalletService.php
```

**Methods**

- deposit() : void
- deduct() : void
