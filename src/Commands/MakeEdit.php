<?php

namespace Hungnm28\LaravelForm\Commands;


use Hungnm28\LaravelForm\Traits\WithCommandTrait;
use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Nwidart\Modules\Facades\Module;

class MakeEdit extends Command
{
    use WithCommandTrait;

    protected $signature = 'lf:make-edit {name} {module} {--fileName=Edit} {--force} {--model=}';

    protected $description = 'Make edit Page: ';

    protected $folder;

    public function handle()
    {

        $this->info("make Edit file: " . $this->name);
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
        $stub = $this->getStub("Edit.php.stub");

        $listField = '';
        $rules = '';
        $createFields = '';
        $mountFields = '';
        foreach ($this->getModelFields() as $f => $field) {
            if (!in_array($f, $this->reservedColumn)) {
                if ($field->default) {
                    $listField .= '$' . $f . "= '$field->default', ";
                } else {
                    $listField .= '$' . $f . ", ";
                }
                $rules .= "'$f' => '$field->rule'," . $this->showNewLine(5);
                $createFields .= "'$f' => \$this->$f," . $this->showNewLine(5);
                $mountFields .= "\$this->$f = \$data->$f;" . $this->showNewLine(4);
            }
        }
        $listField = trim($listField, ', ');
        $routes = $this->getArrRoutes();
        $breadcrumb = "";
        foreach ($routes as $k => $title) {
            $breadcrumb .= 'lForm()->pushBreadcrumb(route("' . $k . '"),"' . $title . '");' . $this->showNewLine(4);
        }
        $template = str_replace([
            'DumpMyListFields'
            , 'DumpMyRules'
            , 'DumpMyMountFields'
            , 'DumpMyEditFields'
            , 'DumpMyBreadcrumb'
        ], [
            $listField
            , $rules
            , $mountFields
            , $createFields
            , $breadcrumb
        ], $stub);
        $template = $this->generateData($template);
        $pathSave = $this->getClassFile("$this->fileName.php");
        $this->writeFile($pathSave, $template);
    }

    private function createView()
    {
        $stub = $this->getStub("edit.blade.php.stub");
        $fields = "";
        foreach ($this->getModelFields() as $f => $field) {
            if (in_array($f, $this->reservedColumn)) continue;
            switch ($field->type) {
                case "boolean":
                    $fields .= '<x-lf.form.toggle name="' . $f . '" label="' . $field->label . '" />' . $this->showNewLine(4);
                    break;
                case "json":
                    $fields .= '<x-lf.form.array name="' . $f . '" label="' . $field->label . '" placeholder="' . $field->label . ' ..." :params="$' . $f . '"/>' . $this->showNewLine(4);
                    break;
                default:
                    $fields .= '<x-lf.form.input name="' . $f . '" type="' . $field->type . '" label="' . $field->label . '" placeholder="' . $field->label . ' ..."/>' . $this->showNewLine(4);
            }
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
