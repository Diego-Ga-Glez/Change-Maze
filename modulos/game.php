<script src="./js/index.js" type="module"></script>
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
</style>

<div id="game-container"></div>


<?php
  
  if(isset($_SESSION["id"]) and $_SESSION["game"]){
    $_SESSION["game"] = false;
  }
   

    
?>