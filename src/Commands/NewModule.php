<?php

namespace Hungnm28\LaravelForm\Commands;

use App\Models\Role;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Nwidart\Modules\Facades\Module;

class NewModule extends Command
{


    protected $signature = 'lf:new-module {name}';

    protected $description = 'Create new module';

    public function handle()
    {
        $moduleName = $this->argument("name");
        $check = Module::has($moduleName);
        if(!$check){
            $this->call("module:make",["name"=>[$moduleName]]);
        }
        $this->call("lf:init-module",["name"=>$moduleName,"--all"=>"1"]);
        return Command::SUCCESS;
    }
}
