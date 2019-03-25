<?php
/*
 * Clients Controller
 *---------------------------------
 */

session_start();

if(!empty($_SESSION['current_coe_user']))$currentUser = $_SESSION['current_coe_user'];
else $currentUser = [];

/* Clients Area Page Values
 * 1 => List
 * 2 => New
 * 3 => View
 */

$COEPageURI['clients'][0] = "views/clients/login.php";
$COEPageURI['clients'][2] = "views/clients/register.php";
$COEPageURI['clients'][3] = "views/clients/view.php";
$COEPageURI['clients'][4] = "views/service-requests/list.php";
$COEPageURI['clients'][5] = "views/service-requests/new.php";
$COEPageURI['clients'][6] = "views/service-requests/view.php";

$pageURL = get_site_url().'/clients/';

// Navigation based on the value of $_REQUEST['api_code']

$APICode = empty( $_REQUEST['api_code'] ) ? 0 : $_REQUEST['api_code'];
if(!empty($_SESSION['current_coe_user']) && $APICode == 0) $APICode = 4;

switch ($APICode) {
    case '0': //Login page
        $COEPage = 0;
        break;
    case '1': // Logout Action
        $COEPage = 0;
        $currentUser = [];
        session_unset();
        session_destroy();
        break;
    case '2':
        echo json_encode(getCOEManufacturers());
        exit();
        break;
    case '3':
        echo json_encode(getCOEEquipment());
        exit();
        break;
    case '4':
        $serviceRequests = getServiceRequests($currentUser->client_id);
        $COEPage = 4;
        break;
    case '600': //Search for facility by MFL Code
        echo json_encode(getCOEFacility($_REQUEST['search_text']));
        exit();
        break;
    case '601': //Add new Facility contact
        $newContact = addCOEClientContact($_REQUEST['facility_id'], $_REQUEST['contact_name'], 
            $_REQUEST['contact_email'], $_REQUEST['contact_phone'], $_REQUEST['password']);
        echo json_encode($newContact);
        exit();
        break;
    case '7': //Registration page
        $COEPage = 2;
        break;
    case '8': //Login Action
        $authenticated = authenticateClient($_REQUEST['contact_email'], $_REQUEST['password']);
        if($authenticated){
            $currentUser = $_SESSION['current_coe_user'];
            $serviceRequests = getServiceRequests($currentUser->client_id);
            $COEPage = 4;
        }else{
            $infoMessage = "<span class='text-danger' style='font-size:0.9em;font-weight:bold;'>";
            $infoMessage .= "Login failed!</span>";
            $COEPage = 0;
        }
        break;
    case '9': //New service requests page
        $manufacturers = getCOEManufacturers();
        $equipments = getCOEEquipment();
        $COEPage = 5;
        break;
    case '10': //Save service request
        echo addServiceRequest($_REQUEST);
        exit();
        break;
    case '11':
        $serviceRequest = getServiceRequest($_REQUEST['service_request_id']);
        $COEPage = 6;
        break;
}

function authenticateClient($email, $password){
    global $wpdb;
    
    $query = "SELECT cc.id, cc.client_id, cc.name, cc.email, cc.phone, cc.email, cc.phone, cc.can_login, f.code, f.name AS facility_name FROM wp_coe_client_contacts cc LEFT JOIN wp_coe_facilities f ON cc.client_id = f.id WHERE cc.email = '$email' AND cc.password = md5('$password');";

    $result = $wpdb->get_row($query, ARRAY_A);

    if(count($result) > 0){
        $_SESSION['current_coe_user'] = (object)$result;
        return true;
    }else{
        $currentUser = [];
        session_unset();
        session_destroy();
        return false;
    }
}

function getServiceRequests($facilityID){
    log2File("getServiceRequests");
    log2File("facilityID: $facilityID");
    global $wpdb;
    
    $query = "SELECT sr.id AS service_request_id, m.name AS manufacturer_name, e.name AS equipment_name, sr.equipment_model, sr.equipment_serial_number, sr.equipment_inventory_number, srs.status_text AS status, srs.done_at AS request_date, cc.name AS requested_by, sr.calibration_interval FROM wp_coe_service_requests sr LEFT JOIN wp_coe_service_request_status srs ON sr.id=srs.service_request_id LEFT JOIN wp_coe_client_contacts cc ON srs.done_by = cc.id LEFT JOIN wp_coe_equipment e ON sr.equipment_id = e.id LEFT JOIN wp_coe_manufacturers m ON sr.manufacturer_id = m.id WHERE status='created' AND sr.facility_id = $facilityID;";
    log2File($query);

    return $wpdb->get_results($query, ARRAY_A);
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

    log2File($query);

    $serviceRequestStatus = $wpdb->get_results($query, ARRAY_A);
    $serviceRequest['stati'] = $serviceRequestStatus;

    $query = "SELECT comment FROM wp_coe_service_request_rejection_reasons WHERE service_request_id = $serviceRequestID";
    $serviceRequest['rejection_reason'] = $wpdb->get_row($query, ARRAY_A);

    return $serviceRequest;
}

function addServiceRequest($request){
    log2File("addServiceRequest");
    global $currentUser, $wpdb;

    $serviceRequest = ["facility_id" => $currentUser->client_id, "equipment_id" => $request["equipment"], "manufacturer_id" => $request["manufacturer"], "equipment_model" => $request["model"], "equipment_serial_number" => $request["serial_number"], "equipment_inventory_number" => $request["inventory_number"], "calibration_interval" => $request["calibration_interval"], "comments" => $request["comments"]];
    log2File(json_encode($request));
    log2File(json_encode($serviceRequest));

    $query = "SELECT sr.id AS service_request_id, srs.id AS service_request_status_id FROM wp_coe_service_requests sr INNER JOIN wp_coe_service_request_status srs ON sr.id=srs.service_request_id LEFT JOIN wp_coe_client_contacts cc ON srs.done_by = cc.id LEFT JOIN wp_coe_equipment e ON sr.equipment_id = e.id LEFT JOIN wp_coe_manufacturers m ON sr.manufacturer_id = m.id WHERE srs.status='created' AND sr.facility_id = {$serviceRequest['facility_id']} AND sr.equipment_serial_number = '{$serviceRequest['equipment_serial_number']}' AND sr.equipment_inventory_number = '{$serviceRequest['equipment_inventory_number']}';";
    log2File($query);

    $previousRequestSearch = $wpdb->get_row($query, ARRAY_A);
    
    $rowsInserted = 0;

    if (count($previousRequestSearch) == 0) {
        $rowsInserted = $wpdb->insert("wp_coe_service_requests", $serviceRequest);

        if($rowsInserted > 0){
            $serviceRequestID = $wpdb->insert_id;
            $serviceRequestStatus = ["service_request_id" => $serviceRequestID, "status" => "created", "status_text" => "Initiated", "done_by" => $currentUser->id];

            $wpdb->insert("wp_coe_service_request_status", $serviceRequestStatus);
        }
    }

    return $rowsInserted;
}
?>
