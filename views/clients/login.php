<!-- Client Login -->
<div>
    <div class="row">
        <div id="info_block" class="col-sm-10"><?php echo $infoMessage; ?></div>
        <form name="ccc_back" method="POST" action="<?php echo get_site_url(); ?>/" class="col-sm-2">
            <button class="btn btn-sm float-right" onclick="document.ccc_back.submit" title="Back">
                <svg class="icon icon-arrow-left" aria-hidden="true" role="img">
                    <use href="#icon-arrow-left" xlink:href="#icon-arrow-left"></use>
                </svg>
            </button>
        </form>
    </div>
    <br>

    <div class="card">
        <div class="card-body">
            <form method="POST" action="<?php echo get_site_url().'/clients/'; ?>" id="client_login_form">
                <h5 class="card-title">Client Login</h5>
                <div class="form-group row">
                    <label class="col-form-label col-sm-4" for="contact_email">
                        Contact Email
                    </label>
                    <input type="email" name="contact_email" id="contact_email" 
                        class="form-control form-control-sm col-sm-8" required />
                </div>
                <div class="form-group row">
                    <label class="col-form-label col-sm-4" for="password">
                        Password
                    </label>
                    <input type="password" name="password" id="password" 
                        class="form-control form-control-sm col-sm-8" required />
                </div>
                <div class="form-group" style="font-size: 0.8em;">
                    <label class="col-form-label col-sm-4" for="client_login_button">&nbsp;</label>
                    <button id="client_login_button" class="btn-primary">Login</button>
                </div>
                <input type="hidden" name="api_code" value="8">
            </form>
            <div class="form-group" style="font-size: 0.9em;">
                <form method="POST" action="<?php echo get_site_url().'/clients/'; ?>" id="client_registration_link">
                    <input type="hidden" name="api_code" value="7">
                    New user? 
                    <a href="#" onclick="document.getElementById('client_registration_link').submit();">Register here</a>.
                </form>
            </div>
        </div>
    </div>
</div>
<!-- /Client Login -->
