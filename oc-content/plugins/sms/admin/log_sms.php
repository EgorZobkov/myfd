<?php
  // Create menu
  $title = __('SMS Logs', 'sms');
  sms_menu($title);


  // GET & UPDATE PARAMETERS
  // $variable = sms_param_update( 'param_name', 'form_name', 'input_type', 'plugin_var_name' );
  // input_type: check or value or value_crypt

  $logs = ModelSMS::newInstance()->getSmsLogs();
?>


<div class="mb-body">
  <!-- CONFIGURE SECTION -->
  <div class="mb-box">
    <div class="mb-head"><i class="fa fa-database"></i> <?php _e('SMS Logs', 'sms'); ?></div>

    <div class="mb-inside">
      <div class="mb-row mb-notes">
        <div class="mb-line"><?php _e('Last 5000 sms logs are shown.', 'sms'); ?></div>
        <div class="mb-line"><?php _e('You cannot remove sms log.', 'sms'); ?></div>
      </div>

      <div class="mb-table mb-table-log">
        <div class="mb-table-head">
          <div class="mb-col-1"><span><?php _e('ID', 'sms');?></span></div>
          <div class="mb-col-3"><span><?php _e('User', 'sms'); ?></span></div>
          <div class="mb-col-4"><span><?php _e('Phone', 'sms'); ?></span></div>
          <div class="mb-col-5"><span><?php _e('Message', 'sms'); ?></span></div>
          <div class="mb-col-2"><span><?php _e('Date', 'sms'); ?></span></div>
          <div class="mb-col-3"><span><?php _e('Action', 'sms'); ?></span></div>
          <div class="mb-col-2"><span><?php _e('Provider', 'sms'); ?></span></div>
          <div class="mb-col-3"><span><?php _e('Response', 'sms'); ?></span></div>
          <div class="mb-col-1"><span><?php _e('Status', 'sms'); ?></span></div>
        </div>

        <?php if(count($logs) <= 0) { ?>
          <div class="mb-table-row mb-row-empty">
            <i class="fa fa-warning"></i><span><?php _e('No sms logs has been found', 'sms'); ?></span>
          </div>
        <?php } else { ?>
          <?php foreach($logs as $l) { ?>
            <?php $user = User::newInstance()->findByPrimaryKey($l['fk_i_user_id']); ?>

            <div class="mb-table-row">
              <div class="mb-col-1"><?php echo $l['pk_i_id']; ?></div>
              <div class="mb-col-3"><?php echo (@$user['s_name'] <> '' ? $user['s_name'] : '-'); ?></div>
              <div class="mb-col-4"><?php echo $l['s_phone_number']; ?></div>
              <div class="mb-col-5"><?php echo $l['s_message']; ?></div>
              <div class="mb-col-2"><?php echo $l['dt_date']; ?></div>
              <div class="mb-col-3"><?php echo $l['s_action']; ?></div>
              <div class="mb-col-2"><?php echo $l['s_provider']; ?></div>

              <div class="mb-col-3"><span class="mb-has-tooltip mb-log-response"><i class="fa fa-search" title="<?php echo osc_esc_html(__('Click to open response', 'sms')); ?>"></i> <span><?php _e('Response details', 'sms'); ?></span></span></div>

              <div class="mb-col-1"><?php echo $l['s_status']; ?></div>

              <div class="mb-line mb-response" style="display:none;">
                <span class="mb-code">
                  <?php _e('RESPONSE:', 'sms'); ?><br/><?php echo stripslashes($l['s_response']); ?>

                  <?php if($l['s_error'] <> '' && $l['s_error'] <> 0) { ?>
                    <br/><br/><?php _e('ERROR:', 'sms'); ?><br/><?php echo $l['s_error']; ?>
                  <?php } ?>
                </span>
              </div>
            </div>
          <?php } ?>
        <?php } ?>
      </div>
    </div>
  </div>

</div>

<?php echo sms_footer(); ?>