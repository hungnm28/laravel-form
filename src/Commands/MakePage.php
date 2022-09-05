<?php

namespace Hungnm28\LaravelForm\Commands;


use Hungnm28\LaravelForm\Traits\WithCommandTrait;
use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Nwidart\Modules\Facades\Module;

class MakePage extends Command
{
    use WithCommandTrait;

    protected $signature = 'lf:make-page {name} {module} {--pre=} {--model=}';

    protected $description = 'Make edit Page: ';

    protected $folder;

    public function handle()
    {
        $this->call('lf:make-listing', [
                                        'name' => $this->argument("name")
                                        ,'module' => $this->argument("module")
                                        ,'--pre' => $this->option("pre")
                                        ,'--model' => $this->option("model")
                                        ]);
        $this->call('lf:make-create', [
                                        'name' => $this->argument("name")
                                        ,'module' => $this->argument("module")
                                        ,'--pre' => $this->option("pre")
                                        ,'--model' => $this->option("model")
                                    ]);
        $this->call('lf:make-edit', [
                                        'name' => $this->argument("name")
                                        ,'module' => $this->argument("module")
                                        ,'--pre' => $this->option("pre")
                                        ,'--model' => $this->option("model")
                                    ]);
        $this->call('lf:make-show', [
                                    'name' => $this->argument("name")
                                    ,'module' => $this->argument("module")
                                    ,'--pre' => $this->option("pre")
                                    ,'--model' => $this->option("model")
                                ]);

    }
}
