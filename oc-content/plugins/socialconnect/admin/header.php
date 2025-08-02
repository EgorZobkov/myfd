<?php if ( ! defined('ABS_PATH')) exit('ABS_PATH is not loaded. Direct access is not allowed.');
$route = Params::getParam('route');
?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/uikit/2.27.2/css/uikit.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/uikit/2.27.2/js/uikit.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/uikit/2.27.2/css/components/sticky.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/uikit/2.27.2/js/components/sticky.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/uikit/2.27.2/js/core/modal.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/uikit/2.27.2/js/components/sortable.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/uikit/2.27.2/css/components/sortable.min.css" />


    <style>
    #sidebar h3 {
        line-height:1em;
    }
    .uk-panel-box {
        padding: 15px;
        background: #fafafa;
        color: #666;
        border: 1px solid #E5E5E5;
        border-radius: 4px;
    }
    </style>
    <div class="header-title-market">
        <h2><?php _e('Social connect settings', 'socialconnect'); ?></h2>
    </div>
    <ul class="tabs">
        <li <?php if($route == 'sc-conf'){ echo 'class="active"';} ?>><a href="<?php echo osc_route_admin_url('sc-conf'); ?>"><?php _e('Settings', 'socialconnect'); ?></a></li>
        <li <?php if($route == 'sc-stats'){ echo 'class="active"';} ?>><a href="<?php echo osc_route_admin_url('sc-stats'); ?>"><?php _e('Stats', 'socialconnect'); ?></a></li>
        <li <?php if($route == 'sc-help'){ echo 'class="active"';} ?>><a href="<?php echo osc_route_admin_url('sc-help'); ?>"><?php _e('Help', 'socialconnect'); ?></a></li>
    </ul>
    <?php

