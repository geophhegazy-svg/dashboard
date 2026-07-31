# Business Rules

## ActivityLogService

**Namespace**
App\Modules\Activity\Application\Services

**Dependencies**
- None

**Methods**
- log(5 params) : void

---

## AutomaticBillingService

**Namespace**
App\Modules\Billing\Application\Services

**Dependencies**
- App\Modules\Billing\Application\Workflows\AutomaticBillingWorkflow

**Methods**
- __construct(1 params) : mixed
- run(1 params) : void
- processSubscription(1 params) : void

---

## BillingCycleService

**Namespace**
App\Modules\Billing\Application\Services

**Dependencies**
- None

**Methods**
- calculateNextBillingDate(2 params) : Carbon\Carbon
- calculateGraceDate(2 params) : Carbon\Carbon
- isDue(1 params) : bool
- isExpired(1 params) : bool

---

## CustomerDashboardService

**Namespace**
App\Modules\Dashboard\Application\Services

**Dependencies**
- App\Modules\Usage\UsageService

**Methods**
- __construct(1 params) : mixed
- getDashboardData(1 params) : array

---

## CustomerService

**Namespace**
App\Modules\Customer\Application\Services

**Dependencies**
- App\Modules\Customer\Application\Actions\CreateCustomerAction
- App\Modules\Customer\Application\Actions\UpdateCustomerAction
- App\Modules\Customer\Application\Actions\DeleteCustomerAction

**Methods**
- __construct(3 params) : mixed
- create(1 params) : App\Models\Customer
- update(2 params) : App\Models\Customer
- delete(1 params) : bool

---

## DashboardService

**Namespace**
App\Modules\Dashboard\Application\Services

**Dependencies**
- None

**Methods**
- getDashboardData(0 params) : array

---

## FinanceService

**Namespace**
App\Modules\Finance\Application\Services

**Dependencies**
- None

**Methods**
- record(1 params) : void

---

## InvoiceGenerator

**Namespace**
App\Modules\Billing\Application\Services

**Dependencies**
- App\Modules\Billing\Application\Workflows\GenerateInvoiceWorkflow

**Methods**
- __construct(1 params) : mixed
- generate(1 params) : App\Models\Invoice

---

## InvoiceNumberService

**Namespace**
App\Modules\Invoice\Application\Services

**Dependencies**
- None

**Methods**
- generate(1 params) : string

---

## InvoiceService

**Namespace**
App\Modules\Invoice\Application\Services

**Dependencies**
- App\Modules\Invoice\Application\Actions\CreateInvoiceAction
- App\Modules\Invoice\Application\Actions\UpdateInvoiceAction
- App\Modules\Invoice\Application\Actions\DeleteInvoiceAction

**Methods**
- __construct(3 params) : mixed
- create(1 params) : App\Models\Invoice
- update(2 params) : App\Models\Invoice
- delete(1 params) : bool

---

## JournalEntryNumberService

**Namespace**
App\Modules\Accounting\Application\Services

**Dependencies**
- None

**Methods**
- generate(0 params) : string

---

## JournalPostingService

**Namespace**
App\Modules\Accounting\Application\Services

**Dependencies**
- App\Modules\Accounting\Application\Workflows\PostJournalEntryWorkflow

**Methods**
- __construct(1 params) : mixed
- post(1 params) : App\Models\JournalEntry

---

## JournalValidationService

**Namespace**
App\Modules\Accounting\Application\Services

**Dependencies**
- None

**Methods**
- validate(1 params) : void

---

## NotificationService

**Namespace**
App\Modules\Notification\Application\Services

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
App\Modules\Package\Application\Services

**Dependencies**
- App\Modules\Package\Domain\Contracts\PackageRepositoryInterface

**Methods**
- __construct(1 params) : mixed
- paginate(0 params) : Illuminate\Contracts\Pagination\LengthAwarePaginator
- create(1 params) : App\Models\Package
- update(2 params) : App\Models\Package
- delete(1 params) : void

---

## PaymentService

**Namespace**
App\Modules\Payment\Application\Services

**Dependencies**
- None

**Methods**
- create(1 params) : App\Models\Payment
- createFromInvoice(5 params) : App\Models\Payment

---

## ReportExecutionService

**Namespace**
App\Modules\Reports\Application\Services

**Dependencies**
- App\Reports\Manager\ReportManager
- App\Reports\Export\ExportManager
- App\Modules\Reports\Domain\Contracts\ReportRepositoryInterface
- App\Modules\Reports\Domain\Contracts\ReportExportRepositoryInterface

**Methods**
- __construct(4 params) : mixed
- execute(3 params) : App\Reports\DTO\ExportResult

---

## ReportExportService

**Namespace**
App\Modules\Reports\Application\Services

**Dependencies**
- App\Modules\Reports\Domain\Contracts\ReportExportRepositoryInterface

**Methods**
- __construct(1 params) : mixed
- paginate(0 params) : Illuminate\Contracts\Pagination\LengthAwarePaginator
- create(1 params) : App\Models\ReportExport
- find(1 params) : ?App\Models\ReportExport

---

## ReportService

**Namespace**
App\Modules\Reports\Application\Services

**Dependencies**
- App\Modules\Reports\Domain\Contracts\ReportRepositoryInterface

**Methods**
- __construct(1 params) : mixed
- paginate(0 params) : Illuminate\Contracts\Pagination\LengthAwarePaginator
- create(1 params) : App\Models\Report
- update(2 params) : App\Models\Report
- delete(1 params) : bool
- find(1 params) : ?App\Models\Report

---

## ScheduledReportService

**Namespace**
App\Modules\Reports\Application\Services

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

## SubscriptionActivityService

**Namespace**
App\Modules\Activity\Application\Services

**Dependencies**
- None

**Methods**
- log(4 params) : App\Models\ActivityLog

---

## SubscriptionService

**Namespace**
App\Modules\Subscription\Application\Services

**Dependencies**
- App\Modules\Subscription\Domain\Contracts\SubscriptionRepositoryInterface
- App\Modules\Subscription\Application\Workflows\ActivateWorkflow
- App\Modules\Subscription\Application\Workflows\SuspendWorkflow
- App\Modules\Subscription\Application\Workflows\ExpireWorkflow
- App\Modules\Subscription\Application\Workflows\RestoreWorkflow
- App\Modules\Subscription\Application\Workflows\RenewWorkflow

**Methods**
- __construct(6 params) : mixed
- paginate(2 params) : Illuminate\Pagination\LengthAwarePaginator
- find(1 params) : ?App\Modules\Subscription\Infrastructure\Persistence\Models\Subscription
- findOrFail(1 params) : App\Modules\Subscription\Infrastructure\Persistence\Models\Subscription
- byCustomer(1 params) : Illuminate\Database\Eloquent\Collection
- active(0 params) : Illuminate\Database\Eloquent\Collection
- expired(0 params) : Illuminate\Database\Eloquent\Collection
- byStatus(1 params) : Illuminate\Database\Eloquent\Collection
- search(2 params) : Illuminate\Pagination\LengthAwarePaginator
- create(1 params) : App\Modules\Subscription\Infrastructure\Persistence\Models\Subscription
- update(2 params) : App\Modules\Subscription\Infrastructure\Persistence\Models\Subscription
- activate(1 params) : App\Modules\Subscription\Infrastructure\Persistence\Models\Subscription
- suspend(1 params) : App\Modules\Subscription\Infrastructure\Persistence\Models\Subscription
- expire(1 params) : App\Modules\Subscription\Infrastructure\Persistence\Models\Subscription
- restore(1 params) : App\Modules\Subscription\Infrastructure\Persistence\Models\Subscription
- renew(2 params) : App\Modules\Subscription\Infrastructure\Persistence\Models\Subscription
- statistics(0 params) : array
- autoExpire(0 params) : int
- expiringSoon(1 params) : Illuminate\Database\Eloquent\Collection

---

## TaskService

**Namespace**
App\Modules\Task\Application\Services

**Dependencies**
- App\Modules\Task\Application\Workflows\CreateTaskWorkflow
- App\Modules\Task\Application\Workflows\UpdateTaskWorkflow
- App\Modules\Task\Application\Workflows\DeleteTaskWorkflow

**Methods**
- __construct(3 params) : mixed
- paginate(0 params) : Illuminate\Contracts\Pagination\LengthAwarePaginator
- create(1 params) : App\Models\Task
- update(2 params) : App\Models\Task
- complete(1 params) : App\Models\Task
- cancel(1 params) : App\Models\Task
- reopen(1 params) : App\Models\Task
- start(1 params) : App\Models\Task
- delete(1 params) : bool

---

## TelegramNotificationService

**Namespace**
App\Modules\Notification\Application\Services

**Dependencies**
- None

**Methods**
- __construct(0 params) : mixed
- sendMessage(1 params) : mixed
- sendDeviceAlert(1 params) : mixed

---

## WalletService

**Namespace**
App\Modules\Wallet\Application\Services

**Dependencies**
- None

**Methods**
- deposit(4 params) : void
- deduct(4 params) : void

---
