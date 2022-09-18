<?php

namespace Hungnm28\LaravelForm\Commands;


use Hungnm28\LaravelForm\Traits\WithCommandTrait;
use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Nwidart\Modules\Facades\Module;

class MakeRoute extends Command
{
    use WithCommandTrait;

    protected $signature = 'lf:make-route {name} {module} {--force}';

    protected $description = 'Make Route Page: ';

    protected $folder;

    public function handle()
    {
        $this->initPath($this->argument("name"));
        $this->initModule($this->argument("module"));
        $this->info($this->description . $this->argument("name"));

        $this->createRoute();

        return true;
    }

    private function createRoute()
    {
        $path = $this->path;
        $pageName = Str::afterLast($path,"/");
        $stub = $this->getStub("route.stub");
        $endTag = "//---END-OF-".Str::upper($pageName)."---//";
        $template = str_replace([
            'DumpMyPrefix'
            ,'DumpMyRouteName'
            , 'DumpMyModuleName'
            , 'DumpMyPermission'
            ,'DumpMyClassPath'
            ,'DumpMyTag'

        ], [
            Str::slug(Str::headline($pageName))
            ,Str::slug(Str::headline($pageName))
            ,$this->getModuleName()
            , $this->getPermissionName()
            ,str_replace("/","\\",$this->path)
            ,$endTag
        ], $stub);

        $pre = Str::beforeLast($this->path,"$pageName");
        $pre = trim($pre,"/");
        if($pre !=""){
            $preTag = "//---END-OF-".Str::upper($pre)."---//";
        }else{
            $preTag = "//---END-OF-ROUTES---//";
        }
        $this->installRoute($template,$preTag);

    }

    protected function installRoute($routes,$flag)
    {
        if (!Str::contains($appRoutes = file_get_contents($this->getModulepath('Routes/web.php')), $routes)) {
            file_put_contents($this->getModulepath('Routes/web.php'), str_replace(
                $flag,
                $routes . PHP_EOL . $flag,
                $appRoutes
            ));
        }
    }
}
