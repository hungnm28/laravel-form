<?php

namespace Hungnm28\LaravelForm\Commands;


use Hungnm28\LaravelForm\Traits\WithCommandTrait;
use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Nwidart\Modules\Facades\Module;

class MakeCreate extends Command
{
    use WithCommandTrait;

    protected $signature = 'lf:make-create {name} {module} {--fileName=Create} {--force} {--model=}';

    protected $description = 'Make create Page ';

    public function handle()
    {

        $this->info("make Create file: " . $this->argument("name"));
        $this->initPath($this->argument("name"));
        $this->initModule($this->argument("module"));
        $this->initModel($this->argument("name"));
        $this->initFileName();
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

        foreach ($this->getModelFields() as $f => $field) {
            if (!in_array($f, $this->reservedColumn)) {
                $default = $field->default;
                switch ($field->type){
                    case "json": $default = '[]';
                    break;
                    default:
                        if($default){
                            $default = "'$default'";
                        }
                }
                if ($default) {
                    $listField .= '$' . $f . "= $default, ";
                } else {
                    $listField .= '$' . $f . ", ";
                }
                $rules .= "'$f' => '$field->rule'," . $this->showNewLine(4);
                $createFields .= "'$f' => \$this->$f," . $this->showNewLine(5);
            }
        }
        $listField = trim($listField, ', ');
        if($listField ==""){
            $listField = '$recode_id';
        }
        $routes = $this->getArrRoutes("create");
        $breadcrumb = "";
        foreach ($routes as $k => $title) {
            $breadcrumb .= 'lForm()->pushBreadcrumb(route("' . $k . '"),"' . $title . '");' . $this->showNewLine(4);
        }
        $template = str_replace([
             'DumpMyListFields'
            , 'DumpMyRules'
            , 'DumpMyCreateFields'
            ,'DumpMyBreadcrumb'
        ], [
            $listField
            , $rules
            , $createFields
            , $breadcrumb
        ], $stub);
        $template = $this->generateData($template);
        $pathSave = $this->getClassFile("$this->fileName.php");
        $this->writeFile($pathSave, $template);
    }

    private function createView()
    {
        $stub = $this->getStub("create.blade.php.stub");
        $fields = "";
        foreach ($this->getModelFields() as $f => $field) {
            if(in_array($f,$this->reservedColumn)) continue;
            switch ($field->type) {
                case "boolean":
                    $form = '<x-lf.form.toggle name="' . $f . '" class="md:w-1/2" label="' . $field->label . '" />';
                    break;
                case "text":
                case "long-text":
                    $form = '<x-lf.form.textarea name="' . $f . '" label="' . $field->label . '" placeholder="' . $field->label . ' ..." />';
                    break;
                case "json":
                    $form = '<x-lf.form.array name="' . $f . '" class="md:w-1/2" label="' . $field->label . '" placeholder="' . $field->label . ' ..." :params="$' . $f . '"/>';
                    break;
                default:
                    $form = '<x-lf.form.input name="' . $f . '" class="md:w-1/2" type="' . $field->type . '" label="' . $field->label . '" placeholder="' . $field->label . ' ..."/>';
            }
            $fields .= $form . $this->showNewLine(4);
        }
        $template = str_replace([
            'DumpMyFields'
        ],
            [
                $fields
            ],
            $stub);
        $template = $this->generateData($template);
        $pathSave = $this->getViewFile($this->getSnakeString($this->fileName).".blade.php");
        $this->writeFile($pathSave, $template);
    }


}
