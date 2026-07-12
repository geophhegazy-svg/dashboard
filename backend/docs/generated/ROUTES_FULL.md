# Routes

## sanctum/csrf-cookie

- Method: GET|HEAD
- Name: sanctum.csrf-cookie
- Action: Laravel\Sanctum\Http\Controllers\CsrfCookieController@show
- Middleware: web

## api/login

- Method: POST
- Name: -
- Action: App\Http\Controllers\Api\AuthController@login
- Middleware: api

## api/customer/login

- Method: POST
- Name: -
- Action: App\Http\Controllers\Api\CustomerAuthController@login
- Middleware: api

## api/scheduled-reports

- Method: GET|HEAD
- Name: scheduled-reports.index
- Action: App\Http\Controllers\Api\ScheduledReportController@index
- Middleware: api, auth:sanctum

## api/scheduled-reports

- Method: POST
- Name: scheduled-reports.store
- Action: App\Http\Controllers\Api\ScheduledReportController@store
- Middleware: api, auth:sanctum

## api/scheduled-reports/{scheduled_report}

- Method: GET|HEAD
- Name: scheduled-reports.show
- Action: App\Http\Controllers\Api\ScheduledReportController@show
- Middleware: api, auth:sanctum

## api/scheduled-reports/{scheduled_report}

- Method: PUT|PATCH
- Name: scheduled-reports.update
- Action: App\Http\Controllers\Api\ScheduledReportController@update
- Middleware: api, auth:sanctum

## api/scheduled-reports/{scheduled_report}

- Method: DELETE
- Name: scheduled-reports.destroy
- Action: App\Http\Controllers\Api\ScheduledReportController@destroy
- Middleware: api, auth:sanctum

## api/scheduled-reports/{scheduledReport}/activate

- Method: PATCH
- Name: -
- Action: App\Http\Controllers\Api\ScheduledReportController@activate
- Middleware: api, auth:sanctum

## api/scheduled-reports/{scheduledReport}/deactivate

- Method: PATCH
- Name: -
- Action: App\Http\Controllers\Api\ScheduledReportController@deactivate
- Middleware: api, auth:sanctum

## api/me

- Method: GET|HEAD
- Name: -
- Action: App\Http\Controllers\Api\AuthController@me
- Middleware: api, auth:sanctum

## api/logout

- Method: POST
- Name: -
- Action: App\Http\Controllers\Api\AuthController@logout
- Middleware: api, auth:sanctum

## api/tickets/{ticket}/reply

- Method: POST
- Name: -
- Action: App\Http\Controllers\Api\TicketController@reply
- Middleware: api, auth:sanctum

## api/tickets/{ticket}/messages

- Method: GET|HEAD
- Name: -
- Action: App\Http\Controllers\Api\TicketController@messages
- Middleware: api, auth:sanctum

## api/dashboard

- Method: GET|HEAD
- Name: -
- Action: App\Http\Controllers\Api\DashboardController@index
- Middleware: api, auth:sanctum

## api/dashboard/stats

- Method: GET|HEAD
- Name: -
- Action: App\Http\Controllers\Api\DashboardController@stats
- Middleware: api

## api/users

- Method: GET|HEAD
- Name: users.index
- Action: App\Http\Controllers\Api\UserController@index
- Middleware: api, auth:sanctum

## api/users

- Method: POST
- Name: users.store
- Action: App\Http\Controllers\Api\UserController@store
- Middleware: api, auth:sanctum

## api/users/{user}

- Method: GET|HEAD
- Name: users.show
- Action: App\Http\Controllers\Api\UserController@show
- Middleware: api, auth:sanctum

## api/users/{user}

- Method: PUT|PATCH
- Name: users.update
- Action: App\Http\Controllers\Api\UserController@update
- Middleware: api, auth:sanctum

## api/users/{user}

- Method: DELETE
- Name: users.destroy
- Action: App\Http\Controllers\Api\UserController@destroy
- Middleware: api, auth:sanctum

## api/tenants

- Method: GET|HEAD
- Name: tenants.index
- Action: App\Http\Controllers\Api\TenantController@index
- Middleware: api, auth:sanctum

## api/tenants

- Method: POST
- Name: tenants.store
- Action: App\Http\Controllers\Api\TenantController@store
- Middleware: api, auth:sanctum

## api/tenants/{tenant}

- Method: GET|HEAD
- Name: tenants.show
- Action: App\Http\Controllers\Api\TenantController@show
- Middleware: api, auth:sanctum

## api/tenants/{tenant}

- Method: PUT|PATCH
- Name: tenants.update
- Action: App\Http\Controllers\Api\TenantController@update
- Middleware: api, auth:sanctum

## api/tenants/{tenant}

- Method: DELETE
- Name: tenants.destroy
- Action: App\Http\Controllers\Api\TenantController@destroy
- Middleware: api, auth:sanctum

## api/customers

- Method: GET|HEAD
- Name: customers.index
- Action: App\Http\Controllers\Api\CustomerController@index
- Middleware: api, auth:sanctum

## api/customers

- Method: POST
- Name: customers.store
- Action: App\Http\Controllers\Api\CustomerController@store
- Middleware: api, auth:sanctum

## api/customers/{customer}

- Method: GET|HEAD
- Name: customers.show
- Action: App\Http\Controllers\Api\CustomerController@show
- Middleware: api, auth:sanctum

## api/customers/{customer}

- Method: PUT|PATCH
- Name: customers.update
- Action: App\Http\Controllers\Api\CustomerController@update
- Middleware: api, auth:sanctum

## api/customers/{customer}

- Method: DELETE
- Name: customers.destroy
- Action: App\Http\Controllers\Api\CustomerController@destroy
- Middleware: api, auth:sanctum

## api/packages

- Method: GET|HEAD
- Name: packages.index
- Action: App\Http\Controllers\Api\PackageController@index
- Middleware: api, auth:sanctum

## api/packages

- Method: POST
- Name: packages.store
- Action: App\Http\Controllers\Api\PackageController@store
- Middleware: api, auth:sanctum

## api/packages/{package}

- Method: GET|HEAD
- Name: packages.show
- Action: App\Http\Controllers\Api\PackageController@show
- Middleware: api, auth:sanctum

## api/packages/{package}

- Method: PUT|PATCH
- Name: packages.update
- Action: App\Http\Controllers\Api\PackageController@update
- Middleware: api, auth:sanctum

## api/packages/{package}

- Method: DELETE
- Name: packages.destroy
- Action: App\Http\Controllers\Api\PackageController@destroy
- Middleware: api, auth:sanctum

## api/subscriptions

- Method: GET|HEAD
- Name: subscriptions.index
- Action: App\Http\Controllers\Api\SubscriptionController@index
- Middleware: api, auth:sanctum

## api/subscriptions

- Method: POST
- Name: subscriptions.store
- Action: App\Http\Controllers\Api\SubscriptionController@store
- Middleware: api, auth:sanctum

## api/subscriptions/{subscription}

- Method: GET|HEAD
- Name: subscriptions.show
- Action: App\Http\Controllers\Api\SubscriptionController@show
- Middleware: api, auth:sanctum

## api/subscriptions/{subscription}

- Method: PUT|PATCH
- Name: subscriptions.update
- Action: App\Http\Controllers\Api\SubscriptionController@update
- Middleware: api, auth:sanctum

## api/subscriptions/{subscription}

- Method: DELETE
- Name: subscriptions.destroy
- Action: App\Http\Controllers\Api\SubscriptionController@destroy
- Middleware: api, auth:sanctum

## api/hotspot-subscriptions

- Method: GET|HEAD
- Name: hotspot-subscriptions.index
- Action: App\Http\Controllers\Api\HotspotSubscriptionController@index
- Middleware: api, auth:sanctum

## api/hotspot-subscriptions

- Method: POST
- Name: hotspot-subscriptions.store
- Action: App\Http\Controllers\Api\HotspotSubscriptionController@store
- Middleware: api, auth:sanctum

## api/hotspot-subscriptions/{hotspot_subscription}

- Method: GET|HEAD
- Name: hotspot-subscriptions.show
- Action: App\Http\Controllers\Api\HotspotSubscriptionController@show
- Middleware: api, auth:sanctum

## api/hotspot-subscriptions/{hotspot_subscription}

- Method: PUT|PATCH
- Name: hotspot-subscriptions.update
- Action: App\Http\Controllers\Api\HotspotSubscriptionController@update
- Middleware: api, auth:sanctum

## api/hotspot-subscriptions/{hotspot_subscription}

- Method: DELETE
- Name: hotspot-subscriptions.destroy
- Action: App\Http\Controllers\Api\HotspotSubscriptionController@destroy
- Middleware: api, auth:sanctum

## api/invoices

- Method: GET|HEAD
- Name: invoices.index
- Action: App\Http\Controllers\Api\InvoiceController@index
- Middleware: api, auth:sanctum

## api/invoices

- Method: POST
- Name: invoices.store
- Action: App\Http\Controllers\Api\InvoiceController@store
- Middleware: api, auth:sanctum

## api/invoices/{invoice}

- Method: GET|HEAD
- Name: invoices.show
- Action: App\Http\Controllers\Api\InvoiceController@show
- Middleware: api, auth:sanctum

## api/invoices/{invoice}

- Method: PUT|PATCH
- Name: invoices.update
- Action: App\Http\Controllers\Api\InvoiceController@update
- Middleware: api, auth:sanctum

## api/invoices/{invoice}

- Method: DELETE
- Name: invoices.destroy
- Action: App\Http\Controllers\Api\InvoiceController@destroy
- Middleware: api, auth:sanctum

## api/payments

- Method: GET|HEAD
- Name: payments.index
- Action: App\Http\Controllers\Api\PaymentController@index
- Middleware: api, auth:sanctum

## api/payments

- Method: POST
- Name: payments.store
- Action: App\Http\Controllers\Api\PaymentController@store
- Middleware: api, auth:sanctum

## api/payments/{payment}

- Method: GET|HEAD
- Name: payments.show
- Action: App\Http\Controllers\Api\PaymentController@show
- Middleware: api, auth:sanctum

## api/payments/{payment}

- Method: PUT|PATCH
- Name: payments.update
- Action: App\Http\Controllers\Api\PaymentController@update
- Middleware: api, auth:sanctum

## api/payments/{payment}

- Method: DELETE
- Name: payments.destroy
- Action: App\Http\Controllers\Api\PaymentController@destroy
- Middleware: api, auth:sanctum

## api/devices

- Method: GET|HEAD
- Name: devices.index
- Action: App\Http\Controllers\Api\DeviceController@index
- Middleware: api, auth:sanctum

## api/devices

- Method: POST
- Name: devices.store
- Action: App\Http\Controllers\Api\DeviceController@store
- Middleware: api, auth:sanctum

## api/devices/{device}

- Method: GET|HEAD
- Name: devices.show
- Action: App\Http\Controllers\Api\DeviceController@show
- Middleware: api, auth:sanctum

## api/devices/{device}

- Method: PUT|PATCH
- Name: devices.update
- Action: App\Http\Controllers\Api\DeviceController@update
- Middleware: api, auth:sanctum

## api/devices/{device}

- Method: DELETE
- Name: devices.destroy
- Action: App\Http\Controllers\Api\DeviceController@destroy
- Middleware: api, auth:sanctum

## api/inventories

- Method: GET|HEAD
- Name: inventories.index
- Action: App\Http\Controllers\Api\InventoryController@index
- Middleware: api, auth:sanctum

## api/inventories

- Method: POST
- Name: inventories.store
- Action: App\Http\Controllers\Api\InventoryController@store
- Middleware: api, auth:sanctum

## api/inventories/{inventory}

- Method: GET|HEAD
- Name: inventories.show
- Action: App\Http\Controllers\Api\InventoryController@show
- Middleware: api, auth:sanctum

## api/inventories/{inventory}

- Method: PUT|PATCH
- Name: inventories.update
- Action: App\Http\Controllers\Api\InventoryController@update
- Middleware: api, auth:sanctum

## api/inventories/{inventory}

- Method: DELETE
- Name: inventories.destroy
- Action: App\Http\Controllers\Api\InventoryController@destroy
- Middleware: api, auth:sanctum

## api/device-assignments

- Method: GET|HEAD
- Name: device-assignments.index
- Action: App\Http\Controllers\Api\DeviceAssignmentController@index
- Middleware: api, auth:sanctum

## api/device-assignments

- Method: POST
- Name: device-assignments.store
- Action: App\Http\Controllers\Api\DeviceAssignmentController@store
- Middleware: api, auth:sanctum

## api/device-assignments/{device_assignment}

- Method: GET|HEAD
- Name: device-assignments.show
- Action: App\Http\Controllers\Api\DeviceAssignmentController@show
- Middleware: api, auth:sanctum

## api/device-assignments/{device_assignment}

- Method: PUT|PATCH
- Name: device-assignments.update
- Action: App\Http\Controllers\Api\DeviceAssignmentController@update
- Middleware: api, auth:sanctum

## api/device-assignments/{device_assignment}

- Method: DELETE
- Name: device-assignments.destroy
- Action: App\Http\Controllers\Api\DeviceAssignmentController@destroy
- Middleware: api, auth:sanctum

## api/tickets

- Method: GET|HEAD
- Name: tickets.index
- Action: App\Http\Controllers\Api\TicketController@index
- Middleware: api, auth:sanctum

## api/tickets

- Method: POST
- Name: tickets.store
- Action: App\Http\Controllers\Api\TicketController@store
- Middleware: api, auth:sanctum

## api/tickets/{ticket}

- Method: GET|HEAD
- Name: tickets.show
- Action: App\Http\Controllers\Api\TicketController@show
- Middleware: api, auth:sanctum

## api/tickets/{ticket}

- Method: PUT|PATCH
- Name: tickets.update
- Action: App\Http\Controllers\Api\TicketController@update
- Middleware: api, auth:sanctum

## api/tickets/{ticket}

- Method: DELETE
- Name: tickets.destroy
- Action: App\Http\Controllers\Api\TicketController@destroy
- Middleware: api, auth:sanctum

## api/tickets/{ticket}/assign

- Method: POST
- Name: -
- Action: App\Http\Controllers\Api\TicketController@assign
- Middleware: api, auth:sanctum

## api/tickets/{ticket}/status

- Method: POST
- Name: -
- Action: App\Http\Controllers\Api\TicketController@changeStatus
- Middleware: api, auth:sanctum

## api/tickets/dashboard/statistics

- Method: GET|HEAD
- Name: -
- Action: App\Http\Controllers\Api\TicketController@dashboard
- Middleware: api, auth:sanctum

## api/notifications

- Method: GET|HEAD
- Name: notifications.index
- Action: App\Http\Controllers\Api\NotificationController@index
- Middleware: api, auth:sanctum

## api/notifications

- Method: POST
- Name: notifications.store
- Action: App\Http\Controllers\Api\NotificationController@store
- Middleware: api, auth:sanctum

## api/notifications/{notification}

- Method: GET|HEAD
- Name: notifications.show
- Action: App\Http\Controllers\Api\NotificationController@show
- Middleware: api, auth:sanctum

## api/notifications/{notification}

- Method: PUT|PATCH
- Name: notifications.update
- Action: App\Http\Controllers\Api\NotificationController@update
- Middleware: api, auth:sanctum

## api/notifications/{notification}

- Method: DELETE
- Name: notifications.destroy
- Action: App\Http\Controllers\Api\NotificationController@destroy
- Middleware: api, auth:sanctum

## api/activity-logs

- Method: GET|HEAD
- Name: activity-logs.index
- Action: App\Http\Controllers\Api\ActivityLogController@index
- Middleware: api, auth:sanctum

## api/activity-logs/{activity_log}

- Method: GET|HEAD
- Name: activity-logs.show
- Action: App\Http\Controllers\Api\ActivityLogController@show
- Middleware: api, auth:sanctum

## api/subscriptions/available-pppoe-users

- Method: GET|HEAD
- Name: -
- Action: App\Http\Controllers\Api\SubscriptionController@availablePppoeUsers
- Middleware: api, auth:sanctum

## api/subscriptions/{subscription}/link-pppoe

- Method: POST
- Name: -
- Action: App\Http\Controllers\Api\SubscriptionController@linkPppoe
- Middleware: api, auth:sanctum

## api/subscriptions/{subscription}/activate

- Method: POST
- Name: -
- Action: App\Http\Controllers\Api\SubscriptionController@activate
- Middleware: api, auth:sanctum

## api/subscriptions/{subscription}/suspend

- Method: POST
- Name: -
- Action: App\Http\Controllers\Api\SubscriptionController@suspend
- Middleware: api, auth:sanctum

## api/subscriptions/{subscription}/renew

- Method: POST
- Name: -
- Action: App\Http\Controllers\Api\SubscriptionController@renew
- Middleware: api, auth:sanctum

## api/hotspot-subscriptions/{hotspotSubscription}/activate

- Method: POST
- Name: -
- Action: App\Http\Controllers\Api\HotspotSubscriptionController@activate
- Middleware: api, auth:sanctum

## api/hotspot-subscriptions/{hotspotSubscription}/suspend

- Method: POST
- Name: -
- Action: App\Http\Controllers\Api\HotspotSubscriptionController@suspend
- Middleware: api, auth:sanctum

## api/device-assignments/{device_assignment}/return

- Method: POST
- Name: -
- Action: App\Http\Controllers\Api\DeviceAssignmentController@returnDevice
- Middleware: api, auth:sanctum

## api/notifications/{notification}/read

- Method: POST
- Name: -
- Action: App\Http\Controllers\Api\NotificationController@markAsRead
- Middleware: api, auth:sanctum

## api/notifications/read-all

- Method: POST
- Name: -
- Action: App\Http\Controllers\Api\NotificationController@markAllAsRead
- Middleware: api, auth:sanctum

## api/reports/dashboard

- Method: GET|HEAD
- Name: -
- Action: App\Http\Controllers\Api\ReportController@dashboard
- Middleware: api, auth:sanctum

## api/reports/revenue

- Method: GET|HEAD
- Name: -
- Action: App\Http\Controllers\Api\ReportController@revenue
- Middleware: api, auth:sanctum

## api/reports/invoices

- Method: GET|HEAD
- Name: -
- Action: App\Http\Controllers\Api\ReportController@invoices
- Middleware: api, auth:sanctum

## api/reports/inventory

- Method: GET|HEAD
- Name: -
- Action: App\Http\Controllers\Api\ReportController@inventory
- Middleware: api, auth:sanctum

## api/reports/tickets

- Method: GET|HEAD
- Name: -
- Action: App\Http\Controllers\Api\ReportController@tickets
- Middleware: api, auth:sanctum

## api/mikrotik/test

- Method: GET|HEAD
- Name: -
- Action: App\Http\Controllers\Api\MikrotikController@test
- Middleware: api, auth:sanctum

## api/mikrotik/dashboard-stats

- Method: GET|HEAD
- Name: -
- Action: App\Http\Controllers\Api\MikrotikController@dashboardStats
- Middleware: api, auth:sanctum

## api/mikrotik/pppoe-users

- Method: GET|HEAD
- Name: -
- Action: App\Http\Controllers\Api\MikrotikController@pppoeUsers
- Middleware: api, auth:sanctum

## api/mikrotik/pppoe-users

- Method: POST
- Name: -
- Action: App\Http\Controllers\Api\MikrotikController@createPppoeUser
- Middleware: api, auth:sanctum

## api/mikrotik/hotspot-users

- Method: GET|HEAD
- Name: -
- Action: App\Http\Controllers\Api\MikrotikController@hotspotUsers
- Middleware: api, auth:sanctum

## api/mikrotik/hotspot-users/active

- Method: GET|HEAD
- Name: -
- Action: App\Http\Controllers\Api\MikrotikController@activeUsers
- Middleware: api, auth:sanctum

## api/mikrotik/hotspot-users

- Method: POST
- Name: -
- Action: App\Http\Controllers\Api\MikrotikController@createHotspotUser
- Middleware: api, auth:sanctum

## api/mikrotik/hotspot-users/{username}

- Method: DELETE
- Name: -
- Action: App\Http\Controllers\Api\MikrotikController@deleteHotspotUser
- Middleware: api, auth:sanctum

## api/mikrotik/hotspot-users/{username}/activate

- Method: POST
- Name: -
- Action: App\Http\Controllers\Api\MikrotikController@activateHotspotUser
- Middleware: api, auth:sanctum

## api/mikrotik/hotspot-users/{username}/suspend

- Method: POST
- Name: -
- Action: App\Http\Controllers\Api\MikrotikController@suspendHotspotUser
- Middleware: api, auth:sanctum

## api/customer/me

- Method: GET|HEAD
- Name: -
- Action: App\Http\Controllers\Api\CustomerAuthController@me
- Middleware: api, auth:sanctum

## api/customer/logout

- Method: POST
- Name: -
- Action: App\Http\Controllers\Api\CustomerAuthController@logout
- Middleware: api, auth:sanctum

## api/customer/profile

- Method: PUT
- Name: -
- Action: App\Http\Controllers\Api\CustomerAuthController@updateProfile
- Middleware: api, auth:sanctum

## api/customer/change-password

- Method: POST
- Name: -
- Action: App\Http\Controllers\Api\CustomerAuthController@changePassword
- Middleware: api, auth:sanctum

## api/customer/dashboard

- Method: GET|HEAD
- Name: -
- Action: App\Http\Controllers\Api\CustomerDashboardController@index
- Middleware: api, auth:sanctum

## api/customer/subscription

- Method: GET|HEAD
- Name: -
- Action: App\Http\Controllers\Api\CustomerSubscriptionController@current
- Middleware: api, auth:sanctum

## api/customer/subscription/renew

- Method: POST
- Name: -
- Action: App\Http\Controllers\Api\CustomerSubscriptionController@renew
- Middleware: api, auth:sanctum

## api/customer/wallet

- Method: GET|HEAD
- Name: -
- Action: App\Http\Controllers\Api\CustomerWalletController@show
- Middleware: api, auth:sanctum

## api/customer/wallet/transactions

- Method: GET|HEAD
- Name: -
- Action: App\Http\Controllers\Api\CustomerWalletController@transactions
- Middleware: api, auth:sanctum

## api/customer/invoices

- Method: GET|HEAD
- Name: -
- Action: App\Http\Controllers\Api\CustomerInvoiceController@index
- Middleware: api, auth:sanctum

## api/customer/invoices/{invoice}

- Method: GET|HEAD
- Name: -
- Action: App\Http\Controllers\Api\CustomerInvoiceController@show
- Middleware: api, auth:sanctum

## api/customer/notifications

- Method: GET|HEAD
- Name: -
- Action: App\Http\Controllers\Api\CustomerNotificationController@index
- Middleware: api, auth:sanctum

## api/customer/notifications/{id}/read

- Method: POST
- Name: -
- Action: App\Http\Controllers\Api\CustomerNotificationController@markAsRead
- Middleware: api, auth:sanctum

## api/customer/notifications/read-all

- Method: POST
- Name: -
- Action: App\Http\Controllers\Api\CustomerNotificationController@markAllAsRead
- Middleware: api, auth:sanctum

## api/customer/tickets/dashboard

- Method: GET|HEAD
- Name: -
- Action: App\Http\Controllers\Api\CustomerTicketController@dashboard
- Middleware: api, auth:sanctum

## api/customer/tickets

- Method: GET|HEAD
- Name: -
- Action: App\Http\Controllers\Api\CustomerTicketController@index
- Middleware: api, auth:sanctum

## api/customer/tickets

- Method: POST
- Name: -
- Action: App\Http\Controllers\Api\CustomerTicketController@store
- Middleware: api, auth:sanctum

## api/customer/tickets/{ticket}

- Method: GET|HEAD
- Name: -
- Action: App\Http\Controllers\Api\CustomerTicketController@show
- Middleware: api, auth:sanctum

## api/customer/tickets/{ticket}/messages

- Method: GET|HEAD
- Name: -
- Action: App\Http\Controllers\Api\CustomerTicketController@messages
- Middleware: api, auth:sanctum

## api/customer/tickets/{ticket}/reply

- Method: POST
- Name: -
- Action: App\Http\Controllers\Api\CustomerTicketController@reply
- Middleware: api, auth:sanctum

## api/customer/tickets/{ticket}/close

- Method: POST
- Name: -
- Action: App\Http\Controllers\Api\CustomerTicketController@close
- Middleware: api, auth:sanctum

## api/network/dhcp/leases

- Method: GET|HEAD
- Name: -
- Action: App\Http\Controllers\Api\MikrotikController@dhcpLeases
- Middleware: api, auth:sanctum

## api/hotspot/online

- Method: GET|HEAD
- Name: -
- Action: App\Http\Controllers\Api\HotspotController@onlineUsers
- Middleware: api

## api/hotspot/stats

- Method: GET|HEAD
- Name: -
- Action: App\Http\Controllers\Api\HotspotController@stats
- Middleware: api

## api/tasks

- Method: GET|HEAD
- Name: tasks.index
- Action: App\Http\Controllers\Api\Task\TaskController@index
- Middleware: api

## api/tasks

- Method: POST
- Name: tasks.store
- Action: App\Http\Controllers\Api\Task\TaskController@store
- Middleware: api

## api/tasks/{task}

- Method: GET|HEAD
- Name: tasks.show
- Action: App\Http\Controllers\Api\Task\TaskController@show
- Middleware: api

## api/tasks/{task}

- Method: PUT|PATCH
- Name: tasks.update
- Action: App\Http\Controllers\Api\Task\TaskController@update
- Middleware: api

## api/tasks/{task}

- Method: DELETE
- Name: tasks.destroy
- Action: App\Http\Controllers\Api\Task\TaskController@destroy
- Middleware: api

## api/mikrotik/advanced/queues

- Method: GET|HEAD
- Name: -
- Action: App\Http\Controllers\Api\MikroTikAdvancedController@getQueues
- Middleware: api, auth:sanctum

## api/mikrotik/advanced/queues

- Method: POST
- Name: -
- Action: App\Http\Controllers\Api\MikroTikAdvancedController@createQueue
- Middleware: api, auth:sanctum

## api/mikrotik/advanced/queues/{name}

- Method: PUT
- Name: -
- Action: App\Http\Controllers\Api\MikroTikAdvancedController@updateQueue
- Middleware: api, auth:sanctum

## api/mikrotik/advanced/queues/{name}

- Method: DELETE
- Name: -
- Action: App\Http\Controllers\Api\MikroTikAdvancedController@deleteQueue
- Middleware: api, auth:sanctum

## api/mikrotik/advanced/queues/{name}/toggle

- Method: POST
- Name: -
- Action: App\Http\Controllers\Api\MikroTikAdvancedController@toggleQueue
- Middleware: api, auth:sanctum

## api/mikrotik/advanced/firewall

- Method: GET|HEAD
- Name: -
- Action: App\Http\Controllers\Api\MikroTikAdvancedController@getFirewallRules
- Middleware: api, auth:sanctum

## api/mikrotik/advanced/firewall

- Method: POST
- Name: -
- Action: App\Http\Controllers\Api\MikroTikAdvancedController@createFirewallRule
- Middleware: api, auth:sanctum

## api/mikrotik/advanced/firewall/{id}

- Method: DELETE
- Name: -
- Action: App\Http\Controllers\Api\MikroTikAdvancedController@deleteFirewallRule
- Middleware: api, auth:sanctum

## api/mikrotik/advanced/nat

- Method: GET|HEAD
- Name: -
- Action: App\Http\Controllers\Api\MikroTikAdvancedController@getNATRules
- Middleware: api, auth:sanctum

## api/mikrotik/advanced/dhcp

- Method: GET|HEAD
- Name: -
- Action: App\Http\Controllers\Api\MikroTikAdvancedController@getDHCPLeases
- Middleware: api, auth:sanctum

## api/mikrotik/advanced/dhcp

- Method: POST
- Name: -
- Action: App\Http\Controllers\Api\MikroTikAdvancedController@addDHCPLease
- Middleware: api, auth:sanctum

## api/mikrotik/advanced/dhcp/{id}

- Method: DELETE
- Name: -
- Action: App\Http\Controllers\Api\MikroTikAdvancedController@deleteDHCPLease
- Middleware: api, auth:sanctum

## /

- Method: GET|HEAD|POST|PUT|PATCH|DELETE|OPTIONS
- Name: -
- Action: \Illuminate\Routing\RedirectController
- Middleware: web

## dashboard

- Method: GET|HEAD
- Name: dashboard
- Action: App\Http\Controllers\Api\DashboardController@index
- Middleware: web

## queues

- Method: GET|HEAD
- Name: queues.index
- Action: App\Http\Controllers\Api\Network\QueueController@index
- Middleware: web

## queues/create

- Method: GET|HEAD
- Name: queues.create
- Action: App\Http\Controllers\Api\Network\QueueController@create
- Middleware: web

## queues

- Method: POST
- Name: queues.store
- Action: App\Http\Controllers\Api\Network\QueueController@store
- Middleware: web

## queues/{name}/toggle

- Method: POST
- Name: queues.toggle
- Action: App\Http\Controllers\Api\Network\QueueController@toggle
- Middleware: web

## queues/{name}

- Method: DELETE
- Name: queues.destroy
- Action: App\Http\Controllers\Api\Network\QueueController@destroy
- Middleware: web

## firewall

- Method: GET|HEAD
- Name: firewall.index
- Action: App\Http\Controllers\Api\Network\FirewallController@index
- Middleware: web

## firewall/create

- Method: GET|HEAD
- Name: firewall.create
- Action: App\Http\Controllers\Api\Network\FirewallController@create
- Middleware: web

## firewall

- Method: POST
- Name: firewall.store
- Action: App\Http\Controllers\Api\Network\FirewallController@store
- Middleware: web

## firewall/{id}

- Method: DELETE
- Name: firewall.destroy
- Action: App\Http\Controllers\Api\Network\FirewallController@destroy
- Middleware: web

## dhcp

- Method: GET|HEAD
- Name: dhcp.index
- Action: App\Http\Controllers\Api\Network\DHCPController@index
- Middleware: web

## dhcp/create

- Method: GET|HEAD
- Name: dhcp.create
- Action: App\Http\Controllers\Api\Network\DHCPController@create
- Middleware: web

## dhcp

- Method: POST
- Name: dhcp.store
- Action: App\Http\Controllers\Api\Network\DHCPController@store
- Middleware: web

## dhcp/{id}

- Method: DELETE
- Name: dhcp.destroy
- Action: App\Http\Controllers\Api\Network\DHCPController@destroy
- Middleware: web

## queues/{name}/edit

- Method: GET|HEAD
- Name: queues.edit
- Action: App\Http\Controllers\Api\Network\QueueController@edit
- Middleware: web

## queues/{name}

- Method: PUT
- Name: queues.update
- Action: App\Http\Controllers\Api\Network\QueueController@update
- Middleware: web

## firewall/{id}/edit

- Method: GET|HEAD
- Name: firewall.edit
- Action: App\Http\Controllers\Api\Network\FirewallController@edit
- Middleware: web

## firewall/{id}

- Method: PUT
- Name: firewall.update
- Action: App\Http\Controllers\Api\Network\FirewallController@update
- Middleware: web

## dhcp/{id}/edit

- Method: GET|HEAD
- Name: dhcp.edit
- Action: App\Http\Controllers\Api\Network\DHCPController@edit
- Middleware: web

## dhcp/{id}

- Method: PUT
- Name: dhcp.update
- Action: App\Http\Controllers\Api\Network\DHCPController@update
- Middleware: web

## customer/login

- Method: GET|HEAD
- Name: customer.login
- Action: App\Http\Controllers\CustomerAuthController@showLoginForm
- Middleware: web

## customer/login

- Method: POST
- Name: customer.login.post
- Action: App\Http\Controllers\CustomerAuthController@login
- Middleware: web

## customer/logout

- Method: POST
- Name: customer.logout
- Action: App\Http\Controllers\CustomerAuthController@logout
- Middleware: web

## customer/dashboard

- Method: GET|HEAD
- Name: customer.dashboard
- Action: App\Http\Controllers\CustomerDashboardController@index
- Middleware: web

## customer/invoices

- Method: GET|HEAD
- Name: customer.invoices
- Action: App\Http\Controllers\CustomerInvoiceController@index
- Middleware: web

## customer/invoices/{id}

- Method: GET|HEAD
- Name: customer.invoice.show
- Action: App\Http\Controllers\CustomerInvoiceController@show
- Middleware: web

## customer/tickets

- Method: GET|HEAD
- Name: customer.tickets
- Action: App\Http\Controllers\CustomerTicketController@index
- Middleware: web

## customer/tickets/create

- Method: GET|HEAD
- Name: customer.ticket.create
- Action: App\Http\Controllers\CustomerTicketController@create
- Middleware: web

## customer/tickets

- Method: POST
- Name: customer.ticket.store
- Action: App\Http\Controllers\CustomerTicketController@store
- Middleware: web

## customer/tickets/{id}

- Method: GET|HEAD
- Name: customer.ticket.show
- Action: App\Http\Controllers\CustomerTicketController@show
- Middleware: web

## customer/tickets/{id}/reply

- Method: POST
- Name: customer.ticket.reply
- Action: App\Http\Controllers\CustomerTicketController@reply
- Middleware: web

## customer/tickets/{id}/close

- Method: POST
- Name: customer.ticket.close
- Action: App\Http\Controllers\CustomerTicketController@close
- Middleware: web

## customer/profile

- Method: GET|HEAD
- Name: customer.profile
- Action: App\Http\Controllers\CustomerProfileController@show
- Middleware: web

## customer/profile

- Method: PUT
- Name: customer.profile.update
- Action: App\Http\Controllers\CustomerProfileController@update
- Middleware: web

## customer/profile/change-password

- Method: POST
- Name: customer.profile.change-password
- Action: App\Http\Controllers\CustomerProfileController@changePassword
- Middleware: web

## broadcasting/auth

- Method: GET|POST|HEAD
- Name: -
- Action: \Illuminate\Broadcasting\BroadcastController@authenticate
- Middleware: web

## storage/{path}

- Method: GET|HEAD
- Name: storage.local
- Action: Closure
- Middleware: 

## storage/{path}

- Method: PUT
- Name: storage.local.upload
- Action: Closure
- Middleware: 
