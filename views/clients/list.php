<!-- List Registered Users -->
<?php
    if(hasRole('USER_ADMIN')){
?>
<div class="row justify-content-end" style="padding-bottom: 20px;">
    <form name="ccc_post" method="POST" action="<?php echo $pageURL; ?>">
        <input type="hidden" name="api_code" value="9" />
        <button class="btn btn-sm btn-outline-dark" onclick="document.ccc_post.submit()">
            <strong><span aria-hidden="true">&plus;</span> New User </strong>
        </button>
    </form>
</div>
<div class="table-responsive">
    <table class="table table-striped table-sm table-bordered" id="clients-list" style="font-size: 0.8rem;">
        <thead>
            <tr>
                <th scope="col">Code</th>
                <th scope="col">Facility</th>
                <th scope="col">Contact</th>
                <th scope="col">Email</th>
                <th scope="col">Phone</th>
                <th scope="col">Status</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
                $active = ['Inactive', 'Active' ];
                $enable = ['Enable', 'Disable' ];
                $colors = ['btn-outline-success', 'btn-outline-danger' ];
                $badge = ['badge-warning', 'badge-success'];
                foreach ($contacts as $contact) {
                    echo "<tr><td>$contact->code</td>";
                    echo "<td>$contact->facility_name</td>";
                    echo "<td>$contact->name</td>";
                    echo "<td>$contact->email</td>";
                    echo "<td>$contact->phone</td>";
                    echo "<td><span class='badge {$badge[$contact->can_login]}'>{$active[$contact->can_login]}</span></td>";
            ?>
                    <td>
                        <form name="user_actions" method="POST" action="<?php echo $pageURL; ?>" class="inline-form">
                            <input type="hidden" name="api_code" value="10" />
                            <input type="hidden" name="contact_id" value="<?php echo $contact->id; ?>" />
                            <button class="btn btn-sm btn-outline-primary" id="user_edit">Edit</button>
                        </form>
                        <form name="user_actions" method="POST" action="<?php echo $pageURL; ?>" class="inline-form">
                            <input type="hidden" name="api_code" value="8" />
                            <input type="hidden" name="contact_id" value="<?php echo $contact->id; ?>" />
                            <input type="hidden" name="can_login" value="<?php echo $contact->can_login; ?>" />
                            <button class="btn btn-sm <?php echo "{$colors[$contact->can_login]}"; ?>" 
                                id="user_enable">
                                <?php echo "{$enable[$contact->can_login]}"; ?>
                            </button>
                        </form>
                    </td></tr>
            <?php
                }
            ?>
        </tbody>
    </table>
</div>
<?php
    }else{
        
    }
?>
<!-- / List Registered Users -->
