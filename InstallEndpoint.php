<?php

namespace Boke0\Mechanism\Plugins\VacuumTube;
use \Boke0\Mechanism\Api\Endpoint;

/**
 * @path /admin/install
 */
class InstallEndpoint extends Endpoint{
    public function handle($req,$args){
        if(file_exists(__DIR__."/cfg.json")){
            return $this->createResponse()->withHeader("Location","/admin");
        }
        if($req->getServerParams()["REQUEST_METHOD"]=="POST"){
            $post=$req->getParsedBody();
            $host=$post["host"];
            $dbname=$post["dbname"];
            $user=$post["user"];
            $pass=$post["pass"];
            Cfg::set("dsn","mysql:host=$host;dbname=$dbname");
            Cfg::set("dbuser","$user");
            Cfg::set("dbpass","$pass");
            $pdo=new \PDO(Cfg::get("dsn"),Cfg::get("dbuser"),Cfg::get("dbpass"));
            $stmt=$pdo->prepare($sql);
            $stmt->execute();
            return $this->createResponse()->withHeader("Location","/admin");
        }
        return $this->twig("install.tpl.html");
    }
}
