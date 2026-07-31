# Services

---

## ActivityLogService

**Namespace**

```
App\Modules\Activity\Application\Services
```

**File**

```
/var/www/app/Modules/Activity/Application/Services/ActivityLogService.php
```

**Methods**

- log() : void

---

## AutomaticBillingService

**Namespace**

```
App\Modules\Billing\Application\Services
```

**File**

```
/var/www/app/Modules/Billing/Application/Services/AutomaticBillingService.php
```

**Constructor Dependencies**

- AutomaticBillingWorkflow $workflow

**Properties**

- $workflow : App\Modules\Billing\Application\Workflows\AutomaticBillingWorkflow

**Methods**

- run() : void
- processSubscription() : void

---

## BillingCycleService

**Namespace**

```
App\Modules\Billing\Application\Services
```

**File**

```
/var/www/app/Modules/Billing/Application/Services/BillingCycleService.php
```

**Methods**

- calculateNextBillingDate() : Carbon\Carbon
- calculateGraceDate() : Carbon\Carbon
- isDue() : bool
- isExpired() : bool

---

## CustomerDashboardService

**Namespace**

```
App\Modules\Dashboard\Application\Services
```

**File**

```
/var/www/app/Modules/Dashboard/Application/Services/CustomerDashboardService.php
```

**Constructor Dependencies**

- UsageService $usageService

**Properties**

- $usageService : App\Modules\Usage\UsageService

**Methods**

- getDashboardData() : array

---

## CustomerService

**Namespace**

```
App\Modules\Customer\Application\Services
```

**File**

```
/var/www/app/Modules/Customer/Application/Services/CustomerService.php
```

**Constructor Dependencies**

- CreateCustomerAction $createCustomer
- UpdateCustomerAction $updateCustomer
- DeleteCustomerAction $deleteCustomer

**Properties**

- $createCustomer : App\Modules\Customer\Application\Actions\CreateCustomerAction
- $updateCustomer : App\Modules\Customer\Application\Actions\UpdateCustomerAction
- $deleteCustomer : App\Modules\Customer\Application\Actions\DeleteCustomerAction

**Methods**

- create() : App\Models\Customer
- update() : App\Models\Customer
- delete() : bool

---

## DashboardService

**Namespace**

```
App\Modules\Dashboard\Application\Services
```

**File**

```
/var/www/app/Modules/Dashboard/Application/Services/DashboardService.php
```

**Methods**

- getDashboardData() : array

---

## FinanceService

**Namespace**

```
App\Modules\Finance\Application\Services
```

**File**

```
/var/www/app/Modules/Finance/Application/Services/FinanceService.php
```

**Methods**

- record() : void

---

## InvoiceGenerator

**Namespace**

```
App\Modules\Billing\Application\Services
```

**File**

```
/var/www/app/Modules/Billing/Application/Services/InvoiceGenerator.php
```

**Constructor Dependencies**

- GenerateInvoiceWorkflow $workflow

**Properties**

- $workflow : App\Modules\Billing\Application\Workflows\GenerateInvoiceWorkflow

**Methods**

- generate() : App\Models\Invoice

---

## InvoiceNumberService

**Namespace**

```
App\Modules\Invoice\Application\Services
```

**File**

```
/var/www/app/Modules/Invoice/Application/Services/InvoiceNumberService.php
```

**Methods**

- generate() : string

---

## InvoiceService

**Namespace**

```
App\Modules\Invoice\Application\Services
```

**File**

```
/var/www/app/Modules/Invoice/Application/Services/InvoiceService.php
```

**Constructor Dependencies**

- CreateInvoiceAction $createInvoice
- UpdateInvoiceAction $updateInvoice
- DeleteInvoiceAction $deleteInvoice

**Properties**

- $createInvoice : App\Modules\Invoice\Application\Actions\CreateInvoiceAction
- $updateInvoice : App\Modules\Invoice\Application\Actions\UpdateInvoiceAction
- $deleteInvoice : App\Modules\Invoice\Application\Actions\DeleteInvoiceAction

**Methods**

- create() : App\Models\Invoice
- update() : App\Models\Invoice
- delete() : bool

---

## JournalEntryNumberService

**Namespace**

```
App\Modules\Accounting\Application\Services
```

**File**

```
/var/www/app/Modules/Accounting/Application/Services/JournalEntryNumberService.php
```

**Methods**

- generate() : string

---

## JournalPostingService

**Namespace**

```
App\Modules\Accounting\Application\Services
```

**File**

```
/var/www/app/Modules/Accounting/Application/Services/JournalPostingService.php
```

**Constructor Dependencies**

- PostJournalEntryWorkflow $workflow

**Properties**

- $workflow : App\Modules\Accounting\Application\Workflows\PostJournalEntryWorkflow

**Methods**

- post() : App\Models\JournalEntry

---

## JournalValidationService

**Namespace**

```
App\Modules\Accounting\Application\Services
```

**File**

```
/var/www/app/Modules/Accounting/Application/Services/JournalValidationService.php
```

**Methods**

- validate() : void

---

## NotificationService

**Namespace**

```
App\Modules\Notification\Application\Services
```

**File**

```
/var/www/app/Modules/Notification/Application/Services/NotificationService.php
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
App\Modules\Package\Application\Services
```

**File**

```
/var/www/app/Modules/Package/Application/Services/PackageService.php
```

**Constructor Dependencies**

- PackageRepositoryInterface $repository

**Properties**

- $repository : App\Modules\Package\Domain\Contracts\PackageRepositoryInterface

**Methods**

- paginate() : Illuminate\Contracts\Pagination\LengthAwarePaginator
- create() : App\Models\Package
- update() : App\Models\Package
- delete() : void

---

## PaymentService

**Namespace**

```
App\Modules\Payment\Application\Services
```

**File**

```
/var/www/app/Modules/Payment/Application/Services/PaymentService.php
```

**Methods**

- create() : App\Models\Payment
- createFromInvoice() : App\Models\Payment

---

## ReportExecutionService

**Namespace**

```
App\Modules\Reports\Application\Services
```

**File**

```
/var/www/app/Modules/Reports/Application/Services/ReportExecutionService.php
```

**Constructor Dependencies**

- ReportManager $reportManager
- ExportManager $exportManager
- ReportRepositoryInterface $reportRepository
- ReportExportRepositoryInterface $reportExportRepository

**Properties**

- $reportManager : App\Reports\Manager\ReportManager
- $exportManager : App\Reports\Export\ExportManager
- $reportRepository : App\Modules\Reports\Domain\Contracts\ReportRepositoryInterface
- $reportExportRepository : App\Modules\Reports\Domain\Contracts\ReportExportRepositoryInterface

**Methods**

- execute() : App\Reports\DTO\ExportResult

---

## ReportExportService

**Namespace**

```
App\Modules\Reports\Application\Services
```

**File**

```
/var/www/app/Modules/Reports/Application/Services/ReportExportService.php
```

**Constructor Dependencies**

- ReportExportRepositoryInterface $exports

**Properties**

- $exports : App\Modules\Reports\Domain\Contracts\ReportExportRepositoryInterface

**Methods**

- paginate() : Illuminate\Contracts\Pagination\LengthAwarePaginator
- create() : App\Models\ReportExport
- find() : ?App\Models\ReportExport

---

## ReportService

**Namespace**

```
App\Modules\Reports\Application\Services
```

**File**

```
/var/www/app/Modules/Reports/Application/Services/ReportService.php
```

**Constructor Dependencies**

- ReportRepositoryInterface $reports

**Properties**

- $reports : App\Modules\Reports\Domain\Contracts\ReportRepositoryInterface

**Methods**

- paginate() : Illuminate\Contracts\Pagination\LengthAwarePaginator
- create() : App\Models\Report
- update() : App\Models\Report
- delete() : bool
- find() : ?App\Models\Report

---

## ScheduledReportService

**Namespace**

```
App\Modules\Reports\Application\Services
```

**File**

```
/var/www/app/Modules/Reports/Application/Services/ScheduledReportService.php
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

## SubscriptionActivityService

**Namespace**

```
App\Modules\Activity\Application\Services
```

**File**

```
/var/www/app/Modules/Activity/Application/Services/SubscriptionActivityService.php
```

**Methods**

- log() : App\Models\ActivityLog

---

## SubscriptionService

**Namespace**

```
App\Modules\Subscription\Application\Services
```

**File**

```
/var/www/app/Modules/Subscription/Application/Services/SubscriptionService.php
```

**Constructor Dependencies**

- SubscriptionRepositoryInterface $subscriptions
- ActivateWorkflow $activateWorkflow
- SuspendWorkflow $suspendWorkflow
- ExpireWorkflow $expireWorkflow
- RestoreWorkflow $restoreWorkflow
- RenewWorkflow $renewWorkflow

**Properties**

- $subscriptions : App\Modules\Subscription\Domain\Contracts\SubscriptionRepositoryInterface
- $activateWorkflow : App\Modules\Subscription\Application\Workflows\ActivateWorkflow
- $suspendWorkflow : App\Modules\Subscription\Application\Workflows\SuspendWorkflow
- $expireWorkflow : App\Modules\Subscription\Application\Workflows\ExpireWorkflow
- $restoreWorkflow : App\Modules\Subscription\Application\Workflows\RestoreWorkflow
- $renewWorkflow : App\Modules\Subscription\Application\Workflows\RenewWorkflow

**Methods**

- paginate() : Illuminate\Pagination\LengthAwarePaginator
- find() : ?App\Modules\Subscription\Infrastructure\Persistence\Models\Subscription
- findOrFail() : App\Modules\Subscription\Infrastructure\Persistence\Models\Subscription
- byCustomer() : Illuminate\Database\Eloquent\Collection
- active() : Illuminate\Database\Eloquent\Collection
- expired() : Illuminate\Database\Eloquent\Collection
- byStatus() : Illuminate\Database\Eloquent\Collection
- search() : Illuminate\Pagination\LengthAwarePaginator
- create() : App\Modules\Subscription\Infrastructure\Persistence\Models\Subscription
- update() : App\Modules\Subscription\Infrastructure\Persistence\Models\Subscription
- activate() : App\Modules\Subscription\Infrastructure\Persistence\Models\Subscription
- suspend() : App\Modules\Subscription\Infrastructure\Persistence\Models\Subscription
- expire() : App\Modules\Subscription\Infrastructure\Persistence\Models\Subscription
- restore() : App\Modules\Subscription\Infrastructure\Persistence\Models\Subscription
- renew() : App\Modules\Subscription\Infrastructure\Persistence\Models\Subscription
- statistics() : array
- autoExpire() : int
- expiringSoon() : Illuminate\Database\Eloquent\Collection

---

## TaskService

**Namespace**

```
App\Modules\Task\Application\Services
```

**File**

```
/var/www/app/Modules/Task/Application/Services/TaskService.php
```

**Constructor Dependencies**

- CreateTaskWorkflow $createTask
- UpdateTaskWorkflow $updateTask
- DeleteTaskWorkflow $deleteTask

**Properties**

- $createTask : App\Modules\Task\Application\Workflows\CreateTaskWorkflow
- $updateTask : App\Modules\Task\Application\Workflows\UpdateTaskWorkflow
- $deleteTask : App\Modules\Task\Application\Workflows\DeleteTaskWorkflow

**Methods**

- paginate() : Illuminate\Contracts\Pagination\LengthAwarePaginator
- create() : App\Models\Task
- update() : App\Models\Task
- complete() : App\Models\Task
- cancel() : App\Models\Task
- reopen() : App\Models\Task
- start() : App\Models\Task
- delete() : bool

---

## TelegramNotificationService

**Namespace**

```
App\Modules\Notification\Application\Services
```

**File**

```
/var/www/app/Modules/Notification/Application/Services/TelegramNotificationService.php
```

**Properties**

- $botToken : mixed
- $chatId : mixed

**Methods**

- sendMessage() : mixed
- sendDeviceAlert() : mixed

---

## WalletService

**Namespace**

```
App\Modules\Wallet\Application\Services
```

**File**

```
/var/www/app/Modules/Wallet/Application/Services/WalletService.php
```

**Methods**

- deposit() : void
- deduct() : void
