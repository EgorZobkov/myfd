<?php
/*
 * Copyright 2016 Osclass
 *
 * You shall not distribute this plugin and any its files (except third-party libraries) to third parties.
 * Rental, leasing, sale and any other form of distribution are not allowed and are strictly forbidden.
 */

/*
Plugin Name: Social Connect
Description: Add login button from most used social networks
Version: 2.1.0
Author: Osclass
Author URI: https://osclass.org
Plugin URI: https://osclass.org
Short Name: socialconnect
Plugin update URI: socialconnect
*/

define('SC_PLUGIN_FOLDER', 'socialconnect/');
define('SC_PATH', PLUGINS_PATH . SC_PLUGIN_FOLDER);
define('SC_VERSION', '210');

require_once SC_PATH . 'lib/vendor/autoload.php';
require_once SC_PATH . 'class/SCClass.php';
require_once SC_PATH . 'model/SCModel.php';

function sc_install() {
    SCModel::newInstance()->install();
}

function sc_uninstall() {
    SCModel::newInstance()->uninstall();
}

function sc_update() {
    $version = osc_get_preference('version', 'socialconnect');
    if($version=="") {
        $version = 100;
    }
    if($version<200) {
        // add new social networks to order
        $sorder = 'fb,google,twitter,linkedin,instagram,live';
        osc_set_preference('order_providers', $sorder, 'socialconnect');
    }
    if($version<210) {
        // add profile picture
        $conn = DBConnectionClass::newInstance();
        $data = $conn->getOsclassDb();
        $dbCommand = new DBCommandClass($data);
        $dbCommand->query(sprintf('ALTER TABLE `%st_social_connect` ADD `s_picture_profile` VARCHAR(300) NOT NULL DEFAULT ""  AFTER `s_provider`', DB_TABLE_PREFIX));
        $dbCommand->query(sprintf('UPDATE `%st_social_connect` set `s_picture_profile` = "" WHERE 1=1', DB_TABLE_PREFIX));
    }
    osc_set_preference('version', SC_VERSION, 'socialconnect');
}
sc_update();

function sc_admin_menu() {
    osc_add_admin_menu_page('Social Connect', osc_route_admin_url('sc-conf'), 'plugin_sc_conf', 'administrator');
    osc_add_admin_submenu_page('plugin_sc_conf', __('Settings', 'socialconnect'), osc_route_admin_url('sc-conf'), 'sc_conf', 'administrator');
    osc_add_admin_submenu_page('plugin_sc_conf', __('Help', 'socialconnect'), osc_route_admin_url('sc-help'), 'sc_help', 'administrator');
}
osc_add_hook('admin_menu_init', 'sc_admin_menu');

function sc_user_menu($options) {
    $options[] = array('name' => __('Social accounts', 'socialconnect'), 'url' => osc_route_url('sc-manage'), 'class' => 'opt_socialconnect');
    return $options;
}
osc_add_hook('user_menu_filter', 'sc_user_menu');

function sc_user_deleted($id) {
    SCModel::newInstance()->delete(array('fk_i_user_id' => $id));
}
osc_add_hook('after_delete_user', 'sc_user_deleted');

function sc_style_admin_menu() {
    ?>
    <style>
        #plugin_sc_conf .ico {
            background-image: url('<?php echo osc_base_url(); ?>oc-content/plugins/socialconnect/img/split.png') !important;
            background-position:0px -48px;
        }

        .current #plugin_sc_conf .ico{
            background-position:0px -48px !important;
        }
        #plugin_sc_conf .ico:hover {
            background-position:0px 0px !important;
        }
        body.compact #plugin_sc_conf .ico{
            background-position:-48px 0px;
        }
        body.compact .current #plugin_sc_conf .ico{

            background-position:-48px -48px !important;
        }
        body.compact #plugin_sc_conf .ico:hover{
            background-position:-48px 0px !important;
        }
    </style>
    <?php
}
osc_add_hook('admin_footer', 'sc_style_admin_menu');

function sc_buttons() {
    $providers = SCClass::providers();
    if(!osc_is_web_user_logged_in()) {
        echo '<div class="social-box">';
        echo '<div>';
        echo '<div style="text-align: center;">';
        foreach($providers as $key => $provider) {
            if(osc_get_preference('enabled_' . $key, 'socialconnect')==1
            && osc_get_preference($key . '_app_id', 'socialconnect')!=""
            && osc_get_preference($key . '_app_secret', 'socialconnect')!="") {
                sc_button($key, $provider);
            }
        }
        echo '<div style="clear:both;"></div>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
    }
}
osc_add_hook('sc_buttons', 'sc_buttons');

function sc_button($key, $provider = null, $http_referer = null) {
    $href="javascript:void(0)";
    if($provider!=null) {
        $params = array('provider' => $provider);
        if ($http_referer != null) {
            $code = osc_genRandomPassword();
            Session::newInstance()->_set('sc_rd_' . $code, $http_referer);
            $params['rd'] = $code;
        }
        $href = osc_route_url('sc-login', $params) ;
    }

    $fixed_width = osc_get_preference('fixed_width', 'socialconnect')==1;
    $class = ($fixed_width || OC_ADMIN || Params::getParam('route')=='sc-manage') ? 'socialconnect-button-fixedwidth': '';
    switch($key) {
        case 'fb':
            echo '<a class="socialconnect-button btn btn-block btn-social btn-facebook '.$class.'" href="' . $href . '"><span class="fa fa-facebook"></span> ' . __( 'Sign in with Facebook', 'socialconnect' ) . '</a>';
            break;
        case 'google':
            echo '<a class="socialconnect-button btn btn-block btn-social btn-google '.$class.'" href="' . $href . '"><span class="fa fa-google"></span> ' . __( 'Sign in with Google', 'socialconnect' ) . '</a>';
            break;
        case 'twitter':
            echo '<a class="socialconnect-button btn btn-block btn-social btn-twitter '.$class.'" href="' . $href . '"><span class="fa fa-twitter"></span> ' . __( 'Sign in with Twitter', 'socialconnect' ) . '</a>';
            break;
        case 'linkedin':
            echo '<a class="socialconnect-button btn btn-block btn-social btn-linkedin '.$class.'" href="' . $href . '"><span class="fa fa-linkedin"></span> ' . __( 'Sign in with Linkedin', 'socialconnect' ) . '</a>';
            break;
        case 'instagram':
            echo '<a class="socialconnect-button btn btn-block btn-social btn-instagram '.$class.'" href="' . $href . '"><span class="fa fa-instagram"></span> ' . __( 'Sign in with Instagram', 'socialconnect' ) . '</a>';
            break;
        case 'live':
            echo '<a class="socialconnect-button btn btn-block btn-social btn-microsoft '.$class.'" href="' . $href . '"><span class="fa fa-windows"></span> ' . __( 'Sign in with Microsoft', 'socialconnect' ) . '</a>';
            break;
        default:
            break;
    }
}


function sc_profile_picture($userId, $provider=null, $width = "42") {
    $user_info = SCModel::newInstance()->findByUserIdProvider(osc_logged_user_id(), $provider);
    if(!is_null($user_info['s_picture_profile']) &&  $user_info['s_picture_profile']!="") {
        return '<img width="' . $width . '" src="' . $user_info['s_picture_profile'] . '"/>';
    }
    return "";
}

osc_add_hook('before_html', 'sc_no_email_warning');
function sc_no_email_warning()
{
    if (osc_is_web_user_logged_in()) {
        $user_id = osc_logged_user_id();
        $accounts_linked = SCModel::newInstance()->findByUserId($user_id);
        $current_email   = osc_logged_user_email();
        foreach($accounts_linked as $account) {
            $e = $account['i_provider_id'].'@'.$account['s_provider'].'.com';
            if($e==$current_email) {
                $fm = sprintf(__('No email provided, <b>you need to add a valid email so users can contact you</b>. <a href="%s">Edit profile</a>', 'socialconnect'), osc_user_profile_url());
                osc_add_flash_warning_message($fm);
                break;
            }
        }
    }
}

function sc_admin_assets() {

    switch (Params::getParam('route')) {
        case 'sc-conf':
        case 'sc-stats':
        case 'sc-help':
            osc_enqueue_style('font-awesome', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css');
            osc_enqueue_style('socialconnect', osc_base_url() . 'oc-content/plugins/socialconnect/assets/style.css');
            break;
        default:
            break;
    }
}
osc_add_hook('admin_init', 'sc_admin_assets');

function sc_admin_page_header() {

    switch (Params::getParam('route')) {
        case 'sc-conf':
        case 'sc-stats':
        case 'sc-help':
            osc_enqueue_style('font-awesome', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css');
            osc_enqueue_style('socialconnect', osc_base_url() . 'oc-content/plugins/socialconnect/assets/style.css');
            osc_remove_hook('admin_page_header', 'customPageHeader');
            osc_add_hook('admin_page_header',  '_sc_admin_page_header' );
            break;
        default:
            break;
    }
}
osc_add_hook('admin_header', 'sc_admin_page_header');

function _sc_admin_page_header() {
    if (Params::getParam('route')=='sc-conf') { ?>
        <h1><?php _e('Social connect settings', 'socialconnect'); ?></h1>
    <?php }
    if (Params::getParam('route')=='sc-stats') { ?>
        <h1><?php _e('Social connect statistics', 'socialconnect'); ?></h1>
    <?php }
    if (Params::getParam('route')=='sc-help') { ?>
        <h1><?php _e('Social connect help', 'socialconnect'); ?></h1>
    <?php }
    @include(dirname(__FILE__) . '/admin/header.php');
}


function sc_body_class($array) {
    switch (Params::getParam('route')) {
        case 'sc-conf':
        case 'sc-stats':
        case 'sc-help':
            $array[] = 'market';
            break;
        default:
            break;
    }
    return $array;
}
osc_add_filter('admin_body_class','sc_body_class');

function sc_load_css() {
    osc_enqueue_style('font-awesome', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css');
    osc_enqueue_style('socialconnect', osc_base_url() . 'oc-content/plugins/socialconnect/assets/style.css');
}
osc_add_hook('init', 'sc_load_css');

osc_add_route('sc-conf', 'socialconnect/admin/conf', 'socialconnect/admin/conf', SC_PLUGIN_FOLDER . 'admin/conf.php');
osc_add_route('sc-stats', 'socialconnect/admin/stats', 'socialconnect/admin/stats', SC_PLUGIN_FOLDER . 'admin/stats.php');
osc_add_route('sc-help', 'socialconnect/admin/help', 'socialconnect/admin/help', SC_PLUGIN_FOLDER . 'admin/help.php');
osc_add_route('sc-login', 'socialconnect/login/(.+)', 'socialconnect/login/{provider}', SC_PLUGIN_FOLDER . 'user/callback.php');
osc_add_route('sc-endpoint', 'socialconnect/connect', 'socialconnect/connect', SC_PLUGIN_FOLDER . 'user/endpoint.php');
osc_add_route('sc-manage', 'socialconnect/manage', 'socialconnect/manage', SC_PLUGIN_FOLDER . 'user/manage.php', true);

osc_add_route('sc-live', 'socialconnect/live', 'socialconnect/live', SC_PLUGIN_FOLDER . 'empty.php');
osc_add_hook('init', function() {
    if (Params::getParam('route') == 'sc-live') {
        require_once(SC_PATH . 'live.php');
        die();
    }
});

function sc_configure() {
    osc_redirect_to( osc_route_admin_url('sc-conf') );
}

osc_register_plugin(osc_plugin_path(__FILE__), 'sc_install');
osc_add_hook(osc_plugin_path(__FILE__) . "_uninstall", 'sc_uninstall');
osc_add_hook(osc_plugin_path(__FILE__) . "_configure", 'sc_configure');