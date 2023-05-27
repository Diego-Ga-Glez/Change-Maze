<?php

require_once "conexion.php";

class Usuario{
    static public function agregarUsuario(){
        if(isset($_POST['nombre'])){
            
            # Ocupacion estudiante
            if($_POST['ocupacion'] == 'Estudiante'){
                $stmt = Conexion::conectar()->prepare("INSERT INTO usuario (nombre_completo,correo,sexo,edad,ocupacion,escuela,carrera,semestre) 
                VALUES (:nombre, :correo, :genero, :edad, :ocupacion,:escuela, :carrera, :semestre)");

                $stmt->bindParam(":nombre", $_POST['nombre'], PDO::PARAM_STR);
                $stmt->bindParam(":correo", $_POST['correo'], PDO::PARAM_STR);
                $stmt->bindParam(":genero", $_POST['genero'], PDO::PARAM_STR);
                $stmt->bindParam(":edad", $_POST['edad'], PDO::PARAM_INT);
                $stmt->bindParam(":ocupacion", $_POST['ocupacion'], PDO::PARAM_STR);
                $stmt->bindParam(":escuela", $_POST['escuela'], PDO::PARAM_STR);
                $stmt->bindParam(":carrera", $_POST['carrera'], PDO::PARAM_STR);
                $stmt->bindParam(":semestre", $_POST['semestre'], PDO::PARAM_INT);
             # Ocupacion profesionista
            }else{
                $stmt = Conexion::conectar()->prepare("INSERT INTO usuario (nombre_completo,correo,sexo,edad,ocupacion,profesion) 
                VALUES (:nombre, :correo, :genero, :edad, :ocupacion,:profesion)");

                $stmt->bindParam(":nombre", $_POST['nombre'], PDO::PARAM_STR);
                $stmt->bindParam(":correo", $_POST['correo'], PDO::PARAM_STR);
                $stmt->bindParam(":genero", $_POST['genero'], PDO::PARAM_STR);
                $stmt->bindParam(":edad", $_POST['edad'], PDO::PARAM_INT);
                $stmt->bindParam(":ocupacion", $_POST['ocupacion'], PDO::PARAM_STR);
                $stmt->bindParam(":profesion", $_POST['profesion'], PDO::PARAM_STR);  
            }

            if($stmt->execute())
                echo "<script> Swal.fire({
                               icon: 'success',
                               title: 'Ok',
                               showConfirmButton: true,
                               confirmButtonText: 'Cerrar')}
                      </script>"; 
            else
                echo "<script> Swal.fire({
                               icon: 'error',
                               title: 'Error',
                               showConfirmButton: true,
                               confirmButtonText: 'Cerrar')}
                      </script>"; 
        }
       
    }
}