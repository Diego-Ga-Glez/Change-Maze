<?php

require_once '../php/jugador.php';

class AjaxJugadores{

    // Agregar seccion a la DB
    public $num_res;
    public $score;
    public $change;

    public function ajaxAgregarSeccion(){
        Jugador::agregarSeccionJugador($this->num_res,$this->score,$this->change);    
    }

}

if(isset($_POST["num_resp"])){
    $agregar = new AjaxJugadores();
    $agregar -> num_res = $_POST["num_resp"];
    $agregar -> score = $_POST["score"];
    $agregar -> change = $_POST["change"];
    $agregar -> ajaxAgregarSeccion();
}

if(isset($_POST["encuesta"])){
    $_SESSION["game"] = false;
    $_SESSION["encuesta"] = true;
}