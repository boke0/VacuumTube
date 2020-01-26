<?php

namespace Boke0\Mechanism\Plugins\VacuumTube;

class Cfg{
    static public function get($key){
        if(!file_exists(__DIR__."/../../contents/cfg.json")) return [];
        $json=json_decode(file_get_contents(__DIR__."/../../contents/cfg.json"),TRUE);
        return $json[$key];
    }
    static public function set($key,$value){
        if(!file_exists(__DIR__."/../../contents/cfg.json")){
            $json=[];
        }else{
            $json=json_decode(file_get_contents(__DIR__."/../../contents/cfg.json"),TRUE);
        }
        $json[$key]=$value;
        file_put_contents(__DIR__."/../../contents/cfg.json",json_encode($json));
    }
}
