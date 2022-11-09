<?php

namespace Hungnm28\LaravelForm\Commands;


use Hungnm28\LaravelForm\Traits\WithCommandTrait;
use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Nwidart\Modules\Facades\Module;

class MakePage extends Command
{
    use WithCommandTrait;

    protected $signature = 'lf:make-page {name} {module} {--model=} {--force}';

    protected $description = 'Make edit Page: ';


    public function handle()
    {
        $this->initPath($this->argument("name"));

        $this->call('lf:make-index', [
            'name' => $this->argument("name")
            ,'module' => $this->argument("module")
            ,'--force' => $this->option("force")
            ,'--model' => $this->option("model")
        ]);
        $this->call('lf:make-listing', [
                                        'name' => $this->argument("name")
                                        ,'module' => $this->argument("module")
                                        ,'--force' => $this->option("force")
                                        ,'--model' => $this->option("model")
                                        ]);
        $this->call('lf:make-create', [
                                        'name' => $this->argument("name")
                                        ,'module' => $this->argument("module")
                                        ,'--force' => $this->option("force")
                                        ,'--model' => $this->option("model")
                                    ]);
        $this->call('lf:make-edit', [
                                        'name' => $this->argument("name")
                                        ,'module' => $this->argument("module")
                                        ,'--force' => $this->option("force")
                                        ,'--model' => $this->option("model")
                                    ]);
        $this->call('lf:make-show', [
                                    'name' => $this->argument("name")
                                    ,'module' => $this->argument("module")
                                    ,'--force' => $this->option("force")
                                    ,'--model' => $this->option("model")
                                ]);

        $this->call('lf:make-route', [
            'name' => $this->argument("name")
            ,'module' => $this->argument("module")
            ,'--force' => $this->option("force")
        ]);

    }
}
