<?php

namespace Hungnm28\LaravelForm\Commands;


use Hungnm28\LaravelForm\Traits\WithCommandTrait;
use Illuminate\Console\Command;

class InitModule extends Command
{
    use WithCommandTrait;

    protected $signature = 'lf:init-module {name} {--all} {--mix} {--layout} {--provider} {--route} {--gitignore}';

    protected $description = 'Init module: ';


    public function handle()
    {
        $name = $this->argument("name");
        $this->info($this->description . $name);
        if(!$this->checkModule($name)){
            $this->error("Module: $name not exits");
            return false;
        }
        if($this->option("provider") || $this->option("all")){
            $this->call('lf:init-provider', ['name' => $name]);
        }
        if($this->option("mix") || $this->option("all")){
            $this->call('lf:init-mix', ['name' => $name]);
        }
        if($this->option("layout") || $this->option("all")){
            $this->call('lf:init-layout', ['name' => $name]);
        }
        if($this->option("route") || $this->option("all")){
            $this->call('lf:init-route', ['name' => $name]);
        }
        if($this->option("gitignore") || $this->option("all")){
            $this->call('lf:init-gitignore',['name' => $name]);
        }

        return true;
    }


}
