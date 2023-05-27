<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Inicio</title>

    <!-- Bootstrap v5.1.3 CDNs -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>

<body style="background: #f8fafc;">
    
        <div class="container mt-5" style="width: 40%;" id="contenedorForm">

            <div class="card-deck mb-3 mt-5">

                <div class="card mb-4 box-shadow">

                    <div class="card-header">
                        <h4 class="text-center">Registro</h4>
                    </div>
                    
                    <div class="card-body p-5">

                        <form class="needs-validation" method="post">

                            <ul class="list-unstyled mb-4" id="listaCampos">

                                <div class="form-group">
                                    <label class="form-label">Nombre completo</label>
                                    <input class="form-control" type="text" id="nombre" name="nombre" onkeyup="mayuscula(this)" required>
                                </div>

                                <div class="form-group mt-3">
                                    <label class="form-label" for="email">Correo electrónico</label>
                                    <input class="form-control" type="email" id="email" name="correo" onkeyup="minuscula(this)" required>
                                </div>

                                <div class="form-group mt-3">
                                    <label class="form-label">Sexo</label>
                                    <select class="form-select" id="genero" name="genero" required>
                                        <option selected></option>
                                        <option value="F">FEMENINO</option>
                                        <option value="M">MASCULINO</option>
                                        <option value="O">PREFIERO NO DECIRLO</option>
                                    </select>
                                </div>

                                <div class="form-group mt-3">
                                    <label class="form-label">Edad</label>
                                    <input class="form-control" type="number" min="1" max="99" id="edad" name="edad" required>
                                </div>

                                <div class="form-group mt-3">
                                    <label class="form-label">Ocupación</label>
                                    <select class="form-select" id="ocupacion" onchange="f_profesion()" name="ocupacion" required>
                                        <option selected></option>
                                        <option value="ESTUDIANTE">ESTUDIANTE</option>
                                        <option value="PROFESIONISTA">PROFESIONISTA</option>
                                    </select>
                                </div>

                            </ul>

                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault" required>
                                <p>
                                    Estoy de acuerdo con el
                                    <a href="#" onclick="alert_aviso()">aviso de privacidad</a>
                                </p>
                            </div>

                            <input class="btn btn-primary w-100 mt-3" type="submit" id="btnRegistro" value="Registrarse">
                        
                            <?php
                                include 'php/usuarios.php';
                                $usuario = new Usuario();
                                $usuario -> agregarUsuario();
                            ?>  
                        
                        </form>

                    </div>
                
                </div>
            
            </div>
                
        </div>

        <script>
            function alert_aviso() {
                var text = "¡Muchas gracias por haber aceptado participar en este estudio!<br>Tu tarea consistirá en jugar dos juegos de mesa junto con otra(s) persona(s). La duración de la sesión dependerá del tiempo en el que ustedes realicen la tarea.<br>El objetivo de este estudio es obtener información sobre la forma en la que la gente se enfrenta al cambio. No buscamos evaluar inteligencia o memoria. Durante la sesión se te conectara un sensor que tomará tu pulso cardio. Se jugaron dos juegos de mesas que tendrán una duración de 30 minutos cada uno, durante el experimento se te grabará para conocer tus reacciones. Te informamos que ninguna de las actividades que realizarás implica algún riesgo o alguna molestia física o psicológica a corto o largo plazo. Sin embargo, si en algún momento deseas terminar tu participación en la tarea podrás hacerlo informando al encargado, esto sin ninguna consecuencia para ti.<br>En caso de ser necesario, los datos que proporciones serán confidenciales y se utilizarán para fines investigativos exclusivamente.<br>Finalmente, al aceptar participar en este estudio, te comprometes a no divulgar información sobre las tareas utilizadas y los procedimientos realizados porque ello podría afectar el desempeño de otros estudiantes que decidan participar con nosotros.";

                Swal.fire({
                title: 'Aviso de privacidad',
                type: 'info',
                html:
                    '<p align="justify">'+text+'</p>'
                })
            }

            function f_profesion() {
                let profesion = document.getElementById("ocupacion").value;
                console.log(profesion)
                let eliminar = document.getElementsByClassName("opcionales");
                let padre_div = document.getElementById("listaCampos");

                while(eliminar.length > 0){
                    eliminar[0].parentNode.removeChild(eliminar[0]);
                }

                if (profesion == 'ESTUDIANTE') {
                    var div_escuela = document.createElement("div");
                    div_escuela.classList.add("form-group");
                    div_escuela.classList.add("mt-3");
                    div_escuela.classList.add("opcionales");

                    var label_escuela = document.createElement("label");
                    label_escuela.classList.add("form-label");
                    label_escuela.classList.add("opcionales");
                    label_escuela.innerHTML = "Nombre del centro universitario o escuela";

                    var input_escuela = document.createElement("input");
                    input_escuela.classList.add("form-control");
                    input_escuela.classList.add("opcionales");
                    input_escuela.type = "text";
                    input_escuela.placeholder = "Escribe su abreviatura";
                    input_escuela.required = true;
                    input_escuela.name = "escuela";
                    input_escuela.onkeyup = function() {mayuscula(input_escuela)};

                    var div_carrera = document.createElement("div");
                    div_carrera.classList.add("form-group");
                    div_carrera.classList.add("mt-3");
                    div_carrera.classList.add("opcionales");

                    var label_carrera = document.createElement("label");
                    label_carrera.classList.add("form-label");
                    label_carrera.classList.add("opcionales");
                    label_carrera.innerHTML = "Nombre de la carrera";

                    var input_carrera = document.createElement("input");
                    input_carrera.classList.add("form-control");
                    input_carrera.classList.add("opcionales");
                    input_carrera.type = "text";
                    input_carrera.placeholder = "Escribe su nombre completo";
                    input_carrera.required = true;
                    input_carrera.name = "carrera";
                    input_carrera.onkeyup = function() {mayuscula(input_carrera)};

                    var div_semestre = document.createElement("div");
                    div_semestre.classList.add("form-group");
                    div_semestre.classList.add("mt-3");
                    div_semestre.classList.add("opcionales");
                    div_semestre.id = "semestre";

                    var label_semestre = document.createElement("label");
                    label_semestre.classList.add("form-label");
                    label_semestre.classList.add("opcionales");
                    label_semestre.innerHTML = "Semestre";

                    var input_semestre = document.createElement("input");
                    input_semestre.classList.add("form-control");
                    input_semestre.classList.add("opcionales");
                    input_semestre.type = "number";
                    input_semestre.min = "1";
                    input_semestre.max = "20";
                    input_semestre.required = true;
                    input_semestre.name = "semestre";

                    div_escuela.appendChild(label_escuela);
                    div_escuela.appendChild(input_escuela);
                    
                    div_carrera.appendChild(label_carrera);
                    div_carrera.appendChild(input_carrera);

                    div_semestre.appendChild(label_semestre);
                    div_semestre.appendChild(input_semestre);

                    padre_div.appendChild(div_escuela);
                    padre_div.appendChild(div_carrera);
                    padre_div.appendChild(div_semestre);
                }
                
                if (profesion == 'PROFESIONISTA') {
                    var div_profesion = document.createElement("div");
                    div_profesion.classList.add("form-group");
                    div_profesion.classList.add("mt-3");
                    div_profesion.classList.add("opcionales");

                    var label_profesion = document.createElement("label");
                    label_profesion.classList.add("form-label");
                    label_profesion.classList.add("opcionales");
                    label_profesion.innerHTML = "Nombre de la profesión";

                    var input_profesion = document.createElement("input");
                    input_profesion.classList.add("form-control");
                    input_profesion.classList.add("opcionales");
                    input_profesion.type = "text";
                    input_profesion.required = true;
                    input_profesion.name = "profesion";
                    input_profesion.onkeyup = function() {mayuscula(input_profesion)};

                    div_profesion.appendChild(label_profesion);
                    div_profesion.appendChild(input_profesion);

                    padre_div.appendChild(div_profesion);
                }
            }

            function mayuscula(input){
                input.value = input.value.toUpperCase();
            }

            function minuscula(input){
                input.value = input.value.toLowerCase();
            }

        </script>

</body>

</html>