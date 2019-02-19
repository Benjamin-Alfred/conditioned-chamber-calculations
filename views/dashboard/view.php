    <div class="container-fluid">
        <div class="row justify-content-center">
            <main role="main" class="col-md-11 px-1">
                <div class="pt-4 pb-2 border-bottom">
                    <h1 class="h2 d-none">COE</h1>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <form method="POST" action="<?php echo $pageURL;?>" class="col">
                            <div class="form-row">
                                <div class="col">
                                    <label for="chart_type">Chart Type:</label>
                                </div>
                                <div class="col">
                                    <select class="form-control form-control-sm" name="chart_type" id="chart_type">
                                        <option value="bar" <?php echo strcmp($chartType, 'bar')==0?"selected":""; ?>>Bar</option>
                                        <option value="line" <?php echo strcmp($chartType, 'line')==0?"selected":""; ?>>Line</option>
                                    </select>
                                </div>
                                <div class="col">
                                    <label for="start_date">Start Date:</label>
                                </div>
                                <div class="col">
                                    <input type="date" class="form-control form-control-sm" name="start_date" value="<?php echo $startDate; ?>">
                                </div>
                                <div class="col">
                                    <label for="end_date">End Date:</label>
                                </div>
                                <div class="col">
                                    <input type="date" class="form-control form-control-sm" name="end_date" value="<?php echo $endDate; ?>">
                                </div>
                                <div class="col-2">
                                    <select class="form-control form-control-sm" name="interval" id="interval">
                                        <option value="daily" <?php echo strcmp($interval, 'daily')==0?"selected":""; ?>>Daily</option>
                                        <option value="monthly" <?php echo strcmp($interval, 'monthly')==0?"selected":""; ?>>Monthly</option>
                                        <option value="yearly" <?php echo strcmp($interval, 'yearly')==0?"selected":""; ?>>Yearly</option>
                                    </select>
                                </div>
                                <div class="col">
                                    <input type="hidden" name="api_code" value="11" />
                                    <button type="submit" class="btn btn-sm btn-outline-secondary">
                                        <strong>Go</strong>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- Conditioned Chambers -->
                <div class="row">
                    <div class="col-md-6">
                        <canvas class="my-4 w-100" id="conditionedChamberChart" width="900" height="380"></canvas>
                    </div>
                    <div class="col-md-6">
                        <canvas class="my-4 w-100" id="thermometerChart" width="900" height="380"></canvas>
                    </div>
                </div>
                <!-- Conditioned Chambers -->

                <!-- Thermometers -->
                <div class="row">
                    <div class="col-md-6">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-sm">
                                <thead>
                                    <tr>
                                        <th>Interval</th>
                                        <th>Total</th>
                                        <th>Passed</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if(count($CCSummary) > 0){
                                        if(strlen($CCSummary['labels']) > 0){
                                            $labelString = str_replace("'", "", $CCSummary['labels']);
                                            $labels = explode(",", substr($labelString, 1, strlen($labelString) - 2));

                                            $totalString = str_replace("'", "", $CCSummary['totals']);
                                            $totals = explode(",", substr($totalString, 1, strlen($totalString) - 2));

                                            $passString = str_replace("'", "", $CCSummary['passed']);
                                            $passed = explode(",", substr($passString, 1, strlen($passString) - 2));

                                            for ($i = 0; $i < count($labels); $i++) {
                                    ?>
                                                <tr>
                                                    <td><?php echo $labels[$i]; ?></td>
                                                    <td><?php echo $totals[$i]; ?></td>
                                                    <td><?php echo $passed[$i]; ?></td>
                                                </tr>
                                    <?php
                                            }
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-sm">
                                <thead>
                                    <tr>
                                        <th>Interval</th>
                                        <th>Total</th>
                                        <th>Passed</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if(count($thermometerSummary) > 0){
                                        if(strlen($thermometerSummary['labels']) > 0){
                                            $labelString = str_replace("'", "", $thermometerSummary['labels']);
                                            $labels = explode(",", substr($labelString, 1, strlen($labelString) - 2));

                                            $totalString = str_replace("'", "", $thermometerSummary['totals']);
                                            $totals = explode(",", substr($totalString, 1, strlen($totalString) - 2));

                                            $passString = str_replace("'", "", $thermometerSummary['passed']);
                                            $passed = explode(",", substr($passString, 1, strlen($passString) - 2));

                                            for ($i = 0; $i < count($labels); $i++) {
                                    ?>
                                                <tr>
                                                    <td><?php echo $labels[$i]; ?></td>
                                                    <td><?php echo $totals[$i]; ?></td>
                                                    <td><?php echo $passed[$i]; ?></td>
                                                </tr>
                                    <?php
                                            }
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- /Thermometers -->

            </main>
        </div>
    </div>

    <script type="text/javaScript">
        /* globals Chart:false, feather:false */

(function () {
  'use strict'

  feather.replace()

  // Graphs
  var ctx = document.getElementById('conditionedChamberChart')
  var thermoChart = document.getElementById('thermometerChart')

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
        text: 'Conditioned Chambers Calibrated over time'},
      scales: {
        yAxes: [{
          ticks: {
            beginAtZero: true
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

  if(count($CCSummary) > 0){ 
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
        text: 'Thermometers Calibrated over time'},
      scales: {
        yAxes: [{
          ticks: {
            beginAtZero: true
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
