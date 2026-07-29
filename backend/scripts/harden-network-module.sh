#!/bin/bash

set -e

echo "=========================================="
echo " Network Module Hardening"
echo "=========================================="

mkdir -p app/Modules/Network/Application
mkdir -p app/Modules/Network/Domain
mkdir -p app/Modules/Network/Infrastructure

echo "Moving folders..."

if [ -d app/Services/Network/Contracts ]; then
    mv app/Services/Network/Contracts \
       app/Modules/Network/Domain/
fi

if [ -d app/Services/Network/Providers ]; then
    mv app/Services/Network/Providers \
       app/Modules/Network/Infrastructure/
fi

for file in \
NetworkManager.php \
NetworkProviderResolver.php \
NetworkDeviceConnectionManager.php \
MikrotikServiceAdapter.php
do
    if [ -f "app/Services/Network/$file" ]; then
        mv "app/Services/Network/$file" \
           "app/Modules/Network/Application/"
    fi
done

echo "Updating namespaces..."

find app/Modules/Network/Application -type f -name "*.php" \
-exec sed -i \
's#namespace App\\Services\\Network#namespace App\\Modules\\Network\\Application#g' {} \;

find app/Modules/Network/Domain -type f -name "*.php" \
-exec sed -i \
's#namespace App\\Services\\Network\\Contracts#namespace App\\Modules\\Network\\Domain\\Contracts#g' {} \;

find app/Modules/Network/Infrastructure -type f -name "*.php" \
-exec sed -i \
's#namespace App\\Services\\Network\\Providers#namespace App\\Modules\\Network\\Infrastructure\\Providers#g' {} \;

echo "Updating internal references..."

find app/Modules/Network -type f -name "*.php" \
-exec sed -i \
's#App\\Services\\Network\\Contracts#App\\Modules\\Network\\Domain\\Contracts#g' {} \;

find app/Modules/Network -type f -name "*.php" \
-exec sed -i \
's#App\\Services\\Network\\Providers#App\\Modules\\Network\\Infrastructure\\Providers#g' {} \;

find app/Modules/Network -type f -name "*.php" \
-exec sed -i \
's#App\\Services\\Network#App\\Modules\\Network\\Application#g' {} \;

echo "Updating project references..."

find app tests routes bootstrap config database \
-type f -name "*.php" \
-exec sed -i \
's#App\\Services\\Network\\Contracts#App\\Modules\\Network\\Domain\\Contracts#g' {} \;

find app tests routes bootstrap config database \
-type f -name "*.php" \
-exec sed -i \
's#App\\Services\\Network\\Providers#App\\Modules\\Network\\Infrastructure\\Providers#g' {} \;

find app tests routes bootstrap config database \
-type f -name "*.php" \
-exec sed -i \
's#App\\Services\\Network#App\\Modules\\Network\\Application#g' {} \;

echo "Removing empty legacy folder..."

rmdir app/Services/Network 2>/dev/null || true

echo "Composer..."

composer dump-autoload

php artisan optimize:clear

echo "=========================================="
echo " Network Module Hardened Successfully"
echo "=========================================="
