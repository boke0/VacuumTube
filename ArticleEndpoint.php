<?php

namespace Boke0\Mechanism\Plugins\VacuumTube;
use \Boke0\Mechanism\Api\Endpoint;

/**
 * @path /admin/articles
 */
class ArticleEndpoint extends Endpoint{
    public function handle($req,$args){
        $qs=$req->getQueryParams();
        $articleMdl=new Mdl\Article();
        $path=isset($qs["path"])?$qs["path"]:"/";
        if(Session::get("vt_uid")==NULL){
            return $this->createResponse()->withHeader("Location","/admin/login");
        }
        if(!file_exists(__DIR__."/../../contents/cfg.json")){
            return $this->createResponse()->withHeader("Location","/admin/install");
        }
        return $this->twig("articles.tpl.html",$articleMdl->getDirList($path));
    }
}
