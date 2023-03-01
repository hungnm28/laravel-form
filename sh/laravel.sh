#!/bin/bash
RED='\033[0;31m'
NC='\033[0m' # No Color
echo -e "${RED} Starting......"
export COMPOSER_ALLOW_SUPERUSER=1;
read -p "Vui lòng nhập tên thư mục laravel-project: " projectname
composer create-project laravel/laravel $projectname;
cd $projectname;
composer require laravel/jetstream
php artisan jetstream:install livewire
composer require nwidart/laravel-modules
php artisan vendor:publish --provider="Nwidart\Modules\LaravelModulesServiceProvider"
composer require mhmiton/laravel-modules-livewire
composer require toanld/modules-inertia
composer require tightenco/ziggy
php "$( dirname -- "${BASH_SOURCE[0]}" )/artisan" inertia:middleware
php artisan vendor:publish --tag=modules-livewire-config

composer require hungnm28/laravel-form
yes|php "$( dirname -- "${BASH_SOURCE[0]}" )/artisan" lf:composer
composer require toanld/laravel-debug-to-sql
composer require toanld/multi-relationships
composer require barryvdh/laravel-debugbar --dev
composer require toanld/laravel-create-mysql-db
php "$( dirname -- "${BASH_SOURCE[0]}" )/artisan" lf:use-webpack
php "$( dirname -- "${BASH_SOURCE[0]}" )/artisan" lf:create-database
php "$( dirname -- "${BASH_SOURCE[0]}" )/artisan" migrate
php "$( dirname -- "${BASH_SOURCE[0]}" )/artisan" lf:new-admin Admin
php "$( dirname -- "${BASH_SOURCE[0]}" )/artisan" lf:create-admin-user
chmod 755 "$( dirname -- "${BASH_SOURCE[0]}" )/npm-module"
chmod 755 "$( dirname -- "${BASH_SOURCE[0]}" )/git-push"
cd "$( dirname -- "${BASH_SOURCE[0]}" )/Modules/Admin" && npm install && npm run dev
cd $projectname && php "$( dirname -- "${BASH_SOURCE[0]}" )/artisan" serv

