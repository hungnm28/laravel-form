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

    protected $signature = 'lf:init-auth';

    protected $description = 'Init Auth: ';


    public function handle()
    {

    }


}
