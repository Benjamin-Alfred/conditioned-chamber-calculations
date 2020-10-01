<div class="dropdown">
    <button class="btn btn-outline-light" type="button" id="dropdownMenuButton"
        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <span class="oi" data-glyph="menu" title="menu" aria-hidden="true" style="color: #000;"></span>
    </button>
    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
        <?php if(hasRole('DATA_ANALYST')){ ?>
            <a class="dropdown-item" href="/dashboard/">Dashboard</a>
        <?php } ?>
        <?php if(hasRole('USER_ADMIN') || hasRole('CALIBRATOR') || hasRole('REVIEWER') || hasRole('APPROVER')){ ?>
            <button class="dropdown-item" id="service-requests-menu">Service Requests</button>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="/centrifuges/">Centrifuges</a>
            <a class="dropdown-item" href="/conditioned-chambers/">Conditioned Chambers</a>
            <a class="dropdown-item" href="/pipettes/">Pipettes</a>
            <a class="dropdown-item" href="/thermometers/">Thermometers</a>
            <a class="dropdown-item" href="/timers/">Timers</a>
        <?php } ?>
        <?php if(hasRole('USER_ADMIN')){ ?>
            <div class="dropdown-divider"></div>
            <button class="dropdown-item" id="client-contacts-menu">Client Contacts</button>
        <?php } ?>
    </div>
</div>
