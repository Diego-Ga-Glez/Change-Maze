<?php

session_start();
require_once "conexion.php";
require_once "alert.php";

class Jugador{

    static public function resultados_jugador() {
        try{
            $stmt = Conexion::conectar()->prepare("SELECT * FROM resultados WHERE id_jugador = :id_jugador");
            $stmt->bindParam(":id_jugador", $_SESSION["id"], PDO::PARAM_INT);
            $stmt -> execute();
            return $stmt -> fetch(PDO::FETCH_OBJ);
        }catch(Exception $e){} 
    }
    
    static public function avg_jugadores($campos){
        try{
            $sql = "SELECT ";
            foreach ($campos as $c) { $sql .= $c.","; }
            $sql = substr($sql, 0, -1);
            $sql .= " FROM resultados";
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

    public function agregarPuntajeJugador($total_time,$total_coins){
        try{
            $stmt = Conexion::conectar()->prepare("INSERT INTO puntaje (tiempo_total,monedas_total,id_jugador)
            VALUES(:total_time,:total_coins,:id)");
            
            $stmt->bindParam(":total_time", $total_time, PDO::PARAM_INT);
            $stmt->bindParam(":total_coins", $total_coins, PDO::PARAM_INT);
            $stmt->bindParam(":id", $_SESSION["id"], PDO::PARAM_INT);

            $stmt -> execute();
            
            // Agregar promedios a tabla resultados

            // Promedios para búsqueda de rutina y reacción emocional
            $sth = Conexion::conectar()->prepare("SELECT AVG(calificacion_juego) AS avg_calificacion_juego,
            AVG(cambiar_juego) AS avg_cambiar_juego, AVG(suerte) AS avg_suerte FROM seccion WHERE id_jugador = :id_jugador");

            $sth->bindParam(":id_jugador", $_SESSION["id"], PDO::PARAM_INT);
            $sth -> execute();
            $resultado = $sth -> fetch(PDO::FETCH_ASSOC);

            // Para rigidez cognitiva
            $resultadoNo = $this -> contarCambioJuego(0); // 0 = no cambiar juego
            $resultadoSi = $this -> contarCambioJuego(1); // 0 = sí cambiar juego
            $totalCambios = $this -> contarCambioJuego(3); // 3 = total de cambios

            $noCambiar = intval($resultadoNo -> cambio);
            $siCambiar = intval($resultadoSi -> cambio);
            $total = intval($totalCambios -> cambio);

            $porcentajeNo = $noCambiar / $total; 
            $porcentajeSi = $siCambiar / $total;

            if ($porcentajeNo > $porcentajeSi)
                $num = $porcentajeSi / $porcentajeNo; //dividir numero menor entre el mayor
            else
                $num = $porcentajeNo / $porcentajeSi;

            $rigidezCognitiva = 1 - $num;

            // Para enfoque a corto plazo
            $promedio_cal_juego = floatval($resultado["avg_calificacion_juego"]);
            $primer_porcentaje = $promedio_cal_juego / 2;

            $promedio_suerte = floatval($resultado["avg_suerte"]); //Tal vez cambie
            $segundo_porcentaje = (1 - $promedio_suerte) / 2;
            $enfoque_corto_plazo = $primer_porcentaje + $segundo_porcentaje;


            $stc = Conexion::conectar()->prepare("INSERT INTO resultados (busqueda_rutina,
            reaccion_emocional, enfoque_corto_plazo, rigidez_cognitiva, id_jugador) VALUES (:busqueda_rutina,
            :reaccion_emocional, :enfoque_corto_plazo, :rigidez_cognitiva, :id_jugador)");

            $stc->bindParam(":busqueda_rutina", $resultado["avg_cambiar_juego"], PDO::PARAM_STR);
            $stc->bindParam(":reaccion_emocional", $resultado["avg_calificacion_juego"], PDO::PARAM_STR);
            $stc->bindParam(":enfoque_corto_plazo", $enfoque_corto_plazo, PDO::PARAM_STR);
            $stc->bindParam(":rigidez_cognitiva", $rigidezCognitiva, PDO::PARAM_STR);
            $stc->bindParam(":id_jugador", $_SESSION["id"], PDO::PARAM_INT);
            $stc -> execute();

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
    
    static public function obtenerJugador($correo){
        # obtener id del jugador
        $stmt = Conexion::conectar()->prepare("SELECT * FROM jugador WHERE correo = :correo");
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

                $result = $this -> obtenerJugador($_POST['correo']);

                if ($result != NULL) {
                    echo alerts("Ya existe un jugador registrado con ese correo.",
                            "Intenta con otro correo electrónico.","error","OK","");
                }
                else {
                    $stmt->execute();
                    $result = $this -> obtenerJugador($_POST['correo']);
                    $_SESSION["id"] = $result -> id;
                    $_SESSION["game"] = true;
                    
                    echo alerts("Jugador registrado con éxito",
                                "Ahora serás redireccionado al juego","success","OK","game");
                }
            }catch(Exception $e){
                echo alerts("Algo salió mal, jugador no registrado",
                            "Por favor, intentalo de nuevo","error","OK","");
            }
        }  
    }

    static public function contarCambioJuego($cambio){
        try {
            if ($cambio == 3) {
                $stmt = Conexion::conectar()->prepare("SELECT COUNT(cambiar_juego) AS cambio FROM seccion WHERE id_jugador = :id_jugador");
            }
            else {
                $stmt = Conexion::conectar()->prepare("SELECT COUNT(cambiar_juego) AS cambio FROM seccion WHERE id_jugador = :id_jugador AND cambiar_juego = :cambiar_juego;");
                $stmt->bindParam(":cambiar_juego",$cambio, PDO::PARAM_INT);
            }

            $stmt->bindParam(":id_jugador", $_SESSION["id"], PDO::PARAM_INT);
            $stmt -> execute();
            return $stmt -> fetch(PDO::FETCH_OBJ);
        }catch(Exception $e){}
    }

}