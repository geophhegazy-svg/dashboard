#!/bin/bash
set -e

echo "====================================="
echo " Application Layer Migration"
echo "====================================="

mkdir -p app/Modules/Payment/Application/{DTO,Results,Validators,Workflows}
mkdir -p app/Modules/Subscription/Application/Validators

cp -a app/Application/Payment/DTO/. \
app/Modules/Payment/Application/DTO/

cp -a app/Application/Payment/Results/. \
app/Modules/Payment/Application/Results/

cp -a app/Application/Payment/Validators/. \
app/Modules/Payment/Application/Validators/

cp -a app/Application/Payment/Workflows/. \
app/Modules/Payment/Application/Workflows/

cp -a app/Application/Subscription/Validators/. \
app/Modules/Subscription/Application/Validators/

echo "Updating namespaces..."

find app/Modules/Payment/Application -name "*.php" \
-exec sed -i \
's#namespace App\\Application\\Payment#namespace App\\Modules\\Payment\\Application#g' {} \;

find app/Modules/Subscription/Application -name "*.php" \
-exec sed -i \
's#namespace App\\Application\\Subscription#namespace App\\Modules\\Subscription\\Application#g' {} \;

echo "Updating use statements..."

find app tests routes database bootstrap config \
-name "*.php" \
-exec sed -i \
's#App\\Application\\Payment#App\\Modules\\Payment\\Application#g' {} \;

find app tests routes database bootstrap config \
-name "*.php" \
-exec sed -i \
's#App\\Application\\Subscription#App\\Modules\\Subscription\\Application#g' {} \;

echo "Removing legacy Application..."

rm -rf app/Application

composer dump-autoload

php artisan optimize:clear

echo "====================================="
echo " Migration Finished"
echo "====================================="
