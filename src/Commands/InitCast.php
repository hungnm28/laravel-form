<?php

namespace Hungnm28\LaravelForm\Commands;


use Hungnm28\LaravelForm\Traits\WithCommandTrait;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;


class InitCast extends Command
{
    use WithCommandTrait;

    protected $signature = 'lf:init-cast {--force}';

    protected $description = 'Make Cast ';

    public function handle()
    {
        $this->info("Init Cast");
        $this->copyCast("BooleanCast.php");
        $this->copyCast("DateCast.php");
        $this->copyCast("EmailCast.php");
        $this->copyCast("HtmlCast.php");
        $this->copyCast("IntegerCast.php");
        $this->copyCast("JsonCast.php");
        $this->copyCast("NumberCast.php");
        $this->copyCast("SlugCast.php");
        $this->copyCast("StringCast.php");


    }

    private function copyCast($name)
    {
        $pathSave = app_path("Casts/$name");
        $this->ensureDirectoryExists($pathSave);
        if(!file_exists($pathSave)){
            $this->info("Make File: $pathSave");
            (new Filesystem())->copy(__DIR__ . "/stubs/app/Casts/$name.stub", $pathSave);

        }

    }
}
