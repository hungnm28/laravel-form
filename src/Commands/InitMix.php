<?php

namespace Hungnm28\LaravelForm\Commands;


use Hungnm28\LaravelForm\Traits\WithCommandTrait;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\File;


class InitMix extends Command
{
    use WithCommandTrait;

    protected $signature = 'lf:init-mix {name} {--force}';

    protected $description = 'Init Mix: ';


    public function handle()
    {
        $name = $this->argument("name");
        $this->info($this->description . $name);
        $this->initModule($name);
        if(!$this->checkModule($name)){
            $this->error("Module: $name not exits");
            return false;
        }
        (new Filesystem)->copyDirectory(__DIR__ . '/../../publishes/mix', module_path($name));
        $path = module_path($name,'Resources/assets');
        $pathSource = base_path('stubs/laravel-form-stubs/assets');
        if(!File::exists($pathSource)){
            $pathSource = __DIR__ . "/../Commands/stubs/assets";
        }

        (new Filesystem)->copyDirectory($pathSource, $path);
        $stub = $this->getStub("webpack.mix.js.stub");
        $template = str_replace([
            "DumpMyFile"
        ],$this->getModuleSug(),$stub);
        $this->writeFile(module_path($name,'webpack.mix.js'),$template);
        return true;

    }


}
