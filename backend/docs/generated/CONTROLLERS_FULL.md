# Controllers

---

## ActivityLogController

**Namespace**

```
App\Http\Controllers\Api
```

**File**

```
/var/www/app/Http/Controllers/Api/ActivityLogController.php
```

**Public Methods**

- index()
- show()

---

## AuthController

**Namespace**

```
App\Http\Controllers\Api
```

**File**

```
/var/www/app/Http/Controllers/Api/AuthController.php
```

**Public Methods**

- login()
- me()
- logout()

---

## Controller

**Namespace**

```
App\Http\Controllers
```

**File**

```
/var/www/app/Http/Controllers/Controller.php
```

**Public Methods**

- authorize()
- authorizeForUser()
- authorizeResource()

---

## CustomerAuthController

**Namespace**

```
App\Http\Controllers\Api
```

**File**

```
/var/www/app/Http/Controllers/Api/CustomerAuthController.php
```

**Public Methods**

- login()
- me()

---

## CustomerController

**Namespace**

```
App\Http\Controllers\Api
```

**File**

```
/var/www/app/Http/Controllers/Api/CustomerController.php
```

**Dependencies**

- CustomerService $customerService

**Public Methods**

- index()
- store()
- show()
- update()
- destroy()

---

## CustomerDashboardController

**Namespace**

```
App\Http\Controllers\Api
```

**File**

```
/var/www/app/Http/Controllers/Api/CustomerDashboardController.php
```

**Public Methods**

- index()

---

## CustomerInvoiceController

**Namespace**

```
App\Http\Controllers\Api
```

**File**

```
/var/www/app/Http/Controllers/Api/CustomerInvoiceController.php
```

**Public Methods**

- index()
- show()

---

## CustomerNotificationController

**Namespace**

```
App\Http\Controllers\Api
```

**File**

```
/var/www/app/Http/Controllers/Api/CustomerNotificationController.php
```

**Public Methods**

- index()
- markAsRead()
- markAllAsRead()

---

## CustomerSubscriptionController

**Namespace**

```
App\Http\Controllers\Api
```

**File**

```
/var/www/app/Http/Controllers/Api/CustomerSubscriptionController.php
```

**Public Methods**

- current()

---

## CustomerTicketController

**Namespace**

```
App\Http\Controllers\Api
```

**File**

```
/var/www/app/Http/Controllers/Api/CustomerTicketController.php
```

**Public Methods**

- index()
- dashboard()
- show()
- messages()
- store()
- reply()
- close()

---

## CustomerWalletController

**Namespace**

```
App\Http\Controllers\Api
```

**File**

```
/var/www/app/Http/Controllers/Api/CustomerWalletController.php
```

**Public Methods**

- show()

---

## DashboardController

**Namespace**

```
App\Http\Controllers\Api
```

**File**

```
/var/www/app/Http/Controllers/Api/DashboardController.php
```

**Dependencies**

- DashboardService $dashboardService

**Public Methods**

- index()

---

## DeviceAssignmentController

**Namespace**

```
App\Http\Controllers\Api
```

**File**

```
/var/www/app/Http/Controllers/Api/DeviceAssignmentController.php
```

**Public Methods**

- index()
- store()
- returnDevice()
- show()
- update()
- destroy()

---

## DeviceController

**Namespace**

```
App\Http\Controllers\Api
```

**File**

```
/var/www/app/Http/Controllers/Api/DeviceController.php
```

**Public Methods**

- index()
- store()
- show()
- update()
- destroy()

---

## DhcpLeaseController

**Namespace**

```
App\Http\Controllers\Api\Network
```

**File**

```
/var/www/app/Http/Controllers/Api/Network/DhcpLeaseController.php
```

**Public Methods**

- index()

---

## HotspotSubscriptionController

**Namespace**

```
App\Http\Controllers\Api
```

**File**

```
/var/www/app/Http/Controllers/Api/HotspotSubscriptionController.php
```

**Public Methods**

- index()
- store()
- show()
- destroy()
- suspend()
- activate()

---

## InventoryController

**Namespace**

```
App\Http\Controllers\Api
```

**File**

```
/var/www/app/Http/Controllers/Api/InventoryController.php
```

**Public Methods**

- index()
- store()
- show()
- update()
- destroy()

---

## InvoiceController

**Namespace**

```
App\Http\Controllers\Api
```

**File**

```
/var/www/app/Http/Controllers/Api/InvoiceController.php
```

**Dependencies**

- InvoiceService $invoiceService

**Public Methods**

- index()
- store()
- show()
- update()
- destroy()

---

## MikrotikController

**Namespace**

```
App\Http\Controllers\Api
```

**File**

```
/var/www/app/Http/Controllers/Api/MikrotikController.php
```

**Dependencies**

- MikrotikServiceInterface $mikrotik
- MikrotikConnection $connection

**Public Methods**

- test()
- pppoeUsers()
- createPppoeUser()
- hotspotUsers()
- activeUsers()
- createHotspotUser()
- deleteHotspotUser()
- suspendHotspotUser()
- activateHotspotUser()
- dhcpLeases()
- dashboardStats()

---

## NotificationController

**Namespace**

```
App\Http\Controllers\Api
```

**File**

```
/var/www/app/Http/Controllers/Api/NotificationController.php
```

**Public Methods**

- index()
- show()
- markAsRead()
- markAllAsRead()
- destroy()

---

## PackageController

**Namespace**

```
App\Http\Controllers\Api
```

**File**

```
/var/www/app/Http/Controllers/Api/PackageController.php
```

**Dependencies**

- PackageService $packageService

**Public Methods**

- index()
- store()
- show()
- update()
- destroy()

---

## PaymentController

**Namespace**

```
App\Http\Controllers\Api
```

**File**

```
/var/www/app/Http/Controllers/Api/PaymentController.php
```

**Dependencies**

- PaymentService $paymentService

**Public Methods**

- index()
- store()
- show()
- update()
- destroy()

---

## ReportController

**Namespace**

```
App\Http\Controllers\Api
```

**File**

```
/var/www/app/Http/Controllers/Api/ReportController.php
```

**Public Methods**

- dashboard()
- revenue()
- invoices()
- inventory()
- tickets()

---

## SubscriptionController

**Namespace**

```
App\Http\Controllers\Api
```

**File**

```
/var/www/app/Http/Controllers/Api/SubscriptionController.php
```

**Dependencies**

- SubscriptionService $subscriptionService

**Public Methods**

- activate()
- suspend()
- renew()
- restore()
- expire()

---

## TenantController

**Namespace**

```
App\Http\Controllers\Api
```

**File**

```
/var/www/app/Http/Controllers/Api/TenantController.php
```

**Public Methods**

- index()
- store()
- show()
- update()
- destroy()

---

## TicketController

**Namespace**

```
App\Http\Controllers\Api
```

**File**

```
/var/www/app/Http/Controllers/Api/TicketController.php
```

**Public Methods**

- index()
- store()
- show()
- update()
- destroy()
- dashboard()
- messages()
- reply()
- changeStatus()
- assign()

---

## UserController

**Namespace**

```
App\Http\Controllers\Api
```

**File**

```
/var/www/app/Http/Controllers/Api/UserController.php
```

**Public Methods**

- index()
- store()
- show()
- destroy()
