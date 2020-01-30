<?php

namespace Boke0\Mechanism\Plugins\VacuumTube;
use \Boke0\Mechanism\Api\Endpoint;

/**
 * @path /admin/discard
 */
class DiscardEndpoint extends Endpoint{
    public function handle($req,$args){
        if(Session::get("vt_uid")==NULL){
            return $this->createResponse()->withHeader("Location","/admin/login");
        }
        if(!file_exists(__DIR__."/../../contents/cfg.json")){
            return $this->createResponse()->withHeader("Location","/admin/install");
        }
        $qs=$req->getQueryParams();
        $db=new Mdl\Db();
        $userMdl=new Mdl\User($db);
        if($qs["user"]!=NULL){
            $mdl=$userMdl;
            $id=$qs["user"];
        }else{
            $mdl=new Mdl\Invite($db);
            $id=$qs["invite"];
        }
        $user=$mdl->get($id);
        if($req->getServerParams()["REQUEST_METHOD"]=="POST"){
            $post=$req->getParsedBody();
            if($userMdl->verify(Session::get("vt_uid"),$post["passwd"])){
                $mdl->delete($id);
            }
            return $this->createResponse()
                        ->withHeader("Location","/admin/users");
        }
        return $this->twig("discard.tpl.html",[
            "user"=>$user
        ]);
    }
}
