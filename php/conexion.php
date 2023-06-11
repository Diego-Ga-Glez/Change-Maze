<?php

class Conexion{
    static public function conectar(){
        $link = new PDO("mysql:host=66.225.201.137; dbname=qwsuvdzd_ChangeMaze; port=3306",
                        "qwsuvdzd_ChangeMaze",
                        "G4dalajara2020");

        $link->exec("set names utf8");
        return $link;
    }

}