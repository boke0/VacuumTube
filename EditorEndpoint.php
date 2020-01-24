<?php

namespace Boke0\Mechanism\Plugins\VacuumTube;
use \Boke0\Mechanism\Api\Endpoint;

/**
 * @path /admin/editor;
 */
class EditorEndpoint extends Endpoint{
    public function handle($req,$args){
        return $this->twig("editor.tpl.html");
    }
}
