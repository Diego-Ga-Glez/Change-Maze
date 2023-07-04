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

    .chart-container {
      width: 100%;
      height: 50vh;
      margin: auto;
    }
</style>

<?php
  include 'menu.php';

  $jugador = new Jugador();

  $estudiantes = $jugador -> contarJugadores('ESTUDIANTE') -> cantidad;
  $profesionistas = $jugador -> contarJugadores('PROFESIONISTA') -> cantidad;

  $medias = $jugador -> mediasERC();
  $media1 = round($medias -> media1,2);
  $media2 = round($medias -> media2,2);
  $media3 = round($medias -> media3,2);
  $media4 = round($medias -> media4,2);
  $media_total = round($medias -> mediaTotal,2);
  $cant_muestra = $medias -> cantidad;

  $excelente_no = $jugador -> seccionesJuego('excelente','no') -> cantidad;
  $excelente_si = $jugador -> seccionesJuego('excelente','si') -> cantidad;
  $bueno_no = $jugador -> seccionesJuego('bueno','no') -> cantidad;
  $bueno_si = $jugador -> seccionesJuego('bueno','si') -> cantidad;
  $regular_no = $jugador -> seccionesJuego('regular','no') -> cantidad;
  $regular_si = $jugador -> seccionesJuego('regular','si') -> cantidad;
  $malo_no = $jugador -> seccionesJuego('malo','no') -> cantidad;
  $malo_si = $jugador -> seccionesJuego('malo','si') -> cantidad;
  $pesimo_no = $jugador -> seccionesJuego('pesimo','no') -> cantidad;
  $pesimo_si = $jugador -> seccionesJuego('pesimo','si') -> cantidad;

  $entre16y20 = $jugador -> contarEdades(16,20) -> cantidad;
  $entre21y25 = $jugador -> contarEdades(21,25) -> cantidad;
  $entre26y30 = $jugador -> contarEdades(26,30) -> cantidad;
  $entre31y35 = $jugador -> contarEdades(31,35) -> cantidad;
  $entre36y40 = $jugador -> contarEdades(36,40) -> cantidad;
  $entre41y45 = $jugador -> contarEdades(41,45) -> cantidad;
  $mayorA45 = $jugador -> contarEdades(45,99) -> cantidad;
?>

<div class="container mt-5">

    <div class="card-deck mb-5 mt-5">

        <div class="card mb-4 box-shadow">

            <div class="card-header">
                <h6 class="text-center">Perfil de Resistencia al Cambio</h6>
            </div>
            
            <div class="card-body p-5">

              <div class="card chart-container">
                <canvas id="lineChart"></canvas>
              </div>

            </div>
        
        </div>
    
    </div>
        
</div>

<div class="container mt-5">

    <div class="card-deck mb-5 mt-5">

        <div class="card mb-4 box-shadow">

            <div class="card-header">
                <h6 class="text-center">Secciones del Juego</h6>
            </div>
            
            <div class="card-body p-5">

              <div class="card chart-container">
                <canvas id="barChart"></canvas>
              </div>

            </div>
        
        </div>
    
    </div>
        
</div>

<div class="container mt-5">

    <div class="card-deck mb-5 mt-5">

        <div class="card mb-4 box-shadow">

            <div class="card-header">
                <h6 class="text-center">Jugadores</h6>
            </div>
            
            <div class="card-body p-5">

              <div class="card chart-container">
                <canvas id="pieChart"></canvas>
              </div>

            </div>
        
        </div>
    
    </div>
        
</div>

<div class="container mt-5 mb-5">

    <div class="card-deck mb-5 mt-5">

        <div class="card mb-4 box-shadow">

            <div class="card-header">
                <h6 class="text-center">Edades</h6>
            </div>
            
            <div class="card-body p-5">

              <div class="card chart-container">
                <canvas id="horizontalBarChart"></canvas>
              </div>

            </div>
        
        </div>
    
    </div>
        
</div>


<script>
  // Gráfica de líneas
  var lineCanvas = document.getElementById("lineChart");

  var lineData = {
    labels: ["Búsqueda de rutina", "Reacción emocional", "Enfoque a corto plazo", "Rigidez cognitiva"],
    datasets: [{
      label: 'Resultados de una muestra de N = <?php echo $cant_muestra ?>',
      data: [<?php echo $media1 ?>, <?php echo $media2 ?>, <?php echo $media3 ?>, <?php echo $media4 ?>],
      lineTension: 0,
      fill: false,
      borderColor: 'orange',
      backgroundColor: 'transparent',
      pointBorderColor: 'orange',
      pointBackgroundColor: 'rgba(255,150,0,0.5)',
      pointRadius: 10,
      pointHoverRadius: 10,
      pointHitRadius: 30,
      pointBorderWidth: 2,
      pointStyle: 'rectRounded'
    },
    {
      label: 'Puntuación ERC media de la muestra = <?php echo $media_total ?>',
      data: [<?php echo $media_total ?>, <?php echo $media_total ?>, <?php echo $media_total ?>, <?php echo $media_total ?>],
      lineTension: 0,
      fill: false,
      borderColor: 'blue',
      backgroundColor: 'transparent',
      pointBorderColor: 'transparent'
    }]
  };

  var lineOptions = {
    responsive: true,
    maintainAspectRatio: false,
    scales: {
      xAxes: [{
        gridLines: {
          display: false,
          color: "grey"
        }
      }],
      yAxes: [{
        gridLines: {
          color: "grey",
          borderDash: [2, 5],
        },
        scaleLabel: {
          display: true,
          labelString: "Resistencia",
          fontColor: "grey"
        },
        ticks: {
          min: 0,
          max: 6,
          stepSize: 1
        }
      }]
    }
  };

  var lineChart = new Chart(lineCanvas, {
    type: 'line',
    data: lineData,
    options: lineOptions
  });
  
  // Gráfica de barras
  var barCanvas = document.getElementById("barChart");

  var yesData = {
    label: 'Sí cambiar el juego',
    data: [<?php echo $excelente_si ?>, <?php echo $bueno_si ?>, <?php echo $regular_si ?>, <?php echo $malo_si ?>, <?php echo $pesimo_si ?>],
    backgroundColor: '#3D55F3'
  };
  
  var noData = {
    label: 'No cambiar el juego',
    data: [<?php echo $excelente_no ?>, <?php echo $bueno_no ?>, <?php echo $regular_no ?>, <?php echo $malo_no ?>, <?php echo $pesimo_no ?>],
    backgroundColor: '#EE313F'
  };
  
  var barData = {
    labels: ["Excelente", "Bueno", "Regular", "Malo", "Pésimo"],
    datasets: [yesData, noData]
  };
  
  var barOptions = {
    responsive: true,
    maintainAspectRatio: false,
    scales: {
      xAxes: [{
        scaleLabel: {
          display: true,
          labelString: "Calificación",
          fontColor: "grey"
        },
        barPercentage: 1,
        categoryPercentage: 0.6
      }],
      yAxes: [{
        scaleLabel: {
          display: true,
          labelString: "Secciones",
          fontColor: "grey"
        },
        ticks: {
            min: 0,
            max: <?php echo max($excelente_si, $excelente_no, $bueno_si, $bueno_no, $regular_si, $regular_no, $malo_si, $malo_no, $pesimo_si, $pesimo_no) ?>,
            callback: function(value) {if (value % 1 === 0) {return value;}}
        }
      }]
    }
  };
  
  var barChart = new Chart(barCanvas, {
    type: 'bar',
    data: barData,
    options: barOptions
  });

  // Gráfica de pastel
  var pieCanvas = document.getElementById("pieChart");

  var pieData = {
      labels: [
          "Estudiantes",
          "Profesionistas"
      ],
      datasets: [
      {
        data: [<?php echo $estudiantes ?>, <?php echo $profesionistas ?>],
        backgroundColor: [
            "#FF6384",
            "#3DEBF3"
        ]
      }]
  };

  var pieOptions = {
    responsive: true,
    maintainAspectRatio: false,
  };

  var pieChart = new Chart(pieCanvas, {
    type: 'pie',
    data: pieData,
    options: pieOptions
  });

  //Gráfica de barras horizontal
  var horizontalBarCanvas = document.getElementById("horizontalBarChart");

  var ageData = {
    label: 'Jugadores',
    data: [<?php echo $mayorA45 ?>, <?php echo $entre41y45 ?>, <?php echo $entre36y40 ?>, <?php echo $entre31y35 ?>, <?php echo $entre26y30 ?>, <?php echo $entre21y25?>, <?php echo $entre16y20 ?>],
    backgroundColor: '#037CA4'
  };

  var horizontalBarData = {
    labels: ["Mayor a 45", "Entre 41 y 45", "Entre 36 y 40", "Entre 31 y 35", "Entre 26 y 30", "Entre 21 y 25", "Entre 16 y 20"],
    datasets: [ageData]
  };

  var horizontalBarOptions = {
    responsive: true,
    maintainAspectRatio: false,
    scales: {
      xAxes: [{
        scaleLabel: {
          display: true,
          labelString: "Número de jugadores",
          fontColor: "grey"
        },
        ticks: {
            min: 0,
            max: <?php echo max($mayorA45, $entre41y45, $entre36y40, $entre31y35, $entre26y30, $entre21y25, $entre16y20) ?>,
            callback: function(value) {if (value % 1 === 0) {return value;}}
        }
      }],
      yAxes: [{
        scaleLabel: {
          display: true,
          labelString: "Rangos de edad (años)",
          fontColor: "grey"
        },
        barPercentage: 1
      }]
    }
  };

  var horizontalBarChart = new Chart(horizontalBarCanvas, {
    type: 'horizontalBar',
    data: horizontalBarData,
    options: horizontalBarOptions
  });

</script>