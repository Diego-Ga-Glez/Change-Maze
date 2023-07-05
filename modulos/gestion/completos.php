<?php
  include 'menu.php';
?>

<div class="container" style="background:#ffffff; padding:0; width:90%;">
  <div class="card-deck mb-5 mt-5">

    <div class="card mb-2 box-shadow">

      <div class="card-header">
        <h6 class="text-center">Jugadores con registro completo</h6>
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
            $jugadores = $jugador -> jugadoresCompletos();
            
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
                          <button type="button" class="btn btn-primary btnInfoJugador" title="Mostrar información" data-bs-toggle="modal" data-bs-target="#modalInfoJugador" idInfoJugador="'.$value["id"].'">
                            <i class="bi bi-file-text text-light"></i>
                          </button>
                          <button type="button" class="btn btn-danger btnEliminarJugador" title="Eliminar" idJugador="'.$value["id"].'">
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

<!-- Modal mostrar información del usuario -->
<div class="modal fade" id="modalInfoJugador" role="dialog" tabindex="-1">
  <div class="modal-dialog dialog-lg"> 
    <div class="modal-content">

      <div class="modal-header card-header">
        <h5 class="modal-title">Información</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body">
        <div>
          <h6 class="text-center">Secciones jugadas</h6>
        </div>

        <div class="table-responsive">
          <table class="table table-bordered text-center" id="table_modal_secciones">
            <thead>
              <tr>
                <th>Numero de respuesta</th>
                <th>Calificacion del juego</th>
                <th>Cambiar de juego</th>
              </tr>
            </thead>

            <tbody>
            </tbody>
          </table>
        </div>

        <div>
          <h6 class="text-center">Resultados de la encuesta ERC</h6>
        </div>

        <div class="table-responsive">
          <table class="table table-bordered text-center" id="table_modal_erc">
            <thead>
              <tr>
                <th>Búsqueda de rutina</th>
                <th>Reacción emocional</th>
                <th>Enfoque a corto plazo</th>
                <th>Rigidez cognitiva</th>
                <th>Puntaje total</th>
              </tr>
            </thead>

            <tbody>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
$(document).ready(function () {

var rol = '<?php echo $_SESSION['rol'];?>' ;
if(rol == "Usuario"){
  const btns = document.getElementsByClassName('btnEliminarJugador')
  for(const btn of btns)
    btn.style.visibility = 'hidden';
}

document.getElementById("DataTables_Table_0_length").classList.add("mb-3");
document.getElementById("DataTables_Table_0_filter").classList.add("mb-3");
  
})

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
        window.location = "completos?idJugador="+idJugador;
      }
  })
})

$(document).on("click", ".btnInfoJugador", function(){
  var idInfoJugador = $(this).attr("idInfoJugador");
  var datos = new FormData();
  datos.append("idInfoJugador", idInfoJugador);

  $.ajax({
        url:"./ajax/jugadores.ajax.php",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function(respuesta){
          const table_sec = document.getElementById('table_modal_secciones');
          for (var i = table_sec.rows.length - 1; i > 0; i--)
            table_sec.deleteRow(i);

          
          let rows = 1;
          for(let registro of respuesta){
            let row = table_sec.insertRow(rows++);
            row.insertCell(0).innerHTML = Number(registro["num_respuesta"]) + 1;
            row.insertCell(1).innerHTML = registro["calificacion_juego"];
            row.insertCell(2).innerHTML = registro["cambiar_juego"];
          }

          const table_erc = document.getElementById('table_modal_erc');
          if(table_erc.rows.length > 1)
            table_erc.deleteRow(1);

          let row = table_erc.insertRow(1);
          row.insertCell(0).innerHTML = Number(respuesta[0]["busqueda_rutina"]).toFixed(2);
          row.insertCell(1).innerHTML = Number(respuesta[0]["reaccion_emocional"]).toFixed(2);
          row.insertCell(2).innerHTML = Number(respuesta[0]["enfoque_corto_plazo"]).toFixed(2);
          row.insertCell(3).innerHTML = Number(respuesta[0]["rigidez_cognitiva"]).toFixed(2);
          row.insertCell(4).innerHTML = Number(respuesta[0]["puntaje_total"]).toFixed(2);  
        }
    });
})

</script>

<?php
  $jugador = new Jugador();
  $jugador -> eliminarJugador("completos");
?>  