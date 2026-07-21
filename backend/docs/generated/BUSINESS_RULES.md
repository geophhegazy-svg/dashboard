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

## AccountResolverService

**Namespace**
App\Services\Accounting

**Dependencies**
- None

**Methods**
- assets(1 params) : App\Models\Account
- cash(1 params) : App\Models\Account
- accountsReceivable(1 params) : App\Models\Account
- liabilities(1 params) : App\Models\Account
- customerWalletLiability(1 params) : App\Models\Account
- equity(1 params) : App\Models\Account
- ownerEquity(1 params) : App\Models\Account
- revenue(1 params) : App\Models\Account
- subscriptionRevenue(1 params) : App\Models\Account
- expenses(1 params) : App\Models\Account
- networkExpenses(1 params) : App\Models\Account

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

## ChartOfAccountsService

**Namespace**
App\Services\Accounting

**Dependencies**
- None

**Methods**
- createDefaultAccounts(1 params) : void

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
- App\Services\Usage\UsageService

**Methods**
- __construct(1 params) : mixed
- getDashboardData(1 params) : array

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

## JournalEntryNumberService

**Namespace**
App\Services\Finance

**Dependencies**
- None

**Methods**
- generate(0 params) : string

---

## JournalPostingService

**Namespace**
App\Services\Accounting

**Dependencies**
- App\Services\Accounting\JournalValidationService
- App\Modules\Activity\Application\Services\ActivityLogService

**Methods**
- __construct(2 params) : mixed
- post(1 params) : App\Models\JournalEntry

---

## JournalValidationService

**Namespace**
App\Services\Accounting

**Dependencies**
- None

**Methods**
- validate(1 params) : void

---

## JournalValidator

**Namespace**
App\Services\Finance\Accounting

**Dependencies**
- None

**Methods**
- validate(1 params) : void

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

## MikroTikConnectionService

**Namespace**
App\Services\Network\Providers\MikroTik

**Dependencies**
- None

**Methods**
- connect(4 params) : bool
- client(0 params) : ?RouterOS\Client
- isConnected(0 params) : bool
- disconnect(0 params) : void
- ping(0 params) : bool

---

## MikroTikDhcpService

**Namespace**
App\Services\Network\Providers\MikroTik

**Dependencies**
- App\Services\Network\Providers\MikroTik\MikroTikQueryService

**Methods**
- __construct(1 params) : mixed
- getAll(0 params) : array
- find(1 params) : ?array
- findByMac(1 params) : ?array
- create(4 params) : bool
- update(2 params) : bool
- delete(1 params) : bool
- makeStatic(1 params) : bool
- removeStatic(1 params) : bool
- search(1 params) : array
- statistics(0 params) : array
- activeClients(0 params) : array

---

## MikroTikFirewallService

**Namespace**
App\Services\Network\Providers\MikroTik

**Dependencies**
- App\Services\Network\Providers\MikroTik\MikroTikQueryService

**Methods**
- __construct(1 params) : mixed
- getRules(0 params) : array
- find(1 params) : ?array
- create(1 params) : bool
- update(2 params) : bool
- delete(1 params) : bool
- disable(1 params) : bool
- enable(1 params) : bool
- getNatRules(0 params) : array
- findNat(1 params) : ?array
- createNat(1 params) : bool
- updateNat(2 params) : bool
- deleteNat(1 params) : bool
- search(1 params) : array
- statistics(0 params) : array

---

## MikroTikHotspotService

**Namespace**
App\Services\Network\Providers\MikroTik

**Dependencies**
- App\Services\Network\Providers\MikroTik\MikroTikQueryService

**Methods**
- __construct(1 params) : mixed
- getUsers(0 params) : array
- findUser(1 params) : ?array
- getActiveSessions(0 params) : array
- getActiveSession(1 params) : ?array
- createUser(4 params) : bool
- disableUser(1 params) : bool
- enableUser(1 params) : bool
- deleteUser(1 params) : bool
- disconnectUser(1 params) : bool
- status(1 params) : array
- updateUser(2 params) : bool
- updateProfile(2 params) : bool
- updatePassword(2 params) : bool
- search(1 params) : array
- statistics(0 params) : array

---

## MikroTikMonitoringService

**Namespace**
App\Services\Network\Providers\MikroTik

**Dependencies**
- App\Services\Network\Providers\MikroTik\MikroTikQueryService

**Methods**
- __construct(1 params) : mixed
- getSystemResource(0 params) : array
- getIdentity(0 params) : array
- getInterfaces(0 params) : array
- getInterfaceTraffic(0 params) : array
- ping(2 params) : bool
- healthCheck(0 params) : array
- summary(0 params) : array

---

## MikroTikPppoeService

**Namespace**
App\Services\Network\Providers\MikroTik

**Dependencies**
- App\Services\Network\Providers\MikroTik\MikroTikQueryService

**Methods**
- __construct(1 params) : mixed
- getAllUsers(0 params) : array
- getUser(1 params) : ?array
- createUser(4 params) : bool
- updateUser(2 params) : bool
- disableUser(1 params) : bool
- enableUser(1 params) : bool
- deleteUser(1 params) : bool
- getActiveSessions(0 params) : array
- getActiveSession(1 params) : ?array
- disconnectUser(1 params) : bool
- updateProfile(2 params) : bool
- updatePassword(2 params) : bool
- searchUsers(1 params) : array
- status(1 params) : array

---

## MikroTikProvider

**Namespace**
App\Services\Network\Providers\MikroTik

**Dependencies**
- App\Services\Network\Providers\MikroTik\MikroTikConnectionService
- App\Services\Network\Providers\MikroTik\MikroTikPppoeService
- App\Services\Network\Providers\MikroTik\MikroTikQueueService
- App\Services\Network\Providers\MikroTik\MikroTikHotspotService
- App\Services\Network\Providers\MikroTik\MikroTikFirewallService
- App\Services\Network\Providers\MikroTik\MikroTikDhcpService
- App\Services\Network\Providers\MikroTik\MikroTikMonitoringService

**Methods**
- __construct(7 params) : mixed
- connect(4 params) : bool
- disconnect(0 params) : void
- isConnected(0 params) : bool
- name(0 params) : string
- capabilities(0 params) : array
- pppoe(0 params) : App\Contracts\Network\Services\PppoeServiceInterface
- queue(0 params) : App\Contracts\Network\Services\QueueServiceInterface
- hotspot(0 params) : App\Contracts\Network\Services\HotspotServiceInterface
- firewall(0 params) : App\Contracts\Network\Services\FirewallServiceInterface
- dhcp(0 params) : App\Contracts\Network\Services\DhcpServiceInterface
- monitoring(0 params) : App\Contracts\Network\Services\MonitoringServiceInterface

---

## MikroTikQueryService

**Namespace**
App\Services\Network\Providers\MikroTik

**Dependencies**
- App\Services\Network\Providers\MikroTik\MikroTikConnectionService

**Methods**
- __construct(1 params) : mixed
- execute(1 params) : array
- first(1 params) : ?array
- write(1 params) : bool

---

## MikroTikQueueService

**Namespace**
App\Services\Network\Providers\MikroTik

**Dependencies**
- App\Services\Network\Providers\MikroTik\MikroTikQueryService

**Methods**
- __construct(1 params) : mixed
- getAll(0 params) : array
- find(1 params) : ?array
- create(6 params) : bool
- update(2 params) : bool
- delete(1 params) : bool
- disable(1 params) : bool
- enable(1 params) : bool
- getUsage(0 params) : array
- getUserQueue(1 params) : ?array
- updateSpeed(3 params) : bool
- resetCounters(1 params) : bool
- search(1 params) : array
- statistics(1 params) : array

---

## MikrotikServiceAdapter

**Namespace**
App\Services\Network

**Dependencies**
- App\Services\Network\NetworkManager

**Methods**
- __construct(1 params) : mixed
- connect(4 params) : bool
- createUser(4 params) : bool
- disableUser(1 params) : bool
- enableUser(1 params) : bool
- deleteUser(1 params) : bool
- getAllUsers(0 params) : array
- getActiveSessions(0 params) : array
- updateUserQueue(3 params) : bool
- getQueueUsage(0 params) : array
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

## NetworkDeviceConnectionManager

**Namespace**
App\Services\Network

**Dependencies**
- App\Services\Network\Providers\MikroTik\MikroTikConnectionService

**Methods**
- __construct(1 params) : mixed
- connectById(1 params) : App\Services\Network\Providers\MikroTik\MikroTikConnectionService
- connect(1 params) : App\Services\Network\Providers\MikroTik\MikroTikConnectionService

---

## NetworkManager

**Namespace**
App\Services\Network

**Dependencies**
- App\Services\Network\NetworkProviderResolver

**Methods**
- __construct(1 params) : mixed
- connect(1 params) : bool
- disconnect(0 params) : void
- provider(0 params) : ?App\Contracts\Network\NetworkProviderInterface
- device(0 params) : ?App\Models\NetworkDevice
- connected(0 params) : bool
- providerName(0 params) : ?string
- capabilities(0 params) : array

---

## NetworkProviderResolver

**Namespace**
App\Services\Network

**Dependencies**
- None

**Methods**
- resolve(1 params) : App\Contracts\Network\NetworkProviderInterface
- resolveByName(1 params) : App\Contracts\Network\NetworkProviderInterface
- register(2 params) : void
- available(0 params) : array

---

## NotificationService

**Namespace**
App\Services\Notification

**Dependencies**
- None

**Methods**
- create(1 params) : App\Models\Notification
- createReminder(2 params) : App\Models\Notification
- billingFailed(1 params) : App\Models\Notification
- subscriptionRenewed(1 params) : App\Models\Notification

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

## SubscriptionActivityService

**Namespace**
App\Services\Activity

**Dependencies**
- None

**Methods**
- log(4 params) : App\Models\ActivityLog

---

## TelegramNotificationService

**Namespace**
App\Services\Notification

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
