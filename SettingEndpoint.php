<?php

namespace Boke0\Mechanism\Plugins\VacuumTube;
use \Boke0\Mechanism\Api\Endpoint;

/**
 * @path /admin/settings
 */
class SettingEndpoint extends Endpoint{
    public function handle($req,$arg){
        if(Session::get("vt_uid")==NULL){
            return $this->createResponse()->withHeader("Location","/admin/login");
        }
        if(!file_exists(__DIR__."/../../contents/cfg.json")){
            return $this->createResponse()->withHeader("Location","/admin/install");
        }
        if($req->getServerParams()["REQUEST_METHOD"]=="POST"){
            $qs=$req->getQueryParams();
            switch($qs["type"]){
                case "db":
                    $settings=json_decode(file_get_contents(__DIR__."/../../contents/cfg.json"),TRUE);
                    $settings["dsn"]=$post["dsn"];
                    $settings["dbuser"]=$post["dbuser"];
                    $settings["dbpass"]=$post["dbpass"];
                    file_put_contents(__DIR__."/../../contents/cfg.json",json_encode($settings));
                    break;
                case "struct":
                    file_put_contents(__DIR__."/../../contents/struct.json",$post["struct"]);
                    break;
            }
        }
        $settings=json_decode(file_get_contents(__DIR__."/../../contents/cfg.json"),TRUE);
        $settings["struct"]=file_get_contents(__DIR__."/../../contents/struct.json");
        return $this->twig("settings.tpl.html",$settings);
    }
}
