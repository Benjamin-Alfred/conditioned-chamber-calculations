<!-- Show Calibration Certificate -->
<div class="certificate-frame">
    <div class="row justify-content-end d-print-none">
        <div class="col">
            <form name="ccc_back" id="ccc_back" method="POST"
                action="<?php echo get_site_url(); ?>/pipettes/">
                <input type="hidden" name="ccc_id" id="ccc_id" value="<?php echo $requestedCertificate; ?>">
                <input type="hidden" name="certificate_details" id="certificate_details" value="<?php echo base64_encode(json_encode($certification)); ?>">
                <input type="hidden" name="validity" id="validity" value="<?php echo $validity; ?>">
                <input type="hidden" name="xml_schema_type" id="xml_schema_type" value="<?php echo $schema; ?>">
                <div class="btn-group float-right" role="group" aria-label="Status">
                    <?php
                    if(strcmp($certification['result'], "PENDING") != 0 && hasRole('APPROVER')){
                    ?>
                    <button id="btn_approve" type="button" class="btn btn-sm btn-outline-dark">
                        Approve
                    </button>
                    <?php
                    }

                    if(strcmp($certification['result'], "PENDING") == 0 && hasRole('REVIEWER')){
                    ?>
                    <button id="status-pass" type="button" class="btn btn-sm btn-outline-dark">
                        Pass
                    </button>
                    <button id="status-fail" type="button" class="btn btn-sm btn-outline-dark">
                        Fail
                    </button>
                    <?php
                    }
                    if($certification['result'] === 1){
                    ?>
                    <button id="save-imported-certificate" type="button" class="btn btn-sm btn-outline-dark">
                        Save
                    </button>
                    <?php
                    }
                    ?>
                    <button class="btn btn-sm btn-outline-dark" onclick="document.ccc_back.submit">
                        Close
                    </button>
                </div>
            </form>
        </div>
    </div>
    <div class="certificate-inner-frame">
        <div class="report-header">
            <div class="row">
                <div class="nphl-address col-5" style="font-size: 0.65em;">
                    <strong>
                        NATIONAL PUBLIC HEALTH LABORATORY<br>
                        EQUIPMENT CALIBRATION CENTER<br>
                        P.O BOX   20750-00202<br>
                        NAIROBI, KENYA.<br>
                    </strong>
                    EMAIL: coe.nphl@gmail.com<br>
                    WEBSITE: nphl.go.ke
                </div>
                <div class="col-2">
                    <img src="<?php bloginfo('template_url'); ?>-child/i/coat_of_arms.png" style="width: 90%;height: 90%;">
                </div>
                <div class="col-5" style="text-align: right;">
                    <span style="font-size: 0.55em; "><strong>CERTIFICATE NUMBER</strong></span>
                    <span style="font-size: 0.65em; display: inline-block;border: 1px solid #000;padding: 0 10px;">
                        <?php echo $certification['certificate_number'];?>
                    </span>
                    <div>
                        <img style="width:85px;height:85px;margin-top:5px;" src="<?php bloginfo('template_url'); ?>-child/i/kenas_logo.jpg">
                    </div>
                </div>
            </div>
            <div class="row">
                <div style="text-align:center;font-size: 0.9em;" class="col-12">
                    <strong>CALIBRATION CERTIFICATE</strong>
                </div>
            </div>
        </div>
        <!-- Client and Pipette Details-->
        <div style="margin-top: 11px;">
            <table class="table table-sm table-borderless" border="0">
                <tbody style="font-size: 0.77em;">
                    <tr>
                        <td>Pipette Serial Number</td>
                        <td>
                            <?php echo $certification['Pipette']['SN'];?>
                        </td>
                        <td>Owner Company</td>
                        <td>
                            <?php echo $certification['Contact'][0]['Company'];?>
                        </td>
                    </tr>
                    <tr>
                        <td>Pipette Second ID</td>
                        <td>
                            <?php echo $certification['Pipette']['SndID'];?>
                        </td>
                        <td>Owner Department</td>
                        <td>
                            <?php echo $certification['Contact'][0]['Department'];?>
                        </td>
                    </tr>
                    <tr>
                        <td>Pipette Type</td>
                        <td>
                            <?php echo $certification['Pipette']['Name'];?>
                        </td>
                        <td>Owner Name</td>
                        <td>
                            <?php echo $certification['Contact'][0]['FirstName'];?>
                            <?php echo $certification['Contact'][0]['LastName'];?>
                        </td>
                    </tr>
                    <tr>
                        <td>Manufacturer</td>
                        <td>
                            <?php echo $certification['Pipette']['Manufacturer'];?>
                        </td>
                        <td>Method Description</td>
                        <td>
                            <?php echo $certification['Method']['Description'];?>
                        </td>
                    </tr>
                    <tr>
                        <td>Method</td>
                        <td>
                            <?php echo $certification['Method']['Name'];?>
                        </td>
                        <td colspan="2">&nbsp;</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <!-- /Client and Pipette Details-->
        <!-- Test Conditions & Balance-->
        <div style="margin-top: 10px;padding-top:10px;border-top:1px solid #000;">
            <table class="table table-sm table-borderless" border="0">
                <thead>
                    <tr style="font-size: 0.9em;">
                        <th colspan="2">Test Conditions</th>
                        <th colspan="2">Balance</th>
                    </tr>
                </thead>
                <tbody style="font-size: 0.77em;">
                    <tr>
                        <td>Water Temperature</td>
                        <td>
                            <?php echo $certification['CalibrationData']['Test'][0]['Environment'][0]['TemperatureWater'];?> °C
                        </td>
                        <td>Serial Number</td>
                        <td>
                            <?php echo $certification['Device']['Balance']['SN'];?>
                        </td>
                    </tr>
                    <tr>
                        <td>Humidity</td>
                        <td>
                            <?php echo $certification['CalibrationData']['Test'][0]['Environment'][0]['Humidity'];?> %
                        </td>
                        <td>Name</td>
                        <td>
                            <?php echo $certification['Device']['Balance']['Name'];?>
                        </td>
                    </tr>
                    <tr>
                        <td>Abs. Air Pressure</td>
                        <td>
                            <?php echo $certification['CalibrationData']['Test'][0]['Environment'][0]['Pressure'];?> hPA
                        </td>
                        <td>Model</td>
                        <td>
                            <?php echo $certification['Device']['Balance']['Name'];?>
                        </td>
                    </tr>
                    <tr>
                        <td>Z-Factor</td>
                        <td>
                            <?php echo $certification['CalibrationData']['Test'][0]['ZFactor'];?>
                        </td>
                        <td>Readability</td>
                        <td>
                            <?php echo $certification['Device']['Balance']['Sensibility'];?> g
                        </td>
                    </tr>
                    <tr>
                        <td>Z-Factor Reference</td>
                        <td>ISO 8655</td>
                        <td>Location</td>
                        <td>
                            <?php echo $certification['Device']['Balance']['Location'][0];?>
                        </td>
                    </tr>
                    <tr>
                        <td>Evaporation</td>
                        <td>
                            <?php echo $certification['CalibrationData']['Test'][0]['Evaporation'];?> µl/Cycle
                        </td>
                        <td>Tips</td>
                        <td>
                            <?php echo $certification['CalibrationData']['Test'][0]['Tips'];?>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <!-- /Test Conditions & Balance-->
        <!-- Readings as returned -->
        <div style="margin-top: 10px;padding-top:10px;border-top:1px solid #000;">
            <div style="font-size: 0.9em;"><center><strong>As Returned</strong></center></div>
            <div class="row" style="font-size: 0.77em;">
                <div class="col">
                    Weighings [g]/[µl]
                </div>
                <?php
                    if(isset($certification['Method']['Sample'][0]['Volume'])){
                ?>
                <div class="col">
                    <table class="table table-sm table-borderless" border="0">
                        <tbody>
                            <tr>
                                <td colspan="2" style="text-align: center;font-weight: bold;border-bottom: 1px solid #000;">
                                    <?php echo $certification['Method']['Sample'][0]['Volume'];?> µl
                                </td>
                            </tr>
                            <?php
                             foreach ($certification['CalibrationData']['Test'][0]['TestData']['Volume'][0]['Reading'] as $reading) {
                                 ?>
                                <tr>
                                    <td style="border-right: 1px solid #000; text-align: right;">
                                        <?php echo number_format($reading['Channel']['Weight']/1000/$certification['CalibrationData']['Test'][0]['ZFactor'],5);?>
                                    </td>
                                    <td>
                                        <?php echo $reading['Channel']['Weight'];?>
                                    </td>
                                </tr>
                                 <?php
                             }
                            ?>
                        </tbody>
                    </table>
                </div>
                <?php
                    } 

                    if(isset($certification['Method']['Sample'][1]['Volume'])){
                ?>
                <div class="col">
                    <table class="table table-sm table-borderless" border="0">
                        <tbody>
                            <tr>
                                <td colspan="2" style="text-align: center;font-weight: bold;border-bottom: 1px solid #000;">
                                    <?php echo $certification['Method']['Sample'][1]['Volume'];?> µl
                                </td>
                            </tr>
                            <?php
                             foreach ($certification['CalibrationData']['Test'][0]['TestData']['Volume'][1]['Reading'] as $reading) {
                                 ?>
                                <tr>
                                    <td style="border-right: 1px solid #000; text-align: right;">
                                        <?php echo number_format($reading['Channel']['Weight']/1000/$certification['CalibrationData']['Test'][0]['ZFactor'],5);?>
                                    </td>
                                    <td>
                                        <?php echo $reading['Channel']['Weight'];?>
                                    </td>
                                </tr>
                                 <?php
                             }
                            ?>
                        </tbody>
                    </table>
                </div>
                <?php
                    } 

                    if(isset($certification['Method']['Sample'][2]['Volume'])){
                ?>
                <div class="col">
                    <table class="table table-sm table-borderless" border="0">
                        <tbody>
                            <tr>
                                <td colspan="2" style="text-align: center;font-weight: bold;border-bottom: 1px solid #000;">
                                    <?php echo $certification['Method']['Sample'][2]['Volume'];?> µl
                                </td>
                            </tr>
                            <?php
                             foreach ($certification['CalibrationData']['Test'][0]['TestData']['Volume'][2]['Reading'] as $reading) {
                                 ?>
                                <tr>
                                    <td style="border-right: 1px solid #000; text-align: right;">
                                        <?php echo number_format($reading['Channel']['Weight']/1000/$certification['CalibrationData']['Test'][0]['ZFactor'],5);?>
                                    </td>
                                    <td>
                                        <?php echo $reading['Channel']['Weight'];?>
                                    </td>
                                </tr>
                                 <?php
                             }
                            ?>
                        </tbody>
                    </table>
                </div>
                <?php
                    } 
                ?>
            </div>
        </div>
        <!-- /Readings as returned -->
        <!-- /Results -->
        <div style="margin-top: 11px;border-bottom: 1px solid #000;">
            <div class="row" style="font-size: 0.77em;">
                <div class="col">
                    <table class="table table-sm table-borderless" border="0">
                        <tbody>
                            <tr><td>&nbsp;</td></tr>
                            <tr><td>Mean [µl]</td></tr>
                            <tr><td>Systematic Error [µl]</td></tr>
                            <tr><td>Systematic Error [%]</td></tr>
                            <tr><td>Random Error [µl]</td></tr>
                            <tr><td>Random Error [%]</td></tr>
                            <tr><td>Uncertainty meas. [µl]</td></tr>
                            <tr><td><strong>Status</strong></td></tr>
                            <tr><td><strong>Status</strong></td></tr>
                        </tbody>
                    </table>
                </div>
                <?php
                    if(isset($certification['Method']['Sample'][0]['Volume'])){
                ?>
                <div class="col">
                    <table class="table table-sm table-borderless" border="0">
                        <tbody>
                            <tr>
                                <td style="text-align: center;font-weight: bold;border-bottom: 1px solid #000;border-right: 1px solid #000;">
                                    Results
                                </td>
                                <td style="text-align: center;font-weight: bold;border-bottom: 1px solid #000;">
                                    Limits
                                </td>
                            </tr>
                            <tr>
                                <td style="border-right: 1px solid #000; text-align: right;">
                                    <?php echo number_format($certification['CalibrationData']['Test'][0]['TestData']['Volume'][0]['Statistics']['Channel']['Mean'],3);?>
                                </td>
                                <td>&nbsp;</td>
                            </tr>
                            <tr>
                                <td style="border-right: 1px solid #000; text-align: right;font-weight: bold;">
                                    <?php echo number_format($certification['CalibrationData']['Test'][0]['TestData']['Volume'][0]['Statistics']['Channel']['SEul'],2);?>
                                </td>
                                <td><strong>± <?php echo number_format($certification['Method']['Sample'][0]['SE'],1);?></strong></td>
                            </tr>
                            <tr>
                                <td style="border-right: 1px solid #000; text-align: right;">
                                    <?php echo $certification['CalibrationData']['Test'][0]['TestData']['Volume'][0]['Statistics']['Channel']['SE'];?>
                                </td>
                                <td>&nbsp;</td>
                            </tr>
                            <tr>
                                <td style="border-right: 1px solid #000; text-align: right;font-weight: bold;">
                                    <?php echo number_format($certification['CalibrationData']['Test'][0]['TestData']['Volume'][0]['Statistics']['Channel']['REul'],2);?>
                                </td>
                                <td><strong><?php echo number_format($certification['Method']['Sample'][0]['RE'],1);?></strong></td>
                            </tr>
                            <tr>
                                <td style="border-right: 1px solid #000; text-align: right;">
                                    <?php echo number_format($certification['CalibrationData']['Test'][0]['TestData']['Volume'][0]['Statistics']['Channel']['RE'],2);?>
                                </td>
                                <td>&nbsp;</td>
                            </tr>
                            <tr>
                                <td style="border-right: 1px solid #000; text-align: right;">
                                    <?php echo number_format(($certification['CalibrationData']['Test'][0]['TestData']['Volume'][0]['Statistics']['Channel']['SEul']+(2*$certification['CalibrationData']['Test'][0]['TestData']['Volume'][0]['Statistics']['Channel']['REul'])),3);?>
                                </td>
                                <td>&nbsp;</td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <center><strong>
                                    <?php
                                    if (abs($certification['CalibrationData']['Test'][0]['TestData']['Volume'][0]['Statistics']['Channel']['SEul'])<$certification['Method']['Sample'][0]['SE'] && $certification['CalibrationData']['Test'][0]['TestData']['Volume'][0]['Statistics']['Channel']['REul'] < $certification['Method']['Sample'][0]['RE']) {
                                        echo "Passed";
                                    }else{
                                        echo "Failed";
                                    }
                                    ?>
                                    </strong></center>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <center><strong>
                                    <?php
                                    if ((abs($certification['CalibrationData']['Test'][0]['TestData']['Volume'][0]['Statistics']['Channel']['SEul'])<$certification['Method']['Sample'][0]['SE'] && $certification['CalibrationData']['Test'][0]['TestData']['Volume'][0]['Statistics']['Channel']['REul'] < $certification['Method']['Sample'][0]['RE']) &&
                                        (abs($certification['CalibrationData']['Test'][0]['TestData']['Volume'][1]['Statistics']['Channel']['SEul'])<$certification['Method']['Sample'][1]['SE'] && $certification['CalibrationData']['Test'][0]['TestData']['Volume'][1]['Statistics']['Channel']['REul'] < $certification['Method']['Sample'][1]['RE']) &&
                                        (abs($certification['CalibrationData']['Test'][0]['TestData']['Volume'][2]['Statistics']['Channel']['SEul'])<$certification['Method']['Sample'][2]['SE'] && $certification['CalibrationData']['Test'][0]['TestData']['Volume'][2]['Statistics']['Channel']['REul'] < $certification['Method']['Sample'][2]['RE'])) {
                                        echo "Passed";
                                    }else{
                                        echo "Failed";
                                    }
                                    ?>
                                    </strong></center>
                                </td>
                            </tr>
                         </tbody>
                    </table>
                </div>
                <?php
                    } 

                    if(isset($certification['Method']['Sample'][1]['Volume'])){
                ?>
                <div class="col">
                    <table class="table table-sm table-borderless" border="0">
                        <tbody>
                            <tr>
                                <td style="text-align: center;font-weight: bold;border-bottom: 1px solid #000;border-right: 1px solid #000;">
                                    Results
                                </td>
                                <td style="text-align: center;font-weight: bold;border-bottom: 1px solid #000;">
                                    Limits
                                </td>
                            </tr>
                            <tr>
                                <td style="border-right: 1px solid #000; text-align: right;">
                                    <?php echo number_format($certification['CalibrationData']['Test'][0]['TestData']['Volume'][1]['Statistics']['Channel']['Mean'],3);?>
                                </td>
                                <td>&nbsp;</td>
                            </tr>
                            <tr>
                                <td style="border-right: 1px solid #000; text-align: right;font-weight: bold;">
                                    <?php echo number_format($certification['CalibrationData']['Test'][0]['TestData']['Volume'][1]['Statistics']['Channel']['SEul'],2);?>
                                </td>
                                <td><strong>± <?php echo number_format($certification['Method']['Sample'][1]['SE'],1);?></strong></td>
                            </tr>
                            <tr>
                                <td style="border-right: 1px solid #000; text-align: right;">
                                    <?php echo $certification['CalibrationData']['Test'][0]['TestData']['Volume'][1]['Statistics']['Channel']['SE'];?>
                                </td>
                                <td>&nbsp;</td>
                            </tr>
                            <tr>
                                <td style="border-right: 1px solid #000; text-align: right;font-weight: bold;">
                                    <?php echo number_format($certification['CalibrationData']['Test'][0]['TestData']['Volume'][1]['Statistics']['Channel']['REul'],2);?>
                                </td>
                                <td><strong><?php echo number_format($certification['Method']['Sample'][1]['RE'],1);?></strong></td>
                            </tr>
                            <tr>
                                <td style="border-right: 1px solid #000; text-align: right;">
                                    <?php echo number_format($certification['CalibrationData']['Test'][0]['TestData']['Volume'][1]['Statistics']['Channel']['RE'],2);?>
                                </td>
                                <td>&nbsp;</td>
                            </tr>
                            <tr>
                                <td style="border-right: 1px solid #000; text-align: right;">
                                    <?php echo number_format(($certification['CalibrationData']['Test'][0]['TestData']['Volume'][1]['Statistics']['Channel']['SEul']+(2*$certification['CalibrationData']['Test'][0]['TestData']['Volume'][1]['Statistics']['Channel']['REul'])),3);?>
                                </td>
                                <td>&nbsp;</td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <center><strong>
                                    <?php
                                    if (abs($certification['CalibrationData']['Test'][0]['TestData']['Volume'][1]['Statistics']['Channel']['SEul'])<$certification['Method']['Sample'][1]['SE'] && $certification['CalibrationData']['Test'][0]['TestData']['Volume'][1]['Statistics']['Channel']['REul'] < $certification['Method']['Sample'][1]['RE']) {
                                        echo "Passed";
                                    }else{
                                        echo "Failed";
                                    }
                                    ?>
                                    </strong></center>
                                </td>
                            </tr>
                         </tbody>
                    </table>
                </div>
                <?php
                    } 

                    if(isset($certification['Method']['Sample'][2]['Volume'])){
                ?>
                <div class="col">
                    <table class="table table-sm table-borderless" border="0">
                        <tbody>
                            <tr>
                                <td style="text-align: center;font-weight: bold;border-bottom: 1px solid #000;border-right: 1px solid #000;">
                                    Results
                                </td>
                                <td style="text-align: center;font-weight: bold;border-bottom: 1px solid #000;">
                                    Limits
                                </td>
                            </tr>
                            <tr>
                                <td style="border-right: 1px solid #000; text-align: right;">
                                    <?php echo number_format($certification['CalibrationData']['Test'][0]['TestData']['Volume'][2]['Statistics']['Channel']['Mean'],3);?>
                                </td>
                                <td>&nbsp;</td>
                            </tr>
                            <tr>
                                <td style="border-right: 1px solid #000; text-align: right;font-weight: bold;">
                                    <?php echo number_format($certification['CalibrationData']['Test'][0]['TestData']['Volume'][2]['Statistics']['Channel']['SEul'],2);?>
                                </td>
                                <td><strong>± <?php echo number_format($certification['Method']['Sample'][2]['SE'],1);?></strong></td>
                            </tr>
                            <tr>
                                <td style="border-right: 1px solid #000; text-align: right;">
                                    <?php echo $certification['CalibrationData']['Test'][0]['TestData']['Volume'][2]['Statistics']['Channel']['SE'];?>
                                </td>
                                <td>&nbsp;</td>
                            </tr>
                            <tr>
                                <td style="border-right: 1px solid #000; text-align: right;font-weight: bold;">
                                    <?php echo number_format($certification['CalibrationData']['Test'][0]['TestData']['Volume'][2]['Statistics']['Channel']['REul'],2);?>
                                </td>
                                <td><strong><?php echo number_format($certification['Method']['Sample'][2]['RE'],1);?></strong></td>
                            </tr>
                            <tr>
                                <td style="border-right: 1px solid #000; text-align: right;">
                                    <?php echo number_format($certification['CalibrationData']['Test'][0]['TestData']['Volume'][2]['Statistics']['Channel']['RE'],2);?>
                                </td>
                                <td>&nbsp;</td>
                            </tr>
                            <tr>
                                <td style="border-right: 1px solid #000; text-align: right;">
                                    <?php echo number_format(($certification['CalibrationData']['Test'][0]['TestData']['Volume'][2]['Statistics']['Channel']['SEul']+(2*$certification['CalibrationData']['Test'][0]['TestData']['Volume'][2]['Statistics']['Channel']['REul'])),3);?>
                                </td>
                                <td>&nbsp;</td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <center><strong>
                                    <?php
                                    if (abs($certification['CalibrationData']['Test'][0]['TestData']['Volume'][2]['Statistics']['Channel']['SEul'])<$certification['Method']['Sample'][2]['SE'] && $certification['CalibrationData']['Test'][0]['TestData']['Volume'][2]['Statistics']['Channel']['REul'] < $certification['Method']['Sample'][2]['RE']) {
                                        echo "Passed";
                                    }else{
                                        echo "Failed";
                                    }
                                    ?>
                                    </strong></center>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <?php
                    } 
                ?>
            </div>
        </div>
        <div style="font-size: 0.7em;">
            <!-- <p>This certificate is valid until <strong><?php echo $certification['CalibrationData']['NextDue']; ?></strong></p> -->
            <p>This certificate is valid until <strong><?php echo $certification['certificate_validity']; ?></strong></p>
            <table class="table table-sm table-borderless" border="0">
                <tr>
                    <td class="signatories-label-left">PERFORMED BY</td>
                    <td class="signatories-space">
                        <?php echo $certification['creator']['display_name']; ?>
                    </td>
                    <td class="signatories-label">DATE</td>
                    <td class="signatories-space">
                        <?php echo substr($certification['date_performed'], 0, 10); ?>
                    </td>
                    <td class="signatories-label">SIGN</td>
                    <td class="signatories-space">
                        <?php
                            $creatorSignature = get_template_directory_uri()."-child/i/signature-".$certification['created_by'].".png";
                        ?>
                        <img src="<?php echo $creatorSignature ?>" alt="Sign here" class="signatories-image" />
                    </td>
                </tr>
                <tr>
                    <td class="signatories-label-left">REVIEWED BY</td>
                    <td class="signatories-space">
                        <?php echo isset($certification['verifier']['display_name'])?$certification['verifier']['display_name']:""; ?>
                    </td>
                    <td class="signatories-label">DATE</td>
                    <td class="signatories-space">
                        <?php echo substr($certification['verified_at'], 0, 10); ?>
                    </td>
                    <td class="signatories-label">SIGN</td>
                    <td class="signatories-space">
                        <?php
                        if(isset($certification['verified_by'])){
                            $verifierSignature = get_template_directory_uri()."-child/i/signature-".$certification['verified_by'].".png";
                        ?>
                            <img src="<?php echo $verifierSignature ?>" alt="Sign here" 
                                class="signatories-image" />
                        <?php
                        }
                        ?>
                    </td>
                </tr>
                <tr>
                    <td class="signatories-label-left">APPROVED BY</td>
                    <td class="signatories-space">
                        <?php echo isset($certification['approver']['display_name'])?$certification['approver']['display_name']:""; ?>
                    </td>
                    <td class="signatories-label">DATE</td>
                    <td class="signatories-space">
                        <?php echo substr($certification['approved_at'], 0, 10); ?>
                    </td>
                    <td class="signatories-label">SIGN</td>
                    <td class="signatories-space">
                        <?php
                        if(isset($certification['approved_by'])){
                            $approverSignature = get_template_directory_uri()."-child/i/signature-".$certification['approved_by'].".png";
                        ?>
                            <img src="<?php echo $approverSignature; ?>" alt="signature" 
                                class="signatories-image" />
                        <?php
                        }
                        ?>
                    </td>
                </tr>
                <tr>
                    <td> &nbsp; </td>
                    <td colspan="5">For Head NPHL </td>
                </tr>
            </table>
        </div>
        <div style="font-size: 0.76em;">
            <p>The reported uncertainties of measurements were calculated and expressed in 
            accordance with EA-4/02 publication and were based on a standard uncertainty multiplied
            by a coverage factor of k=2, which, unless stated otherwise provides a level of 
            confidence of approximately 95%.</p>
            <p>
                Calibration certificate issued without signature is not valid. This certificate has been issued without any alteration and may not be reproduced other than in full and with the approval of the head of NPHL-COE. If undelivered please return to the above address.
            </p>
        </div>
    </div>
    <div class="row" style="font-size: 0.7em;">
        <div class="col">
            <center>Page 1 of 1</center>
        </div>
    </div>
</div>
<!-- /Show Calibration Certificate -->
