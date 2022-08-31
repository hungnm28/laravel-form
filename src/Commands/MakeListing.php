<?php

namespace Hungnm28\LaravelForm\Commands;


use Hungnm28\LaravelForm\Traits\WithCommandTrait;
use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Nwidart\Modules\Facades\Module;

class MakeListing extends Command
{
    use WithCommandTrait;

    protected $signature = 'lf:make-listing {name} {module} {--pre=} {--model=}';

    protected $description = 'Make listing Page: ';

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
        $stub = $this->getStub("Listing.php.stub");
        $routes = $this->getArrRoutes();
        $breadcrumb = "";
        foreach ($routes as $k => $title) {
            $breadcrumb .= 'lForm()->pushBreadcrumb(route("' . $k . '"),"' . $title . '");' . " \r\n\t\t";
        }
        $fields = "";
        foreach ($this->fields as $f => $field) {
            $fields .= '
            "' . $f . '" => [
                        "status" => true
                        , "label" => "' . $this->getHeadline($f) . '"
                    ],
            ';
        }

        $template = str_replace([
            'DumpMyNamespace'
            , 'DumpMyModelNamespace'
            , 'DumpMyFields'
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
            , $fields
            , $this->getPermissionName()
            , $this->modelName
            , $breadcrumb
            , $this->getRouteName()
            , $this->gerViewDot()
            , $this->getSnakeString($this->module->getName())
            , $this->getHeadline($this->pageName)
        ], $stub);
        $pathSave = $this->classPath . "/Listing.php";
        $this->writeFile($pathSave, $template);
    }

    private function createView()
    {
        $stub = $this->getStub("listing.blade.php.stub");
        $fields = "";
        $titleFields = "";
        foreach ($this->fields as $f => $field) {
            if ($f == "id") continue;

            $titleFields .= '@if(data_get($fields,"' . $f . '.status"))
                <th>' . $this->getHeadline($f) . '</th>
            @endif
            ';

            $fields .= '@if(data_get($fields,"' . $f . '.status"))
                    <td>{{$item->' . $f . '}}</td>
                @endif
                ';
        }
        $template = str_replace([
            'DumpMyTitleFields'
            ,'DumpMyFields'
            , 'DumpMyRoute'
            , 'DumpMyPermission'
        ],
            [
                $titleFields
                ,$fields
                , $this->getRouteName()
                , $this->getPermissionName()
            ],
            $stub);
        $pathSave = $this->viewPath . "/listing.blade.php";
        $this->writeFile($pathSave, $template);
    }


}
