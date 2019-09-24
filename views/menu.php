<div class="dropdown">
    <button class="btn btn-outline-light" type="button" id="dropdownMenuButton"
        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <span class="oi" data-glyph="menu" title="menu" aria-hidden="true" style="color: #000;"></span>
    </button>
    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
        <?php if(hasRole('USER_ADMIN')){ ?>
            <a class="dropdown-item" href="/dashboard/">Dashboard</a>
        <?php } ?>
        <button class="dropdown-item" id="service-requests-menu">Service Requests</button>
        <div class="dropdown-divider"></div>
        <a class="dropdown-item" href="/centrifuges/">Centrifuges</a>
        <button class="dropdown-item" id="conditioned-chambers-menu">Conditioned Chambers</button>
        <a class="dropdown-item" href="/thermometers/">Thermometers</a>
        <a class="dropdown-item" href="/timers/">Timers</a>
        <?php if(hasRole('USER_ADMIN')){ ?>
            <div class="dropdown-divider"></div>
            <button class="dropdown-item" id="client-contacts-menu">Client Contacts</button>
        <?php } ?>
    </div>
</div>
