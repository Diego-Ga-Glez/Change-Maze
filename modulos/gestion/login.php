<?php
    if(isset($_SESSION['usuario'],$_SESSION['rol']))
        echo '<script> window.location = "inicio" </script>';
?> 

<style>
    /* Cuando la pantalla es menor a 900px  (tablets y teléfonos inteligentes)*/
    @media only screen and (max-width : 900px) {
        .container{
            width:90%;
        }
    }

    /* Cuando la pantalla es mayor a 900px */
    @media only screen and (min-width : 901px) {
        .container{
            width:40%;
        }
    }
</style>

<div class="container mt-5" id="contenedorForm">

    <div class="card-deck mb-5 mt-5">

        <div class="card mb-4 box-shadow">

            <div class="card-header">
                <h4 class="text-center">Iniciar Sesión</h4>
            </div>
            
            <div class="card-body p-5">

                <form class="needs-validation" method="post">

                    <ul class="list-unstyled mb-4" id="listaCampos">

                        <div class="form-group">
                            <label class="form-label" for="email">Correo electrónico</label>
                            <input class="form-control" type="email" id="email" name="correo" onkeyup="minuscula(this)" required>
                        </div>

                        <div class="form-group mt-3">
                            <label class="form-label" for="password">Contraseña</label>
                            <input class="form-control" type="password" id="password" name="password" required>
                        </div>

                    </ul>

                    <input class="btn btn-primary w-100 mt-3" type="submit" id="btnAdmin" value="Iniciar sesión">
                
                    <?php
                        $usuario = new Usuario();
                        $usuario -> validarUsuario();
                        
                    ?>  
                
                </form>

            </div>
        
        </div>
    
    </div>
        
</div>