<?php

namespace Hungnm28\LaravelForm\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;

class UseWebpack extends Command
{


    protected $signature = 'lf:use-webpack';

    protected $description = 'Use webpack';

    public function handle()
    {
        $this->call("vendor:publish", ["--tag" => "laravel-use-webpack"]);
        $process = Process::fromShellCommandline('npm install laravel-mix sass sass-loader browser-sync browser-sync-webpack-plugin --D');

        $process->run();
        $this->info($process->getOutput());

        $package = file_get_contents(base_path("package.json"));
        if (strpos($package, '"dev": "vite",')) {
            $package = str_replace('"dev": "vite",', '"dev": "npm run development",
        "development": "mix",
        "watch": "mix watch",
        "watch-poll": "mix watch -- --watch-options-poll=1000",
        "hot": "mix watch --hot",
        "prod": "npm run production",
        "production": "mix --production",
        "vite": "vite",', $package);
        }
        file_put_contents(base_path("package.json"), $package);

        $guestPath = resource_path("views/layouts/guest.blade.php");
        if(file_exists($guestPath)){
            $guest = file_get_contents($guestPath);
            $guest = str_replace("@vite(['resources/css/app.css', 'resources/js/app.js'])",'<link rel="stylesheet" href="{{asset("css/app.css")}}" />
        <script type="text/javascript" src="{{asset("js/app.js")}}"></script>',$guest);

           file_put_contents($guestPath, $guest);
        }

        $appPath = resource_path("views/layouts/app.blade.php");
        if(file_exists($appPath)){
            $appView = file_get_contents($appPath);
            $appView = str_replace("@vite(['resources/css/app.css', 'resources/js/app.js'])",'<link rel="stylesheet" href="{{asset("css/app.css")}}" />
        <script type="text/javascript" src="{{asset("js/app.js")}}"></script>',$appView);

            file_put_contents($appPath, $appView);
        }

        $process = Process::fromShellCommandline('npm run dev');
        $process->run();
        $this->info($process->getOutput());

        return Command::SUCCESS;
    }
}
