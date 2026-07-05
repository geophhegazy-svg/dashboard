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
- App\Services\Subscription\SubscriptionRenewalService
- App\Services\InvoiceService
- App\Services\NotificationService

**Methods**
- __construct(4 params) : mixed
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

## FileScanner

**Namespace**
App\Services\Documentation\Scanner

**Dependencies**
- None

**Methods**
- scan(1 params) : array

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
- None

**Methods**
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
- None

**Methods**
- generators(0 params) : array

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
- App\Services\Network\MikrotikConnection

**Methods**
- __construct(1 params) : mixed
- getPppoeUsers(0 params) : array
- createPppoe(3 params) : mixed
- findPppoe(1 params) : mixed
- deletePppoe(1 params) : bool
- enablePppoe(1 params) : bool
- disablePppoe(1 params) : bool
- getHotspotUsers(0 params) : array
- getActiveHotspotUsers(0 params) : array
- createHotspot(3 params) : mixed
- findHotspot(1 params) : mixed
- deleteHotspot(1 params) : bool
- enableHotspot(1 params) : bool
- disableHotspot(1 params) : bool
- getDhcpLeases(0 params) : array
- run(1 params) : array
- raw(1 params) : array

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

## ModelsSection

**Namespace**
App\Services\Documentation\Sections

**Dependencies**
- None

**Methods**
- generate(0 params) : string

---

## NotificationService

**Namespace**
App\Services

**Dependencies**
- None

**Methods**
- createReminder(2 params) : mixed

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

## SubscriptionRenewalService

**Namespace**
App\Services

**Dependencies**
- None

**Methods**
- renewPppoe(2 params) : bool
- renewHotspot(2 params) : bool

---

## SubscriptionService

**Namespace**
App\Services\Subscription

**Dependencies**
- App\Contracts\Repositories\SubscriptionRepositoryInterface
- App\Contracts\MikrotikServiceInterface
- App\Actions\Subscription\ActivateSubscriptionAction
- App\Actions\Subscription\SuspendSubscriptionAction
- App\Actions\Subscription\ExpireSubscriptionAction
- App\Actions\Subscription\RenewSubscriptionAction
- App\Actions\Subscription\RestoreSubscriptionAction

**Methods**
- __construct(7 params) : mixed
- activate(1 params) : bool
- suspend(1 params) : bool
- expire(1 params) : bool
- renew(2 params) : bool
- restore(1 params) : bool
- availablePppoeUsers(0 params) : array
- linkPppoe(2 params) : App\Models\Subscription

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

## WalletService

**Namespace**
App\Services

**Dependencies**
- None

**Methods**
- deposit(4 params) : void
- deduct(4 params) : void

---
