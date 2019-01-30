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

    wp_enqueue_style(
        'datatables',
        get_stylesheet_directory_uri() . '/js/datatables.net/css/jquery.dataTables.min.css',
        array($parent_style, 'child-style', 'bootstrap')
    );

    wp_enqueue_style(
        'open-iconic',
        get_stylesheet_directory_uri() . '/i/open-iconic/font/css/open-iconic.css',
        array($parent_style, 'child-style', 'bootstrap')
    );

    wp_enqueue_style(
        'open-iconic-bootstrap',
        get_stylesheet_directory_uri() . '/i/open-iconic/font/css/open-iconic-bootstrap.css',
        array($parent_style, 'child-style', 'bootstrap')
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

    wp_enqueue_script(
        'datatables',
        get_stylesheet_directory_uri() . '/js/datatables.net/js/jquery.dataTables.min.js',
        array('jquery')
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

function addCOEClientContact($clientID, $name, $email, $phone, $password = ""){
    global $wpdb;
    $inputArray = [];
    $result = false;
    if ($clientID !== false && $name !== false && $email !== false) {
        $inputArray["client_id"] = $clientID;
        $inputArray["name"] = trim($name);
        $inputArray["email"] = trim($email);
        $inputArray["phone"] = trim($phone);
        if($password !== false) $inputArray["password"] = md5(trim($password));
        $result = $wpdb->insert("wp_coe_client_contacts", $inputArray);
    }
    return $result;
}

function getCOEClientContacts(){
    global $wpdb;
    
    return $wpdb->get_results("SELECT * FROM wp_coe_client_contacts ORDER BY name;");
}

function getCOEFacility($facilityCode){
    global $wpdb;
    $query = "SELECT f.id, f.code, f.name, s.name AS sub_county, c.name AS county FROM wp_coe_facilities f ";
    $query .= "INNER JOIN wp_coe_sub_counties s ON f.sub_county_id = s.id ";
    $query .= "INNER JOIN wp_coe_counties c ON s.county_id = c.id WHERE code = $facilityCode;";
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

function hasRole($role){
    global $wpdb;

    $roles = ['CALIBRATOR' => 1, 'REVIEWER' => 2, 'APPROVER' => 3, 'USER_ADMIN' => 4];
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

/*
 * Log to file
 */
function log2File($logText, $logFile = "coesite.log"){
    $now = new DateTime("now", new DateTimeZone('Africa/Nairobi'));
    error_log("{$now->format('Y-m-d G:i:s')} $logText\n", 3, $logFile);
}

?>
