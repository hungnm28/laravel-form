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

    public function handle()
    {
        $this->info("Make Admin Module");
        $this->initModule();
        $this->initRouteServiceProvider();
        $this->installAdminModule("Icons", "Listing");

        $this->installAdminModule("PermissionConfigs", "Listing");
        $this->installAdminModule("PermissionConfigs", "Create");

        $this->installAdminModule("Menus", "Listing");
        $this->installAdminModule("Menus", "Create");
        $this->installAdminModule("Menus", "Edit");

        $this->installAdminModule("Permissions", "Index");
        $this->installAdminModule("Permissions", "Listing");
        $this->installAdminModule("Permissions", "Edit");
        $this->installAdminModule("Permissions", "Create");
        $this->installAdminModule("Permissions", "Show");

        $this->installAdminModule("Admins", "Index");
        $this->installAdminModule("Admins", "Listing");
        $this->installAdminModule("Admins", "Edit");
        $this->installAdminModule("Admins", "Create");
        $this->installAdminModule("Admins", "Show");

        $this->installAdminModule("Roles", "Index");
        $this->installAdminModule("Roles", "Listing");
        $this->installAdminModule("Roles", "Edit");
        $this->installAdminModule("Roles", "Create");
        $this->installAdminModule("Roles", "Show");

        $this->installAdminModule("Users", "Index");
        $this->installAdminModule("Users", "Listing");
        $this->installAdminModule("Users", "Edit");
        $this->installAdminModule("Users", "Create");
        $this->installAdminModule("Users", "Show");
        $this->addAdminNavbar();
        $this->installRoute();
        $this->addPermission();
        $this->installMenu();
    }

    private function initModule()
    {
        $this->module = Module::findOrFail($this->argument("name"));
        $this->classPath = $this->module->getPath() . "/Http/Livewire";
        $this->viewPath = $this->module->getPath() . "/Resources/views/livewire";
    }

    private function initRouteServiceProvider()
    {
        $stub = $this->getStub("admin/Provider/RouteServiceProvider.php.stub");
        $template = str_replace([
            "DumpMyModuleName"
            , "DumpMyModuleSlug"
            ,"DumpMyModuleLowerName"

        ], [
            $this->module->getName(),
            $this->getModuleSug()
            ,$this->getModuleLowerName()
        ], $stub);
        $pathSave = $this->module->getPath() . "/Providers/RouteServiceProvider.php";
        $this->writeFile($pathSave, $template);
    }

    private function addAdminNavbar()
    {
        $stub = $this->getStub("/admin/Config/menu.php.stub");
        $pathSave = $this->module->getPath() . "/Config/menu.php";

        $template = str_replace([
            "DumpMyLowerName"
            , "DumpMyRouteName"
            , "DumpMyPermission"
            , "DumpMyModuleHeadName"
        ], [
            $this->module->getLowerName()
            , $this->getRouteName()
            , $this->getPermissionName()
            , $this->getModuleHeadName()
        ], $stub);
        $this->writeFile($pathSave, $template);
    }

    private function addPermission()
    {
        $stub = $this->getStub("/admin/Config/permission.php.stub");
        $pathSave = $this->module->getPath() . "/Config/permission.php";

        $template = str_replace([
            "DumpMyLowerName"
            , "DumpMyRouteName"
            , "DumpMyModuleSlug"
        ], [
            $this->module->getLowerName()
            , $this->getRouteName()
            , $this->getModuleSug()
        ], $stub);
        $this->writeFile($pathSave, $template);
    }


    protected function installAdminModule($path, $file)
    {
        $this->installAdminClass($path, $file);
        $this->installAdminView($path, $file);
    }

    private function installAdminClass($path, $file)
    {
        $stub = $this->getStub("Admin/$path/$file.php.stub");
        $arrPath = explode("/", $path);
        $pathSave = $this->classPath;
        foreach ($arrPath as $path) {
            $pathSave .= "/$path";
        }
        $pathSave = $pathSave . "/$file.php";
        $template = str_replace([
            'DumpMyModuleName'
            , 'DumpMyModuleView'
            , 'DumpMyRouteName'
            , 'DumpMyModuleHeadName'
            , 'DumpMyModuleLowerName'
            , 'DumpMyModuleSlug'
        ], [
            $this->module->getName()
            , $this->getModuleSug()
            , $this->getModuleSug()
            , $this->getModuleHeadName()
            , $this->getModuleLowerName()
            , $this->getModuleSug()


        ], $stub);

        $this->writeFile($pathSave, $template);

    }

    private function installAdminView($path, $file)
    {
        $file = $this->getSnakeString($file);
        $stub = $this->getStub("Admin/$path/$file.blade.php.stub");
        $arrPath = explode("/", $path);
        $pathSave = $this->viewPath;
        foreach ($arrPath as $path) {
            $pathSave .= "/" . $this->getSnakeString($path);
        }
        $pathSave = $pathSave . "/$file.blade.php";
        $template = str_replace([
            'DumpMyRouteName'
            , 'DumpMyModuleLowerName'
            , 'DumpMyModuleSlug'
        ], [
            $this->getSnakeString($this->module->getName())
            , $this->getModuleLowerName()
            , $this->getModuleSug()

        ], $stub);
        $this->writeFile($pathSave, $template);

    }

    private function installMenu()
    {
        $stub = $this->getStub("admin/layouts/menu.blade.php.stub");
        $pathSave = $this->module->getPath() . "/Resources/views/components/menu.blade.php";
        $template = str_replace([
            'DumpMyModuleName'
            , 'DumpMyModuleView'
            , 'DumpMyRouteName'
            , 'DumpMyModuleSlug'
            , 'DumpMyModuleLowerName'
            , 'DumpMyModuleHeadName'
        ], [
            $this->module->getName()
            , $this->module->getLowerName()
            , $this->getRouteName()
            , $this->getModuleSug()
            , $this->getModuleLowerName()
            , $this->getModuleHeadName()

        ], $stub);

        $this->writeFile($pathSave, $template);
    }

    private function installRoute()
    {
        $stub = $this->getStub("admin/Routes/web.php.stub");
        $pathSave = $this->module->getPath() . "/Routes/web.php";
        $template = str_replace([
            'DumpMyModuleName'
            , 'DumpMyModuleView'
            , 'DumpMyRouteName'
            , 'DumpMyModuleSlug'
            , 'DumpMyModuleLowerName'
        ], [
            $this->module->getName()
            , $this->module->getLowerName()
            , $this->getRouteName()
            , $this->getModuleSug()
            , $this->getModuleLowerName()

        ], $stub);

        $this->writeFile($pathSave, $template);
    }
}
