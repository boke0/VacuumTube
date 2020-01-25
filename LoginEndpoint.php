<?php

namespace Boke0\Mechanism\Plugins\VacuumTube;
use \Boke0\Mechanism\Api\Endpoint;

/**
 * @path /admin/login
 */
class LoginEndpoint extends Endpoint{
    public function handle($req,$args){
        if(!file_exists(__DIR__."/cfg.json")){
            return $this->createResponse()->withHeader("Location","/admin/install");
        }
        $userMdl=new Mdl\User(new Mdl\Db());
        if($req->getServerParams()["REQUEST_URI"]=="POST"){
            $post=$req->getParsedBody();
            $id=$userMdl->login($post["screen_name"],$post["password"]);
            Session::set("vc_uid",$id);
            return $this->createResponse()
                ->withHeader("Location","/admin");
        }
        return $this->twig("login.tpl.html");
    }
}
