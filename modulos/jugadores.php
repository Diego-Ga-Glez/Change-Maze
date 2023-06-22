<?php
  include 'menu.php';
?>

<div class="container" style="background:#ffffff; padding:0; width:90%;">
  <div class="card-deck mb-5 mt-5">

    <div class="card mb-2 box-shadow">

      <div class="card-header">
        <h6 class="text-center">Todos los jugadores</h6>
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
            $jugadores = $jugador -> mostrarJugadores();
            
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
$(document).ready(function () {
$('.tablas').DataTable({
    "language": {

        "sProcessing":     "Procesando...",
        "sLengthMenu":     "Mostrar _MENU_ registros",
        "sZeroRecords":    "No se encontraron resultados",
        "sEmptyTable":     "Ningún dato disponible en esta tabla",
        "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_",
        "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0",
        "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
        "sInfoPostFix":    "",
        "sSearch":         "Buscar:",
        "sUrl":            "",
        "sInfoThousands":  ",",
        "sLoadingRecords": "Cargando...",
        "oPaginate": {
        "sFirst":    "Primero",
        "sLast":     "Último",
        "sNext":     "Siguiente",
        "sPrevious": "Anterior"
        },
        "oAria": {
            "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
            "sSortDescending": ": Activar para ordenar la columna de manera descendente"
        }

    }
});

document.getElementById("DataTables_Table_0_length").classList.add("mb-3");
document.getElementById("DataTables_Table_0_filter").classList.add("mb-3");

var rol = '<?php echo $_SESSION['rol'];?>' ;
if(rol == "Usuario"){
  const btns = document.getElementsByClassName('btnEliminarJugador')
  for(const btn of btns)
    btn.style.visibility = 'hidden';
}
  
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
        window.location = "jugadores?idJugador="+idJugador;
      }
  })
})

</script>

<?php
  $jugador = new Jugador();
  $jugador -> eliminarJugador();
?>  