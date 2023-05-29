<?php

require_once "conexion.php";
session_start();

class Usuario{
    
    static public function agregarSeccionUsuario($num_resp,$score,$change){
        $stmt = Conexion::conectar()->prepare("INSERT INTO seccion (num_respuesta,calificacion_juego,cambiar_juego,id_usuario)
        VALUES(:num_resp,:score, :change, :id)");

        $stmt->bindParam(":num_resp", $num_resp, PDO::PARAM_INT);
        $stmt->bindParam(":score", $score, PDO::PARAM_STR);
        $stmt->bindParam(":change", $change, PDO::PARAM_STR);
        $stmt->bindParam(":id", $_SESSION["id"], PDO::PARAM_INT);

        $stmt -> execute();
    }
    
    static public function obtenerUsuario($nombre,$correo){
        # obtener id del usuario
        $stmt = Conexion::conectar()->prepare("SELECT * FROM usuario WHERE nombre_completo = :nombre and correo = :correo");
        $stmt->bindParam(":nombre", $nombre, PDO::PARAM_STR);
        $stmt->bindParam(":correo", $correo, PDO::PARAM_STR);
        $stmt -> execute();
        return $stmt -> fetch(PDO::FETCH_OBJ);
    }
    
    public function agregarUsuario(){
        if(isset($_POST['nombre'])){
            
            # Ocupacion estudiante
            if($_POST['ocupacion'] == 'Estudiante'){
                $stmt = Conexion::conectar()->prepare("INSERT INTO usuario (nombre_completo,correo,sexo,edad,ocupacion,escuela,carrera,semestre) 
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
                $stmt = Conexion::conectar()->prepare("INSERT INTO usuario (nombre_completo,correo,sexo,edad,ocupacion,profesion) 
                VALUES (:nombre, :correo, :genero, :edad, :ocupacion,:profesion)");

                $stmt->bindParam(":nombre", $_POST["nombre"], PDO::PARAM_STR);
                $stmt->bindParam(":correo", $_POST["correo"], PDO::PARAM_STR);
                $stmt->bindParam(":genero", $_POST["genero"], PDO::PARAM_STR);
                $stmt->bindParam(":edad", $_POST["edad"], PDO::PARAM_INT);
                $stmt->bindParam(":ocupacion", $_POST["ocupacion"], PDO::PARAM_STR);
                $stmt->bindParam(":profesion", $_POST["profesion"], PDO::PARAM_STR);  
            }

            try{
                $stmt->execute();
                $result = $this -> obtenerUsuario($_POST['nombre'],$_POST['correo']);
                $_SESSION["id"] = $result -> id;
                
                echo '<script>
                        Swal.fire({
                            title: "Usuario registrado con éxito",
                            text: "Ahora serás redireccionado al juego",
                            icon: "success",
                            confirmButtonText: "OK"
                            }).then((result) => {
                            if (result.isConfirmed) {
                                window.location = "game.php";
                            }
                        }) 
                      </script>'; 
            }catch(Exception $e){
                echo '<script>
                        Swal.fire({
                            title: "Algo salió mal, usuario no registrado",
                            text: "Por favor, intentalo de nuevo",
                            icon: "error",
                            confirmButtonText: "OK"
                            }).then((result) => {
                            if (result.isConfirmed) {
                                window.location = "index.php";
                            }
                        }) 
                      </script>'; 
            }
        }  
    }

    public function agregarEncuesta() {
        if(isset($_POST['p1'])){

            $stmt = Conexion::conectar()->prepare("INSERT INTO encuesta (p1,p2,p3,p4,p5,p6,p7,p8,p9,p10,p11,p12,p13,p14,p15,p16,p17,id_usuario) 
            VALUES (:p1, :p2, :p3, :p4, :p5, :p6, :p7, :p8, :p9, :p10, :p11, :p12, :p13, :p14, :p15, :p16, :p17, :id");

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
            $stmt->bindParam(":id", $_SESSION['id'], PDO::PARAM_INT);

            try{
                $stmt->execute();
                echo '<script>
                        Swal.fire({
                            title: "Resultados guardados con éxito",
                            text: "Muchas gracias por participar en este experimento",
                            icon: "success",
                            confirmButtonText: "OK"
                            }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = "index.php"; //destruir sesión
                            }
                        }) 
                      </script>'; 
            }catch(Exception $e){
                echo '<script>
                        Swal.fire({
                            title: "Algo salió mal, respuesyas no registradas",
                            text: "Por favor, intentalo de nuevo",
                            icon: "error",
                            confirmButtonText: "OK"
                            }).then((result) => {
                            if (result.isConfirmed) {
                                window.location = "encuesta.php";
                            }
                        }) 
                      </script>'; 
            }
        }
    }
}