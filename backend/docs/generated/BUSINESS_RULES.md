# Business Rules

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
- App\Core\QueryBus\QueryDispatcher

**Methods**
- __construct(2 params) : mixed
- getDashboardData(1 params) : array

---

## DashboardService

**Namespace**
App\Modules\Dashboard\Application\Services

**Dependencies**
- App\Core\QueryBus\QueryDispatcher

**Methods**
- __construct(1 params) : mixed
- getDashboardData(0 params) : array

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
- App\Modules\Invoice\Domain\Contracts\InvoiceRepositoryInterface
- App\Modules\Invoice\Application\Actions\CreateInvoiceAction
- App\Modules\Invoice\Application\Actions\UpdateInvoiceAction
- App\Modules\Invoice\Application\Actions\DeleteInvoiceAction
- App\Modules\Invoice\Application\Actions\SettleInvoiceAction

**Methods**
- __construct(5 params) : mixed
- findForPayment(1 params) : App\Modules\Invoice\Infrastructure\Persistence\Models\Invoice
- create(1 params) : App\Modules\Invoice\Infrastructure\Persistence\Models\Invoice
- createRenewal(1 params) : App\Modules\Invoice\Infrastructure\Persistence\Models\Invoice
- update(2 params) : App\Modules\Invoice\Infrastructure\Persistence\Models\Invoice
- delete(1 params) : bool
- settle(2 params) : App\Modules\Invoice\Infrastructure\Persistence\Models\Invoice

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
- App\Modules\Notification\Application\Actions\CreateNotificationAction
- App\Modules\Notification\Application\Actions\CreateReminderAction
- App\Modules\Notification\Application\Actions\BillingFailedNotificationAction
- App\Modules\Notification\Application\Actions\SubscriptionRenewedNotificationAction

**Methods**
- __construct(4 params) : mixed
- create(1 params) : App\Modules\Notification\Infrastructure\Persistence\Models\Notification
- createReminder(2 params) : App\Modules\Notification\Infrastructure\Persistence\Models\Notification
- billingFailed(1 params) : App\Modules\Notification\Infrastructure\Persistence\Models\Notification
- subscriptionRenewed(1 params) : App\Modules\Notification\Infrastructure\Persistence\Models\Notification

---

## PackageService

**Namespace**
App\Modules\Package\Application\Services

**Dependencies**
- App\Modules\Package\Domain\Contracts\PackageRepositoryInterface
- App\Modules\Package\Application\Actions\CreatePackageAction
- App\Modules\Package\Application\Actions\UpdatePackageAction
- App\Modules\Package\Application\Actions\DeletePackageAction

**Methods**
- __construct(4 params) : mixed
- paginate(0 params) : Illuminate\Contracts\Pagination\LengthAwarePaginator
- create(1 params) : App\Modules\Package\Infrastructure\Persistence\Models\Package
- update(2 params) : App\Modules\Package\Infrastructure\Persistence\Models\Package
- delete(1 params) : void

---

## PaymentService

**Namespace**
App\Modules\Payment\Application\Services

**Dependencies**
- App\Modules\Payment\Application\Actions\CreatePaymentAction

**Methods**
- __construct(1 params) : mixed
- create(1 params) : App\Modules\Payment\Infrastructure\Persistence\Models\Payment
- createFromInvoice(5 params) : App\Modules\Payment\Infrastructure\Persistence\Models\Payment

---

## SubscriptionService

**Namespace**
App\Modules\Subscription\Application\Services

**Dependencies**
- App\Core\Workflow\WorkflowEngine
- App\Modules\Subscription\Application\Workflows\ActivateWorkflow
- App\Modules\Subscription\Application\Workflows\SuspendWorkflow
- App\Modules\Subscription\Application\Workflows\ExpireWorkflow
- App\Modules\Subscription\Application\Workflows\RestoreWorkflow
- App\Modules\Subscription\Application\Workflows\RenewWorkflow

**Methods**
- __construct(6 params) : mixed
- activate(1 params) : App\Modules\Subscription\Infrastructure\Persistence\Models\Subscription
- suspend(1 params) : App\Modules\Subscription\Infrastructure\Persistence\Models\Subscription
- expire(1 params) : App\Modules\Subscription\Infrastructure\Persistence\Models\Subscription
- restore(1 params) : App\Modules\Subscription\Infrastructure\Persistence\Models\Subscription
- renew(2 params) : App\Modules\Subscription\Infrastructure\Persistence\Models\Subscription

---

## TaskService

**Namespace**
App\Modules\Task\Application\Services

**Dependencies**
- App\Modules\Task\Application\Actions\CreateTaskAction
- App\Modules\Task\Application\Actions\UpdateTaskAction
- App\Modules\Task\Application\Actions\DeleteTaskAction
- App\Modules\Task\Application\Actions\StartTaskAction
- App\Modules\Task\Application\Actions\CompleteTaskAction
- App\Modules\Task\Application\Actions\CancelTaskAction
- App\Modules\Task\Application\Actions\ReopenTaskAction

**Methods**
- __construct(7 params) : mixed
- paginate(0 params) : Illuminate\Contracts\Pagination\LengthAwarePaginator
- create(1 params) : App\Modules\Task\Infrastructure\Persistence\Models\Task
- update(2 params) : App\Modules\Task\Infrastructure\Persistence\Models\Task
- complete(1 params) : App\Modules\Task\Infrastructure\Persistence\Models\Task
- cancel(1 params) : App\Modules\Task\Infrastructure\Persistence\Models\Task
- reopen(1 params) : App\Modules\Task\Infrastructure\Persistence\Models\Task
- start(1 params) : App\Modules\Task\Infrastructure\Persistence\Models\Task
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
- App\Modules\Wallet\Domain\Contracts\WalletRepositoryInterface
- App\Modules\Wallet\Application\Actions\DepositWalletAction

**Methods**
- __construct(2 params) : mixed
- credit(5 params) : void

---
