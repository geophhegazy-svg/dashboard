# Database

## activity_log

**Rows:** 0

### Columns

- id (bigint)
- log_name (varchar) nullable
- description (text)
- subject_type (varchar) nullable
- subject_id (bigint) nullable
- event (varchar) nullable
- causer_type (varchar) nullable
- causer_id (bigint) nullable
- attribute_changes (json) nullable
- properties (json) nullable
- created_at (timestamp) nullable
- updated_at (timestamp) nullable

## activity_log

**Rows:** 0

### Columns

- id (bigint)
- log_name (varchar) nullable
- description (text)
- subject_type (varchar) nullable
- subject_id (bigint) nullable
- event (varchar) nullable
- causer_type (varchar) nullable
- causer_id (bigint) nullable
- attribute_changes (json) nullable
- properties (json) nullable
- created_at (timestamp) nullable
- updated_at (timestamp) nullable

## activity_logs

**Rows:** 0

### Columns

- id (bigint)
- tenant_id (bigint)
- user_id (bigint) nullable
- module (varchar)
- action (varchar)
- description (text)
- ip_address (varchar) nullable
- created_at (timestamp) nullable
- updated_at (timestamp) nullable

## activity_logs

**Rows:** 0

### Columns

- id (bigint)
- tenant_id (bigint)
- user_id (bigint) nullable
- module (varchar)
- action (varchar)
- description (text)
- ip_address (varchar) nullable
- created_at (timestamp) nullable
- updated_at (timestamp) nullable

## cache

**Rows:** 0

### Columns

- key (varchar)
- value (mediumtext)
- expiration (bigint)

## cache

**Rows:** 0

### Columns

- key (varchar)
- value (mediumtext)
- expiration (bigint)

## cache_locks

**Rows:** 0

### Columns

- key (varchar)
- owner (varchar)
- expiration (bigint)

## cache_locks

**Rows:** 0

### Columns

- key (varchar)
- owner (varchar)
- expiration (bigint)

## customers

**Rows:** 0

### Columns

- id (bigint)
- tenant_id (bigint)
- name (varchar)
- phone (varchar)
- email (varchar) nullable
- password (varchar) nullable
- address (varchar) nullable
- national_id (varchar) nullable
- status (enum) default=active
- notes (text) nullable
- created_at (timestamp) nullable
- updated_at (timestamp) nullable
- remember_token (varchar) nullable

## customers

**Rows:** 0

### Columns

- id (bigint)
- tenant_id (bigint)
- name (varchar)
- phone (varchar)
- email (varchar) nullable
- password (varchar) nullable
- address (varchar) nullable
- national_id (varchar) nullable
- status (enum) default=active
- notes (text) nullable
- created_at (timestamp) nullable
- updated_at (timestamp) nullable
- remember_token (varchar) nullable

## device_assignments

**Rows:** 0

### Columns

- id (bigint)
- tenant_id (bigint)
- customer_id (bigint)
- device_id (bigint)
- assigned_at (timestamp)
- returned_at (timestamp) nullable
- status (enum) default=assigned
- notes (text) nullable
- created_at (timestamp) nullable
- updated_at (timestamp) nullable

## device_assignments

**Rows:** 0

### Columns

- id (bigint)
- tenant_id (bigint)
- customer_id (bigint)
- device_id (bigint)
- assigned_at (timestamp)
- returned_at (timestamp) nullable
- status (enum) default=assigned
- notes (text) nullable
- created_at (timestamp) nullable
- updated_at (timestamp) nullable

## devices

**Rows:** 0

### Columns

- id (bigint)
- tenant_id (bigint)
- customer_id (bigint) nullable
- device_type (enum)
- brand (varchar)
- model (varchar) nullable
- serial_number (varchar) nullable
- mac_address (varchar) nullable
- ip_address (varchar) nullable
- status (enum) default=active
- notes (text) nullable
- created_at (timestamp) nullable
- updated_at (timestamp) nullable

## devices

**Rows:** 0

### Columns

- id (bigint)
- tenant_id (bigint)
- customer_id (bigint) nullable
- device_type (enum)
- brand (varchar)
- model (varchar) nullable
- serial_number (varchar) nullable
- mac_address (varchar) nullable
- ip_address (varchar) nullable
- status (enum) default=active
- notes (text) nullable
- created_at (timestamp) nullable
- updated_at (timestamp) nullable

## failed_jobs

**Rows:** 0

### Columns

- id (bigint)
- uuid (varchar)
- connection (varchar)
- queue (varchar)
- payload (longtext)
- exception (longtext)
- failed_at (timestamp) default=CURRENT_TIMESTAMP

## failed_jobs

**Rows:** 0

### Columns

- id (bigint)
- uuid (varchar)
- connection (varchar)
- queue (varchar)
- payload (longtext)
- exception (longtext)
- failed_at (timestamp) default=CURRENT_TIMESTAMP

## hotspot_subscriptions

**Rows:** 0

### Columns

- id (bigint)
- tenant_id (bigint)
- customer_id (bigint)
- package_id (bigint)
- hotspot_username (varchar)
- hotspot_password (varchar)
- mikrotik_profile (varchar) default=default
- start_date (date)
- end_date (date)
- monthly_price (decimal)
- wallet_balance (decimal) default=0.00
- status (enum) default=active
- created_at (timestamp) nullable
- updated_at (timestamp) nullable

## hotspot_subscriptions

**Rows:** 0

### Columns

- id (bigint)
- tenant_id (bigint)
- customer_id (bigint)
- package_id (bigint)
- hotspot_username (varchar)
- hotspot_password (varchar)
- mikrotik_profile (varchar) default=default
- start_date (date)
- end_date (date)
- monthly_price (decimal)
- wallet_balance (decimal) default=0.00
- status (enum) default=active
- created_at (timestamp) nullable
- updated_at (timestamp) nullable

## inventories

**Rows:** 0

### Columns

- id (bigint)
- tenant_id (bigint)
- device_type (enum)
- brand (varchar)
- model (varchar) nullable
- quantity (int) default=0
- minimum_quantity (int) default=0
- notes (text) nullable
- created_at (timestamp) nullable
- updated_at (timestamp) nullable

## inventories

**Rows:** 0

### Columns

- id (bigint)
- tenant_id (bigint)
- device_type (enum)
- brand (varchar)
- model (varchar) nullable
- quantity (int) default=0
- minimum_quantity (int) default=0
- notes (text) nullable
- created_at (timestamp) nullable
- updated_at (timestamp) nullable

## invoices

**Rows:** 0

### Columns

- id (bigint)
- tenant_id (bigint)
- customer_id (bigint)
- subscription_id (bigint)
- hotspot_subscription_id (bigint) nullable
- invoice_number (varchar)
- amount (decimal)
- due_date (date)
- paid_at (timestamp) nullable
- status (enum) default=pending
- notes (text) nullable
- created_at (timestamp) nullable
- updated_at (timestamp) nullable

## invoices

**Rows:** 0

### Columns

- id (bigint)
- tenant_id (bigint)
- customer_id (bigint)
- subscription_id (bigint)
- hotspot_subscription_id (bigint) nullable
- invoice_number (varchar)
- amount (decimal)
- due_date (date)
- paid_at (timestamp) nullable
- status (enum) default=pending
- notes (text) nullable
- created_at (timestamp) nullable
- updated_at (timestamp) nullable

## job_batches

**Rows:** 0

### Columns

- id (varchar)
- name (varchar)
- total_jobs (int)
- pending_jobs (int)
- failed_jobs (int)
- failed_job_ids (longtext)
- options (mediumtext) nullable
- cancelled_at (int) nullable
- created_at (int)
- finished_at (int) nullable

## job_batches

**Rows:** 0

### Columns

- id (varchar)
- name (varchar)
- total_jobs (int)
- pending_jobs (int)
- failed_jobs (int)
- failed_job_ids (longtext)
- options (mediumtext) nullable
- cancelled_at (int) nullable
- created_at (int)
- finished_at (int) nullable

## jobs

**Rows:** 0

### Columns

- id (bigint)
- queue (varchar)
- payload (longtext)
- attempts (smallint)
- reserved_at (int) nullable
- available_at (int)
- created_at (int)

## jobs

**Rows:** 0

### Columns

- id (bigint)
- queue (varchar)
- payload (longtext)
- attempts (smallint)
- reserved_at (int) nullable
- available_at (int)
- created_at (int)

## migrations

**Rows:** 32

### Columns

- id (int)
- migration (varchar)
- batch (int)

## migrations

**Rows:** 32

### Columns

- id (int)
- migration (varchar)
- batch (int)

## model_has_permissions

**Rows:** 0

### Columns

- permission_id (bigint)
- model_type (varchar)
- model_id (bigint)

## model_has_permissions

**Rows:** 0

### Columns

- permission_id (bigint)
- model_type (varchar)
- model_id (bigint)

## model_has_roles

**Rows:** 0

### Columns

- role_id (bigint)
- model_type (varchar)
- model_id (bigint)

## model_has_roles

**Rows:** 0

### Columns

- role_id (bigint)
- model_type (varchar)
- model_id (bigint)

## notifications

**Rows:** 0

### Columns

- id (bigint)
- tenant_id (bigint)
- customer_id (bigint)
- subscription_id (bigint) nullable
- type (varchar)
- reminder_day (int) nullable
- title (varchar)
- message (text)
- is_read (tinyint) default=0
- sent_at (timestamp) nullable
- created_at (timestamp) nullable
- updated_at (timestamp) nullable

## notifications

**Rows:** 0

### Columns

- id (bigint)
- tenant_id (bigint)
- customer_id (bigint)
- subscription_id (bigint) nullable
- type (varchar)
- reminder_day (int) nullable
- title (varchar)
- message (text)
- is_read (tinyint) default=0
- sent_at (timestamp) nullable
- created_at (timestamp) nullable
- updated_at (timestamp) nullable

## packages

**Rows:** 0

### Columns

- id (bigint)
- tenant_id (bigint)
- name (varchar)
- download_speed (int)
- upload_speed (int) default=0
- price (decimal)
- billing_cycle (varchar) default=month
- billing_interval (smallint) default=1
- grace_days (smallint) default=0
- auto_suspend (tinyint) default=1
- auto_expire (tinyint) default=1
- quota_gb (int) nullable
- mikrotik_profile (varchar) nullable
- status (enum) default=active
- description (text) nullable
- created_at (timestamp) nullable
- updated_at (timestamp) nullable

## packages

**Rows:** 0

### Columns

- id (bigint)
- tenant_id (bigint)
- name (varchar)
- download_speed (int)
- upload_speed (int) default=0
- price (decimal)
- billing_cycle (varchar) default=month
- billing_interval (smallint) default=1
- grace_days (smallint) default=0
- auto_suspend (tinyint) default=1
- auto_expire (tinyint) default=1
- quota_gb (int) nullable
- mikrotik_profile (varchar) nullable
- status (enum) default=active
- description (text) nullable
- created_at (timestamp) nullable
- updated_at (timestamp) nullable

## password_reset_tokens

**Rows:** 0

### Columns

- email (varchar)
- token (varchar)
- created_at (timestamp) nullable

## password_reset_tokens

**Rows:** 0

### Columns

- email (varchar)
- token (varchar)
- created_at (timestamp) nullable

## payments

**Rows:** 0

### Columns

- id (bigint)
- tenant_id (bigint)
- invoice_id (bigint)
- amount (decimal)
- payment_date (date)
- payment_method (enum)
- reference_number (varchar) nullable
- notes (text) nullable
- created_at (timestamp) nullable
- updated_at (timestamp) nullable

## payments

**Rows:** 0

### Columns

- id (bigint)
- tenant_id (bigint)
- invoice_id (bigint)
- amount (decimal)
- payment_date (date)
- payment_method (enum)
- reference_number (varchar) nullable
- notes (text) nullable
- created_at (timestamp) nullable
- updated_at (timestamp) nullable

## permissions

**Rows:** 77

### Columns

- id (bigint)
- name (varchar)
- guard_name (varchar)
- created_at (timestamp) nullable
- updated_at (timestamp) nullable

## permissions

**Rows:** 77

### Columns

- id (bigint)
- name (varchar)
- guard_name (varchar)
- created_at (timestamp) nullable
- updated_at (timestamp) nullable

## personal_access_tokens

**Rows:** 0

### Columns

- id (bigint)
- tokenable_type (varchar)
- tokenable_id (bigint)
- name (text)
- token (varchar)
- abilities (text) nullable
- last_used_at (timestamp) nullable
- expires_at (timestamp) nullable
- created_at (timestamp) nullable
- updated_at (timestamp) nullable

## personal_access_tokens

**Rows:** 0

### Columns

- id (bigint)
- tokenable_type (varchar)
- tokenable_id (bigint)
- name (text)
- token (varchar)
- abilities (text) nullable
- last_used_at (timestamp) nullable
- expires_at (timestamp) nullable
- created_at (timestamp) nullable
- updated_at (timestamp) nullable

## role_has_permissions

**Rows:** 203

### Columns

- permission_id (bigint)
- role_id (bigint)

## role_has_permissions

**Rows:** 203

### Columns

- permission_id (bigint)
- role_id (bigint)

## roles

**Rows:** 7

### Columns

- id (bigint)
- name (varchar)
- guard_name (varchar)
- created_at (timestamp) nullable
- updated_at (timestamp) nullable

## roles

**Rows:** 7

### Columns

- id (bigint)
- name (varchar)
- guard_name (varchar)
- created_at (timestamp) nullable
- updated_at (timestamp) nullable

## sessions

**Rows:** 0

### Columns

- id (varchar)
- user_id (bigint) nullable
- ip_address (varchar) nullable
- user_agent (text) nullable
- payload (longtext)
- last_activity (int)

## sessions

**Rows:** 0

### Columns

- id (varchar)
- user_id (bigint) nullable
- ip_address (varchar) nullable
- user_agent (text) nullable
- payload (longtext)
- last_activity (int)

## subscriptions

**Rows:** 0

### Columns

- id (bigint)
- tenant_id (bigint)
- customer_id (bigint)
- package_id (bigint)
- start_date (date)
- end_date (date) nullable
- monthly_price (decimal)
- wallet_balance (decimal) default=0.00
- status (enum) default=active
- notes (text) nullable
- pppoe_username (varchar) nullable
- pppoe_password (varchar) nullable
- mikrotik_profile (varchar) nullable
- created_at (timestamp) nullable
- updated_at (timestamp) nullable

## subscriptions

**Rows:** 0

### Columns

- id (bigint)
- tenant_id (bigint)
- customer_id (bigint)
- package_id (bigint)
- start_date (date)
- end_date (date) nullable
- monthly_price (decimal)
- wallet_balance (decimal) default=0.00
- status (enum) default=active
- notes (text) nullable
- pppoe_username (varchar) nullable
- pppoe_password (varchar) nullable
- mikrotik_profile (varchar) nullable
- created_at (timestamp) nullable
- updated_at (timestamp) nullable

## tenants

**Rows:** 0

### Columns

- id (bigint)
- created_at (timestamp) nullable
- updated_at (timestamp) nullable
- name (varchar)
- email (varchar) nullable
- phone (varchar) nullable
- address (text) nullable
- domain (varchar) nullable
- status (enum) default=active
- logo (varchar) nullable

## tenants

**Rows:** 0

### Columns

- id (bigint)
- created_at (timestamp) nullable
- updated_at (timestamp) nullable
- name (varchar)
- email (varchar) nullable
- phone (varchar) nullable
- address (text) nullable
- domain (varchar) nullable
- status (enum) default=active
- logo (varchar) nullable

## ticket_replies

**Rows:** 0

### Columns

- id (bigint)
- ticket_id (bigint)
- customer_id (bigint) nullable
- user_id (bigint) nullable
- message (text)
- is_staff (tinyint) default=0
- sent_at (timestamp)
- created_at (timestamp) nullable
- updated_at (timestamp) nullable

## ticket_replies

**Rows:** 0

### Columns

- id (bigint)
- ticket_id (bigint)
- customer_id (bigint) nullable
- user_id (bigint) nullable
- message (text)
- is_staff (tinyint) default=0
- sent_at (timestamp)
- created_at (timestamp) nullable
- updated_at (timestamp) nullable

## tickets

**Rows:** 0

### Columns

- id (bigint)
- tenant_id (bigint)
- customer_id (bigint)
- user_id (bigint) nullable
- ticket_number (varchar)
- subject (varchar)
- description (text)
- priority (enum) default=medium
- status (enum) default=open
- opened_at (timestamp) nullable
- closed_at (timestamp) nullable
- notes (text) nullable
- created_at (timestamp) nullable
- updated_at (timestamp) nullable

## tickets

**Rows:** 0

### Columns

- id (bigint)
- tenant_id (bigint)
- customer_id (bigint)
- user_id (bigint) nullable
- ticket_number (varchar)
- subject (varchar)
- description (text)
- priority (enum) default=medium
- status (enum) default=open
- opened_at (timestamp) nullable
- closed_at (timestamp) nullable
- notes (text) nullable
- created_at (timestamp) nullable
- updated_at (timestamp) nullable

## users

**Rows:** 0

### Columns

- id (bigint)
- tenant_id (bigint) nullable
- name (varchar)
- email (varchar)
- email_verified_at (timestamp) nullable
- password (varchar)
- remember_token (varchar) nullable
- created_at (timestamp) nullable
- updated_at (timestamp) nullable

## users

**Rows:** 0

### Columns

- id (bigint)
- tenant_id (bigint) nullable
- name (varchar)
- email (varchar)
- email_verified_at (timestamp) nullable
- password (varchar)
- remember_token (varchar) nullable
- created_at (timestamp) nullable
- updated_at (timestamp) nullable

## wallet_transactions

**Rows:** 0

### Columns

- id (bigint)
- tenant_id (bigint)
- customer_id (bigint)
- amount (decimal)
- balance_before (decimal)
- balance_after (decimal)
- type (varchar)
- reference (varchar) nullable
- description (text) nullable
- created_at (timestamp) nullable
- updated_at (timestamp) nullable

## wallet_transactions

**Rows:** 0

### Columns

- id (bigint)
- tenant_id (bigint)
- customer_id (bigint)
- amount (decimal)
- balance_before (decimal)
- balance_after (decimal)
- type (varchar)
- reference (varchar) nullable
- description (text) nullable
- created_at (timestamp) nullable
- updated_at (timestamp) nullable
