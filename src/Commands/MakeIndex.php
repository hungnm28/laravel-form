<?php

namespace Hungnm28\LaravelForm\Commands;


use Hungnm28\LaravelForm\Traits\WithCommandTrait;
use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Nwidart\Modules\Facades\Module;

class MakeIndex extends Command
{
    use WithCommandTrait;

    protected $signature = 'lf:make-index {name} {module} {--fileName=Index} {--force=} {--model=}';

    protected $description = 'Make index Page: ';

    protected $folder;

    public function handle()
    {
        $this->info("Make index page: " . $this->argument("name"));
        $this->initPath($this->argument("name"));
        $this->initModel($this->argument("name"));
        $this->initModule($this->argument("module"));
        $this->initFileName();
        $this->createClass();
        $this->createView();
        return true;
    }

    private function createClass()
    {
        $stub = $this->getStub("Index.php.stub");
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
        $pathSave = $this->getClassFile("$this->fileName.php");
        $this->writeFile($pathSave, $template);
    }

    private function createView()
    {
        $stub = $this->getStub("index.blade.php.stub");
        $template = $this->generateData($stub);
        $pathSave = $this->getViewFile($this->getSnakeString($this->fileName).".blade.php");
        $this->writeFile($pathSave, $template);
    }


}
