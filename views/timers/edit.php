<!-- Timer Calculations -->
<div>
    <form name="ccc_back" method="POST" action="<?php echo get_site_url(); ?>/timers/">
        <button class="btn btn-sm btn-outline-dark float-right" onclick="document.ccc_back.submit">Back</button>
    </form>
    <br>
    <br>
    <form name="calibration_calculations_form" method="POST" action="<?php echo get_site_url(); ?>/timers/">
        <input type="hidden" name="form_ready_for_update" value="false" />
        <input type="hidden" name="calibration_calculation" value="false" />
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
                <div class="form-group row">
                    <label for="resolution_of_device_under_test" class="col-form-label col-sm-4">
                        Resolution of Timer / Stopwatch
                    </label>
                    <input type="text" class="form-control form-control-sm col-sm-8" id="resolution_of_device_under_test" name="resolution_of_device_under_test" value="<?php echo $certification->resolution_of_device_under_test; ?>" />
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
                    <input type="text" class="form-control form-control-sm col-sm-8" id="ste_serial_number" required
                        name="ste_serial_number" value="<?php echo $certification->standard_test_equipment_serial_number; ?>" />
                </div>
                <div class="form-group row">
                    <label for="ste_certificate_number" class="col-form-label col-sm-4">Certificate Number</label>
                    <input type="text" class="form-control form-control-sm col-sm-8" id="ste_certificate_number" required
                        name="ste_certificate_number" value="<?php echo $certification->standard_test_equipment_certificate_number; ?>" />
                </div>
                <div class="form-group row">
                    <label for="ste_sticker_number" class="col-form-label col-sm-4">Sticker Number</label>
                    <input type="text" class="form-control form-control-sm col-sm-8" id="ste_sticker_number"
                        name="ste_sticker_number" value="<?php echo $certification->standard_test_equipment_sticker_number; ?>" />
                </div>
                <div class="form-group row">
                    <label for="uncertainity_of_standard" class="col-form-label col-sm-4">
                        Accuracy of the Standard
                    </label>
                    <input type="text" class="form-control form-control-sm col-sm-8" id="accuracy_of_standard" 
                        name="accuracy_of_standard" value="<?php echo $certification->accuracy_of_standard; ?>" />
                </div>
                <div class="form-group row">
                    <label for="resolution_of_standard" class="col-form-label col-sm-4">
                        Resolution of the Standard
                    </label>
                    <input type="text" class="form-control form-control-sm col-sm-8" id="resolution_of_standard"
                        name="resolution_of_standard" value="<?php echo $certification->resolution_of_standard; ?>" />
                </div>
                <div class="form-group row">
                    <label for="uncertainity_of_standard" class="col-form-label col-sm-4">
                        Uncertainity of the Standard
                    </label>
                    <input type="text" class="form-control form-control-sm col-sm-8" id="uncertainity_of_standard" 
                        name="uncertainity_of_standard" value="<?php echo $certification->uncertainity_of_standard; ?>" />
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Environmental Conditions</h5>
                <div class="form-group row">
                    <label for="environmental_temperature" class="col-form-label col-sm-5">Temperature</label>
                    <input type="number" step="any" class="form-control form-control-sm col-sm-7" id="environmental_temperature"
                    name="environmental_temperature" value="<?php echo $certification->environmental_temperature; ?>" required />
                </div>
                <div class="form-group row">
                    <label for="environmental_humidity" class="col-form-label col-sm-5">Humidity</label>
                    <input type="number" step="any" class="form-control form-control-sm col-sm-7" id="environmental_humidity" name="environmental_humidity" value="<?php echo $certification->environmental_humidity; ?>" required />
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="form-group row">
                    <label for="expected_set_point_a" class="col-form-label col-sm-5">Set Point 1</label>
                    <input type="number" step="any" class="form-control form-control-sm col-sm-7" id="expected_set_point_a" name="expected_set_point_a" value="<?php echo $certification->expected_set_point_a; ?>" required />
                </div>
                <div class="form-group row">
                    <label for="expected_set_point_b" class="col-form-label col-sm-5">Set Point 2</label>
                    <input type="number" step="any" class="form-control form-control-sm col-sm-7" id="expected_set_point_b" name="expected_set_point_b" value="<?php echo $certification->expected_set_point_b; ?>" required />
                </div>
                <div class="form-group row">
                    <label for="expected_set_point_c" class="col-form-label col-sm-5">Set Point 3</label>
                    <input type="number" step="any" class="form-control form-control-sm col-sm-7" id="expected_set_point_c" name="expected_set_point_c" value="<?php echo $certification->expected_set_point_c; ?>" required />
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
                                <th scope="col" rowspan="2">#</th>
                                <th scope="col" colspan="5"><center>Readings</center></th>
                            </tr>
                            <tr>
                                <th scope="col">1</th>
                                <th scope="col">2</th>
                                <th scope="col">3</th>
                                <th scope="col">4</th>
                                <th scope="col">5</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Point 1</td>
                                <td>
                                    <div class="input-group">
                                        <input type="number" class="form-control form-control-sm" placeholder="MM" min="00" max="60" step="1" id="reading_mm_1_1" name="reading_mm_1_1" required value="<?php echo (int)($certification->readings[0]['reading_a']/60); ?>" />
                                        <div class="input-group-append">
                                            <span class="input-group-text">:</span>
                                        </div>
                                        <input type="number" class="form-control form-control-sm" placeholder="ss" min="00" max="59.9999" step="any" id="reading_ss_1_1" name="reading_ss_1_1" required value="<?php echo round(fmod($certification->readings[0]['reading_a'],60),3); ?>" />
                                    </div>
                                </td>
                                <td>
                                    <div class="input-group">
                                        <input type="number" class="form-control form-control-sm" placeholder="MM" min="00" max="60" step="1" id="reading_mm_1_2" name="reading_mm_1_2" required value="<?php echo (int)($certification->readings[1]['reading_a']/60); ?>" />
                                        <div class="input-group-append">
                                            <span class="input-group-text">:</span>
                                        </div>
                                        <input type="number" class="form-control form-control-sm" placeholder="ss" min="00" max="59.9999" step="any" id="reading_ss_1_2" name="reading_ss_1_2" required value="<?php echo round(fmod($certification->readings[1]['reading_a'],60),3); ?>" />
                                    </div>
                                </td>
                                <td>
                                    <div class="input-group">
                                        <input type="number" class="form-control form-control-sm" placeholder="MM" min="00" max="60" step="1" id="reading_mm_1_3" name="reading_mm_1_3" required value="<?php echo (int)($certification->readings[2]['reading_a']/60); ?>" />
                                        <div class="input-group-append">
                                            <span class="input-group-text">:</span>
                                        </div>
                                        <input type="number" class="form-control form-control-sm" placeholder="ss" min="00" max="59.9999" step="any" id="reading_ss_1_3" name="reading_ss_1_3" required value="<?php echo round(fmod($certification->readings[2]['reading_a'],60),3); ?>" />
                                    </div>
                                </td>
                                <td>
                                    <div class="input-group">
                                        <input type="number" class="form-control form-control-sm" placeholder="MM" min="00" max="60" step="1" id="reading_mm_1_4" name="reading_mm_1_4" required value="<?php echo (int)($certification->readings[3]['reading_a']/60); ?>" />
                                        <div class="input-group-append">
                                            <span class="input-group-text">:</span>
                                        </div>
                                        <input type="number" class="form-control form-control-sm" placeholder="ss" min="00" max="59.9999" step="any" id="reading_ss_1_4" name="reading_ss_1_4" required value="<?php echo round(fmod($certification->readings[3]['reading_a'],60),3); ?>" />
                                    </div>
                                </td>
                                <td>
                                    <div class="input-group">
                                        <input type="number" class="form-control form-control-sm" placeholder="MM" min="00" max="60" step="1" id="reading_mm_1_5" name="reading_mm_1_5" required value="<?php echo (int)($certification->readings[4]['reading_a']/60); ?>" />
                                        <div class="input-group-append">
                                            <span class="input-group-text">:</span>
                                        </div>
                                        <input type="number" class="form-control form-control-sm" placeholder="ss" min="00" max="59.9999" step="any" id="reading_ss_1_5" name="reading_ss_1_5" required value="<?php echo round(fmod($certification->readings[4]['reading_a'],60),3); ?>" />
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>Point 2</td>
                                <td>
                                    <div class="input-group">
                                        <input type="number" class="form-control form-control-sm" placeholder="MM" min="00" max="60" step="1" id="reading_mm_2_1" name="reading_mm_2_1" required value="<?php echo (int)($certification->readings[0]['reading_b']/60); ?>" />
                                        <div class="input-group-append">
                                            <span class="input-group-text">:</span>
                                        </div>
                                        <input type="number" class="form-control form-control-sm" placeholder="ss" min="00" max="59.9999" step="any" id="reading_ss_2_1" name="reading_ss_2_1" required value="<?php echo round(fmod($certification->readings[0]['reading_b'],60),3); ?>" />
                                    </div>
                                </td>
                                <td>
                                    <div class="input-group">
                                        <input type="number" class="form-control form-control-sm" placeholder="MM" min="00" max="60" step="1" id="reading_mm_2_2" name="reading_mm_2_2" required value="<?php echo (int)($certification->readings[1]['reading_b']/60); ?>" />
                                        <div class="input-group-append">
                                            <span class="input-group-text">:</span>
                                        </div>
                                        <input type="number" class="form-control form-control-sm" placeholder="ss" min="00" max="59.9999" step="any" id="reading_ss_2_2" name="reading_ss_2_2" required value="<?php echo round(fmod($certification->readings[1]['reading_b'],60),3); ?>" />
                                    </div>
                                </td>
                                <td>
                                    <div class="input-group">
                                        <input type="number" class="form-control form-control-sm" placeholder="MM" min="00" max="60" step="1" id="reading_mm_2_3" name="reading_mm_2_3" required value="<?php echo (int)($certification->readings[2]['reading_b']/60); ?>" />
                                        <div class="input-group-append">
                                            <span class="input-group-text">:</span>
                                        </div>
                                        <input type="number" class="form-control form-control-sm" placeholder="ss" min="00" max="59.9999" step="any" id="reading_ss_2_3" name="reading_ss_2_3" required value="<?php echo round(fmod($certification->readings[2]['reading_b'],60),3); ?>" />
                                    </div>
                                </td>
                                <td>
                                    <div class="input-group">
                                        <input type="number" class="form-control form-control-sm" placeholder="MM" min="00" max="60" step="1" id="reading_mm_2_4" name="reading_mm_2_4" required value="<?php echo (int)($certification->readings[3]['reading_b']/60); ?>" />
                                        <div class="input-group-append">
                                            <span class="input-group-text">:</span>
                                        </div>
                                        <input type="number" class="form-control form-control-sm" placeholder="ss" min="00" max="59.9999" step="any" id="reading_ss_2_4" name="reading_ss_2_4" required value="<?php echo round(fmod($certification->readings[3]['reading_b'],60),3); ?>" />
                                    </div>
                                </td>
                                <td>
                                    <div class="input-group">
                                        <input type="number" class="form-control form-control-sm" placeholder="MM" min="00" max="60" step="1" id="reading_mm_2_5" name="reading_mm_2_5" required value="<?php echo (int)($certification->readings[4]['reading_b']/60); ?>" />
                                        <div class="input-group-append">
                                            <span class="input-group-text">:</span>
                                        </div>
                                        <input type="number" class="form-control form-control-sm" placeholder="ss" min="00" max="59.9999" step="any" id="reading_ss_2_5" name="reading_ss_2_5" required value="<?php echo round(fmod($certification->readings[4]['reading_b'],60),3); ?>" />
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>Point 3</td>
                                <td>
                                    <div class="input-group">
                                        <input type="number" class="form-control form-control-sm" placeholder="MM" min="00" max="60" step="1" id="reading_mm_3_1" name="reading_mm_3_1" required value="<?php echo (int)($certification->readings[0]['reading_c']/60); ?>" />
                                        <div class="input-group-append">
                                            <span class="input-group-text">:</span>
                                        </div>
                                        <input type="number" class="form-control form-control-sm" placeholder="ss" min="00" max="59.9999" step="any" id="reading_ss_3_1" name="reading_ss_3_1" required value="<?php echo round(fmod($certification->readings[0]['reading_c'],60),3); ?>" />
                                    </div>
                                </td>
                                <td>
                                    <div class="input-group">
                                        <input type="number" class="form-control form-control-sm" placeholder="MM" min="00" max="60" step="1" id="reading_mm_3_2" name="reading_mm_3_2" required value="<?php echo (int)($certification->readings[1]['reading_c']/60); ?>" />
                                        <div class="input-group-append">
                                            <span class="input-group-text">:</span>
                                        </div>
                                        <input type="number" class="form-control form-control-sm" placeholder="ss" min="00" max="59.9999" step="any" id="reading_ss_3_2" name="reading_ss_3_2" required value="<?php echo round(fmod($certification->readings[1]['reading_c'],60),3); ?>" />
                                    </div>
                                </td>
                                <td>
                                    <div class="input-group">
                                        <input type="number" class="form-control form-control-sm" placeholder="MM" min="00" max="60" step="1" id="reading_mm_3_3" name="reading_mm_3_3" required value="<?php echo (int)($certification->readings[2]['reading_c']/60); ?>" />
                                        <div class="input-group-append">
                                            <span class="input-group-text">:</span>
                                        </div>
                                        <input type="number" class="form-control form-control-sm" placeholder="ss" min="00" max="59.9999" step="any" id="reading_ss_3_3" name="reading_ss_3_3" required value="<?php echo round(fmod($certification->readings[2]['reading_c'],60),3); ?>" />
                                    </div>
                                </td>
                                <td>
                                    <div class="input-group">
                                        <input type="number" class="form-control form-control-sm" placeholder="MM" min="00" max="60" step="1" id="reading_mm_3_4" name="reading_mm_3_4" required value="<?php echo (int)($certification->readings[3]['reading_c']/60); ?>" />
                                        <div class="input-group-append">
                                            <span class="input-group-text">:</span>
                                        </div>
                                        <input type="number" class="form-control form-control-sm" placeholder="ss" min="00" max="59.9999" step="any" id="reading_ss_3_4" name="reading_ss_3_4" required value="<?php echo round(fmod($certification->readings[3]['reading_c'],60),3); ?>" />
                                    </div>
                                </td>
                                <td>
                                    <div class="input-group">
                                        <input type="number" class="form-control form-control-sm" placeholder="MM" min="00" max="60" step="1" id="reading_mm_3_5" name="reading_mm_3_5" required value="<?php echo (int)($certification->readings[4]['reading_c']/60); ?>" />
                                        <div class="input-group-append">
                                            <span class="input-group-text">:</span>
                                        </div>
                                        <input type="number" class="form-control form-control-sm" placeholder="ss" min="00" max="59.9999" step="any" id="reading_ss_3_5" name="reading_ss_3_5" required value="<?php echo round(fmod($certification->readings[4]['reading_c'],60),3); ?>" />
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <?php
            // if(hasRole('CALIBRATOR')){
        ?>
            <div class="form-group">
                <input type="submit" class="button btn form-control" value="Update" />
            </div>
        <?php
            // }
        ?>
    </form>
</div>
<!-- /Timer Calculations -->
