<?php

namespace Hungnm28\LaravelForm\Commands;


use Hungnm28\LaravelForm\Traits\WithCommandTrait;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;


class InitAuth extends Command
{
    use WithCommandTrait;

    protected $signature = 'lf:init-auth {--force}';

    protected $description = 'Make admin middleware ';

    public function handle()
    {
        $this->info("Init Auth");
        $this->call("vendor:publish",['--tag'=>'laravel-form-database']);
        $this->copyModel();
        $this->copyConfig();
        $this->copyProvider();
        $this->copyMiddleware();

    }

    private function copyModel(){
        $pathSave = app_path("Traits/HasPermissionsTrait.php");
        $this->info("Make File: $pathSave");
        (new Filesystem())->copy(__DIR__ ."/stubs/app/Traits/HasPermissionsTrait.php.stub",$pathSave);
        $pathSave = app_path("Models/User.php");
        $this->info("Make File: $pathSave");

        (new Filesystem())->copy(__DIR__ ."/stubs/app/Models/User.php.stub",$pathSave);
        $pathSave = app_path("Models/Permission.php");
        $this->info("Make File: $pathSave");
        (new Filesystem())->copy(__DIR__ ."/stubs/app/Models/Permission.php.stub",$pathSave);
        $pathSave = app_path("Models/Role.php");
        $this->info("Make File: $pathSave");
        (new Filesystem())->copy(__DIR__ ."/stubs/app/Models/Role.php.stub",$pathSave);
    }

    private function copyConfig(){
        $pathSave = config_path("admin.php");
        $this->info("Make File: $pathSave");
        (new Filesystem())->copy(__DIR__ ."/stubs/app/config/admin.php.stub",$pathSave);
    }

    private function copyProvider(){
        $pathSave = app_path("Providers/PermissionsServiceProvider.php");
        $this->info("Make File: $pathSave");
        (new Filesystem())->copy(__DIR__ ."/stubs/app/Providers/PermissionsServiceProvider.php.stub",$pathSave);
        // register provider
        $this->installServiceProviderAfter('JetstreamServiceProvider', 'PermissionsServiceProvider');
    }

    private function copyMiddleware(){
        $pathSave = app_path("Http/Middleware/AdminMiddleware.php");
        $this->info("Make File: $pathSave");
        (new Filesystem())->copy(__DIR__ ."/stubs/app/Middleware/AdminMiddleware.php.stub",$pathSave);
        // Register Middleware
        $this->installMiddlewareAfter("'auth' => \App\Http\Middleware\Authenticate::class,","'admin' => \App\Http\Middleware\AdminMiddleware::class,");
    }
    private function installServiceProviderAfter($after, $name)
    {
        if (!Str::contains($appConfig = file_get_contents(config_path('app.php')), 'App\\Providers\\' . $name . '::class')) {
            file_put_contents(config_path('app.php'), str_replace(
                'App\\Providers\\' . $after . '::class,',
                'App\\Providers\\' . $after . '::class,' . PHP_EOL . '        App\\Providers\\' . $name . '::class,',
                $appConfig
            ));
        }
    }

    private function installMiddlewareAfter($after, $name)
    {
        $path = app_path("Http/Kernel.php");
        if (!Str::contains($appConfig = file_get_contents($path), $name)) {
            file_put_contents($path, str_replace(
                $after,
                $after . PHP_EOL ."\t\t" . $name,
                $appConfig
            ));
        }
    }
}
