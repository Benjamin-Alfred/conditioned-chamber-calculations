<!-- Show Calibration Certificate -->
<div class="certificate-frame">
    <div class="row justify-content-end d-print-none">
        <div class="col">
            <form name="ccc_back" id="ccc_back" method="POST"
                action="<?php echo $pageURL; ?>">
                <input type="hidden" name="ccc_id" id="ccc_id" value="<?php echo $requestedCertificate; ?>">
                <input type="hidden" name="api_code" value="4">
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
                    <a class="btn btn-sm btn-outline-dark" href="<?php echo $pageURL; ?>">
                        Close
                    </a>
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
        <div class="customer-and-equipment-details" style="font-size: 0.7em">
            <table class="table table-bordered table-sm table-border-dark">
                <tbody>
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
                </tbody>
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
                <p>The equipment was calibrated as per <strong>NPHL-COE-LTP-SOP-026</strong> procedure
                    for Temperature Calibration measurements.</p>
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
                <p>The equipment has been calibrated against reference standards whose calibration
                 is traceable to international or national standards through 
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
                    <tr>
                        <td> &nbsp; </td>
                        <td colspan="5">For Head NPHL </td>
                    </tr>
                </table>
            </div>
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
            <div><strong>5.0 CALIBRATION RESULTS</strong></div>
            <div style="margin-left: 30px;">
                <table class="table table-sm table-bordered">
                    <thead class="table-border-dark">
                        <tr>
                            <th>Time (min)</th>
                            <th>Set temp(X ⁰C)</th>
                            <th>p1 (⁰C)</th>
                            <th>p2 (⁰C)</th>
                            <th>p3 (⁰C)</th>
                            <th>Average(P)</th>
                            <th>Error(average-X)</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-dark">
                        <?php
                        $totals['p1'] = 0;
                        $totals['p2'] = 0;
                        $totals['p3'] = 0;

                        $errorValues = array();

                        $counter = 0;
                        $divisor = 2;

                        foreach ($certification->readings as $reading) {
                            $average = ($reading['reading_a'] + $reading['reading_b'] + $reading['reading_c'])/3;
                            $error = $average - $certification->expected_temperature;
                        ?>
                            <tr>
                                <td style="text-align: right;"><?php echo $reading['reading_time'];?></td>
                                <td style="text-align: center;">
                                    <?php echo number_format($certification->expected_temperature,2);?>
                                </td>
                                <td style="text-align: right;">
                                    <?php echo number_format($reading['reading_a'], 3);?>
                                </td>
                                <td style="text-align: right;">
                                    <?php echo number_format($reading['reading_b'], 3);?>
                                </td>
                                <td style="text-align: right;">
                                    <?php echo number_format($reading['reading_c'], 3);?>
                                </td>
                                <td style="text-align: right;">
                                    <?php echo number_format($average, 3);?>
                                </td>
                                <td style="text-align: right;">
                                    <?php echo number_format($error, 3); ?>
                                </td>
                            </tr>
                        <?php
                            $totals['p1'] += $reading['reading_a'];
                            $totals['p2'] += $reading['reading_b'];
                            $totals['p3'] += $reading['reading_c'];

                            $errorValues[$counter] = $error;
                            
                            $counter++;
                        }

                        $averageError = pow(array_sum($errorValues)/count($errorValues)/$divisor, 2);

                        $variance = pow((max($errorValues) - min($errorValues))/$divisor, 2);

                        $totals['average_p1'] = $totals['p1']/$counter;
                        $totals['average_p2'] = $totals['p2']/$counter;
                        $totals['average_p3'] = $totals['p3']/$counter;
                        $homogeneity = (($totals['average_p1'] - $totals['average_p2'])+($totals['average_p2'] - $totals['average_p3']))/2/$divisor;
                        $homogeneity = pow($homogeneity, 2);

                        $repeatability = pow(sd($errorValues)/sqrt(count($errorValues))/$divisor, 2);

                        // These 2 lines below don't make sense
                        $UCStandard = pow($certification->standard_of_uncertainity/sqrt(3), 2);

                        $resn = pow($certification->standard_of_resolution/$divisor/sqrt(3), 2);
                        ?>
                        <tr></tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="uncertainity">
            <div>
                <strong>
                    6.0 UNCERTAINITY: 
                    <?php
                        $uncertainity = sqrt($averageError + $variance + $homogeneity  + $repeatability + $UCStandard + $resn);
                        echo number_format($uncertainity*2,7);
                    ?>
                </strong>
            </div>
            <div style="margin-left: 30px;">
                <p>The reported uncertainty is expanded and has a confidence level of 95%.</p>
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
        </div>
        <div class="remarks">
            <div><strong>8.0 COMMENTS</strong></div>
            <div style="margin-left: 30px;">
                <p>
                    <?php echo $certification->comment; ?>
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
