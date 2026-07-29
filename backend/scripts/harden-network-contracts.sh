#!/bin/bash

set -e

echo "=========================================="
echo " Network Contracts Hardening"
echo "=========================================="

mkdir -p app/Modules/Network/Domain/Contracts
mkdir -p app/Modules/Network/Domain/Contracts/Services

echo "Moving contracts..."

if [ -f app/Contracts/MikrotikServiceInterface.php ]; then
    mv app/Contracts/MikrotikServiceInterface.php \
       app/Modules/Network/Domain/Contracts/
fi

if [ -d app/Contracts/Network ]; then
    cp -R app/Contracts/Network/* \
          app/Modules/Network/Domain/Contracts/
    rm -rf app/Contracts/Network
fi

echo "Updating namespaces..."

find app/Modules/Network/Domain/Contracts \
-type f -name "*.php" \
-exec sed -i \
's#namespace App\\Contracts;#namespace App\\Modules\\Network\\Domain\\Contracts;#g' {} \;

find app/Modules/Network/Domain/Contracts \
-type f -name "*.php" \
-exec sed -i \
's#namespace App\\Contracts\\Network;#namespace App\\Modules\\Network\\Domain\\Contracts;#g' {} \;

find app/Modules/Network/Domain/Contracts \
-type f -name "*.php" \
-exec sed -i \
's#namespace App\\Contracts\\Network\\Services;#namespace App\\Modules\\Network\\Domain\\Contracts\\Services;#g' {} \;

echo "Updating project references..."

find app tests routes bootstrap config database \
-type f -name "*.php" \
-exec sed -i \
's#App\\Contracts\\MikrotikServiceInterface#App\\Modules\\Network\\Domain\\Contracts\\MikrotikServiceInterface#g' {} \;

find app tests routes bootstrap config database \
-type f -name "*.php" \
-exec sed -i \
's#App\\Contracts\\Network\\#App\\Modules\\Network\\Domain\\Contracts\\#g' {} \;

echo "Composer..."

composer dump-autoload

php artisan optimize:clear

echo "=========================================="
echo " Network Contracts Hardened Successfully"
echo "=========================================="
