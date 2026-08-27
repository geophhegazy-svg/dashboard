# Service Usage

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

- __construct
- create
- createRenewal
- delete
- findForPayment
- settle
- update

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

- __construct
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

- __construct
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

- __construct
- create
- createFromInvoice

## SubscriptionActivityService

**Class**

```
App\Modules\Activity\Application\Services\SubscriptionActivityService
```

**Public Methods**

- __construct
- log

## SubscriptionService

**Class**

```
App\Modules\Subscription\Application\Services\SubscriptionService
```

**Public Methods**

- __construct
- activate
- expire
- renew
- restore
- suspend

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
