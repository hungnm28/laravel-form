<?php

namespace Hungnm28\LaravelForm\Commands;

use App\Models\Role;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class CreateUser extends Command
{


    protected $signature = 'lf:create-admin-user ';

    protected $description = 'Create Admin User';

    public function handle()
    {
        $data = [];
        $data["email"]=$this->ask("What is Admin email?");
        $data["password"]=$this->secret("What is Password?");
        $data["name"]=$this->ask("What is Admin Name?");
        $data["is_super_admin"]=$this->confirm("Is Super Admin?",true);
        $data["is_admin"]=1;
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
        $user = User::whereEmail($data["email"])->first();
        if ($user) {
            $user->update([
                "password" => Hash::make($data["password"])
                , "is_admin" => 1
                ,"is_super_admin"=>$data["is_super_admin"]
            ]);
        } else {
             User::create([
                "email" => $data["email"]
                , "name" => $data["name"]
                , "password" => Hash::make($data["password"])
                , "is_admin" => 1
                ,"is_super_admin"=>$data["is_super_admin"]
            ]);
        }
        return Command::SUCCESS;
    }
}
