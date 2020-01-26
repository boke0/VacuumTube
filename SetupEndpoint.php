<?php

namespace Boke0\Mechanism\Plugins\VacuumTube;
use \Boke0\Mechanism\Api\Endpoint;

/**
 * @path /admin/install/setup
 */
class SetupEndpoint extends Endpoint{
    public function handle($req,$args){
        if(!file_exists(__DIR__."/../../contents/cfg.json")){
            return $this->createResponse()->withHeader("Location","/admin/install");
        }
        $db=new Mdl\Db();
        $inviteMdl=new Mdl\Invite($db);
        $userMdl=new Mdl\User($db,$inviteMdl);
        if($req->getServerParams()["REQUEST_METHOD"]=="POST"){
            $post=$req->getParsedBody();
            $token=$inviteMdl->create($post["screen_name"],$post["name"]);
            $id=$userMdl->signup($token,$post["password"]);
            Session::set("vt_uid",$id);
            return $this->createResponse()
                ->withHeader("Location","/admin");
        }
        return $this->twig("setup.tpl.html");
    }
}
