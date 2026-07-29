#!/bin/bash
set -e

if [ -z "$1" ]; then
    echo "Usage:"
    echo "./scripts/harden-module.sh ModuleName"
    exit 1
fi

MODULE=$1

echo "=========================================="
echo " Hardening Module: $MODULE"
echo "=========================================="

###########################################
# paths
###########################################

MODULE_DIR="app/Modules/$MODULE"

mkdir -p "$MODULE_DIR/Application/Services"
mkdir -p "$MODULE_DIR/Infrastructure/Repositories"
mkdir -p "$MODULE_DIR/Domain/Contracts"

###########################################
# Move Service
###########################################

if [ -f "$MODULE_DIR/${MODULE}Service.php" ]; then

    mv \
    "$MODULE_DIR/${MODULE}Service.php" \
    "$MODULE_DIR/Application/Services/"
fi

###########################################
# Repository
###########################################

if [ -f "app/Repositories/Eloquent/${MODULE}Repository.php" ]; then

    mv \
    "app/Repositories/Eloquent/${MODULE}Repository.php" \
    "$MODULE_DIR/Infrastructure/Repositories/"
fi

###########################################
# Interface
###########################################

if [ -f "app/Contracts/Repositories/${MODULE}RepositoryInterface.php" ]; then

    mv \
    "app/Contracts/Repositories/${MODULE}RepositoryInterface.php" \
    "$MODULE_DIR/Domain/Contracts/"
fi

###########################################
# Namespace Repository
###########################################

find "$MODULE_DIR/Infrastructure/Repositories" \
-type f -name "*.php" \
-exec sed -i \
"s#namespace App\\\\Repositories\\\\Eloquent;#namespace App\\\\Modules\\\\$MODULE\\\\Infrastructure\\\\Repositories;#g" {} \;

###########################################
# Namespace Interface
###########################################

find "$MODULE_DIR/Domain/Contracts" \
-type f -name "*.php" \
-exec sed -i \
"s#namespace App\\\\Contracts\\\\Repositories;#namespace App\\\\Modules\\\\$MODULE\\\\Domain\\\\Contracts;#g" {} \;

###########################################
# Namespace Service
###########################################

find "$MODULE_DIR/Application/Services" \
-type f -name "*.php" \
-exec sed -i \
"s#namespace App\\\\Modules\\\\$MODULE;#namespace App\\\\Modules\\\\$MODULE\\\\Application\\\\Services;#g" {} \;

###########################################
# Update whole project
###########################################

find app tests routes database bootstrap config \
-type f -name "*.php" \
-exec sed -i \
"s#App\\\\Repositories\\\\Eloquent\\\\${MODULE}Repository#App\\\\Modules\\\\$MODULE\\\\Infrastructure\\\\Repositories\\\\${MODULE}Repository#g" {} \;

find app tests routes database bootstrap config \
-type f -name "*.php" \
-exec sed -i \
"s#App\\\\Contracts\\\\Repositories\\\\${MODULE}RepositoryInterface#App\\\\Modules\\\\$MODULE\\\\Domain\\\\Contracts\\\\${MODULE}RepositoryInterface#g" {} \;

find app tests routes database bootstrap config \
-type f -name "*.php" \
-exec sed -i \
"s#App\\\\Modules\\\\$MODULE\\\\${MODULE}Service#App\\\\Modules\\\\$MODULE\\\\Application\\\\Services\\\\${MODULE}Service#g" {} \;

###########################################
# Cleanup
###########################################

rmdir app/Repositories/Eloquent 2>/dev/null || true
rmdir app/Repositories 2>/dev/null || true
rmdir app/Contracts/Repositories 2>/dev/null || true

###########################################
# Composer
###########################################

composer dump-autoload

php artisan optimize:clear

echo "=========================================="
echo " Module $MODULE Hardened"
echo "=========================================="
