<?php
  include 'menu.php';
?>

<div class="container" style="background:#ffffff; padding:0; width:90%;">
  <div class="card-deck mb-5 mt-5">

    <div class="card mb-2 box-shadow">

      <div class="card-header">
        <h6 class="text-center">Todos los usuarios</h6>
      </div>

      <div class="card-body">

        <table class="display compact cell-border dt-responsive mb-2 tablas" width="100%">

          <thead>
            <tr>
              <th style="width:10px">#</th>
              <th>Usuario</th>
              <th>Correo</th>
              <th>Privilegio</th>
              <th>Ultimo Login</th>
              <th>Acciones</th>
            </tr>
          </thead>

          <tbody>
            <?php
            $usuarios = new Usuario();
            $usuarios = $usuarios -> mostrarUsuarios();
            
            foreach($usuarios as $key => $value) {
              echo '<tr>
                      <td>'.($key+1).'</td>
                      <td>'.$value["usuario"].'</td>
                      <td>'.$value["correo"].'</td>
                      <td>'.$value["privilegios"].'</td>
                      <td>'.$value["ultimo_login"].'</td>
                      <td>
                        <div class="btn-group">
                          <button type="button" class="btn btn-danger btnEliminarUsuario" correoUsuario="'.$value["correo"].'">
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
})

$(document).on("click", ".btnEliminarUsuario", function(){

  var correoUsuario = $(this).attr("correoUsuario");

  swal.fire({
      title:"¿Está seguro de borrar el usuario?",
      text: "Esta acción es irreversible",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6", 
      cancelButtonColor: "#d33",
      confirmButtonText: "Borrar",
      cancelButtonText: "Cancelar"
  }).then((result)=>{
      if(result.value){
        window.location = "usuarios?correoUsuario="+correoUsuario;
      }
  })
})

</script>

<?php
  $usuarios = new Usuario();
  $usuarios -> eliminarUsuario();
?>  