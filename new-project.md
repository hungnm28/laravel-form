# Create new project use laravel-form

## 1. Create new Laravel project
Laravel document: [Laravel document](https://laravel.com/docs/10.x).
```sh
    composer create-project laravel/laravel example-app
```
## 2. Install jetstream  use livewire
Jetstram document: [Jetstram document](https://jetstream.laravel.com/3.x/introduction.html).
```sh
    composer composer require laravel/jetstream
```
```sh
    php artisan jetstream:install livewire
```
## 3. Install nwidart/laravel-modules
Laravel-module document: [Laravel-module document](https://docs.laravelmodules.com/v9/installation-and-setup).
```sh
    composer create-project laravel/laravel example-app
```
### Add Autoloading 
By default the module classes are not loaded automatically. 
You can autoload your modules using psr-4 on composer.json file. For example :
```json
    {
  "autoload": {
    "psr-4": {
      "App\\": "app/",
      "Modules\\": "Modules/",
      "Database\\Factories\\": "database/factories/",
      "Database\\Seeders\\": "database/seeders/"
    }
  }
}
```
### run autoload
```shell
   composer dump-autoload
```

## 4. Install mhmiton/laravel-modules-livewire
 document: [ mhmiton/laravel-modules-livewire](https://github.com/mhmiton/laravel-modules-livewire).

```sh 
    composer require mhmiton/laravel-modules-livewire
```
```sh 
    php artisan vendor:publish --tag=modules-livewire-config
```
