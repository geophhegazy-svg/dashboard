# Service Usage

## ActivityLogService

**Class**

```
App\Modules\Activity\Application\Services\ActivityLogService
```

**Public Methods**

- log

## AutomaticBillingService

**Class**

```
App\Modules\Billing\Application\Services\AutomaticBillingService
```

**Public Methods**

- __construct
- processSubscription
- run

## BillingCycleService

**Class**

```
App\Modules\Billing\Application\Services\BillingCycleService
```

**Public Methods**

- calculateGraceDate
- calculateNextBillingDate
- isDue
- isExpired

## CustomerDashboardService

**Class**

```
App\Modules\Dashboard\Application\Services\CustomerDashboardService
```

**Public Methods**

- __construct
- getDashboardData

## CustomerService

**Class**

```
App\Modules\Customer\Application\Services\CustomerService
```

**Public Methods**

- __construct
- create
- delete
- paginate
- update

## DashboardService

**Class**

```
App\Modules\Dashboard\Application\Services\DashboardService
```

**Public Methods**

- getDashboardData

## FinanceService

**Class**

```
App\Modules\Finance\Application\Services\FinanceService
```

**Public Methods**

- record

## InvoiceGenerator

**Class**

```
App\Modules\Billing\Application\Services\InvoiceGenerator
```

**Public Methods**

- __construct
- generate

## InvoiceNumberService

**Class**

```
App\Modules\Invoice\Application\Services\InvoiceNumberService
```

**Public Methods**

- generate

## InvoiceService

**Class**

```
App\Modules\Invoice\Application\Services\InvoiceService
```

**Public Methods**

- create
- delete
- update

## JournalEntryNumberService

**Class**

```
App\Modules\Accounting\Application\Services\JournalEntryNumberService
```

**Public Methods**

- generate

## JournalPostingService

**Class**

```
App\Modules\Accounting\Application\Services\JournalPostingService
```

**Public Methods**

- __construct
- post

## JournalValidationService

**Class**

```
App\Modules\Accounting\Application\Services\JournalValidationService
```

**Public Methods**

- validate

## NotificationService

**Class**

```
App\Modules\Notification\Application\Services\NotificationService
```

**Public Methods**

- billingFailed
- create
- createReminder
- subscriptionRenewed

## PackageService

**Class**

```
App\Modules\Package\Application\Services\PackageService
```

**Public Methods**

- create
- delete
- paginate
- update

## PaymentService

**Class**

```
App\Modules\Payment\Application\Services\PaymentService
```

**Public Methods**

- create
- createFromInvoice

## ReportExecutionService

**Class**

```
App\Modules\Reports\Application\Services\ReportExecutionService
```

**Public Methods**

- __construct
- execute

## ReportExportService

**Class**

```
App\Modules\Reports\Application\Services\ReportExportService
```

**Public Methods**

- __construct
- create
- find
- paginate

## ReportService

**Class**

```
App\Modules\Reports\Application\Services\ReportService
```

**Public Methods**

- __construct
- create
- delete
- find
- paginate
- update

## ScheduledReportService

**Class**

```
App\Modules\Reports\Application\Services\ScheduledReportService
```

**Public Methods**

- activate
- create
- deactivate
- delete
- paginate
- update
- updateLastRun
- updateNextRun

## SubscriptionActivityService

**Class**

```
App\Modules\Activity\Application\Services\SubscriptionActivityService
```

**Public Methods**

- log

## SubscriptionService

**Class**

```
App\Modules\Subscription\Application\Services\SubscriptionService
```

**Public Methods**

- __construct
- activate
- active
- autoExpire
- byCustomer
- byStatus
- create
- expire
- expired
- expiringSoon
- find
- findOrFail
- paginate
- renew
- restore
- search
- statistics
- suspend
- update

## TaskService

**Class**

```
App\Modules\Task\Application\Services\TaskService
```

**Public Methods**

- cancel
- complete
- create
- delete
- paginate
- reopen
- start
- update

## TelegramNotificationService

**Class**

```
App\Modules\Notification\Application\Services\TelegramNotificationService
```

**Public Methods**

- __construct
- sendDeviceAlert
- sendMessage

## WalletService

**Class**

```
App\Modules\Wallet\Application\Services\WalletService
```

**Public Methods**

- deduct
- deposit
