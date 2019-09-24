<script type="text/javaScript">
/* globals Chart:false, feather:false */

(function () {
  'use strict'

  // jQuery('.show-data').hide();
  jQuery('#showChartData').click(function(event){
    jQuery('.show-data').toggle();
  })

  feather.replace()

  // Graphs
  var ctx = document.getElementById('conditionedChamberChart')
  var thermoChart = document.getElementById('thermometerChart')
  var cfChart = document.getElementById('centrifugeChart')
  var tChart = document.getElementById('timerChart')
  var pChart = document.getElementById('pipetteChart')
  var ptatChart = document.getElementById('pipetteTATChart')

  // eslint-disable-next-line no-unused-vars
  <?php if(count($CCSummary) > 0){ ?>
  var conditionedChamberChart = new Chart(ctx, {
    type: '<?php echo $chartType;?>',
    data: {
      labels: <?php echo $CCSummary['labels'];?>,
      datasets: [{
        label: 'Total',
        data: <?php echo $CCSummary['totals'];?>,
        lineTension: 0,
        backgroundColor: '<?php echo strcmp($chartType, "bar")==0?"#007bff":"transparent";?>',
        borderColor: '#007bff',
        borderWidth: 4,
        pointBackgroundColor: '#007bff'
      },
      {
        label: 'Passed',
        data: <?php echo $CCSummary['passed'];?>,
        lineTension: 0,
        backgroundColor: '<?php echo strcmp($chartType, "bar")==0?"#ff7b7b":"transparent";?>',
        borderColor: '#ff7b7b',
        borderWidth: 4,
        pointBackgroundColor: '#ff7b7b'
      }]
    },
    options: {
      title: {
        display: true,
        fontSize: 18,
        text: 'Conditioned Chambers Calibrated over time'},
      scales: {
        yAxes: [{
          ticks: {
            beginAtZero: true,
            precision: 0
          },
          scaleLabel: {
            display: true,
            labelString: 'Conditioned Chamber Count'
          }
        }],
        xAxes: [{
          scaleLabel: {
            display: true,
            labelString: 'Interval'
          }
        }]

      },
      legend: {
        display: true,
        position: 'bottom'
      }
    }
  });

<?php 

  } 

    if(count($centrifugeSummary) > 0){ ?>
    var centrifugeChart = new Chart(cfChart, {
    type: '<?php echo $chartType;?>',
    data: {
      labels: <?php echo $centrifugeSummary['labels'];?>,
      datasets: [{
        label: 'Total',
        data: <?php echo $centrifugeSummary['totals'];?>,
        lineTension: 0,
        backgroundColor: '<?php echo strcmp($chartType, "bar")==0?"#007bff":"transparent";?>',
        borderColor: '#007bff',
        borderWidth: 4,
        pointBackgroundColor: '#007bff'
      },
      {
        label: 'Passed',
        data: <?php echo $centrifugeSummary['passed'];?>,
        lineTension: 0,
        backgroundColor: '<?php echo strcmp($chartType, "bar")==0?"#ff7b7b":"transparent";?>',
        borderColor: '#ff7b7b',
        borderWidth: 4,
        pointBackgroundColor: '#ff7b7b'
      }]
    },
    options: {
      title: {
        display: true,
        fontSize: 18,
        text: 'Centrifuges Calibrated over time'},
      scales: {
        yAxes: [{
          ticks: {
            beginAtZero: true,
            precision: 0
          },
          scaleLabel: {
            display: true,
            labelString: 'Centrifuge Count'
          }
        }],
        xAxes: [{
          scaleLabel: {
            display: true,
            labelString: 'Interval'
          }
        }]

      },
      legend: {
        display: true,
        position: 'bottom'
      }
    }
  });

<?php 

  } 

    if(count($timerSummary) > 0){ ?>
    var timerChart = new Chart(tChart, {
    type: '<?php echo $chartType;?>',
    data: {
      labels: <?php echo $timerSummary['labels'];?>,
      datasets: [{
        label: 'Total',
        data: <?php echo $timerSummary['totals'];?>,
        lineTension: 0,
        backgroundColor: '<?php echo strcmp($chartType, "bar")==0?"#007bff":"transparent";?>',
        borderColor: '#007bff',
        borderWidth: 4,
        pointBackgroundColor: '#007bff'
      },
      {
        label: 'Passed',
        data: <?php echo $timerSummary['passed'];?>,
        lineTension: 0,
        backgroundColor: '<?php echo strcmp($chartType, "bar")==0?"#ff7b7b":"transparent";?>',
        borderColor: '#ff7b7b',
        borderWidth: 4,
        pointBackgroundColor: '#ff7b7b'
      }]
    },
    options: {
      title: {
        display: true,
        fontSize: 18,
        text: 'Timers Calibrated over time'},
      scales: {
        yAxes: [{
          ticks: {
            beginAtZero: true,
            precision: 0
          },
          scaleLabel: {
            display: true,
            labelString: 'Timer Count'
          }
        }],
        xAxes: [{
          scaleLabel: {
            display: true,
            labelString: 'Interval'
          }
        }]

      },
      legend: {
        display: true,
        position: 'bottom'
      }
    }
  });

<?php 

  } 

  if(count($pipetteSummary) > 0){ ?>
    var pipetteChart = new Chart(pChart, {
    type: '<?php echo $chartType;?>',
    data: {
      labels: <?php echo $pipetteSummary['labels'];?>,
      datasets: [{
        label: 'Total',
        data: <?php echo $pipetteSummary['totals'];?>,
        lineTension: 0,
        backgroundColor: '<?php echo strcmp($chartType, "bar")==0?"#007bff":"transparent";?>',
        borderColor: '#007bff',
        borderWidth: 4,
        pointBackgroundColor: '#007bff'
      },
      {
        label: 'Passed',
        data: <?php echo $pipetteSummary['passed'];?>,
        lineTension: 0,
        backgroundColor: '<?php echo strcmp($chartType, "bar")==0?"#ff7b7b":"transparent";?>',
        borderColor: '#ff7b7b',
        borderWidth: 4,
        pointBackgroundColor: '#ff7b7b'
      }]
    },
    options: {
      title: {
        display: true,
        fontSize: 18,
        text: 'Pipettes Calibrated over time'},
      scales: {
        yAxes: [{
          ticks: {
            beginAtZero: true,
            precision: 0
          },
          scaleLabel: {
            display: true,
            labelString: 'Pipette Count'
          }
        }],
        xAxes: [{
          scaleLabel: {
            display: true,
            labelString: 'Interval'
          }
        }]

      },
      legend: {
        display: true,
        position: 'bottom'
      }
    }
  });

<?php 

  } 

  if(count($pipetteTAT) > 0){ ?>
    var pipetteTATChart = new Chart(ptatChart, {
    type: '<?php echo $chartType;?>',
    data: {
      labels: <?php echo $pipetteTAT['labels'];?>,
      datasets: [{
        label: 'Complete',
        data: <?php echo $pipetteTAT['completed'];?>,
        lineTension: 0,
        backgroundColor: '<?php echo strcmp($chartType, "bar")==0?"#007bff":"transparent";?>',
        borderColor: '#007bff',
        borderWidth: 4,
        pointBackgroundColor: '#007bff'
      },
      {
        label: 'Review',
        data: <?php echo $pipetteTAT['reviewed'];?>,
        lineTension: 0,
        backgroundColor: '<?php echo strcmp($chartType, "bar")==0?"#ff7b7b":"transparent";?>',
        borderColor: '#ff7b7b',
        borderWidth: 4,
        pointBackgroundColor: '#ff7b7b'
      }]
    },
    options: {
      title: {
        display: true,
        fontSize: 18,
        text: 'Pipettes Calibration Average TAT'},
      scales: {
        yAxes: [{
          ticks: {
            beginAtZero: true,
            precision: 0
          },
          scaleLabel: {
            display: true,
            labelString: 'Average TAT (days)'
          }
        }],
        xAxes: [{
          scaleLabel: {
            display: true,
            labelString: 'Interval'
          }
        }]

      },
      legend: {
        display: true,
        position: 'bottom'
      }
    }
  });

<?php 

  } 

  if(count($thermometerSummary) > 0){ 
?>
  var thermometerChart = new Chart(thermoChart, {
    type: '<?php echo $chartType;?>',
    data: {
      labels: <?php echo $thermometerSummary['labels'];?>,
      datasets: [{
        label: 'Total',
        data: <?php echo $thermometerSummary['totals'];?>,
        lineTension: 0,
        backgroundColor: '<?php echo strcmp($chartType, "bar")==0?"#007bff":"transparent";?>',
        borderColor: '#007bff',
        borderWidth: 4,
        pointBackgroundColor: '#007bff'
      },
      {
        label: 'Passed',
        data: <?php echo $thermometerSummary['passed'];?>,
        lineTension: 0,
        backgroundColor: '<?php echo strcmp($chartType, "bar")==0?"#ff7b7b":"transparent";?>',
        borderColor: '#ff7b7b',
        borderWidth: 4,
        pointBackgroundColor: '#ff7b7b'
      }]
    },
    options: {
      title: {
        display: true,
        fontSize: 18,
        text: 'Thermometers Calibrated over time'},
      scales: {
        yAxes: [{
          ticks: {
            beginAtZero: true,
            precision: 0
          },
          scaleLabel: {
            display: true,
            labelString: 'Thermometer Count'
          }
        }],
        xAxes: [{
          scaleLabel: {
            display: true,
            labelString: 'Interval'
          }
        }]

      },
      legend: {
        display: true,
        position: 'bottom'
      }
    }
  })
}())
<?php } ?>
</script>
