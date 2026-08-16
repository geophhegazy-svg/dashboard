# Services

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

- generate() : App\Modules\Invoice\Infrastructure\Persistence\Models\Invoice

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
- SettleInvoiceAction $settleInvoice

**Properties**

- $createInvoice : App\Modules\Invoice\Application\Actions\CreateInvoiceAction
- $updateInvoice : App\Modules\Invoice\Application\Actions\UpdateInvoiceAction
- $deleteInvoice : App\Modules\Invoice\Application\Actions\DeleteInvoiceAction
- $settleInvoice : App\Modules\Invoice\Application\Actions\SettleInvoiceAction

**Methods**

- findForPayment() : App\Modules\Invoice\Infrastructure\Persistence\Models\Invoice
- create() : App\Modules\Invoice\Infrastructure\Persistence\Models\Invoice
- update() : App\Modules\Invoice\Infrastructure\Persistence\Models\Invoice
- delete() : bool
- settle() : App\Modules\Invoice\Infrastructure\Persistence\Models\Invoice

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

- post() : App\Modules\Accounting\Infrastructure\Persistence\Models\JournalEntry

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

**Constructor Dependencies**

- CreateNotificationAction $createNotification
- CreateReminderAction $createReminder
- BillingFailedNotificationAction $billingFailed
- SubscriptionRenewedNotificationAction $subscriptionRenewed

**Properties**

- $createNotification : App\Modules\Notification\Application\Actions\CreateNotificationAction
- $createReminder : App\Modules\Notification\Application\Actions\CreateReminderAction
- $billingFailed : App\Modules\Notification\Application\Actions\BillingFailedNotificationAction
- $subscriptionRenewed : App\Modules\Notification\Application\Actions\SubscriptionRenewedNotificationAction

**Methods**

- create() : App\Modules\Notification\Infrastructure\Persistence\Models\Notification
- createReminder() : App\Modules\Notification\Infrastructure\Persistence\Models\Notification
- billingFailed() : App\Modules\Notification\Infrastructure\Persistence\Models\Notification
- subscriptionRenewed() : App\Modules\Notification\Infrastructure\Persistence\Models\Notification

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
- CreatePackageAction $createWorkflow
- UpdatePackageAction $updateWorkflow
- DeletePackageAction $deleteWorkflow

**Properties**

- $repository : App\Modules\Package\Domain\Contracts\PackageRepositoryInterface
- $createWorkflow : App\Modules\Package\Application\Actions\CreatePackageAction
- $updateWorkflow : App\Modules\Package\Application\Actions\UpdatePackageAction
- $deleteWorkflow : App\Modules\Package\Application\Actions\DeletePackageAction

**Methods**

- paginate() : Illuminate\Contracts\Pagination\LengthAwarePaginator
- create() : App\Modules\Package\Infrastructure\Persistence\Models\Package
- update() : App\Modules\Package\Infrastructure\Persistence\Models\Package
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

**Constructor Dependencies**

- CreatePaymentAction $createPayment

**Properties**

- $createPayment : App\Modules\Payment\Application\Actions\CreatePaymentAction

**Methods**

- create() : App\Modules\Payment\Infrastructure\Persistence\Models\Payment
- createFromInvoice() : App\Modules\Payment\Infrastructure\Persistence\Models\Payment

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
- create() : App\Modules\Reports\Infrastructure\Persistence\Models\ReportExport
- find() : ?App\Modules\Reports\Infrastructure\Persistence\Models\ReportExport

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
- create() : App\Modules\Reports\Infrastructure\Persistence\Models\Report
- update() : App\Modules\Reports\Infrastructure\Persistence\Models\Report
- delete() : bool
- find() : ?App\Modules\Reports\Infrastructure\Persistence\Models\Report

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
- create() : App\Modules\Reports\Infrastructure\Persistence\Models\ScheduledReport
- update() : App\Modules\Reports\Infrastructure\Persistence\Models\ScheduledReport
- delete() : void
- activate() : App\Modules\Reports\Infrastructure\Persistence\Models\ScheduledReport
- deactivate() : App\Modules\Reports\Infrastructure\Persistence\Models\ScheduledReport
- updateLastRun() : App\Modules\Reports\Infrastructure\Persistence\Models\ScheduledReport
- updateNextRun() : App\Modules\Reports\Infrastructure\Persistence\Models\ScheduledReport

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

**Constructor Dependencies**

- CreateActivityLogAction $action

**Properties**

- $action : App\Modules\Activity\Application\Actions\CreateActivityLogAction

**Methods**

- log() : App\Modules\Activity\Infrastructure\Persistence\Models\ActivityLog

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
- AutoExpireSubscriptionsWorkflow $autoExpireSubscriptionsWorkflow

**Properties**

- $subscriptions : App\Modules\Subscription\Domain\Contracts\SubscriptionRepositoryInterface
- $activateWorkflow : App\Modules\Subscription\Application\Workflows\ActivateWorkflow
- $suspendWorkflow : App\Modules\Subscription\Application\Workflows\SuspendWorkflow
- $expireWorkflow : App\Modules\Subscription\Application\Workflows\ExpireWorkflow
- $restoreWorkflow : App\Modules\Subscription\Application\Workflows\RestoreWorkflow
- $renewWorkflow : App\Modules\Subscription\Application\Workflows\RenewWorkflow
- $autoExpireSubscriptionsWorkflow : App\Modules\Subscription\Application\Workflows\AutoExpireSubscriptionsWorkflow

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

- CreateTaskAction $createTask
- UpdateTaskAction $updateTask
- DeleteTaskAction $deleteTask
- StartTaskAction $startTask
- CompleteTaskAction $completeTask
- CancelTaskAction $cancelTask
- ReopenTaskAction $reopenTask

**Properties**

- $createTask : App\Modules\Task\Application\Actions\CreateTaskAction
- $updateTask : App\Modules\Task\Application\Actions\UpdateTaskAction
- $deleteTask : App\Modules\Task\Application\Actions\DeleteTaskAction
- $startTask : App\Modules\Task\Application\Actions\StartTaskAction
- $completeTask : App\Modules\Task\Application\Actions\CompleteTaskAction
- $cancelTask : App\Modules\Task\Application\Actions\CancelTaskAction
- $reopenTask : App\Modules\Task\Application\Actions\ReopenTaskAction

**Methods**

- paginate() : Illuminate\Contracts\Pagination\LengthAwarePaginator
- create() : App\Modules\Task\Infrastructure\Persistence\Models\Task
- update() : App\Modules\Task\Infrastructure\Persistence\Models\Task
- complete() : App\Modules\Task\Infrastructure\Persistence\Models\Task
- cancel() : App\Modules\Task\Infrastructure\Persistence\Models\Task
- reopen() : App\Modules\Task\Infrastructure\Persistence\Models\Task
- start() : App\Modules\Task\Infrastructure\Persistence\Models\Task
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

**Constructor Dependencies**

- DepositWalletAction $depositWallet

**Properties**

- $depositWallet : App\Modules\Wallet\Application\Actions\DepositWalletAction

**Methods**

- credit() : void
