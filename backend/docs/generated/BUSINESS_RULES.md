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
- App\Services\SubscriptionRenewalService
- App\Services\NotificationService

**Methods**
- __construct(3 params) : mixed
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

## MikroTikAdvancedService

**Namespace**
App\Services\Network

**Dependencies**
- None

**Methods**
- connect(4 params) : bool
- getSimpleQueues(0 params) : array
- createSimpleQueue(5 params) : bool
- updateSimpleQueue(2 params) : bool
- deleteSimpleQueue(1 params) : bool
- disableSimpleQueue(1 params) : bool
- enableSimpleQueue(1 params) : bool
- getFirewallRules(0 params) : array
- createFirewallRule(1 params) : bool
- deleteFirewallRule(1 params) : bool
- getNATRules(0 params) : array
- getDHCPLeases(0 params) : array
- addDHCPLease(3 params) : bool
- deleteDHCPLease(1 params) : bool

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
- create(1 params) : App\Models\Notification
- createReminder(2 params) : App\Models\Notification
- billingFailed(1 params) : App\Models\Notification
- subscriptionRenewed(1 params) : App\Models\Notification

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

## ReportExecutionService

**Namespace**
App\Services\Reports

**Dependencies**
- App\Reports\Manager\ReportManager
- App\Reports\Export\ExportManager
- App\Repositories\Contracts\ReportRepositoryInterface
- App\Repositories\Contracts\ReportExportRepositoryInterface

**Methods**
- __construct(4 params) : mixed
- run(3 params) : App\Reports\DTO\ExportResult

---

## ReportExportService

**Namespace**
App\Services\Reports

**Dependencies**
- App\Contracts\Repositories\ReportExportRepositoryInterface

**Methods**
- __construct(1 params) : mixed
- paginate(0 params) : Illuminate\Contracts\Pagination\LengthAwarePaginator
- create(1 params) : App\Models\ReportExport
- find(1 params) : ?App\Models\ReportExport

---

## ReportService

**Namespace**
App\Services\Reports

**Dependencies**
- App\Contracts\Repositories\ReportRepositoryInterface

**Methods**
- __construct(1 params) : mixed
- paginate(0 params) : Illuminate\Contracts\Pagination\LengthAwarePaginator
- create(1 params) : App\Models\Report
- update(2 params) : App\Models\Report
- delete(1 params) : bool
- find(1 params) : ?App\Models\Report

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

## ScheduledReportService

**Namespace**
App\Services\Reports

**Dependencies**
- None

**Methods**
- paginate(0 params) : Illuminate\Contracts\Pagination\LengthAwarePaginator
- create(1 params) : App\Models\ScheduledReport
- update(2 params) : App\Models\ScheduledReport
- delete(1 params) : void
- activate(1 params) : App\Models\ScheduledReport
- deactivate(1 params) : App\Models\ScheduledReport
- updateLastRun(1 params) : App\Models\ScheduledReport
- updateNextRun(2 params) : App\Models\ScheduledReport

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

## TaskService

**Namespace**
App\Services\Task

**Dependencies**
- None

**Methods**
- paginate(0 params) : Illuminate\Contracts\Pagination\LengthAwarePaginator
- create(1 params) : App\Models\Task
- update(2 params) : App\Models\Task
- complete(1 params) : App\Models\Task
- cancel(1 params) : App\Models\Task
- reopen(1 params) : App\Models\Task
- start(1 params) : App\Models\Task
- delete(1 params) : void

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
