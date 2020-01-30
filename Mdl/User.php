<?php

namespace Boke0\Mechanism\Plugins\VacuumTube\Mdl;
use \Boke0\Mechanism\Plugins\VacuumTube\Cfg;

class User{
    public function __construct($db,$invite=NULL){
        $this->db=$db;
        $this->invite=$invite;
    }
    public function signup($token,$password){
        $invite=$this->invite->get($token);
        $this->db->query("insert into user (screen_name,name,password) values (:screen_name,:name,:password)",[
            ":screen_name"=>$invite["screen_name"],
            ":name"=>$invite["name"],
            ":password"=>$this->genPasswd($password)
        ]);
        $id=$this->db->lastInsertId();
        $this->invite->delete($invite["id"]);
        return $id;
    }
    public function get($id){
        return $this->db->query("select id,name,screen_name from user where id=:id",[
            ":id"=>$id
        ])[0];
    }
    public function delete($id){
        $this->db->query("delete from user where id=:id",[
            ":id"=>$id
        ]);
    }
    public function login($screen_name,$password){
        $id=$this->db->query("select id from user where screen_name=:screen_name and password=:password",[
            ":screen_name"=>$screen_name,
            ":password"=>$this->genPasswd($password)
        ])[0]["id"];
        return $id;
    }
    public function verify($id,$passwd){
        return $this->db->query("select count(*) as c from user where id=:id and password=:pass",[
            ":id"=>$id,
            ":pass"=>$this->genPasswd($passwd)
        ])[0]>0;
    }
    public function genPasswd($passwd){
        return hash("sha256",Cfg::get("passwd_key").$screen_name.$password);
    }
    public function list(){
        return $this->db->query("select id,screen_name,name from user");
    }
    public function screenNameExists($screen_name){
        return $this->db->query("select count(*) as c from user where screen_name=:screen_name",[
            ":screen_name"=>$screen_name
        ])[0]["c"]>0;
    }
}
