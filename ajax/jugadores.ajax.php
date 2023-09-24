<?php

require_once '../php/jugador.php';

class AjaxJugadores{

    // Agregar seccion a la DB
    public $num_res;
    public $score;
    public $change;
    public $luck;
    public $coins_level;
    public $coins_obtained;

    public function ajaxAgregarSeccion(){
        Jugador::agregarSeccionJugador($this->num_res,$this->score,$this->change,$this->luck, $this->coins_level, $this->coins_obtained);    
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
    $agregar -> luck = $_POST["luck"];
    $agregar -> coins_level = $_POST["coins_level"];
    $agregar -> coins_obtained = $_POST["coins_obtained"];

    $agregar -> ajaxAgregarSeccion();
}

if(isset($_POST["encuesta"])){
    $_SESSION["game"] = false;
    //$_SESSION["encuesta"] = true;
}

if(isset($_POST["idInfoJugador"])){
    $mostrar = new AjaxJugadores();
    $mostrar -> id = $_POST["idInfoJugador"];
    $mostrar -> ajaxJugadorSeccionesyEncuesta();
}