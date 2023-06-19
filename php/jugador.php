<?php

session_start();
require_once "conexion.php";

class Jugador{

    static public function mostrarJugadores() {
        try{
            $stmt = Conexion::conectar()->prepare("SELECT * FROM jugador");
            $stmt -> execute();
            return $stmt -> fetchAll();
        }catch(Exception $e){} 
    }

    static public function jugadoresIncompletos() {
        try{
            $stmt = Conexion::conectar()->prepare("SELECT jugador.*, seccion.id_jugador, encuesta.id_jugador FROM jugador LEFT JOIN seccion ON seccion.id_jugador = jugador.id LEFT JOIN encuesta ON encuesta.id_jugador = jugador.id WHERE seccion.id_jugador IS NULL OR encuesta.id_jugador IS NULL");
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

    static public function eliminarJugador() {
        if(isset($_GET['idJugador'])){
            try{
                $stmt = Conexion::conectar()->prepare("DELETE FROM jugador WHERE id = :id");
                $stmt->bindParam(":id", $_GET['idJugador'], PDO::PARAM_INT);
                $stmt -> execute();

                echo '<script>
                        Swal.fire({
                            title: "Jugador eliminado con éxito",
                            icon: "success",
                            confirmButtonText: "OK"
                            }).then((result) => {
                            if (result.isConfirmed) {
                                window.location = "jugadores";
                            }
                        }) 
                        </script>';
    
            }catch(Exception $e){
                echo '<script>
                            Swal.fire({
                                title: "Algo salió mal, jugador no eliminado",
                                text: "Por favor, intentalo de nuevo",
                                icon: "error",
                                confirmButtonText: "OK"
                                }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location = "jugadores";
                                }
                            }) 
                          </script>';
            } 
        }
    }
    
    static public function agregarSeccionJugador($num_resp,$score,$change){
        try{
            $stmt = Conexion::conectar()->prepare("INSERT INTO seccion (num_respuesta,calificacion_juego,cambiar_juego,id_jugador)
            VALUES(:num_resp,:score, :change, :id)");
            
            $stmt->bindParam(":num_resp", $num_resp, PDO::PARAM_INT);
            $stmt->bindParam(":score", $score, PDO::PARAM_STR);
            $stmt->bindParam(":change", $change, PDO::PARAM_STR);
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
                
                echo '<script>
                        Swal.fire({
                            title: "Jugador registrado con éxito",
                            text: "Ahora serás redireccionado al juego",
                            icon: "success",
                            allowEscapeKey: false,
                            allowOutsideClick: false,
                            confirmButtonText: "OK"
                            }).then((result) => {
                            if (result.isConfirmed) {
                                window.location = "game";
                            }
                        }) 
                      </script>'; 
            }catch(Exception $e){
                echo '<script>
                        Swal.fire({
                            title: "Algo salió mal, jugador no registrado",
                            text: "Por favor, intentalo de nuevo",
                            icon: "error",
                            allowEscapeKey: false,
                            allowOutsideClick: false,
                            confirmButtonText: "OK"
                            }).then((result) => {
                            if (result.isConfirmed) {
                                window.location = "";
                            }
                        }) 
                      </script>'; 
            }
        }  
    }

    public function agregarEncuesta() {
        if(isset($_POST['p1'])){
            try{
                $stmt = Conexion::conectar()-> prepare("INSERT INTO encuesta (p1,p2,p3,p4,p5,p6,p7,p8,p9,p10,p11,p12,p13,p14,p15,p16,p17,busqueda_rutina,reaccion_emocional,enfoque_corto_plazo,rigidez_cognitiva,puntaje_total,id_jugador) 
                VALUES (:p1, :p2, :p3, :p4, :p5, :p6, :p7, :p8, :p9, :p10, :p11, :p12, :p13, :p14, :p15, :p16, :p17,:busqueda_rutina, :reaccion_emocional, :enfoque_corto_plazo, :rigidez_cognitiva, :puntaje_total, :id)");

                $stmt->bindParam(":p1", $_POST['p1'], PDO::PARAM_INT);
                $stmt->bindParam(":p2", $_POST['p2'], PDO::PARAM_INT);
                $stmt->bindParam(":p3", $_POST['p3'], PDO::PARAM_INT);
                $stmt->bindParam(":p4", $_POST['p4'], PDO::PARAM_INT);
                $stmt->bindParam(":p5", $_POST['p5'], PDO::PARAM_INT);
                $stmt->bindParam(":p6", $_POST['p6'], PDO::PARAM_INT);
                $stmt->bindParam(":p7", $_POST['p7'], PDO::PARAM_INT);
                $stmt->bindParam(":p8", $_POST['p8'], PDO::PARAM_INT);
                $stmt->bindParam(":p9", $_POST['p9'], PDO::PARAM_INT);
                $stmt->bindParam(":p10", $_POST['p10'], PDO::PARAM_INT);
                $stmt->bindParam(":p11", $_POST['p11'], PDO::PARAM_INT);
                $stmt->bindParam(":p12", $_POST['p12'], PDO::PARAM_INT);
                $stmt->bindParam(":p13", $_POST['p13'], PDO::PARAM_INT);
                $stmt->bindParam(":p14", $_POST['p14'], PDO::PARAM_INT);
                $stmt->bindParam(":p15", $_POST['p15'], PDO::PARAM_INT);
                $stmt->bindParam(":p16", $_POST['p16'], PDO::PARAM_INT);
                $stmt->bindParam(":p17", $_POST['p17'], PDO::PARAM_INT);

                $busqueda_rutina = ($_POST['p1'] + $_POST['p2'] + $_POST['p3'] + abs($_POST['p4']-7) + $_POST['p5'])/5;
                $stmt->bindParam(":busqueda_rutina", $busqueda_rutina, PDO::PARAM_STR);

                $reaccion_emocional = ($_POST['p6'] + $_POST['p7'] + $_POST['p8'] + $_POST['p9'])/4;
                $stmt->bindParam(":reaccion_emocional", $reaccion_emocional, PDO::PARAM_STR);

                $enfoque_corto_plazo = ($_POST['p10'] + $_POST['p11'] + $_POST['p12'] + $_POST['p13'])/4;
                $stmt->bindParam(":enfoque_corto_plazo", $enfoque_corto_plazo, PDO::PARAM_STR);

                $rigidez_cognitiva = (abs($_POST['p14']-7) + $_POST['p15'] + $_POST['p16'] + $_POST['p17'])/4;
                $stmt->bindParam(":rigidez_cognitiva", $rigidez_cognitiva, PDO::PARAM_STR);

                $puntaje_total = ($busqueda_rutina + $reaccion_emocional + $enfoque_corto_plazo + $rigidez_cognitiva)/4;
                $stmt->bindParam(":puntaje_total",$puntaje_total, PDO::PARAM_STR);
                $stmt->bindParam(":id", $_SESSION['id'], PDO::PARAM_INT);

            
                $stmt->execute();
                echo '<script>
                        Swal.fire({
                            title: "Resultados guardados con éxito",
                            text: "Muchas gracias por participar en este experimento",
                            icon: "success",
                            allowEscapeKey: false,
                            allowOutsideClick: false,
                            confirmButtonText: "OK"
                            }).then((result) => {
                            if (result.isConfirmed) {
                                window.location = "";
                            }
                        }) 
                      </script>';

                session_destroy(); 
            }catch(Exception $e){
                echo '<script>
                        Swal.fire({
                            title: "Algo salió mal, respuestas no registradas",
                            text: "Por favor, intentalo de nuevo",
                            icon: "error",
                            allowEscapeKey: false,
                            allowOutsideClick: false,
                            confirmButtonText: "OK"
                            }).then((result) => {
                            if (result.isConfirmed) {
                                window.location = "encuesta";
                            }
                        }) 
                      </script>'; 
            }
        }
    }
}