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

- getAll() : array
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
- pppoe() : App\Contracts\Network\Services\PppoeServiceInterface
- queue() : App\Contracts\Network\Services\QueueServiceInterface
- hotspot() : App\Contracts\Network\Services\HotspotServiceInterface
- firewall() : App\Contracts\Network\Services\FirewallServiceInterface
- dhcp() : App\Contracts\Network\Services\DhcpServiceInterface
- monitoring() : App\Contracts\Network\Services\MonitoringServiceInterface

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

- NetworkManager $networkManager

**Properties**

- $networkManager : App\Services\Network\NetworkManager

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

## NetworkDeviceConnectionManager

**Namespace**

```
App\Services\Network
```

**File**

```
/var/www/app/Services/Network/NetworkDeviceConnectionManager.php
```

**Constructor Dependencies**

- MikroTikConnectionService $connectionService

**Properties**

- $connectionService : App\Services\Network\Providers\MikroTik\MikroTikConnectionService

**Methods**

- connectById() : App\Services\Network\Providers\MikroTik\MikroTikConnectionService
- connect() : App\Services\Network\Providers\MikroTik\MikroTikConnectionService

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
