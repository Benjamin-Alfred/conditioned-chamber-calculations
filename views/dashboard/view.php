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
                            <div class="form-row">
                                <div class="form-check" style="font-size: 0.8rem;">
                                    <input class="form-check-input" type="checkbox" id="showChartData" >
                                    <label class="form-check-label" for="showChartData">Hide Chart Data</label>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- Conditioned Chambers and Thermometers Charts-->
                <div class="row">
                    <div class="col-md-6">
                        <canvas class="my-4 w-100" id="conditionedChamberChart" width="900" height="380"></canvas>
                    </div>
                    <div class="col-md-6">
                        <canvas class="my-4 w-100" id="thermometerChart" width="900" height="380"></canvas>
                    </div>
                </div>
                <!-- Conditioned Chambers and Thermometers Charts-->

                <div class="row show-data" style="font-size: 0.8rem;">
                    <!-- Conditioned Chambers -->
                    <div class="col-md-6">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-sm">
                                <thead>
                                    <tr>
                                        <th colspan="3"><center>Conditioned Chambers Data</center></th>
                                    </tr>
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
                    <!-- /Conditioned Chambers -->
                    <!-- Thermometers -->
                    <div class="col-md-6">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-sm">
                                <thead>
                                    <tr>
                                        <th colspan="3"><center>Thermometers Data</center></th>
                                    </tr>
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
                    <!-- /Thermometers -->
                </div>

                <!-- Centrifuges and Timers Charts -->
                <div class="row">
                    <div class="col-md-6">
                        <canvas class="my-4 w-100" id="centrifugeChart" width="900" height="380"></canvas>
                    </div>
                    <div class="col-md-6">
                        <canvas class="my-4 w-100" id="timerChart" width="900" height="380"></canvas>
                    </div>
                </div>
                <!-- /Centrifuges and Timers Charts -->

                <div class="row show-data" style="font-size: 0.8rem;">
                    <!-- Centrifuges data -->
                    <div class="col-md-6">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-sm">
                                <thead>
                                    <tr>
                                        <th colspan="3"><center>Centrifuges Data</center></th>
                                    </tr>
                                    <tr>
                                        <th>Interval</th>
                                        <th>Total</th>
                                        <th>Passed</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if(count($centrifugeSummary) > 0){
                                        if(strlen($centrifugeSummary['labels']) > 0){
                                            $labelString = str_replace("'", "", $centrifugeSummary['labels']);
                                            $labels = explode(",", substr($labelString, 1, strlen($labelString) - 2));

                                            $totalString = str_replace("'", "", $centrifugeSummary['totals']);
                                            $totals = explode(",", substr($totalString, 1, strlen($totalString) - 2));

                                            $passString = str_replace("'", "", $centrifugeSummary['passed']);
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
                    <!-- /Centrifuges data -->
                    <!-- Timers data -->
                    <div class="col-md-6">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-sm">
                                <thead>
                                    <tr>
                                        <th colspan="3"><center>Timers Data</center></th>
                                    </tr>
                                    <tr>
                                        <th>Interval</th>
                                        <th>Total</th>
                                        <th>Passed</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if(count($timerSummary) > 0){
                                        if(strlen($timerSummary['labels']) > 0){
                                            $labelString = str_replace("'", "", $timerSummary['labels']);
                                            $labels = explode(",", substr($labelString, 1, strlen($labelString) - 2));

                                            $totalString = str_replace("'", "", $timerSummary['totals']);
                                            $totals = explode(",", substr($totalString, 1, strlen($totalString) - 2));

                                            $passString = str_replace("'", "", $timerSummary['passed']);
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
                    <!-- /Timers data -->
                </div>

                <!-- Pipette Charts -->
                <div class="row">
                    <div class="col-md-6">
                        <canvas class="my-4 w-100" id="pipetteChart" width="900" height="380"></canvas>
                    </div>
                    <div class="col-md-6">
                        <canvas class="my-4 w-100" id="pipetteTATChart" width="900" height="380"></canvas>
                    </div>
                </div>
                <!-- /Pipette Charts -->

                <div class="row show-data" style="font-size: 0.8rem;">
                    <!-- Pipette data -->
                    <div class="col-md-6">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-sm">
                                <thead>
                                    <tr>
                                        <th colspan="3"><center>Pipette Data</center></th>
                                    </tr>
                                    <tr>
                                        <th>Interval</th>
                                        <th>Total</th>
                                        <th>Passed</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if(count($pipetteSummary) > 0){
                                        if(strlen($pipetteSummary['labels']) > 0){
                                            $labelString = str_replace("'", "", $pipetteSummary['labels']);
                                            $labels = explode(",", substr($labelString, 1, strlen($labelString) - 2));

                                            $totalString = str_replace("'", "", $pipetteSummary['totals']);
                                            $totals = explode(",", substr($totalString, 1, strlen($totalString) - 2));

                                            $passString = str_replace("'", "", $pipetteSummary['passed']);
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
                    <!-- /Pipette data -->
                    <!-- Pipette TAT data -->
                    <div class="col-md-6">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-sm">
                                <thead>
                                    <tr>
                                        <th colspan="3"><center>Pipette TAT Data (days)</center></th>
                                    </tr>
                                    <tr>
                                        <th>Interval</th>
                                        <th>Time to complete</th>
                                        <th>Time to review</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if(count($pipetteTAT) > 0){
                                        if(strlen($pipetteTAT['labels']) > 0){
                                            $labelString = str_replace("'", "", $pipetteTAT['labels']);
                                            $labels = explode(",", substr($labelString, 1, strlen($labelString) - 2));

                                            $completedString = str_replace("'", "", $pipetteTAT['completed']);
                                            $completed = explode(",", substr($completedString, 1, strlen($completedString) - 2));

                                            $reviewedString = str_replace("'", "", $pipetteTAT['reviewed']);
                                            $reviewed = explode(",", substr($reviewedString, 1, strlen($reviewedString) - 2));

                                            for ($i = 0; $i < count($labels); $i++) {
                                    ?>
                                                <tr>
                                                    <td><?php echo $labels[$i]; ?></td>
                                                    <td><?php echo $completed[$i]; ?></td>
                                                    <td><?php echo $reviewed[$i]; ?></td>
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
                    <!-- /Pipette data -->
                </div>
            </main>
        </div>
    </div>

