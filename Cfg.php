<?php

namespace Boke0\Mechanism\Plugins\VacuumTube;

class Cfg{
    static public function get($key){
        $json=json_decode(__DIR__."/cfg.json");
        return $json->$key;
    }
    static public function set($key,$value){
        $json=json_decode(file_get_contents(__DIR__."/cfg.json"),TRUE);
        $json[$key]=$value;
        file_put_contents(__DIR__."/cfg.json",json_encode($json));
    }
}
