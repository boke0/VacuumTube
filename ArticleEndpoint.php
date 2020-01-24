<?php

namespace Boke0\Mechanism\Plugins\VacuumTube;
use \Boke0\Mechanism\Api\Endpoint;

/**
 * @path /admin/articles;
 */
class ArticlesEndpoint extends Endpoint{
    public function handle($req,$args){
        return $this->twig("articles.tpl.html");
    }
}
