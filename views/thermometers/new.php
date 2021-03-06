<!-- Thermometer Calculations -->
<div>
    <form name="ccc_back" method="POST" action="<?php echo get_site_url(); ?>/thermometers/">
        <button class="btn btn-sm btn-outline-dark float-right" onclick="document.ccc_back.submit">Back</button>
    </form>
    <br>
    <br>
    <form name="calibration_calculations_form" method="POST" action="<?php echo get_site_url(); ?>/thermometers/">
        <input type="hidden" name="form_ready_for_submit" value="false" />
        <input type="hidden" name="calibration_calculation" value="false" />

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
                    <select class="form-control form-control-sm col-sm-7" id="client" name="client" required >
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
                    <label for="client_contact_id" class="col-form-label col-sm-4">Contact Person</label>
                    <select class="form-control form-control-sm col-sm-7" id="client_contact_id" name="client_contact_id" required >
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
                    <label for="ste_equipment" class="col-form-label col-sm-4">Description</label>
                    <select class="form-control form-control-sm col-sm-7" id="ste_equipment" name="ste_equipment" required >
                        <?php
                            foreach ($STEquipments as $equipment) {
                                echo "<option value='".$equipment->id."'>".$equipment->name."</option>";
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
                <div class="form-group row">
                    <label for="uncertainity_of_standard" class="col-form-label col-sm-4">
                        Uncertainity of the Standard
                    </label>
                    <input type="text" class="form-control form-control-sm col-sm-8" id="uncertainity_of_standard" name="uncertainity_of_standard" />
                </div>
                <div class="form-group row">
                    <label for="resolution_of_standard" class="col-form-label col-sm-4">
                        Resolution of the Standard
                    </label>
                    <input type="text" class="form-control form-control-sm col-sm-8" id="resolution_of_standard" name="resolution_of_standard" />
                </div>
                <div class="form-group row">
                    <label for="resolution_of_device_under_test" class="col-form-label col-sm-4">
                        Resolution of Device under Test
                    </label>
                    <input type="text" class="form-control form-control-sm col-sm-8" id="resolution_of_device_under_test" name="resolution_of_device_under_test" />
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Environmental Conditions</h5>
                <div class="form-group row">
                    <label for="environmental_temperature" class="col-form-label col-sm-5">Temperature</label>
                    <input type="number" step="any" class="form-control form-control-sm col-sm-7" id="environmental_temperature" name="environmental_temperature" title="" required />
                </div>
                <div class="form-group row">
                    <label for="environmental_humidity" class="col-form-label col-sm-5">Humidity</label>
                    <input type="number" step="any" class="form-control form-control-sm col-sm-7" id="environmental_humidity" name="environmental_humidity" title="" required />
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="form-group row">
                    <label for="expected_temperature" class="col-form-label col-sm-5">Standard Reading 1 (°c)</label>
                    <input type="number" step="any" class="form-control form-control-sm col-sm-7" id="expected_temperature_a" name="expected_temperature_a" title="" required />
                </div>
                <div class="form-group row">
                    <label for="expected_temperature" class="col-form-label col-sm-5">Standard Reading 2 (°c)</label>
                    <input type="number" step="any" class="form-control form-control-sm col-sm-7" id="expected_temperature_b" name="expected_temperature_b" title="" required />
                </div>
                <div class="form-group row">
                    <label for="expected_temperature" class="col-form-label col-sm-5">Standard Reading 3 (°c)</label>
                    <input type="number" step="any" class="form-control form-control-sm col-sm-7" id="expected_temperature_c" name="expected_temperature_c" title="" required />
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
                                <th scope="col" colspan="3"><center>Temperature (°c)</center></th>
                            </tr>
                            <tr>
                                <th scope="col">Point 1</th>
                                <th scope="col">Point 2</th>
                                <th scope="col">Point 3</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Reading 1</td>
                                <td>
                                    <input type="number" step="any" class="form-control form-control-sm" id="reading_1_1" name="reading_1_1" required />
                                </td>
                                <td>
                                    <input type="number" step="any" class="form-control form-control-sm" id="reading_2_1" name="reading_2_1" required />
                                </td>
                                <td>
                                    <input type="number" step="any" class="form-control form-control-sm" id="reading_3_1" name="reading_3_1" required />
                                </td>
                            </tr>
                            <tr>
                                <td>Reading 2</td>
                                <td>
                                    <input type="number" step="any" class="form-control form-control-sm" id="reading_1_2" name="reading_1_2" required />
                                </td>
                                <td>
                                    <input type="number" step="any" class="form-control form-control-sm" id="reading_2_2" name="reading_2_2" required />
                                </td>
                                <td>
                                    <input type="number" step="any" class="form-control form-control-sm" id="reading_3_2" name="reading_3_2" required />
                                </td>
                            </tr>
                            <tr>
                                <td>Reading 3</td>
                                <td>
                                    <input type="number" step="any" class="form-control form-control-sm" id="reading_1_3" name="reading_1_3" required />
                                </td>
                                <td>
                                    <input type="number" step="any" class="form-control form-control-sm" id="reading_2_3" name="reading_2_3" required />
                                </td>
                                <td>
                                    <input type="number" step="any" class="form-control form-control-sm" id="reading_3_3" name="reading_3_3" required />
                                </td>
                            </tr>
                            <tr>
                                <td>Reading 4</td>
                                <td>
                                    <input type="number" step="any" class="form-control form-control-sm" id="reading_1_4" name="reading_1_4" required />
                                </td>
                                <td>
                                    <input type="number" step="any" class="form-control form-control-sm" id="reading_2_4" name="reading_2_4" required />
                                </td>
                                <td>
                                    <input type="number" step="any" class="form-control form-control-sm" id="reading_3_4" name="reading_3_4" required />
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
                <input type="submit" class="button btn form-control" value="Save" />
            </div>
        <?php
            }
        ?>
    </form>
</div>
<!-- /Thermometer Calculations -->
