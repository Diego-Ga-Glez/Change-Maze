<?php
  include 'menu.php';
?>

<div class="container" style="background:#ffffff; padding:0; width:90%;">
  <div class="card-deck mb-5 mt-5">

    <div class="card mb-2 box-shadow">

      <div class="card-header">
        <h6 class="text-center">Jugadores con registro incompleto</h6>
      </div>

      <div class="card-body">

        <table class="display compact cell-border dt-responsive mb-2 tablas" width="100%">

          <thead>
            <tr>
              <th style="width:10px">#</th>
              <th>Nombre</th>
              <th>Correo</th>
              <th>Sexo</th>
              <th>Edad</th>
              <th>Ocupación</th>
              <th>Acciones</th>
            </tr>
          </thead>

          <tbody>
            <?php
            $jugador = new Jugador();
            $jugadores = $jugador -> jugadoresIncompletos();
            
            foreach($jugadores as $key => $value) {
              echo '<tr>
                      <td>'.($key+1).'</td>
                      <td>'.$value["nombre_completo"].'</td>
                      <td>'.$value["correo"].'</td>
                      <td>'.$value["sexo"].'</td>
                      <td>'.$value["edad"].'</td>
                      <td>'.$value["ocupacion"].'</td>
                      <td>
                        <div class="btn-group">
                          <button type="button" class="btn btn-danger btnEliminarJugador" idJugador="'.$value["id"].'">
                            <i class="bi bi-trash text-light"></i>
                          </button>
                        </div>
                      </td>
                    </tr>';
            }
            ?>

          </tbody>

        </table>
        </div>
</div>
</div>
</div>

<script>

$(document).on("click", ".btnEliminarJugador", function(){

  var idJugador = $(this).attr("idJugador");

  swal.fire({
      title:"¿Está seguro de borrar el jugador?",
      text: "Esta acción es irreversible",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6", 
      cancelButtonColor: "#d33",
      confirmButtonText: "Borrar",
      cancelButtonText: "Cancelar"
  }).then((result)=>{
      if(result.value){
        window.location = "jugadores?idJugador="+idJugador;
      }
  })
})

var rol = '<?php echo $_SESSION['rol'];?>' ;
if(rol == "Usuario"){
  const btns = document.getElementsByClassName('btnEliminarJugador')
  for(const btn of btns)
    btn.style.visibility = 'hidden';
}

</script>

<?php
  $jugador = new Jugador();
  $jugador -> eliminarJugador();
?>