<?php

namespace Hungnm28\LaravelForm\Commands;

use App\Models\Role;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Nwidart\Modules\Facades\Module;

class UpdateComposerModule extends Command
{


    protected $signature = 'lf:composer';

    protected $description = 'Update composer.json for laravel module';

    public function handle()
    {
        if ($this->confirm('Do you want update composer.json for laravel-module?',true)) {
            $currentComposer = file_get_contents(base_path() . "/composer.json");
            $arrayComposer = json_decode(trim($currentComposer),true);
            if(!isset($arrayComposer["autoload"]["psr-4"]['Modules\\'])){
                $arrayComposer["autoload"]["psr-4"]['Modules\\'] = 'Modules/';
            }
            if(!isset($arrayComposer["autoload"]["files"])){
                if (!file_exists(base_path() . "/helpers")) {
                    mkdir(base_path() . "/helpers", 0777, true);
                }
                $arrayComposer["autoload"]["files"] = [
                    "helpers/includes.php"
                ];
                file_put_contents(base_path() . "/helpers/includes.php",'<?php');
            }
            file_put_contents(base_path() . "/composer.json",json_encode($arrayComposer,JSON_PRETTY_PRINT));
        }

        return Command::SUCCESS;
    }
}
