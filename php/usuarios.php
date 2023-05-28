<?php

require_once "conexion.php";
session_start();

class Usuario{
    
    static public function agregarSeccionUsuario($num_resp,$score,$change,$id){
        $stmt = Conexion::conectar()->prepare("INSERT INTO seccion (num_respuesta,calificacion_juego,cambiar_juego,id_usuario)
        VALUES(:num_resp,:score, :change, :id)");

        $stmt->bindParam(":num_resp", $num_resp, PDO::PARAM_INT);
        $stmt->bindParam(":score", $score, PDO::PARAM_STR);
        $stmt->bindParam(":change", $change, PDO::PARAM_STR);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);

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
}