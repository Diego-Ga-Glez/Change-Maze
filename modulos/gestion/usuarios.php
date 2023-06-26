<?php
  if($_SESSION["rol"] == "Usuario")
    echo '<script> window.location = "inicio"; </script>';
    
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
              <th>Último Login</th>
              <th>Acciones</th>
            </tr>
          </thead>

          <tbody>
            <?php
            $usuarios = new Usuario();
            $usuarios = $usuarios -> mostrarUsuarios(null);
            
            foreach($usuarios as $key => $value) {
              echo '<tr>
                      <td>'.($key+1).'</td>
                      <td>'.$value["usuario"].'</td>
                      <td>'.$value["correo"].'</td>
                      <td>'.$value["rol"].'</td>
                      <td>'.$value["ultimo_login"].'</td>
                      <td>
                        <div class="btn-group">
                          <button type="button" class="btn btn-warning btnEditarUsuario" idUsuario="'.$value["id"].'" data-bs-toggle="modal" data-bs-target="#modalEditarUsuario">
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
        <button type="button" class="btn btn-primary mx-auto d-block mt-3" data-bs-toggle="modal" data-bs-target="#modalAgregarUsuario">Agregar usuario</button>
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
                <input class="form-control" type="email" id="editarCorreo" name="editarCorreo" onkeyup="minuscula(this)">
            </div>

            <div class="form-group mt-2">
                <label class="form-label">Usuario</label>
                <input class="form-control" type="text" id="editarUsuario" name="editarUsuario">
                <input type="hidden" id="idActual" name="idActual">
            </div>

            <div class="form-group mt-2">
                <label class="form-label" for="password">Nueva contraseña</label>
                <input class="form-control" type="password" id="editarPassword" name="editarPassword">
                <input type="hidden" id="passwordActual" name="passwordActual">
            </div>

            <div class="form-group mt-2">
                <label class="form-label">Rol</label>
                <select class="form-select" id="editarRol" name="editarRol">
                    <option selected></option>
                    <option value="Administrador">Administrador</option>
                    <option value="Usuario">Usuario</option>
                </select>
            </div>
          </ul>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <button type="submit" class="btn btn-primary">Guardar</button>
      </div>

      <?php
          $editarUsuario = new Usuario();
          $editarUsuario -> editarUsuario();
      ?>
      </form>
    </div>
  </div>
</div>

<!-- Modal Agregar Usuario -->
<div class="modal fade" id="modalAgregarUsuario" role="dialog" tabindex="-1">
  <div class="modal-dialog"> 
    <div class="modal-content">

      <div class="modal-header card-header">
        <h5 class="modal-title">Agregar usuario</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body">
        <form role="form" method="post" enctype="multipart/form-data">

          <ul class="list-unstyled mb-4">
            <div class="form-group">
                <label class="form-label" for="email">Correo electrónico</label>
                <input class="form-control" type="email" id="agregarCorreo" name="agregarCorreo" onkeyup="minuscula(this)" required>
            </div>

            <div class="form-group mt-2">
                <label class="form-label">Usuario</label>
                <input class="form-control" type="text" id="agregarUsuario" name="agregarUsuario" required>
            </div>

            <div class="form-group mt-2">
                <label class="form-label" for="password">Contraseña</label>
                <input class="form-control" type="password" id="agregarPassword" name="agregarPassword" required>
            </div>

            <div class="form-group mt-2">
                <label class="form-label">Rol</label>
                <select class="form-select" id="agregarRol" name="agregarRol" required>
                    <option selected></option>
                    <option value="Administrador">Administrador</option>
                    <option value="Usuario">Usuario</option>
                </select>
            </div>
          </ul>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <button type="submit" class="btn btn-primary">Guardar</button>
      </div>

      <?php
          $agregarUsuario = new Usuario();
          $agregarUsuario -> agregarUsuario();
      ?>
      </form>
    </div>
  </div>
</div>

<script>

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

  //Editar usuario
$(document).on("click", ".btnEditarUsuario", function(){
    var idUsuario = $(this).attr("idUsuario");
    var datos = new FormData();
    datos.append("idUsuario", idUsuario);

    $.ajax({
        url:"./ajax/usuarios.ajax.php",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function(respuesta){
            $("#editarUsuario").val(respuesta["usuario"]);
            $("#idActual").val(respuesta["id"]);
            $("#editarCorreo").val(respuesta["correo"]);
            $("#PasswordActual").val(respuesta["password"]);
            $("#editarRol").val(respuesta["rol"]);
        }
    });
})

</script>

<?php
  $usuarios = new Usuario();
  $usuarios -> eliminarUsuario();
?>  