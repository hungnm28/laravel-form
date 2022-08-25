<?php

namespace Hungnm28\LaravelForm\Commands;


use Hungnm28\LaravelForm\Traits\WithCommandTrait;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class InitRoute extends Command
{
    use WithCommandTrait;

    protected $signature = 'lf:init-route {name} {--force}';

    protected $description = 'Init Route: ';


    public function handle()
    {
        $name = $this->argument("name");
        $this->info($this->description . $name);
        if(!$this->checkModule($name)){
            $this->error("Module: $name not exits");
            return false;
        }

        $comfirm = $this->ask("Please enter Y to replace $name route file, any key to quit");
        if (strtolower($comfirm) != "y") {
            return false;
        }
        $stub = $this->getStub("web.php.stub");
        $template = str_replace([
            "DumpMyPrefix"
            ,"DumpMyName"
            ,"DumpMyModule"
        ],[
            Str::slug($name),
            Str::slug($name),
            $name,
        ],$stub);
        $this->writeFile(module_path($name,"Routes/web.php"),$template);


        return true;
    }


}
