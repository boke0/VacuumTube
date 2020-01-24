<?php

namespace Boke0\Mechanism\Plugins\VacuumTube;

class Session{
    static public function get($key){
        return $_SESSION[$key];
    }
    static public function set($key,$value){
        $_SESSION[$key]=$value;
    }
    static public function delete($key){
        unset($_SESSION[$key]);
    }
}
