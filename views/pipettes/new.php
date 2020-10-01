<!-- Pipette Calculations -->
<div>
    <form name="ccc_back" method="POST" action="<?php echo get_site_url(); ?>/pipettes/">
        <button class="btn btn-sm btn-outline-dark float-right" onclick="document.ccc_back.submit">Back</button>
    </form>
    <br>
    <br>
    <form enctype="multipart/form-data" method="POST" action="<?php echo get_site_url(); ?>/pipettes/">
        <input type="hidden" name="form_ready_for_submit" value="false" />
        <input type="hidden" name="show_calibration_certificate" value="false" />

        <div class="card">
            <div class="card-body">
                <div class="row">
                    <label class="col-form-label col-sm-4">XML Schema:</label>
                    <div class="form-check form-check-inline">
                        <input id="schema_1" name="xml_schema_type" type="radio" class="form-check-input" value="METTLER" checked />
                        <label id="schema_1" class="form-check-label">METTLER</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input id="schema_2" name="xml_schema_type" type="radio" class="form-check-input" value="OTHER" />
                        <label id="schema_2" class="form-check-label">OTHER</label>
                    </div>
                </div>
                <div class="form-group row">
                    <label id="validity" class="col-form-label col-sm-4">Certificate Validity:</label>
                    <select class="custom-select col-sm-6" name="validity">
                        <option value="3">3 months</option>
                        <option value="6">6 months</option>
                        <option value="12" selected>12 Months</option>
                    </select>
                </div>
                <div class="form-group row">
                    <label for="model" class="col-form-label col-sm-4">Select Metler XML File:</label>
                    <input type="hidden" name="MAX_FILE_SIZE" value="300000" />
                    <!-- Name of input element determines name in $_FILES array -->
                    <input name="mettler_xml" type="file" class="form-control col-sm-6" required />
                </div>
                <div class="form-group row">
                    <div class="col-sm-4">&nbsp;</div>
                    <?php
                        if(hasRole('CALIBRATOR')){
                    ?>
                    <button class="btn btn-sm btn-outline-dark">Upload</button>
                    <?php
                        }else{
                    ?>
                    <span class="btn btn-sm btn-warning">No upload permissions!</span>
                    <?php
                        }
                    ?>
                </div>
            </div>
        </div>
    </form>
</div>
<!-- /Pipette Calculations -->
