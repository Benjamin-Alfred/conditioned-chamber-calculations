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
     * SERVICE REQUEST
     *
     */

    $( "#service_request_form" ).submit(function(event){
        event.preventDefault();
    });

    $( "#service_request_button" ).click(function() {
        url = "<?php echo $pageURL; ?>";

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



});
</script>
