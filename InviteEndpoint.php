<?php

namespace Boke0\Mechanism\Plugins\VacuumTube;
use \Boke0\Mechanism\Api\Endpoint;

/**
 * @path /admin/invite
 */
class InviteEndpoint extends Endpoint{
    public function handle($req,$args){
        $qs=$req->getQueryParams();
        $path=urldecode($qs["path"]);
        if(Session::get("vt_uid")==NULL){
            return $this->createResponse()->withHeader("Location","/admin/login");
        }
        if(!file_exists(__DIR__."/../../contents/cfg.json")){
            return $this->createResponse()->withHeader("Location","/admin/install");
        }
        if($req->getServerParams()["REQUEST_METHOD"]=="POST"){
            $post=$req->getParsedBody();
            try{
                $userMdl=new Mdl\User(new Mdl\Db());
                $inviteMdl=new Mdl\Invite(new Mdl\Db());
                if($userMdl->screenNameExists($post["screen_name"])){
                    throw new \Exception("すでに登録されています");
                }
                $token=$inviteMdl->create($post["screen_name"],$post["name"]);
                return $this->createResponse()
                            ->withHeader("Location","/admin/users");
            }catch(\Exception $e){
                $err=$e->getMessage();
            }
        }
        return $this->twig("invite.tpl.html",[
            "err"=>$err
        ]);
    }
}

