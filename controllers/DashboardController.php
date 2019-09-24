<?php
/*
 * Dashboard Controller
 *---------------------------------
 * Dashboard Page Values
 * 0 => View
 */
$COEPageURI['dashboard'][0] = "views/dashboard/view.php";

$pageURL = get_site_url().'/dashboard/';

$COEPage = 0; 

$pageHeader = "COE Dashboard";
$interval = "monthly";
$startDate = (new DateTime("now", new DateTimeZone("Africa/Nairobi")))->sub(new DateInterval("P1M"))->format('Y-m-d');
$endDate = (new DateTime("now", new DateTimeZone("Africa/Nairobi")))->add(new DateInterval("P1D"))->format('Y-m-d');
$chartType = "bar";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $formInterval = cleanFormInput($_POST["interval"]);
    if(strcmp($formInterval, "")!=0){
        $interval = $formInterval;
        $startDate = cleanFormInput($_POST["start_date"], "DATE");
        $endDate = cleanFormInput($_POST["end_date"], "DATE");
        $chartType = cleanFormInput($_POST["chart_type"]);
    }
}

$CCSummary = getCCSummary($interval, $startDate, $endDate);
$thermometerSummary = getThermometerSummary($interval, $startDate, $endDate);
$centrifugeSummary = getCentrifugeSummary($interval, $startDate, $endDate);
$timerSummary = getTimerSummary($interval, $startDate, $endDate);
$pipetteSummary = getPipetteSummary($interval, $startDate, $endDate);
$pipetteTAT = getPipetteTAT($interval, $startDate, $endDate);

function getCCSummary($interval="monthly", $startDate, $endDate, $maximumDataPoints = 15){

    global $wpdb;

    log2File("$interval, $startDate, $endDate");
    $intervalRange = [];
    $firstDate = new DateTime($startDate);
    $lastDate = new DateTime($endDate);
    $dataPoints = 0;

    $labels = "";
    $totals = "";
    $passed = "";
    $failed = "";
    $pending = "";

    $dateFormats = ['daily' => "Y-m-d", 'monthly' => "Y-m", 'yearly' => "Y"];
    $dateIntervalFormats = ['daily' => "P1D", 'monthly' => "P1M", 'yearly' => "P1Y"];
    $whereClause = [
        'daily' => "substring(date_performed, 1, 10)", 
        'monthly' => "substring(date_performed, 1, 7)", 
        'yearly' => "substring(date_performed, 1, 4)"
        ];

    while ( $firstDate <= $lastDate && $dataPoints < $maximumDataPoints) {
    
        $query = "SELECT count(*) total, count(IF(result='PASSED',1,NULL)) passed, count(IF(result='FAILED',1,NULL)) " .
                "failed, count(IF(result='PENDING',1,NULL)) pending FROM wp_coe_conditioned_chamber_calculations WHERE " .
                "{$whereClause[$interval]} = '".$firstDate->format($dateFormats[$interval])."'";

        log2File($query);

        $result = $wpdb->get_row($query, ARRAY_A);

        if(count($result) > 0){
            $labels .=  ",'".$firstDate->format($dateFormats[$interval])."'";
            $totals .=  ",'".$result['total']."'";
            $passed .=  ",'".$result['passed']."'";
            $failed .=  ",'".$result['failed']."'";
            $pending .=  ",'".$result['pending']."'";
        }
        
        $firstDate->add(new DateInterval($dateIntervalFormats[$interval]));
        $dataPoints++;
    }

    $labels = "[".substr($labels, 1)."]";
    $totals = "[".substr($totals, 1)."]";
    $passed = "[".substr($passed, 1)."]";
    $failed = "[".substr($failed, 1)."]";
    $pending = "[".substr($pending, 1)."]";

    $CCSummary = ['labels' => $labels, 'totals' => $totals, 'passed' => $passed, 'failed' => $failed, 'pending' => $pending];
    log2File(json_encode($CCSummary));

    return $CCSummary;
}

function getThermometerSummary($interval="monthly", $startDate, $endDate, $maximumDataPoints = 15){

    global $wpdb;

    log2File("$interval, $startDate, $endDate");
    $intervalRange = [];
    $firstDate = new DateTime($startDate);
    $lastDate = new DateTime($endDate);
    $dataPoints = 0;

    $labels = "";
    $totals = "";
    $passed = "";
    $failed = "";
    $pending = "";

    $dateFormats = ['daily' => "Y-m-d", 'monthly' => "Y-m", 'yearly' => "Y"];
    $dateIntervalFormats = ['daily' => "P1D", 'monthly' => "P1M", 'yearly' => "P1Y"];
    $whereClause = [
        'daily' => "substring(date_performed, 1, 10)", 
        'monthly' => "substring(date_performed, 1, 7)", 
        'yearly' => "substring(date_performed, 1, 4)"
        ];

    while ( $firstDate <= $lastDate && $dataPoints < $maximumDataPoints) {
    
        $query = "SELECT count(*) total, count(IF(result='PASSED',1,NULL)) passed, count(IF(result='FAILED',1,NULL)) " .
                "failed, count(IF(result='PENDING',1,NULL)) pending FROM wp_coe_thermometer_calculations WHERE " .
                "{$whereClause[$interval]} = '".$firstDate->format($dateFormats[$interval])."'";

        log2File($query);

        $result = $wpdb->get_row($query, ARRAY_A);

        if(count($result) > 0){
            $labels .=  ",'".$firstDate->format($dateFormats[$interval])."'";
            $totals .=  ",'".$result['total']."'";
            $passed .=  ",'".$result['passed']."'";
            $failed .=  ",'".$result['failed']."'";
            $pending .=  ",'".$result['pending']."'";
        }
        
        $firstDate->add(new DateInterval($dateIntervalFormats[$interval]));
        $dataPoints++;
    }

    $labels = "[".substr($labels, 1)."]";
    $totals = "[".substr($totals, 1)."]";
    $passed = "[".substr($passed, 1)."]";
    $failed = "[".substr($failed, 1)."]";
    $pending = "[".substr($pending, 1)."]";

    $thermometerSummary = ['labels' => $labels, 'totals' => $totals, 'passed' => $passed, 'failed' => $failed, 'pending' => $pending];
    log2File(json_encode($thermometerSummary));

    return $thermometerSummary;
}

function getCentrifugeSummary($interval="monthly", $startDate, $endDate, $maximumDataPoints = 15){

    global $wpdb;

    log2File("$interval, $startDate, $endDate");
    $intervalRange = [];
    $firstDate = new DateTime($startDate);
    $lastDate = new DateTime($endDate);
    $dataPoints = 0;

    $labels = "";
    $totals = "";
    $passed = "";
    $failed = "";
    $pending = "";

    $dateFormats = ['daily' => "Y-m-d", 'monthly' => "Y-m", 'yearly' => "Y"];
    $dateIntervalFormats = ['daily' => "P1D", 'monthly' => "P1M", 'yearly' => "P1Y"];
    $whereClause = [
        'daily' => "substring(date_performed, 1, 10)", 
        'monthly' => "substring(date_performed, 1, 7)", 
        'yearly' => "substring(date_performed, 1, 4)"
        ];

    while ( $firstDate <= $lastDate && $dataPoints < $maximumDataPoints) {
    
        $query = "SELECT count(*) total, count(IF(result='PASSED',1,NULL)) passed, count(IF(result='FAILED',1,NULL)) " .
                "failed, count(IF(result='PENDING',1,NULL)) pending FROM wp_coe_centrifuge_calculations WHERE " .
                "{$whereClause[$interval]} = '".$firstDate->format($dateFormats[$interval])."'";

        log2File($query);

        $result = $wpdb->get_row($query, ARRAY_A);

        if(count($result) > 0){
            $labels .=  ",'".$firstDate->format($dateFormats[$interval])."'";
            $totals .=  ",'".$result['total']."'";
            $passed .=  ",'".$result['passed']."'";
            $failed .=  ",'".$result['failed']."'";
            $pending .=  ",'".$result['pending']."'";
        }
        
        $firstDate->add(new DateInterval($dateIntervalFormats[$interval]));
        $dataPoints++;
    }

    $labels = "[".substr($labels, 1)."]";
    $totals = "[".substr($totals, 1)."]";
    $passed = "[".substr($passed, 1)."]";
    $failed = "[".substr($failed, 1)."]";
    $pending = "[".substr($pending, 1)."]";

    $centrifugeSummary = ['labels' => $labels, 'totals' => $totals, 'passed' => $passed, 'failed' => $failed, 'pending' => $pending];
    log2File(json_encode($centrifugeSummary));

    return $centrifugeSummary;
}

function getTimerSummary($interval="monthly", $startDate, $endDate, $maximumDataPoints = 15){

    global $wpdb;

    log2File("$interval, $startDate, $endDate");
    $intervalRange = [];
    $firstDate = new DateTime($startDate);
    $lastDate = new DateTime($endDate);
    $dataPoints = 0;

    $labels = "";
    $totals = "";
    $passed = "";
    $failed = "";
    $pending = "";

    $dateFormats = ['daily' => "Y-m-d", 'monthly' => "Y-m", 'yearly' => "Y"];
    $dateIntervalFormats = ['daily' => "P1D", 'monthly' => "P1M", 'yearly' => "P1Y"];
    $whereClause = [
        'daily' => "substring(date_performed, 1, 10)", 
        'monthly' => "substring(date_performed, 1, 7)", 
        'yearly' => "substring(date_performed, 1, 4)"
        ];

    while ( $firstDate <= $lastDate && $dataPoints < $maximumDataPoints) {
    
        $query = "SELECT count(*) total, count(IF(result='PASSED',1,NULL)) passed, count(IF(result='FAILED',1,NULL)) " .
                "failed, count(IF(result='PENDING',1,NULL)) pending FROM wp_coe_timer_calculations WHERE " .
                "{$whereClause[$interval]} = '".$firstDate->format($dateFormats[$interval])."'";

        log2File($query);

        $result = $wpdb->get_row($query, ARRAY_A);

        if(count($result) > 0){
            $labels .=  ",'".$firstDate->format($dateFormats[$interval])."'";
            $totals .=  ",'".$result['total']."'";
            $passed .=  ",'".$result['passed']."'";
            $failed .=  ",'".$result['failed']."'";
            $pending .=  ",'".$result['pending']."'";
        }
        
        $firstDate->add(new DateInterval($dateIntervalFormats[$interval]));
        $dataPoints++;
    }

    $labels = "[".substr($labels, 1)."]";
    $totals = "[".substr($totals, 1)."]";
    $passed = "[".substr($passed, 1)."]";
    $failed = "[".substr($failed, 1)."]";
    $pending = "[".substr($pending, 1)."]";

    $timerSummary = ['labels' => $labels, 'totals' => $totals, 'passed' => $passed, 'failed' => $failed, 'pending' => $pending];
    log2File(json_encode($timerSummary));

    return $timerSummary;
}

function getPipetteSummary($interval="monthly", $startDate, $endDate, $maximumDataPoints = 15){

    global $wpdb;

    log2File("$interval, $startDate, $endDate");
    $intervalRange = [];
    $firstDate = new DateTime($startDate);
    $lastDate = new DateTime($endDate);
    $dataPoints = 0;

    $labels = "";
    $totals = "";
    $passed = "";
    $failed = "";
    $pending = "";

    $dateFormats = ['daily' => "Y-m-d", 'monthly' => "Y-m", 'yearly' => "Y"];
    $dateIntervalFormats = ['daily' => "P1D", 'monthly' => "P1M", 'yearly' => "P1Y"];
    $whereClause = [
        'daily' => "substring(completed_at, 1, 10)", 
        'monthly' => "substring(completed_at, 1, 7)", 
        'yearly' => "substring(completed_at, 1, 4)"
        ];

    while ( $firstDate <= $lastDate && $dataPoints < $maximumDataPoints) {
    
        $query = "SELECT count(*) total, count(IF(result='PASS',1,NULL)) passed, count(IF(result='FAIL',1,NULL)) " .
                "failed, count(IF(result='PENDING',1,NULL)) pending FROM wp_coe_pipette_data WHERE " .
                "{$whereClause[$interval]} = '".$firstDate->format($dateFormats[$interval])."'";

        log2File($query);

        $result = $wpdb->get_row($query, ARRAY_A);

        if(count($result) > 0){
            $labels .=  ",'".$firstDate->format($dateFormats[$interval])."'";
            $totals .=  ",'".$result['total']."'";
            $passed .=  ",'".$result['passed']."'";
            $failed .=  ",'".$result['failed']."'";
            $pending .=  ",'".$result['pending']."'";
        }
        
        $firstDate->add(new DateInterval($dateIntervalFormats[$interval]));
        $dataPoints++;
    }

    $labels = "[".substr($labels, 1)."]";
    $totals = "[".substr($totals, 1)."]";
    $passed = "[".substr($passed, 1)."]";
    $failed = "[".substr($failed, 1)."]";
    $pending = "[".substr($pending, 1)."]";

    $pipetteSummary = ['labels' => $labels, 'totals' => $totals, 'passed' => $passed, 'failed' => $failed, 'pending' => $pending];
    log2File(json_encode($pipetteSummary));

    return $pipetteSummary;
}

function getPipetteTAT($interval="monthly", $startDate, $endDate, $maximumDataPoints = 15){

    global $wpdb;

    log2File("$interval, $startDate, $endDate");
    $intervalRange = [];
    $firstDate = new DateTime($startDate);
    $lastDate = new DateTime($endDate);
    $dataPoints = 0;

    $labels = "";
    $totals = "";
    $completed = "";
    $reviewed = "";

    $dateFormats = ['daily' => "Y-m-d", 'monthly' => "Y-m", 'yearly' => "Y"];
    $dateIntervalFormats = ['daily' => "P1D", 'monthly' => "P1M", 'yearly' => "P1Y"];
    $whereClause = [
        'daily' => "substring(logged_at, 1, 10)", 
        'monthly' => "substring(logged_at, 1, 7)", 
        'yearly' => "substring(logged_at, 1, 4)"
        ];

    while ( $firstDate <= $lastDate && $dataPoints < $maximumDataPoints) {
    
        $query = "SELECT count(*) total, sum((unix_timestamp(completed_at)-unix_timestamp(logged_at))/(60*60*24)) completion_tat, ".
                "sum((unix_timestamp(reviewed_at)-unix_timestamp(completed_at))/(60*60*24)) review_tat FROM wp_coe_pipette_data ".
                "WHERE {$whereClause[$interval]} = '".$firstDate->format($dateFormats[$interval])."'";

        log2File($query);

        $result = $wpdb->get_row($query, ARRAY_A);

        if(count($result) > 0){
            $labels .=  ",'".$firstDate->format($dateFormats[$interval])."'";
            $totals .=  ",'".$result['total']."'";
            if ($result['total'] > 0) {
                $completed .=  ",'".round($result['completion_tat']/$result['total'],2)."'";
                $reviewed .=  ",'".round($result['review_tat']/$result['total'],2)."'";
            }else{
                $completed .=  ",'0'";
                $reviewed .=  ",'0'";
            }
        }
        
        $firstDate->add(new DateInterval($dateIntervalFormats[$interval]));
        $dataPoints++;
    }

    $labels = "[".substr($labels, 1)."]";
    $totals = "[".substr($totals, 1)."]";
    $completed = "[".substr($completed, 1)."]";
    $reviewed = "[".substr($reviewed, 1)."]";

    $pipetteSummary = ['labels' => $labels, 'totals' => $totals, 'completed' => $completed, 'reviewed' => $reviewed];
    log2File(json_encode($pipetteSummary));

    return $pipetteSummary;
}

?>