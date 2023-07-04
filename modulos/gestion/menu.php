<?php
    if(!isset($_SESSION["usuario"],$_SESSION["rol"]))
        echo '<script> window.location = "login" </script>';
?> 

<nav class="navbar navbar-expand-lg navbar-light shadow-sm" style="background-color: #ffffff;">
  <div class="container-fluid">
    
    <a class="navbar-brand" href="inicio" style="margin-left: 1em;">Inicio</a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNavDropdown">

        <ul class="navbar-nav me-auto mb-2 mb-lg-0" style="margin-right: 1em;">
            <li class="nav-item dropdown">

                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Jugadores
                </a>

                <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                    <li><a class="dropdown-item" href="completos">Registros completos</a></li>
                    <li><a class="dropdown-item" href="incompletos">Registros incompletos</a></li>
                </ul>

            </li>

            <?php
                if($_SESSION["rol"] == "Administrador")
                echo '<li class="nav-item">
                        <a class="nav-link" href="usuarios">Usuarios</a>
                      </li>'
            ?>
        </ul>

        <ul class="navbar-nav" style="margin-right: 1em;">

            <li class="nav-item dropdown">

                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <?php echo $_SESSION["usuario"] ?>
                </a>

                <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                    <li><a class="dropdown-item" href="salir">Cerrar sesión</a></li>
                </ul>

            </li>

        </ul>

    </div>

  </div>
</nav>