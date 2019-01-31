<!-- New Registrations -->
<div>
    <div class="row">
        <div id="info_block" class="col-sm-10"></div>
        <form name="ccc_back" method="POST" action="<?php echo get_site_url(); ?>/" class="col-sm-2">
            <button class="btn btn-sm float-right" onclick="document.ccc_back.submit" title="Back">
                <svg class="icon icon-arrow-left" aria-hidden="true" role="img">
                    <use href="#icon-arrow-left" xlink:href="#icon-arrow-left"></use>
                </svg>
            </button>
        </form>
    </div>

    <div class="card" style="margin-top: 20px;">
        <div class="card-body">
            <h5 class="card-title">Client Details</h5>
            <form name="registration_form" id="registration_form">
                <div class="form-group row">
                    <label for="client_id" class="col-form-label col-sm-4">
                        <sup style="color: red;">&nbsp;</sup>
                        MFL Code
                    </label>
                    <div class="col-sm-8" style="padding: 0;">
                        <div class="search-form" style="width: 100%;color: #606060;font-size: 0.9em;">
                            <input type="search" name="mfl_code" id="mfl_code" class="search-field" placeholder="Type MFL Code" />
                            <button type="button" class="search-submit" id="mfl_search">
                                <svg class="icon icon-search" aria-hidden="true" role="img">
                                    <use href="#icon-search" xlink:href="#icon-search"></use>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-form-label col-sm-4" for="facility_name">
                        <sup style="color: red;" title="Mandatory">*</sup>
                        Facility
                    </label>
                    <input type="text" name="facility_name" id="facility_name" 
                        class="form-control form-control-sm col-sm-8" readonly required 
                        title="Enter an MFL Code in the field above" />
                    <input type="hidden" name="facility_id" id="facility_id" />
                </div>
                <div class="form-group row">
                    <label class="col-form-label col-sm-4" for="county_name">
                        <sup style="color: red;">&nbsp;</sup>
                        County
                    </label>
                    <input type="text" name="county_name" id="county_name" 
                        class="form-control form-control-sm col-sm-8" readonly 
                        title="Enter an MFL Code in the field above" />
                </div>
                <div class="form-group row">
                    <label class="col-form-label col-sm-4" for="sub_county_name">
                        <sup style="color: red;">&nbsp;</sup>
                        Sub-county
                    </label>
                    <input type="text" name="sub_county_name" id="sub_county_name" 
                        class="form-control form-control-sm col-sm-8" readonly 
                        title="Enter an MFL Code in the field above" />
                </div>
                <div class="form-group row">
                    <label class="col-form-label col-sm-4" for="contact_name">
                        <sup style="color: red;" title="Mandatory">*</sup>
                        Contact Person
                    </label>
                    <input type="text" name="contact_name" id="contact_name" 
                        class="form-control form-control-sm col-sm-8" required />
                </div>
                <div class="form-group row">
                    <label class="col-form-label col-sm-4" for="contact_email">
                        <sup style="color: red;" title="Mandatory">*</sup>
                        Contact Email
                    </label>
                    <input type="email" name="contact_email" id="contact_email" 
                        class="form-control form-control-sm col-sm-8" required />
                </div>
                <div class="form-group row">
                    <label class="col-form-label col-sm-4" for="contact_phone">
                        <sup style="color: red;" title="Mandatory">*</sup>
                        Contact Phone
                    </label>
                    <input type="text" name="contact_phone" id="contact_phone" 
                        class="form-control form-control-sm col-sm-8" required />
                </div>
                <div class="form-group row">
                    <label class="col-form-label col-sm-4" for="password">
                        <sup style="color: red;" title="Mandatory">*</sup>
                        Password
                    </label>
                    <input type="password" name="password" id="password" 
                        class="form-control form-control-sm col-sm-8" required />
                </div>
                <div class="form-group row">
                    <label class="col-form-label col-sm-4" for="repeat_password">
                        <sup style="color: red;" title="Mandatory">*</sup>
                        Repeat Password
                    </label>
                    <input type="password" name="repeat_password" id="repeat_password" 
                        class="form-control form-control-sm col-sm-8" required />
                </div>
                <div class="form-group row justify-content-end">
                    <input type="hidden" name="api_code" value="601">
                    <label class="col-form-label sr-only" for="client_self_registration">Register</label>
                    <input type="submit" id="client_self_registration" class="button btn form-control form-control-sm col-sm-8" value="Register" />
                </div>
            </form>
        </div>
    </div>
    <div class="row" style="margin-top: 20px;">
        <div class="col-sm-12">
            <button class="btn btn-sm float-right" onclick="window.history.back();" title="Back">
                <svg class="icon icon-arrow-left" aria-hidden="true" role="img">
                    <use href="#icon-arrow-left" xlink:href="#icon-arrow-left"></use>
                </svg>
            </button>
        </div>
    </div>
</div>
<!-- /New Registrations -->
