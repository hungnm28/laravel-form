<?php

namespace Hungnm28\LaravelForm\Commands;


use Hungnm28\LaravelForm\Traits\WithCommandTrait;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class InitRoute extends Command
{
    use WithCommandTrait;

    protected $signature = 'lf:init-route {name} {--force}';

    protected $description = 'Init Route: ';


    public function handle()
    {
        $name = $this->argument("name");
        $this->info($this->description . $name);
        $this->initModule($name);
        if (!$this->checkModule($name)) {
            $this->error("Module: $name not exits");
            return false;
        }

        $this->installRoute();
        $this->replaceRouteServiceProvider();
        return true;
    }

    private function installRoute(){
        $endTag = "//---END-OF-ROUTES---//";
        if (!Str::contains(file_get_contents($this->getModulepath('Routes/web.php')), $endTag)) {
            $stub = $this->getStub("web.php.stub");
            $name = $this->argument("name");
            $template = str_replace([
                "DumpMyPrefix"
                , "DumpMyName"
                , "DumpMyModule"
                ,"DumpMyPermission"
            ], [
                $this->getModuleSug()
                , $this->getModuleName()
                , $name
                ,$this->getModuleSug()
            ], $stub);
            $this->writeFile(module_path($name, "Routes/web.php"), $template);
        }
    }

    private function replaceRouteServiceProvider()
    {
        $name = $this->argument("name");
        $stub = $this->getStub("RouteServiceProvider.php.stub");
        $template = str_replace([
            "DumpMyModuleName"
            , "DumpMyModuleSlug"
        ], [
            $name,
            $this->getModuleSug()
        ], $stub);

        $this->writeFile(module_path($name, "Providers/RouteServiceProvider.php"), $template);


    }

}
