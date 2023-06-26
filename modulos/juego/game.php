<script src="./ChangeMaze/index.js" type="module"></script>
<style>
    html,
    body,
    #game-container {
      margin: 0;
      padding: 0;
    }

    #game-container {
      width: fit-content;
      height: fit-content;
      display: flex;
      align-items: center;
      justify-content: center;
    }
</style>

<div id="game-container"></div>


<?php
  
  if(isset($_SESSION["id"]) and $_SESSION["game"]){
    $_SESSION["game"] = false;
  }else{
    Jugador::eliminarUsuario();
    echo '<script> window.location = "index.php" </script>';
  }
    
?>