#!/bin/bash

set -e

echo "=== Subscription Module Migration v2 Started ==="

BASE="app/Modules/Subscription"

mkdir -p \
$BASE/Application/Commands \
$BASE/Application/Workflows


echo "== Moving Subscription Actions =="

if [ -d app/Actions/Subscription ]; then

    mv app/Actions/Subscription/* \
    $BASE/Application/Commands/

    rmdir app/Actions/Subscription

fi


echo "== Moving Subscription Workflows =="

if [ -d app/Application/Subscription/Workflows ]; then

    mv app/Application/Subscription/Workflows/* \
    $BASE/Application/Workflows/

fi


echo "== Updating Namespaces =="


find $BASE/Application/Commands -type f -name "*.php" \
-exec sed -i \
's/namespace App\\Actions\\Subscription;/namespace App\\Modules\\Subscription\\Application\\Commands;/' {} \;


find $BASE/Application/Workflows -type f -name "*.php" \
-exec sed -i \
's/namespace App\\Application\\Subscription\\Workflows;/namespace App\\Modules\\Subscription\\Application\\Workflows;/' {} \;


echo "== Updating Imports =="


grep -rl "App\\\\Actions\\\\Subscription" app tests \
| xargs -r sed -i \
's/App\\Actions\\Subscription/App\\Modules\\Subscription\\Application\\Commands/g'


grep -rl "App\\\\Application\\\\Subscription\\\\Workflows" app tests \
| xargs -r sed -i \
's/App\\Application\\Subscription\\Workflows/App\\Modules\\Subscription\\Application\\Workflows/g'


echo "== Rebuilding Autoload =="

composer dump-autoload


echo "== Running Tests =="

php artisan test


echo "=== Migration v2 Completed Successfully ==="

