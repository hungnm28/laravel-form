<?php

namespace Hungnm28\LaravelForm\Commands;


use Hungnm28\LaravelForm\Traits\WithCommandTrait;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;


class InitMix extends Command
{
    use WithCommandTrait;

    protected $signature = 'lf:init-mix {name} {--force}';

    protected $description = 'Init Mix: ';


    public function handle()
    {
        $name = $this->argument("name");
        $this->info($this->description . $name);
        if(!$this->checkModule($name)){
            $this->error("Module: $name not exits");
            return false;
        }
        (new Filesystem)->copyDirectory(__DIR__ . '/../../publishes/mix', module_path($name));
        $path = module_path($name,'Resources/assets');
        (new Filesystem)->copyDirectory(__DIR__ . '/../../publishes/Resources/assets', $path);
        $stub = $this->getStub("webpack.mix.js.stub");
        $template = str_replace([
            "DumpMyFile"
        ],Str::slug($name),$stub);
        $this->writeFile(module_path($name,'webpack.mix.js'),$template);
        return true;

    }


}
