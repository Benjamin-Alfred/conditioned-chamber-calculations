<script>
jQuery( document ).ready(function( $ ) {

    $( "#add_manufacturer_button" ).click(function() {
        url = "<?php echo $pageURL; ?>";
        $.post( 
            url, 
            {manufacturer_name: $( "#manufacturer_name").val(), api_code: 1} 
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
        url = "<?php echo $pageURL; ?>";
        $.post( 
            url, 
            {equipment_name: $( "#equipment_name").val(), api_code: 2} 
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
     * SELF REGISTRATION FORM
     *
     */


    $( "#registration_form" ).submit(function(event){
        event.preventDefault();
    });

    $( "#client_self_registration" ).click(function() {
        url = "<?php echo $pageURL; ?>";

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

    $( "#add_new_user" ).click(function() {
        url = "<?php echo $pageURL; ?>";

        // Validation
        validationMessage = "";
        //1. Mandatory fields are filled out
        var fields = ["#facility_id", "#contact_name", "#contact_email", "#contact_phone"];
        for (var i = fields.length - 1; i >= 0; i--) {
            if($(fields[i]).val().trim().length < 1){
                validationMessage += "<li>Please fill in all the mandatory fields!</li>";
                break;
            }
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

                newClientMessage = "<span class='text-success' style='font-size:0.9em;font-weight:bold;'>The user will be notified via email once activated.</span>";
                if(data != true)newClientMessage = "<span class='text-warning' style='font-size:0.9em;font-weight:bold;'>An account with the given credentials already exists!</span>";

                $( "#info_block" ).html(newClientMessage);
                $('html,body').animate({ scrollTop: $("#info_block").offset().top }, 'slow');
            });
        }
    });

    $( "#mfl_search" ).click(function() {
        url = "<?php echo $pageURL; ?>";
        if($("#mfl_code").val().trim().length > 4){
            $.post( 
                url, 
                {
                    search_text: $("#mfl_code").val(),
                    api_code: 600
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
