#!/bin/bash

set -e

echo "=== Subscription Application Migration Started ==="

BASE="app/Modules/Subscription/Application"

mkdir -p \
$BASE/Commands \
$BASE/DTO \
$BASE/Handlers \
$BASE/Queries \
$BASE/Workflows \
$BASE/Validators


echo "== Moving Actions to Commands =="

if [ -d app/Actions/Subscription ]; then

    mv app/Actions/Subscription/*.php \
    $BASE/Commands/

    rmdir app/Actions/Subscription 2>/dev/null || true

fi


echo "== Moving Workflows =="

if [ -d app/Application/Subscription/Workflows ]; then

    mv app/Application/Subscription/Workflows/*.php \
    $BASE/Workflows/

fi


echo "== Moving Validators =="

if [ -d app/Application/Subscription/Validators ]; then

    mv app/Application/Subscription/Validators/*.php \
    $BASE/Validators/

fi


echo "== Moving DTO =="

if [ -d app/Data/Subscription ]; then

    mv app/Data/Subscription/*.php \
    $BASE/DTO/

fi


echo "== Updating Namespaces =="


find $BASE -type f -name "*.php" -exec sed -i \
's/namespace App\\Actions\\Subscription;/namespace App\\Modules\\Subscription\\Application\\Commands;/' {} \;


find $BASE -type f -name "*.php" -exec sed -i \
's/namespace App\\Application\\Subscription\\Workflows;/namespace App\\Modules\\Subscription\\Application\\Workflows;/' {} \;


find $BASE -type f -name "*.php" -exec sed -i \
's/namespace App\\Application\\Subscription\\Validators;/namespace App\\Modules\\Subscription\\Application\\Validators;/' {} \;


find $BASE -type f -name "*.php" -exec sed -i \
's/namespace App\\Data\\Subscription;/namespace App\\Modules\\Subscription\\Application\\DTO;/' {} \;


echo "== Updating Imports Everywhere =="


grep -rl "App\\\\Actions\\\\Subscription" app tests \
| xargs -r sed -i \
's/App\\Actions\\Subscription/App\\Modules\\Subscription\\Application\\Commands/g'


grep -rl "App\\\\Application\\\\Subscription\\\\Workflows" app tests \
| xargs -r sed -i \
's/App\\Application\\Subscription\\Workflows/App\\Modules\\Subscription\\Application\\Workflows/g'


grep -rl "App\\\\Application\\\\Subscription\\\\Validators" app tests \
| xargs -r sed -i \
's/App\\Application\\Subscription\\Validators/App\\Modules\\Subscription\\Application\\Validators/g'


grep -rl "App\\\\Data\\\\Subscription" app tests \
| xargs -r sed -i \
's/App\\Data\\Subscription/App\\Modules\\Subscription\\Application\\DTO/g'


echo "== Structure =="

find app/Modules/Subscription/Application -type f | sort


echo "== Composer Autoload =="

composer dump-autoload


echo "=== Migration Finished Successfully ==="

