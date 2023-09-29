<?php

session_start();
require_once "conexion.php";
require_once "alert.php";

class Jugador{

    static public function agregarPuntajeJugador($total_time,$total_coins){
        try{
            $stmt = Conexion::conectar()->prepare("INSERT INTO puntaje (tiempo_total,monedas_total,id_jugador)
            VALUES(:total_time,:total_coins,:id)");
            
            $stmt->bindParam(":total_time", $total_time, PDO::PARAM_INT);
            $stmt->bindParam(":total_coins", $total_coins, PDO::PARAM_INT);
            $stmt->bindParam(":id", $_SESSION["id"], PDO::PARAM_INT);

            $stmt -> execute();
        }catch(Exception $e){}
    }

    static public function jugadorSeccionesyEncuesta($id){
        try{
            $stmt = Conexion::conectar()->prepare("SELECT* FROM seccion,encuesta WHERE seccion.id_jugador = :id_s AND encuesta.id_jugador = :id_e;");
            $stmt->bindParam(":id_s", $id, PDO::PARAM_INT);
            $stmt->bindParam(":id_e", $id, PDO::PARAM_INT);
            $stmt -> execute();
            return $stmt -> fetchAll();
        }catch(Exception $e){}
    }
    
    static public function jugadoresCompletos() {
        try{
            $stmt = Conexion::conectar()->prepare("SELECT DISTINCT jugador.*, seccion.id_jugador, encuesta.id_jugador FROM jugador LEFT JOIN seccion ON seccion.id_jugador = jugador.id LEFT JOIN encuesta ON encuesta.id_jugador = jugador.id WHERE seccion.id_jugador IS NOT NULL AND encuesta.id_jugador IS NOT NULL;");
            $stmt -> execute();
            return $stmt -> fetchAll();
        }catch(Exception $e){} 
    }

    static public function jugadoresIncompletos() {
        try{
            $stmt = Conexion::conectar()->prepare("SELECT DISTINCT jugador.*, seccion.id_jugador, encuesta.id_jugador FROM jugador LEFT JOIN seccion ON seccion.id_jugador = jugador.id LEFT JOIN encuesta ON encuesta.id_jugador = jugador.id WHERE seccion.id_jugador IS NULL OR encuesta.id_jugador IS NULL");
            $stmt -> execute();
            return $stmt -> fetchAll();
        }catch(Exception $e){} 
    }
    
    static public function eliminarUsuario(){
        try{
            $stmt = Conexion::conectar()->prepare("DELETE FROM jugador WHERE id = :id");
            $stmt->bindParam(":id", $_SESSION["id"], PDO::PARAM_INT);
            $stmt -> execute();
        }catch(Exception $e){} 
    }

    static public function eliminarJugador($ruta) {
        if(isset($_GET['idJugador'])){
            try{
                $stmt = Conexion::conectar()->prepare("DELETE FROM jugador WHERE id = :id");
                $stmt->bindParam(":id", $_GET['idJugador'], PDO::PARAM_INT);
                $stmt -> execute();
                echo alerts("Jugador eliminado con éxito","","success","OK",$ruta);
    
            }catch(Exception $e){
                echo alerts("Algo salió mal, jugador no eliminado",
                            "Por favor, intentalo de nuevo","error","OK",$ruta);
            } 
        }
    }
    
    static public function agregarSeccionJugador($num_resp,$score,$change,$luck,$coins_level,$coins_obtained,$current_level,$time_elapsed){
        try{
            $stmt = Conexion::conectar()->prepare("INSERT INTO seccion (num_respuesta,calificacion_juego,cambiar_juego,suerte,monedas_nivel,monedas_obtenidas,nivel_actual,tiempo_transcurrido,id_jugador)
            VALUES(:num_resp,:score, :change,:luck,:coins_level,:coins_obtained,:current_level,:time_elapsed,:id)");
            
            $stmt->bindParam(":num_resp", $num_resp, PDO::PARAM_INT);
            $stmt->bindParam(":score", $score, PDO::PARAM_INT);
            $stmt->bindParam(":change", $change, PDO::PARAM_INT);
            $stmt->bindParam(":luck", $luck, PDO::PARAM_INT);
            $stmt->bindParam(":coins_level", $coins_level, PDO::PARAM_INT);
            $stmt->bindParam(":coins_obtained", $coins_obtained, PDO::PARAM_INT);
            $stmt->bindParam(":current_level", $current_level, PDO::PARAM_INT);
            $stmt->bindParam(":time_elapsed", $time_elapsed, PDO::PARAM_INT);
            $stmt->bindParam(":id", $_SESSION["id"], PDO::PARAM_INT);

            $stmt -> execute();
        }catch(Exception $e){}
    }
    
    static public function obtenerJugador($nombre,$correo){
        # obtener id del jugador
        $stmt = Conexion::conectar()->prepare("SELECT * FROM jugador WHERE nombre_completo = :nombre and correo = :correo");
        $stmt->bindParam(":nombre", $nombre, PDO::PARAM_STR);
        $stmt->bindParam(":correo", $correo, PDO::PARAM_STR);
        $stmt -> execute();
        return $stmt -> fetch(PDO::FETCH_OBJ);
    }
    
    public function agregarJugador(){
        if(isset($_POST['nombre'])){
            try{
                # Ocupacion estudiante
                if($_POST['ocupacion'] == 'ESTUDIANTE'){
                    $stmt = Conexion::conectar()->prepare("INSERT INTO jugador (nombre_completo,correo,sexo,edad,ocupacion,escuela,carrera,semestre) 
                    VALUES (:nombre, :correo, :genero, :edad, :ocupacion,:escuela, :carrera, :semestre)");

                    $stmt->bindParam(":nombre", $_POST["nombre"], PDO::PARAM_STR);
                    $stmt->bindParam(":correo", $_POST["correo"], PDO::PARAM_STR);
                    $stmt->bindParam(":genero", $_POST["genero"], PDO::PARAM_STR);
                    $stmt->bindParam(":edad", $_POST["edad"], PDO::PARAM_INT);
                    $stmt->bindParam(":ocupacion", $_POST["ocupacion"], PDO::PARAM_STR);
                    $stmt->bindParam(":escuela", $_POST["escuela"], PDO::PARAM_STR);
                    $stmt->bindParam(":carrera", $_POST["carrera"], PDO::PARAM_STR);
                    $stmt->bindParam(":semestre", $_POST["semestre"], PDO::PARAM_INT);
                # Ocupacion profesionista
                }else{
                    $stmt = Conexion::conectar()->prepare("INSERT INTO jugador (nombre_completo,correo,sexo,edad,ocupacion,profesion) 
                    VALUES (:nombre, :correo, :genero, :edad, :ocupacion,:profesion)");

                    $stmt->bindParam(":nombre", $_POST["nombre"], PDO::PARAM_STR);
                    $stmt->bindParam(":correo", $_POST["correo"], PDO::PARAM_STR);
                    $stmt->bindParam(":genero", $_POST["genero"], PDO::PARAM_STR);
                    $stmt->bindParam(":edad", $_POST["edad"], PDO::PARAM_INT);
                    $stmt->bindParam(":ocupacion", $_POST["ocupacion"], PDO::PARAM_STR);
                    $stmt->bindParam(":profesion", $_POST["profesion"], PDO::PARAM_STR);  
                }

            
                $stmt->execute();
                $result = $this -> obtenerJugador($_POST['nombre'],$_POST['correo']);
                $_SESSION["id"] = $result -> id;
                $_SESSION["game"] = true;
                
                echo alerts("Jugador registrado con éxito",
                            "Ahora serás redireccionado al juego","success","OK","game");
            }catch(Exception $e){
                echo alerts("Algo salió mal, jugador no registrado",
                            "Por favor, intentalo de nuevo","error","OK","");
            }
        }  
    }
        
    static public function contarJugadores($ocupacion){
        try {
            $stmt = Conexion::conectar()->prepare("SELECT COUNT(*) AS cantidad FROM jugador WHERE ocupacion = :ocupacion;");
            $stmt->bindParam(":ocupacion",$ocupacion, PDO::PARAM_STR);
            $stmt -> execute();
            return $stmt -> fetch(PDO::FETCH_OBJ);
        }catch(Exception $e){}
    }

    static public function seccionesJuego($calificacion_juego, $cambiar_juego){
        try{
            $stmt = Conexion::conectar()->prepare("SELECT COUNT(*) AS cantidad FROM seccion 
            WHERE calificacion_juego = :calificacion_juego AND cambiar_juego = :cambiar_juego;");

            $stmt->bindParam(":calificacion_juego",$calificacion_juego, PDO::PARAM_STR);
            $stmt->bindParam(":cambiar_juego",$cambiar_juego, PDO::PARAM_STR);
            $stmt -> execute();
            return $stmt -> fetch(PDO::FETCH_OBJ);
        }catch(Exception $e) {}
    }

    static public function contarEdades($edadMin, $edadMax){
        try {
            $stmt = Conexion::conectar()->prepare("SELECT COUNT(*) AS cantidad FROM jugador WHERE edad BETWEEN :edadMin AND :edadMax;");
            $stmt->bindParam(":edadMin",$edadMin, PDO::PARAM_INT);
            $stmt->bindParam(":edadMax",$edadMax, PDO::PARAM_INT);
            $stmt -> execute();
            return $stmt -> fetch(PDO::FETCH_OBJ);
        }catch(Exception $e){}
    }
}