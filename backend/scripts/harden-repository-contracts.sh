#!/bin/bash

set -e

echo "=========================================="
echo " Repository Contracts Hardening"
echo "=========================================="

mkdir -p app/Modules/Accounting/Domain/Contracts
mkdir -p app/Modules/Billing/Domain/Contracts
mkdir -p app/Modules/Invoice/Domain/Contracts
mkdir -p app/Modules/Wallet/Domain/Contracts
mkdir -p app/Modules/Reports/Domain/Contracts
mkdir -p app/Modules/Package/Domain/Contracts
mkdir -p app/Modules/Task/Domain/Contracts

move_if_exists () {
    if [ -f "$1" ]; then
        mv "$1" "$2"
    fi
}

echo "Moving repository interfaces..."

move_if_exists app/Contracts/Repositories/AccountRepositoryInterface.php \
app/Modules/Accounting/Domain/Contracts/

move_if_exists app/Contracts/Repositories/JournalEntryRepositoryInterface.php \
app/Modules/Accounting/Domain/Contracts/

move_if_exists app/Contracts/Repositories/JournalEntryLineRepositoryInterface.php \
app/Modules/Accounting/Domain/Contracts/

move_if_exists app/Contracts/Repositories/BillingRepositoryInterface.php \
app/Modules/Billing/Domain/Contracts/

move_if_exists app/Contracts/Repositories/InvoiceRepositoryInterface.php \
app/Modules/Invoice/Domain/Contracts/

move_if_exists app/Contracts/Repositories/WalletRepositoryInterface.php \
app/Modules/Wallet/Domain/Contracts/

move_if_exists app/Contracts/Repositories/ReportRepositoryInterface.php \
app/Modules/Reports/Domain/Contracts/

move_if_exists app/Contracts/Repositories/ReportExportRepositoryInterface.php \
app/Modules/Reports/Domain/Contracts/

move_if_exists app/Contracts/Repositories/ScheduledReportRepositoryInterface.php \
app/Modules/Reports/Domain/Contracts/

move_if_exists app/Contracts/Repositories/PackageRepositoryInterface.php \
app/Modules/Package/Domain/Contracts/

move_if_exists app/Contracts/Repositories/TaskRepositoryInterface.php \
app/Modules/Task/Domain/Contracts/

echo "Updating namespaces..."

find app/Modules \
-type f \
-name "*RepositoryInterface.php" \
-exec sed -i \
's#namespace App\\Contracts\\Repositories;#namespace App\\Modules\\Accounting\\Domain\\Contracts;#g' {} \;

sed -i 's#namespace App\\Modules\\Accounting\\Domain\\Contracts;#namespace App\\Modules\\Billing\\Domain\\Contracts;#' \
app/Modules/Billing/Domain/Contracts/BillingRepositoryInterface.php 2>/dev/null || true

sed -i 's#namespace App\\Modules\\Accounting\\Domain\\Contracts;#namespace App\\Modules\\Invoice\\Domain\\Contracts;#' \
app/Modules/Invoice/Domain/Contracts/InvoiceRepositoryInterface.php 2>/dev/null || true

sed -i 's#namespace App\\Modules\\Accounting\\Domain\\Contracts;#namespace App\\Modules\\Wallet\\Domain\\Contracts;#' \
app/Modules/Wallet/Domain/Contracts/WalletRepositoryInterface.php 2>/dev/null || true

sed -i 's#namespace App\\Modules\\Accounting\\Domain\\Contracts;#namespace App\\Modules\\Reports\\Domain\\Contracts;#' \
app/Modules/Reports/Domain/Contracts/*RepositoryInterface.php 2>/dev/null || true

sed -i 's#namespace App\\Modules\\Accounting\\Domain\\Contracts;#namespace App\\Modules\\Package\\Domain\\Contracts;#' \
app/Modules/Package/Domain/Contracts/PackageRepositoryInterface.php 2>/dev/null || true

sed -i 's#namespace App\\Modules\\Accounting\\Domain\\Contracts;#namespace App\\Modules\\Task\\Domain\\Contracts;#' \
app/Modules/Task/Domain/Contracts/TaskRepositoryInterface.php 2>/dev/null || true

echo "Updating project references..."

find app tests routes bootstrap config database \
-type f \
-name "*.php" \
-exec sed -i \
's#App\\Contracts\\Repositories\\AccountRepositoryInterface#App\\Modules\\Accounting\\Domain\\Contracts\\AccountRepositoryInterface#g' {} \;

find app tests routes bootstrap config database \
-type f \
-name "*.php" \
-exec sed -i \
's#App\\Contracts\\Repositories\\JournalEntryRepositoryInterface#App\\Modules\\Accounting\\Domain\\Contracts\\JournalEntryRepositoryInterface#g' {} \;

find app tests routes bootstrap config database \
-type f \
-name "*.php" \
-exec sed -i \
's#App\\Contracts\\Repositories\\JournalEntryLineRepositoryInterface#App\\Modules\\Accounting\\Domain\\Contracts\\JournalEntryLineRepositoryInterface#g' {} \;

find app tests routes bootstrap config database \
-type f \
-name "*.php" \
-exec sed -i \
's#App\\Contracts\\Repositories\\BillingRepositoryInterface#App\\Modules\\Billing\\Domain\\Contracts\\BillingRepositoryInterface#g' {} \;

find app tests routes bootstrap config database \
-type f \
-name "*.php" \
-exec sed -i \
's#App\\Contracts\\Repositories\\InvoiceRepositoryInterface#App\\Modules\\Invoice\\Domain\\Contracts\\InvoiceRepositoryInterface#g' {} \;

find app tests routes bootstrap config database \
-type f \
-name "*.php" \
-exec sed -i \
's#App\\Contracts\\Repositories\\WalletRepositoryInterface#App\\Modules\\Wallet\\Domain\\Contracts\\WalletRepositoryInterface#g' {} \;

find app tests routes bootstrap config database \
-type f \
-name "*.php" \
-exec sed -i \
's#App\\Contracts\\Repositories\\ReportRepositoryInterface#App\\Modules\\Reports\\Domain\\Contracts\\ReportRepositoryInterface#g' {} \;

find app tests routes bootstrap config database \
-type f \
-name "*.php" \
-exec sed -i \
's#App\\Contracts\\Repositories\\ReportExportRepositoryInterface#App\\Modules\\Reports\\Domain\\Contracts\\ReportExportRepositoryInterface#g' {} \;

find app tests routes bootstrap config database \
-type f \
-name "*.php" \
-exec sed -i \
's#App\\Contracts\\Repositories\\ScheduledReportRepositoryInterface#App\\Modules\\Reports\\Domain\\Contracts\\ScheduledReportRepositoryInterface#g' {} \;

find app tests routes bootstrap config database \
-type f \
-name "*.php" \
-exec sed -i \
's#App\\Contracts\\Repositories\\PackageRepositoryInterface#App\\Modules\\Package\\Domain\\Contracts\\PackageRepositoryInterface#g' {} \;

find app tests routes bootstrap config database \
-type f \
-name "*.php" \
-exec sed -i \
's#App\\Contracts\\Repositories\\TaskRepositoryInterface#App\\Modules\\Task\\Domain\\Contracts\\TaskRepositoryInterface#g' {} \;

rmdir app/Contracts/Repositories 2>/dev/null || true

composer dump-autoload

php artisan optimize:clear

echo "=========================================="
echo " Repository Contracts Hardened Successfully"
echo "=========================================="
