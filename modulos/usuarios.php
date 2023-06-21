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
              <th>Rol</th>
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
                      <td>'.$value["rol"].'</td>
                      <td>'.$value["ultimo_login"].'</td>
                      <td>
                        <div class="btn-group">
                          <button type="button" class="btn btn-warning" idUsuario="'.$value["id"].'" data-bs-toggle="modal" data-bs-target="#modalEditarUsuario">
                            <i class="bi bi-pencil-fill text-light"></i>
                          </button>
                          <button type="button" class="btn btn-danger btnEliminarUsuario" idUsuario="'.$value["id"].'">
                            <i class="bi bi-trash text-light"></i>
                          </button>
                        </div>
                      </td>
                    </tr>';
            }
            ?>

          </tbody>

        </table>
        <button type="button" class="btn btn-primary mx-auto d-block mt-3">Agregar usuario</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal Modificar Usuario -->
<div class="modal fade" id="modalEditarUsuario" role="dialog" tabindex="-1">
  <div class="modal-dialog"> 
    <div class="modal-content">

      <div class="modal-header card-header">
        <h5 class="modal-title">Editar usuario</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body">
        <form role="form" method="post" enctype="multipart/form-data">

          <ul class="list-unstyled mb-4">
            <div class="form-group">
                <label class="form-label" for="email">Correo electrónico</label>
                <input class="form-control" type="email" id="email" name="correo" onkeyup="minuscula(this)">
            </div>

            <div class="form-group mt-2">
                <label class="form-label">Usuario</label>
                <input class="form-control" type="text" id="usuario" name="usuario">
            </div>

            <div class="form-group mt-2">
                <label class="form-label" for="password">Nueva contraseña</label>
                <input class="form-control" type="password" id="password" name="password">
            </div>

            <div class="form-group mt-2">
                <label class="form-label">Rol</label>
                <select class="form-select" id="rol" name="rol">
                    <option selected></option>
                    <option value="F">Administrador</option>
                    <option value="M">Usuario</option>
                </select>
            </div>
          </ul>
        </form>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary">Guardar</button>
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

    var idUsuario = $(this).attr("idUsuario");

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
          window.location = "usuarios?idUsuario="+idUsuario;
        }
    })
  })

  function minuscula(input){
        input.value = input.value.toLowerCase();
  }

</script>

<?php
  $usuarios = new Usuario();
  $usuarios -> eliminarUsuario();
?>  