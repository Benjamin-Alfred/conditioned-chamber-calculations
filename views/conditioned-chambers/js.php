<script>
jQuery( document ).ready(function( $ ) {
    $( function() {
        $( "#date_performed" ).datepicker({ dateFormat: 'yy-mm-dd' });
    } );

    $( "#status-pass" ).click(function() {
        url = "<?php echo $pageURL; ?>";
        $.post( url, {ccc_id: $( "#ccc_id").val(), status: "PASSED", api_code: 6} )
            .done(function(data) {
                $( "#ccc_back" ).submit();
            });
    });

    $( "#status-fail" ).click(function() {
        url = "<?php echo $pageURL; ?>";
        $.post( url, {ccc_id: $( "#ccc_id").val(), status: "FAILED", api_code: 6} )
            .done(function(data) {
                $( "#ccc_back" ).submit();
            });
    });

    $( "#add_client_button" ).click(function() {
        url = "<?php echo $pageURL; ?>";
        $.post( 
            url, 
            {client_name: $( "#client_name").val(), api_code: 15} 
        ).done(function(data) {
                var newOptions = "", i, clients;
                clients = JSON.parse(data);
                for(i = 0; i < clients.length; i++){
                    newOptions += "<option value='" + clients[i].id + "'>" + clients[i].name + "</option>";
                }
                $("#client").html(newOptions);
            });
    });

    $( "#add_manufacturer_button" ).click(function() {
        url = "<?php echo $pageURL; ?>";
        $.post( 
            url, 
            {manufacturer_name: $( "#manufacturer_name").val(), api_code: 12} 
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
            {equipment_name: $( "#equipment_name").val(), api_code: 13} 
        ).done(function(data) {
                var newOptions = "", i, equipments;
                equipments = JSON.parse(data);
                for(i = 0; i < equipments.length; i++){
                    newOptions += "<option value='" + equipments[i].id + "'>" + equipments[i].name + "</option>";
                }
                $("#equipment").html(newOptions);
            });
    });

    $( "#add_ste_equipment_button" ).click(function() {
        url = "<?php echo $pageURL; ?>";
        $.post( 
            url, 
            {s_t_equipment_name: $( "#s_t_equipment_name").val(), api_code: 14} 
        ).done(function(data) {
                var newOptions = "", i, equipments;
                equipments = JSON.parse(data);
                for(i = 0; i < equipments.length; i++){
                    newOptions += "<option value='" + equipments[i].id + "'>" + equipments[i].name + "</option>";
                }
                $("#ste_equipment").html(newOptions);
            });
    });

    $( "#add_client_contact_button" ).click(function() {
        url = "<?php echo $pageURL; ?>";
        $.post( 
            url, 
            {
                client_id: $("#client_id").val(),
                contact_name: $( "#contact_name").val(), 
                contact_email: $( "#contact_email").val(), 
                contact_phone: $( "#contact_phone").val(), 
                api_code: 16
            } 
        ).done(function(data) {
                var newOptions = "", i, clients;
                clients = JSON.parse(data);
                for(i = 0; i < clients.length; i++){
                    newOptions += "<option value='" + clients[i].id + "'>" + clients[i].name + "</option>";
                }
                $("#client_contact_id").html(newOptions);
            });
    });


    $( "#conditioned-chambers-list" ).DataTable();
    $( "#clients-list" ).DataTable();
    $( "#service-requests-list" ).DataTable();


    $( "#client-contacts-menu" ).click(function() {
        url = "<?php echo $pageURL; ?>";

        $('<form action="' + url + '" method="POST"><input type="hidden" name="api_code" value="7" /></form>').appendTo('body').hide().submit();
    });

    $( "#client-contacts-menu" ).click(function() {
        url = "<?php echo $pageURL; ?>";

        $('<form action="' + url + '" method="POST"><input type="hidden" name="api_code" value="7" /></form>').appendTo('body').hide().submit();
    });

    $( "#conditioned-chambers-menu" ).click(function() {
        url = "<?php echo $pageURL; ?>";

        $('<form action="' + url + '" method="POST"><input type="hidden" name="api_code" value="0" /></form>').appendTo('body').hide().submit();
    });

    $( "#service-requests-menu" ).click(function() {
        url = "<?php echo $pageURL; ?>";

        $('<form action="' + url + '" method="POST"><input type="hidden" name="api_code" value="18" /></form>').appendTo('body').hide().submit();
    });



    $('#serviceRequestAcceptModal').on('show.bs.modal', function (event) {
        
        var button = $(event.relatedTarget);
        var serviceRequestID = button.data('service-request-id');
        var serviceRequestFacility = button.data('service-request-facility');
        var serviceRequestEquipment = button.data('service-request-equipment');
        var serviceRequestAction = button.data('service-request-action');
        console.log(serviceRequestFacility);

        var modal = $(this);
        modal.find('.modal-title').text(serviceRequestAction + ' Service Request');
        modal.find('#service_request_id').val(serviceRequestID);
        modal.find('#service_request_action').val(serviceRequestAction);
        modal.find('#facility_name').val(serviceRequestFacility);
        modal.find('#equipment_name').val(serviceRequestEquipment);
    });


    $( "#accept_service_request_button" ).click(function() {
        url = "<?php echo $pageURL; ?>";
        $.post( url, 
            {
                service_request_id: $( "#service_request_id").val(), 
                service_request_action: $( "#service_request_action").val(), 
                service_request_comment: $( "#service_request_comment").val(), 
                api_code: 20
            } )
            .done(function(data) {
                $( "#service-requests-menu" ).click();
            });
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
                        $("#facility_name").val(facility[0].name + " - " + facility[0].county + ", " + facility[0].sub_county);
                        $("#facility_id").val(facility[0].id);
                    }else{
                        $("#facility_name").val("The facility was not found!");
                        $("#facility_id").val("");
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
