#!/bin/bash

set -e

echo "=========================================="
echo " Reports Module Hardening"
echo "=========================================="

mkdir -p app/Modules/Reports/Application/Services

echo "Moving services..."

for file in \
ReportService.php \
ReportExecutionService.php \
ReportExportService.php \
ScheduledReportService.php
do
    if [ -f "app/Modules/Reports/$file" ]; then
        mv "app/Modules/Reports/$file" \
        "app/Modules/Reports/Application/Services/$file"
    fi
done


echo "Updating namespaces..."

find app/Modules/Reports/Application/Services \
-type f -name "*.php" \
-exec sed -i \
's#namespace App\\Modules\\Reports;#namespace App\\Modules\\Reports\\Application\\Services;#g' {} \;


echo "Updating references..."

find app tests routes bootstrap config database \
-type f -name "*.php" \
-exec sed -i \
's#App\\Modules\\Reports\\ReportService#App\\Modules\\Reports\\Application\\Services\\ReportService#g' {} \;

find app tests routes bootstrap config database \
-type f -name "*.php" \
-exec sed -i \
's#App\\Modules\\Reports\\ReportExecutionService#App\\Modules\\Reports\\Application\\Services\\ReportExecutionService#g' {} \;

find app tests routes bootstrap config database \
-type f -name "*.php" \
-exec sed -i \
's#App\\Modules\\Reports\\ReportExportService#App\\Modules\\Reports\\Application\\Services\\ReportExportService#g' {} \;

find app tests routes bootstrap config database \
-type f -name "*.php" \
-exec sed -i \
's#App\\Modules\\Reports\\ScheduledReportService#App\\Modules\\Reports\\Application\\Services\\ScheduledReportService#g' {} \;


echo "Running composer..."

composer dump-autoload


echo "Clearing cache..."

php artisan optimize:clear


echo "=========================================="
echo " Reports Module Hardened Successfully"
echo "=========================================="
