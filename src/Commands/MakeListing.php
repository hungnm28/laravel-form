<?php

namespace Hungnm28\LaravelForm\Commands;


use Hungnm28\LaravelForm\Traits\WithCommandTrait;
use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Nwidart\Modules\Facades\Module;

class MakeListing extends Command
{
    use WithCommandTrait;

    protected $signature = 'lf:make-listing {name} {module} {--force} {--model=}';

    protected $description = 'Make listing File ';

    public function handle()
    {
        $this->info("make Listing file: " . $this->name);
        $this->initPath($this->argument("name"));
        $this->initModule($this->argument("module"));
        $this->initModel($this->argument("name"));
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
            $breadcrumb .= 'lForm()->pushBreadcrumb(route("' . $k . '"),"' . $title . '");' .$this->showNewLine(4);
        }
        $fields = "";
        $tbFields = data_get($this->model,"fields",[]);
        foreach ($tbFields as $f => $field) {
            $fields .= '"' . $f . '" => ["status" => true, "label" => "' . $this->getHeadline($f) . '"],' . $this->showNewLine(4);
        }

        $template = str_replace([
             'DumpMyFields'
            , 'DumpMyBreadcrumb'
        ], [
             $fields
            , $breadcrumb
        ], $stub);
        $template = $this->generateData($template);
        $pathSave = $this->getClassFile("Listing.php");
        $this->writeFile($pathSave, $template);
    }

    private function createView()
    {
        $stub = $this->getStub("listing.blade.php.stub");
        $fields = "";
        $titleFields = "";
        $tbField = data_get($this->model,"fields",[]);
        foreach ($tbField as $f => $field) {
            if ($f == "id") continue;

            $titleFields .= '<x-lf.table.label name="'.$f.'" :fields="$fields">' . $this->getHeadline($f) . '</x-lf.table.label>'.$this->showNewLine(5);

            switch ($field->type) {
                case "array":
                case "object":
                case "json":
                    $fields .= '<x-lf.table.item name="'.$f.'" :fields="$fields"><x-lf.item.tags :params="$item->' . $f . '" /></x-lf.table.item>' . $this->showNewLine(6);
                    break;

                default:
                    $fields .= '<x-lf.table.item name="'.$f.'" :fields="$fields">{{$item->'.$f.'}}</x-lf.table.item>' . $this->showNewLine(6);
            }


        }
        $template = str_replace([
            'DumpMyTitleFields'
            , 'DumpMyFields'
        ],
            [
                $titleFields
                , $fields
            ],
            $stub);
        $template = $this->generateData($template);
        $pathSave = $this->getViewFile("listing.blade.php");
        $this->writeFile($pathSave, $template);
    }


}
