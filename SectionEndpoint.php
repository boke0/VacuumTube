<?php

namespace Boke0\Mechanism\Plugins\VacuumTube;
use \Boke0\Mechanism\Api\Endpoint;

/**
 * @path /admin/section
 */
class SectionEndpoint extends Endpoint{
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
            $articleMdl=new Mdl\Article();
            $title=$post["title"]!=""?$post["title"]:"無題";
            $path=isset($post["path"])?$post["path"]:"/";
            $articleMdl->createSection($path);
            if(substr($path,-1,1)!="/") $path="$path/";
            $articleMdl->postArticle("{$path}__index.md","---\ntitle: $title\n---");
            return $this->createResponse()
                        ->withHeader("Location","/admin/articles?path={$post["path"]}");
        }
        return $this->twig("create_section.tpl.html",[
            "path"=>$path
        ]);
    }
}

