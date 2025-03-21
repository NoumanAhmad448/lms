<?php

namespace Eren\Lms\Controllers;

use Exception;
use Illuminate\Support\Facades\Artisan;

class DeploymentController extends Controller
{
    public function clearCache()
    {
        Artisan::call("config:cache");
        // Artisan::call("route:cache");
        // Artisan::call("view:cache");
        debug_logs("config, view, route are cached successfully");
    }
    public function liveDeployment()
    {
        try{
            $this->clearCache();
            Artisan::call("migrate");
        }catch(Exception $th){
            if(config("app.debug")){
                dd($th->getMessage());
            }else{
                echo config("setting.err_msg");
            }
        }
    }
}
