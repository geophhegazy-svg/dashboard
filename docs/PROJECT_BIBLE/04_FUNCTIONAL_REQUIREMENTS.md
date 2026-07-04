Functional Requirements
Module 1
Authentication
Features
Login
Logout
Remember Me
Password Reset
Change Password
Module 2
Users

يدعم:

CRUD
Roles
Permissions
Module 3
Customers

يدعم:

Create
Update
Delete
Suspend
Search
Pagination
Filters
Module 4
Packages

يدعم:

CRUD
Active
Inactive
Billing Cycle
MikroTik Profile
Module 5
Subscriptions

يدعم:

Create
Activate
Suspend
Restore
Expire
Renew
Link PPPoE
Link Hotspot
Change Package
Module 6
Billing

يدعم:

Generate Invoice
Automatic Billing
Manual Billing
Due Detection
Grace Detection
Expiration Detection
Module 7
Invoice

يدعم:

Create
View
Search
Cancel
Mark Paid
PDF
Module 8
Payments

يدعم:

Cash
Wallet
Bank
Online (Future)
Module 9
Wallet

يدعم:

Deposit
Withdraw
Transactions
Balance
Module 10
Notifications

يدعم:

SMS
Email
WhatsApp
Dashboard
Module 11
MikroTik

يدعم حالياً:

PPPoE
List
Find
Create
Delete
Enable
Disable
Hotspot
List
Active Users
Find
Create
Delete
Enable
Disable
DHCP
Lease List
Generic
Raw Commands
Execute Query
Module 12
Dashboard

يعرض:

عدد العملاء.
عدد الاشتراكات.
العملاء النشطين.
الاشتراكات المنتهية.
إجمالي الإيرادات.
عدد الفواتير.
عدد المدفوعات.
Module 13
Activity Log

يسجل:

Login
Logout
CRUD
Renew
Suspend
Payments
Billing
Wallet
Module 14
Reports (Future)
Revenue Report
Customers Report
Payments Report
Packages Report
Expired Report
Due Report
Module 15
Inventory (Future)
Devices
Warehouses
Suppliers
Purchases
Transfers
16. Billing Module (Enterprise Design)
الهدف

Billing هو قلب النظام بالكامل.

لا يوجد أي جزء في النظام يقوم بحساب الاشتراكات أو الفواتير إلا من خلال Billing Engine.

جميع الخدمات الأخرى تعتمد عليه.

Architecture
Subscription
      │
      │
      ▼
BillingEngine
      │
      ├─────────────── Calculate Status
      │
      ├─────────────── Calculate Due Date
      │
      ├─────────────── Grace Period
      │
      ├─────────────── Expired
      │
      └─────────────── Suspension Decision
               │
               ▼
AutomaticBillingService
               │
               ▼
InvoiceGenerator
               │
               ▼
Invoice
BillingEngine

مسؤول عن الحسابات فقط.

لا يقوم بالحفظ داخل قاعدة البيانات.

لا يقوم بإرسال Notifications.

لا يقوم بتعديل الاشتراك.

Pure Business Logic فقط.

Responsibilities

Calculate Next Due Date

Determine Status

Determine Grace

Determine Expired

Determine Auto Suspend

Determine Auto Expire

BillingStatus Enum
ACTIVE

DUE

GRACE

EXPIRED

لا يتم استخدام Strings داخل الكود.

AutomaticBillingService

هذه الخدمة هي Orchestrator.

هى التى تعمل داخل Scheduler.

مثال

every minute

↓

Fetch Due Subscriptions

↓

BillingEngine

↓

Generate Invoice

↓

Suspend

↓

Notify

↓

Log Activity
InvoiceGenerator

هذه الخدمة مسؤولة عن إنشاء الفاتورة فقط.

لا تقوم بالتحصيل.

لا تقوم بالإشعارات.

لا تقوم بتغيير حالة الاشتراك.

Responsibilities

Generate Invoice Number

Copy Package Price

Copy Customer

Copy Subscription

Set Due Date

Status = Pending

Invoice Number Strategy
INV-000001

INV-000002

INV-000003

عن طريق

InvoiceNumberService
Duplicate Protection

قبل إنشاء فاتورة

يتم التأكد من عدم وجود فاتورة Pending لنفس الاشتراك.

subscription_id

status = pending

إذا وجدت

Return Existing

أو

Throw Exception

حسب السيناريو.

Billing Cycle

Supported

Daily

Weekly

Monthly

Yearly
Grace Period

يتم حسابها من

Package

or

Subscription
Billing Flow
Subscription

↓

BillingEngine

↓

Status

↓

AutomaticBillingService

↓

InvoiceGenerator

↓

Notification

↓

Activity Log

↓

MikroTik Suspend
17. MikroTik Module

Architecture

Controller

↓

Service

↓

Connection

↓

RouterOS API
MikrotikConnection

وظيفته

فتح الاتصال فقط.

MikrotikService

كل Business Operations.

PPPoE

Create

Delete

Enable

Disable

Find

List

Update

Hotspot

Create

Delete

Enable

Disable

Find

List

DHCP

List Leases

Generic

Run Query

Raw Command

ممنوع

ممنوع استخدام RouterOS Client داخل Controller.

دائماً

Controller

↓

Service

↓

Connection
Subscription Flow
Activate

↓

Enable PPPoE

↓

Update Status

↓

Activity Log

↓

Dispatch Event
Suspend

↓

Disable PPPoE

↓

Update Status

↓

Notification

↓

Activity
Renew

↓

Invoice

↓

Payment

↓

Wallet

↓

New End Date

↓

Activity

↓

Notification
Repository Layer

Repositories مسئولة عن Database فقط.

لا يوجد Business Logic.

Example

SubscriptionRepository

↓

find()

save()

delete()

usernameExists()

linkedPppoeUsers()

updatePppoe()

expiringSubscriptions()
Service Layer

كل Business Rules هنا.

مثال

SubscriptionService

BillingService

DashboardService

WalletService

PaymentService

InvoiceService
Actions

كل عملية كبيرة تصبح Action مستقلة.

مثل

ActivateSubscriptionAction

SuspendSubscriptionAction

RestoreSubscriptionAction

ExpireSubscriptionAction

RenewSubscriptionAction

ميزة ذلك

Single Responsibility

Testing

Reuse

Dependency Injection Rule

ممنوع

new Service()

دائماً

Constructor Injection
Interface Rule

كل Service لها Interface إذا كانت ستستخدم خارج نطاقها.

مثل

MikrotikServiceInterface

Repositories أيضاً Interfaces.

Current Test Status

حتى الآن المشروع يحقق:

أكثر من 60 اختبارًا ناجحًا (Unit + Feature).
جميع الاختبارات الحالية تمر بنسبة 100%.
تغطية ممتازة لخدمات الاشتراكات، الفوترة، المحافظ، الإشعارات، ولوحة التحكم.
تم إدخال طبقة Repository وActions مع الحفاظ على نجاح الاختبارات.
23. Billing Module

يعتبر نظام الفوترة هو القلب الحقيقي لنظام EgyptNet ISP، ولذلك تم تصميمه ليكون مستقلاً عن واجهات المستخدم وقابلاً للتطوير ليشمل جميع أنواع الاشتراكات.

الأهداف
إنشاء الفواتير تلقائياً.
دعم أكثر من دورة محاسبية.
منع إنشاء فواتير مكررة.
دعم Wallet.
دعم التجديد التلقائي.
دعم الإيقاف التلقائي.
دعم الانتهاء التلقائي.
دعم أكثر من طريقة دفع.
قابل للتوسع مستقبلاً.
Billing Components
BillingEngine

مسؤول عن حساب:

Due Date
Grace Period
Billing Status
InvoiceGenerator

مسؤول عن

Subscription
↓

Invoice
AutomaticBillingService

يقوم يومياً بـ

Find Due Subscriptions

↓

Generate Invoice

↓

Create Notification

↓

Create Activity

↓

Send Events
InvoiceService

CRUD

PaymentService

إضافة المدفوعات

WalletService

خصم

إضافة

تحويل

Billing Flow
Subscription

↓

BillingEngine

↓

InvoiceGenerator

↓

Invoice

↓

Payment

↓

Renew

↓

Activity Log

↓

Notification
Invoice Status
pending

paid

cancelled

overdue
Billing Status
ACTIVE

DUE

GRACE

EXPIRED
Billing Cycle
daily

weekly

monthly

yearly
Grace Period
Package

↓

grace_days

↓

BillingEngine
Automatic Renewal
Invoice Paid

↓

Renew Subscription

↓

Update End Date

↓

Enable PPPoE

↓

Activity

↓

Notification
Automatic Suspension
Invoice Overdue

↓

Grace Finished

↓

Suspend Subscription

↓

Disable PPPoE
Automatic Expiration
Suspended

↓

Expire

↓

Archive
Billing Design Principles

لا يوجد Controller يحسب الفواتير.

لا يوجد Model يحسب الفواتير.

كل الحسابات داخل Billing Services.

24. MikroTik Module

هذه الوحدة مسؤولة عن التكامل الكامل مع RouterOS.

Components
MikrotikConnection

يتعامل مع الاتصال.

MikrotikService

يتعامل مع جميع أوامر RouterOS.

PPPoE
Create

Delete

Enable

Disable

Find

List
Hotspot
Create

Delete

Enable

Disable

List

Active
DHCP
List Leases
Generic Commands
run()

raw()
RouterOS API

يعتمد المشروع على

evilfreelancer/routeros-api-php
Design Rules

لا يستخدم Controller RouterOS مباشرة.

لا تستخدم Action RouterOS مباشرة.

الطبقة الوحيدة المسموح لها هي

MikrotikService
Future Features

Queue Tree

Simple Queue

IP Binding

Radius

PPP Profiles

Firewall

Address Lists

Scheduler

Scripts

Logs

Traffic Graphs

Interface Monitoring

OLT Integration

25. Authentication

يعتمد المشروع على

Laravel Sanctum
Authentication Flow
Login

↓

Token

↓

API

↓

Middleware

↓

Policies
Future

OTP Login

SMS Login

Two Factor Authentication

Remember Devices

Refresh Tokens

Multiple Sessions

26. Authorization

يعتمد المشروع على

spatie/laravel-permission
Current Roles
Super Admin

Admin

Employee
Future Roles
Cashier

Support

Technician

Sales

Manager

Accountant

Auditor

Owner
Permission Strategy

كل Controller يستخدم

authorize()

أو

Policies

ولا يتم فحص الصلاحيات يدوياً داخل الخدمات.

Future Policies

CustomerPolicy

SubscriptionPolicy

InvoicePolicy

PaymentPolicy

WalletPolicy

PackagePolicy

TenantPolicy

MikrotikPolicy



PaymentServiceTest

DashboardServiceTest

NotificationServiceTest

كل Action لها Unit Test.

كل Repository له Test.

كل Billing Rule لها Test.

39. FEATURE TEST STRATEGY

كل Endpoint له Feature Test.

GET

POST

PUT

DELETE

PATCH

كل Authorization له Test.

كل Validation له Test.

كل API Error له Test.

31. Development Workflow

المشروع لا يتم تطويره بطريقة عشوائية.

كل Feature تمر بنفس دورة الحياة.

Requirement

↓

Analysis

↓

Architecture

↓

Database

↓

Models

↓

Repository

↓

Service

↓

Actions

↓

Events

↓

Notifications

↓

Controllers

↓

Requests

↓

Resources

↓

Tests

↓

Documentation

↓

Review
قاعدة ذهبية

لا يتم إنشاء Controller قبل وجود Service.

لا يتم إنشاء Service قبل Repository.

لا يتم إنشاء Repository قبل Interface.

ولا يتم إنشاء أي Feature بدون Tests.

Example Workflow

مثال:

إضافة Wallet Transfer

الترتيب يكون

Migration

↓

Model

↓

Repository Interface

↓

Repository

↓

Service

↓

Actions

↓

Event

↓

Notification

↓

API

↓

Tests

↓

Documentation
Git Workflow
main

↓

develop

↓

feature/*

مثال

feature/wallet

feature/invoices

feature/mikrotik

feature/dashboard

كل Feature لها Pull Request منفصل.

Commit Convention
feat:

fix:

refactor:

test:

docs:

style:

perf:

chore:

مثال

feat(invoice): add automatic invoice generation

fix(wallet): prevent negative balance

refactor(subscription): move activation logic to Action

test(billing): add BillingEngine tests
Code Review Checklist

قبل الدمج يجب التأكد من:

✓ جميع الاختبارات ناجحة

✓ لا يوجد Duplication

✓ Repository مستخدم

✓ Service نظيف

✓ Action صغير

✓ Controller صغير

✓ Validation داخل Request

✓ لا يوجد Business Logic داخل Controller

✓ Naming صحيح

✓ لا يوجد Dead Code

Testing Strategy

كل Feature جديدة يجب أن تحتوي على

Unit Tests

+

Feature Tests

مثال

Invoice

InvoiceGeneratorTest

InvoiceServiceTest

InvoiceControllerTest
CI Pipeline

كل Push يجب أن ينفذ

composer install

↓

php artisan migrate --env=testing

↓

php artisan test

↓

phpstan

↓

pint

↓

build docker

أي Failure يمنع الدمج.

Versioning Strategy

Semantic Versioning

v1.0

↓

v1.1

↓

v1.2

↓

v2.0
Release Workflow
develop

↓

staging

↓

production
Backup Strategy

قبل كل Release

Database Backup

+

Storage Backup

+

RouterOS Backup

+

Configuration Backup
Rollback Strategy

إذا فشل Deployment

Rollback Code

↓

Rollback Database

↓

Restart Queue

↓

Restart Reverb

↓

Restart Scheduler
Monitoring

بعد كل Deployment يتم متابعة

CPU

RAM

Queue

Logs

MikroTik

Database

Redis

Broadcast

API Response Time
Health Check Endpoints
/health

/api/status

/api/version

/api/mikrotik/status

/api/database/status

/api/cache/status
Project Metrics

يتم قياس

عدد العملاء

عدد الاشتراكات

عدد الفواتير

عدد المدفوعات

إجمالي الإيرادات

الإيراد الشهري

الإيراد السنوي

Average Revenue Per User

Renewal Rate

Suspension Rate

Expiration Rate

Collection Rate
Performance Targets

API

<150 ms

Dashboard

<300 ms

Invoice Generation

<100 ms

Wallet

<50 ms

MikroTik Operations

<500 ms
Quality Gates

لن تعتبر Feature منتهية إلا إذا حققت

✓ Tests Passed

✓ PHPStan Passed

✓ Pint Passed

✓ No Duplicate Code

✓ Repository Pattern

✓ Service Layer

✓ Action Layer

✓ Events

✓ Activity Log

✓ Documentation Updated
Enterprise Principles

المشروع يلتزم بالمبادئ التالية:

SOLID
DRY
KISS
Clean Code
Clean Architecture
Domain Driven Design (DDD)
Repository Pattern
Action Pattern
Event-Driven Architecture
Dependency Injection
Interface Segregation
Single Responsibility Principle
Final Rule

أي تعديل جديد يجب أن يجيب على الأسئلة التالية:

هل يحافظ على المعمارية الحالية؟
هل يوجد له Tests؟
هل يضيف منطقًا داخل الـ Service أو Action وليس Controller؟
هل يستخدم Repository بدلاً من الوصول المباشر إلى الـ Model؟
هل يسجل Activity Log عند الحاجة؟
هل يمكن توسيعه مستقبلاً دون كسر الكود الحالي؟
هل يتوافق مع معايير المشروع في التسمية والتنظيم؟

الفصل 25
Coding Standards (Enterprise)
PHP
PHP 8.4
strict_types=1 دائماً
Typed Properties فقط
Constructor Property Promotion
readonly whenever possible
Return Types mandatory
Nullable فقط عند الحاجة
Laravel

عدم استخدام Facades داخل Domain.

يفضل Dependency Injection.

مثال

بدلاً من

Invoice::create(...)

يستخدم

InvoiceRepositoryInterface
Service Rules

Service

لا يحتوى SQL

لا يحتوى Validation

لا يحتوى HTTP

هو فقط Orchestrator.

Repository Rules

Repository مسؤول عن

Database
Query Builder
Eloquent

ولا يحتوى Business Logic.

Action Rules

كل Action مسئول عن عملية واحدة.

مثال

ActivateSubscriptionAction

SuspendSubscriptionAction

RenewSubscriptionAction

ExpireSubscriptionAction

RestoreSubscriptionAction
Controller Rules

Controller لا يزيد عن 30-50 سطر.

كل Controller:

Validate

Call Service

Return Resource

ولا شيء آخر.

Request Rules

كل Validation داخل FormRequest.

ممنوع كتابة

$request->validate(...)

داخل Controller.

Resource Rules

كل Response يخرج بواسطة

JsonResource

وليس

return response()->json(...)

إلا فى الحالات الخاصة.

Events

كل Event يحمل Data فقط.

ولا يحتوى Logic.

Jobs

كل Job قابلة لإعادة التنفيذ.

Idempotent.

Notifications

Notifications لا ترسل مباشرة.

بل عن طريق Queue.

DTO Future

سيتم استخدام DTOs بين

Controller

Service

Repository

فى Version 3.

الفصل 26
Error Handling Strategy

كل Exception يكون Typed.

مثال

SubscriptionAlreadyExpiredException

WalletBalanceException

InvoiceAlreadyPaidException

PackageNotFoundException

ممنوع

throw new Exception(...)

كل Exception يحتوى

Message

Code

Context

API ترجع

status

message

errors

trace (debug only)

Validation Errors

HTTP 422

Unauthorized

401

Forbidden

403

Not Found

404

Server Error

500

الفصل 27
Logging Strategy

يستخدم

Activity Log

لكل العمليات المهمة.

يسجل

Login

Logout

Invoice Created

Payment

Renew

Suspend

Restore

Delete

Update

Wallet

MikroTik

كل Log يحتوى

tenant

user

ip

browser

model

event

old values

new values


Logs لا يتم حذفها.

Audit Trail دائم.

الفصل 28
Security Rules

عدم استخدام

Mass Assignment

إلا مع fillable.

كل Password

Hash.

Sanctum Tokens.

CSRF للويب.

API Rate Limit.

Authorization قبل تنفيذ أى Action.

Tenant Isolation.

عدم إظهار Stack Trace فى Production.

كل File Upload يتم فحصه.

Validation لكل Input.

No Raw SQL.

Prepared Statements فقط.

الفصل 29
API Standards

RESTful.

Endpoints

GET

POST

PUT

PATCH

DELETE

Response

success

message

data

meta

Pagination

current_page

per_page

total

last_page

Filtering

?status=

?tenant=

?customer=

Sorting

sort=name

sort=-created_at

Searching

?q=

Versioning

/api/v1

وسيضاف

v2

لاحقًا.

الفصل 30
Definition of Done (DoD)

أى Feature لا تعتبر مكتملة إلا إذا حققت جميع الشروط التالية:

تعمل وظيفيًا كما هو مطلوب.
تتبع معمارية المشروع (Repository → Service → Action).
لا تحتوي على تكرار في الكود.
تستخدم Dependency Injection.
تحتوي على Unit Tests عند الحاجة.
تحتوي على Feature Tests إذا كانت API أو Controller.
تمر جميع الاختبارات (php artisan test).
لا تكسر أي جزء موجود من النظام.
تتوافق مع معايير التسمية والهيكلة.
موثقة داخل Project Bible إذا كانت تضيف مكونًا معماريًا جديدًا.



invoice_number

phone

email
29. Docker Architecture

الحاويات الحالية

Laravel

PHP

Nginx

MariaDB

Redis

Node

Mailpit

وسيتم إضافة

Queue Worker

Scheduler

Prometheus

Grafana

MinIO
30. Environment Variables
APP_NAME

APP_ENV

APP_KEY

APP_URL

DB_HOST

DB_DATABASE

DB_USERNAME

DB_PASSWORD

REDIS_HOST

QUEUE_CONNECTION

MAIL_HOST

MIKROTIK_HOST

MIKROTIK_USERNAME

MIKROTIK_PASSWORD

MIKROTIK_PORT
31. AI Development Rules

أي نموذج ذكاء اصطناعي يعمل على المشروع يجب أن يلتزم بما يلي:

لا يغير المعمارية الحالية.
لا يحذف كود يعمل بالفعل.
يبدأ بالاختبارات (TDD) قبل تنفيذ أي Feature.
يستخدم Repository Pattern وService Layer وActions.
لا يضع منطق الأعمال داخل Controllers أو Models.
يحافظ على التوافق مع Laravel 13 وPHP 8.4.
لا يكسر الاختبارات الموجودة، ويجب أن تظل جميعها ناجحة بعد أي تعديل.

29. Docker Architecture
Philosophy

يجب أن يكون المشروع قابلاً للعمل بالكامل داخل Docker بدون الحاجة لتثبيت أي شيء على الجهاز المضيف باستثناء Docker وDocker Compose.

Host Machine
      │
      ▼
Docker Compose
      │
      ├────────────── nginx
      │
      ├────────────── php-fpm
      │
      ├────────────── mysql
      │
      ├────────────── redis
      │
      ├────────────── queue-worker
      │
      ├────────────── scheduler
      │
      └────────────── reverb
Containers
PHP

Responsibilities

Laravel
Artisan
Queue
Scheduler
Nginx

Responsibilities

HTTP
HTTPS
Static Files
MySQL

Responsibilities

Primary Database

Redis

Responsibilities

Queue
Cache
Session
Queue Worker

Runs

php artisan queue:work
Scheduler

Runs

php artisan schedule:work
Reverb

Runs

php artisan reverb:start
30. Deployment

Deployment Steps

git pull

composer install --no-dev

php artisan migrate --force

php artisan optimize

php artisan config:cache

php artisan route:cache

php artisan view:cache

php artisan queue:restart

Rollback

git checkout previous-tag

php artisan migrate:rollback

php artisan optimize
31. Environment Variables

Required

APP_NAME

APP_ENV

APP_KEY

APP_URL

DB_HOST

DB_DATABASE

DB_USERNAME

DB_PASSWORD

REDIS_HOST

QUEUE_CONNECTION

CACHE_STORE

MAIL_HOST

MAIL_USERNAME

MAIL_PASSWORD

MIKROTIK_HOST

MIKROTIK_USERNAME

MIKROTIK_PASSWORD

MIKROTIK_PORT

Never Commit

.env
32. Coding Standards

PSR-12

Strict Types

Constructor Injection

No Facades inside Services

No Business Logic inside Controllers

Repositories only access database

Actions perform one operation only

Services orchestrate Actions

Formatting

Always

declare(strict_types=1);

Always

readonly

Never

new Service()

Always DI.

33. Naming Conventions

Services

InvoiceService

Repositories

InvoiceRepository

Interfaces

InvoiceRepositoryInterface

Actions

CreateInvoiceAction

Requests

StoreInvoiceRequest

Controllers

InvoiceController

Policies

InvoicePolicy

Jobs

GenerateInvoicesJob

Events

InvoiceCreated

Listeners

SendInvoiceNotification
34. Error Handling

Never

catch(Exception){

}

Always

catch(Throwable $e){

Log::error()

throw $e;

}

Validation Errors

ValidationException

Business Errors

DomainException

Authorization

AuthorizationException
35. Logging Strategy

Use

Spatie Activity Log

For

Customer

Subscription

Invoice

Payment

Wallet

Package

MikroTik

Authentication

Settings

Every important action

must be logged.

Example

Customer Updated

Old Value

New Value

User

Date

IP

Tenant
36. Security Rules

Never trust request data.

Always validate.

Always authorize.

Always sanitize.

Passwords

Hash::make()

Tokens

Sanctum

CSRF enabled

Rate Limit

Enabled

Audit

Enabled

Activity Log

Enabled

Soft Delete

When applicable.

37. API Standards

Base

/api/v1/

Success

{
    success:true,
    data:{}
}

Error

{
    success:false,
    message:"",
    errors:[]
}

Pagination

data

links

meta

HTTP Codes

200

201

204

400

401

403

404

422

500
38. Roadmap
Version 1

Foundation

✅ Done

Version 2

Billing

70%

Version 3

CRM

Not Started

Version 4

Automation

Not Started

Version 5

Enterprise

Not Started

39. Current Progress

Completed

✔ Docker

✔ Laravel

✔ Authentication

✔ Roles

✔ Permissions

✔ Packages

✔ Customers

✔ Subscriptions

✔ PPPoE

✔ Hotspot

✔ Wallet

✔ Payments

✔ Billing Engine

✔ Billing Status

✔ Invoice Service

✔ Invoice Generator

✔ Dashboard

✔ Notifications

✔ Activity Log

✔ Repository Pattern

✔ Actions Pattern

✔ Events

✔ Unit Tests

✔ Feature Tests

Current Tests

62+

Passing

Architecture Stability

Very High

40. Next Milestones

Priority 1

Automatic Billing Service

Priority 2

Invoice Scheduler

Priority 3

Auto Suspension

Priority 4

Auto Expiration

Priority 5

Auto Renewal

Priority 6

Wallet Auto Payment

Priority 7

PDF Invoice

Priority 8

SMS

Priority 9

WhatsApp

Priority 10

Email Templates

41. Future Modules

بعد الانتهاء من النواة الأساسية (Core System)، سيتم تنفيذ الوحدات التالية تدريجياً دون كسر المعمارية الحالية.

41.1 CRM Module

يتضمن:

Leads
Opportunities
Follow-up
Sales Pipeline
Customer Notes
Customer History
Tickets
Contracts
41.2 Inventory Module

إدارة:

Routers
ONU
Fiber
Cables
Switches
Access Points
Spare Parts

مع دعم:

Barcode
QR Code
Stock Movement
Purchase Orders
41.3 Help Desk

يتضمن:

Tickets
Categories
SLA
Priorities
Assignment
Internal Notes
Attachments
41.4 SMS Gateway

دعم:

Vodafone
Etisalat
Twilio
SMPP

للإرسال:

Invoice Reminder
Renewal Reminder
Suspension Notice
OTP
41.5 WhatsApp Gateway

Notifications

Renewals

Invoices

Suspensions

OTP

Marketing

41.6 Email Module

Templates

Layouts

SMTP

Queues

Attachments

PDF Invoice

41.7 PDF Engine

إنتاج

Invoice PDF

Receipt

Contract

Customer Statement

Wallet Statement

41.8 Reporting Engine

تقارير:

Revenue

Customers

Subscriptions

Packages

Sales

Wallet

Payments

Invoices

Taxes

Growth

Cancellation Rate

41.9 Analytics Dashboard

Charts

KPIs

MRR

ARR

Revenue

Cash Flow

Growth

Customer Lifetime

Average Revenue

41.10 Finance Module

Expenses

Income

General Ledger

Journal

Cost Centers

Taxes

Profit & Loss

Balance Sheet

41.11 Accounting Integration

QuickBooks

Odoo

ERPNext

SAP

41.12 Mobile API

Android

iOS

Flutter

React Native

41.13 Customer Portal

Customer Login

Invoices

Payments

Wallet

Profile

Renewal

Tickets

41.14 Employee Portal

Attendance

Tasks

Tickets

Sales

Reports

41.15 Multi MikroTik Cluster

Support

Unlimited Routers

Automatic Selection

Router Groups

Load Distribution

Synchronization

42. Definition of Done

أي ميزة جديدة لا تعتبر مكتملة إلا إذا حققت جميع الشروط التالية.

Code

✓ Clean

✓ Typed

✓ PSR12

✓ SOLID

✓ DRY

✓ KISS

Tests

كل ميزة يجب أن تحتوي على:

Unit Tests

Feature Tests

Edge Cases

Failure Cases

Validation Tests

Authorization Tests

Documentation

كل Service

كل Repository

كل Interface

كل Action

موثق.

Security

Validation

Authorization

Logging

Audit

Performance

لا يوجد

N+1

ولا Queries زائدة.

Review

Code Review

Architecture Review

Test Review

Ready

الميزة جاهزة للإنتاج.

43. AI Instructions

هذا القسم هو الأهم عند استخدام أي نموذج ذكاء اصطناعي.

Rule 1

لا تقم أبداً بإعادة كتابة المشروع.

Rule 2

لا تغير المعمارية الحالية.

Rule 3

لا تنقل الملفات دون سبب.

Rule 4

لا تكسر الاختبارات الحالية.

Rule 5

أي كود جديد يجب أن يمر بجميع الاختبارات.

Rule 6

ابدأ دائماً من الكود الحالي.

ولا تقترح مشروعاً جديداً.

Rule 7

لا تستخدم حلولاً سريعة.

Always Enterprise.

Rule 8

لا تضع Business Logic داخل Controller.

Rule 9

لا تستخدم Facades داخل Services إذا كان يمكن استخدام Dependency Injection.

Rule 10

لا تستخدم Model مباشرة إذا كان Repository موجوداً.

Rule 11

Action = عملية واحدة فقط.

Rule 12

Service = Orchestrator فقط.

Rule 13

Repository = Database Only.

Rule 14

Controller = HTTP فقط.

Rule 15

كل Feature جديدة يجب أن تبدأ بالاختبارات.

TDD First.

Rule 16

أي تعديل يجب ألا يقلل نسبة الاختبارات.

Rule 17

أي تغيير في قاعدة البيانات يجب أن يكون Migration.

Rule 18

أي API جديد يجب أن يستخدم:

Request

Resource

Policy

Validation

Activity Log

Rule 19

أي Service جديد يجب أن يكون قابلاً للاختبار.

Rule 20

أي AI يعمل على المشروع يجب أن يقرأ هذا الملف بالكامل أولاً.

44. Rules That Must Never Be Broken

هذه قواعد ثابتة.

كسر أي قاعدة يعتبر خطأ معماري.

ممنوع

Business Logic داخل Controller

ممنوع

Raw SQL بدون داع.

ممنوع

Duplicate Code

ممنوع

Static Helpers لكل شيء.

ممنوع

God Service

ممنوع

God Controller

ممنوع

Repository يحتوي Business Logic

ممنوع

Action يستدعي Action آخر.

ممنوع

Repository يستدعي Service.

ممنوع

Circular Dependency.

ممنوع

Hardcoded Configuration.

ممنوع

Hardcoded MikroTik Data.

ممنوع

تعديل Tests لتناسب الكود.

الصحيح:

عدل الكود ليمر بالاختبارات.

ممنوع

Skipping Validation.

ممنوع

Skipping Authorization.

ممنوع

Skipping Activity Log.

ممنوع

Ignoring Exceptions.

ممنوع

Silent Catch.

ممنوع

كسر التوافق مع الإصدارات السابقة دون Migration واضحة.

45. Complete Development Roadmap (v1.0 → v5.0)
Version 1.0 — Foundation ✅

تم إنجازه بشكل كبير.

يشمل:

Docker Environment
Laravel 13
Authentication
Authorization
Roles & Permissions
Tenants
Customers
Packages
PPPoE
Hotspot
Wallet
Payments
Invoices
Notifications
Activity Log
Dashboard
Subscription Actions
Repository Pattern
Action Pattern
Unit Tests
Feature Tests

الحالة: ≈ 90–95%

Version 2.0 — Billing Automation 🚧

يشمل:

AutomaticBillingService
InvoiceGenerator
Billing Engine
Billing Scheduler
Grace Period Automation
Auto Suspension
Auto Expiration
Auto Renewal
Wallet Auto Deduction
Retry Policies
Billing Reports
Billing Notifications
PDF Invoice Generation

الحالة الحالية: قيد التنفيذ

Version 3.0 — CRM & Customer Experience

يشمل:

CRM
Customer Portal
Ticketing System
Email Templates
WhatsApp Integration
SMS Gateway
Customer Timeline
Contracts
Sales Pipeline
Lead Management
Customer Analytics
Version 4.0 — Operations & Network

يشمل:

Inventory
Fiber Management
ONU Management
Switch Management
Multi-Router Management
Router Clustering
Auto Provisioning
Network Monitoring
Radius Integration
Backup & Restore
SNMP Monitoring
Network Maps
Version 5.0 — Enterprise Platform

يشمل:

Accounting
Finance
HR
Payroll
BI Dashboards
AI Assistant
Predictive Billing
Forecasting
Multi-Company
Multi-Country
Localization
Plugin System
Public API
SDK
High Availability
Horizontal Scaling
Kubernetes Deployment
Microservices Readiness
خاتمة (Official Project Statement)

EgyptNet ISP Management System هو نظام ERP/OSS/BSS احترافي لإدارة مزودي خدمة الإنترنت (ISP)، مبني باستخدام Laravel 13 + PHP 8.4 + Docker + MikroTik RouterOS API وفق مبادئ Clean Architecture وSOLID وDDD-inspired Architecture.

يعتمد المشروع على:

Repository Pattern
Service Layer
Action Pattern
Dependency Injection
Event-Driven Design
Comprehensive Testing (TDD)
Activity Logging
قابلية التوسع المؤسسي (Enterprise Scalability)

ويُعتبر هذا الدليل (Project Bible) المرجع الرسمي الوحيد للمشروع، ويجب أن يلتزم به أي مطور أو أي نموذج ذكاء اصطناعي يعمل على تطوير النظام، مع الحفاظ على المعمارية الحالية وعدم كسر التوافق أو الاختبارات، واتباع خارطة الطريق من الإصدار v1.0 حتى v5.0.


