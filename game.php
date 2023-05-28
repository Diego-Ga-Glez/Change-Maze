<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>ERC Game</title>

    <style>
      html,
      body,
      #game-container {
        margin: 0;
        padding: 0;
      }

      #game-container {
        min-width: 100vw;
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
      }

      #game-container > canvas {
        border-radius: 5px;
      }
    </style>
  </head>

  <body style="background-color: #0d0711;">
    <div id="game-container"></div>

    <script src="https://cdn.jsdelivr.net/npm/@mikewesthad/dungeon@1.2.2"></script>
    <script src="https://cdn.jsdelivr.net/npm/phaser@3.55.2/dist/phaser.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="./js/index.js" type="module"></script>
  </body>
</html>


<?php
  
  if(!isset($_SESSION["id"])){
    echo '<script> window.location = "index.php" </script>';
  }{
    session_destroy();
  }
  
   
?>