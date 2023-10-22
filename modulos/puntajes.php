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
                        $tr = '<tr style="background-color: #B1FFF0;">';
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
                    <h6 class="text-center">Su resultado</h6>
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

                    <!-- kmeans y PCA -->
                    <?php
                        $jugadores = new Jugador();
                        $campos = array("avg_calificacion_juego", "avg_cambiar_juego", 
                                        "avg_suerte", "avg_monedas_obtenidas");
                        $avg_jugadores = $jugadores -> avg_jugadores($campos);
                        
                        $campos = array("id_jugador");
                        $avg_id_jugadores =  $jugadores -> avg_jugadores($campos);
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
                        console.log(avg_jugadores);
                        WCluster(avg_jugadores).then(resultado => { 
                            console.log(resultado);
                        });
                       
                    </script>

                </div>

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