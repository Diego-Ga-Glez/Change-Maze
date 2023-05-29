<?php

require_once '../php/usuarios.php';

class AjaxUsuarios{

    // Agregar seccion a la DB
    public $num_res;
    public $score;
    public $change;

    public function ajaxAgregarSeccion(){
        Usuario::agregarSeccionUsuario($this->num_res,$this->score,$this->change);    
    }

}

if(isset($_POST["num_resp"])){
    $agregar = new AjaxUsuarios();
    $agregar -> num_res = $_POST["num_resp"];
    $agregar -> score = $_POST["score"];
    $agregar -> change = $_POST["change"];
    $agregar -> ajaxAgregarSeccion();
}