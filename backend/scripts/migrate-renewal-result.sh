#!/bin/bash

set -e

echo "=========================================="
echo " Subscription RenewalResult Migration"
echo "=========================================="

mkdir -p app/Modules/Subscription/Application/Results

echo "Moving RenewalResult..."

mv app/Core/DTO/RenewalResult.php \
app/Modules/Subscription/Application/Results/

echo "Updating namespace..."

sed -i \
's#namespace App\\Core\\DTO;#namespace App\\Modules\\Subscription\\Application\\Results;#' \
app/Modules/Subscription/Application/Results/RenewalResult.php

echo "Updating references..."

find app tests routes bootstrap config database \
-type f -name "*.php" \
-exec sed -i \
's#App\\Core\\DTO\\RenewalResult#App\\Modules\\Subscription\\Application\\Results\\RenewalResult#g' \
{} \;

echo "Composer..."

composer dump-autoload

php artisan optimize:clear

echo "=========================================="
echo " RenewalResult migrated successfully"
echo "=========================================="
