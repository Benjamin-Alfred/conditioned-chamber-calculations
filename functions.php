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
        get_stylesheet_directory_uri() . '/jquery-ui-1.12.1.custom/jquery-ui.min.css',
        array($parent_style, 'child-style')
    );

    wp_enqueue_style(
        'bootstrap',
        get_stylesheet_directory_uri() . '/bootstrap/css/bootstrap.min.css',
        array($parent_style, 'child-style', 'jquery-ui')
    );

    wp_enqueue_script(
        'jquery-ui',
        get_stylesheet_directory_uri() . '/jquery-ui-1.12.1.custom/jquery-ui.min.js',
        array('jquery')
    );

    wp_enqueue_script(
        'bootstrap',
        get_stylesheet_directory_uri() . '/bootstrap/js/bootstrap.min.js',
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

    $testDetails = array(
        client_id => $request['client'],
        client_contact_id => $request['client_contact_id'],

        date_performed => 'now()',
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

        expected_temperature => $request['expected_temperature'],
        environmental_temperature => $request['environmental_temperature'],
        environmental_humidity => $request['environmental_humidity']

    );

    $wpdb->insert("wp_coe_conditioned_chamber_calculations", $testDetails);
    $CCCID = $wpdb->insert_id;

    $intervals = array(0, 6, 12, 18, 24, 30, 36, 42, 48, 54, 60);

    $averageP = array();
    $error = array();

    foreach ($intervals as $interval) {
        $intervalArray = array(
                'conditioned_chamber_calculation_id' => $CCCID,
                'reading_time' => $interval,
                'reading_a' => $request['p_1_'.$interval],
                'reading_b' => $request['p_2_'.$interval],
                'reading_c' => $request['p_3_'.$interval],
            );
        $wpdb->insert("wp_coe_conditioned_chamber_calculation_readings", $intervalArray);

        $averageP[$interval] = ($request['p_1_'.$interval] + $request['p_2_'.$interval] + $request['p_3_'.$interval])/3;
        $error[$interval] = $averageP[interval] - $request['expected_temperature'];
    }

    //Calculate uncertainity

    //redirect to listing page

    return true;
}

function getCOEConditionedChamberCertificatesList(){
    global $wpdb;

    $query = "SELECT wp_coe_conditioned_chamber_calculations.id, 
                wp_coe_conditioned_chamber_calculations.date_performed, 
                wp_coe_clients.name AS client_name, 
                wp_coe_equipment.name AS equipment_name, 
                wp_coe_conditioned_chamber_calculations.equipment_serial_number, 
                wp_coe_conditioned_chamber_calculations.uncertainity 
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
    $subQuery = "SELECT name FROM wp_coe_equipment WHERE id = ".$result->standard_test_equipment_id;

    $result->ste_equipment = $wpdb->get_row($subQuery, ARRAY_A);

    $subQuery = "SELECT name FROM wp_coe_manufacturers WHERE id = ".$result->standard_test_equipment_manufacturer_id;

    $result->ste_manufacturer = $wpdb->get_row($subQuery, ARRAY_A);

    return $result;
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
