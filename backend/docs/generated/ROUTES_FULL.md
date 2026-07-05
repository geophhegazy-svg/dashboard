# Routes

---

## sanctum/csrf-cookie

**Methods**

- GET
- HEAD

**Name**

sanctum.csrf-cookie

**Action**

Laravel\Sanctum\Http\Controllers\CsrfCookieController@show

**Middleware**

- web

---

## api/login

**Methods**

- POST

**Name**

-

**Action**

App\Http\Controllers\Api\AuthController@login

**Middleware**

- api

---

## api/customer/login

**Methods**

- POST

**Name**

-

**Action**

App\Http\Controllers\Api\CustomerAuthController@login

**Middleware**

- api

---

## api/me

**Methods**

- GET
- HEAD

**Name**

-

**Action**

App\Http\Controllers\Api\AuthController@me

**Middleware**

- api
- auth:sanctum

---

## api/logout

**Methods**

- POST

**Name**

-

**Action**

App\Http\Controllers\Api\AuthController@logout

**Middleware**

- api
- auth:sanctum

---

## api/tickets/{ticket}/reply

**Methods**

- POST

**Name**

-

**Action**

App\Http\Controllers\Api\TicketController@reply

**Middleware**

- api
- auth:sanctum

---

## api/tickets/{ticket}/messages

**Methods**

- GET
- HEAD

**Name**

-

**Action**

App\Http\Controllers\Api\TicketController@messages

**Middleware**

- api
- auth:sanctum

---

## api/dashboard

**Methods**

- GET
- HEAD

**Name**

-

**Action**

App\Http\Controllers\Api\DashboardController@index

**Middleware**

- api
- auth:sanctum

---

## api/dashboard/stats

**Methods**

- GET
- HEAD

**Name**

-

**Action**

App\Http\Controllers\Api\MikrotikController@dashboardStats

**Middleware**

- api
- auth:sanctum

---

## api/users

**Methods**

- GET
- HEAD

**Name**

users.index

**Action**

App\Http\Controllers\Api\UserController@index

**Middleware**

- api
- auth:sanctum

---

## api/users

**Methods**

- POST

**Name**

users.store

**Action**

App\Http\Controllers\Api\UserController@store

**Middleware**

- api
- auth:sanctum

---

## api/users/{user}

**Methods**

- GET
- HEAD

**Name**

users.show

**Action**

App\Http\Controllers\Api\UserController@show

**Middleware**

- api
- auth:sanctum

---

## api/users/{user}

**Methods**

- PUT
- PATCH

**Name**

users.update

**Action**

App\Http\Controllers\Api\UserController@update

**Middleware**

- api
- auth:sanctum

---

## api/users/{user}

**Methods**

- DELETE

**Name**

users.destroy

**Action**

App\Http\Controllers\Api\UserController@destroy

**Middleware**

- api
- auth:sanctum

---

## api/tenants

**Methods**

- GET
- HEAD

**Name**

tenants.index

**Action**

App\Http\Controllers\Api\TenantController@index

**Middleware**

- api
- auth:sanctum

---

## api/tenants

**Methods**

- POST

**Name**

tenants.store

**Action**

App\Http\Controllers\Api\TenantController@store

**Middleware**

- api
- auth:sanctum

---

## api/tenants/{tenant}

**Methods**

- GET
- HEAD

**Name**

tenants.show

**Action**

App\Http\Controllers\Api\TenantController@show

**Middleware**

- api
- auth:sanctum

---

## api/tenants/{tenant}

**Methods**

- PUT
- PATCH

**Name**

tenants.update

**Action**

App\Http\Controllers\Api\TenantController@update

**Middleware**

- api
- auth:sanctum

---

## api/tenants/{tenant}

**Methods**

- DELETE

**Name**

tenants.destroy

**Action**

App\Http\Controllers\Api\TenantController@destroy

**Middleware**

- api
- auth:sanctum

---

## api/customers

**Methods**

- GET
- HEAD

**Name**

customers.index

**Action**

App\Http\Controllers\Api\CustomerController@index

**Middleware**

- api
- auth:sanctum

---

## api/customers

**Methods**

- POST

**Name**

customers.store

**Action**

App\Http\Controllers\Api\CustomerController@store

**Middleware**

- api
- auth:sanctum

---

## api/customers/{customer}

**Methods**

- GET
- HEAD

**Name**

customers.show

**Action**

App\Http\Controllers\Api\CustomerController@show

**Middleware**

- api
- auth:sanctum

---

## api/customers/{customer}

**Methods**

- PUT
- PATCH

**Name**

customers.update

**Action**

App\Http\Controllers\Api\CustomerController@update

**Middleware**

- api
- auth:sanctum

---

## api/customers/{customer}

**Methods**

- DELETE

**Name**

customers.destroy

**Action**

App\Http\Controllers\Api\CustomerController@destroy

**Middleware**

- api
- auth:sanctum

---

## api/packages

**Methods**

- GET
- HEAD

**Name**

packages.index

**Action**

App\Http\Controllers\Api\PackageController@index

**Middleware**

- api
- auth:sanctum

---

## api/packages

**Methods**

- POST

**Name**

packages.store

**Action**

App\Http\Controllers\Api\PackageController@store

**Middleware**

- api
- auth:sanctum

---

## api/packages/{package}

**Methods**

- GET
- HEAD

**Name**

packages.show

**Action**

App\Http\Controllers\Api\PackageController@show

**Middleware**

- api
- auth:sanctum

---

## api/packages/{package}

**Methods**

- PUT
- PATCH

**Name**

packages.update

**Action**

App\Http\Controllers\Api\PackageController@update

**Middleware**

- api
- auth:sanctum

---

## api/packages/{package}

**Methods**

- DELETE

**Name**

packages.destroy

**Action**

App\Http\Controllers\Api\PackageController@destroy

**Middleware**

- api
- auth:sanctum

---

## api/subscriptions

**Methods**

- GET
- HEAD

**Name**

subscriptions.index

**Action**

App\Http\Controllers\Api\SubscriptionController@index

**Middleware**

- api
- auth:sanctum

---

## api/subscriptions

**Methods**

- POST

**Name**

subscriptions.store

**Action**

App\Http\Controllers\Api\SubscriptionController@store

**Middleware**

- api
- auth:sanctum

---

## api/subscriptions/{subscription}

**Methods**

- GET
- HEAD

**Name**

subscriptions.show

**Action**

App\Http\Controllers\Api\SubscriptionController@show

**Middleware**

- api
- auth:sanctum

---

## api/subscriptions/{subscription}

**Methods**

- PUT
- PATCH

**Name**

subscriptions.update

**Action**

App\Http\Controllers\Api\SubscriptionController@update

**Middleware**

- api
- auth:sanctum

---

## api/subscriptions/{subscription}

**Methods**

- DELETE

**Name**

subscriptions.destroy

**Action**

App\Http\Controllers\Api\SubscriptionController@destroy

**Middleware**

- api
- auth:sanctum

---

## api/hotspot-subscriptions

**Methods**

- GET
- HEAD

**Name**

hotspot-subscriptions.index

**Action**

App\Http\Controllers\Api\HotspotSubscriptionController@index

**Middleware**

- api
- auth:sanctum

---

## api/hotspot-subscriptions

**Methods**

- POST

**Name**

hotspot-subscriptions.store

**Action**

App\Http\Controllers\Api\HotspotSubscriptionController@store

**Middleware**

- api
- auth:sanctum

---

## api/hotspot-subscriptions/{hotspot_subscription}

**Methods**

- GET
- HEAD

**Name**

hotspot-subscriptions.show

**Action**

App\Http\Controllers\Api\HotspotSubscriptionController@show

**Middleware**

- api
- auth:sanctum

---

## api/hotspot-subscriptions/{hotspot_subscription}

**Methods**

- PUT
- PATCH

**Name**

hotspot-subscriptions.update

**Action**

App\Http\Controllers\Api\HotspotSubscriptionController@update

**Middleware**

- api
- auth:sanctum

---

## api/hotspot-subscriptions/{hotspot_subscription}

**Methods**

- DELETE

**Name**

hotspot-subscriptions.destroy

**Action**

App\Http\Controllers\Api\HotspotSubscriptionController@destroy

**Middleware**

- api
- auth:sanctum

---

## api/invoices

**Methods**

- GET
- HEAD

**Name**

invoices.index

**Action**

App\Http\Controllers\Api\InvoiceController@index

**Middleware**

- api
- auth:sanctum

---

## api/invoices

**Methods**

- POST

**Name**

invoices.store

**Action**

App\Http\Controllers\Api\InvoiceController@store

**Middleware**

- api
- auth:sanctum

---

## api/invoices/{invoice}

**Methods**

- GET
- HEAD

**Name**

invoices.show

**Action**

App\Http\Controllers\Api\InvoiceController@show

**Middleware**

- api
- auth:sanctum

---

## api/invoices/{invoice}

**Methods**

- PUT
- PATCH

**Name**

invoices.update

**Action**

App\Http\Controllers\Api\InvoiceController@update

**Middleware**

- api
- auth:sanctum

---

## api/invoices/{invoice}

**Methods**

- DELETE

**Name**

invoices.destroy

**Action**

App\Http\Controllers\Api\InvoiceController@destroy

**Middleware**

- api
- auth:sanctum

---

## api/payments

**Methods**

- GET
- HEAD

**Name**

payments.index

**Action**

App\Http\Controllers\Api\PaymentController@index

**Middleware**

- api
- auth:sanctum

---

## api/payments

**Methods**

- POST

**Name**

payments.store

**Action**

App\Http\Controllers\Api\PaymentController@store

**Middleware**

- api
- auth:sanctum

---

## api/payments/{payment}

**Methods**

- GET
- HEAD

**Name**

payments.show

**Action**

App\Http\Controllers\Api\PaymentController@show

**Middleware**

- api
- auth:sanctum

---

## api/payments/{payment}

**Methods**

- PUT
- PATCH

**Name**

payments.update

**Action**

App\Http\Controllers\Api\PaymentController@update

**Middleware**

- api
- auth:sanctum

---

## api/payments/{payment}

**Methods**

- DELETE

**Name**

payments.destroy

**Action**

App\Http\Controllers\Api\PaymentController@destroy

**Middleware**

- api
- auth:sanctum

---

## api/devices

**Methods**

- GET
- HEAD

**Name**

devices.index

**Action**

App\Http\Controllers\Api\DeviceController@index

**Middleware**

- api
- auth:sanctum

---

## api/devices

**Methods**

- POST

**Name**

devices.store

**Action**

App\Http\Controllers\Api\DeviceController@store

**Middleware**

- api
- auth:sanctum

---

## api/devices/{device}

**Methods**

- GET
- HEAD

**Name**

devices.show

**Action**

App\Http\Controllers\Api\DeviceController@show

**Middleware**

- api
- auth:sanctum

---

## api/devices/{device}

**Methods**

- PUT
- PATCH

**Name**

devices.update

**Action**

App\Http\Controllers\Api\DeviceController@update

**Middleware**

- api
- auth:sanctum

---

## api/devices/{device}

**Methods**

- DELETE

**Name**

devices.destroy

**Action**

App\Http\Controllers\Api\DeviceController@destroy

**Middleware**

- api
- auth:sanctum

---

## api/inventories

**Methods**

- GET
- HEAD

**Name**

inventories.index

**Action**

App\Http\Controllers\Api\InventoryController@index

**Middleware**

- api
- auth:sanctum

---

## api/inventories

**Methods**

- POST

**Name**

inventories.store

**Action**

App\Http\Controllers\Api\InventoryController@store

**Middleware**

- api
- auth:sanctum

---

## api/inventories/{inventory}

**Methods**

- GET
- HEAD

**Name**

inventories.show

**Action**

App\Http\Controllers\Api\InventoryController@show

**Middleware**

- api
- auth:sanctum

---

## api/inventories/{inventory}

**Methods**

- PUT
- PATCH

**Name**

inventories.update

**Action**

App\Http\Controllers\Api\InventoryController@update

**Middleware**

- api
- auth:sanctum

---

## api/inventories/{inventory}

**Methods**

- DELETE

**Name**

inventories.destroy

**Action**

App\Http\Controllers\Api\InventoryController@destroy

**Middleware**

- api
- auth:sanctum

---

## api/device-assignments

**Methods**

- GET
- HEAD

**Name**

device-assignments.index

**Action**

App\Http\Controllers\Api\DeviceAssignmentController@index

**Middleware**

- api
- auth:sanctum

---

## api/device-assignments

**Methods**

- POST

**Name**

device-assignments.store

**Action**

App\Http\Controllers\Api\DeviceAssignmentController@store

**Middleware**

- api
- auth:sanctum

---

## api/device-assignments/{device_assignment}

**Methods**

- GET
- HEAD

**Name**

device-assignments.show

**Action**

App\Http\Controllers\Api\DeviceAssignmentController@show

**Middleware**

- api
- auth:sanctum

---

## api/device-assignments/{device_assignment}

**Methods**

- PUT
- PATCH

**Name**

device-assignments.update

**Action**

App\Http\Controllers\Api\DeviceAssignmentController@update

**Middleware**

- api
- auth:sanctum

---

## api/device-assignments/{device_assignment}

**Methods**

- DELETE

**Name**

device-assignments.destroy

**Action**

App\Http\Controllers\Api\DeviceAssignmentController@destroy

**Middleware**

- api
- auth:sanctum

---

## api/tickets

**Methods**

- GET
- HEAD

**Name**

tickets.index

**Action**

App\Http\Controllers\Api\TicketController@index

**Middleware**

- api
- auth:sanctum

---

## api/tickets

**Methods**

- POST

**Name**

tickets.store

**Action**

App\Http\Controllers\Api\TicketController@store

**Middleware**

- api
- auth:sanctum

---

## api/tickets/{ticket}

**Methods**

- GET
- HEAD

**Name**

tickets.show

**Action**

App\Http\Controllers\Api\TicketController@show

**Middleware**

- api
- auth:sanctum

---

## api/tickets/{ticket}

**Methods**

- PUT
- PATCH

**Name**

tickets.update

**Action**

App\Http\Controllers\Api\TicketController@update

**Middleware**

- api
- auth:sanctum

---

## api/tickets/{ticket}

**Methods**

- DELETE

**Name**

tickets.destroy

**Action**

App\Http\Controllers\Api\TicketController@destroy

**Middleware**

- api
- auth:sanctum

---

## api/tickets/{ticket}/assign

**Methods**

- POST

**Name**

-

**Action**

App\Http\Controllers\Api\TicketController@assign

**Middleware**

- api
- auth:sanctum

---

## api/tickets/{ticket}/status

**Methods**

- POST

**Name**

-

**Action**

App\Http\Controllers\Api\TicketController@changeStatus

**Middleware**

- api
- auth:sanctum

---

## api/tickets/dashboard/statistics

**Methods**

- GET
- HEAD

**Name**

-

**Action**

App\Http\Controllers\Api\TicketController@dashboard

**Middleware**

- api
- auth:sanctum

---

## api/notifications

**Methods**

- GET
- HEAD

**Name**

notifications.index

**Action**

App\Http\Controllers\Api\NotificationController@index

**Middleware**

- api
- auth:sanctum

---

## api/notifications

**Methods**

- POST

**Name**

notifications.store

**Action**

App\Http\Controllers\Api\NotificationController@store

**Middleware**

- api
- auth:sanctum

---

## api/notifications/{notification}

**Methods**

- GET
- HEAD

**Name**

notifications.show

**Action**

App\Http\Controllers\Api\NotificationController@show

**Middleware**

- api
- auth:sanctum

---

## api/notifications/{notification}

**Methods**

- PUT
- PATCH

**Name**

notifications.update

**Action**

App\Http\Controllers\Api\NotificationController@update

**Middleware**

- api
- auth:sanctum

---

## api/notifications/{notification}

**Methods**

- DELETE

**Name**

notifications.destroy

**Action**

App\Http\Controllers\Api\NotificationController@destroy

**Middleware**

- api
- auth:sanctum

---

## api/activity-logs

**Methods**

- GET
- HEAD

**Name**

activity-logs.index

**Action**

App\Http\Controllers\Api\ActivityLogController@index

**Middleware**

- api
- auth:sanctum

---

## api/activity-logs/{activity_log}

**Methods**

- GET
- HEAD

**Name**

activity-logs.show

**Action**

App\Http\Controllers\Api\ActivityLogController@show

**Middleware**

- api
- auth:sanctum

---

## api/subscriptions/available-pppoe-users

**Methods**

- GET
- HEAD

**Name**

-

**Action**

App\Http\Controllers\Api\SubscriptionController@availablePppoeUsers

**Middleware**

- api
- auth:sanctum

---

## api/subscriptions/{subscription}/link-pppoe

**Methods**

- POST

**Name**

-

**Action**

App\Http\Controllers\Api\SubscriptionController@linkPppoe

**Middleware**

- api
- auth:sanctum

---

## api/subscriptions/{subscription}/activate

**Methods**

- POST

**Name**

-

**Action**

App\Http\Controllers\Api\SubscriptionController@activate

**Middleware**

- api
- auth:sanctum

---

## api/subscriptions/{subscription}/suspend

**Methods**

- POST

**Name**

-

**Action**

App\Http\Controllers\Api\SubscriptionController@suspend

**Middleware**

- api
- auth:sanctum

---

## api/subscriptions/{subscription}/renew

**Methods**

- POST

**Name**

-

**Action**

App\Http\Controllers\Api\SubscriptionController@renew

**Middleware**

- api
- auth:sanctum

---

## api/hotspot-subscriptions/{hotspotSubscription}/activate

**Methods**

- POST

**Name**

-

**Action**

App\Http\Controllers\Api\HotspotSubscriptionController@activate

**Middleware**

- api
- auth:sanctum

---

## api/hotspot-subscriptions/{hotspotSubscription}/suspend

**Methods**

- POST

**Name**

-

**Action**

App\Http\Controllers\Api\HotspotSubscriptionController@suspend

**Middleware**

- api
- auth:sanctum

---

## api/device-assignments/{device_assignment}/return

**Methods**

- POST

**Name**

-

**Action**

App\Http\Controllers\Api\DeviceAssignmentController@returnDevice

**Middleware**

- api
- auth:sanctum

---

## api/notifications/{notification}/read

**Methods**

- POST

**Name**

-

**Action**

App\Http\Controllers\Api\NotificationController@markAsRead

**Middleware**

- api
- auth:sanctum

---

## api/notifications/read-all

**Methods**

- POST

**Name**

-

**Action**

App\Http\Controllers\Api\NotificationController@markAllAsRead

**Middleware**

- api
- auth:sanctum

---

## api/reports/dashboard

**Methods**

- GET
- HEAD

**Name**

-

**Action**

App\Http\Controllers\Api\ReportController@dashboard

**Middleware**

- api
- auth:sanctum

---

## api/reports/revenue

**Methods**

- GET
- HEAD

**Name**

-

**Action**

App\Http\Controllers\Api\ReportController@revenue

**Middleware**

- api
- auth:sanctum

---

## api/reports/invoices

**Methods**

- GET
- HEAD

**Name**

-

**Action**

App\Http\Controllers\Api\ReportController@invoices

**Middleware**

- api
- auth:sanctum

---

## api/reports/inventory

**Methods**

- GET
- HEAD

**Name**

-

**Action**

App\Http\Controllers\Api\ReportController@inventory

**Middleware**

- api
- auth:sanctum

---

## api/reports/tickets

**Methods**

- GET
- HEAD

**Name**

-

**Action**

App\Http\Controllers\Api\ReportController@tickets

**Middleware**

- api
- auth:sanctum

---

## api/mikrotik/test

**Methods**

- GET
- HEAD

**Name**

-

**Action**

App\Http\Controllers\Api\MikrotikController@test

**Middleware**

- api
- auth:sanctum

---

## api/mikrotik/dashboard-stats

**Methods**

- GET
- HEAD

**Name**

-

**Action**

App\Http\Controllers\Api\MikrotikController@dashboardStats

**Middleware**

- api
- auth:sanctum

---

## api/mikrotik/pppoe-users

**Methods**

- GET
- HEAD

**Name**

-

**Action**

App\Http\Controllers\Api\MikrotikController@pppoeUsers

**Middleware**

- api
- auth:sanctum

---

## api/mikrotik/pppoe-users

**Methods**

- POST

**Name**

-

**Action**

App\Http\Controllers\Api\MikrotikController@createPppoeUser

**Middleware**

- api
- auth:sanctum

---

## api/mikrotik/hotspot-users

**Methods**

- GET
- HEAD

**Name**

-

**Action**

App\Http\Controllers\Api\MikrotikController@hotspotUsers

**Middleware**

- api
- auth:sanctum

---

## api/mikrotik/hotspot-users/active

**Methods**

- GET
- HEAD

**Name**

-

**Action**

App\Http\Controllers\Api\MikrotikController@activeUsers

**Middleware**

- api
- auth:sanctum

---

## api/mikrotik/hotspot-users

**Methods**

- POST

**Name**

-

**Action**

App\Http\Controllers\Api\MikrotikController@createHotspotUser

**Middleware**

- api
- auth:sanctum

---

## api/mikrotik/hotspot-users/{username}

**Methods**

- DELETE

**Name**

-

**Action**

App\Http\Controllers\Api\MikrotikController@deleteHotspotUser

**Middleware**

- api
- auth:sanctum

---

## api/mikrotik/hotspot-users/{username}/activate

**Methods**

- POST

**Name**

-

**Action**

App\Http\Controllers\Api\MikrotikController@activateHotspotUser

**Middleware**

- api
- auth:sanctum

---

## api/mikrotik/hotspot-users/{username}/suspend

**Methods**

- POST

**Name**

-

**Action**

App\Http\Controllers\Api\MikrotikController@suspendHotspotUser

**Middleware**

- api
- auth:sanctum

---

## api/customer/me

**Methods**

- GET
- HEAD

**Name**

-

**Action**

App\Http\Controllers\Api\CustomerAuthController@me

**Middleware**

- api
- auth:sanctum

---

## api/customer/logout

**Methods**

- POST

**Name**

-

**Action**

App\Http\Controllers\Api\CustomerAuthController@logout

**Middleware**

- api
- auth:sanctum

---

## api/customer/profile

**Methods**

- PUT

**Name**

-

**Action**

App\Http\Controllers\Api\CustomerAuthController@updateProfile

**Middleware**

- api
- auth:sanctum

---

## api/customer/change-password

**Methods**

- POST

**Name**

-

**Action**

App\Http\Controllers\Api\CustomerAuthController@changePassword

**Middleware**

- api
- auth:sanctum

---

## api/customer/dashboard

**Methods**

- GET
- HEAD

**Name**

-

**Action**

App\Http\Controllers\Api\CustomerDashboardController@index

**Middleware**

- api
- auth:sanctum

---

## api/customer/subscription

**Methods**

- GET
- HEAD

**Name**

-

**Action**

App\Http\Controllers\Api\CustomerSubscriptionController@current

**Middleware**

- api
- auth:sanctum

---

## api/customer/subscription/renew

**Methods**

- POST

**Name**

-

**Action**

App\Http\Controllers\Api\CustomerSubscriptionController@renew

**Middleware**

- api
- auth:sanctum

---

## api/customer/wallet

**Methods**

- GET
- HEAD

**Name**

-

**Action**

App\Http\Controllers\Api\CustomerWalletController@show

**Middleware**

- api
- auth:sanctum

---

## api/customer/wallet/transactions

**Methods**

- GET
- HEAD

**Name**

-

**Action**

App\Http\Controllers\Api\CustomerWalletController@transactions

**Middleware**

- api
- auth:sanctum

---

## api/customer/invoices

**Methods**

- GET
- HEAD

**Name**

-

**Action**

App\Http\Controllers\Api\CustomerInvoiceController@index

**Middleware**

- api
- auth:sanctum

---

## api/customer/invoices/{invoice}

**Methods**

- GET
- HEAD

**Name**

-

**Action**

App\Http\Controllers\Api\CustomerInvoiceController@show

**Middleware**

- api
- auth:sanctum

---

## api/customer/notifications

**Methods**

- GET
- HEAD

**Name**

-

**Action**

App\Http\Controllers\Api\CustomerNotificationController@index

**Middleware**

- api
- auth:sanctum

---

## api/customer/notifications/{id}/read

**Methods**

- POST

**Name**

-

**Action**

App\Http\Controllers\Api\CustomerNotificationController@markAsRead

**Middleware**

- api
- auth:sanctum

---

## api/customer/notifications/read-all

**Methods**

- POST

**Name**

-

**Action**

App\Http\Controllers\Api\CustomerNotificationController@markAllAsRead

**Middleware**

- api
- auth:sanctum

---

## api/customer/tickets/dashboard

**Methods**

- GET
- HEAD

**Name**

-

**Action**

App\Http\Controllers\Api\CustomerTicketController@dashboard

**Middleware**

- api
- auth:sanctum

---

## api/customer/tickets

**Methods**

- GET
- HEAD

**Name**

-

**Action**

App\Http\Controllers\Api\CustomerTicketController@index

**Middleware**

- api
- auth:sanctum

---

## api/customer/tickets

**Methods**

- POST

**Name**

-

**Action**

App\Http\Controllers\Api\CustomerTicketController@store

**Middleware**

- api
- auth:sanctum

---

## api/customer/tickets/{ticket}

**Methods**

- GET
- HEAD

**Name**

-

**Action**

App\Http\Controllers\Api\CustomerTicketController@show

**Middleware**

- api
- auth:sanctum

---

## api/customer/tickets/{ticket}/messages

**Methods**

- GET
- HEAD

**Name**

-

**Action**

App\Http\Controllers\Api\CustomerTicketController@messages

**Middleware**

- api
- auth:sanctum

---

## api/customer/tickets/{ticket}/reply

**Methods**

- POST

**Name**

-

**Action**

App\Http\Controllers\Api\CustomerTicketController@reply

**Middleware**

- api
- auth:sanctum

---

## api/customer/tickets/{ticket}/close

**Methods**

- POST

**Name**

-

**Action**

App\Http\Controllers\Api\CustomerTicketController@close

**Middleware**

- api
- auth:sanctum

---

## api/network/dhcp/leases

**Methods**

- GET
- HEAD

**Name**

-

**Action**

App\Http\Controllers\Api\MikrotikController@dhcpLeases

**Middleware**

- api
- auth:sanctum

---

## /

**Methods**

- GET
- HEAD

**Name**

-

**Action**

Closure

**Middleware**

- web

---

## broadcasting/auth

**Methods**

- GET
- POST
- HEAD

**Name**

-

**Action**

\Illuminate\Broadcasting\BroadcastController@authenticate

**Middleware**

- web

---

## storage/{path}

**Methods**

- GET
- HEAD

**Name**

storage.local

**Action**

Closure

**Middleware**


---

## storage/{path}

**Methods**

- PUT

**Name**

storage.local.upload

**Action**

Closure

**Middleware**

