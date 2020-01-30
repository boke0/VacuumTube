<?php

namespace Boke0\Mechanism\Plugins\VacuumTube;
use \Boke0\Mechanism\Api\Endpoint;

/**
 * @path /admin/delete
 */
class DeleteEndpoint extends Endpoint{
    public function handle($req,$args){
        if(Session::get("vt_uid")==NULL){
            return $this->createResponse()->withHeader("Location","/admin/login");
        }
        if(!file_exists(__DIR__."/../../contents/cfg.json")){
            return $this->createResponse()->withHeader("Location","/admin/install");
        }
        $post=$req->getParsedBody();
        $path=urldecode($post["path"]);
        if(substr($path,0,1)!="/") $path="/$path";
        if(substr($path,1,-1)!="/") $path="$path/";
        $fullpath=__DIR__."/../../contents$path";
        if(is_dir($fullpath)){
            exec("rm -rf {$fullpath}");
        }else if(file_exists($fullpath)){
            unlink("$fullpath");
        }
        $jumpto=dirname($path);
        return $this->createResponse()
                    ->withHeader("Location","/admin/articles?path={$jumpto}");
    }
}
