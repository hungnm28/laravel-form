<?php

namespace Hungnm28\LaravelForm\Commands;


use Hungnm28\LaravelForm\Traits\WithCommandTrait;
use Illuminate\Console\Command;
use Nwidart\Modules\Facades\Module;

class InitLayout extends Command
{
    use WithCommandTrait;

    protected $signature = 'lf:init-layout {name} {--force}';

    protected $description = 'Init layout ';


    public function handle()
    {
        $name = $this->argument("name");

        $this->info("Init Layout" . $name);
        $this->initModule($name);

        $this->copyHeaderBar();
        $this->copyNavbar();
        $this->copyLayout();
        $this->copyHomePage();
        return true;
    }

    private function copyHeaderBar(){
        $this->info("Copy HeaderBar.php");
        $this->makeFile('layouts/HeaderBar.php.stub', $this->getModulepath("Views/Components/HeaderBar.php"));

        $this->info("Copy header-bar.blade.php");
        $this->makeFile('layouts/header-bar.blade.php.stub', $this->getModulepath("Resources/views/components/header-bar.blade.php"));
    }

    private function copyNavbar(){
        $module= Module::findOrFail($this->module);
        $this->info("Copy Menu.php");
        $this->makeFile('layouts/Menu.php.stub', $this->getModulepath("Views/Components/Menu.php"));

        $this->info("Copy menu.blade.php");
        $this->makeFile('layouts/menu.blade.php.stub', $this->getModulepath("Resources/views/components/menu.blade.php"));
    }


    private function copyLayout(){
        $this->info("Copy LayoutMaster.php");
        $this->makeFile('layouts/LayoutMaster.php.stub', $this->getModulepath("Views/Components/LayoutMaster.php"));

        $this->info("Copy master.blade.php");
        $this->makeFile('layouts/master.blade.php.stub', $this->getModulepath("Resources/views/layouts/master.blade.php"));
    }

    private function copyHomePage(){
        $this->info("Copy index.blade.php");
        $this->makeFile('layouts/index.blade.php.stub', $this->getModulepath("Resources/views/index.blade.php"));
        $this->info("Copy HomeController.php");
        $this->makeFile('HomeController.php.stub', $this->getModulepath("Http/Controllers/HomeController.php"));

    }

    private function makeFile($stubPath,$pathSave){
        $stub = $this->getStub($stubPath);
        $tempplate = str_replace([
            "DumpMyModuleName"
            ,"DumpMyModuleLowerName"
            ,"DumpMyModuleHeadName"
            ,"DumpMyModuleSlug"
            ,"DumpMyRoute"
            ,"DumpMyAssets"
        ],[
            $this->getModuleName()
            ,$this->getModuleLowerName()
            ,$this->getModuleHeadName()
            ,$this->getModuleSug()
            ,$this->getRouteName()
            ,$this->getModuleSug()
        ],$stub);
        $this->writeFile($pathSave,$tempplate);
    }
}
