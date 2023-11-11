<?php include 'php/jugador.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ChangeMaze</title>
    <link rel="icon" href="ChangeMaze/assets/spritesheets/icono.png" type="image">

    <!-- Agregar todos las bibliotecas necesitadas -->

    <!-- game.php -->
     <!-- jquery -->
    <script src="libs/js/jquery/jquery.min.js"></script>
    <script src="libs/js/phaser/dungeon.js"></script>
    <script src="libs/js/phaser/phaser.js"></script>
    <script src="libs/js/webfont/webfont.js"></script>

    <!-- registro.php -->
    <!-- Bootstrap v5.1.3 CDNs -->
    <link rel="stylesheet" href="libs/css/bootstrap/bootstrap.min.css"/>
    <script src="libs/js/bootstrap/bootstrap.bundle.min.js"></script>

    <!-- DataTables -->
    <link rel="stylesheet" href="libs/css/datatables/jquery.dataTables.css"/>
    <link rel="stylesheet" href="libs/css/datatables/responsive.bootstrap.min.css"/>
    <script src="libs/js/datatables/jquery.dataTables.js"></script>
    <script src="libs/js/datatables/dataTables.responsive.min.js"></script>
    <script src="libs/js/datatables/responsive.bootstrap.min.js"></script>

    <!-- Sweet Alert 2 -->
    <script src="libs/js/sweetalert2/sweetalert2.js"></script>

    <!-- w cluster -->
    <!-- https://www.npmjs.com/package/w-cluster -->
    <script src="libs/js/w-cluster/w-cluster.umd.js"></script>

    <!-- Chart.js -->
    <script src="libs/js/chartjs/chart.js"></script>

</head>
<body style="background: #f8fafc;">
    <?php
        if (isset($_GET["ruta"])){
            if ($_GET["ruta"] == 'game')
                include 'modulos/game.php';

            if ($_GET["ruta"] == 'puntajes')
                include 'modulos/puntajes.php';
        }else{
            include 'modulos/registro.php';
        }
    ?>
</body>
</html>