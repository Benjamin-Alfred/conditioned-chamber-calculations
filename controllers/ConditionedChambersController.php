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
$COEPageURI['conditioned-chambers'][1] = "views/conditioned-chambers/list.php";
$COEPageURI['conditioned-chambers'][2] = "views/conditioned-chambers/entry-form.php";
$COEPageURI['conditioned-chambers'][3] = "views/conditioned-chambers/certificate.php";
$COEPageURI['conditioned-chambers'][4] = "views/conditioned-chambers/edit-form.php";

$COEPage = 1; 
if(!empty( $_REQUEST['calibration_calculation'] )) $COEPage = 2;
else if(!empty( $_REQUEST['show_calibration_certificate'] )) $COEPage = 3;
else if(!empty( $_REQUEST['edit_calibration_calculation'] )) $COEPage = 4;


if ($COEPage == 1) {
    $certicates = getCOEConditionedChamberCertificatesList();
}else if($COEPage == 2){

    $validated = empty( $_REQUEST['form_ready_for_submit'] ) ? false : true;
    $updatedForm = empty( $_REQUEST['form_ready_for_update'] ) ? false : true;

    if ($validated || $updatedForm) {
        if($validated)$response = addConditionedChamberRecordings($_REQUEST);
        else if($updatedForm)$response = updateConditionedChamberRecordings($_REQUEST);

        if($response){
            $COEPage = 1;
            $certicates = getCOEConditionedChamberCertificatesList();
        }
    }else{

        $newManufacturer = empty( $_REQUEST['manufacturer_name'] ) ? false : $_REQUEST['manufacturer_name'];
        addCOEManufacturer($newManufacturer);

        $newEquipment = empty( $_REQUEST['equipment_name'] ) ? false : $_REQUEST['equipment_name'];
        addCOEEquipment($newEquipment);

        $newSTEquipment = empty( $_REQUEST['s_t_equipment_name'] ) ? false : $_REQUEST['s_t_equipment_name'];
        addCOESTEquipment($newSTEquipment);

        $newClient = empty( $_REQUEST['client_name'] ) ? false : $_REQUEST['client_name'];
        addCOEClient($newClient);
        
        $clientID = empty( $_REQUEST['client_id'] ) ? false : $_REQUEST['client_id'];
        $newClientContactName = empty( $_REQUEST['contact_name'] ) ? false : $_REQUEST['contact_name'];
        $newClientContactEmail = empty( $_REQUEST['contact_email'] ) ? false : $_REQUEST['contact_email'];
        $newClientContactPhone = empty( $_REQUEST['contact_phone'] ) ? '' : $_REQUEST['contact_phone'];

        addCOEClientContact($clientID, $newClientContactName, $newClientContactEmail, $newClientContactPhone);

        $manufacturers = getCOEManufacturers();
        $equipments = getCOEEquipment();
        $STEquipments = getCOESTEquipment();
        $clients = getCOEClients();
        $clientContacts = getCOEClientContacts();

        // If this was an AJAX call, return json output then terminate execution
        $APICode = empty( $_REQUEST['api_code'] ) ? 0 : $_REQUEST['api_code'];

        switch ($APICode) {
            case '0':
                break;
            case '1':
                echo json_encode($manufacturers);
                exit();
                break;
            case '2':
                echo json_encode($equipments);
                exit();
                break;
            case '3':
                echo json_encode($STEquipments);
                exit();
                break;
            case '4':
                echo json_encode($clients);
                exit();
                break;
            case '5':
                echo json_encode($clientContacts);
                exit();
                break;
        }
    }

}else if($COEPage == 3){
    $requestedCertificate = $_REQUEST['ccc_id'];
    
    if(!empty( $_REQUEST['status'] )){  // Verify COE CC Certificate
        verifyConditionedChamberCertificate($_REQUEST);
        exit();
    }else{                              //Show COE CC Certificate
        $certification = getCOECCCertificate($requestedCertificate);
    }
}else if($COEPage == 4){
    $requestedCertificate = $_REQUEST['ccc_id'];
    
    if(!empty( $_REQUEST['status'] )){  // Verify COE Thermometer Certificate
        verifyConditionedChamberCertificate($_REQUEST);
        exit();
    }else{                              //Show COE Thermometer Certificate
        $certification = getCOECCCertificate($requestedCertificate);

        $manufacturers = getCOEManufacturers();
        $equipments = getCOEEquipment();
        $STEquipments = getCOESTEquipment();
        $clients = getCOEClients();
        $clientContacts = getCOEClientContacts();
    }
}

$currentUser = wp_get_current_user();

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