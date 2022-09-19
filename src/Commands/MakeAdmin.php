<?php

namespace Hungnm28\LaravelForm\Commands;

use Hungnm28\LaravelForm\Traits\WithCommandTrait;
use Illuminate\Console\Command;
use Nwidart\Modules\Facades\Module;

class MakeAdmin extends Command
{
    use WithCommandTrait;
    protected $signature = 'lf:make-admin {name} {--force}';

    protected $description = 'Make Admin module ';

    private $module = null;
    public function handle(){
        $this->info("Make Admin Module");
        $this->initModule();
        $this->installAdminModule("Settings","Index");
        $this->installAdminModule("Settings/Icons","Listing");
        $this->installAdminModule("Settings/Menus","Listing");
        $this->installAdminModule("Settings/Menus","Create");
        $this->installAdminModule("Settings/Menus","Edit");
        $this->addAdminNavbar();
        $this->installRoute();
    }
    private function initModule(){
        $this->module = Module::findOrFail($this->argument("name"));
        $this->classPath = $this->module->getPath() . "/Http/Livewire";
        $this->viewPath = $this->module->getPath() . "/Resources/views/livewire";
    }

    private function addAdminNavbar(){
        $stub = $this->getStub("/admin/Config/navbar.php.stub");
        $pathSave = $this->module->getPath() . "/Config/navbar.php";

        $template = str_replace([
            "DumpMyLowerName"
            ],[
                $this->module->getLowerName()
        ],$stub);
        $this->writeFile($pathSave, $template);
    }


    protected function installAdminModule($path, $file)
    {
        $this->installAdminClass($path, $file);
        $this->installAdminView($path, $file);
    }
    private function installAdminClass($path, $file){
        $stub = $this->getStub("Admin/$path/$file.php.stub");
        $arrPath = explode("/",$path);
        $pathSave = $this->classPath;
        foreach($arrPath as $path){
            $pathSave .= "/$path";
        }
        $pathSave = $pathSave."/$file.php";
        $template = str_replace([
            'DumpMyModuleName'
            ,'DumpMyModuleView'
            ,'DumpMyRouteName'
            ],[
                $this->module->getName()
                ,$this->getSnakeString($this->module->getName())
                ,$this->getSnakeString($this->module->getName())

        ],$stub);

        $this->writeFile($pathSave, $template);

    }
    private function installAdminView($path, $file){
        $file = $this->getSnakeString($file);
        $stub = $this->getStub("Admin/$path/$file.blade.php.stub");
        $arrPath = explode("/",$path);
        $pathSave = $this->viewPath;
        foreach($arrPath as $path){
            $pathSave .= "/" . $this->getSnakeString($path);
        }
        $pathSave = $pathSave."/$file.blade.php";
        $template = str_replace([
            'DumpMyRouteName'
        ],[
            $this->getSnakeString($this->module->getName())

        ],$stub);
        $this->writeFile($pathSave, $template);

    }

    private function installRoute(){
        $stub = $this->getStub("Admin/Routes/web.php.stub");
        $pathSave = $this->module->getPath()."/Routes/web.php";
        $template = str_replace([
            'DumpMyModuleName'
            ,'DumpMyModuleView'
            ,'DumpMyRouteName'
        ],[
            $this->module->getName()
            ,$this->module->getLowerName()
            ,$this->getSnakeString($this->module->getName())

        ],$stub);

        $this->writeFile($pathSave, $template);
    }
}
