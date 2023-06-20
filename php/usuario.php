<?php

require_once "conexion.php";

class Usuario{

    static public function modificarUltimoLogin($id){
        try{
            $stmt = Conexion::conectar()->prepare("UPDATE usuario SET ultimo_login = :ultimo_login WHERE id = :id");
            date_default_timezone_set('America/Mexico_City');
            $fecha = date('Y-m-d');
            $hora = date('H-i-s');
            $ultimo_login = $fecha." ".$hora;
            $stmt->bindParam(":ultimo_login", $ultimo_login, PDO::PARAM_STR);
            $stmt->bindParam(":id", $id, PDO::PARAM_STR);
            $stmt -> execute();
        }catch(Exception $e){

        }
    }
    
    static public function eliminarUsuario(){
        if(isset($_GET['idUsuario'])){
            try{
                $stmt = Conexion::conectar()->prepare("DELETE FROM usuario WHERE id = :id");
                $stmt->bindParam(":id", $_GET['idUsuario'], PDO::PARAM_STR);
                $stmt -> execute();

                echo '<script>
                        Swal.fire({
                            title: "Usuario eliminado con éxito",
                            icon: "success",
                            confirmButtonText: "OK"
                            }).then((result) => {window.location = "usuarios";}) 
                        </script>';

                
                # sacar al usuario si elimina su propio usuario
                if($_GET['idUsuario'] == $_SESSION["id"])
                    echo '<script> window.location = "salir"; </script>';      

            }catch(Exception $e){
                echo '<script>
                            Swal.fire({
                                title: "Algo salió mal, usuario no eliminado",
                                text: "Por favor, intentalo de nuevo",
                                icon: "error",
                                confirmButtonText: "OK"
                                }).then((result)=>{window.location = "usuarios";}) 
                          </script>';
            }
        }

    }
    
    static public function mostrarUsuarios() {
        try{
            $stmt = Conexion::conectar()->prepare("SELECT * FROM usuario");
            $stmt -> execute();
            return $stmt -> fetchAll();
        }catch(Exception $e){}     
    }
    
    public function validarUsuario(){
        if(isset($_POST['correo'])){
            try{
                $stmt = Conexion::conectar()->prepare("SELECT * FROM usuario WHERE correo = :correo and password = :password");
                $stmt->bindParam(":correo",$_POST['correo'], PDO::PARAM_STR);
                $stmt->bindParam(":password", $_POST['password'], PDO::PARAM_STR);
                $stmt -> execute();
                $respuesta = $stmt -> fetch();

                if(is_array($respuesta)){

                    if($respuesta["correo"] == $_POST["correo"] &&
                    $respuesta["password"] == $_POST['password']){

                        $_SESSION["usuario"] = $respuesta["usuario"];
                        $_SESSION["id"] = $respuesta["id"];
                        $_SESSION["rol"] = $respuesta["rol"];
                        Usuario::modificarUltimoLogin($_SESSION["id"]);
                        echo '<script> window.location = "gestion" </script>';
                    }

                }else{
                    echo '<script>
                    Swal.fire({
                        title: "Algo salió mal",
                        text: "Contraseña o correo incorrecto",
                        icon: "error",
                        confirmButtonText: "OK"
                        }).then((result) => {window.location = "admin";}) 
                  </script>';      
                }
            }catch(Exception $e){ } 
        }
        
    }

}