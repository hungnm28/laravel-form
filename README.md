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
ASSET_URL=/dev
ASSET_ICON=/assets
APP_SUPER_ADMIN=<list super admin id eg: 1,2,3>
```

Run command
```sh
php artisan lf:init-module <Module Name> --all

cd Modules/<Module name>
npm install
npm run dev

```
## Init Icon
```sh
    php artisan lf:init-icon
```

## Create Page
```sh
    php artisan lf:make-page <Page name> <Module Name> {--model=} {--pre=}
```

