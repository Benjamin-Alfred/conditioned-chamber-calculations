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

function addConditionedChamberRecordings($request){
    global $wpdb;

    $testDetails = array(
        client_name => $request['client_name'],
        submission_number => $request['submission_number'],
        certificate_number => $request['certificate_number'],
        date_performed => 'now()',
        manufacturer_id => $request['manufacturer'],
        equipment_id => $request['equipment'],
        equipment_model => $request['model'],
        equipment_serial_number => $request['serial_number'],
        expected_temperature => $request['expected_temperature']
    );

    $wpdb->insert("wp_coe_conditioned_chamber_calculations", $testDetails);
    $CCCID = $wpdb->insert_id;
echo "<!-- CCCID: $CCCID -->";

    $intervals = array(0, 6, 12, 18, 24, 30, 36, 42, 48, 54, 60);

    foreach ($intervals as $interval) {
        $intervalArray = array(
                'conditioned_chamber_calculation_id' => $CCCID,
                'reading_time' => $interval,
                'reading_a' => $request['p_1_'.$interval],
                'reading_b' => $request['p_2_'.$interval],
                'reading_c' => $request['p_3_'.$interval],
            );
        $wpdb->insert("wp_coe_conditioned_chamber_calculation_readings", $intervalArray);
    }

    //Calculate uncertainity

    //redirect to listing page

    return true;
}

function getCOEConditionedChamberCertificates(){
    global $wpdb;

    $query = "SELECT wp_coe_conditioned_chamber_calculations.id, 
                wp_coe_conditioned_chamber_calculations.date_performed, 
                wp_coe_conditioned_chamber_calculations.client_name, 
                wp_coe_equipment.name AS equipment_name, 
                wp_coe_conditioned_chamber_calculations.equipment_serial_number, 
                wp_coe_conditioned_chamber_calculations.uncertainity 
            FROM wp_coe_conditioned_chamber_calculations 
            INNER JOIN wp_coe_equipment 
            ON wp_coe_conditioned_chamber_calculations.equipment_id = wp_coe_equipment.id;";

    return $wpdb->get_results($query);
}
?>
