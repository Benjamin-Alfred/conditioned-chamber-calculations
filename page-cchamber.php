<?php
/**
 * Template Name: Conditioned Chamber Calculations
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 * @version 1.0
 */

get_header(); ?>

<div class="wrap">
    <div id="primary" class="content-area">
        <main id="main" class="site-main" role="main">
            <h3>Calculations for the Conditioned Chamber</h3>
            <form>
                <div class="form-group row">
                    <label for="client_name" class="col-form-label col-sm-4">Client Name</label>
                    <input type="text" class="form-control form-control-sm col-sm-8" id="client_name" name="client_name" placeholder="Client Name" required />
                </div>
                <div class="form-group row">
                    <label for="manufacturer" class="col-form-label col-sm-4">Manufacturer</label>
                    <input type="text" class="form-control form-control-sm col-sm-8" id="manufacturer" name="manufacturer" required />
                </div>
                <div class="form-group row">
                    <label for="equipment" class="col-form-label col-sm-4">Equipment Name</label>
                    <input type="text" class="form-control form-control-sm col-sm-8" id="equipment" name="equipment" required />
                </div>
                <div class="form-group row">
                    <label for="model" class="col-form-label col-sm-4">Model</label>
                    <input type="text" class="form-control form-control-sm col-sm-8" id="model" name="model" required />
                </div>
                <div class="form-group row">
                    <label for="serial_number" class="col-form-label col-sm-4">Serial Number</label>
                    <input type="text" class="form-control form-control-sm col-sm-8" id="serial_number" name="serial_number" required />
                </div>
                <div class="form-group row">
                    <label for="submission_number" class="col-form-label col-sm-4">Submission Number</label>
                    <input type="text" class="form-control form-control-sm col-sm-8" id="submission_number" name="submission_number" required />
                </div>
                <div class="form-group row">
                    <label for="certificate_number" class="col-form-label col-sm-4">Certificate Number</label>
                    <input type="text" class="form-control form-control-sm col-sm-8" id="certificate_number" name="certificate_number" required />
                </div>
                <hr />
                <div class="form-group row">
                    <label for="expected_temperature" class="col-form-label col-sm-5">Expected/Set Temperature</label>
                    <input type="number" class="form-control form-control-sm col-sm-7" id="expected_temperature" name="expected_temperature" title="" required />
                </div>

                <div class="table-responsive">
                    <table class="table table-striped table-sm">
                        <thead>
                            <tr><th colspan="2"></th><th colspan="5">Chamber Temperature in °c</th></tr>
                            <tr>
                                <th scope="col">time</th>
                                <th scope="col">set temp</th>
                                <th scope="col">p1</th>
                                <th scope="col">p2</th>
                                <th scope="col">p3</th>
                                <th scope="col">average</th>
                                <th scope="col">error</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td align="right">0</td>
                                <td align="right">10</td>
                                <td>
                                    <input type="number" class="form-control form-control-sm" id="p_1_1" name="p_1_1" title="" required />
                                </td>
                                <td>
                                    <input type="number" class="form-control form-control-sm" id="p_2_1" name="p_2_1" title="" required />
                                </td>
                                <td>
                                    <input type="number" class="form-control form-control-sm" id="p_3_1" name="p_3_1" title="" required />
                                </td>
                                <td align="right">0.00</td>
                                <td align="right">0.00</td>
                            </tr>
                            <tr>
                                <td align="right">6</td>
                                <td align="right">10</td>
                                <td>
                                    <input type="number" class="form-control form-control-sm" id="p_1_1" name="p_1_1" title="" required />
                                </td>
                                <td>
                                    <input type="number" class="form-control form-control-sm" id="p_2_1" name="p_2_1" title="" required />
                                </td>
                                <td>
                                    <input type="number" class="form-control form-control-sm" id="p_3_1" name="p_3_1" title="" required />
                                </td>
                                <td align="right">0.00</td>
                                <td align="right">0.00</td>
                            </tr>
                            <tr>
                                <td align="right">12</td>
                                <td align="right">10</td>
                                <td>
                                    <input type="number" class="form-control form-control-sm" id="p_1_1" name="p_1_1" title="" required />
                                </td>
                                <td>
                                    <input type="number" class="form-control form-control-sm" id="p_2_1" name="p_2_1" title="" required />
                                </td>
                                <td>
                                    <input type="number" class="form-control form-control-sm" id="p_3_1" name="p_3_1" title="" required />
                                </td>
                                <td align="right">0.00</td>
                                <td align="right">0.00</td>
                            </tr>
                            <tr>
                                <td align="right">18</td>
                                <td align="right">10</td>
                                <td>
                                    <input type="number" class="form-control form-control-sm" id="p_1_1" name="p_1_1" title="" required />
                                </td>
                                <td>
                                    <input type="number" class="form-control form-control-sm" id="p_2_1" name="p_2_1" title="" required />
                                </td>
                                <td>
                                    <input type="number" class="form-control form-control-sm" id="p_3_1" name="p_3_1" title="" required />
                                </td>
                                <td align="right">0.00</td>
                                <td align="right">0.00</td>
                            </tr>
                            <tr>
                                <td align="right">24</td>
                                <td align="right">10</td>
                                <td>
                                    <input type="number" class="form-control form-control-sm" id="p_1_1" name="p_1_1" title="" required />
                                </td>
                                <td>
                                    <input type="number" class="form-control form-control-sm" id="p_2_1" name="p_2_1" title="" required />
                                </td>
                                <td>
                                    <input type="number" class="form-control form-control-sm" id="p_3_1" name="p_3_1" title="" required />
                                </td>
                                <td align="right">0.00</td>
                                <td align="right">0.00</td>
                            </tr>
                            <tr>
                                <td align="right">30</td>
                                <td align="right">10</td>
                                <td>
                                    <input type="number" class="form-control form-control-sm" id="p_1_1" name="p_1_1" title="" required />
                                </td>
                                <td>
                                    <input type="number" class="form-control form-control-sm" id="p_2_1" name="p_2_1" title="" required />
                                </td>
                                <td>
                                    <input type="number" class="form-control form-control-sm" id="p_3_1" name="p_3_1" title="" required />
                                </td>
                                <td align="right">0.00</td>
                                <td align="right">0.00</td>
                            </tr>
                            <tr>
                                <td align="right">36</td>
                                <td align="right">10</td>
                                <td>
                                    <input type="number" class="form-control form-control-sm" id="p_1_1" name="p_1_1" title="" required />
                                </td>
                                <td>
                                    <input type="number" class="form-control form-control-sm" id="p_2_1" name="p_2_1" title="" required />
                                </td>
                                <td>
                                    <input type="number" class="form-control form-control-sm" id="p_3_1" name="p_3_1" title="" required />
                                </td>
                                <td align="right">0.00</td>
                                <td align="right">0.00</td>
                            </tr>
                            <tr>
                                <td align="right">42</td>
                                <td align="right">10</td>
                                <td>
                                    <input type="number" class="form-control form-control-sm" id="p_1_1" name="p_1_1" title="" required />
                                </td>
                                <td>
                                    <input type="number" class="form-control form-control-sm" id="p_2_1" name="p_2_1" title="" required />
                                </td>
                                <td>
                                    <input type="number" class="form-control form-control-sm" id="p_3_1" name="p_3_1" title="" required />
                                </td>
                                <td align="right">0.00</td>
                                <td align="right">0.00</td>
                            </tr>
                            <tr>
                                <td align="right">48</td>
                                <td align="right">10</td>
                                <td>
                                    <input type="number" class="form-control form-control-sm" id="p_1_1" name="p_1_1" title="" required />
                                </td>
                                <td>
                                    <input type="number" class="form-control form-control-sm" id="p_2_1" name="p_2_1" title="" required />
                                </td>
                                <td>
                                    <input type="number" class="form-control form-control-sm" id="p_3_1" name="p_3_1" title="" required />
                                </td>
                                <td align="right">0.00</td>
                                <td align="right">0.00</td>
                            </tr>
                            <tr>
                                <td align="right">54</td>
                                <td align="right">10</td>
                                <td>
                                    <input type="number" class="form-control form-control-sm" id="p_1_1" name="p_1_1" title="" required />
                                </td>
                                <td>
                                    <input type="number" class="form-control form-control-sm" id="p_2_1" name="p_2_1" title="" required />
                                </td>
                                <td>
                                    <input type="number" class="form-control form-control-sm" id="p_3_1" name="p_3_1" title="" required />
                                </td>
                                <td align="right">0.00</td>
                                <td align="right">0.00</td>
                            </tr>
                            <tr>
                                <td align="right">60</td>
                                <td align="right">10</td>
                                <td>
                                    <input type="number" class="form-control form-control-sm" id="p_1_1" name="p_1_1" title="" required />
                                </td>
                                <td>
                                    <input type="number" class="form-control form-control-sm" id="p_2_1" name="p_2_1" title="" required />
                                </td>
                                <td>
                                    <input type="number" class="form-control form-control-sm" id="p_3_1" name="p_3_1" title="" required />
                                </td>
                                <td align="right">0.00</td>
                                <td align="right">0.00</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </form>
        </main><!-- #main -->
    </div><!-- #primary -->
</div><!-- .wrap -->

<?php get_footer();
