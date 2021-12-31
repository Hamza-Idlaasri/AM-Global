<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SwitchDB extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }
    
    public function switchDB($db_host,$db_port,$db_database,$db_username,$db_password)
    {

        $envFile = app()->environmentFilePath();
        $str = file_get_contents($envFile);

        // $old_DB_CONNECTION = env('DB_CONNECTION');
        $old_DB_HOST = env('DB_HOST');
        $old_DB_PORT = env('DB_PORT');
        $old_DB_DATABASE = env('DB_DATABASE');
        $old_DB_USERNAME = env('DB_USERNAME');
        $old_DB_PASSWORD = env('DB_PASSWORD');

        // $str = str_replace("DB_CONNECTION={$old_DB_CONNECTION}", "DB_CONNECTION=users", $str);
        $str = str_replace("DB_HOST={$old_DB_HOST}", "DB_HOST={$db_host}", $str);
        $str = str_replace("DB_PORT={$old_DB_PORT}", "DB_PORT={$db_port}", $str);
        $str = str_replace("DB_DATABASE={$old_DB_DATABASE}", "DB_DATABASE={$db_database}", $str);
        $str = str_replace("DB_USERNAME={$old_DB_USERNAME}", "DB_USERNAME={$db_username}", $str);

        if ($db_password == 'empty') {

            $str = str_replace("DB_PASSWORD={$old_DB_PASSWORD}", "DB_PASSWORD=", $str);

        } else
            {
                $str = str_replace("DB_PASSWORD={$old_DB_PASSWORD}", "DB_PASSWORD={$db_password}", $str);
            }


        $fp = fopen($envFile, 'w');
        fwrite($fp, $str);
        fclose($fp);


        return redirect()->route('overview');
    }
}
