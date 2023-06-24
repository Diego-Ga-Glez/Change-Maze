<?php
  include 'menu.php';
?>

<div class="container mt-5">

    <div class="card-deck mb-5 mt-5">

        <div class="card mb-4 box-shadow">

            <div class="card-header">
                <h6 class="text-center">Perfil ERC</h6>
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
                <canvas id="pieChart" height="400"></canvas>
              </div>

            </div>
        
        </div>
    
    </div>
        
</div>

<style>
.chart-container {
    width: 60%;
    height: 60%;
    margin: auto;
  }
</style>

<script>

  var lineCanvas = document.getElementById("lineChart");

  var lineData = {
    labels: ["Búsqueda de rutina", "Reacción emocional", "Enfoque a corto plazo", "Rigidez cognitiva"],
    datasets: [{
      label: 'Resultados de una muestra de N = 49710',
      data: [2.36, 2.97, 2.42, 3.09],
      lineTension: 0,
      fill: false,
      borderColor: 'orange',
      backgroundColor: 'transparent',
      pointBorderColor: 'orange',
      pointBackgroundColor: 'rgba(255,150,0,0.5)',
      //borderDash: [5, 5], Linea punteada
      pointRadius: 10,
      pointHoverRadius: 10,
      pointHitRadius: 30,
      pointBorderWidth: 2,
      pointStyle: 'rectRounded'
    },
    {
      label: 'Puntuación ERC media de la muestra = 2.59',
      data: [2.59, 2.59, 2.59, 2.59],
      lineTension: 0,
      fill: false,
      borderColor: 'blue',
      backgroundColor: 'transparent',
      pointBorderColor: 'transparent'
    }]
  };

  var lineOptions = {
    legend: {
      display: true,
      position: 'top',
      labels: {
        fontColor: 'black'
      }
    },
    scales: {
      xAxes: [{
        gridLines: {
          display: false,
          color: "black"
        }
      }],
      yAxes: [{
        gridLines: {
          color: "black",
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
  

  var barCanvas = document.getElementById("barChart");

  var yesData = {
    label: 'Sí cambiar el juego',
    data: [8, 10, 5, 2, 16],
    backgroundColor: 'blue'
  };
  
  var noData = {
    label: 'No cambiar el juego',
    data: [16, 8, 9, 3, 12],
    backgroundColor: 'red'
  };
  
  var barData = {
    labels: ["Excelente", "Bueno", "Regular", "Malo", "Pésimo"],
    datasets: [yesData, noData]
  };
  
  var barOptions = {
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
            max: 20,
            stepSize: 2
        }
      }]
    }
  };
  
  var barChart = new Chart(barCanvas, {
    type: 'bar',
    data: barData,
    options: barOptions
  });


  var pieCanvas = document.getElementById("pieChart");

  var pieData = {
      labels: [
          "Estudiantes",
          "Profesionistas"
      ],
      datasets: [
      {
        data: [45, 26],
        backgroundColor: [
            "#FF6384",
            "#63FF84"
        ]
      }]
  };

  var pieChart = new Chart(pieCanvas, {
    type: 'pie',
    data: pieData
  });

</script>