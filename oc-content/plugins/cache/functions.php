<?php

// ADD NOTIFICATION TO ADMIN TOOLBAR MENU TO CLEAN CACHE
function cac_admin_toolbar(){
  if( !osc_is_moderator() ) {
    $size = cac_size_dir(cac_upload_path());

    if($size > 0 && cac_param('enable') == 1) {
      $title = __('Clean cache', 'cache') . ' (' . $size . 'Mb)';
      AdminToolbar::newInstance()->add_menu(
        array(
          'id' => 'cache',
          'title' => $title,
          'href'  => osc_admin_base_url(true) . '?page=plugins&action=renderplugin&file=cache/admin/configure.php&what=cleancache',
          'meta'  => array('class' => 'action-btn action-btn-black')
        )
      );
    }
  }
}


if(!function_exists('osc_is_current_page')) {
  function osc_is_current_page($location, $section) {
    if( osc_get_osclass_location() === $location && osc_get_osclass_section() === $section ) {
      return true;
    }

    return false;
  }    
}


if(!function_exists('osc_is_register_page')) {
  function osc_is_register_page() {
    return osc_is_current_page("register", "register");
  }
}

if(!function_exists('osc_is_login_page')) {
  function osc_is_login_page() {
    return osc_is_current_page("login", "");
  }
}




osc_add_hook( 'add_admin_toolbar_menus', 'cac_admin_toolbar', 1 );

// GET FINAL TIME
function cac_time() {
  GLOBAL $cac_time_start; 
  $execution_time = (microtime(true) - $cac_time_start); 

  return number_format($execution_time, 8); 
}



// CLEANUP OLD CACHE
function cac_cleanup($path = '') {
  $clean_int = cac_param('clean_interval')*24;  // days to hours

  if($path == '') {
    $files = glob(cac_upload_path() . '*');
  } else {
    $files = glob($path . '*');
  } 

  if(count($files) > 0) {
    foreach($files as $file){ 
      if(is_file($file)) {
        if(time() - @filemtime($file) > $clean_int * 3600) {
          @unlink($file);
          clearstatcache();
        }
      } else {
        cac_cleanup($file . '/');
      }
    }
  }
}

osc_add_hook('cron_daily', 'cac_cleanup');



function cac_admin_notification() {
  $file_path = cac_upload_path() . cac_get_dir() . cac_get_name() . '.html';
  $file_url = cac_upload_url() . cac_get_dir() . cac_get_name() . '.html';

  if(osc_is_admin_user_logged_in()) {
    $tooltip = '';
    if(cac_param('disable_admin') == 1) {
      $tooltip .= osc_esc_html(__('Cache files are not generated if admin user is logged in in same browser.', 'cache'));
      $tooltip .= '&#010;';
    }
    
    $tooltip .= osc_esc_html(__('This message is visible for admin only.', 'cache'));

  }
}

function cac_admin_notification_check() {
  if(!osc_is_admin_user_logged_in()) {
    echo '<style>#cac-notif{display:none!important;}</style>';
  }
}

osc_add_hook('footer', 'cac_admin_notification');


// CHECK IF DIR IS CREATED AND WRITTABLE, IF NOT CREATE
function cac_check_dir($path) {
  if(!file_exists($path)) {
    @mkdir($path, 0744, true);
  } else if (!@chmod($dir, 0744)) {
    @chmod($path, 0744);
  }
}


// CHECK IF MOBILE DEVICE
function cac_is_mobile() {
  return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);
}


// CHECK IF CACHE CAN BE GENERATED
function cac_generate_check($file = '', $usage_check = false) {
  $user = array();
  if(function_exists('gdpr_checkbox_enabled') && gdpr_param('trigger') == 1 && osc_is_web_user_logged_in()) {
    $user = User::newInstance()->findByPrimaryKey(osc_logged_user_id());
  }

  if(
    Params::getParam('fbLogin') == 1 
    || Params::getParam('gglLogin') == 1 
    || ($usage_check == false && cac_param('disable_admin') == 1 && osc_is_admin_user_logged_in())
    || (function_exists('gdpr_checkbox_enabled') && gdpr_param('trigger') == 1 && osc_is_web_user_logged_in() && (@$user['i_gdpr_tc'] == 0 && gdpr_checkbox_enabled('tc') || @$user['i_gdpr_pp'] == 0 && gdpr_checkbox_enabled('pp')))
  ) {
    return false;
  }

  // Remove cache if too old
  $refresh_int = cac_param('refresh_interval');  // hours

  if($file == '') {
    $cache_file = cac_upload_path() . cac_get_dir() . cac_get_name() . '.html';
  } else {
    $cache_file = $file;
  }


  if(file_exists($cache_file)) {
    if(time() - @filemtime($cache_file) > $refresh_int * 3600) {
      @unlink($cache_file);
      clearstatcache();
    }
  }


  $params = Params::getParamsAsArray();
  $params['lang'] = osc_current_user_locale();
  
  if(cac_is_mobile()){
    $params['mobile'] = 1;
  } else {
    $params['mobile'] = 0;
  }

  //$messages = Session::newInstance()->_getMessage('pubMessages');
  GLOBAL $cac_messages; 
  $messages = $cac_messages;

  //if(is_array($cac_messages) && !empty($cac_messages)) {
  //  $messages = array_merge($messages, $cac_messages);
  //}

  if(is_array($messages) && !empty($messages) && count($messages) > 0) {
    return false;
  }

  if(osc_is_ad_page() && (osc_item_is_spam() || !osc_item_is_active() || !osc_item_is_enabled())) {
    return false;
  }

  if(isset($params['ajaxRequest'])) {
    return false;
  }



  if(cac_param('enable') == 0) {
    return false;
  }

  if(osc_is_web_user_logged_in() && cac_param('logged') == 0) {
    return false;
  }

  if(osc_is_home_page() && cac_param('home') == 0) {
    return false;
  }

  if(osc_is_search_page() && cac_param('search') == 0) {
    return false;
  }

  if(osc_is_ad_page() && cac_param('item') == 0) {
    return false;
  }

  if(osc_is_static_page() && cac_param('static') == 0) {
    return false;
  }

  if((osc_is_register_page() || osc_is_login_page()) && cac_param('register') == 0) {
    return false;
  }

  if(osc_is_contact_page() && cac_param('contact') == 0) {
    return false;
  }

  if(osc_is_custom_page() || !(osc_is_home_page() || osc_is_search_page() || osc_is_ad_page() || osc_is_contact_page() || osc_is_static_page() || osc_is_register_page() || osc_is_login_page())) {
    return false;
  }

  return true;
}



// CHECK IF CACHE EXISTS AND IS OK
function cac_use_cache($file) {
  if(Params::getParam('fbLogin') == 1 || Params::getParam('gglLogin') == 1) {
    return false;
  }

  if(cac_generate_check($file, true) === false) {
    return false;
  }

  if(!file_exists($file)) {
    return false;
  }

  if(@filesize($file) <= 0) {
    return false;
  }

  return true;
}


// MANAGE PARAMS
function cac_get_name() {
  $params = Params::getParamsAsArray();

  unset($params['osclass']);
  unset($params['2ec96']);

  $params['lang'] = osc_current_user_locale();
 
  if(cac_is_mobile()){
    $params['mobile'] = 1;
  } else {
    $params['mobile'] = 0;
  }
  
  if(!isset($params['page']) || @$params['page'] == '') {
    $params['page'] = 'home';
  }

  if(osc_is_web_user_logged_in()) {
    $params['user'] = osc_logged_user_id();
  }


  $nparams = array();
  $nparams['page'] = $params['page'];
  $nparams['action'] = @$params['action'];

  unset($params['page']);
  unset($params['action']);
  unset($params['cookieAction']);

  ksort($params);

  $params = array_merge($nparams, $params);
  $params = array_filter($params);

  $output = '';
  $count = 0;

  foreach($params as $n => $v) {
    if($count > 0) {
      $output .= '_';
    }
 
    $output .= @strtolower($n) . '-' . @strtolower($v);

    $count++;
  }

  return md5($output);
}


// GET CORRECT DIRECTORY
function cac_get_dir() {
  if(osc_is_home_page()) {
    return 'home/';

  } else if(osc_is_ad_page()) {
    return 'item/';

  } else if(osc_is_static_page()) {
    return 'static/';

  } else if(osc_is_register_page() || osc_is_login_page()) {
    return 'auth/';

  } else if(osc_is_search_page()) {
    return 'search/';

  } else if(osc_is_contact_page()) {
    return 'contact/';
  }
  
  return '';
}



// UPLOAD PATH
function cac_upload_path() {
  return osc_base_path() . 'oc-content/plugins/cache/files/';
}


// UPLOAD LINK
function cac_upload_url() {
  return osc_base_url() . 'oc-content/plugins/cache/files/';
}


// DELETE ALL FILES IN DIRECTORY
function cac_clean_dir($path) {
  $files = glob($path . '*');

  if(count($files) > 0) {
    foreach($files as $file) { 
      if(is_file($file)) {
        @unlink($file);
      } else {
        cac_clean_dir($file . '/');
      }
    }
  }

  clearstatcache();
}


// CLEAN CACHE WHEN NEW ITEM ADDED
function cac_clean_posted() {
  cac_clean_dir(cac_upload_path() . 'search/');
  cac_clean_dir(cac_upload_path() . 'home/');
}

osc_add_hook('posted_item', 'cac_clean_posted', 1);


// CLEAN CACHE WHEN ITEM EDITED
function cac_clean_edited($item) {
  cac_clean_dir(cac_upload_path() . 'search/');
  cac_clean_dir(cac_upload_path() . 'home/');
  cac_clear_item(osc_item_id($item));
}

osc_add_hook('edited_item', 'cac_clean_edited', 1);


// CLEAN CACHE WHEN ITEM IS REMOVED
function cac_clean_deleted($id) {
  cac_clean_dir(cac_upload_path() . 'search/');
  cac_clean_dir(cac_upload_path() . 'home/');
  cac_clear_item($id);
}

osc_add_hook('delete_item', 'cac_clean_deleted');


// CLEAN WHOLE CACHE
function cac_clean_all() {
  cac_clean_dir(cac_upload_path());
}

osc_add_hook('theme_activate', 'cac_clean_all');


// CLEAR ITEM CACHE
function cac_clear_item($id) {
  $output = 'page-item_id-' . $id;
  $file_path = cac_upload_path() . 'item/' . md5($output) . '.html';
  @unlink($file_path);
}

function cac_clear_item_alt($item) {
  $id = osc_item_id($item);
  $output = 'page-item_id-' . $id;
  $file_path = cac_upload_path() . 'item/' . md5($output) . '.html';
  @unlink($file_path);
}

osc_add_hook('activate_item', 'cac_clear_item');
osc_add_hook('deactivate_item', 'cac_clear_item');
osc_add_hook('enable_item', 'cac_clear_item');
osc_add_hook('disable_item', 'cac_clear_item');
//osc_add_hook('delete_item', 'cac_clear_item');
osc_add_hook('item_spam_on', 'cac_clear_item');
osc_add_hook('item_spam_off', 'cac_clear_item');

osc_add_hook('add_comment', 'cac_clear_item_alt');
osc_add_hook('activate_comment', 'cac_clear_item_alt');
osc_add_hook('deactivate_comment', 'cac_clear_item_alt');
osc_add_hook('enable_comment', 'cac_clear_item_alt');
osc_add_hook('disable_comment', 'cac_clear_item_alt');
osc_add_hook('delete_comment', 'cac_clear_item_alt');



// COUNT FILES IN DIRECTORY
function cac_count_dir($path) {
  $files = glob($path . '*');
  $count = 0;

  if(count($files) > 0) {
    foreach($files as $file) {
      if(is_file($file)) {
        $count++;
      } else {
        $count += cac_count_dir($file . '/');
      }
    }
  }

  return $count;
}


// SIZE FILES IN DIRECTORY
function cac_size_dir($path) {
  $files = glob($path . '*');
  $size = 0;

  if(is_array($files) && count($files) > 0) {
    foreach($files as $file){ 
      if(is_file($file)) {
        $size += filesize($file)/1000000;
      } else {
        $size += cac_size_dir($file . '/');
      }
    }
  }

  clearstatcache();

  return round($size, 2);  // in MegaBytes
}


// GZIP OUTPUT
function cac_sanitize_output($buffer) {
  $search = array(
    '/\>[^\S ]+/s',     // strip whitespaces after tags, except space
    '/[^\S ]+\</s',     // strip whitespaces before tags, except space
    '/(\s)+/s'         // shorten multiple whitespace sequences
  );

  $replace = array(
    '>',
    '<',
    '\\1'
  );

  $buffer = preg_replace($search, $replace, $buffer);

  return $buffer;
}


// CORE FUNCTIONS
function cac_param($name) {
  return osc_get_preference($name, 'plugin-cache');
}


if(!function_exists('mb_param_update')) {
  function mb_param_update( $param_name, $update_param_name, $type = NULL, $plugin_var_name = NULL ) {
  
    $val = '';
    if( $type == 'check') {

      // Checkbox input
      if( Params::getParam( $param_name ) == 'on' ) {
        $val = 1;
      } else {
        if( Params::getParam( $update_param_name ) == 'done' ) {
          $val = 0;
        } else {
          $val = ( osc_get_preference( $param_name, $plugin_var_name ) != '' ) ? osc_get_preference( $param_name, $plugin_var_name ) : '';
        }
      }
    } else {

      // Other inputs (text, password, ...)
      if( Params::getParam( $update_param_name ) == 'done' && Params::existParam($param_name)) {
        $val = Params::getParam( $param_name );
      } else {
        $val = ( osc_get_preference( $param_name, $plugin_var_name) != '' ) ? osc_get_preference( $param_name, $plugin_var_name ) : '';
      }
    }


    // If save button was pressed, update param
    if( Params::getParam( $update_param_name ) == 'done' ) {

      if(osc_get_preference( $param_name, $plugin_var_name ) == '') {
        osc_set_preference( $param_name, $val, $plugin_var_name, 'STRING');  
      } else {
        $dao_preference = new Preference();
        $dao_preference->update( array( "s_value" => $val ), array( "s_section" => $plugin_var_name, "s_name" => $param_name ));
        osc_reset_preferences();
        unset($dao_preference);
      }
    }

    return $val;
  }
}


// CHECK IF RUNNING ON DEMO
function cac_is_demo() {
  if(osc_logged_admin_username() == 'admin') {
    return false;
  } else if(isset($_SERVER['HTTP_HOST']) && (strpos($_SERVER['HTTP_HOST'],'mb-themes') !== false || strpos($_SERVER['HTTP_HOST'],'abprofitrade') !== false)) {
    return true;
  } else {
    return false;
  }
}


if(!function_exists('message_ok')) {
  function message_ok( $text ) {
    $final  = '<div class="flashmessage flashmessage-ok flashmessage-inline">';
    $final .= $text;
    $final .= '</div>';
    echo $final;
  }
}


if(!function_exists('message_error')) {
  function message_error( $text ) {
    $final  = '<div class="flashmessage flashmessage-error flashmessage-inline">';
    $final .= $text;
    $final .= '</div>';
    echo $final;
  }
}


if( !function_exists('osc_is_contact_page') ) {
  function osc_is_contact_page() {
    $location = Rewrite::newInstance()->get_location();
    $section = Rewrite::newInstance()->get_section();
    if( $location == 'contact' ) {
      return true ;
    }

    return false ;
  }
}


// COOKIES WORK
if(!function_exists('mb_set_cookie')) {
  function mb_set_cookie($name, $val) {
    Cookie::newInstance()->set_expires( 86400 * 30 );
    Cookie::newInstance()->push($name, $val);
    Cookie::newInstance()->set();
  }
}


if(!function_exists('mb_get_cookie')) {
  function mb_get_cookie($name) {
    return Cookie::newInstance()->get_value($name);
  }
}

if(!function_exists('mb_drop_cookie')) {
  function mb_drop_cookie($name) {
    Cookie::newInstance()->pop($name);
  }
}


if(!function_exists('mb_generate_rand_string')) {
  function mb_generate_rand_string($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';

    for ($i = 0; $i < $length; $i++) {
      $randomString .= $characters[rand(0, $charactersLength - 1)];
    }

    return $randomString;
  }
}


?>