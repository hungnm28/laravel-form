<?php

namespace Hungnm28\LaravelForm\Commands;


use Hungnm28\LaravelForm\Traits\WithCommandTrait;
use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Nwidart\Modules\Facades\Module;

class MakeShow extends Command
{
    use WithCommandTrait;

    protected $signature = 'lf:make-show {name} {module} {--force=} {--model=}';

    protected $description = 'Make show Page: ';

    protected $folder;

    public function handle()
    {
        $this->info("Make show page: " . $this->argument("name"));
        $this->initPath($this->argument("name"));
        $this->initModel($this->argument("name"));
        $this->initModule($this->argument("module"));
        $this->createClass();
        $this->createView();
        return true;
    }

    private function createClass()
    {
        $stub = $this->getStub("Show.php.stub");
        $routes = $this->getArrRoutes();
        $breadcrumb = "";
        foreach ($routes as $k => $title) {
            $breadcrumb .= 'lForm()->pushBreadcrumb(route("' . $k . '"),"' . $title . '");' .$this->showNewLine(4);
        }
        $template = str_replace([
           'DumpMyBreadcrumb'
        ], [
            $breadcrumb
        ], $stub);
        $template = $this->generateData($template);
        $pathSave = $this->getClassFile("Show.php");
        $this->writeFile($pathSave, $template);
    }

    private function createView()
    {
        $stub = $this->getStub("show.blade.php.stub");
        $fields = "";
        foreach ($this->getModelFields() as $f => $field) {
            if (in_array($f, $this->reservedColumn)) continue;
            switch ($field->type) {
                case "array":
                case "object":
                case "json":
                    $fields .= $this->showNewLine(5).'<tr>'.$this->showNewLine(6).'<th class="text-right pr-2">' . $f . ':</th>'.$this->showNewLine(6).'<td><x-lf.item.tags :params="$data->' . $f . '" /></td>'.$this->showNewLine(5).'</tr>';
                    break;

                default:
                    $fields .= $this->showNewLine(5).'<tr>'.$this->showNewLine(6).'<th class="text-right pr-2">' . $f . ':</th>'.$this->showNewLine(6).'<td>{{$data->' . $f . '}}</td>'.$this->showNewLine(5).'</tr>';
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
        $pathSave = $this->getViewFile("show.blade.php");
        $this->writeFile($pathSave, $template);
    }


}
