<?php

namespace Hungnm28\LaravelForm\Commands;

use App\Models\Role;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Nwidart\Modules\Facades\Module;
use Illuminate\Support\Env;
use mysqli;

class SetupDatabase extends Command
{


    protected $signature = 'lf:create-database';

    protected $description = 'Create new database and modify .env';

    public function handle()
    {
        $this->setupEnv();
        $this->createDatabase();
        return Command::SUCCESS;
    }


    public function setupEnv(){
        Env::enablePutenv();
        $app_url = $this->ask('ENV: APP_URL=' . env('APP_URL') . " nhập APP_URL cần thay thế",env('APP_URL'));
        if (filter_var($app_url, FILTER_VALIDATE_URL)) {
            $this->arrSaveEnv['APP_URL'] = $app_url;
            $this->warn("APP_URL=" . $app_url);
        }
        $db_name = $this->ask('ENV: DB_DATABASE=' . env('DB_DATABASE') . " nhập DB_DATABASE cần thay thế",env('DB_DATABASE'));
        $db_name = strtolower($db_name);
        if($db_name != "no"){
            $this->arrSaveEnv["DB_DATABASE"] = $db_name;
            $this->warn("DB_DATABASE=" . $db_name);
        }

        $db_username = $this->ask('ENV: DB_USERNAME=' . env('DB_USERNAME') . " nhập DB_USERNAME cần thay thế",env('DB_USERNAME'));
        $db_username = strtolower($db_username);
        if($db_username != "no"){
            $this->arrSaveEnv["DB_USERNAME"] = $db_username;
            $this->warn("DB_USERNAME=" . $db_username);
        }

        $db_password = $this->ask('ENV: DB_PASSWORD=' . env('DB_PASSWORD') . " nhập db_password cần thay thế",env('DB_PASSWORD'));
        if($db_password != "no"){
            $this->arrSaveEnv["DB_PASSWORD"] = $db_password;
            $this->warn("DB_PASSWORD=" . $db_password);
        }

        $arrAddEnv = [];
        $arrAddEnv["ASSET_URL"] = "/dev";
        $arrAddEnv["MIX_PUSHER_APP_KEY"] = '"${PUSHER_APP_KEY}"';
        $arrAddEnv["MIX_PUSHER_APP_CLUSTER"] = '"${PUSHER_APP_CLUSTER}"';
        $env = file_get_contents(base_path() . "/.env");
        $envs = explode("\n",$env);
        foreach ($envs as $key => $value){
            foreach ($this->arrSaveEnv as $env_name => $env_value){
                if(strpos($value,$env_name.'=') === 0){
                    $envs[$key] = $env_name . "=" . $env_value;
                    putenv($env_name . "=" . $env_value);
                    $_ENV[$env_name] = $env_value;
                    $this->info("Added: $env_name" . "=" . $env_value);
                }
            }
        }

        foreach ($arrAddEnv as $k => $v){
            if(strpos($env,$k) === false){
                $envs[] = $k . '=' . $v;
            }
        }

        file_put_contents(base_path() . "/.env",implode("\n",$envs));
        file_put_contents(base_path() . "/.env.example",implode("\n",$envs));

    }

    function createDatabase(){
        $mysql_root_pass = $this->secret('Nhập mật khẩu mysql root để tạo database: ');
        if(empty($mysql_root_pass)) return;
        $servername = "127.0.0.1";
        $username = "root";
        $password = $mysql_root_pass;
        $db_name = getenv('DB_DATABASE');

        // Creating a connection
        $conn = new mysqli($servername, $username, $password);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        // Creating a database named newDB
        if ($conn->query("CREATE DATABASE IF NOT EXISTS `$db_name` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci") === TRUE) {
            $this->info("Database created successfully with the name $db_name");
        }
        if(strtolower(getenv('DB_USERNAME')) != "root") {
            $this->info("CREATE USER IF NOT EXISTS " . getenv('DB_USERNAME') . "@" . getenv('DB_HOST') . " IDENTIFIED BY '" . getenv('DB_PASSWORD') . "';");
            if ($conn->query("CREATE USER IF NOT EXISTS " . getenv('DB_USERNAME') . "@" . getenv('DB_HOST') . " IDENTIFIED BY '" . getenv('DB_PASSWORD') . "'") === TRUE) {
                $this->info("CREATE USER IF NOT EXISTS " . getenv('DB_USERNAME') . "@" . getenv('DB_HOST') . " IDENTIFIED BY '" . getenv('DB_PASSWORD') . "';");
            }
            if ($conn->query("GRANT ALL PRIVILEGES ON " . getenv('DB_DATABASE') . ".*   TO " . getenv('DB_USERNAME') . "@" . getenv('DB_HOST') . "  WITH GRANT OPTION") === TRUE) {
                $this->info("GRANT ALL PRIVILEGES ON " . getenv('DB_DATABASE') . ".*   TO " . getenv('DB_USERNAME') . "@" . getenv('DB_HOST') . "  WITH GRANT OPTION;");
            }
            if ($conn->query("ALTER USER " . getenv('DB_USERNAME') . "@" . getenv('DB_HOST') . " IDENTIFIED WITH mysql_native_password BY '" . getenv('DB_PASSWORD') . "'") === TRUE) {
                $this->info("ALTER USER " . getenv('DB_USERNAME') . "@" . getenv('DB_HOST') . " IDENTIFIED WITH mysql_native_password BY '" . getenv('DB_PASSWORD') . "';");
            }
        }
        // closing connection
        $conn->close();
    }
}
