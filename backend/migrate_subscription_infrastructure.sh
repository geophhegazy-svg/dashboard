#!/bin/bash

set -e

echo "=== Subscription Infrastructure Migration Started ==="

BASE="app/Modules/Subscription/Infrastructure"

mkdir -p \
$BASE/Repositories \
$BASE/Persistence/Models


echo "== Copy Repository =="

if [ -f app/Repositories/Eloquent/SubscriptionRepository.php ]; then

    cp app/Repositories/Eloquent/SubscriptionRepository.php \
    $BASE/Repositories/SubscriptionRepository.php

fi


echo "== Copy Model =="

if [ -f app/Models/Subscription.php ]; then

    cp app/Models/Subscription.php \
    $BASE/Persistence/Models/Subscription.php

fi


echo "== Updating Repository Namespace =="

sed -i \
's/namespace App\\Repositories\\Eloquent;/namespace App\\Modules\\Subscription\\Infrastructure\\Repositories;/' \
$BASE/Repositories/SubscriptionRepository.php


echo "== Updating Model Namespace =="

sed -i \
's/namespace App\\Models;/namespace App\\Modules\\Subscription\\Infrastructure\\Persistence\\Models;/' \
$BASE/Persistence/Models/Subscription.php


echo "== Updating Model Imports =="

sed -i \
's/use App\\Models\\Subscription;/use App\\Modules\\Subscription\\Infrastructure\\Persistence\\Models\\Subscription;/' \
$BASE/Repositories/SubscriptionRepository.php


echo "== Updating Repository Contract =="

sed -i \
's/use App\\Modules\\Subscription\\Domain\\Contracts\\SubscriptionRepositoryInterface;/use App\\Modules\\Subscription\\Domain\\Contracts\\SubscriptionRepositoryInterface;/' \
$BASE/Repositories/SubscriptionRepository.php


echo "== Updating Project References =="

grep -rl "App\\\\Models\\\\Subscription" app tests \
| xargs -r sed -i \
's/App\\Models\\Subscription/App\\Modules\\Subscription\\Infrastructure\\Persistence\\Models\\Subscription/g'


grep -rl "App\\\\Repositories\\\\Eloquent\\\\SubscriptionRepository" app tests \
| xargs -r sed -i \
's/App\\Repositories\\Eloquent\\SubscriptionRepository/App\\Modules\\Subscription\\Infrastructure\\Repositories\\SubscriptionRepository/g'


echo "== Module Structure =="

find app/Modules/Subscription/Infrastructure -type f | sort


echo "== Composer Autoload =="

composer dump-autoload


echo "=== Infrastructure Migration Finished ==="

