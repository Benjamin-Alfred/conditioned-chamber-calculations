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
$COEPageURI['clients'][1] = "views/clients/list.php";
$COEPageURI['clients'][2] = "views/clients/new.php";
$COEPageURI['clients'][3] = "views/clients/show.php";
$COEPageURI['clients'][4] = "views/clients/service-requests.php";
$COEPageURI['clients'][5] = "views/clients/new-service-request.php";


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
    case '5': //Add new Facility contact
        $newContact = addCOEClientContact($_REQUEST['facility_id'], $_REQUEST['contact_name'], 
            $_REQUEST['contact_email'], $_REQUEST['contact_phone'], $_REQUEST['password']);
        echo json_encode($newContact);
        exit();
        break;
    case '6': //Search for facility by MFL Code
        echo json_encode(getCOEFacility($_REQUEST['search_text']));
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

function getCurrentUserDetails(){
    error_log("getCurrentUserDetails");
    error_log(json_encode($client));
    return $client[0];
}

function getServiceRequests($facilityID){
    error_log("getServiceRequests");
    error_log("facilityID: $facilityID");
    global $wpdb;
    
    $query = "SELECT sr.id AS service_request_id, m.name AS manufacturer_name, e.name AS equipment_name, sr.equipment_model, sr.equipment_serial_number, sr.equipment_inventory_number, srs.status_text AS status, srs.done_at AS request_date, cc.name AS requested_by FROM wp_coe_service_requests sr LEFT JOIN wp_coe_service_request_status srs ON sr.id=srs.service_request_id LEFT JOIN wp_coe_client_contacts cc ON srs.done_by = cc.id LEFT JOIN wp_coe_equipment e ON sr.equipment_id = e.id LEFT JOIN wp_coe_manufacturers m ON sr.manufacturer_id = m.id WHERE status='created' AND sr.facility_id = $facilityID;";
    error_log($query);

    return $wpdb->get_results($query, ARRAY_A);
}

function addServiceRequest($request){
    global $currentUser, $wpdb;
    error_log("addServiceRequest");
    error_log(json_encode($currentUser));
    error_log(json_encode($request));
    $serviceRequest = ["facility_id" => $currentUser->client_id, "equipment_id" => $request["equipment"], "manufacturer_id" => $request["manufacturer"], "equipment_model" => $request["model"], "equipment_serial_number" => $request["serial_number"], "equipment_inventory_number" => $request["inventory_number"], "comments" => $request["comments"]];
    error_log(json_encode($serviceRequest));
    $rowsInserted = $wpdb->insert("wp_coe_service_requests", $serviceRequest);

    if($rowsInserted > 0){
        $serviceRequestID = $wpdb->insert_id;
        $serviceRequestStatus = ["service_request_id" => $serviceRequestID, "status" => "created", "status_text" => "Initiated", "done_by" => $currentUser->id];
        $rowsInserted = $wpdb->insert("wp_coe_service_request_status", $serviceRequestStatus);
    }

    return $rowsInserted;
}
?>
