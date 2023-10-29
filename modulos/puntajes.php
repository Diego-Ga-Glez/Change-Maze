<style>
    /* Cuando la pantalla es menor a 900px  (tablets y teléfonos inteligentes)*/
    @media only screen and (max-width : 900px) {
        .container{
            width:90%;
        }
    }

    /* Cuando la pantalla es mayor a 900px */
    @media only screen and (min-width : 901px) {
        .container{
            width:60%;
        }
    }
</style>

<div class="container mt-5" id="contenedorForm">

    <div class="card-deck mb-5 mt-5">

        <div class="card mb-4 box-shadow">

            <div class="card-header">
                <h4 class="text-center">Top 10 mejores jugadores</h4>
            </div>
            
            <div class="card-body">

            <table class="display compact cell-border dt-responsive mb-2 tablas" width="100%">

                <thead>
                    <tr>
                        <th style="width:10px">#</th>
                        <th>Jugador</th>
                        <th>Total de Monedas</th>
                        <th>Tiempo Total</th>
                    </tr>
                </thead>

                <tbody>
                <?php
                $jugadores = new Jugador();
                $jugadores = $jugadores -> topJugadores(1);
                
                foreach($jugadores as $key => $value) { //style="background-color: #7BFFBD;"
                    $segundos = $value["tiempo_total"];
                    $horas = floor($segundos/ 3600);
                    $minutos = floor(($segundos - ($horas * 3600)) / 60);
                    $segundos = $segundos - ($horas * 3600) - ($minutos * 60);
                    $tiempo = $horas . ':' . $minutos . ":" . $segundos;

                    if (isset($_SESSION["id"]) && ($value["id_jugador"] == $_SESSION["id"]))
                        $tr = '<tr style="background-color: #36EB8B80;">';
                    else
                        $tr = '<tr>';

                    echo $tr.'
                            <td>'.($key+1).'</td>
                            <td>'.$value["nombre_completo"].'</td>
                            <td>'.$value["monedas_total"].'</td>
                            <td>'.$tiempo.'</td>
                        </tr>';
                }
                ?>

                </tbody>

            </table>

            </div>
        
        </div>
    
    </div>
        
</div>

<?php if(isset($_SESSION["id"]) and isset($_SESSION["puntaje"])){ ?>

    <div class="container mt-5" id="contenedorForm">
        <div class="card-deck mb-5 mt-5">
            <div class="card mb-4 box-shadow">

                <div class="card-header">
                    <h6 class="text-center">Tu resultado del juego</h6>
                </div>
                
                <div class="card-body">
                    <table class="display compact cell-border dt-responsive mb-2 tablas" width="100%">

                        <thead>
                            <tr>
                                <th style="width:10px">#</th>
                                <th>Jugador</th>
                                <th>Total de Monedas</th>
                                <th>Tiempo Total</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                                $jugadores = new Jugador();
                                $jugadores = $jugadores -> topJugadores(0);

                                foreach($jugadores as $key => $value) {
                                    if ($value["id_jugador"] == $_SESSION["id"]) {
                                        $segundos = $value["tiempo_total"];
                                        $horas = floor($segundos/ 3600);
                                        $minutos = floor(($segundos - ($horas * 3600)) / 60);
                                        $segundos = $segundos - ($horas * 3600) - ($minutos * 60);
                                        $tiempo = $horas . ':' . $minutos . ":" . $segundos;

                                        echo '<tr>
                                                <td>'.($key+1).'</td>
                                                <td>'.$value["nombre_completo"].'</td>
                                                <td>'.$value["monedas_total"].'</td>
                                                <td>'.$tiempo.'</td>
                                            </tr>';
                                        
                                        break;
                                    }
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>     
    </div>

    <div class="container mt-5" id="contenedorForm">
        <div class="card-deck mb-5 mt-5">
            <div class="card mb-4 box-shadow">

                <div class="card-header">
                    <h6 class="text-center">Resultados de resistencia al cambio</h6>
                </div>

                <div class="card-body">
                    <canvas id="chart1"></canvas>
                </div>

                <?php
                    $jugadores = new Jugador();
                    $resultados_jugador = $jugadores -> resultados_jugador();

                    $busqueda_rutina = floatval($resultados_jugador -> busqueda_rutina); // mayor de 0.5 le gusta experimentar cosas nuevas
                    $reaccion_emocional = floatval($resultados_jugador -> reaccion_emocional); //mayor de 0.5 buena reacción
                    $enfoque_corto_plazo = floatval($resultados_jugador -> enfoque_corto_plazo); // mayor de 0.5 sí tiene enfoque a corto plazo
                    $rigidez_cognitiva = floatval($resultados_jugador -> rigidez_cognitiva); // mayor de 0.5 tiene rigidez cognitiva (no cambia de opinión)

                    $flexibilidad_cambio = ($busqueda_rutina + $reaccion_emocional + $enfoque_corto_plazo + (1 - $rigidez_cognitiva)) / 4; // Quizá la rigidez cognitiva da puntaje negativo porque entre mayor es, suele cambiar menos de opinión
                ?>

                <div class="card-body">
                    <div>
                        <h6 class="text-center">Perfil de resistencia al cambio</h6>
                        
                        <p align="justify" class="mb-0" style="padding: 0px 10px 10px 10px;">
                            <?php if ($flexibilidad_cambio > 0.5) { ?>
                                Tu enfoque general hacia el cambio tiende a ser positivo. Por lo general, te gustan los cambios y tiendes a buscarlos. Por lo tanto, es probable que tu rendimiento y bienestar mejoren cuando el entorno es dinámico y relativamente impredecible.
                            <?php } else { ?>
                                Tu inclinación general hacia el cambio es evitarlo o resistirlo. Realmente no te gustan los cambios y no te sientes cómodo en su presencia. Por lo tanto, es probable que tu rendimiento y bienestar mejoren cuando el entorno es estable y predecible.
                            <?php } ?>
                            <?php if ($busqueda_rutina > 0.5) { ?>
                                En cuanto a tu enfoque hacia las rutinas, te gusta experimentar cosas nuevas, generalmente disfrutas de las sorpresas y te aburres cada vez que se forma una rutina en tu vida.
                            <?php } else { ?>
                                En cuanto a tu enfoque hacia las rutinas, ganas comodidad y disfrutas haciendo las mismas cosas a la misma hora, no te gustan particularmente las sorpresas y te sientes incómodo cuando algo se interpone en tu rutina diaria.
                            <?php } ?>
                            <?php if ($reaccion_emocional > 0.5) { ?>
                                No tiendes a tener reacciones emocionales negativas a los cambios. No te hacen sentir particularmente incómodo y cuando ocurren mantienes la compostura.
                            <?php } else { ?>
                                Tu reacción emocional a los cambios es generalmente negativa. Los cambios a menudo te hacen sentir incómodo, nervioso e incluso estresado.
                            <?php } ?>
                            <?php if ($enfoque_corto_plazo > 0.5) { ?>
                                Tiendes a centrarte en las implicaciones del cambio a largo plazo. No te molestan demasiado los inconvenientes a corto plazo que a menudo implican los cambios y no permitirás que interfieran con tu toma de decisiones.
                            <?php } else { ?>
                                Te enfocas en los ajustes que los cambios a menudo requieren. Incluso cuando sabes que el cambio puede beneficiarte, no puedes evitar molestarte con los inconvenientes a corto plazo involucrados.
                            <?php } ?>
                            <?php if ($rigidez_cognitiva > 0.5) { ?>
                                Pareces ser muy estable y consistente en tus opiniones. Sabes en lo que crees y no es muy probable que cambies de opinión.
                            <?php } else { ?>
                                Pareces ser bastante flexible en tu forma de pensar. Por lo general, tienes la mente abierta y estás dispuesto a reconsiderar tus puntos de vista.
                            <?php } ?>
                        </p>
                    </div>
                </div>

                <!-- kmeans y PCA -->
                <?php
                    $jugadores = new Jugador();
                    $campos = array("busqueda_rutina", "reaccion_emocional", 
                                    "enfoque_corto_plazo", "rigidez_cognitiva");
                    $avg_jugadores = $jugadores -> avg_jugadores($campos);
                    
                    $campos = array("id_jugador");
                    $avg_id_jugadores =  $jugadores -> avg_jugadores($campos);
                    $id_jugador = $_SESSION["id"];
                ?>

                <script>
                    async function WCluster(avg_jugadores) {
                        let WCluster = window['w-cluster'];
                        let mode = 'k-medoids';
                        let resultado = await WCluster.cluster(avg_jugadores, { mode, kNumber: 2, nCompNIPALS: 2 })
                        return JSON.stringify(resultado, null, 2);
                    }

                    let avg_jugadores = <?php echo json_encode($avg_jugadores); ?>;
                    let avg_id_jugadores = <?php echo json_encode($avg_id_jugadores); ?>;
                    let id_jugador = <?php echo $id_jugador ?>;
                    var avg_float = [];
                    var tmp = [];

                    console.log(avg_jugadores);

                    for (let i = 0; i < avg_jugadores.length; i++) {
                        for (let j = 0; j < 4; j++)
                            tmp.push(parseFloat(avg_jugadores[i][j]));

                        avg_float.push(tmp);
                        tmp = [];
                    }

                    WCluster(avg_float).then(resultado => { 
                        var res = JSON.parse(resultado);
                        console.log(res);
                        var datasets = [[],[],[]]; //[[grupo1],[grupo2],[jugador actual]]
                        var indice_jugador = 0;
                        var posicion_final = [0,0]; //[grupo, posición en el grupo] del jugador actual

                        // encontrar indice del jugador en la lista de ids
                        for (let i = 0; i < avg_id_jugadores.length; i++) {
                            if (avg_id_jugadores[i] == id_jugador) {
                                indice_jugador = i;
                                break;
                            }
                        }

                        //encontrar posición de resultado del jugador
                        var encontrado = false;
                        for (let i = 0; i < res["ginds"].length; i++) {
                            for (let j = 0; j < res["ginds"][i].length; j++) {
                                if (res["ginds"][i][j] == indice_jugador) {
                                    posicion_final = [i,j];
                                    encontrado = true;
                                    break;
                                }
                            }
                            if (encontrado)
                                break;
                        }

                        //Guardar datos de los grupos (y del jugador actual) en datasets
                        for (let i = 0; i < res["gmat"].length; i++) {
                            for (let j = 0; j < res["gmat"][i].length; j++) {
                                if (posicion_final[0] == i && posicion_final[1] == j)
                                    datasets[2].push({ x: res["gmat"][i][j][0], y: res["gmat"][i][j][1] });
                                else 
                                    datasets[i].push({ x: res["gmat"][i][j][0], y: res["gmat"][i][j][1] });
                            }
                        }

                        var flexibilidad_cambio = <?php echo $flexibilidad_cambio; ?>;
                        var label1 = '';
                        var label2 = '';

                        if(posicion_final[0] == 0) { // Jugador pertenece a Grupo 1
                            if (parseFloat(flexibilidad_cambio > 0.5)) {
                                label1 = 'No resistentes';
                                label2 = 'Resistentes';
                            } else {
                                label1 = 'Resistentes';
                                label2 = 'No resistentes';
                            }
                        }
                        else if(posicion_final[0] == 1) { // Jugador pertenece a Grupo 2
                            if (parseFloat(flexibilidad_cambio > 0.5)) {
                                label1 = 'Resistentes';
                                label2 = 'No resistentes';
                            } else {
                                label1 = 'No resistentes';
                                label2 = 'Resistentes';
                            }
                        }

                        var ctx = document.getElementById("chart1").getContext("2d");
                        var myScatter = Chart.Scatter(ctx, {
                        data: {
                            datasets: [{
                                label: label1,
                                borderColor: '#FF6384',
                                backgroundColor: '#FF638480',
                                data: datasets[0]
                            }, {
                                label: label2,
                                borderColor: '#36A2EB',
                                backgroundColor: '#36A2EB80',
                                data: datasets[1]
                            }, {
                                label: "Jugador actual",
                                borderColor: '#36EB8B',
                                backgroundColor: '#36EB8B80',
                                data: datasets[2]
                            }
                        ]
                        },
                        options: {
                            title: {
                                display: true,
                                text: 'Total de muestras'
                            },
                            showLines: false,
                            /*scales: {
                                yAxes: [{
                                    ticks: {
                                        min: 28,
                                        max: 40,
                                    }
                                }],
                            },*/
                            elements: {
                                point: {
                                    radius: 5
                                }
                            }
                        }
                        });
                        
                    });
                    
                </script>

            </div>
        </div>     
    </div>


<?php } ?>

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

        document.getElementById("DataTables_Table_0_length").style.display = 'none';
        document.getElementById("DataTables_Table_0_filter").style.display = 'none';
        document.getElementById("DataTables_Table_0_info").style.display = 'none';
        document.getElementById("DataTables_Table_0_paginate").style.display = 'none';

        const i = '<?php echo isset($_SESSION['id'])? 1:0; ?>' ;
        if(parseInt(i)){
            document.getElementById("DataTables_Table_1_length").style.display = 'none';
            document.getElementById("DataTables_Table_1_filter").style.display = 'none';
            document.getElementById("DataTables_Table_1_info").style.display = 'none';
            document.getElementById("DataTables_Table_1_paginate").style.display = 'none';
        }
    })

</script>