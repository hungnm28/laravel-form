<?php

namespace Hungnm28\LaravelForm\Commands;

use App\Models\Role;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class CreateUser extends Command
{


    protected $signature = 'lf:create-admin-user {email} {password} {name} {--super_admin=1}';

    protected $description = 'Create Admin User: email password name  {--super_admin=1}';

    public function handle()
    {
        $data = [
            "email" => $this->argument("email")
            , "password" => $this->argument("password")
            , "name" => $this->argument("name")
        ];
        $validate = Validator::make($data, [
            "email" => "email|required"
            , "password" => "string|required"
            , "name" => "string|required"
        ]);
        if ($validate->fails()) {
            $this->error(json_encode($validate->messages()));
            return false;
        }

        // CHeck user
        $user = User::whereEmail($this->argument("email"))->first();
        if ($user) {
            $user->update([
                "password" => Hash::make($this->argument("password"))
                , "is_admin" => 1
                ,"is_super_admin"=>$this->option("super_admin")
            ]);
        } else {
             User::create([
                "email" => $this->argument("email")
                , "name" => $this->argument("name")
                , "password" => Hash::make($this->argument("password"))
                , "is_admin" => 1
                ,"is_super_admin"=>$this->option("super_admin")
            ]);
        }
        return Command::SUCCESS;
    }
}
