<?php

namespace Hungnm28\LaravelForm\Traits;

use Hungnm28\LaravelForm\Supports\ModelGenerator;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Nwidart\Modules\Facades\Module;

trait WithCommandTrait
{
    private $module, $pageName, $modelName, $tableName, $fields = [], $prePath, $viewPath, $classPath, $dotpath;

    private $reservedColumn = [
        'id', 'created_at', 'updated_at', 'deleted_at', 'remember_token', 'two_factor_recovery_codes', 'two_factor_secret'
    ];

    private function initPage()
    {
        $name = $this->argument("name");
        $name = Str::plural($name);
        $name = Str::studly($name);
        $this->pageName = $name;

        $pre = $this->option("pre");
        if ($pre) {
            $arrPre = explode("/", $pre);
            foreach ($arrPre as $k => $prePath) {
                $prePath = Str::plural($prePath);
                $prePath = Str::studly($prePath);
                if ($k > 0) {
                    $this->prePath .= "/";
                }
                $this->prePath .= $prePath;
            }


        }

        $modelName = $this->option("model");
        if (!$modelName) {
            $modelName = Str::singular($this->pageName);
            $this->modelName = $modelName;
        }

        $this->module = Module::findOrFail($this->argument("module"));

        $this->classPath = $this->module->getPath() . "/Http/Livewire";
        $this->viewPath = $this->module->getPath() . "/Resources/views/livewire";
        if ($this->prePath) {
            $this->classPath .= "/$this->prePath";
            $arrPre = explode("/", $this->prePath);
            foreach ($arrPre as $item) {
                $item = $this->getSnakeString($item);
                $this->viewPath .= "/$item";
            }
        }
        $this->classPath .= "/$this->pageName";
        $this->viewPath .= "/" . $this->getSnakeString($this->pageName);


    }

    private function getNamespace()
    {
        $namespace = "Modules/" . $this->module->getName() . "/Http/Livewire";
        if ($this->prePath) {
            $namespace .= "/$this->prePath";
        }
        $namespace .= "/$this->pageName";
        $namespace = str_replace("/", "\\", $namespace);
        return $namespace;
    }

    private function gerViewDot($name = '')
    {
        $return = "";
        if ($this->prePath) {
            foreach (explode("/", $this->prePath) as $pre) {
                $return .= "." . $this->getSnakeString($pre);
            }
        }
        $return .= "." . $this->getSnakeString($this->pageName);
        if ($name) {
            $return .= ".$name";
        }
        $return = trim($return, ". ");
        return $return;
    }

    private function getRouteName($name = "")
    {
        $route = $this->getModuleSug($this->module->getName());
        if ($this->prePath) {
            $arrPre = explode("/", $this->prePath);
            foreach ($arrPre as $pre) {
                $route .= "." . $this->getSnakeString($pre);
            }
        }
        $route .= "." . $this->getSnakeString($this->pageName);
        if ($name) {
            $route .= ".$name";
        }
        return $route;
    }

    private function getPermissionName($name = "")
    {
        $permission = $this->getSnakeString($this->module->getName());
        if ($this->prePath) {
            $arrPre = explode("/", $this->prePath);
            foreach ($arrPre as $pre) {
                $permission .= "." . $this->getSnakeString($pre);
            }
        }
        $permission .= "." . $this->getSnakeString($this->pageName);
        if ($name) {
            $permission .= ".$name";
        }
        return $permission;
    }

    private function getModelFields($name)
    {
        $modelGenerator = new ModelGenerator($name);
        $this->tableName = $modelGenerator->model->getTable();
        $this->fields = $modelGenerator->getFields();
        return $this->fields;
    }

    private function getModelNamspace()
    {
        return "App\\Models\\$this->modelName";
    }

    private function getArrRoutes($name=""){
        $return = [];
        $route = $this->getSnakeString($this->module->getName());
        $return[$route] = $this->module->getName();
        if($this->prePath){
            foreach(explode("/",$this->prePath) as $pre){
                $route .= '.' .$this->getSnakeString($pre);
                $return[$route] = $this->getHeadline($pre);
            }
        }
        $route .= '.' .$this->getSnakeString($this->pageName);
        $return[$route] = $this->getHeadline($this->pageName);
        if($name){
            $route .= ".$name";
            $return[$route] = $this->getHeadline($name);
        }

        return $return;
    }

    private function getStub($file)
    {
        $path = base_path('stubs/laravel-form-stubs/'.$file);
        if (!File::exists($path)) {
            $path = __DIR__ . "/../Commands/stubs/$file";
        }
        if (!File::exists($path)) {
            $this->error("WHOOPS-IE-TOOTLES  😳 \n");
            $this->error("Stubs not exists: $path \n ");
            return false;
        }
        return file_get_contents($path);
    }

    private function writeFile($path, $data)
    {
        $this->ensureDirectoryExists($path);
        return File::put($path, $data);
    }

    private function checkModule($name)
    {
        return Module::has($name);
    }

    private function isForce()
    {
        return $this->option('force') === true;
    }

    private function ensureDirectoryExists($path)
    {
        $path = dirname($path);
        (new Filesystem)->ensureDirectoryExists($path);
    }

    private function getSnakeString($str)
    {
        $str = Str::snake($str, "-");
        return Str::slug($str);
    }
    private function getHeadline($str='')
    {
        $str = Str::replace("/", " ", $str);
        $str = Str::snake($str, "-");
        return Str::headline($str);
    }

    private function getModuleSug($name){
        return $this->getSnakeString($name);
    }
}
