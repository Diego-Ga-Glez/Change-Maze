<?php
    include 'php/jugador.php';  
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ChangeMaze</title>

    <!-- Agregar todos las bibliotecas necesitadas -->

    <!-- game.php -->
     <!-- jquery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@mikewesthad/dungeon@1.2.2"></script>
    <script src="https://cdn.jsdelivr.net/npm/phaser@3.55.2/dist/phaser.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.26/webfont.js"></script>

    <!-- registro.php y encuesta.php -->
    <!-- Bootstrap v5.1.3 CDNs -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.css"/>
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.bootstrap.min.css"/>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.4.1/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.4.1/js/responsive.bootstrap.min.js"></script>

    <!-- Bootstrap icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css"/>

    <!-- Sweet Alert 2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>
<body style="background: #f8fafc;">
    <?php
        if (isset($_GET["ruta"])){
            if ($_GET["ruta"] == 'game')
                include 'modulos/game.php';
            
            if ($_GET["ruta"] == 'encuesta')
                include 'modulos/encuesta.php';
                
            if ($_GET["ruta"] == 'admin')
                include 'modulos/admin.php';
            
            if ($_GET["ruta"] == 'gestion')
                include 'modulos/gestion.php';

            if ($_GET["ruta"] == 'jugadores')
                include 'modulos/jugadores.php';
            
            if ($_GET["ruta"] == 'incompletos')
                include 'modulos/incompletos.php';
        }else{
            include 'modulos/registro.php';
        }
    ?>
</body>
</html>