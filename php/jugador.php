<?php

session_start();
require_once "conexion.php";
require_once "alert.php";

class Jugador{
    
    static public function avg_jugadores($campos){
        try{
            $sql = "SELECT ";
            foreach ($campos as $c) { $sql .= $c.","; }
            $sql = substr($sql, 0, -1);
            $sql .= " FROM avg_seccion";
            $stmt = Conexion::conectar()->prepare($sql);
            $stmt -> execute();
            if(count($campos) != 1) return $stmt -> fetchAll(PDO::FETCH_NUM);
            else return $stmt -> fetchAll(PDO::FETCH_COLUMN, 0);

        }catch(Exception $e){} 
    }

    static public function topJugadores($limit) {
        try{
            if($limit == 1){
                $stmt = Conexion::conectar()->prepare("SELECT p.*, j.nombre_completo FROM puntaje AS p INNER JOIN jugador AS j ON p.id_jugador = j.id ORDER BY p.monedas_total DESC, p.tiempo_total ASC LIMIT 10;");
                $stmt -> execute();
                return $stmt -> fetchAll();
            }
            else {
                $stmt = Conexion::conectar()->prepare("SELECT p.*, j.nombre_completo FROM puntaje AS p INNER JOIN jugador AS j ON p.id_jugador = j.id ORDER BY p.monedas_total DESC, p.tiempo_total ASC;");
                $stmt -> execute();
                return $stmt -> fetchAll();
            }
        }catch(Exception $e){} 
    }

    static public function agregarPuntajeJugador($total_time,$total_coins){
        try{
            $stmt = Conexion::conectar()->prepare("INSERT INTO puntaje (tiempo_total,monedas_total,id_jugador)
            VALUES(:total_time,:total_coins,:id)");
            
            $stmt->bindParam(":total_time", $total_time, PDO::PARAM_INT);
            $stmt->bindParam(":total_coins", $total_coins, PDO::PARAM_INT);
            $stmt->bindParam(":id", $_SESSION["id"], PDO::PARAM_INT);

            $stmt -> execute();
            
            // Agregar promedio a tabla avg_seccion

            $sth = Conexion::conectar()->prepare("SELECT AVG(calificacion_juego) AS avg_calificacion_juego,
            AVG(cambiar_juego) AS avg_cambiar_juego, AVG(suerte) AS avg_suerte, AVG(monedas_obtenidas) AS
            avg_monedas_obtenidas FROM seccion WHERE id_jugador = :id_jugador");

            $sth->bindParam(":id_jugador", $_SESSION["id"], PDO::PARAM_INT);
            $sth -> execute();
            $resultado = $sth -> fetch(PDO::FETCH_ASSOC);

            $stc = Conexion::conectar()->prepare("INSERT INTO avg_seccion (avg_calificacion_juego,
            avg_cambiar_juego, avg_suerte, avg_monedas_obtenidas, id_jugador) VALUES (:avg_calificacion_juego,
            :avg_cambiar_juego, :avg_suerte, :avg_monedas_obtenidas, :id_jugador)");

            $stc->bindParam(":avg_calificacion_juego", $resultado["avg_calificacion_juego"], PDO::PARAM_STR);
            $stc->bindParam(":avg_cambiar_juego", $resultado["avg_cambiar_juego"], PDO::PARAM_STR);
            $stc->bindParam(":avg_suerte", $resultado["avg_suerte"], PDO::PARAM_STR);
            $stc->bindParam(":avg_monedas_obtenidas", $resultado["avg_monedas_obtenidas"], PDO::PARAM_STR);
            $stc->bindParam(":id_jugador", $_SESSION["id"], PDO::PARAM_INT);
            $stc -> execute();

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

}