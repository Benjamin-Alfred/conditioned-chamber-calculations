<!-- List Registered Users -->
<?php
    if(hasRole('REVIEWER')){
?>
<div class="row justify-content-end" style="padding-bottom: 20px;">
    <form name="ccc_post" method="POST" action="<?php echo get_site_url(); ?>/registration/">
        <input type="hidden" name="calibration_calculation" value="false" />
        <button class="btn btn-sm btn-outline-dark" onclick="document.ccc_post.submit()">
            <strong><span aria-hidden="true">&plus;</span> New User </strong>
        </button>
    </form>
</div>
<div class="table-responsive">
    <table class="table table-striped table-sm">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Facility</th>
                <th scope="col">Contact Person</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
                $counter = 1;
                foreach ($certicates as $certicate) {
                    echo "<tr><td>".$counter++."</td>";
                    echo "<td>$certicate->client_name</td>";
                    echo "<td>$certicate->equipment_serial_number</td>";
            ?>
                    <td><form name="ccc_cert" id="ccc_cert" method="POST" action="<?php echo get_site_url(); ?>/registration/">
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
<?php
    }else{
        
    }
?>
<!-- / List Registered Users -->
