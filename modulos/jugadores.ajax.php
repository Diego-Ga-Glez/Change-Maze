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
    public $current_level;
    public $time;

    public function ajaxAgregarSeccion(){
        Jugador::agregarSeccionJugador($this->num_res,$this->score,$this->change,$this->luck, $this->coins_level, $this->coins_obtained, $this->current_level, $this->time);    
    }

    public $id;

    public function ajaxJugadorSeccionesyEncuesta(){
        $respuesta = Jugador::jugadorSeccionesyEncuesta($this->id);
        echo json_encode($respuesta);
    }

    public $total_time;
    public $total_coins;

    public function ajaxJugadorAgregarPuntaje(){
        Jugador::agregarPuntajeJugador($this->total_time,$this->total_coins);
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
    $agregar -> current_level = $_POST["current_level"];
    $agregar -> time = $_POST["time"];

    $agregar -> ajaxAgregarSeccion();
}

if(isset($_POST["idInfoJugador"])){
    $mostrar = new AjaxJugadores();
    $mostrar -> id = $_POST["idInfoJugador"];
    $mostrar -> ajaxJugadorSeccionesyEncuesta();
}

if(isset($_POST["total_time"])){
    $_SESSION["game"] = false;
    $_SESSION["puntaje"] = true;
    $puntaje = new AjaxJugadores();
    $puntaje -> total_time = $_POST["total_time"];
    $puntaje -> total_coins = $_POST["total_coins"];
    $puntaje -> ajaxJugadorAgregarPuntaje();
}