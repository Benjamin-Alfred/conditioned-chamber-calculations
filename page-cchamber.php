<?php
/**
 * Template Name: Conditioned Chamber Calculations
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 * @version 1.0
 */

/*
 * COE Page Values
 * 1 => List Conditioned Chamber Items
 * 2 => Calibrate Conditioned Chamber Item
 * 3 => View Calibrated Conditioned Chamber Item Report
 */
$COEPage = 1; 
if(!empty( $_REQUEST['calculate_conditioned_chamber_item'] )) $COEPage = 2;
else if(!empty( $_REQUEST['show_calibration_certificate'] )) $COEPage = 3;


if ($COEPage == 1) {
    $certicates = getCOEConditionedChamberCertificatesList();
}else if($COEPage == 2){

    $validated = empty( $_REQUEST['form_ready_for_submit'] ) ? false : true;

    if ($validated) {
        $response = addConditionedChamberRecordings($_REQUEST);

        if($response){
            $COEPage = 1;
            $certicates = getCOEConditionedChamberCertificatesList();
        }
    }

    $newManufacturer = empty( $_REQUEST['manufacturer_name'] ) ? false : $_REQUEST['manufacturer_name'];
    addCOEManufacturer($newManufacturer);

    $newEquipment = empty( $_REQUEST['equipment_name'] ) ? false : $_REQUEST['equipment_name'];
    addCOEEquipment($newEquipment);

    $newClient = empty( $_REQUEST['client_name'] ) ? false : $_REQUEST['client_name'];
    addCOEClient($newClient);
    
    $clientID = empty( $_REQUEST['client_id'] ) ? false : $_REQUEST['client_id'];
    $newClientContactName = empty( $_REQUEST['contact_name'] ) ? false : $_REQUEST['contact_name'];
    $newClientContactEmail = empty( $_REQUEST['contact_email'] ) ? false : $_REQUEST['contact_email'];
    $newClientContactPhone = empty( $_REQUEST['contact_phone'] ) ? '' : $_REQUEST['contact_phone'];

    addCOEClientContact($clientID, $newClientContactName, $newClientContactEmail, $newClientContactPhone);

    $manufacturers = getCOEManufacturers();
    $equipments = getCOEEquipment();
    $clients = getCOEClients();
    $clientContacts = getCOEClientContacts();

}else if($COEPage == 3){
    $requestedCertificate = $_REQUEST['ccc_id'];
    $certification = getCOECCCertificate($requestedCertificate);
}

get_header();

?>

<div class="wrap">
    <div id="primary" class="content-area">
        <main id="main" class="site-main" role="main">
            <?php
                if ($COEPage == 1) {
            ?>
            <!-- List Conditioned Chamber Items -->
                <h3>Conditioned Chamber Certifications</h3>

                <form name="ccc_post" method="POST" action="<?php echo get_site_url(); ?>/conditioned-chamber-calculations/">
                    <input type="hidden" name="calculate_conditioned_chamber_item" value="false" />
                    <button class="btn btn-sm btn-outline-dark" onclick="document.ccc_post.submit()">
                        <strong><span aria-hidden="true">&plus;</span> Add New </strong>
                    </button>
                </form>
                <div class="table-responsive">
                    <table class="table table-striped table-sm">
                        <thead>
                            <tr>
                                <th scope="col">Date</th>
                                <th scope="col">Client</th>
                                <th scope="col">Equipment</th>
                                <th scope="col">Serial Number</th>
                                <th scope="col">Result</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                foreach ($certicates as $certicate) {
                                    echo "<tr><td>$certicate->date_performed</td>";
                                    echo "<td>$certicate->client_name</td>";
                                    echo "<td>$certicate->equipment_name</td>";
                                    echo "<td>$certicate->equipment_serial_number</td>";
                                    echo "<td>".($certicate->uncertainity?"<span class='badge badge-pill badge-success'>PASS</span>":"<span class='badge badge-pill badge-danger'>FAIL</span>")."</td>";
                            ?>
                                    <td><form name="ccc_cert" method="POST" action="<?php echo get_site_url(); ?>/conditioned-chamber-calculations/">
                                        <input type="hidden" name="show_calibration_certificate" value="false" />
                                        <input type="hidden" name="ccc_id" value="<?php echo $certicate->id; ?>" />
                                        <button class="btn btn-sm btn-outline-dark" onclick="document.ccc_cert.submit()">View</button>
                                    </form>
                                    </td></tr>
                            <?php
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
            <!-- / List Conditioned Chamber Items -->
            <?php
                }else if ($COEPage == 2){
            ?>
            <!-- Conditioned Chamber Calculations -->

                <form name="ccc_back" method="POST" action="<?php echo get_site_url(); ?>/conditioned-chamber-calculations/">
                    <button class="btn btn-sm btn-outline-dark float-right" onclick="document.ccc_back.submit">Back</button>
                </form>
                <h3>Calibration of Conditioned Chamber</h3>
                <form name="conditioned_chamber_calculations" method="POST" action="<?php echo get_site_url(); ?>/conditioned-chamber-calculations/">
                    <input type="hidden" name="form_ready_for_submit" value="false" />
                    <input type="hidden" name="calculate_conditioned_chamber_item" value="false" />

                    <div class="card">
                        <div class="card-body">
                        <div class="form-group row">
                            <label for="model" class="col-form-label col-sm-4">Date Performed</label>
                            <input type="text" class="form-control form-control-sm col-sm-8" id="date_performed" name="date_performed" required />
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Client Details</h5>
                            <div class="form-group row">
                                <label for="client" class="col-form-label col-sm-4">Name</label>
                                <select class="form-control form-control-sm col-sm-7" id="client_contact_id" name="client_contact_id" required >
                                    <?php
                                        foreach ($clients as $client) {
                                            echo "<option value='".$client->id."'>".$client->name."</option>";
                                        }
                                    ?>
                                </select>
                                <div class="col-sm-1">
                                    <button type="button" class="btn btn-sm btn-outline-dark" data-toggle="modal" data-target="#addClientModal">
                                        <strong><span aria-hidden="true">&plus;</span></strong>
                                    </button>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="client_contact" class="col-form-label col-sm-4">Contact Person</label>
                                <select class="form-control form-control-sm col-sm-7" id="client_contact" name="client_contact" required >
                                    <?php
                                        foreach ($clientContacts as $contact) {
                                            echo "<option value='".$contact->id."'>".$contact->name."</option>";
                                        }
                                    ?>
                                </select>
                                <div class="col-sm-1">
                                    <button type="button" class="btn btn-sm btn-outline-dark" data-toggle="modal" data-target="#addClientContactModal">
                                        <strong><span aria-hidden="true">&plus;</span></strong>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Equipment Details</h5>
                            <div class="form-group row">
                                <label for="manufacturer" class="col-form-label col-sm-4">Manufacturer</label>
                                <select class="form-control form-control-sm col-sm-7" id="manufacturer" name="manufacturer" required >
                                    <?php
                                        foreach ($manufacturers as $manufacturer) {
                                            echo "<option value='".$manufacturer->id."'>".$manufacturer->name."</option>";
                                        }
                                    ?>
                                </select>
                                <div class="col-sm-1">
                                    <button type="button" class="btn btn-sm btn-outline-dark" data-toggle="modal" data-target="#addManufacturerModal">
                                        <strong><span aria-hidden="true">&plus;</span></strong>
                                    </button>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="equipment" class="col-form-label col-sm-4">Equipment Name</label>
                                <select class="form-control form-control-sm col-sm-7" id="equipment" name="equipment" required >
                                    <?php
                                        foreach ($equipments as $equipment) {
                                            echo "<option value='".$equipment->id."'>".$equipment->name."</option>";
                                        }
                                    ?>
                                </select>
                                <div class="col-sm-1">
                                    <button type="button" class="btn btn-sm btn-outline-dark" data-toggle="modal" data-target="#addEquipmentModal">
                                        <strong><span aria-hidden="true">&plus;</span></strong>
                                    </button>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="model" class="col-form-label col-sm-4">Model</label>
                                <input type="text" class="form-control form-control-sm col-sm-8" id="model" name="model" required />
                            </div>
                            <div class="form-group row">
                                <label for="serial_number" class="col-form-label col-sm-4">Serial Number</label>
                                <input type="text" class="form-control form-control-sm col-sm-8" id="serial_number" name="serial_number" required />
                            </div>
                            <div class="form-group row">
                                <label for="submission_number" class="col-form-label col-sm-4">Inventory Number</label>
                                <input type="text" class="form-control form-control-sm col-sm-8" id="submission_number" name="submission_number" />
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Standard Test Equipment Used</h5>
                            <div class="form-group row">
                                <label for="manufacturer" class="col-form-label col-sm-4">Manufacturer</label>
                                <select class="form-control form-control-sm col-sm-7" id="ste_manufacturer" name="ste_manufacturer" required >
                                    <?php
                                        foreach ($manufacturers as $manufacturer) {
                                            echo "<option value='".$manufacturer->id."'>".$manufacturer->name."</option>";
                                        }
                                    ?>
                                </select>
                                <div class="col-sm-1">
                                    <button type="button" class="btn btn-sm btn-outline-dark" data-toggle="modal" data-target="#addManufacturerModal">
                                        <strong><span aria-hidden="true">&plus;</span></strong>
                                    </button>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="equipment" class="col-form-label col-sm-4">Description</label>
                                <select class="form-control form-control-sm col-sm-7" id="ste_equipment" name="ste_equipment" required >
                                    <?php
                                        foreach ($equipments as $equipment) {
                                            echo "<option value='".$equipment->id."'>".$equipment->name."</option>";
                                        }
                                    ?>
                                </select>
                                <div class="col-sm-1">
                                    <button type="button" class="btn btn-sm btn-outline-dark" data-toggle="modal" data-target="#addEquipmentModal">
                                        <strong><span aria-hidden="true">&plus;</span></strong>
                                    </button>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="model" class="col-form-label col-sm-4">Model</label>
                                <input type="text" class="form-control form-control-sm col-sm-8" id="ste_model" name="ste_model" required />
                            </div>
                            <div class="form-group row">
                                <label for="serial_number" class="col-form-label col-sm-4">Serial Number</label>
                                <input type="text" class="form-control form-control-sm col-sm-8" id="ste_serial_number" name="ste_serial_number" required />
                            </div>
                            <div class="form-group row">
                                <label for="ste_certificate_number" class="col-form-label col-sm-4">Certificate Number</label>
                                <input type="text" class="form-control form-control-sm col-sm-8" id="ste_certificate_number" name="ste_certificate_number" required />
                            </div>
                            <div class="form-group row">
                                <label for="ste_sticker_number" class="col-form-label col-sm-4">Sticker Number</label>
                                <input type="text" class="form-control form-control-sm col-sm-8" id="ste_sticker_number" name="ste_sticker_number" />
                            </div>
                        </div>
                    </div>
                    <!-- TODO: Generate Sequential xxx plus YY year -->
                    <!-- <input type="hidden" id="certificate_number" name="certificate_number" value="COE/CC/YY/xxxxx" /> -->
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Environmental Conditions</h5>
                            <div class="form-group row">
                                <label for="environmental_temperature" class="col-form-label col-sm-5">Temperature</label>
                                <input type="number" class="form-control form-control-sm col-sm-7" id="environmental_temperature" name="environmental_temperature" title="" required />
                            </div>
                            <div class="form-group row">
                                <label for="environmental_humidity" class="col-form-label col-sm-5">Humidity</label>
                                <input type="number" class="form-control form-control-sm col-sm-7" id="environmental_humidity" name="environmental_humidity" title="" required />
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group row">
                                <label for="expected_temperature" class="col-form-label col-sm-5">Expected/Set Temperature</label>
                                <input type="number" class="form-control form-control-sm col-sm-7" id="expected_temperature" name="expected_temperature" title="" required />
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Readings</h5>
                            <div class="table-responsive">
                                <table class="table table-bordered table-sm">
                                    <thead>
                                        <tr>
                                            <th scope="col" rowspan="2">time (min)</th>
                                            <th colspan="3"><center>Chamber Temperature in °c</center></th>
                                        </tr>
                                        <tr>
                                            <th scope="col">p1</th>
                                            <th scope="col">p2</th>
                                            <th scope="col">p3</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td align="center">0</td>
                                            <td>
                                                <input type="number" class="form-control form-control-sm" id="p_1_0" name="p_1_0" title="" required />
                                            </td>
                                            <td>
                                                <input type="number" class="form-control form-control-sm" id="p_2_0" name="p_2_0" title="" required />
                                            </td>
                                            <td>
                                                <input type="number" class="form-control form-control-sm" id="p_3_0" name="p_3_0" title="" required />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="center">6</td>
                                            <td>
                                                <input type="number" class="form-control form-control-sm" id="p_1_6" name="p_1_6" title="" required />
                                            </td>
                                            <td>
                                                <input type="number" class="form-control form-control-sm" id="p_2_6" name="p_2_6" title="" required />
                                            </td>
                                            <td>
                                                <input type="number" class="form-control form-control-sm" id="p_3_6" name="p_3_6" title="" required />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="center">12</td>
                                            <td>
                                                <input type="number" class="form-control form-control-sm" id="p_1_12" name="p_1_12" title="" required />
                                            </td>
                                            <td>
                                                <input type="number" class="form-control form-control-sm" id="p_2_12" name="p_2_12" title="" required />
                                            </td>
                                            <td>
                                                <input type="number" class="form-control form-control-sm" id="p_3_12" name="p_3_12" title="" required />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="center">18</td>
                                            <td>
                                                <input type="number" class="form-control form-control-sm" id="p_1_18" name="p_1_18" title="" required />
                                            </td>
                                            <td>
                                                <input type="number" class="form-control form-control-sm" id="p_2_18" name="p_2_18" title="" required />
                                            </td>
                                            <td>
                                                <input type="number" class="form-control form-control-sm" id="p_3_18" name="p_3_18" title="" required />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="center">24</td>
                                            <td>
                                                <input type="number" class="form-control form-control-sm" id="p_1_24" name="p_1_24" title="" required />
                                            </td>
                                            <td>
                                                <input type="number" class="form-control form-control-sm" id="p_2_24" name="p_2_24" title="" required />
                                            </td>
                                            <td>
                                                <input type="number" class="form-control form-control-sm" id="p_3_24" name="p_3_24" title="" required />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="center">30</td>
                                            <td>
                                                <input type="number" class="form-control form-control-sm" id="p_1_30" name="p_1_30" title="" required />
                                            </td>
                                            <td>
                                                <input type="number" class="form-control form-control-sm" id="p_2_30" name="p_2_30" title="" required />
                                            </td>
                                            <td>
                                                <input type="number" class="form-control form-control-sm" id="p_3_30" name="p_3_30" title="" required />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="center">36</td>
                                            <td>
                                                <input type="number" class="form-control form-control-sm" id="p_1_36" name="p_1_36" title="" required />
                                            </td>
                                            <td>
                                                <input type="number" class="form-control form-control-sm" id="p_2_36" name="p_2_36" title="" required />
                                            </td>
                                            <td>
                                                <input type="number" class="form-control form-control-sm" id="p_3_36" name="p_3_36" title="" required />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="center">42</td>
                                            <td>
                                                <input type="number" class="form-control form-control-sm" id="p_1_42" name="p_1_42" title="" required />
                                            </td>
                                            <td>
                                                <input type="number" class="form-control form-control-sm" id="p_2_42" name="p_2_42" title="" required />
                                            </td>
                                            <td>
                                                <input type="number" class="form-control form-control-sm" id="p_3_42" name="p_3_42" title="" required />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="center">48</td>
                                            <td>
                                                <input type="number" class="form-control form-control-sm" id="p_1_48" name="p_1_48" title="" required />
                                            </td>
                                            <td>
                                                <input type="number" class="form-control form-control-sm" id="p_2_48" name="p_2_48" title="" required />
                                            </td>
                                            <td>
                                                <input type="number" class="form-control form-control-sm" id="p_3_48" name="p_3_48" title="" required />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="center">54</td>
                                            <td>
                                                <input type="number" class="form-control form-control-sm" id="p_1_54" name="p_1_54" title="" required />
                                            </td>
                                            <td>
                                                <input type="number" class="form-control form-control-sm" id="p_2_54" name="p_2_54" title="" required />
                                            </td>
                                            <td>
                                                <input type="number" class="form-control form-control-sm" id="p_3_54" name="p_3_54" title="" required />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="center">60</td>
                                            <td>
                                                <input type="number" class="form-control form-control-sm" id="p_1_60" name="p_1_60" title="" required />
                                            </td>
                                            <td>
                                                <input type="number" class="form-control form-control-sm" id="p_2_60" name="p_2_60" title="" required />
                                            </td>
                                            <td>
                                                <input type="number" class="form-control form-control-sm" id="p_3_60" name="p_3_60" title="" required />
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <input type="submit" class="button btn form-control" value="Save" />
                    </div>
                </form>
            <!-- /Conditioned Chamber Calculations -->
            <?php
                }else if ($COEPage == 3){
            ?>
            <!-- Show Calibration Certificate -->
                <div>
                    <form name="ccc_back" method="POST" action="<?php echo get_site_url(); ?>/conditioned-chamber-calculations/" class="d-print-none">
                        <button class="btn btn-sm btn-outline-dark float-right" onclick="document.ccc_back.submit">Back</button>
                    </form><br>
                    <div class="report-header">
                        <div class="row">
                            <div class="nphl-address col-sm-5" style="font-size: 0.65em;">
                                <strong>
                                    NATIONAL PUBLIC HEALTH LABORATORY<br>
                                    EQUIPMENT CALIBRATION CENTER<br>
                                    P.O BOX   20750-00202<br>
                                    NAIROBI, KENYA.<br>
                                </strong>
                                EMAIL: nphls.coe@gmail.com<br>
                                WEBSITE: nphls.co.ke
                            </div>
                            <div class="col-sm-2">
                                <img src="<?php bloginfo('template_url'); ?>-child/coat_of_arms.png">
                            </div>
                        </div>
                        <div class="row">
                            <div style="text-align:center" class="col-sm-12">
                                <strong>CALIBRATION CERTIFICATE</strong>
                            </div>
                        </div>
                    </div>
                    <div class="customer-and-equipment-details" style="font-size: 0.7em">
                        <table class="table table-bordered table-sm">
                            <tr>
                                <td colspan="2" style="text-align:center">
                                    <strong>CUSTOMER DETAILS</strong>
                                </td>
                            </tr>
                            <tr>
                                <td><strong>REQUESTED BY (FACILITY)</strong></td>
                                <td><?php echo $certification->client_name;?></td>
                            </tr>
                            <tr>
                                <td><strong>LABORATORY PERSONNEL</strong></td>
                                <td><?php echo $certification->client_contact_name;?></td>
                            </tr>
                            <tr>
                                <td><strong>EMAIL OF LAB PERSONNEL</strong></td>
                                <td><?php echo $certification->client_contact_email;?></td>
                            </tr>
                            <tr>
                                <td colspan="2" style="text-align:center">
                                    <strong>EQUIPMENT DETAILS</strong>
                                </td>
                            </tr>
                            <tr>
                                <td><strong>EQUIPMENT</strong></td>
                                <td><?php echo $certification->equipment_name; ?></td>
                            </tr>
                            <tr>
                                <td><strong>MANUFACTURER</strong></td>
                                <td><?php echo $certification->manufacturer_name;?></td>
                            </tr>
                            <tr>
                                <td><strong>MODEL</strong></td>
                                <td><?php echo $certification->equipment_model;?></td>
                            </tr>
                            <tr>
                                <td><strong>SERIAL No.</strong></td>
                                <td><?php echo $certification->equipment_serial_number;?></td>
                            </tr>
                            <tr>
                                <td><strong>INVENTORY No.</strong></td>
                                <td><?php echo $certification->submission_number;?></td>
                            </tr>
                        </table>
                    </div>
                    <div class="standard-equipment" style="font-size: 0.75em">
                        <div><strong>1.0 STANDARD TEST EQUIPMENT USED:</strong></div>
                        <div style="margin-left: 30px;margin-bottom: 20px;" class="row">
                            <div class="col-sm-12">
                                <strong>DESCRIPTION:</strong>
                                <?php echo $certification->ste_equipment['name'];?>
                            </div>
                            <div class="col-sm-12">
                                <strong>MANUFACTURER:</strong>
                                <?php echo $certification->ste_manufacturer['name'];?>
                            </div>
                            <div class="col-sm-6">
                                <strong>MODEL:</strong>
                                <?php echo $certification->standard_test_equipment_model;?>
                            </div>
                            <div class="col-sm-6">
                                <strong>SERIAL No:</strong>
                                <?php echo $certification->standard_test_equipment_serial_number;?>
                            </div>
                            <div class="col-sm-6">
                                <strong>CERTIFICATE No:</strong>
                                <?php echo $certification->standard_test_equipment_certificate_number;?>
                            </div>
                            <div class="col-sm-6">
                                <strong>STICKER No:</strong>
                                <?php echo $certification->standard_test_equipment_sticker_number;?>
                            </div>
                        </div>
                    </div>
                    <div class="calibration-procedure" style="font-size: 0.75em">
                        <div><strong>2.0 CALIBRATION PROCEDURE</strong></div>
                        <div style="margin-left: 30px;">
                            <p>The equipment was calibrated as per <strong>NPHL-COE-LTP-SOP-026</strong> procedure
                                for Temperature Calibration measurements.</p>
                            <p>The environmental conditions were recorded during the period of calibration.
                                The temperature was
                                <strong><?php echo $certification->environmental_temperature;?> </strong>⁰C
                                with relative humidity of 
                                <strong><?php echo $certification->environmental_humidity;?></strong> %.
                            </p>
                        </div>
                    </div>
                    <div class="traceability" style="font-size: 0.75em">
                        <div><strong>3.0 TRACEABILITY</strong></div>
                        <div style="margin-left: 30px;">
                            <p>The equipment has been calibrated against reference standards whose calibration
                             is traceable to international or national standards.</p>
                        </div>
                    </div>
                    <div class="validity" style="font-size: 0.75em">
                        <div><strong>4.0 VALIDITY</strong></div>
                        <div style="margin-left: 30px;">
                            <p>This certificate is valid until <strong><?php echo $certification->certificate_validity; ?></strong></p>
                            <table class="table table-sm table-borderless">
                                <tr>
                                    <td style="border-bottom: 1px solid #FFF;">PERFORMED BY</td>
                                    <td style="border-bottom: 1px solid #000;">
                                        <?php echo $certification->creator['display_name']; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="border-bottom: 1px solid #FFF;">REVIEWED BY</td>
                                    <td style="border-bottom: 1px solid #000;">
                                        <?php echo $certification->verifier['display_name']; ?>
                                    </td>
                                    <td style="border-bottom: 1px solid #FFF;text-align: right;">DATE</td>
                                    <td style="border-bottom: 1px solid #000;">
                                        <?php echo substr($certification->verified_at, 0, 10); ?>
                                    </td>
                                    <td style="border-bottom: 1px solid #FFF;text-align: right;">SIGN</td>
                                    <td style="border-bottom: 1px solid #000;"><?php echo "signature"; ?></td>
                                </tr>
                                <tr>
                                    <td style="border-bottom: 1px solid #FFF;">APPROVED BY</td>
                                    <td style="border-bottom: 1px solid #000;">
                                        <?php echo $certification->approver['display_name']; ?>
                                    </td>
                                    <td style="border-bottom: 1px solid #FFF;text-align: right;">DATE</td>
                                    <td style="border-bottom: 1px solid #000;">
                                        <?php echo substr($certification->approved_at, 0, 10); ?>
                                    </td>
                                    <td style="border-bottom: 1px solid #FFF;text-align: right;">SIGN</td>
                                    <td style="border-bottom: 1px solid #000;"><?php echo "signature"; ?></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="results" style="font-size: 0.75em">
                        <div><strong>5.0 TRACEABILITY</strong></div>
                        <div style="margin-left: 30px;">
                            <table class="table table-sm table-bordered">
                                <thead>
                                    <tr>
                                        <th>time/in</th>
                                        <th>set temp(X)</th>
                                        <th>p1</th>
                                        <th>p2</th>
                                        <th>p3</th>
                                        <th>average(P)</th>
                                        <th>error(average-X)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $totals['p1'] = 0;
                                    $totals['p2'] = 0;
                                    $totals['p3'] = 0;

                                    $errorValues = array();

                                    $counter = 0;
                                    $divisor = 2;

                                    foreach ($certification->readings as $reading) {
                                        $average = ($reading['reading_a'] + $reading['reading_b'] + $reading['reading_c'])/3;
                                        $error = $average - $certification->expected_temperature;
                                    ?>
                                        <tr>
                                            <td style="text-align: right;"><?php echo $reading['reading_time'];?></td>
                                            <td style="text-align: center;"><?php echo $certification->expected_temperature;?></td>
                                            <td style="text-align: right;">
                                                <?php echo number_format($reading['reading_a'], 3);?>
                                            </td>
                                            <td style="text-align: right;">
                                                <?php echo number_format($reading['reading_b'], 3);?>
                                            </td>
                                            <td style="text-align: right;">
                                                <?php echo number_format($reading['reading_c'], 3);?>
                                            </td>
                                            <td style="text-align: right;">
                                                <?php echo number_format($average, 3);?>
                                            </td>
                                            <td style="text-align: right;">
                                                <?php echo number_format($error, 3); ?>
                                            </td>
                                        </tr>
                                    <?php
                                        $totals['p1'] += $reading['reading_a'];
                                        $totals['p2'] += $reading['reading_b'];
                                        $totals['p3'] += $reading['reading_c'];

                                        $errorValues[$counter] = $error;
                                        
                                        $counter++;
                                    }

                                    $averageError = pow(array_sum($errorValues)/count($errorValues)/$divisor, 2);

                                    $variance = pow((max($errorValues) - min($errorValues))/$divisor, 2);

                                    $totals['average_p1'] = $totals['p1']/$counter;
                                    $totals['average_p2'] = $totals['p2']/$counter;
                                    $totals['average_p3'] = $totals['p3']/$counter;
                                    $homogeneity = (($totals['average_p1'] - $totals['average_p2'])+($totals['average_p2'] - $totals['average_p3']))/2/$divisor;
                                    $homogeneity = pow($homogeneity, 2);

                                    $repeatability = pow(sd($errorValues)/sqrt(count($errorValues))/$divisor, 2);

                                    // These 2 lines below don't make sense
                                    $UCStandard = pow(0/sqrt(3), 2);

                                    $resn = pow(0/$divisor/sqrt(3), 2);
                                    ?>
                                    <tr></tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="uncertainity" style="font-size: 0.75em">
                        <div>
                            <strong>
                                6.0 UNCERTAINITY: 
                                <?php
                                    $uncertainity = sqrt($averageError + $variance + $homogeneity  + $repeatability + $UCStandard + $resn);
                                    echo number_format($uncertainity,7);
                                ?>
                            </strong>
                        </div>
                    </div><br>
                    <div class="remarks" style="font-size: 0.75em">
                        <div><strong>7.0 REMARKS</strong></div>
                        <div style="margin-left: 30px;">
                            <p><?php echo "remarks";?></p>
                        <div style="padding: 5px; border: 1px solid #000;">
                            <p>Calibration certificate issued without signature and official stamp is not valid.
                                This certificate has been issued without any alteration and may not be reproduced
                                other than in full and with the approval of the head of NPHL-COE.</p>
                            <p>If undelivered please return to the above address.</p>
                        </div><br>
                        <div>Calibration Complete. STATUS: <?php echo "pass_fail"?></div>
                    </div>
                </div>
            <!-- /Show Calibration Certificate -->
            <?php
                }
            ?>
        </main><!-- #main -->
    </div><!-- #primary -->
</div><!-- .wrap -->


<div class="modal fade" id="addManufacturerModal" tabindex="-1" role="dialog" aria-labelledby="addManufacturerModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addManufacturerModalLabel">Add Manufacturer</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="<?php echo get_site_url(); ?>/conditioned-chamber-calculations/" name="newManufacturer">
                    <div class="form-group row">
                        <label class="col-form-label col-sm-4" for="manufacturer_name">Name</label>
                        <input type="text" name="manufacturer_name" id="manufacturer_name" class="form-control form-control-sm col-sm-8" required />
                        <input type="hidden" name="calculate_conditioned_chamber_item" value="false" />
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <input type="submit" class="btn btn-primary" data-dismiss="modal" value="Save" onclick="document.newManufacturer.submit()" />
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="addEquipmentModal" tabindex="-1" role="dialog" aria-labelledby="addEquipmentModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addEquipmentModalLabel">Add Equipment</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="<?php echo get_site_url(); ?>/conditioned-chamber-calculations/" name="newEquipment">
                    <div class="form-group row">
                        <label class="col-form-label col-sm-4" for="equipment_name">Name</label>
                        <input type="text" name="equipment_name" id="equipment_name" class="form-control form-control-sm col-sm-8" required />
                        <input type="hidden" name="calculate_conditioned_chamber_item" value="false" />
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <input type="submit" class="btn btn-primary" data-dismiss="modal" value="Save" onclick="document.newEquipment.submit()" />
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="addClientModal" tabindex="-1" role="dialog" aria-labelledby="addClientModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addClientModalLabel">Add Client</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="<?php echo get_site_url(); ?>/conditioned-chamber-calculations/" name="newClient">
                    <div class="form-group row">
                        <label class="col-form-label col-sm-4" for="client_name">Name</label>
                        <input type="text" name="client_name" id="client_name" class="form-control form-control-sm col-sm-8" required />
                        <input type="hidden" name="calculate_conditioned_chamber_item" value="false" />
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <input type="submit" class="btn btn-primary" data-dismiss="modal" value="Save" onclick="document.newClient.submit()" />
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="addClientContactModal" tabindex="-1" role="dialog" aria-labelledby="addClientContactModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addClientContactModalLabel">Add Client Contact</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="<?php echo get_site_url(); ?>/conditioned-chamber-calculations/" name="newClientContact">
                    <div class="form-group row">
                        <label for="client" class="col-form-label col-sm-4">Name</label>
                        <select class="form-control form-control-sm col-sm-8" id="client_id" name="client_id" required >
                            <?php
                                foreach ($clients as $client) {
                                    echo "<option value='".$client->id."'>".$client->name."</option>";
                                }
                            ?>
                        </select>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-sm-4" for="contact_name">Contact Name</label>
                        <input type="text" name="contact_name" id="contact_name" class="form-control form-control-sm col-sm-8" required />
                        <input type="hidden" name="calculate_conditioned_chamber_item" value="false" />
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-sm-4" for="contact_email">Contact Email</label>
                        <input type="email" name="contact_email" id="contact_email" class="form-control form-control-sm col-sm-8" required />
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-sm-4" for="contact_phone">Contact Phone</label>
                        <input type="text" name="contact_phone" id="contact_phone" class="form-control form-control-sm col-sm-8" />
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <input type="submit" class="btn btn-primary" data-dismiss="modal" value="Save" onclick="document.newClientContact.submit()" />
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<?php get_footer(); ?>

<script>
jQuery( document ).ready(function( $ ) {
    $( function() {
        $( "#date_performed" ).datepicker({ dateFormat: 'yy-mm-dd' });
    } );
});
</script>
