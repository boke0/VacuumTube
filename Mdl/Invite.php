<?php

namespace Boke0\Mechanism\Plugins\VacuumTube\Mdl;

class Invite{
    public function __construct($db){
        $this->db=$db;
    }
    public function create($screen_name,$name){
        $token=hash("sha256",uniqid().mt_rand());
        $this->db->query("insert into invite (screen_name,name,token) values (:screen_name,:name,:token)",[
            ":screen_name"=>$screen_name,
            ":name"=>$name,
            ":token"=>$token
        ]);
        return $token;
    }
    public function delete($id){
        $this->db->query("delete from invite where id=:id",[
            ":id"=>$id
        ]);
    }
    public function get($token){
        $invite=$this->db->query("select id,token,screen_name,name from invite where token=:token",[
            ":token"=>$token
        ])[0];
        return $invite;
    }
}
