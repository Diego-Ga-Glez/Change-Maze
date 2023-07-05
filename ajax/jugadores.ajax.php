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

    public $id;

    public function ajaxJugadorSeccionesyEncuesta(){
        $respuesta = Jugador::jugadorSeccionesyEncuesta($this->id);
        echo json_encode($respuesta);
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

if(isset($_POST["idInfoJugador"])){
    $mostrar = new AjaxJugadores();
    $mostrar -> id = $_POST["idInfoJugador"];
    $mostrar -> ajaxJugadorSeccionesyEncuesta();
}