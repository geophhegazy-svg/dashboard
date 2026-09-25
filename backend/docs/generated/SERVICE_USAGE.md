# Service Usage

## AccountingPeriodService

**Class**

```
App\Modules\Accounting\Application\Services\AccountingPeriodService
```

**Public Methods**

- __construct
- assertOpenForDate

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

## DashboardService

**Class**

```
App\Modules\Dashboard\Application\Services\DashboardService
```

**Public Methods**

- __construct
- getDashboardData

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

- __construct
- create
- createRenewal
- delete
- findForPayment
- settle
- update

## JournalNumberService

**Class**

```
App\Modules\Accounting\Application\Services\JournalNumberService
```

**Public Methods**

- __construct
- generate

## JournalValidationService

**Class**

```
App\Modules\Accounting\Application\Services\JournalValidationService
```

**Public Methods**

- validate

## NetworkDeviceResolver

**Class**

```
App\Modules\Network\Application\Services\NetworkDeviceResolver
```

**Public Methods**

- resolveForSubscription

## NotificationService

**Class**

```
App\Modules\Notification\Application\Services\NotificationService
```

**Public Methods**

- __construct
- billingFailed
- create
- createReminder
- subscriptionRenewed

## PaymentService

**Class**

```
App\Modules\Payment\Application\Services\PaymentService
```

**Public Methods**

- __construct
- create
- createFromInvoice

## TaskService

**Class**

```
App\Modules\Task\Application\Services\TaskService
```

**Public Methods**

- __construct
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

- __construct
- credit
