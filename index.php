<?php
    include 'php/usuarios.php';  
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ERC</title>

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

    <!-- Sweet Alert 2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>
<body>
    <?php
        if (isset($_GET["ruta"])){
            if ($_GET["ruta"] == 'game')
                include 'modulos/game.php';
            
            if ($_GET["ruta"] == 'encuesta')
                include 'modulos/encuesta.php';
        }else{
            include 'modulos/registro.php';
        }
    ?>
</body>
</html>