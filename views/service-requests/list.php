<!-- List Client Service Requests -->
<div class="row justify-content-end" style="padding-bottom: 20px;">
    <form name="ccc_post" method="POST" action="<?php echo get_site_url(); ?>/clients/">
        <input type="hidden" name="api_code" value="9">
        <button onclick="document.ccc_post.submit()" title="New Service Request" class="btn-nav-coe btn-info">
            &plus;
        </button>
        <button class="float-right btn-nav-coe btn-info" onclick="window.history.back();" title="Back">
            <svg class="icon icon-arrow-left" aria-hidden="true" role="img">
                <use href="#icon-arrow-left" xlink:href="#icon-arrow-left"></use>
            </svg>
        </button>
    </form>
</div>
<div class="">
    <table class="table table-striped table-sm" style="font-size: 0.9em;" id="service-request-list" data-page-length="25">
        <thead>
            <tr>
                <th scope="col" title="Request Date">Date</th>
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
                foreach ($serviceRequests as $serviceRequest) {
                    echo "<tr><td>".substr($serviceRequest['request_date'],0,10)."</td>";
                    echo "<td>{$serviceRequest['equipment_name']}</td>";
                    echo "<td>{$serviceRequest['equipment_model']}</td>";
                    echo "<td>{$serviceRequest['equipment_serial_number']}</td>";
                    echo "<td>{$serviceRequest['requested_by']}</td>";
                    echo "<td>{$serviceRequest['status']}</td>";
            ?>
                    <td>
                        <form method="POST" action="<?php echo get_site_url(); ?>/clients/">
                            <input type="hidden" name="api_code" value="11">
                            <input type="hidden" name="service_request_id" 
                                value="<?php echo $serviceRequest['service_request_id']; ?>" />
                            <button class="btn btn-sm btn-outline-dark">View</button>
                        </form>
                    </td></tr>
            <?php
                }
            ?>
        </tbody>
    </table>
</div>
<!-- / List Client Service Requests -->
