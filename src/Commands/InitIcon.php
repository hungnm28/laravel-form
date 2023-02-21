<?php

namespace Hungnm28\LaravelForm\Commands;


use Hungnm28\LaravelForm\Traits\WithCommandTrait;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;
use function PHPUnit\Framework\fileExists;


class InitIcon extends Command
{
    use WithCommandTrait;

    protected $signature = 'lf:init-icon';

    protected $description = 'Init Icon: ';


    public function handle()
    {
        $pathSave = public_path("assets/images/icons.svg");
        if(file_exists($pathSave)){
            $this->info("File icons exits $pathSave");
            if(!$this->confirm("Do you want replace file",true)){
                return false;
            }
        }
        $this->info("success");
        $this->ensureDirectoryExists($pathSave);
        (new Filesystem)->copy(__DIR__ . '/../../publishes/icons/icons.svg',$pathSave);


        return true;
    }


}
