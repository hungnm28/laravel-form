<?php

namespace Hungnm28\LaravelForm\Commands;


use Hungnm28\LaravelForm\Traits\WithCommandTrait;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;

class InitProvider extends Command
{
    use WithCommandTrait;

    protected $signature = 'lf:init-provider {name} {--force}';

    protected $description = 'Init provider: ';


    public function handle()
    {
        $name = $this->argument("name");
        $this->info($this->description . $name);
        if(!$this->checkModule($name)){
            $this->error("Module: $name not exits");
            return false;
        }
        (new Filesystem)->copy(__DIR__ . '/../../publishes/Config/navbar.php', module_path($name,'Config/navbar.php'));

        $stub = $this->getStub("ModuleServiceProvider.php.stub");
        $template = str_replace([
            "DumpMyNamespace"
            ,"DumMyModuleName"
            ,"DumMyModuleLower"
            ,"DumMyComponent"
        ],[
            $name,
            $name,
            Str::slug($name),
            Str::slug($name),
        ],$stub);
        $this->writeFile(module_path($name,"Providers/" . $name . "ServiceProvider.php"),$template);


        return true;
    }


}
