<?php
/*
 * Conditioned Chambers Controller
 *---------------------------------
 * Conditioned Chambers Page Values
 * 1 => List
 * 2 => Add
 * 3 => View Certificate
 * 4 => Edit
 */
$COEPageURI['conditioned-chambers'][0] = "views/conditioned-chambers/list.php";
$COEPageURI['conditioned-chambers'][1] = "views/conditioned-chambers/new.php";
$COEPageURI['conditioned-chambers'][2] = "views/conditioned-chambers/certificate.php";
$COEPageURI['conditioned-chambers'][3] = "views/conditioned-chambers/edit.php";

$COEPageURI['conditioned-chambers'][4] = "views/clients/list.php";
$COEPageURI['conditioned-chambers'][5] = "views/clients/new.php";
$COEPageURI['conditioned-chambers'][6] = "views/clients/edit.php";

$COEPageURI['conditioned-chambers'][7] = "views/dashboard/view.php";

$COEPageURI['conditioned-chambers'][8] = "views/service-requests/list.php";
$COEPageURI['conditioned-chambers'][9] = "views/service-requests/view.php";

$COEPage = $APICode = 0;

$APICode = $_REQUEST['api_code'];

$currentUser = wp_get_current_user();

$pageURL = get_site_url()."/conditioned-chambers/";

$pageHeader = "Conditioned Chambers";

switch ($APICode) {
    case '0': $COEPage = 0; break; // list CC
    case '1': $COEPage = 1; break; // new CC
    case '2': // save CC
        $response = addConditionedChamberRecordings($_REQUEST);

        if($response){
            $COEPage = 0;
        }else{
            $COEPage = 1;
        }
        break;
    case '3': // update CC
        $response = updateConditionedChamberRecordings($_REQUEST);

        if($response){
            $COEPage = 0;
        }else{
            $COEPage = 3;
        }
        break;
    case '4': $COEPage = 2; break; // view CC certificate
    case '5': $COEPage = 3; break; // edit CC
    case '6': // verify CC certificte
        $requestedCertificate = $_REQUEST['ccc_id'];
        if(!empty( $_REQUEST['status'] )){  // Verify COE CC Certificate
            verifyConditionedChamberCertificate($_REQUEST);
        }
        exit();
        break;
    case '7': $COEPage = 4; break; // list client contacts
    case '8': // Activate/De-activate client contact
        $contactID = empty( $_REQUEST['contact_id'] ) ? false : $_REQUEST['contact_id'];
        activateCOEClientContact($contactID, $_REQUEST['can_login']);
        $COEPage = 4;
        break;
    case '9': $COEPage = 5; break; // new client contact
    case '10': $COEPage = 6; break; // edit contact
    case '11': // view dashboard
        $COEPage = 7;
        log2File("Viewing dashboard");
        break;
    case '12': // add new manufacturer
        $newManufacturer = empty( $_REQUEST['manufacturer_name'] ) ? false : $_REQUEST['manufacturer_name'];
        addCOEManufacturer($newManufacturer);
        $APICode = 500;
        break;
    case '13': // add new equipment
        $newEquipment = empty( $_REQUEST['equipment_name'] ) ? false : $_REQUEST['equipment_name'];
        $equipmentType = empty( $_REQUEST['equipment_type_id'] ) ? null : $_REQUEST['equipment_type_id'];
        addCOEEquipment($newEquipment, $equipmentType);
        $APICode = 501;
        break;
    case '14': // add new standard test equipment 
        $newSTEquipment = empty( $_REQUEST['s_t_equipment_name'] ) ? false : $_REQUEST['s_t_equipment_name'];
        addCOESTEquipment($newSTEquipment);
        $APICode = 502;
        break;
    case '15': // add new client
        $newClient = empty( $_REQUEST['client_name'] ) ? false : $_REQUEST['client_name'];
        addCOEClient($newClient);
        $APICode = 503;
        break;
    case '16': // add new client contact
        $clientID = empty( $_REQUEST['client_id'] ) ? false : $_REQUEST['client_id'];
        $newClientContactName = empty( $_REQUEST['contact_name'] ) ? false : $_REQUEST['contact_name'];
        $newClientContactEmail = empty( $_REQUEST['contact_email'] ) ? false : $_REQUEST['contact_email'];
        $newClientContactPhone = empty( $_REQUEST['contact_phone'] ) ? '' : $_REQUEST['contact_phone'];

        addCOEClientContact($clientID, $newClientContactName, $newClientContactEmail, $newClientContactPhone);
        $APICode = 504;
        break;
    case '17': // update client contact
        $faciltyID = empty( $_REQUEST['facility_id'] ) ? false : $_REQUEST['facility_id'];
        $contactID = empty( $_REQUEST['contact_id'] ) ? false : $_REQUEST['contact_id'];
        $contactName = empty( $_REQUEST['contact_name'] ) ? false : $_REQUEST['contact_name'];
        $contactEmail = empty( $_REQUEST['contact_email'] ) ? false : $_REQUEST['contact_email'];
        $contactPhone = empty( $_REQUEST['contact_phone'] ) ? '' : $_REQUEST['contact_phone'];

        updateCOEClientContact($contactID, $faciltyID, $contactName, $contactEmail, $contactPhone);
        $COEPage = 4;
        break;
    case '18': $COEPage = 8; break; // list service requests
    case '19': $COEPage = 9; break; // view service request detail
    case '20': // update service request 
        $serviceRequestID = empty($_REQUEST['service_request_id']) ? false : $_REQUEST['service_request_id'];
        $serviceRequestAction = empty($_REQUEST['service_request_action']) ? false : $_REQUEST['service_request_action'];
        $serviceRequestComment = empty($_REQUEST['service_request_comment']) ? false : $_REQUEST['service_request_comment'];
        updateServiceRequest($serviceRequestID, $serviceRequestAction, $serviceRequestComment);

        exit();
        break;
}

//Return JSON output and exit - codes from 500
switch ($APICode) {
    case '500': // get manufacturers
        $manufacturers = getCOEManufacturers();
        echo json_encode($manufacturers);
        exit();
        break;
    case '501': // get equipments
        $equipments = getCOEEquipment();
        echo json_encode($equipments);
        exit();
        break;
    case '502': // get standard test equipment
        $STEquipments = getCOESTEquipment();
        echo json_encode($STEquipments);
        exit();
        break;
    case '503': // get clients
        $clients = getCOEClients();
        echo json_encode($clients);
        exit();
        break;
    case '504': // get client contacts
        $clientContacts = getCOEClientContacts();
        echo json_encode($clientContacts);
        exit();
        break;
    case '600': //Search for facility by MFL Code
        echo json_encode(getCOEFacility($_REQUEST['search_text']));
        exit();
        break;
    case '601': //Add new Facility contact
        $newContact = addCOEClientContact($_REQUEST['facility_id'], $_REQUEST['contact_name'], 
            $_REQUEST['contact_email'], $_REQUEST['contact_phone']);
        echo json_encode($newContact);
        exit();
        break;
}

// Redirect to page - where do we go now?
switch ($COEPage) {
    case '0':
        $certicates = getCOEConditionedChamberCertificatesList();
        break;
    case '1':
        $manufacturers = getCOEManufacturers();
        $equipments = getCOEEquipment();
        $equipmentTypes = getCOEEquipmentTypes();
        $STEquipments = getCOESTEquipment();
        $clients = getCOEClients();
        $clientContacts = getCOEClientContacts();
        break;
    case '2':
        $requestedCertificate = $_REQUEST['ccc_id'];
        $certification = getCOECCCertificate($requestedCertificate);
        break;
    case '3':
        $requestedCertificate = $_REQUEST['ccc_id'];
        $certification = getCOECCCertificate($requestedCertificate);

        $manufacturers = getCOEManufacturers();
        $equipments = getCOEEquipment();
        $equipmentTypes = getCOEEquipmentTypes();
        $STEquipments = getCOESTEquipment();
        $clients = getCOEClients();
        $clientContacts = getCOEClientContacts();
        break;
    case '4':
        $pageHeader = "Registered Users";
        $contacts = getCOEClientContacts(true); //Get client contacts with facility details
        break;
    case '6':
        $pageHeader = "Registered Users";
        $contactID = $_REQUEST['contact_id'];
        $contact = getCOEClientContact($contactID); //Get client contacts with facility details
        log2File(json_encode($contact));
        break;
    case '7':
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
        break;
    case '8':
        $pageHeader = "Service Requests";
        $serviceRequests = getServiceRequests();
        break;
    case '9':
        $pageHeader = "Service Requests";
        $serviceRequest = getServiceRequest($_REQUEST['service_request_id']);
        break;
}

/*
 * Conditioned Chamber specific functions
 */
function addConditionedChamberRecordings($request){
    global $wpdb;

    $currentUser = wp_get_current_user();

    $testDetails = array(
        client_id => $request['client'],
        client_contact_id => $request['client_contact_id'],

        date_performed => $request['date_performed'],
        created_by => $currentUser->ID,
        manufacturer_id => $request['manufacturer'],
        equipment_id => $request['equipment'],
        equipment_model => $request['model'],
        equipment_serial_number => $request['serial_number'],
        submission_number => $request['submission_number'],

        certificate_number => 'NOT ISSUED',
        
        standard_test_equipment_id => $request['ste_equipment'],
        standard_test_equipment_manufacturer_id => $request['ste_manufacturer'],
        standard_test_equipment_model => $request['ste_model'],
        standard_test_equipment_serial_number => $request['ste_serial_number'],
        standard_test_equipment_certificate_number => $request['ste_certificate_number'],
        standard_test_equipment_sticker_number => $request['ste_sticker_number'],

        uncertainity_of_standard => $request['uncertainity_of_standard'],
        resolution_of_standard => $request['resolution_of_standard'],
        expected_temperature => $request['expected_temperature'],
        environmental_temperature => $request['environmental_temperature'],
        environmental_humidity => $request['environmental_humidity'],

        result => 'PENDING'

    );

    $wpdb->insert("wp_coe_conditioned_chamber_calculations", $testDetails);
    $CCCID = $wpdb->insert_id;

    $intervals = array(0, 6, 12, 18, 24, 30, 36, 42, 48, 54, 60);

    $p1Values = array();
    $p2Values = array();
    $p3Values = array();
    $errorValues = array();


    foreach ($intervals as $interval) {
        $intervalArray = array(
                'conditioned_chamber_calculation_id' => $CCCID,
                'reading_time' => $interval,
                'reading_a' => $request['p_1_'.$interval],
                'reading_b' => $request['p_2_'.$interval],
                'reading_c' => $request['p_3_'.$interval],
                'created_by' => $currentUser->ID
            );
        $wpdb->insert("wp_coe_conditioned_chamber_calculation_readings", $intervalArray);

        $p1Values[$interval] = $request['p_1_'.$interval];
        $p2Values[$interval] = $request['p_2_'.$interval];
        $p3Values[$interval] = $request['p_3_'.$interval];

        $averagePValue = ($p1Values[$interval] + $p2Values[$interval] + $p3Values[$interval])/3;

        $errorValues[$interval] = $averagePValue - $request['expected_temperature'];
    }

    //Calculate uncertainity
    $divisor = 2;

    $averageError = pow(array_sum($errorValues)/count($errorValues)/$divisor, 2);
    $variance = pow((max($errorValues) - min($errorValues))/$divisor, 2);

    $p1Average = array_sum($p1Values)/count($p1Values);
    $p2Average = array_sum($p2Values)/count($p2Values);
    $p3Average = array_sum($p3Values)/count($p3Values);

    $homogeneity = pow((($p1Average - $p2Average) + ($p2Average - $p3Average))/2/$divisor, 2);
    $repeatability = pow(sd($errorValues)/sqrt(count($errorValues))/$divisor, 2);

    $UCStandard = pow($testDetails['uncertainity_of_standard']/sqrt(3), 2);
    $resn = pow($testDetails['resolution_of_standard']/$divisor/sqrt(3), 2);
    
    $uncertainity = sqrt($averageError + $variance + $homogeneity  + $repeatability + $UCStandard + $resn);

    $wpdb->update("wp_coe_conditioned_chamber_calculations", ['uncertainity' => $uncertainity], ['id' => $CCCID]);

    return true;
}

function updateConditionedChamberRecordings($request){
    global $wpdb;

    $currentUser = wp_get_current_user();

    $calculationID = $request['calibration_calculation_id'];

    $testDetails = array(
        client_id => $request['client'],
        client_contact_id => $request['client_contact_id'],

        date_performed => $request['date_performed'],
        created_by => $currentUser->ID,
        manufacturer_id => $request['manufacturer'],
        equipment_id => $request['equipment'],
        equipment_model => $request['model'],
        equipment_serial_number => $request['serial_number'],
        submission_number => $request['submission_number'],

        certificate_number => 'NOT ISSUED',
        
        standard_test_equipment_id => $request['ste_equipment'],
        standard_test_equipment_manufacturer_id => $request['ste_manufacturer'],
        standard_test_equipment_model => $request['ste_model'],
        standard_test_equipment_serial_number => $request['ste_serial_number'],
        standard_test_equipment_certificate_number => $request['ste_certificate_number'],
        standard_test_equipment_sticker_number => $request['ste_sticker_number'],

        uncertainity_of_standard => $request['uncertainity_of_standard'],
        resolution_of_standard => $request['resolution_of_standard'],
        expected_temperature => $request['expected_temperature'],
        environmental_temperature => $request['environmental_temperature'],
        environmental_humidity => $request['environmental_humidity'],

        result => 'PENDING'

    );

    $wpdb->update("wp_coe_conditioned_chamber_calculations", $testDetails, ['id' => $calculationID]);

    $intervals = array(0, 6, 12, 18, 24, 30, 36, 42, 48, 54, 60);
    $now = date("Y-m-d H:i:s");

    foreach ($intervals as $interval) {
        $results = $wpdb->get_results("SELECT id FROM wp_coe_conditioned_chamber_calculation_readings WHERE conditioned_chamber_calculation_id = $calculationID AND reading_time = $interval", ARRAY_A);

        if (count($results > 0)) {
            $intervalArray = array(
                'reading_a' => $request['p_1_'.$interval],
                'reading_b' => $request['p_2_'.$interval],
                'reading_c' => $request['p_3_'.$interval],
                'updated_at' => $now
            );

            $wpdb->update("wp_coe_conditioned_chamber_calculation_readings", $intervalArray, ['id' => $results[0]['id']]);
        }else{
            $intervalArray = array(
                'reading_a' => $request['p_1_'.$interval],
                'reading_b' => $request['p_2_'.$interval],
                'reading_c' => $request['p_3_'.$interval],
                'conditioned_chamber_calculation_id' => $calculationID,
                'reading_time' => $interval
            );

            $wpdb->insert("wp_coe_conditioned_chamber_calculation_readings", $intervalArray);
        }

    }

    return true;
}

function getCOEConditionedChamberCertificatesList(){
    global $wpdb;

    $query = "SELECT wp_coe_conditioned_chamber_calculations.id, 
                wp_coe_conditioned_chamber_calculations.date_performed, 
                wp_coe_clients.name AS client_name, 
                wp_coe_equipment.name AS equipment_name, 
                wp_coe_conditioned_chamber_calculations.equipment_serial_number, 
                wp_coe_conditioned_chamber_calculations.result 
            FROM wp_coe_conditioned_chamber_calculations 
            INNER JOIN wp_coe_equipment 
                ON wp_coe_conditioned_chamber_calculations.equipment_id = wp_coe_equipment.id
            INNER JOIN wp_coe_clients ON wp_coe_conditioned_chamber_calculations.client_id = wp_coe_clients.id;";

    return $wpdb->get_results($query);
}

function verifyConditionedChamberCertificate($data){
    global $wpdb;

    $currentUser = wp_get_current_user();
    $_APPROVER = $currentUser->ID;
    $_VERIFIER = $currentUser->ID;

    $datetime = date("Y-m-d H:i:s", time() + (3*60*60)); //UTC+3
    $year = substr($datetime, 0, 4);

    $subQuery = "SELECT COUNT(id) hits FROM wp_coe_conditioned_chamber_calculations WHERE verified_at LIKE '$year%'";

    $result = $wpdb->get_row($subQuery, ARRAY_A);
    $certificateNumber = str_pad((intval($result['hits'])+1), 4, "0", STR_PAD_LEFT);

    $verifierData = [
        'result' => $data['status'], 
        'certificate_number' => "COE/CC/".$year."/$certificateNumber", 
        'verified_by' => $_VERIFIER, 
        'verified_at' => $datetime, 
        'approved_by' => $_APPROVER, 
        'approved_at' => $datetime
    ];

    $wpdb->update("wp_coe_conditioned_chamber_calculations", $verifierData, ['id' => $data['ccc_id']]);
}

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

function getServiceRequests(){
    global $wpdb;
    
    $query = "SELECT sr.id AS service_request_id, f.id AS facility_id, f.name AS facility_name, m.name AS manufacturer_name, "
            ."e.name AS equipment_name, sr.equipment_model, sr.equipment_serial_number, sr.equipment_inventory_number, "
            ."srs.status_text AS status, nsrs.done_at AS request_date, cc.name AS requested_by, sr.calibration_interval "
            ."FROM wp_coe_service_requests sr "
            ."LEFT JOIN (SELECT sr.id, MAX(srs.done_at) time_done FROM wp_coe_service_requests sr "
                ."LEFT JOIN wp_coe_service_request_status srs ON sr.id=srs.service_request_id GROUP BY sr.id) AS xsr "
                ."ON sr.id = xsr.id "
            ."LEFT JOIN wp_coe_service_request_status srs ON sr.id=srs.service_request_id AND srs.done_at = xsr.time_done "
            ."LEFT JOIN (SELECT sr.id, MAX(srs.done_at) time_done FROM wp_coe_service_requests sr "
                ."LEFT JOIN wp_coe_service_request_status srs ON sr.id=srs.service_request_id GROUP BY sr.id) AS nsr "
                ."ON sr.id = nsr.id "
            ."LEFT JOIN wp_coe_service_request_status nsrs ON sr.id=nsrs.service_request_id AND nsrs.done_at=xsr.time_done "
            ."LEFT JOIN wp_coe_client_contacts cc ON nsrs.done_by = cc.id "
            ."LEFT JOIN wp_coe_facilities f ON sr.facility_id = f.id "
            ."LEFT JOIN wp_coe_equipment e ON sr.equipment_id = e.id "
            ."LEFT JOIN wp_coe_manufacturers m ON sr.manufacturer_id = m.id;";

    log2File($query);

    $serviceRequests = $wpdb->get_results($query, ARRAY_A);

    return $serviceRequests;
}

function getServiceRequest($serviceRequestID){
    log2File("getServiceRequest");
    log2File("serviceRequestID: $serviceRequestID");
    global $wpdb;
    
    $query = "SELECT sr.id AS service_request_id, f.id AS facility_id, f.name AS facility_name, "
            ."m.name AS manufacturer_name, e.name AS equipment_name, sr.equipment_model, sr.equipment_serial_number, "
            ."sr.equipment_inventory_number, sr.calibration_interval, sr.comments, srs.status_text AS status "
            ."FROM wp_coe_service_requests sr " 
            ."INNER JOIN (SELECT sr.id, MAX(srs.done_at) time_done FROM wp_coe_service_requests sr "
                ."LEFT JOIN wp_coe_service_request_status srs ON sr.id=srs.service_request_id GROUP BY sr.id) AS xsr "
                ."ON sr.id = xsr.id "
            ."LEFT JOIN wp_coe_service_request_status srs ON sr.id = srs.service_request_id AND srs.done_at = xsr.time_done " 
            ."LEFT JOIN wp_coe_facilities f ON sr.facility_id = f.id "
            ."LEFT JOIN wp_coe_equipment e ON sr.equipment_id = e.id "
            ."LEFT JOIN wp_coe_manufacturers m ON sr.manufacturer_id = m.id "
            ."WHERE sr.id = $serviceRequestID;";

    log2File($query);

    $serviceRequest = $wpdb->get_row($query, ARRAY_A);

    $query = "SELECT srs.status, srs.status_text, srs.done_at, IF(srs.status = 'created', cc.name, u.display_name) name "
            ."FROM wp_coe_service_request_status srs "
            ."LEFT JOIN wp_coe_client_contacts cc ON srs.done_by = cc.id AND srs.status = 'created' "
            ."LEFT JOIN wp_users u ON srs.done_by = u.ID AND srs.status != 'created' "
            ."WHERE service_request_id = $serviceRequestID";
    $serviceRequestStatus = $wpdb->get_results($query, ARRAY_A);
    $serviceRequest['stati'] = $serviceRequestStatus;

    $query = "SELECT comment FROM wp_coe_service_request_rejection_reasons WHERE service_request_id = $serviceRequestID";
    $serviceRequest['rejection_reason'] = $wpdb->get_row($query, ARRAY_A);

    return $serviceRequest;
}

function updateServiceRequest($serviceRequestID, $serviceRequestAction, $comments = ""){

    global $wpdb;
    $status = ['Accept' => 'received', 'Reject' => 'rejected'];
    $statusText = ['Accept' => 'Received', 'Reject' => 'Rejected'];

    log2File("SRI: $serviceRequestID SRA: $serviceRequestAction C: $comments");

    $currentUser = wp_get_current_user();

    $serviceRequestStatus = [
        'service_request_id' => $serviceRequestID, 
        'status' => $status[$serviceRequestAction],
        'status_text' => $statusText[$serviceRequestAction],
        'done_by' => $currentUser->id
    ];

    $wpdb->insert('wp_coe_service_request_status', $serviceRequestStatus);

    if(strlen(trim($comments)) > 0){
        $serviceRequestRejectionReason = [
            'service_request_id' => $serviceRequestID, 
            'comment' => $comments
        ];

        $wpdb->insert('wp_coe_service_request_rejection_reasons', $serviceRequestRejectionReason);
    }
}
?>