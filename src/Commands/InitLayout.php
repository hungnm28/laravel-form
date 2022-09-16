<?php

namespace Hungnm28\LaravelForm\Commands;


use Hungnm28\LaravelForm\Traits\WithCommandTrait;
use Illuminate\Console\Command;
use Nwidart\Modules\Facades\Module;

class InitLayout extends Command
{
    use WithCommandTrait;

    protected $signature = 'lf:init-layout {name} {--force}';

    protected $description = 'Init layout: ';

    private $module;

    public function handle()
    {
        $name = $this->argument("name");
        $this->module = $name;
        $this->info($this->description . $name);
        if (!$this->checkModule($name)) {
            $this->error("Module: $name not exits");
            return false;
        }

        $this->copyHeaderBar();
        $this->copyNavbar();
        $this->copyLayout();
        $this->copyHomeController();
        $this->copyHomePage();
        return true;
    }

    private function copyHeaderBar(){
        $this->info("Copy HeaderBar.php");
        $stub = $this->getStub('layouts/HeaderBar.php.stub');
        $tempplate = str_replace([
            "DumpMyModule"
            ,"DumpMyComponent"
        ],[
            $this->module
            ,$this->getModuleSug($this->module)
        ],$stub);
        $this->writeFile(module_path($this->module,"Views/Components/HeaderBar.php"),$tempplate);


        $this->info("Copy header-bar.blade.php");

        $stub = $this->getStub("layouts/header-bar.blade.php.stub");
        $tempplate = str_replace([
            "DumpMyModule"
            ,"DumpMyAssets"
        ],[
            $this->module
            ,$this->getModuleSug($this->module)
        ],$stub);
        $this->writeFile(module_path($this->module,"Resources/views/components/header-bar.blade.php"),$tempplate);

    }

    private function copyNavbar(){
        $module= Module::findOrFail($this->module);
        $this->info("Copy Navbar.php");
        $stub = $this->getStub('layouts/Navbar.php.stub');
        $tempplate = str_replace([
            "DumpMyConfig"
            ,"DumpMyModule"
            ,"DumpMyComponent"
        ],[
            $module->getLowerName()
            ,$this->module
            ,$this->getModuleSug($this->module)
        ],$stub);
        $this->writeFile(module_path($this->module,"Views/Components/Navbar.php"),$tempplate);

        $this->info("Copy navbar.blade.php");
        $stub = $this->getStub("layouts/navbar.blade.php.stub");
        $tempplate = str_replace([
            "DumpMyHomeRoute"
        ],[
            $this->getModuleSug($this->module)
        ],$stub);
        $this->writeFile(module_path($this->module,"Resources/views/components/navbar.blade.php"),$tempplate);

    }


    private function copyLayout(){
        $this->info("Copy LayoutMaster.php");
        $stub = $this->getStub('layouts/LayoutMaster.php.stub');
        $tempplate = str_replace([
           "DumpMyModule"
            ,"DumpMyComponent"
        ],[

            $this->module
            ,$this->getModuleSug($this->module)
        ],$stub);
        $this->writeFile(module_path($this->module,"Views/Components/LayoutMaster.php"),$tempplate);

        $this->info("Copy master.blade.php");

        $stub = $this->getStub("layouts/master.blade.php.stub");
        $tempplate = str_replace([
            "DumpMyModule"
            ,"DumpMyAssets"
            ,"DumpMyComponent"
        ],[
            $this->module
            ,$this->getModuleSug($this->module)
            ,$this->getModuleSug($this->module)
        ],$stub);
        $this->writeFile(module_path($this->module,"Resources/views/layouts/master.blade.php"),$tempplate);

    }

    private function copyHomePage(){
        $this->info("Copy index.blade.php");
        $stub = $this->getStub('layouts/index.blade.php.stub');
        $tempplate = str_replace([
            "DumpMyComponent"
            ,"DumpMyModule"
        ],[
            $this->getModuleSug($this->module)
            ,$this->module
        ],$stub);
        $this->writeFile(module_path($this->module,"Resources/views/index.blade.php"),$tempplate);

    }
    private function copyHomeController(){
        $this->info("Copy HomeController.php");
        $stub = $this->getStub('/HomeController.php.stub');
        $tempplate = str_replace([
            "DumpMyModuleName"
            ,"DumpMyModuleSlug"
        ],[
            $this->module
            ,$this->getModuleSug($this->module)
        ],$stub);
        $this->writeFile(module_path($this->module,"Http/Controllers/HomeController.php"),$tempplate);

    }
}
