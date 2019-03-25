<!-- View Service Request -->
<div>
    <div class="row">
        <div class="col-sm-12">
            <div id="info_block"></div>
            <form method="POST" action="<?php echo $pageURL; ?>">
                <div class="btn-group float-right" role="group" aria-label="Status">
                    <?php
                    if( hasRole('USER_ADMIN') && strcmp($serviceRequest['status'], 'Initiated') == 0){
                        $equipmentFullName = "{$serviceRequest['equipment_name']}, {$serviceRequest['equipment_model']}, {$serviceRequest['equipment_serial_number']}";
                    ?>
                    <button id="service-request-receive" type="button" class="btn btn-sm btn-outline-success"
                        data-service-request-id="<?php echo $serviceRequest['service_request_id']; ?>"
                        data-service-request-facility="<?php echo $serviceRequest['facility_name']; ?>"
                        data-service-request-equipment="<?php echo $equipmentFullName; ?>"
                        data-service-request-action="Accept" data-toggle="modal"
                        data-target="#serviceRequestAcceptModal">
                        Receive
                    </button>
                    <button id="service-request-reject" type="button" class="btn btn-sm btn-outline-danger"
                        data-service-request-id="<?php echo $serviceRequest['service_request_id']; ?>"
                        data-service-request-facility="<?php echo $serviceRequest['facility_name']; ?>"
                        data-service-request-equipment="<?php echo $equipmentFullName; ?>"
                        data-service-request-action="Reject" data-toggle="modal"
                        data-target="#serviceRequestAcceptModal">
                        Reject
                    </button>
                    <?php
                    } 
                    ?>
                    <button type="button" class="btn btn-sm btn-outline-dark" onclick="window.history.back()">
                        Close
                    </button>
                </div>
            </form>
        </div>
    </div>
    <br>
    <div class="card">
        <div class="card-body" style="font-size: 0.8rem;">
            <h5 class="card-title">Calibration Service Request</h5>
            <hr />
            <?php 
            $statusColor = ['Initiated'=>'info', 'Received' => 'success', 'Rejected' => 'danger'];

            if(hasRole('USER_ADMIN')){ 
            ?>
            <div class="form-group row">
                <label class="col-form-label col-sm-4">
                    Facility
                </label>
                <span><?php echo $serviceRequest['facility_name']; ?></span>
            </div>
        <?php } ?>
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

            <?php
            if(isset($serviceRequest['rejection_reason'])){
            ?>
            <div class="form-group row">
                <label class="col-form-label col-sm-4">
                    Rejection reason
                </label>
                <span><?php echo $serviceRequest['rejection_reason']['comment']; ?></span>
            </div>
            <?php
            }
            ?>

            <div class="form-group row">
                <label class="col-form-label col-sm-4">
                    Calibration Interval
                </label>
                <span><?php echo $serviceRequest['calibration_interval']; ?> months</span>
            </div>
            <hr />
            <div>
                <div><label>Equipment Status</label></div>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-sm">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Action/Status</th>
                                <th>Performed By</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            foreach ($serviceRequest['stati'] as $status) {
                            ?>
                                <tr>
                                    <td><?php echo substr($status['done_at'], 0, 16); ?></td>
                                    <td>
                                        <span class="badge badge-<?php echo $statusColor[$status['status_text']]; ?>">
                                            <?php echo $status['status_text']; ?>
                                        </span>
                                    </td>
                                    <td><?php echo $status['name']; ?></td>
                                </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <?php
            if(isset($serviceRequest['rejection_reason'])){
            ?>
                <hr />
                <div class="form-group row">
                    <label class="col-form-label col-sm-4">
                        Rejection Reason
                    </label>
                    <span><?php echo $serviceRequest['rejection_reason']['comment']; ?></span>
                </div>
            <?php
            }
            ?>

        </div>
    </div>
</div>
<!-- /View Service Request -->
