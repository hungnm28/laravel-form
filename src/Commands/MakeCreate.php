<?php

namespace Hungnm28\LaravelForm\Commands;


use Hungnm28\LaravelForm\Traits\WithCommandTrait;
use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Nwidart\Modules\Facades\Module;

class MakeCreate extends Command
{
    use WithCommandTrait;

    protected $signature = 'lf:make-create {name} {module} {--pre=} {--model=}';

    protected $description = 'Make create Page: ';

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
        $stub = $this->getStub("Create.php.stub");
        $listField = '';
        $rules = '';
        $createFields = '';

        foreach ($this->fields as $f => $field) {
            if (!in_array($f, $this->reservedColumn)) {
                $default = $field->default;
                switch ($field->type){
                    case "json": $default = '[]';
                    break;
                }
                if ($default) {
                    $listField .= '$' . $f . "= $default, ";
                } else {
                    $listField .= '$' . $f . ", ";
                }
                $rules .= "'$f' => '$field->rule', \r\n\t\t";
                $createFields .= "'$f' => \$this->$f, \r\n\t\t";
            }
        }
        $listField = trim($listField, ', ');
        $routes = $this->getArrRoutes();
        $breadcrumb = "";
        foreach ($routes as $k => $title) {
            $breadcrumb .= 'lForm()->pushBreadcrumb(route("' . $k . '"),"' . $title . '");' . " \r\n\t\t";
        }
        $template = str_replace([
            'DumpMyNamespace'
            , 'DumpMyModelNamespace'
            , 'DumpMyListFields'
            , 'DumpMyRules'
            , 'DumpMyPermission'
            , 'DumpMyModelClassName'
            , 'DumpMyCreateFields'
            , 'DumpMyRoute'
            , 'DumpMyView'
            , 'DumpMyModuleName'
            , 'DumpMyBreadcrumb'
            , 'DumpMyPageName'
        ], [
            $this->getNamespace()
            , $this->getModelNamspace()
            , $listField
            , $rules
            , $this->getPermissionName()
            , $this->modelName
            , $createFields
            , $this->getRouteName()
            , $this->gerViewDot()
            , $this->getSnakeString($this->module->getName())
            , $breadcrumb
            , $this->getHeadline($this->pageName)
        ], $stub);
        $pathSave = $this->classPath . "/Create.php";
        $this->writeFile($pathSave, $template);
    }

    private function createView()
    {
        $stub = $this->getStub("create.blade.php.stub");
        $fields = "";
        foreach ($this->fields as $f => $field) {
            if(in_array($f,$this->reservedColumn)) continue;
            switch ($field->type) {
                case "boolean":
                    $fields .= '<x-lf.form.toggle name="' . $f . '" label="' . $field->label . '" />' . " \r\n\t\t";
                    break;
                case "text":
                    $fields .= '<x-lf.form.textarea name="' . $f . '" label="' . $field->label . '" />' . " \r\n\t\t";
                    break;
                case "json":
                    $fields .= '<x-lf.form.array name="' . $f . '" label="' . $field->label . '" placeholder="' . $field->label . ' ..." :params="$' . $f . '"/>' . " \r\n\t\t";
                    break;
                default:
                    $fields .= '<x-lf.form.input name="' . $f . '" type="' . $field->type . '" label="' . $field->label . '" placeholder="' . $field->label . ' ..."/>' . " \r\n\t\t";
            }
        }
        $template = str_replace([
            'DumpMyFields'
            , 'DumpMyRoute'
        ],
            [
                $fields
                , $this->getRouteName()
            ],
            $stub);
        $pathSave = $this->viewPath . "/create.blade.php";
        $this->writeFile($pathSave, $template);
    }


}
