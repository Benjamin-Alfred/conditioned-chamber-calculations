<?php
function my_theme_enqueue_styles() {

    $parent_style = 'twentyseventeen-style'; // This is 'twentyfifteen-style' for the Twenty Fifteen theme.

    wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css' );

    wp_enqueue_style( 'child-style',
        get_stylesheet_directory_uri() . '/style.css',
        array( $parent_style ),
        wp_get_theme()->get('Version')
    );

    wp_enqueue_style(
        'jquery-ui',
        get_stylesheet_directory_uri() . '/js/jquery-ui-1.12.1.custom/jquery-ui.min.css',
        array($parent_style, 'child-style')
    );

    wp_enqueue_style(
        'bootstrap',
        get_stylesheet_directory_uri() . '/js/bootstrap/css/bootstrap.min.css',
        array($parent_style, 'child-style', 'jquery-ui')
    );

    wp_enqueue_script(
        'jquery-ui',
        get_stylesheet_directory_uri() . '/js/jquery-ui-1.12.1.custom/jquery-ui.min.js',
        array('jquery')
    );

    wp_enqueue_script(
        'bootstrap',
        get_stylesheet_directory_uri() . '/js/bootstrap/js/bootstrap.bundle.min.js',
        array('jquery','jquery-ui')
    );

}
add_action( 'wp_enqueue_scripts', 'my_theme_enqueue_styles' );

function addCOEManufacturer($name){
    global $wpdb;
    if ($name != false) {
        $result = $wpdb->insert("wp_coe_manufacturers", array('name' => trim($name)));
    }
}

function getCOEManufacturers(){
    global $wpdb;
    
    return $wpdb->get_results("SELECT * FROM wp_coe_manufacturers ORDER BY name;");
}

function addCOEEquipment($name){
    global $wpdb;
    if ($name != false) {
        $result = $wpdb->insert("wp_coe_equipment", array('name' => trim($name)));
    }
}

function getCOEEquipment(){
    global $wpdb;
    
    return $wpdb->get_results("SELECT * FROM wp_coe_equipment ORDER BY name;");
}

function addCOESTEquipment($name){
    global $wpdb;
    if ($name != false) {
        $result = $wpdb->insert("wp_coe_standard_test_equipment", array('name' => trim($name)));
    }
}

function getCOESTEquipment(){
    global $wpdb;
    
    return $wpdb->get_results("SELECT * FROM wp_coe_standard_test_equipment ORDER BY name;");
}

function addCOEClient($name){
    global $wpdb;
    if ($name != false) {
        $result = $wpdb->insert("wp_coe_clients", array('name' => trim($name)));
    }
}

function getCOEClients(){
    global $wpdb;
    
    return $wpdb->get_results("SELECT * FROM wp_coe_clients ORDER BY name;");
}

function addCOEClientContact($clientID, $name, $email, $phone){
    global $wpdb;
    if ($clientID != false && $name != false && $email != false) {
        $result = $wpdb->insert("wp_coe_client_contacts",
                    array('client_id' => $clientID, 'name' => trim($name), 'email' => trim($email), 'phone' => trim($phone)));
    }
}

function getCOEClientContacts(){
    global $wpdb;
    
    return $wpdb->get_results("SELECT * FROM wp_coe_client_contacts ORDER BY name;");
}

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

function getCOECCCertificate($certificateID){
    global $wpdb;

    $query = "SELECT wp_coe_conditioned_chamber_calculations.*,
                wp_coe_clients.name AS client_name,
                wp_coe_client_contacts.name AS client_contact_name,
                wp_coe_client_contacts.email AS client_contact_email,
                wp_coe_equipment.name AS equipment_name,
                wp_coe_manufacturers.name AS manufacturer_name,
                DATE_FORMAT(DATE_ADD(wp_coe_conditioned_chamber_calculations.date_performed, INTERVAL 1 YEAR),'%M %Y') AS certificate_validity
            FROM wp_coe_conditioned_chamber_calculations 
            LEFT JOIN wp_coe_clients 
                ON wp_coe_conditioned_chamber_calculations.client_id = wp_coe_clients.id
            LEFT JOIN wp_coe_client_contacts 
                ON wp_coe_conditioned_chamber_calculations.client_contact_id = wp_coe_client_contacts.id
            LEFT JOIN wp_coe_equipment 
                ON wp_coe_conditioned_chamber_calculations.equipment_id = wp_coe_equipment.id
            LEFT JOIN wp_coe_manufacturers
                ON wp_coe_conditioned_chamber_calculations.manufacturer_id = wp_coe_manufacturers.id
            WHERE wp_coe_conditioned_chamber_calculations.id = $certificateID;";

    $result = $wpdb->get_row($query);
    
    $subQuery = "SELECT * FROM wp_coe_conditioned_chamber_calculation_readings WHERE conditioned_chamber_calculation_id = ".$result->id;

    $result->readings = $wpdb->get_results($subQuery, ARRAY_A);

    // Creators, verifiers and approvers
    $subQuery = "SELECT display_name FROM wp_users WHERE ID = ".$result->created_by;

    $result->creator = $wpdb->get_row($subQuery, ARRAY_A);

    $subQuery = "SELECT display_name FROM wp_users WHERE ID = ".$result->verified_by;

    $result->verifier = $wpdb->get_row($subQuery, ARRAY_A);

    $subQuery = "SELECT display_name FROM wp_users WHERE ID = ".$result->approved_by;

    $result->approver = $wpdb->get_row($subQuery, ARRAY_A);

    // Standard Test Equipment Info: Name and manufacturer
    $subQuery = "SELECT name FROM wp_coe_standard_test_equipment WHERE id = ".$result->standard_test_equipment_id;

    $result->ste_equipment = $wpdb->get_row($subQuery, ARRAY_A);

    $subQuery = "SELECT name FROM wp_coe_manufacturers WHERE id = ".$result->standard_test_equipment_manufacturer_id;

    $result->ste_manufacturer = $wpdb->get_row($subQuery, ARRAY_A);

    return $result;
}

function verifyCOECertificate($data){
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

function addThermometerRecordings($request){
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
        expected_temperature_a => $request['expected_temperature_a'],
        expected_temperature_b => $request['expected_temperature_b'],
        expected_temperature_c => $request['expected_temperature_c'],
        environmental_temperature => $request['environmental_temperature'],
        environmental_humidity => $request['environmental_humidity'],

        result => 'PENDING'

    );

    $wpdb->insert("wp_coe_thermometer_calculations", $testDetails);
    $CCCID = $wpdb->insert_id;

    $intervals = array(1, 2, 3, 4);

    $averagePValue = array();
    $errorValues = array();


    foreach ($intervals as $interval) {
        $intervalArray = array(
                'thermometer_calculation_id' => $CCCID,
                'reading_id' => $interval,
                'reading_a' => $request['reading_1_'.$interval],
                'reading_b' => $request['reading_2_'.$interval],
                'reading_c' => $request['reading_3_'.$interval],
                'created_by' => $currentUser->ID
            );
        $wpdb->insert("wp_coe_thermometer_calculation_readings", $intervalArray);

        $errorValues[1][$interval] = $request['reading_1_'.$interval] - $request['expected_temperature_a'];
        $errorValues[2][$interval] = $request['reading_2_'.$interval] - $request['expected_temperature_b'];
        $errorValues[3][$interval] = $request['reading_3_'.$interval] - $request['expected_temperature_c'];
    }

    //Calculate uncertainity
    $divisor = 2;

    $averageError[1] = pow(array_sum($errorValues[1])/count($errorValues[1])/$divisor, 2);
    $averageError[2] = pow(array_sum($errorValues[2])/count($errorValues[2])/$divisor, 2);
    $averageError[3] = pow(array_sum($errorValues[3])/count($errorValues[3])/$divisor, 2);

    $variance[1] = pow((max($errorValues[1]) - min($errorValues[1]))/$divisor, 2);
    $variance[2] = pow((max($errorValues[2]) - min($errorValues[2]))/$divisor, 2);
    $variance[3] = pow((max($errorValues[3]) - min($errorValues[3]))/$divisor, 2);

    $homogeneity = 0;

    $repeatability[1] = pow(sd($errorValues[1])/sqrt(count($errorValues[1]))/$divisor, 2);
    $repeatability[2] = pow(sd($errorValues[2])/sqrt(count($errorValues[2]))/$divisor, 2);
    $repeatability[3] = pow(sd($errorValues[3])/sqrt(count($errorValues[3]))/$divisor, 2);

    $UCStandard = pow($testDetails['uncertainity_of_standard']/sqrt(3), 2);
    $resn = pow($testDetails['resolution_of_standard']/$divisor/sqrt(3), 2);
    
    $uncertainity[1] = sqrt($averageError[1] + $variance[1] + $homogeneity  + $repeatability[1] + $UCStandard + $resn);
    $uncertainity[2] = sqrt($averageError[2] + $variance[2] + $homogeneity  + $repeatability[2] + $UCStandard + $resn);
    $uncertainity[3] = sqrt($averageError[3] + $variance[3] + $homogeneity  + $repeatability[3] + $UCStandard + $resn);

    // $wpdb->update("wp_coe_thermometer_calculations", ['uncertainity' => $uncertainity], ['id' => $CCCID]);

    return true;
}

function updateThermometerRecordings($request){
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
        expected_temperature_a => $request['expected_temperature_a'],
        expected_temperature_b => $request['expected_temperature_b'],
        expected_temperature_c => $request['expected_temperature_c'],
        environmental_temperature => $request['environmental_temperature'],
        environmental_humidity => $request['environmental_humidity'],

        result => 'PENDING'

    );

    $wpdb->update("wp_coe_thermometer_calculations", $testDetails, ['id' => $calculationID]);

    $intervals = array(1, 2, 3, 4);
    $now = date("Y-m-d H:i:s");

    foreach ($intervals as $interval) {
        $results = $wpdb->get_results("SELECT id FROM wp_coe_thermometer_calculation_readings WHERE thermometer_calculation_id = $calculationID AND reading_id = $interval", ARRAY_A);

        if (count($results > 0)) {
            $intervalArray = array(
                'reading_a' => $request['reading_1_'.$interval],
                'reading_b' => $request['reading_2_'.$interval],
                'reading_c' => $request['reading_3_'.$interval],
                'updated_at' => $now
            );

            $wpdb->update("wp_coe_thermometer_calculation_readings", $intervalArray, ['id' => $results[0]['id']]);
        }else{
            $intervalArray = array(
                'reading_a' => $request['reading_1_'.$interval],
                'reading_b' => $request['reading_2_'.$interval],
                'reading_c' => $request['reading_3_'.$interval],
                'thermometer_calculation_id' => $calculationID,
                'reading_id' => $interval
            );

            $wpdb->insert("wp_coe_thermometer_calculation_readings", $intervalArray);
        }
    }

    return true;
}

function getCOEThermometerCertificatesList(){
    global $wpdb;

    $query = "SELECT wp_coe_thermometer_calculations.id, 
                wp_coe_thermometer_calculations.date_performed, 
                wp_coe_clients.name AS client_name, 
                wp_coe_equipment.name AS equipment_name, 
                wp_coe_thermometer_calculations.equipment_serial_number, 
                wp_coe_thermometer_calculations.result 
            FROM wp_coe_thermometer_calculations 
            INNER JOIN wp_coe_equipment 
                ON wp_coe_thermometer_calculations.equipment_id = wp_coe_equipment.id
            INNER JOIN wp_coe_clients ON wp_coe_thermometer_calculations.client_id = wp_coe_clients.id;";

    return $wpdb->get_results($query);
}

function getCOEThermometerCertificate($certificateID){
    global $wpdb;

    $query = "SELECT wp_coe_thermometer_calculations.*,
                wp_coe_clients.name AS client_name,
                wp_coe_client_contacts.name AS client_contact_name,
                wp_coe_client_contacts.email AS client_contact_email,
                wp_coe_equipment.name AS equipment_name,
                wp_coe_manufacturers.name AS manufacturer_name,
                DATE_FORMAT(DATE_ADD(wp_coe_thermometer_calculations.date_performed, INTERVAL 1 YEAR),'%M %Y') AS certificate_validity
            FROM wp_coe_thermometer_calculations 
            LEFT JOIN wp_coe_clients 
                ON wp_coe_thermometer_calculations.client_id = wp_coe_clients.id
            LEFT JOIN wp_coe_client_contacts 
                ON wp_coe_thermometer_calculations.client_contact_id = wp_coe_client_contacts.id
            LEFT JOIN wp_coe_equipment 
                ON wp_coe_thermometer_calculations.equipment_id = wp_coe_equipment.id
            LEFT JOIN wp_coe_manufacturers
                ON wp_coe_thermometer_calculations.manufacturer_id = wp_coe_manufacturers.id
            WHERE wp_coe_thermometer_calculations.id = $certificateID;";

    $result = $wpdb->get_row($query);
    
    $subQuery = "SELECT * FROM wp_coe_thermometer_calculation_readings WHERE thermometer_calculation_id = ".$result->id;

    $result->readings = $wpdb->get_results($subQuery, ARRAY_A);

    // Creators, verifiers and approvers
    $subQuery = "SELECT display_name FROM wp_users WHERE ID = ".$result->created_by;

    $result->creator = $wpdb->get_row($subQuery, ARRAY_A);

    $subQuery = "SELECT display_name FROM wp_users WHERE ID = ".$result->verified_by;

    $result->verifier = $wpdb->get_row($subQuery, ARRAY_A);

    $subQuery = "SELECT display_name FROM wp_users WHERE ID = ".$result->approved_by;

    $result->approver = $wpdb->get_row($subQuery, ARRAY_A);

    // Standard Test Equipment Info: Name and manufacturer
    $subQuery = "SELECT name FROM wp_coe_standard_test_equipment WHERE id = ".$result->standard_test_equipment_id;

    $result->ste_equipment = $wpdb->get_row($subQuery, ARRAY_A);

    $subQuery = "SELECT name FROM wp_coe_manufacturers WHERE id = ".$result->standard_test_equipment_manufacturer_id;

    $result->ste_manufacturer = $wpdb->get_row($subQuery, ARRAY_A);

    return $result;
}

function verifyThermometerCertificate($data){
    global $wpdb;

    $currentUser = wp_get_current_user();
    $_APPROVER = $currentUser->ID;
    $_VERIFIER = $currentUser->ID;

    $datetime = date("Y-m-d H:i:s", time() + (3*60*60)); //UTC+3
    $year = substr($datetime, 0, 4);

    $subQuery = "SELECT COUNT(id) hits FROM wp_coe_thermometer_calculations WHERE verified_at LIKE '$year%'";

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

    $wpdb->update("wp_coe_thermometer_calculations", $verifierData, ['id' => $data['ccc_id']]);
}

function hasRole($role){
    global $wpdb;

    $roles = ['CALIBRATOR' => 1, 'REVIEWER' => 2, 'APPROVER' => 3];
    $currentUser = wp_get_current_user();

    $query = "SELECT COUNT(*) hits FROM wp_coe_user_roles WHERE user_id = ".$currentUser->ID." AND role_id = ".$roles[$role];
    $result = $wpdb->get_row($query, ARRAY_A);

    return intval($result['hits']) == 1;
}

/*
 * Source: http://php.net/manual/en/function.stats-standard-deviation.php
 */
function sd_square($x, $mean) { return pow($x - $mean,2); }

function sd($array) { 
    
    // square root of sum of squares devided by N-1 
    return sqrt(
        array_sum(
            array_map("sd_square", $array, array_fill(0, count($array), (array_sum($array) / count($array))))
            ) / (count($array)-1)
        ); 
}
?>
