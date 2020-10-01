<?php
/*
 * Pipettes Controller
 *---------------------------------
 * Pipettes Page Values
 * 1 => List
 * 2 => Add
 * 3 => View Certificate
 * 4 => Edit
 */
$COEPageURI['pipettes'][1] = "views/pipettes/list.php";
$COEPageURI['pipettes'][2] = "views/pipettes/new.php";
$COEPageURI['pipettes'][3] = "views/pipettes/certificate.php";
$COEPageURI['pipettes'][4] = "views/pipettes/edit.php";

$pageURL = get_site_url().'/pipettes/';

$COEPage = 1; 

if(!empty( $_REQUEST['calibration_calculation'] )) $COEPage = 2;
else if(!empty( $_REQUEST['show_calibration_certificate'] )) $COEPage = 3;
else if(!empty( $_REQUEST['edit_calibration_calculation'] )) $COEPage = 4;


if ($COEPage == 1) {
    $certicates = getCOEPipetteCertificatesList();
}else if($COEPage == 2){

    $validated = empty( $_REQUEST['form_ready_for_submit'] ) ? false : true;
    $updatedForm = empty( $_REQUEST['form_ready_for_update'] ) ? false : true;

    if ($validated || $updatedForm) {
        if($validated)$response = addPipetteRecordings($_REQUEST);
        else if($updatedForm)$response = updatePipetteRecordings($_REQUEST);

        if($response){
            $COEPage = 1;
            $certicates = getCOEPipetteCertificatesList();
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
    $contents = "";
    $certification = "";
    
    if(!empty( $_REQUEST['certificate_details'] )){
        $certification = json_decode(base64_decode($_REQUEST['certificate_details']), true);

        addPipetteRecordings($_REQUEST, $certification);
    }

    if(!empty( $_REQUEST['status'] )){  // Verify COE Pipette Certificate
        verifyPipetteCertificate($_REQUEST);
        exit();
    }else{                              //Show COE Pipette Certificate
        if(isset($_FILES['mettler_xml'])){
            $errors= array();
            $file_name = $_FILES['mettler_xml']['name'];
            $file_size =$_FILES['mettler_xml']['size'];
            $file_tmp =$_FILES['mettler_xml']['tmp_name'];
            $file_type=$_FILES['mettler_xml']['type'];
            $file_ext=strtolower(end(explode('.',$_FILES['mettler_xml']['name'])));

            $extensions= array("xml");

            if(in_array($file_ext,$extensions)=== false){
                $errors[]="extension not allowed, please choose an xml file.";
            }

            if($file_size > 2097152){
                $errors[]='File size must be less than 2 MB';
            }

            if(empty($errors)==true){
                $stream = fopen($file_tmp, 'r');
                $parser = xml_parser_create();

                while (!feof($stream)){
                    $contents .= fread($stream, 8192);
                }
                fclose($stream);

                move_uploaded_file($file_tmp,"uploads/".$file_name);
                //TODO: Check whether and where this file is stored

                //TODO: Save to db below

                $certification = json_decode(json_encode(simplexml_load_string($contents)), TRUE);
                // print_r($certification);
                $validity = $_REQUEST['validity'];
                $schema = $_REQUEST['xml_schema_type'];
            }else{
                // print_r($errors);
            }
        }else{
            //Read XML from db using ccc_id
            $contents = getCOEPipetteCertificate($requestedCertificate);
            $certification = $contents;
        }
        // $certification = simplexml_load_string($contents);
    }
}else if($COEPage == 4){
    $requestedCertificate = $_REQUEST['ccc_id'];
    
    if(!empty( $_REQUEST['status'] )){  // Verify COE Pipette Certificate
        verifyPipetteCertificate($_REQUEST);
        exit();
    }else{                              //Show COE Pipette Certificate
        $certification = getCOEPipetteCertificate($requestedCertificate);
        error_log($certification);
    }
}

$currentUser = wp_get_current_user();

/*
 * Pipette specific functions
 */

function addPipetteRecordings($request, $certification){
    global $wpdb;

    $currentUser = wp_get_current_user();
    $performTime = substr($certification['CalibrationData']['Test'][0]['Date'],0,10);
    error_log("Performed at $performTime");
    error_log($request['certificate_details']);
    $datePermormed = new DateTime($performTime);
    $now = new DateTime();

    $testDetails = array(
        certificate_number => 'NOT ISSUED',
        pipette_id => $certification['Pipette']['SndID'],
        // client_id => $request['client'],
        xml_schema_type => $request['xml_schema_type'],
        certificate_data => $request['certificate_details'],
        result => 'PENDING',
        // comment => $request['comment'],
        validity => $request['validity'],
        date_performed => $datePermormed->format("Y-m-d"),
        created_by => $currentUser->ID,
        created_at => $now->format("Y-m-d"),
    );

    $wpdb->insert("wp_coe_pipette_xml_imports", $testDetails);

    return true;
}

function updatePipetteRecordings($request){
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

        accuracy_of_standard => $request['accuracy_of_standard'],
        resolution_of_standard => $request['resolution_of_standard'],
        uncertainity_of_standard => $request['uncertainity_of_standard'],
        resolution_of_device_under_test => $request['resolution_of_device_under_test'],
        expected_set_point_a => $request['expected_set_point_a'],
        expected_set_point_b => $request['expected_set_point_b'],
        expected_set_point_c => $request['expected_set_point_c'],
        environmental_temperature => $request['environmental_temperature'],
        environmental_humidity => $request['environmental_humidity'],

        result => 'PENDING'

    );

    $wpdb->update("wp_coe_timer_calculations", $testDetails, ['id' => $calculationID]);

    $intervals = array(1, 2, 3, 4, 5);
    $now = date("Y-m-d H:i:s");

    foreach ($intervals as $interval) {
        $results = $wpdb->get_results("SELECT id FROM wp_coe_timer_calculation_readings WHERE timer_calculation_id = $calculationID AND reading_id = $interval", ARRAY_A);

        if (count($results > 0)) {
            $intervalArray = array(
                'reading_a' => $request['reading_mm_1_'.$interval] * 60 + $request['reading_ss_1_'.$interval],
                'reading_b' => $request['reading_mm_2_'.$interval] * 60 + $request['reading_ss_2_'.$interval],
                'reading_c' => $request['reading_mm_3_'.$interval] * 60 + $request['reading_ss_3_'.$interval],
                'updated_at' => $now
            );

            $wpdb->update("wp_coe_timer_calculation_readings", $intervalArray, ['id' => $results[0]['id']]);
        }else{
            $intervalArray = array(
                'reading_a' => $request['reading_mm_1_'.$interval] * 60 + $request['reading_ss_1_'.$interval],
                'reading_b' => $request['reading_mm_2_'.$interval] * 60 + $request['reading_ss_2_'.$interval],
                'reading_c' => $request['reading_mm_3_'.$interval] * 60 + $request['reading_ss_3_'.$interval],
                'timer_calculation_id' => $calculationID,
                'reading_id' => $interval
            );

            $wpdb->insert("wp_coe_timer_calculation_readings", $intervalArray);
        }
    }

    return true;
}

function getCOEPipetteCertificatesList(){
    global $wpdb;

    $query = "SELECT wp_coe_pipette_xml_imports.id, 
                wp_coe_pipette_xml_imports.date_performed, 
                'wp_coe_clients.name' AS client_name, 
                'Pipette' AS equipment_name, 
                'xxx' AS equipment_serial_number, 
                wp_coe_pipette_xml_imports.result 
            FROM wp_coe_pipette_xml_imports 
            LEFT JOIN wp_coe_clients ON wp_coe_pipette_xml_imports.client_id = wp_coe_clients.id;";

    return $wpdb->get_results($query);
}

function getCOEPipetteCertificate($certificateID){
    global $wpdb;

    $query = "SELECT wp_coe_pipette_xml_imports.*,
                wp_coe_clients.name AS client_name,
                DATE_FORMAT(DATE_ADD(wp_coe_pipette_xml_imports.date_performed, INTERVAL wp_coe_pipette_xml_imports.validity MONTH),'%M %Y') AS certificate_validity
            FROM wp_coe_pipette_xml_imports 
            LEFT JOIN wp_coe_clients 
                ON wp_coe_pipette_xml_imports.client_id = wp_coe_clients.id
            WHERE wp_coe_pipette_xml_imports.id = $certificateID;";

    $result = $wpdb->get_row($query);
    
    $certification = json_decode(base64_decode($result->certificate_data), true);

    // Creators, verifiers and approvers
    if ($result->created_by) {
        $subQuery = "SELECT display_name FROM wp_users WHERE ID = ".$result->created_by;

        $certification['creator'] = $wpdb->get_row($subQuery, ARRAY_A);
    }else{
        $certification['creator'] = "";
    }

    if ($result->verified_by) {
        $subQuery = "SELECT display_name FROM wp_users WHERE ID = ".$result->verified_by;

        $certification['verifier'] = $wpdb->get_row($subQuery, ARRAY_A);
    }else{
        $certification['verifier'] = "";
    }

    if ($result->approved_by) {
        $subQuery = "SELECT display_name FROM wp_users WHERE ID = ".$result->approved_by;

        $certification['approver'] = $wpdb->get_row($subQuery, ARRAY_A);
    }else{
        $certification['approver'] = "";
    }

    return $certification;
}

function verifyPipetteCertificate($data){
    global $wpdb;

    $currentUser = wp_get_current_user();
    $_APPROVER = $currentUser->ID;
    $_VERIFIER = $currentUser->ID;

    $datetime = date("Y-m-d H:i:s", time() + (3*60*60)); //UTC+3
    $year = substr($datetime, 0, 4);

    $subQuery = "SELECT COUNT(id) hits FROM wp_coe_timer_calculations WHERE verified_at LIKE '$year%'";

    $result = $wpdb->get_row($subQuery, ARRAY_A);
    $certificateNumber = str_pad((intval($result['hits'])+1), 4, "0", STR_PAD_LEFT);

    $verifierData = [
        'result' => $data['status'], 
        'certificate_number' => "COE/TIME/".$year."/$certificateNumber", 
        'verified_by' => $_VERIFIER, 
        'verified_at' => $datetime, 
        'approved_by' => $_APPROVER, 
        'approved_at' => $datetime
    ];

    $wpdb->update("wp_coe_timer_calculations", $verifierData, ['id' => $data['ccc_id']]);
}
?>