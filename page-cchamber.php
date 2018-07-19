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


if ($COEPage == 1) {
    $certicates = getCOEConditionedChamberCertificates();
}else if($COEPage == 2){

    $validated = empty( $_REQUEST['form_ready_for_submit'] ) ? false : true;

    if ($validated) {
        $response = addConditionedChamberRecordings($_REQUEST);

        if($response){
            $COEPage = 1;
            $certicates = getCOEConditionedChamberCertificates();
        }
    }

    $newManufacturer = empty( $_REQUEST['manufacturer_name'] ) ? false : $_REQUEST['manufacturer_name'];
    $newEquipment = empty( $_REQUEST['equipment_name'] ) ? false : $_REQUEST['equipment_name'];

    addCOEManufacturer($newManufacturer);
    addCOEEquipment($newEquipment);

    $manufacturers = getCOEManufacturers();
    $equipments = getCOEEquipment();

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
                    <button class="btn btn-sm btn-outline-dark"onclick="document.ccc_post.submit()">
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
                                    echo "<td><button class='btn btn-sm btn-outline-dark'>View</button></td></tr>";
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

                <h3>Calibration of Conditioned Chamber</h3>
                <form name="conditioned_chamber_calculations" method="POST" action="<?php echo get_site_url(); ?>/conditioned-chamber-calculations/">
                    <input type="hidden" name="form_ready_for_submit" value="false" />
                    <input type="hidden" name="calculate_conditioned_chamber_item" value="false" />

                    <div class="form-group row">
                        <label for="model" class="col-form-label col-sm-4">Date Performed</label>
                        <input type="text" class="form-control form-control-sm col-sm-8" id="date_performed" name="date_performed" required />
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Client Details</h5>
                            <div class="form-group row">
                                <label for="client_name" class="col-form-label col-sm-4">Name</label>
                                <input type="text" class="form-control form-control-sm col-sm-8" id="client_name" name="client_name" placeholder="Client Name" required />
                            </div>
                            <div class="form-group row">
                                <label for="client_contact" class="col-form-label col-sm-4">Contact Person</label>
                                <input type="text" class="form-control form-control-sm col-sm-8" id="client_contact" name="client_contact" placeholder="Client Contact Person" required />
                            </div>
                            <div class="form-group row">
                                <label for="client_contact_email" class="col-form-label col-sm-4">Contact Email</label>
                                <input type="email" class="form-control form-control-sm col-sm-8" id="client_contact_email" name="client_contact_email" placeholder="Client Contact Email" required />
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
                    <!-- TODO: Generate Sequential xxx plus YY year -->
                    <input type="hidden" id="certificate_number" name="certificate_number" value="COE/CC/YY/xxxxx" />
                    <div class="form-group row">
                        <label for="expected_temperature" class="col-form-label col-sm-5">Expected/Set Temperature</label>
                        <input type="number" class="form-control form-control-sm col-sm-7" id="expected_temperature" name="expected_temperature" title="" required />
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Readings</h5>
                            <div class="table-responsive">
                                <table class="table table-striped table-sm">
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
                        <input type="text" name="manufacturer_name" id="manufacturer_name" class="form-control form-control-sm col-sm-8" />
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
                        <input type="text" name="equipment_name" id="manufacturer_name" class="form-control form-control-sm col-sm-8" />
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

<?php get_footer(); ?>

<script>
jQuery( document ).ready(function( $ ) {
    $( function() {
        $( "#date_performed" ).datepicker({ dateFormat: 'yy-mm-dd' });
    } );
});
</script>
