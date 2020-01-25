<?php

namespace Boke0\Mechanism\Plugins\VacuumTube;
use \Boke0\Mechanism\Api\Endpoint;

/**
 * @path /admin
 */
class DashEndpoint extends Endpoint{
    public function handle($req,$args){
        if(!file_exists(__DIR__."/cfg.json")){
            return $this->createResponse()->withHeader("Location","/admin/install");
        }
        return $this->twig("dash.tpl.html");
    }
}
