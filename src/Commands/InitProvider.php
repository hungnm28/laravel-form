<?php

namespace Hungnm28\LaravelForm\Commands;


use Hungnm28\LaravelForm\Traits\WithCommandTrait;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Nwidart\Modules\Facades\Module;

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
        $this->initModule($name);
        $this->configNavbar($name);
        $this->configPermission($name);
        $this->initServicesProvider($name);
        $this->initModulePermission($name);
        $this->initModuleJson($name);
        return true;
    }

    private function configNavbar($moduleName){
        (new Filesystem)->copy(__DIR__ . '/../../publishes/Config/menu.php', module_path($moduleName,'Config/menu.php'));
    }
    private function configPermission($moduleName){
        (new Filesystem)->copy(__DIR__ . '/../../publishes/Config/permission.php', module_path($moduleName,'Config/permission.php'));
    }

    private function initModulePermission($name){
        $module = Module::findOrFail($name);
        $stub = $this->getStub("ModulePermissionServiceProvider.php.stub");
        $template = str_replace([
            "DumpMyNamespace"
            ,"DumMyModuleName"
            ,"DumMyModuleLower"
            ,"DumMyComponent"
        ],[
            $name,
            $name,
            $module->getLowerName(),
            $this->getModuleSug(),
        ],$stub);
        $this->writeFile(module_path($name,"Providers/PermissionServiceProvider.php"),$template);
    }

    private function initServicesProvider($name){
        $module = Module::findOrFail($name);
        $stub = $this->getStub("ModuleServiceProvider.php.stub");
        $template = str_replace([
            "DumpMyNamespace"
            ,"DumMyModuleName"
            ,"DumMyModuleLower"
            ,"DumMyComponent"
        ],[
            $name,
            $name,
            $module->getLowerName(),
            $this->getModuleSug(),
        ],$stub);
        $this->writeFile(module_path($name,"Providers/" . $name . "ServiceProvider.php"),$template);
    }

    private function initModuleJson($name){
        $module = Module::findOrFail($name);
        $stub = $this->getStub("module.json.stub");
        $template = str_replace([
            "DumpMyNamespace"
            ,"DumpMyModuleName"
            ,"DumpMyModuleLower"
            ,"DumpMyComponent"
        ],[
            $name,
            $name,
            $module->getLowerName(),
            $this->getModuleSug(),
        ],$stub);
        $this->writeFile(module_path($name,"module.json"),$template);
    }

}
