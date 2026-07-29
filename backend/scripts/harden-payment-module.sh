#!/bin/bash
set -e

echo "=========================================="
echo " Payment Module Hardening"
echo "=========================================="

mkdir -p app/Modules/Payment/Domain/Contracts
mkdir -p app/Modules/Payment/Infrastructure/Repositories
mkdir -p app/Modules/Payment/Application/Services

############################################
# Move Repository Interface
############################################

if [ -f app/Contracts/Repositories/PaymentRepositoryInterface.php ]; then
    mv \
    app/Contracts/Repositories/PaymentRepositoryInterface.php \
    app/Modules/Payment/Domain/Contracts/
fi

############################################
# Move Repository
############################################

if [ -f app/Repositories/Eloquent/PaymentRepository.php ]; then
    mv \
    app/Repositories/Eloquent/PaymentRepository.php \
    app/Modules/Payment/Infrastructure/Repositories/
fi

############################################
# Move Service
############################################

if [ -f app/Modules/Payment/PaymentService.php ]; then
    mv \
    app/Modules/Payment/PaymentService.php \
    app/Modules/Payment/Application/Services/
fi

echo "Updating namespaces..."

############################################
# Repository Interface
############################################

find app/Modules/Payment/Domain/Contracts \
-type f -name "*.php" \
-exec sed -i \
's#namespace App\\Contracts\\Repositories;#namespace App\\Modules\\Payment\\Domain\\Contracts;#g' {} \;

############################################
# Repository
############################################

find app/Modules/Payment/Infrastructure/Repositories \
-type f -name "*.php" \
-exec sed -i \
's#namespace App\\Repositories\\Eloquent;#namespace App\\Modules\\Payment\\Infrastructure\\Repositories;#g' {} \;

find app/Modules/Payment/Infrastructure/Repositories \
-type f -name "*.php" \
-exec sed -i \
's#App\\Contracts\\Repositories\\PaymentRepositoryInterface#App\\Modules\\Payment\\Domain\\Contracts\\PaymentRepositoryInterface#g' {} \;

############################################
# Service
############################################

find app/Modules/Payment/Application/Services \
-type f -name "*.php" \
-exec sed -i \
's#namespace App\\Modules\\Payment;#namespace App\\Modules\\Payment\\Application\\Services;#g' {} \;

############################################
# Update project references
############################################

find app tests routes bootstrap config database \
-type f -name "*.php" \
-exec sed -i \
's#App\\Contracts\\Repositories\\PaymentRepositoryInterface#App\\Modules\\Payment\\Domain\\Contracts\\PaymentRepositoryInterface#g' {} \;

find app tests routes bootstrap config database \
-type f -name "*.php" \
-exec sed -i \
's#App\\Repositories\\Eloquent\\PaymentRepository#App\\Modules\\Payment\\Infrastructure\\Repositories\\PaymentRepository#g' {} \;

find app tests routes bootstrap config database \
-type f -name "*.php" \
-exec sed -i \
's#App\\Modules\\Payment\\PaymentService#App\\Modules\\Payment\\Application\\Services\\PaymentService#g' {} \;

############################################
# Cleanup
############################################

rmdir app/Contracts/Repositories 2>/dev/null || true
rmdir app/Repositories/Eloquent 2>/dev/null || true
rmdir app/Repositories 2>/dev/null || true

############################################
# Composer
############################################

composer dump-autoload

php artisan optimize:clear

echo "=========================================="
echo " Payment Module Hardened Successfully"
echo "=========================================="
