#!/bin/bash

set -e

echo "=== Fixing Subscription Contracts References ==="


grep -rl "App\\\\Contracts\\\\Domain\\\\Shared\\\\Contracts\\\\ActionInterface" app tests \
| xargs -r sed -i \
's/App\\Contracts\\Domain\\Shared\\Contracts\\ActionInterface/App\\Core\\Contracts\\ActionInterface/g'


grep -rl "App\\\\Contracts\\\\Domain\\\\Shared\\\\Contracts\\\\DomainEventInterface" app tests \
| xargs -r sed -i \
's/App\\Contracts\\Domain\\Shared\\Contracts\\DomainEventInterface/App\\Core\\Contracts\\DomainEventInterface/g'


grep -rl "App\\\\Contracts\\\\Domain\\\\Shared\\\\Contracts\\\\RepositoryInterface" app tests \
| xargs -r sed -i \
's/App\\Contracts\\Domain\\Shared\\Contracts\\RepositoryInterface/App\\Core\\Contracts\\RepositoryInterface/g'


grep -rl "App\\\\Contracts\\\\Domain\\\\Shared\\\\Contracts\\\\WorkflowInterface" app tests \
| xargs -r sed -i \
's/App\\Contracts\\Domain\\Shared\\\\Contracts\\WorkflowInterface/App\\Core\\Contracts\\WorkflowInterface/g'


echo "=== Fixing Subscription Repository Interface ==="


grep -rl "App\\\\Contracts\\\\Repositories\\\\SubscriptionRepositoryInterface" app tests \
| xargs -r sed -i \
's/App\\Contracts\\Repositories\\SubscriptionRepositoryInterface/App\\Modules\\Subscription\\Domain\\Contracts\\SubscriptionRepositoryInterface/g'


echo "=== Done ==="

