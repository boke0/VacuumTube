<?php

namespace Boke0\Mechanism\Plugins\VacuumTube;
use \Boke0\Mechanism\Api\Endpoint;

/**
 * @path /admin/login
 */
class LoginEndpoint extends Endpoint{
    public function handle($req,$args){
        if(Session::get("vt_uid")!=NULL){
            return $this->createResponse()->withHeader("Location","/admin");
        }
        if(!file_exists(__DIR__."/../../contents/cfg.json")){
            return $this->createResponse()->withHeader("Location","/admin/install");
        }
        $userMdl=new Mdl\User(new Mdl\Db());
        if($req->getServerParams()["REQUEST_METHOD"]=="POST"){
            $post=$req->getParsedBody();
            $id=$userMdl->login($post["screen_name"],$post["password"]);
            Session::set("vt_uid",$id);
            return $this->createResponse()
                ->withHeader("Location","/admin");
        }
        return $this->twig("login.tpl.html");
    }
}
