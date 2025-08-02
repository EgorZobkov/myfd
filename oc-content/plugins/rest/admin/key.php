<?php
  $key_id = (Params::getParam('keyId') > 0 ? Params::getParam('keyId') : Params::getParam('pk_i_id'));
  $key_id = ($key_id > 0 ? $key_id : Params::getParam('keyEditId'));
  
  // Create menu

  if(Params::getParam('plugin_action') == 'done') {
    $data = array(
      'pk_i_id' => Params::getParam('pk_i_id'),
      's_name' => Params::getParam('s_name'),
      's_description' => Params::getParam('s_description'),
      's_key' => Params::getParam('s_key'),
      's_email' => Params::getParam('s_email'),
      's_privilege' => Params::getParam('s_privilege'),
      's_status' => Params::getParam('s_status'),
      'i_max_calls' => (Params::getParam('i_max_calls') > 0 ? Params::getParam('i_max_calls') : 0),
      'dt_datetime' => date('Y-m-d H:i:s')
    );


    if(Params::getParam('pk_i_id') <= 0) {
      unset($data['pk_i_id']);
      $key_id = ModelREST::newInstance()->insertKey($data);
      message_ok(__('API Key successfully created', 'rest'));

    } else {
      ModelREST::newInstance()->updateKey($data);
      $key_id = Params::getParam('pk_i_id');
      message_ok(__('API Key successfully updated', 'rest'));
    }
  }



  if($key_id > 0) {
    $title = __('Edit API Key', 'rest');
    $button_title = __('Update settings', 'rest');
  } else {
    $title = __('Add a new API Key', 'rest');
    $button_title = __('Create an API Key', 'rest');
  }

  rest_menu($title);


  // GET & UPDATE PARAMETERS
  // $variable = mb_param_update( 'param_name', 'form_name', 'input_type', 'plugin_var_name' );
  // input_type: check or value
  // $enable = mb_param_update('enable', 'plugin_action', 'check', 'plugin-rest');


  if($key_id > 0) {
    $key = ModelREST::newInstance()->getKeyById($key_id);
  } else {
    $key = array();
  }

  $privilege_array = explode(',', @$key['s_privilege']); 
  $privilege_all = array('read', 'insert', 'update', 'delete');
?>


<div class="mb-body">

  <!-- IMPORTS SETTINGS -->
  <div class="mb-box">
    <div class="mb-head">
      <i class="fa fa-list"></i> <?php _e('API Key settings', 'rest'); ?>
    </div>

    <div class="mb-inside">

      <form name="promo_form" action="<?php echo osc_admin_base_url(true); ?>" method="POST" enctype="multipart/form-data" >
        <input type="hidden" name="page" value="plugins" />
        <input type="hidden" name="action" value="renderplugin" />
        <input type="hidden" name="file" value="<?php echo osc_plugin_folder(__FILE__); ?>key.php" />
        <input type="hidden" name="plugin_action" value="done" />

        <div class="mb-row" <?php if($key_id <= 0) { ?>style="display:none;"<?php } ?>>
          <label for="pk_i_id"><span><?php _e('Key ID', 'rest'); ?></span></label> 
          <input name="pk_i_id" size="10" type="text" value="<?php echo @$key['pk_i_id']; ?>" readonly/>

          <div class="mb-explain"><?php _e('Unique identifier of API Key', 'rest'); ?></div>
        </div>

        <div class="mb-row">
          <label for="s_name"><span><?php _e('Name', 'rest'); ?></span></label> 
          <input name="s_name" size="60" type="text" value="<?php echo @$key['s_name']; ?>" required />

          <div class="mb-explain"><?php _e('Enter name that you will use to recognize this API Key', 'rest'); ?></div>
        </div>

        <div class="mb-row">
          <label for="s_description"><span><?php _e('Description', 'rest'); ?></span></label> 
          <textarea name="s_description" style="max-width: 50%; min-width: 50%; height: 90px;"><?php echo @$key['s_description']; ?></textarea>

          <div class="mb-explain"><?php _e('Provide details about key that can help you identify purpose and usage of this key in future', 'rest'); ?></div>
        </div>

        <div class="mb-row">
          <label for="s_email"><span><?php _e('Contact Email', 'rest'); ?></span></label> 
          <input name="s_email" size="40" type="text" value="<?php echo @$key['s_email']; ?>" />

          <div class="mb-explain"><?php _e('Contact email to holder of key.', 'rest'); ?></div>
        </div>

        <div class="mb-row">
          <label for="s_key"><span><?php _e('Key / Secret', 'rest'); ?></span></label> 
          <input name="s_key" size="60" type="text" value="<?php echo (@$key['s_key'] <> '' ? $key['s_key'] : mb_generate_rand_string(30)); ?>" required />

          <div class="mb-explain"><?php _e('Key / Secret code used to access Rest API. Do not publish it anywhere, provide just to responsible person!', 'rest'); ?></div>
        </div>


        <div class="mb-line mb-row-select-multiple">
          <label for="category_multiple" class="h6"><span class=""><?php _e('Privileges', 'rest'); ?></span></label> 

          <input type="hidden" name="s_privilege" id="s_privilege" value="<?php echo @$key['s_privilege']; ?>"/>
          <select id="s_privilege_multiple" name="s_privilege_multiple" multiple style="max-height: 84px; min-height: 84px;" required>
            <?php foreach($privilege_all as $p) { ?>
              <option value="<?php echo $p; ?>" <?php if(in_array($p, $privilege_array)) { ?>selected="selected"<?php } ?> <?php if($p == 'delete' && rest_is_demo()) { ?>disabled<?php } ?>><?php echo rest_get_type($p); ?></option>
            <?php } ?>
          </select>

          <div class="mb-explain"><?php _e('If not category selected, advert is shown in all categories.', 'rest'); ?></div>
        </div>



        <div class="mb-row">
          <label for="s_status"><span><?php _e('Status', 'rest'); ?></span></label> 
          <select name="s_status" required>
            <option value="active" <?php if(@$key['s_status'] == '' or @$key['s_file_format'] == 'active') { ?>selected="selected"<?php } ?>><?php _e('Active', 'rest'); ?></option>
            <option value="inactive" <?php if(@$key['s_status'] == 'inactive') { ?>selected="selected"<?php } ?>><?php _e('Inactive', 'rest'); ?></option>
          </select>

          <div class="mb-explain"><?php _e('Deactivate API key if it was exposed or should not be used anymore', 'rest'); ?></div>
        </div>


        <div class="mb-row">&nbsp;</div>

        <div class="mb-foot">
          <button type="submit" class="mb-button"><?php echo $button_title; ?></button>
        </div>
      </form>
    </div>
  </div>
  
</div>


<?php echo rest_footer(); ?>