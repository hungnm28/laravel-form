<?php

namespace Hungnm28\LaravelForm\Commands;


use Hungnm28\LaravelForm\Traits\WithCommandTrait;
use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Nwidart\Modules\Facades\Module;

class MakeRoute extends Command
{
    use WithCommandTrait;

    protected $signature = 'lf:make-route {name} {module} {--pre=}';

    protected $description = 'Make Route Page: ';

    protected $folder;

    public function handle()
    {
        $moduleName = $this->argument("module");
        if (!$this->checkModule($moduleName)) {
            $this->error("Module: $moduleName not exits");
            return false;
        }
        $this->info($this->description . $this->argument("name"));

        $this->createRoute();

        return true;
    }

    private function createRoute()
    {
        $pageName = $this->argument("name");
        $moduleName = $this->argument("module");

        $stub = $this->getStub("route.stub");
        $template = str_replace([
            'DumpMyPrefix'
            , 'DumMyNamespace'
            , 'DumMyPermission'
            ,'DumpMyTag'

        ], [
            $this->getModuleSug($this->module)
            , $this->getModelNamspace()
            , $this->getPermissionName()
            ,"//---END-OF-".Str::upper($this->pageName)."---//"
        ], $stub);
        $pathSave = module_path($this->module) . "/Route/web.php";

      dd($pathSave,$template);
    }
}
