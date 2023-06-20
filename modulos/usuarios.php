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
                          <button type="button" class="btn btn-warning" idUsuario="'.$value["id"].'" data-toggle="modal" data-target="#modalEditarUsuario">
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
<div id="modalEditarUsuario" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <div class="modal-content">

      <form role="form" method="post" enctype="multipart/form-data">

        <!-- Header del formulario -->
        <div class="modal-header" style="background:#3c8dbc; color:white;">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Editar usuario</h4>
        </div>

        <!-- Body del formulario -->
        <div class="modal-body">

          <div class="box-body">

            <!-- Input de nombre -->
            <div class="form-group">
              <div class="input-group">   
                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                <input class="form-control input-lg" type="text" id="editarNombre" name="editarNombre" value=""> 
              </div>
            </div>

            <!-- Input Usuario -->
            <div class="form-group">
              <div class="input-group">   
                <span class="input-group-addon"><i class="fa fa-key"></i></span>
                <input class="form-control input-lg" type="text" id="editarUsuario" name="editarUsuario" value="" readonly> 
              </div>
            </div>

            <!-- Input contraseña -->
            <div class="form-group">
              <div class="input-group">   
                <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                <input class="form-control input-lg" type="password" name="editarPassword" placeholder="Ingrese la nueva contraseña"> 
                <input type="hidden" id="passwordActual" name="passwordActual">
              </div>
            </div>

            <!-- Input perfil -->
            <div class="form-group">
              <div class="input-group">   
                <span class="input-group-addon"><i class="fa fa-users"></i></span>
                <select name="editarPerfil" class="form-control input-lg">
                  <option value="" id="editarPerfil"></option>
                  <option value="Administrador">Administrador</option>
                  <option value="Especial">Especial</option>
                  <option value="Vendedor">Vendedor</option>
                </select>
              </div>
            </div>

            <!-- Input imagen -->
            <div class="form-group">
              <div class="panel ">Subir foto</div>
              <input type="file" class="foto" name="editarFoto">
              <p class="help-block">Peso maximo de 2 MB</p>
              <img src="vistas/img/usuarios/default/default-user.png" class="img-thumbnail previsualizar" width="100px">
              <input type="hidden" id="fotoActual" name="fotoActual">
            </div>

          </div>

        </div>

        <!-- Footer del formulario -->
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
          <button type="submit" class="btn btn-primary">Guardar</button>
        </div>

        <?php
          /*$editarUsuario = new ControladorUsuarios();
          $editarUsuario -> ctrEditarUsuario();*/
        ?>
      </form>

    </div>
    <!-- Modal-content-->

  </div>
  <!-- Modal-dialog-->
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

</script>

<?php
  $usuarios = new Usuario();
  $usuarios -> eliminarUsuario();
?>  