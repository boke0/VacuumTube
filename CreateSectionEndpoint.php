<?php

namespace Boke0\Mechanism\Plugins\VacuumTube;
use \Boke0\Mechanism\Api\Endpoint;

/**
 * @path /admin/section/create
 * @method POST
 */
class CreateSectionEndpoint extends Endpoint{
    public function handle($req,$args){
        if(Session::get("vt_uid")==NULL){
            return $this->createResponse()->withHeader("Location","/admin/login");
        }
        if(!file_exists(__DIR__."/../../contents/cfg.json")){
            return $this->createResponse()->withHeader("Location","/admin/install");
        }
        $post=$req->getParsedBody();
        $articleMdl=new Mdl\Article();
        $title=$post["title"]!=""?$post["title"]:"無題";
        $path=isset($post["path"])?$post["path"]:"/";
        $articleMdl->createSection($path,$title);
        return $this->createResponse()
                    ->withBody($body)
                    ->withHeader("Content-Type","application/json");
    }
}

