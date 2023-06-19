<?php

require_once "conexion.php";

class Usuario{
    public function mostrarUsuario(){
        if(isset($_POST['correo'])){
            try{
                $stmt = Conexion::conectar()->prepare("SELECT * FROM usuario WHERE correo = :correo and pass = :pass");
                $stmt->bindParam(":correo",$_POST['correo'], PDO::PARAM_STR);
                $stmt->bindParam(":pass", $_POST['password'], PDO::PARAM_STR);
                $stmt -> execute();
                $respuesta = $stmt -> fetch();

                if(is_array($respuesta)){

                    if($respuesta["correo"] == $_POST["correo"] &&
                    $respuesta["pass"] == $_POST['password']){

                        $_SESSION["usuario"] = $respuesta["usuario"];
                        $_SESSION["privilegios"] = $respuesta["privilegios"];
                        echo '<script> window.location = "gestion" </script>';
                    }

                }else{
                    echo '<script>
                    Swal.fire({
                        title: "Algo salió mal",
                        text: "Contraseña o correo incorrecto",
                        icon: "error",
                        confirmButtonText: "OK"
                        }).then((result) => {
                            window.location = "admin";
                    }) 
                  </script>';      
                }
            }catch(Exception $e){ } 
        }
        
    }

}