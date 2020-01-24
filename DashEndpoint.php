<?php

namespace Boke0\Mechanism\Plugins\VacuumTube;
use \Boke0\Mechanism\Api\Endpoint;

/**
 * @path /admin;
 */
class DashEndpoint extends Endpoint{
    public function handle($req,$args){
        return $this->twig("dash.tpl.html");
    }
}
