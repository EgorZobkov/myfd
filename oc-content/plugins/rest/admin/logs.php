<?php
  // Create menu
  $title = __('Configure', 'rest');
  rest_menu($title);


  // GET & UPDATE PARAMETERS
  // $variable = mb_param_update( 'param_name', 'form_name', 'input_type', 'plugin_var_name' );
  // input_type: check or value
  
  $key = Params::getParam('key');
  $keys = ModelREST::newInstance()->getKeys();
  $logs = ModelREST::newInstance()->getLogs($key);
  $stats = ModelREST::newInstance()->getStats();
?>


<div class="mb-body">

  <!-- STATS SECTION -->
  <div class="mb-box">
    <div class="mb-head"><i class="fa fa-dashboard"></i> <?php _e('Stats', 'rest'); ?></div>

    <div class="mb-inside mb-rest">
      <div class="mb-table mb-table-stats">
        <div class="mb-table-head">
          <div class="mb-col-4 mb-align-left"><?php _e('API Key', 'rest');?></div>
          <div class="mb-col-3"><?php _e('YearMonth', 'rest');?></div>
          <div class="mb-col-3"><?php _e('Successful Calls', 'rest');?></div>
          <div class="mb-col-3"><?php _e('Failed Calls', 'rest');?></div>
          <div class="mb-col-3"><?php _e('Total Calls', 'rest');?></div>
          <div class="mb-col-3"><?php _e('Total Exec Time', 'rest');?></div>
          <div class="mb-col-5"><?php _e('Read / Insert / Update / Delete Calls', 'rest');?></div>
        </div>
        
        <?php if(count($stats) > 0) { ?>
          <?php foreach($stats as $s) { ?>
            <div class="mb-table-row">
              <div class="mb-col-4 mb-align-left"><a href="<?php echo osc_admin_base_url(true); ?>?page=plugins&action=renderplugin&file=rest/admin/logs.php&key=<?php echo $s['key_id']; ?>" title="<?php echo osc_esc_html(__('Click to see logs', 'rest')); ?>"><?php echo $s['key']; ?></a></div>
              <div class="mb-col-3"><?php echo $s['yearmonth']; ?></div>
              <div class="mb-col-3"><?php echo $s['calls_success']; ?></div>
              <div class="mb-col-3"><?php echo $s['calls_failed']; ?></div>
              <div class="mb-col-3"><?php echo $s['calls_total']; ?></div>
              <div class="mb-col-3"><?php echo round($s['exec_time'], 3); ?>s</div>
              <div class="mb-col-5"><?php echo $s['calls_read']; ?> / <?php echo $s['calls_insert']; ?> / <?php echo $s['calls_update']; ?> / <?php echo $s['calls_delete']; ?></div>
            </div>
          <?php } ?>
        <?php } else { ?>
          <div class="mb-table-row mb-row-empty">
            <i class="fa fa-warning"></i><span><?php _e('No stats has been found', 'rest'); ?></span>
          </div>
        <?php } ?>
        
      </div>
    </div>
  </div>
  
  
  <!-- LOGS SECTION -->
  <div class="mb-box">
    <div class="mb-head"><i class="fa fa-database"></i> <?php _e('Logs history (last 1000)', 'rest'); ?></div>

    <div class="mb-inside mb-rest">
      <div class="mb-table mb-table-log">
        <div class="mb-table-head">
          <div class="mb-col-2"><?php _e('ID', 'rest');?></div>
          <div class="mb-col-2 mb-align-left"><?php _e('Type', 'rest');?></div>
          <div class="mb-col-4 mb-align-left"><?php _e('Action', 'rest');?></div>
          <div class="mb-col-8 mb-align-left"><?php _e('Details', 'rest');?></div>
          <div class="mb-col-2"><?php _e('Status', 'rest');?></div>
          <div class="mb-col-3"><?php _e('Execution Time', 'rest');?></div>
          <div class="mb-col-3"><?php _e('Date', 'rest');?></div>
        </div>
        
        <?php if($key == '') { ?>
          <div class="mb-table-row mb-row-empty" style="padding:70px 20px;height:auto!important;">
            <label for="key" style="font-weight:bold;padding: 0; width: 100%; text-align: center; }"><?php _e('Select API Key', 'rest'); ?>:</label>
            <select name="key" class="key">
              <option value=""><?php _e('Select API Key', 'rest'); ?></option>

              <?php if(count($keys) > 0) { ?>
                <?php foreach($keys as $k) { ?>
                  <option value="<?php echo $k['pk_i_id']; ?>"><?php echo $k['s_name']; ?></option>
                <?php } ?>
              <?php } else { ?>
                <option value=""><?php _e('No API Key found', 'rest'); ?></option>
              <?php } ?>
            </select>
          </div>
        <?php } else { ?>
          <?php if(count($logs) > 0) { ?>
            <?php foreach($logs as $l) { ?>
              <div class="mb-table-row">
                <div class="mb-col-2"><?php echo $l['pk_i_id']; ?></div>
                <div class="mb-col-2 mb-align-left"><?php echo rest_get_type($l['s_type']); ?></div>
                <div class="mb-col-4 mb-align-left"><?php echo $l['s_action']; ?></div>
                <div class="mb-col-8 mb-align-left"><?php echo $l['s_detail']; ?></div>
                <div class="mb-col-2"><?php echo rest_get_status($l['s_status']); ?></div>
                <div class="mb-col-3"><?php echo round($l['d_time'], 4); ?>s</div>
                <div class="mb-col-3" style="color:#888"><?php echo date('Y-m-d H:i:s', strtotime($l['dt_datetime'])); ?></div>
              </div>
            <?php } ?>
          <?php } else { ?>
            <div class="mb-table-row mb-row-empty">
              <i class="fa fa-warning"></i><span><?php _e('No logs has been found', 'rest'); ?></span>
            </div>
          <?php } ?>
        <?php } ?>
        
      </div>
    </div>
  </div>       
</div>

<script>
  $(document).ready(function() {
    $('body').on('change', 'select[name="key"]', function(e) { 
      if($(this).val() != '') {
        window.location.href = "<?php echo osc_admin_base_url(true); ?>?page=plugins&action=renderplugin&file=rest/admin/logs.php&key=" + $(this).val();
      }    
    });
  });
</script>


<?php echo rest_footer(); ?>