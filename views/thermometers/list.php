<!-- List Conditioned Chamber Items -->
<div class="row justify-content-end" style="padding-bottom: 20px;">
    <form name="ccc_post" method="POST" action="<?php echo get_site_url(); ?>/thermometers/">
        <input type="hidden" name="calibration_calculation" value="false" />
    <?php
        if(hasRole('CALIBRATOR')){
    ?>
        <button class="btn btn-sm btn-outline-dark" onclick="document.ccc_post.submit()">
            <strong><span aria-hidden="true">&plus;</span> New Calculation </strong>
        </button>
    <?php
        }
    ?>
    </form>
</div>
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
                    $badge = ['FAIL'=>'danger', 'PASS'=>'success', 'PENDING'=>'warning'];
                    echo "<td><span class='badge badge-".$badge[$certicate->result]."'>".$certicate->result."</span></td>";
            ?>
                    <td><form name="ccc_cert" method="POST" action="<?php echo get_site_url(); ?>/thermometers/">
                        <input type="hidden" name="show_calibration_certificate" value="false" />
                        <input type="hidden" name="ccc_id" value="<?php echo $certicate->id; ?>" />
                        <button class="btn btn-sm btn-outline-dark" onclick="document.ccc_cert.submit()">View</button>
                    </form>
                    </td></tr>
            <?php
                }
            ?>
        </tbody>
    </table>
</div>
<!-- / List Conditioned Chamber Items -->
