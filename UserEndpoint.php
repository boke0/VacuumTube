<?php

namespace Boke0\Mechanism\Plugins\VacuumTube;
use \Boke0\Mechanism\Api\Endpoint;

/**
 * @path /admin/users
 */
class UserEndpoint extends Endpoint{
    public function handle($req,$arg){
        $userMdl=new Mdl\User(new Mdl\Db());
        $inviteMdl=new Mdl\Invite(new Mdl\Db());
        if(Session::get("vt_uid")==NULL){
            return $this->createResponse()->withHeader("Location","/admin/login");
        }
        if(!file_exists(__DIR__."/../../contents/cfg.json")){
            return $this->createResponse()->withHeader("Location","/admin/install");
        }
        $users=$userMdl->list();       
        $invites=$inviteMdl->list();       
        return $this->twig("users.tpl.html",[
            "users"=>$users,
            "invites"=>$invites
        ]);
    }
}
