<?php

namespace Hungnm28\LaravelForm\Commands;

use App\Models\Role;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Nwidart\Modules\Facades\Module;

class NewAdmin extends Command
{


    protected $signature = 'lf:new-admin {name}';

    protected $description = 'Create new admin module';

    public function handle()
    {
        $moduleName = $this->argument("name");
        $check = Module::has($moduleName);
        if(!$check){
            $this->call("module:make",["name"=>[$moduleName]]);
        }
        $this->call("lf:init-module",["name"=>$moduleName,"--all"=>"1"]);
        $this->call("lf:init-cast");
        $this->call("lf:init-auth");
        $this->call("lf:make-admin",["name"=>$moduleName]);

        return Command::SUCCESS;
    }
}
