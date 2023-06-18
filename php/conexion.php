<?php

class Conexion{
    static public function conectar(){
        $link = new PDO("mysql:host=localhost; dbname=erc_game",
                        "root",
                        "");

        $link->exec("set names utf8");
        return $link;
    }

}