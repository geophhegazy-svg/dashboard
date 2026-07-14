#!/bin/bash

set -e

echo "=== Subscription Module Migration Started ==="

BASE="app/Modules/Subscription"

mkdir -p \
$BASE/Domain/Enums \
$BASE/Domain/Exceptions \
$BASE/Domain/Events \
$BASE/Infrastructure/Repositories \
$BASE/Infrastructure/Persistence/Models


echo "== Moving Subscription Enum =="

if [ -f app/Enums/SubscriptionStatus.php ]; then
    mv app/Enums/SubscriptionStatus.php \
    $BASE/Domain/Enums/SubscriptionStatus.php
fi


echo "== Moving Exceptions =="

if [ -f app/Exceptions/InvalidStateTransitionException.php ]; then
    mv app/Exceptions/InvalidStateTransitionException.php \
    $BASE/Domain/Exceptions/InvalidStateTransitionException.php
fi


echo "== Moving Events =="

if ls app/Events/Subscription*.php >/dev/null 2>&1; then
    mv app/Events/Subscription*.php \
    $BASE/Domain/Events/
fi


echo "== Updating Namespaces =="


find $BASE/Domain/Enums -type f -name "*.php" \
-exec sed -i \
's/namespace App\\Enums;/namespace App\\Modules\\Subscription\\Domain\\Enums;/' {} \;


find $BASE/Domain/Exceptions -type f -name "*.php" \
-exec sed -i \
's/namespace App\\Exceptions;/namespace App\\Modules\\Subscription\\Domain\\Exceptions;/' {} \;


find $BASE/Domain/Events -type f -name "*.php" \
-exec sed -i \
's/namespace App\\Events;/namespace App\\Modules\\Subscription\\Domain\\Events;/' {} \;


echo "== Updating Imports Project Wide =="


grep -rl "App\\\\Enums\\\\SubscriptionStatus" app tests \
| xargs -r sed -i \
's/App\\Enums\\SubscriptionStatus/App\\Modules\\Subscription\\Domain\\Enums\\SubscriptionStatus/g'


grep -rl "App\\\\Exceptions\\\\InvalidStateTransitionException" app tests \
| xargs -r sed -i \
's/App\\Exceptions\\InvalidStateTransitionException/App\\Modules\\Subscription\\Domain\\Exceptions\\InvalidStateTransitionException/g'


grep -rl "App\\\\Events\\\\Subscription" app tests \
| xargs -r sed -i \
's/App\\Events\\/App\\Modules\\Subscription\\Domain\\Events\\/g'


echo "== Checking Module Structure =="

find app/Modules/Subscription -type f | sort


echo "== Rebuilding Autoload =="

composer dump-autoload


echo "=== Subscription Module Migration Finished ==="

