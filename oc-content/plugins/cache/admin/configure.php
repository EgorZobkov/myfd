<?php
  // Create menu
  $title = __('Configure', 'cache');
  cac_menu($title);


  // GET & UPDATE PARAMETERS
  // $variable = mb_param_update( 'param_name', 'form_name', 'input_type', 'plugin_var_name' );
  // input_type: check or value

  $enable = mb_param_update('enable', 'plugin_action', 'check', 'plugin-cache');
  $disable_admin = mb_param_update('disable_admin', 'plugin_action', 'check', 'plugin-cache');
  $refresh_interval = mb_param_update('refresh_interval', 'plugin_action', 'value', 'plugin-cache');
  $clean_interval = mb_param_update('clean_interval', 'plugin_action', 'value', 'plugin-cache');
  $home = mb_param_update('home', 'plugin_action', 'check', 'plugin-cache');
  $search = mb_param_update('search', 'plugin_action', 'check', 'plugin-cache');
  $item = mb_param_update('item', 'plugin_action', 'check', 'plugin-cache');
  $register = mb_param_update('register', 'plugin_action', 'check', 'plugin-cache');
  $contact = mb_param_update('contact', 'plugin_action', 'check', 'plugin-cache');
  $static = mb_param_update('static', 'plugin_action', 'check', 'plugin-cache');
  $logged = mb_param_update('logged', 'plugin_action', 'check', 'plugin-cache');
  $compress = mb_param_update('compress', 'plugin_action', 'check', 'plugin-cache');


  if(Params::getParam('plugin_action') == 'done') {
    message_ok( __('Settings were successfully saved', 'cache') );
  }

  if(Params::getParam('what') == 'cleancache') {
    cac_clean_dir(cac_upload_path());

    osc_add_flash_ok_message(__('Cache successfully removed.', 'cache'), 'admin');
    header('Location:' . osc_admin_base_url(true) . '?page=plugins&action=renderplugin&file=cache/admin/configure.php');
    exit;
  }
?>


<div class="mb-body">

  <div class="mb-row mb-notes">
    <div class="mb-line"><?php echo sprintf(__('Cache plugin currently use %d cache files with total size of %s Mb.', 'cache'), cac_count_dir(cac_upload_path()), cac_size_dir(cac_upload_path())); ?></div>
  </div>


  <!-- CONFIGURE SECTION -->
  <div class="mb-box">
    <div class="mb-head"><i class="fa fa-wrench"></i> <?php _e('Configure', 'cache'); ?></div>

    <div class="mb-inside mb-minify">
      <form name="promo_form" action="<?php echo osc_admin_base_url(true); ?>" method="POST" enctype="multipart/form-data" >
        <?php if(!cac_is_demo()) { ?>
        <input type="hidden" name="page" value="plugins" />
        <input type="hidden" name="action" value="renderplugin" />
        <input type="hidden" name="file" value="<?php echo osc_plugin_folder(__FILE__); ?>configure.php" />
        <input type="hidden" name="plugin_action" value="done" />
        <?php } ?>

        <div class="mb-row">
          <label for="enable" class="h1"><span><?php _e('Enable Cache', 'cache'); ?></span></label> 
          <input name="enable" type="checkbox" class="element-slide" <?php echo ($enable == 1 ? 'checked' : ''); ?> />

          <div class="mb-explain"><?php _e('When enabled, plugin will generate cache for selected pages.', 'cache'); ?></div>
        </div>
        
        <div class="mb-row">
          <label for="disable_admin" class=""><span><?php _e('Disable Caching by Admin', 'cache'); ?></span></label> 
          <input name="disable_admin" type="checkbox" class="element-slide" <?php echo ($disable_admin == 1 ? 'checked' : ''); ?> />

          <div class="mb-explain"><?php _e('When enabled, cache is not generated when admin user is logged in in browser. This prevents unwanted "admin" content to be added into cache and exposed to customers.', 'cache'); ?></div>
        </div>

        <div class="mb-row">
          <label for="home" class="h2"><span><?php _e('Enable Home Page Caching', 'cache'); ?></span></label> 
          <input name="home" type="checkbox" class="element-slide" <?php echo ($home == 1 ? 'checked' : ''); ?> />

          <div class="mb-explain"><?php _e('Enable caching of home page. In case you show items on home page in random order, this will not work until cache is refreshed.', 'cache'); ?></div>
        </div>

        <div class="mb-row">
          <label for="search" class="h3"><span><?php _e('Enable Search Page Caching', 'cache'); ?></span></label> 
          <input name="search" type="checkbox" class="element-slide" <?php echo ($search == 1 ? 'checked' : ''); ?> />

          <div class="mb-explain"><?php _e('This may be very extensive on hosting resources (space) as 1 file is created for each combination. When you enable this option, monitor space usage of plugin regulary.', 'cache'); ?></div>
        </div>

        <div class="mb-row">
          <label for="item" class="h4"><span><?php _e('Enable Item Page Caching', 'cache'); ?></span></label> 
          <input name="item" type="checkbox" class="element-slide" <?php echo ($item == 1 ? 'checked' : ''); ?> />

          <div class="mb-explain"><?php _e('This may be extensive on hosting resources (space) as 1 file is created for each item. When you enable this option, monitor space usage of plugin regulary.', 'cache'); ?></div>
        </div>


        <div class="mb-row">
          <label for="static" class="h5"><span><?php _e('Enable Static Pages Caching', 'cache'); ?></span></label> 
          <input name="static" type="checkbox" class="element-slide" <?php echo ($static == 1 ? 'checked' : ''); ?> />

          <div class="mb-explain"><?php _e('Enable caching of static pages.', 'cache'); ?></div>
        </div>


        <div class="mb-row">
          <label for="register" class="h6"><span><?php _e('Enable Register Page Caching', 'cache'); ?></span></label> 
          <input name="register" type="checkbox" class="element-slide" <?php echo ($register == 1 ? 'checked' : ''); ?> />

          <div class="mb-explain"><?php _e('Enable caching of authentication pages, includes both login & register page.', 'cache'); ?></div>
        </div>

        <div class="mb-row">
          <label for="contact" class="h6"><span><?php _e('Enable Contact Page Caching', 'cache'); ?></span></label> 
          <input name="contact" type="checkbox" class="element-slide" <?php echo ($contact == 1 ? 'checked' : ''); ?> />

          <div class="mb-explain"><?php _e('Enable caching of contact page.', 'cache'); ?></div>
        </div>


        <div class="mb-row">
          <label for="logged" class="h9"><span><?php _e('Enable Caching for Logged Users', 'cache'); ?></span></label> 
          <input name="logged" type="checkbox" class="element-slide" <?php echo ($logged == 1 ? 'checked' : ''); ?> />

          <div class="mb-explain"><?php _e('This may be very extensive on hosting resources (space) as cache files are generated separately for every user. When you enable this option, monitor space usage of plugin regulary.', 'cache'); ?></div>
        </div>


        <div class="mb-row">
          <label for="compress" class="h10"><span><?php _e('Compress Cached Files', 'cache'); ?></span></label> 
          <input name="compress" type="checkbox" class="element-slide" <?php echo ($compress == 1 ? 'checked' : ''); ?> />

          <div class="mb-explain"><?php _e('Enable compression to reduce size of cache files. If you experience any kind of issues with compress option (like javascript errors), disable it.', 'cache'); ?></div>
        </div>


        <div class="mb-row">
          <label for="refresh_interval" class="h7"><span><?php _e('Refresh Interval', 'cache'); ?></span></label> 
          <input name="refresh_interval" type="number" min="1" value="<?php echo $refresh_interval; ?>" />
          <div class="mb-input-desc"><?php _e('hours', 'cache'); ?></div>

          <div class="mb-explain"><?php _e('Enter after how many hours cache is refreshed.', 'cache'); ?></div>
        </div>


        <div class="mb-row">
          <label for="clean_interval" class="h8"><span><?php _e('Clearing Interval', 'cache'); ?></span></label> 
          <input name="clean_interval" type="number" min="1" value="<?php echo $clean_interval; ?>" />
          <div class="mb-input-desc"><?php _e('days', 'cache'); ?></div>

          <div class="mb-explain"><?php _e('Enter after how many days cache file is removed. In case you want to save server space, put less days. This functionality require CRON to be fully functional on your osclass.', 'cache'); ?></div>
        </div>



        <div class="mb-row">
          <label><span>&nbsp;</span></label> 
          <a href="<?php echo osc_admin_base_url(true); ?>?page=plugins&action=renderplugin&file=cache/admin/configure.php&what=cleancache" class="mb-button-green"><?php _e('Clear cache', 'cache'); ?></a>
        </div>


        <div class="mb-row">&nbsp;</div>

        <div class="mb-foot">
          <?php if(cac_is_demo()) { ?>
            <a class="mb-button mb-has-tooltip disabled" onclick="return false;" style="cursor:not-allowed;opacity:0.5;" title="<?php echo osc_esc_html(__('This is demo site', 'cache')); ?>"><?php _e('Save', 'cache');?></a>
          <?php } else { ?>
            <button type="submit" class="mb-button"><?php _e('Save', 'cache');?></button>
          <?php } ?>
        </div>
      </form>
    </div>
  </div>


  <!-- PLUGIN INTEGRATION -->
  <div class="mb-box">
    <div class="mb-head"><i class="fa fa-wrench"></i> <?php _e('Plugin Setup', 'cache'); ?></div>

    <div class="mb-inside">

      <div class="mb-row">
        <div class="mb-line"><?php _e('Plugin does not require any modifications in theme files.', 'cache'); ?></div>

      </div>
    </div>
  </div>
</div>


<?php echo cac_footer(); ?>