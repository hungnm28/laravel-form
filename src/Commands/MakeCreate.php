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
        return true;
    }

    private function createClass()
    {
        $stub = $this->getStub("Create-class.php.stub");

        $listField = '';
        $rules = '';
        $createFields = '';
        foreach ($this->fields as $f => $field) {
            if (!in_array($f, $this->reservedColumn)) {
                if ($field->default) {
                    $listField .= '$' . $f . "= $field->default, ";
                } else {
                    $listField .= '$' . $f . ", ";
                }
                $rules .= "'$f' => '$field->rule', \r\n\t\t";
                $createFields .= "'$f'=> \$this->$f, \r\n\t\t";
            }
        }
        $listField = trim($listField, ', ');

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
            , 'DumpMyPageName'
        ], [
            $this->getNamespace()
            , $this->getModelNamspace()
            , $listField
            , $rules
            , $this->getPermissionName()
            ,$this->modelName
            ,$createFields
            , $this->getRouteName()
            , $this->gerViewDot()
            , $this->getSnakeString($this->module->getName())
            , $this->getHeadline($this->pageName)
        ], $stub);
        $pathSave = $this->classPath . "/Create.php";
        $this->writeFile($pathSave,$template);
    }

    private function createView()
    {

    }


}
