<!-- Conditioned Chamber Calculations -->
<div>
    <form name="ccc_back" method="POST" action="<?php echo $pageURL; ?>">
        <button class="btn btn-sm btn-outline-dark float-right" onclick="document.ccc_back.submit">Back</button>
    </form>
    <br>
    <br>
    <form name="calibration_calculations_form" method="POST" action="<?php echo $pageURL; ?>">
        <input type="hidden" name="api_code" value="3" />
        <input type="hidden" name="calibration_calculation_id" value="<?php echo $certification->id; ?>" />

        <div class="card">
            <div class="card-body">
            <div class="form-group row">
                <label for="model" class="col-form-label col-sm-4">Date Performed</label>
                <input type="text" class="form-control form-control-sm col-sm-8" id="date_performed" name="date_performed" required value="<?php echo $certification->date_performed; ?>" />
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Client Details</h5>
                <div class="form-group row">
                    <label for="client" class="col-form-label col-sm-4">Name</label>
                    <select class="form-control form-control-sm col-sm-7" id="client" name="client" required >
                        <?php
                            foreach ($clients as $client) {
                                echo "<option value='{$client->id}' ".($certification->client_id==$client->id?'selected':'');
                                echo ">{$client->name}</option>";
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
                    <label for="client_contact_id" class="col-form-label col-sm-4">Contact Person</label>
                    <select class="form-control form-control-sm col-sm-7" id="client_contact_id" name="client_contact_id" required >
                        <?php
                            foreach ($clientContacts as $contact) {
                                echo "<option value='{$contact->id}' ";
                                echo ($certification->client_contact_id==$contact->id?'selected':'');
                                echo ">{$contact->name}</option>";
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
                    <label for="equipment" class="col-form-label col-sm-4">Equipment Name</label>
                    <select class="form-control form-control-sm col-sm-7" id="equipment" name="equipment" required >
                        <?php
                            foreach ($equipments as $equipment) {
                                echo "<option value='{$equipment->id}' ";
                                echo ($certification->equipment_id==$equipment->id?'selected':'');
                                echo ">{$equipment->name}</option>";
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
                    <label for="manufacturer" class="col-form-label col-sm-4">Manufacturer</label>
                    <select class="form-control form-control-sm col-sm-7" id="manufacturer" name="manufacturer" required >
                        <?php
                            foreach ($manufacturers as $manufacturer) {
                                echo "<option value='{$manufacturer->id}' ";
                                echo ($certification->manufacturer_id==$manufacturer->id?'selected':'');
                                echo ">{$manufacturer->name}</option>";
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
                    <label for="model" class="col-form-label col-sm-4">Model</label>
                    <input type="text" class="form-control form-control-sm col-sm-8" id="model" name="model" required
                        value="<?php echo $certification->equipment_model; ?>" />
                </div>
                <div class="form-group row">
                    <label for="serial_number" class="col-form-label col-sm-4">Serial Number</label>
                    <input type="text" class="form-control form-control-sm col-sm-8" id="serial_number" name="serial_number"
                        required value="<?php echo $certification->equipment_serial_number; ?>" />
                </div>
                <div class="form-group row">
                    <label for="submission_number" class="col-form-label col-sm-4">Inventory Number</label>
                    <input type="text" class="form-control form-control-sm col-sm-8" id="submission_number"
                        name="submission_number" value="<?php echo $certification->submission_number; ?>" />
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Standard Test Equipment Used</h5>
                <div class="form-group row">
                    <label for="ste_equipment" class="col-form-label col-sm-4">Description</label>
                    <select class="form-control form-control-sm col-sm-7" id="ste_equipment" name="ste_equipment" required >
                        <?php
                            foreach ($STEquipments as $equipment) {
                                echo "<option value='{$equipment->id}' ";
                                echo ($certification->standard_test_equipment_id==$equipment->id?'selected':'');
                                echo ">{$equipment->name}</option>";
                            }
                        ?>
                    </select>
                    <div class="col-sm-1">
                        <button type="button" class="btn btn-sm btn-outline-dark" data-toggle="modal" data-target="#addSTEquipmentModal">
                            <strong><span aria-hidden="true">&plus;</span></strong>
                        </button>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="ste_manufacturer" class="col-form-label col-sm-4">Manufacturer</label>
                    <select class="form-control form-control-sm col-sm-7" id="ste_manufacturer" name="ste_manufacturer" required >
                        <?php
                            foreach ($manufacturers as $manufacturer) {
                                echo "<option value='{$manufacturer->id}' ";
                                echo ($certification->standard_test_equipment_manufacturer_id==$manufacturer->id?'selected':'');
                                echo ">{$manufacturer->name}</option>";
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
                    <label for="model" class="col-form-label col-sm-4">Model</label>
                    <input type="text" class="form-control form-control-sm col-sm-8" id="ste_model" name="ste_model" required
                        value="<?php echo $certification->standard_test_equipment_model; ?>" />
                </div>
                <div class="form-group row">
                    <label for="serial_number" class="col-form-label col-sm-4">Serial Number</label>
                    <input type="text" class="form-control form-control-sm col-sm-8" id="ste_serial_number" 
                    name="ste_serial_number" required  value="<?php echo $certification->standard_test_equipment_serial_number; ?>" />
                </div>
                <div class="form-group row">
                    <label for="ste_certificate_number" class="col-form-label col-sm-4">Certificate Number</label>
                    <input type="text" class="form-control form-control-sm col-sm-8" id="ste_certificate_number" 
                        name="ste_certificate_number" required value="<?php echo $certification->standard_test_equipment_certificate_number; ?>" />
                </div>
                <div class="form-group row">
                    <label for="ste_sticker_number" class="col-form-label col-sm-4">Sticker Number</label>
                    <input type="text" class="form-control form-control-sm col-sm-8" id="ste_sticker_number" 
                        name="ste_sticker_number" value="<?php echo $certification->standard_test_equipment_sticker_number; ?>" />
                </div>
                <div class="form-group row">
                    <label for="uncertainity_of_standard" class="col-form-label col-sm-4">
                        Uncertainity of the Standard
                    </label>
                    <input type="text" class="form-control form-control-sm col-sm-8" id="uncertainity_of_standard" name="uncertainity_of_standard" value="<?php echo $certification->uncertainity_of_standard; ?>" />
                </div>
                <div class="form-group row">
                    <label for="resolution_of_standard" class="col-form-label col-sm-4">
                        Resolution of the Standard
                    </label>
                    <input type="text" class="form-control form-control-sm col-sm-8" id="resolution_of_standard" 
                        name="resolution_of_standard" value="<?php echo $certification->resolution_of_standard; ?>" />
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Environmental Conditions</h5>
                <div class="form-group row">
                    <label for="environmental_temperature" class="col-form-label col-sm-5">Temperature</label>
                    <input type="number" step="any" class="form-control form-control-sm col-sm-7" 
                        id="environmental_temperature" name="environmental_temperature" title="" required
                        value="<?php echo $certification->environmental_temperature; ?>" />
                </div>
                <div class="form-group row">
                    <label for="environmental_humidity" class="col-form-label col-sm-5">Humidity</label>
                    <input type="number" step="any" class="form-control form-control-sm col-sm-7" id="environmental_humidity"
                        name="environmental_humidity" title="" required
                        value="<?php echo $certification->environmental_humidity; ?>" />
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="form-group row">
                    <label for="expected_temperature" class="col-form-label col-sm-5">Expected/Set Temperature</label>
                    <input type="number" step="any" class="form-control form-control-sm col-sm-7" id="expected_temperature"
                        name="expected_temperature" title="" required
                        value="<?php echo $certification->expected_temperature; ?>" />
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
                                    <input type="number" step="any" class="form-control form-control-sm" id="p_1_0" required
                                    name="p_1_0" value="<?php echo $certification->readings[0]['reading_a']; ?>" />
                                </td>
                                <td>
                                    <input type="number" step="any" class="form-control form-control-sm" id="p_2_0" required
                                        name="p_2_0" value="<?php echo $certification->readings[0]['reading_b']; ?>" />
                                </td>
                                <td>
                                    <input type="number" step="any" class="form-control form-control-sm" id="p_3_0" required
                                        name="p_3_0" value="<?php echo $certification->readings[0]['reading_c']; ?>" />
                                </td>
                            </tr>
                            <tr>
                                <td align="center">6</td>
                                <td>
                                    <input type="number" step="any" class="form-control form-control-sm" id="p_1_6" name="p_1_6" required value="<?php echo $certification->readings[1]['reading_a']; ?>" />
                                </td>
                                <td>
                                    <input type="number" step="any" class="form-control form-control-sm" id="p_2_6" name="p_2_6" required value="<?php echo $certification->readings[1]['reading_b']; ?>" />
                                </td>
                                <td>
                                    <input type="number" step="any" class="form-control form-control-sm" id="p_3_6" name="p_3_6" required value="<?php echo $certification->readings[1]['reading_c']; ?>" />
                                </td>
                            </tr>
                            <tr>
                                <td align="center">12</td>
                                <td>
                                    <input type="number" step="any" class="form-control form-control-sm" id="p_1_12" name="p_1_12" required value="<?php echo $certification->readings[2]['reading_a']; ?>" />
                                </td>
                                <td>
                                    <input type="number" step="any" class="form-control form-control-sm" id="p_2_12" name="p_2_12" required value="<?php echo $certification->readings[2]['reading_b']; ?>" />
                                </td>
                                <td>
                                    <input type="number" step="any" class="form-control form-control-sm" id="p_3_12" name="p_3_12" required value="<?php echo $certification->readings[2]['reading_c']; ?>" />
                                </td>
                            </tr>
                            <tr>
                                <td align="center">18</td>
                                <td>
                                    <input type="number" step="any" class="form-control form-control-sm" id="p_1_18" name="p_1_18" required value="<?php echo $certification->readings[3]['reading_a']; ?>" />
                                </td>
                                <td>
                                    <input type="number" step="any" class="form-control form-control-sm" id="p_2_18" name="p_2_18" required value="<?php echo $certification->readings[3]['reading_b']; ?>" />
                                </td>
                                <td>
                                    <input type="number" step="any" class="form-control form-control-sm" id="p_3_18" name="p_3_18" required value="<?php echo $certification->readings[3]['reading_c']; ?>" />
                                </td>
                            </tr>
                            <tr>
                                <td align="center">24</td>
                                <td>
                                    <input type="number" step="any" class="form-control form-control-sm" id="p_1_24" name="p_1_24" required value="<?php echo $certification->readings[4]['reading_a']; ?>" />
                                </td>
                                <td>
                                    <input type="number" step="any" class="form-control form-control-sm" id="p_2_24" name="p_2_24" required value="<?php echo $certification->readings[4]['reading_b']; ?>" />
                                </td>
                                <td>
                                    <input type="number" step="any" class="form-control form-control-sm" id="p_3_24" name="p_3_24" required value="<?php echo $certification->readings[4]['reading_c']; ?>" />
                                </td>
                            </tr>
                            <tr>
                                <td align="center">30</td>
                                <td>
                                    <input type="number" step="any" class="form-control form-control-sm" id="p_1_30" name="p_1_30" required value="<?php echo $certification->readings[5]['reading_a']; ?>" />
                                </td>
                                <td>
                                    <input type="number" step="any" class="form-control form-control-sm" id="p_2_30" name="p_2_30" required value="<?php echo $certification->readings[5]['reading_b']; ?>" />
                                </td>
                                <td>
                                    <input type="number" step="any" class="form-control form-control-sm" id="p_3_30" name="p_3_30" required value="<?php echo $certification->readings[5]['reading_c']; ?>" />
                                </td>
                            </tr>
                            <tr>
                                <td align="center">36</td>
                                <td>
                                    <input type="number" step="any" class="form-control form-control-sm" id="p_1_36" name="p_1_36" required value="<?php echo $certification->readings[6]['reading_a']; ?>" />
                                </td>
                                <td>
                                    <input type="number" step="any" class="form-control form-control-sm" id="p_2_36" name="p_2_36" required value="<?php echo $certification->readings[6]['reading_b']; ?>" />
                                </td>
                                <td>
                                    <input type="number" step="any" class="form-control form-control-sm" id="p_3_36" name="p_3_36" required value="<?php echo $certification->readings[6]['reading_c']; ?>" />
                                </td>
                            </tr>
                            <tr>
                                <td align="center">42</td>
                                <td>
                                    <input type="number" step="any" class="form-control form-control-sm" id="p_1_42" name="p_1_42" required value="<?php echo $certification->readings[7]['reading_a']; ?>" />
                                </td>
                                <td>
                                    <input type="number" step="any" class="form-control form-control-sm" id="p_2_42" name="p_2_42" required value="<?php echo $certification->readings[7]['reading_b']; ?>" />
                                </td>
                                <td>
                                    <input type="number" step="any" class="form-control form-control-sm" id="p_3_42" name="p_3_42" required value="<?php echo $certification->readings[7]['reading_c']; ?>" />
                                </td>
                            </tr>
                            <tr>
                                <td align="center">48</td>
                                <td>
                                    <input type="number" step="any" class="form-control form-control-sm" id="p_1_48" name="p_1_48" required value="<?php echo $certification->readings[8]['reading_a']; ?>" />
                                </td>
                                <td>
                                    <input type="number" step="any" class="form-control form-control-sm" id="p_2_48" name="p_2_48" required value="<?php echo $certification->readings[8]['reading_b']; ?>" />
                                </td>
                                <td>
                                    <input type="number" step="any" class="form-control form-control-sm" id="p_3_48" name="p_3_48" required value="<?php echo $certification->readings[8]['reading_c']; ?>" />
                                </td>
                            </tr>
                            <tr>
                                <td align="center">54</td>
                                <td>
                                    <input type="number" step="any" class="form-control form-control-sm" id="p_1_54" name="p_1_54" required value="<?php echo $certification->readings[9]['reading_a']; ?>" />
                                </td>
                                <td>
                                    <input type="number" step="any" class="form-control form-control-sm" id="p_2_54" name="p_2_54" required value="<?php echo $certification->readings[9]['reading_b']; ?>" />
                                </td>
                                <td>
                                    <input type="number" step="any" class="form-control form-control-sm" id="p_3_54" name="p_3_54" required value="<?php echo $certification->readings[9]['reading_c']; ?>" />
                                </td>
                            </tr>
                            <tr>
                                <td align="center">60</td>
                                <td>
                                    <input type="number" step="any" class="form-control form-control-sm" id="p_1_60" name="p_1_60" required value="<?php echo $certification->readings[10]['reading_a']; ?>" />
                                </td>
                                <td>
                                    <input type="number" step="any" class="form-control form-control-sm" id="p_2_60" name="p_2_60" required value="<?php echo $certification->readings[10]['reading_b']; ?>" />
                                </td>
                                <td>
                                    <input type="number" step="any" class="form-control form-control-sm" id="p_3_60" name="p_3_60" required value="<?php echo $certification->readings[10]['reading_c']; ?>" />
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <?php
            if(hasRole('CALIBRATOR')){
        ?>
            <div class="form-group">
                <input type="submit" class="button btn form-control" value="Update" />
            </div>
        <?php
            }
        ?>
    </form>
</div>
<!-- /Conditioned Chamber Calculations -->
