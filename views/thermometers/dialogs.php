<div class="modal fade" id="addManufacturerModal" tabindex="-1" role="dialog" 
    aria-labelledby="addManufacturerModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addManufacturerModalLabel">Add Manufacturer</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="<?php echo get_site_url(); ?>/thermometers/" 
                    name="newManufacturer">
                    <div class="form-group row">
                        <label class="col-form-label col-sm-4" for="manufacturer_name">Name</label>
                        <input type="text" name="manufacturer_name" id="manufacturer_name" 
                            class="form-control form-control-sm col-sm-8" required />
                        <input type="hidden" name="calibration_calculation" value="false" />
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button id="add_manufacturer_button" type="button" class="btn btn-primary" data-dismiss="modal">
                    Save
                </button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="addEquipmentModal" tabindex="-1" role="dialog" 
    aria-labelledby="addEquipmentModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addEquipmentModalLabel">Add Equipment</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="<?php echo get_site_url(); ?>/thermometers/" 
                    name="newEquipment">
                    <div class="form-group row">
                        <label class="col-form-label col-sm-4" for="equipment_name">Name</label>
                        <input type="text" name="equipment_name" id="equipment_name" class="form-control form-control-sm col-sm-8" required />
                        <input type="hidden" name="calibration_calculation" value="false" />
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button id="add_equipment_button" type="button" class="btn btn-primary" data-dismiss="modal">
                    Save
                </button> 
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="addSTEquipmentModal" tabindex="-1" role="dialog" 
    aria-labelledby="addSTEquipmentModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addSTEquipmentModalLabel">Add Standard Test Equipment</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="<?php echo get_site_url(); ?>/thermometers/" 
                    name="newSTEquipment">
                    <div class="form-group row">
                        <label class="col-form-label col-sm-4" for="s_t_equipment_name">Name</label>
                        <input type="text" name="s_t_equipment_name" id="s_t_equipment_name" 
                            class="form-control form-control-sm col-sm-8" required />
                        <input type="hidden" name="calibration_calculation" value="false" />
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button id="add_ste_equipment_button" type="button" class="btn btn-primary" data-dismiss="modal">
                    Save
                </button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="addClientModal" tabindex="-1" role="dialog" 
    aria-labelledby="addClientModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addClientModalLabel">Add Client</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="<?php echo get_site_url(); ?>/thermometers/" 
                    name="newClient">
                    <div class="form-group row">
                        <label class="col-form-label col-sm-4" for="client_name">Name</label>
                        <input type="text" name="client_name" id="client_name" 
                            class="form-control form-control-sm col-sm-8" required />
                        <input type="hidden" name="calibration_calculation" value="false" />
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button id="add_client_button" type="button" class="btn btn-primary" data-dismiss="modal">
                    Save
                </button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="addClientContactModal" tabindex="-1" role="dialog" 
    aria-labelledby="addClientContactModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addClientContactModalLabel">Add Client Contact</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="<?php echo get_site_url(); ?>/thermometers/" 
                    name="newClientContact">
                    <div class="form-group row">
                        <label for="client" class="col-form-label col-sm-4">Name</label>
                        <select class="form-control form-control-sm col-sm-8" id="client_id" 
                            name="client_id" required >
                            <?php
                                if(count($clients) > 0){
                                    foreach ($clients as $client) {
                                        echo "<option value='".$client->id."'>".$client->name."</option>";
                                    }
                                }
                            ?>
                        </select>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-sm-4" for="contact_name">Contact Name</label>
                        <input type="text" name="contact_name" id="contact_name" 
                            class="form-control form-control-sm col-sm-8" required />
                        <input type="hidden" name="calibration_calculation" value="false" />
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-sm-4" for="contact_email">Contact Email</label>
                        <input type="email" name="contact_email" id="contact_email" 
                            class="form-control form-control-sm col-sm-8" required />
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-sm-4" for="contact_phone">Contact Phone</label>
                        <input type="text" name="contact_phone" id="contact_phone" 
                            class="form-control form-control-sm col-sm-8" />
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button id="add_client_contact_button" type="button" class="btn btn-primary" data-dismiss="modal">
                    Save
                </button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>