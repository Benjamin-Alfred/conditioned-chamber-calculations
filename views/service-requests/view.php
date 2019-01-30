<!-- View Service Request -->
<div>
    <div class="row">
        <div class="col-sm-12">
            <div id="info_block"></div>
            <button class="btn-nav-coe float-right btn-info" onclick="window.history.back()" title="Back">
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
            <div class="form-group row">
                <label class="col-form-label col-sm-4">
                    Date Requested
                </label>
                <span><?php echo $serviceRequest['request_date']; ?></span>
            </div>
            <div class="form-group row">
                <label class="col-form-label col-sm-4">
                    Equipment Name
                </label>
                <span><?php echo $serviceRequest['equipment_name']; ?></span>
            </div>
            <div class="form-group row">
                <label class="col-form-label col-sm-4">
                    Manufacturer
                </label>
                <span><?php echo $serviceRequest['manufacturer_name']; ?></span>
            </div>
            <div class="form-group row">
                <label class="col-form-label col-sm-4">
                    Model
                </label>
                <span><?php echo $serviceRequest['equipment_model']; ?></span>
            </div>
            <div class="form-group row">
                <label class="col-form-label col-sm-4">
                    Serial Number
                </label>
                <span><?php echo $serviceRequest['equipment_serial_number']; ?></span>
            </div>
            <div class="form-group row">
                <label class="col-form-label col-sm-4">
                    Inventory Number
                </label>
                <span><?php echo $serviceRequest['equipment_inventory_number']; ?></span>
            </div>

            <div class="form-group row">
                <label class="col-form-label col-sm-4">
                    Comments
                </label>
                <span><?php echo $serviceRequest['comments']; ?></span>
            </div>

            <div class="form-group row">
                <label class="col-form-label col-sm-4">
                    Service Request Status
                </label>
                <span><?php echo $serviceRequest['status']; ?></span>
            </div>

            <div class="form-group row">
                <label class="col-form-label col-sm-4">
                    Calibration Interval
                </label>
                <span><?php echo $serviceRequest['calibration_interval']; ?> months</span>
            </div>

            <div class="form-group row">
                <label class="col-form-label col-sm-4">
                    Requested By
                </label>
                <span><?php echo $serviceRequest['requested_by']; ?></span>
            </div>

        </div>
    </div>
</div>
<!-- /View Service Request -->
