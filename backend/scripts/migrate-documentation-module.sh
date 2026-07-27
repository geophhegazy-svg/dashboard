#!/bin/bash
set -e

echo "=========================================="
echo " Documentation Module Migration"
echo "=========================================="

OLD="app/Services/Documentation"
NEW="app/Modules/Documentation/Application"

mkdir -p "$NEW"

echo "Copying files..."
cp -a "$OLD/." "$NEW/"

echo "Replacing namespaces..."
find "$NEW" -type f -name "*.php" \
-exec sed -i \
's#namespace App\\Services\\Documentation#namespace App\\Modules\\Documentation\\Application#g' {} \;

find "$NEW" -type f -name "*.php" \
-exec sed -i \
's#use App\\Services\\Documentation#use App\\Modules\\Documentation\\Application#g' {} \;

echo "Replacing project references..."
find app tests routes database bootstrap config \
-type f \
-name "*.php" \
-exec sed -i \
's#App\\Services\\Documentation#App\\Modules\\Documentation\\Application#g' {} \;

echo "Removing legacy folder..."
rm -rf app/Services/Documentation

echo "Running composer..."
composer dump-autoload

echo "Clearing cache..."
php artisan optimize:clear

echo "=========================================="
echo " Migration Finished Successfully"
echo "=========================================="
