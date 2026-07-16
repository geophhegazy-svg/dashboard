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

## CustomerAuthController

**Namespace**

```
App\Http\Controllers
```

**File**

```
/var/www/app/Http/Controllers/CustomerAuthController.php
```

**Public Methods**

- showLoginForm()
- login()
- logout()

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

**Dependencies**

- CustomerDashboardService $dashboardService

**Public Methods**

- index()

---

## CustomerDashboardController

**Namespace**

```
App\Http\Controllers
```

**File**

```
/var/www/app/Http/Controllers/CustomerDashboardController.php
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

## CustomerInvoiceController

**Namespace**

```
App\Http\Controllers
```

**File**

```
/var/www/app/Http/Controllers/CustomerInvoiceController.php
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

## CustomerProfileController

**Namespace**

```
App\Http\Controllers
```

**File**

```
/var/www/app/Http/Controllers/CustomerProfileController.php
```

**Public Methods**

- show()
- update()
- changePassword()

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

**Dependencies**

- TicketService $ticketService

**Public Methods**

- index()
- dashboard()
- show()
- messages()
- store()
- reply()
- close()

---

## CustomerTicketController

**Namespace**

```
App\Http\Controllers
```

**File**

```
/var/www/app/Http/Controllers/CustomerTicketController.php
```

**Public Methods**

- index()
- create()
- store()
- show()
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

## DHCPController

**Namespace**

```
App\Http\Controllers\Api\Network
```

**File**

```
/var/www/app/Http/Controllers/Api/Network/DHCPController.php
```

**Dependencies**

- NetworkManager $networkManager

**Public Methods**

- index()
- create()
- store()
- edit()
- update()
- destroy()

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

**Public Methods**

- index()
- stats()

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

## DhcpApiController

**Namespace**

```
App\Http\Controllers\Api
```

**File**

```
/var/www/app/Http/Controllers/Api/DhcpApiController.php
```

**Dependencies**

- NetworkManager $networkManager

**Public Methods**

- index()
- store()
- update()
- destroy()

---

## FirewallApiController

**Namespace**

```
App\Http\Controllers\Api
```

**File**

```
/var/www/app/Http/Controllers/Api/FirewallApiController.php
```

**Dependencies**

- NetworkManager $networkManager

**Public Methods**

- index()
- store()
- update()
- destroy()

---

## FirewallController

**Namespace**

```
App\Http\Controllers\Api\Network
```

**File**

```
/var/www/app/Http/Controllers/Api/Network/FirewallController.php
```

**Dependencies**

- NetworkManager $networkManager

**Public Methods**

- index()
- create()
- store()
- edit()
- update()
- destroy()

---

## HotspotController

**Namespace**

```
App\Http\Controllers\Api
```

**File**

```
/var/www/app/Http/Controllers/Api/HotspotController.php
```

**Public Methods**

- onlineUsers()
- stats()

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

- NetworkManager $networkManager

**Public Methods**

- test()
- pppoeUsers()
- hotspotUsers()
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

## QueueApiController

**Namespace**

```
App\Http\Controllers\Api
```

**File**

```
/var/www/app/Http/Controllers/Api/QueueApiController.php
```

**Dependencies**

- NetworkManager $networkManager

**Public Methods**

- index()
- store()
- update()
- toggle()
- destroy()

---

## QueueController

**Namespace**

```
App\Http\Controllers\Api\Network
```

**File**

```
/var/www/app/Http/Controllers/Api/Network/QueueController.php
```

**Dependencies**

- NetworkManager $networkManager

**Public Methods**

- index()
- create()
- store()
- edit()
- update()
- toggle()
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

## ScheduledReportController

**Namespace**

```
App\Http\Controllers\Api
```

**File**

```
/var/www/app/Http/Controllers/Api/ScheduledReportController.php
```

**Dependencies**

- ScheduledReportService $service

**Public Methods**

- index()
- store()
- show()
- update()
- destroy()
- activate()
- deactivate()

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

## TaskController

**Namespace**

```
app\Http\Controllers\Api\Task
```

**File**

```
/var/www/app/Http/Controllers/Api/Task/TaskController.php
```

**Dependencies**

- TaskService $service

**Public Methods**

- index()
- store()
- update()
- destroy()

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

**Dependencies**

- TicketService $ticketService

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
