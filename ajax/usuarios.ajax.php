<?php

require_once './php/usuarios.php';

//session_start();

class AjaxUsuarios{

    // Agregar seccion a la DB
    public $num_res;
    public $score;
    public $change;
    //public $id;

    public function ajaxAgregarSeccion(){
        //Usuario::agregarSeccionUsuario($this->num_res,$this->score,$this->change,$this->id);    
    }

}

echo '<script> console.log("hola") </script>';

if(isset($_POST["num_resp"])){
    echo '<script> console.log("hola") </script>';
    $agregar = new AjaxUsuarios();
    $agregar -> num_res = $_POST["num_resp"];
    $agregar -> score = $_POST["score"];
    $agregar -> change = $_POST["change"];
    //$agregar -> id = $_SESSION["id"];
    $agregar -> ajaxAgregarSeccion();
}