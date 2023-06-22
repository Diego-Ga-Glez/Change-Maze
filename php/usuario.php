<?php

require_once "conexion.php";

class Usuario{
    static public function agregarUsuario(){
        try{
            if(isset($_POST['agregarUsuario'])){
                $stmt = Conexion::conectar()->prepare("INSERT INTO usuario(correo, usuario, password, rol) 
                                                       VALUES (:correo, :usuario,:password,:rol)");

                $stmt->bindParam(":correo", $_POST["agregarCorreo"], PDO::PARAM_STR);
                $stmt->bindParam(":usuario", $_POST["agregarUsuario"], PDO::PARAM_STR);
                $encriptar = crypt($_POST["agregarPassword"],'$2a$07$usesomesillystringforsalt$');
                $stmt->bindParam(":password", $encriptar, PDO::PARAM_STR);
                $stmt->bindParam(":rol", $_POST["agregarRol"], PDO::PARAM_STR);
                $stmt -> execute();

                echo '<script>
                        Swal.fire({
                        title: "Usuario agregado con exito",
                        icon: "success",
                        confirmButtonText: "OK"
                        }).then((result) => {window.location = "usuarios";}) 
                      </script>';
            }

        }catch(Exception $e){
            echo '<script>
                    Swal.fire({
                        title: "Algo salió mal, usuario no agregado",
                        text: "Por favor, intentalo de nuevo",
                        icon: "error",
                        confirmButtonText: "OK"
                        }).then((result)=>{window.location = "usuarios";}) 
                  </script>';
        }
    }
    
    static public function editarUsuario(){
        try{
            if(isset($_POST['editarUsuario'])){

                $stmt = Conexion::conectar()->prepare("UPDATE usuario SET correo = :correo,
                    usuario = :usuario, password = :password, rol = :rol WHERE id = :id");
            
                $stmt->bindParam(":correo", $_POST["editarCorreo"], PDO::PARAM_STR);
                $stmt->bindParam(":usuario", $_POST["editarUsuario"], PDO::PARAM_STR);
                if(isset($_POST["editarPassword"]))
                    $encriptar = crypt($_POST["editarPassword"],'$2a$07$usesomesillystringforsalt$');
                else
                    $encriptar =  $_POST["passwordActual"];        
                $stmt->bindParam(":password", $encriptar, PDO::PARAM_STR);
                $stmt->bindParam(":rol", $_POST["editarRol"], PDO::PARAM_STR);
                $stmt->bindParam(":id", $_POST["idActual"], PDO::PARAM_INT);
                $stmt -> execute();

                echo '<script>
                        Swal.fire({
                        title: "Usuario modificado con exito",
                        icon: "success",
                        confirmButtonText: "OK"
                        }).then((result) => {window.location = "usuarios";}) 
                      </script>';
            }
        }catch(Exception $e){
            echo '<script>
                    Swal.fire({
                        title: "Algo salió mal, usuario no modificado",
                        text: "Por favor, intentalo de nuevo",
                        icon: "error",
                        confirmButtonText: "OK"
                        }).then((result)=>{window.location = "usuarios";}) 
                  </script>';
        }
    }
    
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
    
    static public function mostrarUsuarios($id) {
        try{
            if($id == null){
                $stmt = Conexion::conectar()->prepare("SELECT * FROM usuario");
                $stmt -> execute();
                return $stmt -> fetchAll();
            }
            else{
                $stmt = Conexion::conectar()->prepare("SELECT * FROM usuario WHERE id = :id");
                $stmt->bindParam(":id",$id, PDO::PARAM_INT); 
                $stmt -> execute();
                return $stmt -> fetch();
            }    

        }catch(Exception $e){}     
    }
    
    public function validarUsuario(){
        if(isset($_POST['correo'])){
            try{
                $stmt = Conexion::conectar()->prepare("SELECT * FROM usuario WHERE correo = :correo");
                $stmt->bindParam(":correo",$_POST['correo'], PDO::PARAM_STR);
                $stmt -> execute();
                $respuesta = $stmt -> fetch();

                if(is_array($respuesta)){

                    $encriptar = crypt($_POST["password"],'$2a$07$usesomesillystringforsalt$');
                    if($respuesta["password"] ==  $encriptar){

                        $_SESSION["usuario"] = $respuesta["usuario"];
                        $_SESSION["id"] = $respuesta["id"];
                        $_SESSION["rol"] = $respuesta["rol"];
                        Usuario::modificarUltimoLogin($_SESSION["id"]);
                        echo '<script> window.location = "inicio" </script>';
                    }else{
                        echo '<script>
                                Swal.fire({
                                title: "Error al ingresar los datos",
                                icon: "error",
                                confirmButtonText: "OK"
                                }).then((result) => {window.location = "login";}) 
                              </script>';    
                    }

                }else{
                    echo '<script>
                    Swal.fire({
                        title: "Algo salió mal",
                        text: "Inténtelo de nuevo ",
                        icon: "error",
                        confirmButtonText: "OK"
                        }).then((result) => {window.location = "login";}) 
                  </script>';      
                }
            }catch(Exception $e){ } 
        }
        
    }
}