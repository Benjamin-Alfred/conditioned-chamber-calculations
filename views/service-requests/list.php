<!-- List Client Service Requests -->
<div class="row justify-content-end" style="padding-bottom: 20px;">
    <form name="ccc_post" method="POST" action="<?php echo $pageURL; ?>">
        <input type="hidden" name="api_code" value="9">
        <?php if(!hasRole('USER_ADMIN')){ ?>
        <button onclick="document.ccc_post.submit()" title="New Service Request" class="btn btn-info" style="border-radius: 0;">
            &plus;
        </button>
        <?php } ?>
    </form>
</div>
<div class="">
    <table class="table table-striped table-sm table-bordered" style="font-size: 0.8rem;" id="service-requests-list" data-page-length="25">
        <thead>
            <tr>
                <th scope="col" title="Request Date">Date</th>
                <?php if(hasRole('USER_ADMIN')){ ?>
                <th scope="col">Facility</th>
                <?php } ?>
                <th scope="col">Equipment</th>
                <th scope="col">Model</th>
                <th scope="col" title="Serial Number">Serial #</th>
                <th scope="col" title="Requested By">Requestor</th>
                <th scope="col">Status</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
                $status = ['Initiated'=>'info', 'Received' => 'success', 'Rejected' => 'danger'];
                foreach ($serviceRequests as $serviceRequest) {
                    echo "<tr><td>".substr($serviceRequest['request_date'],0,10)."</td>";
                    if(hasRole('USER_ADMIN')){
                        echo "<td>{$serviceRequest['facility_name']}</td>";
                    }
                    echo "<td>{$serviceRequest['equipment_name']}</td>";
                    echo "<td>{$serviceRequest['equipment_model']}</td>";
                    echo "<td>{$serviceRequest['equipment_serial_number']}</td>";
                    echo "<td>{$serviceRequest['requested_by']}</td>";
                    echo "<td><span class='badge badge-{$status[$serviceRequest['status']]}'>{$serviceRequest['status']}</span></td>";
            ?>
                    <td>
                        <form method="POST" action="<?php echo $pageURL; ?>" style="display: inline-block;">
                            <?php if(hasRole('USER_ADMIN')){ ?>
                                <input type="hidden" name="facility_id" value="<?php echo $serviceRequest['facility_id']; ?>" />
                                <input type="hidden" name="api_code" value="19">
                            <?php }else{?>
                                <input type="hidden" name="api_code" value="11">
                            <?php } ?>
                            <input type="hidden" name="service_request_id" 
                                value="<?php echo $serviceRequest['service_request_id']; ?>" />
                            <button class="btn btn-sm btn-outline-info">View</button>
                        </form>
                        <?php if(hasRole('USER_ADMIN')){ ?>
                            <form method="POST" action="<?php echo $pageURL; ?>" style="display: inline-block;">
                                <input type="hidden" name="api_code" value="19">
                                <input type="hidden" name="service_request_id" 
                                    value="<?php echo $serviceRequest['service_request_id']; ?>" />
                                <button class="btn btn-sm btn-outline-primary">Calibrate</button>
                            </form>
                        <?php } ?>
                    </td></tr>
            <?php
                }
            ?>
        </tbody>
    </table>
</div>
<!-- / List Client Service Requests -->
