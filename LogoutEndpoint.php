<?php

namespace Boke0\Mechanism\Plugins\VacuumTube;
use \Boke0\Mechanism\Api\Endpoint;

/**
 * @path /admin/logout;
 */
class LogoutEndpoint extends Endpoint{
    public function handle($req,$args){
        Session::delete("vt_uid");
        return $this->createResponse()
            ->withHeader("Location","/admin/login");
    }
}
