<?php

namespace Boke0\Mechanism\Plugins\VacuumTube;
use \Boke0\Mechanism\Api\Endpoint;

/**
 * @path /admin/editor
 */
class EditorEndpoint extends Endpoint{
    public function handle($req,$args){
        $qs=$req->getQueryParams();
        $path=urldecode($qs["path"]);
        $slug=isset($qs["slug"])?$qs["slug"]:date("YmdHis");
        if(Session::get("vt_uid")==NULL){
            return $this->createResponse()->withHeader("Location","/admin/login");
        }
        if(!file_exists(__DIR__."/../../contents/cfg.json")){
            return $this->createResponse()->withHeader("Location","/admin/install");
        }
        $articleMdl=new Mdl\Article();
        if(file_exists(__DIR__."/../../contents/$path$slug.md")){
            $md=file_get_contents(__DIR__."/../../contents/$path$slug.md");
        }
        if($req->getServerParams()["REQUEST_METHOD"]=="POST"){
            $post=$req->getParsedBody();
            $articleMdl->postArticle($post["path"],$post["content"]);
            $md=$post["content"];
        }
        return $this->twig("editor.tpl.html",[
            "path"=>$path.$slug.".md",
            "md"=>$md
        ]);
    }
}
