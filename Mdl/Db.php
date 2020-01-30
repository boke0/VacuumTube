<?php

namespace Boke0\Mechanism\Plugins\VacuumTube\Mdl;
use \Boke0\Mechanism\Plugins\VacuumTube\Cfg;

class Db{
    public function __construct(){
        $this->dbh=new \PDO(Cfg::get("dsn"),Cfg::get("dbuser"),Cfg::get("dbpass"));    
    }
    public function query($sql,$values=[]){
        $stmt=$this->dbh->prepare($sql);
        $stmt->execute($values);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    public function lastInsertId($id="id"){
        return $this->dbh->lastInsertId($id);
    }
}
