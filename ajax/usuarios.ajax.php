<?php

require_once '../php/usuario.php';

class AjaxUsuarios{

    // mostrar Usuario
    public $id;

    public function ajaxMostrarUsuario(){
        $respuesta = Usuario::mostrarUsuarios($this->id);
        echo json_encode($respuesta);
    }

}

if(isset($_POST["idUsuario"])){
    $modificar = new AjaxUsuarios();
    $modificar -> id = $_POST["idUsuario"];
    $modificar -> ajaxMostrarUsuario();
}