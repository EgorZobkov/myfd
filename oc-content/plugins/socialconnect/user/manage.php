<?php

$providers = SCClass::providers();

if(Params::getParam('unlink')!='') {
    SCModel::newInstance()->delete(array('fk_i_user_id' => osc_logged_user_id(), 's_provider' => Params::getParam('unlink')));
    ob_get_clean();
    osc_add_flash_ok_message(__('Account unlinked correctly', 'socialconnect'));
    osc_redirect_to(osc_route_url('sc-manage'));
}

$url = osc_route_url('sc-manage');

$linked_account = 0;
$not_linked_account = 0;
foreach($providers as $key => $provider) {
    if (osc_get_preference('enabled_' . $key, 'socialconnect') == 1 && SCModel::newInstance()->linked(osc_logged_user_id(), $provider)) {
        $linked_account++;
    } else {
        $not_linked_account++;
    }
}

?>
<div class="wrapper wrapper-flash">
    <div id="flash_js"></div>
</div>
<h2><?php _e('Social accounts', 'socialconnect'); ?></h2>

<?php if($linked_account>0) { ?>
    <style>
        /* ========================================================================
   Component: Table
 ========================================================================== */
        /*
         * 1. Remove most spacing between table cells.
         * 2. Block element behavior
         * 3. Style
         */
        .uk-table {
            /* 1 */
            border-collapse: collapse;
            border-spacing: 0;
            /* 2 */
            width: 100%;
            /* 3 */
            margin-bottom: 15px;
        }
        /*
         * Add margin if adjacent element
         */
        * + .uk-table {
            margin-top: 15px;
        }
        .uk-table th,
        .uk-table td {
            padding: 8px 8px;
            line-height: 42px;
        }
        /*
         * Set alignment
         */
        .uk-table th {
            text-align: left;
        }
        .uk-table td {
            vertical-align: top;
        }
        .uk-table thead th {
            vertical-align: bottom;
        }
        /*
         * Caption and footer
         */
        .uk-table caption,
        .uk-table tfoot {
            font-size: 12px;
            font-style: italic;
        }
        .uk-table caption {
            text-align: left;
            color: #999;
        }
        /*
         * Active State
         */
        .uk-table tbody tr.uk-active {
            background: #EEE;
        }
        /* Sub-modifier: `uk-table-middle`
         ========================================================================== */
        .uk-table-middle,
        .uk-table-middle td {
            vertical-align: middle !important;
        }
        /* Modifier: `uk-table-striped`
         ========================================================================== */
        .uk-table-striped tbody tr:nth-of-type(odd) {
            background: #f5f5f5;
        }
        /* Modifier: `uk-table-condensed`
         ========================================================================== */
        .uk-table-condensed td {
            padding: 4px 8px;
        }
        /* Modifier: `uk-table-hover`
         ========================================================================== */
        .uk-table-hover tbody tr:hover {
            background: #EEE;
        }
    </style>

<table class="uk-table uk-table-hover uk-table-striped uk-table-condensed uk-margin-left">
    <thead>
    <tr>
        <th>Picture</th>
        <th>Network</th>
        <th>Unlink</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach($providers as $key => $provider) {
        if(osc_get_preference('enabled_' . $key, 'socialconnect')==1 && SCModel::newInstance()->linked(osc_logged_user_id(), $provider)) { ?>
            <tr>
                <?php
                $pp = sc_profile_picture(osc_logged_user_id(), $provider);
                if($pp!="") { ?>
                <td><?php echo $pp; ?></td>
                <?php } else { ?>
                <td>&nbsp;</td>
                <?php } ?>
                <td><?php echo $provider; ?></td>
                <td><a href="<?php echo osc_route_url('sc-manage') . '?unlink=' . $provider; ?>" onclick="return confirm('<?php echo osc_esc_js(__('Are you sure to unlink your account?', 'socialconnect')); ?>');"><?php _e('Unlink account', 'socialconnect'); ?></a></td>
            </tr>
        <?php }
    } ?>
    </tbody>
</table>
<div style="clear"></div>
<?php } ?>

<?php if($not_linked_account>0) { ?>
<div>
    <br>
    <h6><?php _e('You can link your account with the following providers:', 'socialconnect'); ?></h6>
<?php foreach($providers as $key => $provider) {
        if(osc_get_preference('enabled_' . $key, 'socialconnect')==1
            && osc_get_preference($key . '_app_id', 'socialconnect')!=""
            && osc_get_preference($key . '_app_secret', 'socialconnect')!="") {
            if (!SCModel::newInstance()->linked(osc_logged_user_id(), $provider)) {
                sc_button($key, $provider, $url);
            }
    }
} ?>
</div>
<?php } ?>