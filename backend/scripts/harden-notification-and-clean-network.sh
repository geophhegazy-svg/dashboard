#!/bin/bash

set -e

echo "=========================================="
echo " Notification Module Hardening"
echo "=========================================="

#
# Remove unused legacy MikrotikService
#
if [ -f app/Services/MikrotikService.php ]; then
    echo "Removing unused legacy MikrotikService..."
    rm app/Services/MikrotikService.php
fi


#
# Prepare Notification Module
#
mkdir -p app/Modules/Notification/Application/Services


if [ -f app/Services/Notification/TelegramNotificationService.php ]; then

    echo "Moving TelegramNotificationService..."

    mv app/Services/Notification/TelegramNotificationService.php \
    app/Modules/Notification/Application/Services/TelegramNotificationService.php

fi


#
# Update namespace
#
echo "Updating namespaces..."

find app/Modules/Notification/Application/Services \
-type f -name "*.php" \
-exec sed -i \
's#namespace App\\Services\\Notification#namespace App\\Modules\\Notification\\Application\\Services#g' {} \;


#
# Update references
#
echo "Updating references..."

find app tests routes database bootstrap config \
-type f -name "*.php" \
-exec sed -i \
's#App\\Services\\Notification\\TelegramNotificationService#App\\Modules\\Notification\\Application\\Services\\TelegramNotificationService#g' {} \;


#
# Composer
#
echo "Running composer..."

composer dump-autoload


#
# Clear cache
#
php artisan optimize:clear


echo "=========================================="
echo " Notification Module Hardened"
echo "=========================================="

