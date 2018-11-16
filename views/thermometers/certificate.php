<!-- Show Calibration Certificate -->
<div class="certificate-frame">
    <div class="row justify-content-end d-print-none">
        <div class="col">
            <form name="ccc_back" id="ccc_back" method="POST"
                action="<?php echo get_site_url(); ?>/thermometers/">
                <input type="hidden" name="ccc_id" id="ccc_id" value="<?php echo $requestedCertificate; ?>">
                <div class="btn-group float-right" role="group" aria-label="Status">
                    <?php
                    if(strcmp($certification->result, "PENDING") != 0 && hasRole('APPROVER')){
                    ?>
                    <button id="btn_approve" type="button" class="btn btn-sm btn-outline-dark">
                        Approve
                    </button>
                    <?php
                    }

                    if(strcmp($certification->result, "PENDING") == 0 && hasRole('REVIEWER')){
                    ?>
                    <button id="status-pass" type="button" class="btn btn-sm btn-outline-dark">
                        Pass
                    </button>
                    <button id="status-fail" type="button" class="btn btn-sm btn-outline-dark">
                        Fail
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
    <div class="report-header">
        <div class="row">
            <div class="nphl-address col-5" style="font-size: 0.65em;">
                <strong>
                    NATIONAL PUBLIC HEALTH LABORATORY<br>
                    EQUIPMENT CALIBRATION CENTER<br>
                    P.O BOX   20750-00202<br>
                    NAIROBI, KENYA.<br>
                </strong>
                EMAIL: nphls.coe@gmail.com<br>
                WEBSITE: nphls.co.ke
            </div>
            <div class="col-2">
                <img src="<?php bloginfo('template_url'); ?>-child/i/coat_of_arms.png">
            </div>
            <div class="col-5" style="text-align: right;">
                <span style="font-size: 0.65em; display: inline-block;border: 1px solid #000;padding: 0 10px;">
                    <?php echo $certification->certificate_number;?>
                </span>
            </div>
        </div>
        <div class="row">
            <div style="text-align:center" class="col-12">
                <strong>CALIBRATION CERTIFICATE</strong>
            </div>
        </div>
    </div>
    <div class="customer-and-equipment-details" style="font-size: 0.7em">
        <table class="table table-bordered table-sm">
            <tr>
                <td colspan="2" style="text-align:center">
                    <strong>CUSTOMER DETAILS</strong>
                </td>
            </tr>
            <tr>
                <td><strong>REQUESTED BY (FACILITY)</strong></td>
                <td><?php echo $certification->client_name;?></td>
            </tr>
            <tr>
                <td><strong>LABORATORY PERSONNEL</strong></td>
                <td><?php echo $certification->client_contact_name;?></td>
            </tr>
            <tr>
                <td><strong>EMAIL OF LAB PERSONNEL</strong></td>
                <td><?php echo $certification->client_contact_email;?></td>
            </tr>
            <tr>
                <td colspan="2" style="text-align:center">
                    <strong>EQUIPMENT DETAILS</strong>
                </td>
            </tr>
            <tr>
                <td><strong>EQUIPMENT</strong></td>
                <td><?php echo $certification->equipment_name; ?></td>
            </tr>
            <tr>
                <td><strong>MANUFACTURER</strong></td>
                <td><?php echo $certification->manufacturer_name;?></td>
            </tr>
            <tr>
                <td><strong>MODEL</strong></td>
                <td><?php echo $certification->equipment_model;?></td>
            </tr>
            <tr>
                <td><strong>SERIAL No.</strong></td>
                <td><?php echo $certification->equipment_serial_number;?></td>
            </tr>
            <tr>
                <td><strong>INVENTORY No.</strong></td>
                <td><?php echo $certification->submission_number;?></td>
            </tr>
        </table>
    </div>
    <div class="standard-equipment" style="font-size: 0.75em">
        <div><strong>1.0 STANDARD TEST EQUIPMENT USED:</strong></div>
        <div style="margin-left: 30px;margin-bottom: 20px;" class="row">
            <div class="col-12">
                <strong>DESCRIPTION:</strong>
                <?php echo $certification->ste_equipment['name'];?>
            </div>
            <div class="col-12">
                <strong>MANUFACTURER:</strong>
                <?php echo $certification->ste_manufacturer['name'];?>
            </div>
            <div class="col-6">
                <strong>MODEL:</strong>
                <?php echo $certification->standard_test_equipment_model;?>
            </div>
            <div class="col-6">
                <strong>SERIAL No:</strong>
                <?php echo $certification->standard_test_equipment_serial_number;?>
            </div>
            <div class="col-6">
                <strong>CERTIFICATE No:</strong>
                <?php echo $certification->standard_test_equipment_certificate_number;?>
            </div>
            <div class="col-6">
                <strong>STICKER No:</strong>
                <?php echo $certification->standard_test_equipment_sticker_number;?>
            </div>
        </div>
    </div>
    <div class="calibration-procedure" style="font-size: 0.75em">
        <div><strong>2.0 CALIBRATION PROCEDURE</strong></div>
        <div style="margin-left: 30px;">
            <p>The equipment was calibrated as per <strong>NPHL/COE/TCP/001</strong> thermometer calibration 
                procedure document. Procedure for digital and analogue thermometers calibration.</p>
            <p>The environmental conditions were recorded during the period of calibration.
                The temperature was
                <strong><?php echo number_format($certification->environmental_temperature, 2);?> </strong>⁰C
                with relative humidity of 
                <strong><?php echo number_format($certification->environmental_humidity, 2);?></strong> %.
            </p>
        </div>
    </div>
    <div class="traceability" style="font-size: 0.75em">
        <div><strong>3.0 TRACEABILITY</strong></div>
        <div style="margin-left: 30px;">
            <p>The thermometer has been calibrated against a thermocouple thermometer traceable to 
                international standards through  
                <?php echo $certification->standard_test_equipment_certificate_number;?>.
             </p>
        </div>
    </div>
    <div class="validity" style="font-size: 0.75em;">
        <div><strong>4.0 VALIDITY</strong></div>
        <div style="margin-left: 30px;">
            <p>This certificate is valid until <strong><?php echo $certification->certificate_validity; ?></strong></p>
            <table class="table table-sm table-borderless">
                <tr>
                    <td class="signatories-label-left">PERFORMED BY</td>
                    <td class="signatories-space">
                        <?php echo $certification->creator['display_name']; ?>
                    </td>
                    <td class="signatories-label">DATE</td>
                    <td class="signatories-space">
                        <?php echo substr($certification->date_performed, 0, 10); ?>
                    </td>
                    <td class="signatories-label">SIGN</td>
                    <td class="signatories-space">
                        <?php
                            $creatorSignature = get_template_directory_uri()."-child/i/signature-".$certification->created_by.".png";
                        ?>
                        <img src="<?php echo $creatorSignature ?>" alt="Sign here" class="signatories-image" />
                    </td>
                </tr>
                <tr>
                    <td class="signatories-label-left">REVIEWED BY</td>
                    <td class="signatories-space">
                        <?php echo $certification->verifier['display_name']; ?>
                    </td>
                    <td class="signatories-label">DATE</td>
                    <td class="signatories-space">
                        <?php echo substr($certification->verified_at, 0, 10); ?>
                    </td>
                    <td class="signatories-label">SIGN</td>
                    <td class="signatories-space">
                        <?php
                        if(isset($certification->verified_by)){
                            $verifierSignature = get_template_directory_uri()."-child/i/signature-".$certification->verified_by.".png";
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
                        <?php echo $certification->approver['display_name']; ?>
                    </td>
                    <td class="signatories-label">DATE</td>
                    <td class="signatories-space">
                        <?php echo substr($certification->approved_at, 0, 10); ?>
                    </td>
                    <td class="signatories-label">SIGN</td>
                    <td class="signatories-space">
                        <?php
                        if(isset($certification->approved_by)){
                            $approverSignature = get_template_directory_uri()."-child/i/signature-".$certification->approved_by.".png";
                        ?>
                            <img src="<?php echo $approverSignature; ?>" alt="signature" 
                                class="signatories-image" />
                        <?php
                        }
                        ?>
                    </td>
                </tr>
            </table>
        </div>
    </div>
    <div class="row" style="font-size: 0.75em;page-break-after: always;">
        <div class="col">
            <center>Page 1 of 2</center>
        </div>
    </div>
</div>
<div class="certificate-frame" style="margin-top: 60px;font-size: 0.75em;">
    <div class="certificate-inner-frame">
        <div class="results">
            <div><strong>5.0 TRACEABILITY</strong></div>
            <div style="margin-left: 30px;">
                <table class="table table-sm table-bordered">
                    <tbody>
                        <tr>
                            <td><strong>Thermometer</strong></td>
                            <td style="text-align: right;" colspan="3">
                                <?php echo $certification->manufacturer_name . " " . $certification->equipment_name . " " . $certification->equipment_model; ?>
                            </td>
                        </tr>
                        <tr style="font-weight: bold;">
                            <td><strong>Standard Setting</strong></td>
                            <td style="text-align: right;"><?php echo $certification->expected_temperature_a; ?></td>
                            <td style="text-align: right;"><?php echo $certification->expected_temperature_b; ?></td>
                            <td style="text-align: right;"><?php echo $certification->expected_temperature_c; ?></td>
                        </tr>
                        <?php

                        $errorValues = array();

                        $counter = 0;
                        $divisor = 2;

                        foreach ($certification->readings as $reading) {
                            $error[1] = $reading['reading_a'] - $certification->expected_temperature_a;
                            $error[2] = $reading['reading_b'] - $certification->expected_temperature_b;
                            $error[3] = $reading['reading_c'] - $certification->expected_temperature_c;
                        ?>
                            <tr>
                                <td><strong>READ <?php echo $reading['reading_id'];?></strong></td>
                                <td style="text-align: right;"><?php echo $reading['reading_a'];?></td>
                                <td style="text-align: right;"><?php echo $reading['reading_b'];?></td>
                                <td style="text-align: right;"><?php echo $reading['reading_c'];?></td>
                            </tr>
                        <?php

                            $errorValues[1][$counter] = $error[1];
                            $errorValues[2][$counter] = $error[2];
                            $errorValues[3][$counter] = $error[3];
                            
                            $counter++;
                        }

                        $averageError[1] = array_sum($errorValues[1])/count($errorValues[1]);
                        $averageError[2] = array_sum($errorValues[2])/count($errorValues[2]);
                        $averageError[3] = array_sum($errorValues[3])/count($errorValues[3]);
                        ?>
                        <tr style="font-weight: bold;">
                            <td><strong>Average Correction</strong></td>
                            <td style="text-align: right;"><?php echo number_format($averageError[1],7); ?></td>
                            <td style="text-align: right;"><?php echo number_format($averageError[2],7); ?></td>
                            <td style="text-align: right;"><?php echo number_format($averageError[3],7); ?></td>
                        </tr>
                        <?php

                        $variance[1] = pow((max($errorValues[1]) - min($errorValues[1]))/$divisor, 2);
                        $variance[2] = pow((max($errorValues[2]) - min($errorValues[2]))/$divisor, 2);
                        $variance[3] = pow((max($errorValues[3]) - min($errorValues[3]))/$divisor, 2);

                        $homogeneity = 0;

                        $repeatability[1] = pow(sd($errorValues[1])/sqrt(count($errorValues[1]))/$divisor, 2);
                        $repeatability[2] = pow(sd($errorValues[2])/sqrt(count($errorValues[2]))/$divisor, 2);
                        $repeatability[3] = pow(sd($errorValues[3])/sqrt(count($errorValues[3]))/$divisor, 2);

                        $standardOfUncertainity = pow($certification->standard_of_uncertainity/sqrt(3), 2);

                        $standardOfResolution = pow($certification->standard_of_resolution/$divisor/sqrt(3), 2);

                        $resolutionOfDeviceUnderTest = pow(($certification->resolution_of_device_under_test/2/sqrt(3)), 2);

                        $uncertainity[1] = sqrt(pow(($averageError[1]/$divisor), 2) + $variance[1] + $homogeneity  + $repeatability[1] + $standardOfUncertainity + $standardOfResolution + $resolutionOfDeviceUnderTest);
                        $uncertainity[2] = sqrt(pow(($averageError[2]/$divisor), 2) + $variance[2] + $homogeneity  + $repeatability[2] + $standardOfUncertainity + $standardOfResolution + $resolutionOfDeviceUnderTest);
                        $uncertainity[3] = sqrt(pow(($averageError[3]/$divisor), 2) + $variance[3] + $homogeneity  + $repeatability[3] + $standardOfUncertainity + $standardOfResolution + $resolutionOfDeviceUnderTest);
                        ?>
                        <tr>
                            <td><strong>Uncertainty Expanded</strong></td>
                            <td style="text-align: right;"><?php echo number_format($uncertainity[1]*2,7); ?></td>
                            <td style="text-align: right;"><?php echo number_format($uncertainity[2]*2,7); ?></td>
                            <td style="text-align: right;"><?php echo number_format($uncertainity[3]*2,7); ?></td>
                        </tr>
                        <tr>
                            <td><strong>Remarks</strong></td>
                            <td style="text-align: right;" colspan="3"><?php echo $certification->result; ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="uncertainity">
            <div>
                <strong>6.0 UNCERTAINITY</strong>
            </div>
            <div style="margin-left: 30px;">
                <p>
                    <?php
                        echo "<span style='margin-right:20px'>".number_format($uncertainity[1]*2,7)."</span>";
                        echo "<span style='margin-right:20px'>".number_format($uncertainity[2]*2,7)."</span>";
                        echo "<span>".number_format($uncertainity[3]*2,7)."</span>";
                    ?>
                </p>
                <p>The reported expanded uncertainty is stated as expanded uncertainty of measurements multiplied 
                    by coverage factor K= 2, providing a confidence level of approximately 95%.</p>
            </div>
        </div><br>
        <div class="remarks">
            <div><strong>7.0 REMARKS</strong></div>
            <div style="margin-left: 30px;">
                <p>Calibration Complete. STATUS: <span id="ccc_status"><?php echo $certification->result; ?></span></p>
                <p>The maximum error is within the specified limits of accuracy of <strong style="color:red">+/- 2⁰C</strong>
                    as specified by the manufacturer for liquid in glass, dial thermometers.</p>
                <p>The maximum error is within the specified limits of accuracy of <strong style="color:red">+/- 1.5⁰C</strong>
                    as specified by the manufacturer for digital thermometers.</p>
            </div>
            <div style="margin-left: 30px;padding: 5px; border: 1px solid #000;">
                <p>Calibration certificate issued without signature is not valid.
                    This certificate has been issued without any alteration and may not be reproduced
                    other than in full and with the approval of the head of NPHL-COE.</p>
                <p>If undelivered please return to the above address.</p>
            </div><br>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <center>Page 2 of 2</center>
        </div>
    </div>
</div>
<!-- /Show Calibration Certificate -->
