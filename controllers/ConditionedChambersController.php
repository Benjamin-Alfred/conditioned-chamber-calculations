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

$COEPage = 0;

$APICode = empty( $_REQUEST['api_code'] ) ? 0 : $_REQUEST['api_code'];

$currentUser = wp_get_current_user();

$pageURL = get_site_url()."/conditioned-chambers/";

switch ($APICode) {
    case '0': // list CC
        $COEPage = 0;
        break;
    case '1': // new CC
        $COEPage = 1;
        break;
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
    case '4': // view CC certificate
        $COEPage = 2;
        break;
    case '5': // edit CC
        $COEPage = 3;
        break;
    case '6': // verify CC certificte
        $requestedCertificate = $_REQUEST['ccc_id'];
        if(!empty( $_REQUEST['status'] )){  // Verify COE CC Certificate
            verifyConditionedChamberCertificate($_REQUEST);
        }
        exit();
        break;
    case '7': // list client contacts
        $COEPage = 4;
        break;
    case '8': // Activate/De-activate client contact
        $contactID = empty( $_REQUEST['contact_id'] ) ? false : $_REQUEST['contact_id'];
        activateCOEClientContact($contactID, $_REQUEST['can_login']);
        $COEPage = 4;
        break;
    case '9': // new client contact
        $COEPage = 5;
        break;
    case '10': // edit contact
        $COEPage = 6;
        break;
    case '12': // add new manufacturer
        $newManufacturer = empty( $_REQUEST['manufacturer_name'] ) ? false : $_REQUEST['manufacturer_name'];
        addCOEManufacturer($newManufacturer);
        $APICode = 500;
        break;
    case '13': // add new equipment
        $newEquipment = empty( $_REQUEST['equipment_name'] ) ? false : $_REQUEST['equipment_name'];
        addCOEEquipment($newEquipment);
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
        $STEquipments = getCOESTEquipment();
        $clients = getCOEClients();
        $clientContacts = getCOEClientContacts();
        break;
    case '4':
        $contacts = getCOEClientContacts(true); //Get client contacts with facility details
        break;
    case '6':
        $contactID = $_REQUEST['contact_id'];
        $contact = getCOEClientContact($contactID); //Get client contacts with facility details
        log2File(json_encode($contact));
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

?>