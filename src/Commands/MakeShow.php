<?php

namespace Hungnm28\LaravelForm\Commands;


use Hungnm28\LaravelForm\Traits\WithCommandTrait;
use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Nwidart\Modules\Facades\Module;

class MakeShow extends Command
{
    use WithCommandTrait;

    protected $signature = 'lf:make-show {name} {module} {--pre=} {--model=}';

    protected $description = 'Make show Page: ';

    protected $folder;

    public function handle()
    {

        $this->initPage();
        $this->info($this->description . $this->pageName);
        $this->getModelFields($this->modelName);
        $this->createClass();
        $this->createView();
        return true;
    }

    private function createClass()
    {
        $stub = $this->getStub("Show.php.stub");
        $routes = $this->getArrRoutes("edit");
        $breadcrumb = "";
        foreach ($routes as $k => $title) {
            $breadcrumb .= 'lForm()->pushBreadcrumb(route("' . $k . '"),"' . $title . '");' . " \r\n\t\t";
        }
        $template = str_replace([
            'DumpMyNamespace'
            , 'DumpMyModelNamespace'
            , 'DumpMyPermission'
            , 'DumpMyModelClassName'
            , 'DumpMyBreadcrumb'
            , 'DumpMyRoute'
            , 'DumpMyView'
            , 'DumpMyModuleName'
            , 'DumpMyPageName'
        ], [
            $this->getNamespace()
            , $this->getModelNamspace()
            , $this->getPermissionName()
            , $this->modelName
            , $breadcrumb
            , $this->getRouteName()
            , $this->gerViewDot()
            , $this->getSnakeString($this->module->getName())
            , $this->getHeadline($this->pageName)
        ], $stub);
        $pathSave = $this->classPath . "/Show.php";
        $this->writeFile($pathSave, $template);
    }

    private function createView()
    {
        $stub = $this->getStub("show.blade.php.stub");
        $fields = "";
        foreach ($this->fields as $f => $field) {
            if (in_array($f, $this->reservedColumn)) continue;
            $fields .= '<tr>
                <th class="text-right pr-2">' . $f . ':</th>
                <td>{{$data->' . $f . '}}</td>
            </tr>';
        }
        $template = str_replace([
            'DumpMyFields'
            , 'DumpMyRoute'
            , 'DumpMyPermission'
        ],
            [
                $fields
                , $this->getRouteName()
                , $this->getPermissionName()
            ],
            $stub);
        $pathSave = $this->viewPath . "/show.blade.php";
        $this->writeFile($pathSave, $template);
    }


}
