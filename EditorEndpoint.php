<?php

namespace Boke0\Mechanism\Plugins\VacuumTube;
use \Boke0\Mechanism\Api\Endpoint;

/**
 * @path /admin/editor
 */
class EditorEndpoint extends Endpoint{
    public function handle($req,$args){
        $qs=$req->getQueryString();
        $path=$qs["path"];
        $slug=$ps["slug"];
        if(Session::get("vt_uid")==NULL){
            return $this->createResponse()->withHeader("Location","/admin/login");
        }
        if(!file_exists(__DIR__."/cfg.json")){
            return $this->createResponse()->withHeader("Location","/admin/install");
        }
        return $this->twig("editor.tpl.html");
    }
}
