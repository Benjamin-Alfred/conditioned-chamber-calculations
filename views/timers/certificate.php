<!-- Show Calibration Certificate -->
<div class="certificate-frame">
    <div class="row justify-content-end d-print-none">
        <div class="col">
            <form name="ccc_back" id="ccc_back" method="POST"
                action="<?php echo get_site_url(); ?>/timers/">
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
                    <img src="<?php bloginfo('template_url'); ?>-child/i/coat_of_arms.png">
                </div>
                <div class="col-5" style="text-align: right;">
                    <span style="font-size: 0.55em; "><strong>CERTIFICATE NUMBER</strong></span>
                    <span style="font-size: 0.65em; display: inline-block;border: 1px solid #000;padding: 0 10px;">
                        <?php echo $certification->certificate_number;?>
                    </span>
                    <div>
                        <img style="width: 90px;height:90px;margin-top:10px;" src="<?php bloginfo('template_url'); ?>-child/i/kenas_logo.jpg">
                    </div>
                </div>
            </div>
            <div class="row">
                <div style="text-align:center" class="col-12">
                    <strong>CALIBRATION CERTIFICATE</strong>
                </div>
            </div>
        </div>
        <div class="customer-and-equipment-details" style="font-size: 0.65em">
            <table class="table table-bordered table-sm">
                <tbody class="table-border-dark">
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
                        <td><strong>SERIAL NUMBER</strong></td>
                        <td><?php echo $certification->equipment_serial_number;?></td>
                    </tr>
                    <tr>
                        <td><strong>INVENTORY NUMBER</strong></td>
                        <td><?php echo $certification->submission_number;?></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="standard-equipment" style="font-size: 0.7em">
            <div><strong>1.0 STANDARD TEST EQUIPMENT USED:</strong></div>
            <div style="margin-bottom: 10px;" class="row">
                <div class="col-12">
                    <table class="table table-bordered table-sm">
                        <tbody class="table-border-dark">
                            <tr>
                                <td><strong>DESCRIPTION</strong></td>
                                <td><?php echo $certification->ste_equipment['name'];?></td>
                                <td><strong>MANUFACTURER</strong></td>
                                <td><?php echo $certification->ste_manufacturer['name'];?></td>
                            </tr>
                            <tr>
                                <td><strong>MODEL</strong></td>
                                <td><?php echo $certification->standard_test_equipment_model;?></td>
                                <td><strong>SERIAL NUMBER</strong></td>
                                <td><?php echo $certification->standard_test_equipment_serial_number;?></td>
                            </tr>
                            <tr>
                                <td><strong>CERTIFICATE NUMBER</strong></td>
                                <td><?php echo $certification->standard_test_equipment_certificate_number;?></td>
                                <td><strong>STICKER NUMBER</strong></td>
                                <td><?php echo $certification->standard_test_equipment_sticker_number;?></td>
                            </tr>
                            <tr>
                                <td><strong>Resolution</strong></td>
                                <td colspan="3"><?php echo number_format($certification->resolution_of_standard,2);?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="calibration-procedure" style="font-size: 0.7em">
            <div><strong>2.0 CALIBRATION PROCEDURE</strong></div>
            <div style="margin-left: 30px;">
                <p>The timer was calibrated using the DIRECT COMPARISON METHOD as per 
                    <strong>NPHL-COE-TECH-10</strong> procedure for calibration of STOPWATCHES and TIMERS.</p>
            </div>
        </div>
        <div class="calibration-procedure" style="font-size: 0.7em">
            <div><strong>3.0 CALIBRATION PROCEDURE</strong></div>
            <div style="margin-left: 30px;">
                <p>The environmental conditions were recorded during the period of calibration.
                    The temperature was recorded as
                    <strong><?php echo number_format($certification->environmental_temperature, 2);?> ⁰C
                    &plusmn; 2 ⁰C</strong> with the relative humidity recorded as  
                    <strong>
                        <?php echo number_format($certification->environmental_humidity, 2);?> &plusmn; 2% RH
                    </strong>
                </p>
            </div>
        </div>
        <div class="traceability" style="font-size: 0.7em">
            <div><strong>4.0 TRACEABILITY</strong></div>
            <div style="margin-left: 30px;">
                <p>The equipment has been calibrated against reference standards whose claibration is traceable 
                    to the Kenya Bureau of Standards through certificate
                    <?php echo $certification->standard_test_equipment_certificate_number;?>.
                 </p>
            </div>
        </div>
        <div class="validity" style="font-size: 0.7em;">
            <div><strong>5.0 VALIDITY</strong></div>
            <div style="margin-left: 10px;">
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
                            <?php echo isset($certification->verifier['display_name'])?$certification->verifier['display_name']:""; ?>
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
                            <?php echo isset($certification->approver['display_name'])?$certification->approver['display_name']:""; ?>
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
                    <tr>
                        <td> &nbsp; </td>
                        <td colspan="5">For Head NPHL </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    <div class="row" style="font-size: 0.7em;page-break-after: always;">
        <div class="col">
            <center>Page 1 of 2</center>
        </div>
    </div>
</div>
<div class="certificate-frame" style="margin-top:60px;font-size:0.75em;">
    <div class="certificate-inner-frame">
        <div class="results">
            <div><strong>6.0 CALIBRATION RESULTS</strong></div>
            <div style="margin-left: 30px;">
                <table class="table table-sm table-bordered">
                    <thead class="table-border-dark">
                        <tr>
                            <th>Set Points (Nominal)</th>
                            <th style="text-align: right;"><?php echo number_format($certification->expected_set_point_a, 2); ?></th>
                            <th style="text-align: right;"><?php echo number_format($certification->expected_set_point_b, 2); ?></th>
                            <th style="text-align: right;"><?php echo number_format($certification->expected_set_point_c, 2); ?></th>
                        </tr>
                    </thead>
                    <tbody class="table-border-dark">
                        <?php

                        $errorValues = array();
                        $values = array();

                        $counter = 0;
                        $divisor = 2;

                        foreach ($certification->readings as $reading) {
                            $error[1] = $reading['reading_a'] - $certification->expected_set_point_a;
                            $error[2] = $reading['reading_b'] - $certification->expected_set_point_b;
                            $error[3] = $reading['reading_c'] - $certification->expected_set_point_c;
                        ?>
                            <tr>
                                <td><strong>READING <?php echo $reading['reading_id'];?></strong></td>
                                <td style="text-align: right;"><?php echo number_format($reading['reading_a'], 3);?></td>
                                <td style="text-align: right;"><?php echo number_format($reading['reading_b'], 3);?></td>
                                <td style="text-align: right;"><?php echo number_format($reading['reading_c'], 3);?></td>
                            </tr>
                        <?php

                            $values[1][$counter] = $reading['reading_a'];
                            $values[2][$counter] = $reading['reading_b'];
                            $values[3][$counter] = $reading['reading_c'];
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
                            <td><strong>Average</strong></td>
                            <td style="text-align: right;"><?php echo number_format($averageError[1] + $certification->expected_set_point_a, 3); ?></td>
                            <td style="text-align: right;"><?php echo number_format($averageError[2] + $certification->expected_set_point_b, 3); ?></td>
                            <td style="text-align: right;"><?php echo number_format($averageError[3] + $certification->expected_set_point_c, 3); ?></td>
                        </tr>
                        <tr style="font-weight: bold;">
                            <td><strong>Deviation</strong></td>
                            <td style="text-align: right;"><?php echo number_format($averageError[1], 3); ?></td>
                            <td style="text-align: right;"><?php echo number_format($averageError[2], 3); ?></td>
                            <td style="text-align: right;"><?php echo number_format($averageError[3], 3); ?></td>
                        </tr>
                        <?php

                        $accuracyOfStandard = $certification->accuracy_of_standard/$divisor/sqrt(3);

                        $resolutionOfStandard = $certification->resolution_of_standard/$divisor/sqrt(3);

                        $uncertainityOfStandard = $certification->uncertainity_of_standard/2;

                        $resolutionOfDeviceUnderTest = $certification->resolution_of_device_under_test/2/sqrt(3);

                        $uncertainity[1] = pow($averageError[1]/sqrt(3), 2) + pow(sd($values[1])/sqrt(5), 2) + pow($accuracyOfStandard + $uncertainityOfStandard + $resolutionOfStandard + $resolutionOfDeviceUnderTest, 2);
                        $uncertainity[2] = pow($averageError[2]/sqrt(3), 2) + pow(sd($values[2])/sqrt(5), 2) + pow($accuracyOfStandard + $uncertainityOfStandard + $resolutionOfStandard + $resolutionOfDeviceUnderTest, 2);
                        $uncertainity[3] = pow($averageError[3]/sqrt(3), 2) + pow(sd($values[3])/sqrt(5), 2) + pow($accuracyOfStandard + $uncertainityOfStandard + $resolutionOfStandard + $resolutionOfDeviceUnderTest, 2);
                        ?>
                        <tr>
                            <td><strong>Uncertainty Expanded (s)</strong></td>
                            <td style="text-align: right;font-weight: bold;color: #F33">
                                <?php echo number_format(sqrt($uncertainity[1])*2, 3); ?>
                            </td>
                            </td>
                            <td style="text-align: right;font-weight: bold;color: #F33">
                                <?php echo number_format(sqrt($uncertainity[2])*2, 3); ?>
                            </td>
                            <td style="text-align: right;font-weight: bold;color: #F33">
                                <?php echo number_format(sqrt($uncertainity[3])*2, 3); ?>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <p>The reported uncertainties of measurements were calculated and expressed in 
                accordance with EA-4/02 publication and were based on a standard uncertainty multiplied
                by a coverage factor of k=2, which, unless stated otherwise provides a level of 
                confidence of approximately 95%.</p>
            </div>
        </div><br>
        <div class="remarks">
            <div><strong>7.0 REMARKS</strong></div>
            <div style="margin-left: 30px;">
                <p>
                    Calibration Complete. STATUS: 
                    <span id="ccc_status" style="color:#F00;"><strong><?php echo $certification->result; ?></strong></span>
                </p>
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
