<?php

namespace Hungnm28\LaravelForm\Commands;


use Hungnm28\LaravelForm\Traits\WithCommandTrait;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;
use Nwidart\Modules\Facades\Module;


class InitGitignore extends Command
{
    use WithCommandTrait;

    protected $signature = 'lf:init-gitignore {name} {--force}';

    protected $description = 'Init Gitignore: ';


    public function handle()
    {
        $name = $this->argument("name");
        $this->info($this->description . $name);
        if(!$this->checkModule($name)){
            $this->error("Module: $name not exits");
            return false;
        }
        $this->module = Module::findOrFail($name);


        (new Filesystem)->copy(__DIR__ . '/../../publishes/.gitignore',$this->module->getPath().'/.gitignore');

    }


}
