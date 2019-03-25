<!-- New Service Request -->
<div>
    <div class="row">
        <div class="col-sm-12">
            <div id="info_block"></div>
            <button class="btn float-right btn-info" style="border-radius: 0;" onclick="window.history.back()" title="Back">
                <svg class="icon icon-arrow-left" aria-hidden="true" role="img">
                    <use href="#icon-arrow-left" xlink:href="#icon-arrow-left"></use>
                </svg>
            </button>
        </div>
    </div>
    <br>

    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Calibration Service Request</h5>
            <form name="service_request_form" id="service_request_form">
                <div class="form-group row">
                    <label for="equipment" class="col-form-label col-sm-4">
                        <sup style="color: red;" title="Mandatory">*</sup>
                        Equipment Name
                    </label>
                    <select class="form-control form-control-sm col-sm-8" id="equipment" name="equipment" required >
                        <?php
                            foreach ($equipments as $equipment) {
                                echo "<option value='".$equipment->id."'>".$equipment->name."</option>";
                            }
                        ?>
                    </select>
                </div>
                <div class="form-group row">
                    <label for="manufacturer" class="col-form-label col-sm-4">
                        <sup style="color: red;" title="Mandatory">*</sup>
                        Manufacturer
                    </label>
                    <select class="form-control form-control-sm col-sm-8" id="manufacturer" name="manufacturer" required >
                        <?php
                            foreach ($manufacturers as $manufacturer) {
                                echo "<option value='".$manufacturer->id."'>".$manufacturer->name."</option>";
                            }
                        ?>
                    </select>
                </div>
                <div class="form-group row">
                    <label for="model" class="col-form-label col-sm-4">
                        <sup style="color: red;" title="Mandatory">*</sup>
                        Model
                    </label>
                    <input type="text" class="form-control form-control-sm col-sm-8" id="model" name="model" required />
                </div>
                <div class="form-group row">
                    <label for="serial_number" class="col-form-label col-sm-4">
                        <sup style="color: red;" title="Mandatory">*</sup>
                        Serial Number
                    </label>
                    <input type="text" class="form-control form-control-sm col-sm-8" id="serial_number" name="serial_number" required />
                </div>
                <div class="form-group row">
                    <label for="inventory_number" class="col-form-label col-sm-4">
                        <sup style="color: red;" title="Mandatory">&nbsp;</sup>
                        Inventory Number
                    </label>
                    <input type="text" class="form-control form-control-sm col-sm-8" id="inventory_number" name="inventory_number" />
                </div>

                <div class="form-group row">
                    <label for="calibration_interval" class="col-form-label col-sm-4">
                        <sup style="color: red;" title="Mandatory">*</sup>
                        Calibration Interval
                    </label>
                    <select class="form-control form-control-sm col-sm-8" id="calibration_interval" name="calibration_interval" required >
                        <option value='3'>3 Months </option>
                        <option value='6'>6 Months </option>
                        <option value='12'>12 Months </option>
                    </select>
                </div>
                <div class="form-group row">
                    <label class="col-form-label col-sm-4" for="comments">
                        <sup style="color: red;" title="Mandatory">&nbsp;</sup>
                        Comments
                    </label>
                    <textarea name="comments" id="comments" class="form-control form-control-sm col-sm-8"
                        title="Enter any additional comments here"></textarea>
                </div>

                <div class="form-group row">
                    <label class="col-form-label col-sm-4"></label>
                    <input type="hidden" name="api_code" value="10">
                    <button id="service_request_button" class="btn btn-info" style="border-radius: 0; margin-right: 10px;">Submit</button>
                    <button onclick="window.history.back();" style="border-radius: 0" class="btn btn-secondary">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- /New Service Request -->
