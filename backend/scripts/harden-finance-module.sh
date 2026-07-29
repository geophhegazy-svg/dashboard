#!/bin/bash

set -e

echo "=========================================="
echo " Finance Module Hardening"
echo "=========================================="

mkdir -p app/Modules/Finance/Application/Services
mkdir -p app/Modules/Finance/Domain/Contracts
mkdir -p app/Modules/Finance/Domain/Rules

echo "Moving FinanceService..."

if [ -f app/Services/Finance/FinanceService.php ]; then
    mv app/Services/Finance/FinanceService.php \
    app/Modules/Finance/Application/Services/
fi


echo "Moving Finance Contract..."

if [ -f app/Contracts/FinanceServiceInterface.php ]; then
    mv app/Contracts/FinanceServiceInterface.php \
    app/Modules/Finance/Domain/Contracts/
fi


echo "Moving JournalValidator..."

if [ -f app/Services/Finance/Accounting/JournalValidator.php ]; then
    mv app/Services/Finance/Accounting/JournalValidator.php \
    app/Modules/Finance/Domain/Rules/
fi


echo "Updating namespaces..."

find app/Modules/Finance -type f -name "*.php" \
-exec sed -i \
's#App\\Services\\Finance#App\\Modules\\Finance\\Application\\Services#g' {} \;


find app/Modules/Finance/Domain -type f -name "*.php" \
-exec sed -i \
's#App\\Contracts#App\\Modules\\Finance\\Domain\\Contracts#g' {} \;


find app/Modules/Finance/Domain/Rules -type f -name "*.php" \
-exec sed -i \
's#App\\Services\\Finance\\Accounting#App\\Modules\\Finance\\Domain\\Rules#g' {} \;


echo "Updating references..."

find app tests routes database bootstrap config \
-type f -name "*.php" \
-exec sed -i \
's#App\\Contracts\\FinanceServiceInterface#App\\Modules\\Finance\\Domain\\Contracts\\FinanceServiceInterface#g' {} \;


find app tests routes database bootstrap config \
-type f -name "*.php" \
-exec sed -i \
's#App\\Services\\Finance\\FinanceService#App\\Modules\\Finance\\Application\\Services\\FinanceService#g' {} \;


echo "Updating ServiceProvider..."

sed -i \
's#App\\Services\\Finance\\FinanceService#App\\Modules\\Finance\\Application\\Services\\FinanceService#g' \
app/Providers/AppServiceProvider.php


echo "Cleaning empty folders..."

rmdir app/Services/Finance/Accounting 2>/dev/null || true
rmdir app/Services/Finance 2>/dev/null || true


echo "Composer..."

composer dump-autoload


php artisan optimize:clear


echo "=========================================="
echo " Finance Module Hardened Successfully"
echo "=========================================="
