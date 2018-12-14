<script>
jQuery( document ).ready(function( $ ) {

    $( "#add_manufacturer_button" ).click(function() {
        url = "<?php echo get_site_url().'/clients/'; ?>";
        $.post( 
            url, 
            {manufacturer_name: $( "#manufacturer_name").val(), calibration_calculation: "false", 
                api_code: 1} 
        ).done(function(data) {
                var newOptions = "", i, manufacturers;
                manufacturers = JSON.parse(data);
                for(i = 0; i < manufacturers.length; i++){
                    newOptions += "<option value='" + manufacturers[i].id + "'>" + manufacturers[i].name + "</option>";
                }
                $("#manufacturer").html(newOptions);
                $("#ste_manufacturer").html(newOptions);
            });
    });

    $( "#add_equipment_button" ).click(function() {
        url = "<?php echo get_site_url().'/clients/'; ?>";
        $.post( 
            url, 
            {equipment_name: $( "#equipment_name").val(), calibration_calculation: "false", api_code: 2} 
        ).done(function(data) {
                var newOptions = "", i, equipments;
                equipments = JSON.parse(data);
                for(i = 0; i < equipments.length; i++){
                    newOptions += "<option value='" + equipments[i].id + "'>" + equipments[i].name + "</option>";
                }
                $("#equipment").html(newOptions);
            });
    });

    /*
     * SERVICE REQUEST
     *
     */

    $( "#service_request_form" ).submit(function(event){
        event.preventDefault();
    });

    $( "#service_request_button" ).click(function() {
        url = "<?php echo get_site_url().'/clients/'; ?>";

        $.post( 
            url,  $( "#service_request_form" ).serialize() 
        ).done(function(data) {

            newClientMessage = "<span class='text-success' style='font-size:0.9em;font-weight:bold;'>Your service request has been received.</span>";
            if(data != true){
                newClientMessage = "<span class='text-warning' style='font-size:0.9em;font-weight:bold;'>A similar request from your facility already exists!</span>";
            }else{
                $(location).attr('href',url);
            }

            $( "#info_block" ).html(newClientMessage);
            $('html,body').animate({ scrollTop: $("#info_block").offset().top }, 'slow');
        });
    });

    $( "#service-request-list" ).DataTable();

    /*
     * SELF REGISTRATION FORM
     *
     */


    $( "#registration_form" ).submit(function(event){
        event.preventDefault();
    });

    $( "#client_self_registration" ).click(function() {
        url = "<?php echo get_site_url().'/clients/'; ?>";

        // Validation
        validationMessage = "";
        //1. Mandatory fields are filled out
        var fields = ["#facility_id", "#contact_name", "#contact_email", "#contact_phone", "#password", "#repeat_password"];
        for (var i = fields.length - 1; i >= 0; i--) {
            if($(fields[i]).val().trim().length < 1){
                validationMessage += "<li>Please fill in all the mandatory fields!</li>";
                break;
            }
        }
        //2. Passwords match and length is acceptable
        if($( "#password" ).val() === $( "#repeat_password" ).val()){
            if($( "#password" ).val().trim().length < 6){
                validationMessage += "<li>Your password must be at least 6 characters long!</li>";
            }
        }else{
            validationMessage += "<li>Your password fields do not match!</li>";
        }

        if(validationMessage.trim().length > 0){
            validationMessage = "<ul class='text-danger' style='font-size:0.9em;font-weight:bold;'>" + validationMessage + "</ul>";
            $( "#info_block" ).html(validationMessage);
            $('html,body').animate({
                    scrollTop: $("#info_block").offset().top
                }, 'slow');
        }else{
            var newClientMessage = "";
            $.post( 
                url,  $( "#registration_form" ).serialize() 
            ).done(function(data) {

                newClientMessage = "<span class='text-success' style='font-size:0.9em;font-weight:bold;'>Your registration has been received. You will be notified via email once your application has been approved.</span>";
                if(data != true)newClientMessage = "<span class='text-warning' style='font-size:0.9em;font-weight:bold;'>An account with the given credentials already exists!</span>";

                $( "#info_block" ).html(newClientMessage);
                $('html,body').animate({ scrollTop: $("#info_block").offset().top }, 'slow');
            });
        }
    });

    $( "#mfl_search" ).click(function() {
        url = "<?php echo get_site_url().'/clients/'; ?>";
        if($("#mfl_code").val().trim().length > 4){
            $.post( 
                url, 
                {
                    search_text: $("#mfl_code").val(),
                    calibration_calculation: "false", 
                    api_code: 6
                } 
            ).done(function(data) {
                    console.log(JSON.parse(data));
                    var facility = JSON.parse(data);
                    if(facility.length > 0){
                        $("#facility_name").val(facility[0].name);
                        $("#facility_id").val(facility[0].id);
                        $("#county_name").val(facility[0].county);
                        $("#sub_county_name").val(facility[0].sub_county);
                    }else{
                        $("#facility_name").val("The facility was not found!");
                        $("#facility_id").val("");
                        $("#county_name").val("");
                        $("#sub_county_name").val("");
                    }
                });
        }
    });

    $( "#mfl_code" ).keypress(function(event){
        if(event.which == 13) {
            event.preventDefault();
            $( "#mfl_search" ).click();
        }
    });


});
</script>
