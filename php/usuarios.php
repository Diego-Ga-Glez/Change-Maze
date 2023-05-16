<?php

require_once "conexion.php";

class Usuario{
    static public function agregarUsuario(){
        if(isset($_POST['nombre'])){
            
            # Ocupacion estudiante
            if($_POST['ocupacion'] == 1){

             # Ocupacion profesionista
            }else{
                
            }
        
        }
        /*$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla (nombre, usuario,password, perfil, foto) 
                VALUES (:nombre, :usuario, :password, :perfil, :foto)");

        $stmt->bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
        $stmt->bindParam(":usuario", $datos["usuario"], PDO::PARAM_STR);
        $stmt->bindParam(":password", $datos["password"], PDO::PARAM_STR);
        $stmt->bindParam(":perfil", $datos["perfil"], PDO::PARAM_STR);
        $stmt->bindParam(":foto", $datos["foto"], PDO::PARAM_STR);

        if($stmt->execute()){
            return "ok";
        }
        else{
            return "error";
        }

        //cerrar sesion
        $stmt = null;*/
    }
}