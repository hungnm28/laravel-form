# Laravel module admin
### The package used for create laravel admin.


## Installation

Requires [Laravel Module](https://nwidart.com/laravel-modules/v6/introduction) 6.0+ to run.

Install:

```sh
composer require hungnm28/laravel-form
```
Create module admin by [Laravel Module](https://nwidart.com/laravel-modules/v6/basic-usage/creating-a-module)



Add this to .env file
```sh
ASSET_ICON=/assets
```

## Create new Module
```sh
php artisan lf:new-module <Module Name>

cd Modules/<Module name>
npm install
npm run dev

```
## Create new Admin
```sh
php artisan lf:new-admin <Module Name>

cd Modules/<Module name>
npm install
npm run dev

```
## Create new Admin User
```sh
php artisan lf:new-admin-admin

```


## Init Icon
```sh
    php artisan lf:init-icon
```

## Create Page
```sh
    php artisan lf:make-page <Page name> <Module Name> {--model=} {--pre=}
```

