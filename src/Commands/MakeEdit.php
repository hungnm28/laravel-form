<?php

namespace Hungnm28\LaravelForm\Commands;


use Hungnm28\LaravelForm\Traits\WithCommandTrait;
use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Nwidart\Modules\Facades\Module;

class MakeEdit extends Command
{
    use WithCommandTrait;

    protected $signature = 'lf:make-edit {name} {module} {--pre=} {--model=}';

    protected $description = 'Make edit Page: ';

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
        $stub = $this->getStub("Edit.php.stub");

        $listField = '';
        $rules = '';
        $createFields = '';
        $mountFields = '';
        foreach ($this->fields as $f => $field) {
            if (!in_array($f, $this->reservedColumn)) {
                if ($field->default) {
                    $listField .= '$' . $f . "= $field->default, ";
                } else {
                    $listField .= '$' . $f . ", ";
                }
                $rules .= "'$f' => '$field->rule', \r\n\t\t\t";
                $createFields .= "'$f' => \$this->$f, \r\n\t\t\t";
                $mountFields .= "\$this->$f = \$data->$f; \r\n\t\t";
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
            , 'DumpMyMountFields'
            , 'DumpMyModelClassName'
            , 'DumpMyEditFields'
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
            , $mountFields
            , $this->modelName
            , $createFields
            , $this->getRouteName()
            , $this->gerViewDot()
            , $this->getSnakeString($this->module->getName())
            , $breadcrumb
            , $this->getHeadline($this->pageName)
        ], $stub);
        $pathSave = $this->classPath . "/Edit.php";
        $this->writeFile($pathSave, $template);
    }

    private function createView()
    {
        $stub = $this->getStub("edit.blade.php.stub");
        $fields = "";
        foreach ($this->fields as $f => $field) {
            if (in_array($f, $this->reservedColumn)) continue;
            switch ($field->type) {
                case "boolean":
                    $fields .= '<x-lf.form.toggle name="' . $f . '" label="' . $field->label . '" />' . " \r\n\t\t";
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
            ,'DumpMyPermission'
        ],
            [
                $fields
                , $this->getRouteName()
                ,$this->getPermissionName()
            ],
            $stub);
        $pathSave = $this->viewPath . "/edit.blade.php";
        $this->writeFile($pathSave, $template);
    }


}
