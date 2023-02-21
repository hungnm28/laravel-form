# Create new project use laravel-form

## 1. Create new Laravel project
Laravel document: [Laravel document](https://laravel.com/docs/10.x).
```sh
    composer create-project laravel/laravel example-app
    cd example-app
```
## 2. Install jetstream  use livewire
Jetstram document: [Jetstram document](https://jetstream.laravel.com/3.x/introduction.html).
```sh
     composer require laravel/jetstream
```
```sh
    php artisan jetstream:install livewire
```
## 3. Install nwidart/laravel-modules
Laravel-module document: [Laravel-module document](https://docs.laravelmodules.com/v9/installation-and-setup).
```sh
    composer require nwidart/laravel-modules
```
```sh
    php artisan vendor:publish --provider="Nwidart\Modules\LaravelModulesServiceProvider"
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

## 5. User simple html dom
document: [simple_html_dom](https://simplehtmldom.sourceforge.io/docs/1.9/index.html).

1. create floder /helpers
2. [download simple_html_dom](https://sourceforge.net/projects/simplehtmldom/).
3. add file  simple_html_dom.php to folder helpers
4. create file /helpers/includes.php
```php
    <?php 
       require_once __DIR__ . "/simple_html_dom.php";
```
5. Add Autoloading
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
    },
      "files": [
          "helpers/includes.php"
      ]
  }
}
```
# dumpautoload
```shell
   composer dump-autoload
```

## 6. Install laravel-form
```sh
composer require hungnm28/laravel-form
```

Add this to .env file
```sh
ASSET_URL=/dev

```
Add to end of file .env


```sh
MIX_PUSHER_APP_KEY="${PUSHER_APP_KEY}"
MIX_PUSHER_APP_CLUSTER="${PUSHER_APP_CLUSTER}"

```
