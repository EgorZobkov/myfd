<?php
/*
Plugin Name: HybridAuth
Plugin URI: https://www.doska-ru.co.uk/
Description: HybridAuth A PHP Library for authentication through Facebook, Twitter, Google
Version: mod 1.1.6 
Author: 
Plugin update URI: hybridauth
*/

require_once osc_plugins_path() . osc_plugin_folder(__FILE__) . 'HybridAuthClass.php';
require_once osc_plugins_path() . osc_plugin_folder(__FILE__) . 'ModelAUT.php';
require_once osc_plugins_path() . osc_plugin_folder(__FILE__) . 'functions.php';


/* HybridAuth Install */
function HybridAuth_install() {
	osc_set_preference('GoogleEnabled',0,'HybridAuth','BOOLEAN');
	osc_set_preference('GoogleId','','HybridAuth');
	osc_set_preference('GoogleSecrect','','HybridAuth');
	
	osc_set_preference('FacebookEnabled',0,'HybridAuth','BOOLEAN');
	osc_set_preference('FacebookId','','HybridAuth');
	osc_set_preference('FacebookSecrect','','HybridAuth');
	
	osc_set_preference('TwitterEnabled',0,'HybridAuth','BOOLEAN');
	osc_set_preference('TwitterId','','HybridAuth');
	osc_set_preference('TwitterSecrect','','HybridAuth');
	
	osc_set_preference('VkontakteEnabled',0,'HybridAuth','BOOLEAN');
	osc_set_preference('VkontakteId','','HybridAuth');
	osc_set_preference('VkontakteSecrect','','HybridAuth');
	
	//mod sz OK
	osc_set_preference('OdnoklassnikiEnabled',0,'HybridAuth','BOOLEAN');
	osc_set_preference('OdnoklassnikiId','','HybridAuth');
	osc_set_preference('OdnoklassnikiSecrect','','HybridAuth');
	osc_set_preference('OdnoklassnikiPublic','','HybridAuth');
	
	
    osc_set_preference('DraugiemEnabled',0,'HybridAuth','BOOLEAN');
	osc_set_preference('DraugiemId','','HybridAuth');
	osc_set_preference('DraugiemSecrect','','HybridAuth');
	
	osc_set_preference('MailruEnabled',0,'HybridAuth','BOOLEAN');
	osc_set_preference('MailruId','','HybridAuth');
	osc_set_preference('MailruSecrect','','HybridAuth');
	
	
	osc_set_preference('YandexEnabled',0,'HybridAuth','BOOLEAN');
	osc_set_preference('YandexId','','HybridAuth');
	osc_set_preference('YandexSecrect','','HybridAuth');

	osc_set_preference('InstagramEnabled',0,'HybridAuth','BOOLEAN');
	osc_set_preference('InstagramId','','HybridAuth');
	osc_set_preference('InstagramSecrect','','HybridAuth');
	
	
	
	//mod sz OK
	
	osc_set_preference('HybridAuthDebug','1','HybridAuth','BOOLEAN');
	osc_set_preference('HybridRedirect','1','HybridAuth','BOOLEAN');
}
osc_register_plugin(osc_plugin_path(__FILE__), 'HybridAuth_install') ;

/* HybridAuth Uninstall */
function HybridAuth_uninstall() {
	Preference::newInstance()->delete(array('s_section' => 'HybridAuth'));
}
osc_add_hook(osc_plugin_path(__FILE__) . '_uninstall', 'HybridAuth_uninstall') ;

function HybridAuth_settings(){
	if(Params::getParam('action_specific') =='HybridAuth' ){
		$GoogleId = Params::getParam('GoogleId');
		Preference::newInstance()->update(array("s_value" => $GoogleId),array("s_section" => "HybridAuth", "s_name" => "GoogleId"));
		$GoogleSecrect = Params::getParam('GoogleSecrect');
		Preference::newInstance()->update(array("s_value" => $GoogleSecrect),array("s_section" => "HybridAuth", "s_name" => "GoogleSecrect"));
		$GoogleEnabled = Params::getParam('GoogleEnabled');
		Preference::newInstance()->update(array("s_value" => $GoogleEnabled),array("s_section" => "HybridAuth", "s_name" => "GoogleEnabled"));
		
		$FacebookId = Params::getParam('FacebookId');
		Preference::newInstance()->update(array("s_value" => $FacebookId),array("s_section" => "HybridAuth", "s_name" => "FacebookId"));
		$FacebookSecrect = Params::getParam('FacebookSecrect');
		Preference::newInstance()->update(array("s_value" => $FacebookSecrect),array("s_section" => "HybridAuth", "s_name" => "FacebookSecrect"));
		$FacebookEnabled = Params::getParam('FacebookEnabled');
		Preference::newInstance()->update(array("s_value" => $FacebookEnabled),array("s_section" => "HybridAuth", "s_name" => "FacebookEnabled"));
		
		$TwitterId = Params::getParam('TwitterId');
		Preference::newInstance()->update(array("s_value" => $TwitterId),array("s_section" => "HybridAuth", "s_name" => "TwitterId"));
		$TwitterSecrect = Params::getParam('TwitterSecrect');
		Preference::newInstance()->update(array("s_value" => $TwitterSecrect),array("s_section" => "HybridAuth", "s_name" => "TwitterSecrect"));
		$TwitterEnabled = Params::getParam('TwitterEnabled');
		Preference::newInstance()->update(array("s_value" => $TwitterEnabled),array("s_section" => "HybridAuth", "s_name" => "TwitterEnabled"));
		
		$VkontakteId = Params::getParam('VkontakteId');
		Preference::newInstance()->update(array("s_value" => $VkontakteId),array("s_section" => "HybridAuth", "s_name" => "VkontakteId"));
		$VkontakteSecrect = Params::getParam('VkontakteSecrect');
		Preference::newInstance()->update(array("s_value" => $VkontakteSecrect),array("s_section" => "HybridAuth", "s_name" => "VkontakteSecrect"));
		$VkontakteEnabled = Params::getParam('VkontakteEnabled');
		Preference::newInstance()->update(array("s_value" => $VkontakteEnabled),array("s_section" => "HybridAuth", "s_name" => "VkontakteEnabled"));
		
		//mod sz OK
		$OdnoklassnikiId = Params::getParam('OdnoklassnikiId');
		Preference::newInstance()->update(array("s_value" => $OdnoklassnikiId),array("s_section" => "HybridAuth", "s_name" => "OdnoklassnikiId"));
		$OdnoklassnikiSecrect = Params::getParam('OdnoklassnikiSecrect');
		Preference::newInstance()->update(array("s_value" => $OdnoklassnikiSecrect),array("s_section" => "HybridAuth", "s_name" => "OdnoklassnikiSecrect"));
		
		$OdnoklassnikiPublic = Params::getParam('OdnoklassnikiPublic');
		Preference::newInstance()->update(array("s_value" => $OdnoklassnikiPublic),array("s_section" => "HybridAuth", "s_name" => "OdnoklassnikiPublic"));
		
		$OdnoklassnikiEnabled = Params::getParam('OdnoklassnikiEnabled');
		Preference::newInstance()->update(array("s_value" => $OdnoklassnikiEnabled),array("s_section" => "HybridAuth", "s_name" => "OdnoklassnikiEnabled"));
		//mod sz OK
		
		//mod Draugiem sz OK
		$DraugiemId = Params::getParam('DraugiemId');
		Preference::newInstance()->update(array("s_value" => $DraugiemId),array("s_section" => "HybridAuth", "s_name" => "DraugiemId"));
		$DraugiemSecrect = Params::getParam('DraugiemSecrect');
		Preference::newInstance()->update(array("s_value" => $DraugiemSecrect),array("s_section" => "HybridAuth", "s_name" => "DraugiemSecrect"));
		$DraugiemEnabled = Params::getParam('DraugiemEnabled');
		Preference::newInstance()->update(array("s_value" => $DraugiemEnabled),array("s_section" => "HybridAuth", "s_name" => "DraugiemEnabled"));
		//mod Draugiem sz OK
		
		//mod Mailru sz
		$MailruId = Params::getParam('MailruId');
		Preference::newInstance()->update(array("s_value" => $MailruId),array("s_section" => "HybridAuth", "s_name" => "MailruId"));
		$MailruSecrect = Params::getParam('MailruSecrect');
		Preference::newInstance()->update(array("s_value" => $MailruSecrect),array("s_section" => "HybridAuth", "s_name" => "MailruSecrect"));
		$MailruEnabled = Params::getParam('MailruEnabled');
		Preference::newInstance()->update(array("s_value" => $MailruEnabled),array("s_section" => "HybridAuth", "s_name" => "MailruEnabled"));
		//mod Mailru sz
		
		//mod sz yandex
		$YandexId = Params::getParam('YandexId');
		Preference::newInstance()->update(array("s_value" => $YandexId),array("s_section" => "HybridAuth", "s_name" => "YandexId"));
		$YandexSecrect = Params::getParam('YandexSecrect');
		Preference::newInstance()->update(array("s_value" => $YandexSecrect),array("s_section" => "HybridAuth", "s_name" => "YandexSecrect"));
		$YandexEnabled = Params::getParam('YandexEnabled');
		Preference::newInstance()->update(array("s_value" => $YandexEnabled),array("s_section" => "HybridAuth", "s_name" => "YandexEnabled"));
		//mod sz yandex


		//mod sz yandex
		$InstagramId = Params::getParam('InstagramId');
		Preference::newInstance()->update(array("s_value" => $InstagramId),array("s_section" => "HybridAuth", "s_name" => "InstagramId"));
		$InstagramSecrect = Params::getParam('InstagramSecrect');
		Preference::newInstance()->update(array("s_value" => $InstagramSecrect),array("s_section" => "HybridAuth", "s_name" => "InstagramSecrect"));
		$InstagramEnabled = Params::getParam('InstagramEnabled');
		Preference::newInstance()->update(array("s_value" => $InstagramEnabled),array("s_section" => "HybridAuth", "s_name" => "InstagramEnabled"));
		//mod sz yandex

		
		
		
		$HybridAuthDebug = Params::getParam('HybridAuthDebug');
		Preference::newInstance()->update(array("s_value" => $HybridAuthDebug),array("s_section" => "HybridAuth", "s_name" => "HybridAuthDebug"));
		
		$HybridRedirect = Params::getParam('HybridRedirect');
		Preference::newInstance()->update(array("s_value" => $HybridRedirect),array("s_section" => "HybridAuth", "s_name" => "HybridRedirect"));
		
		
		osc_add_flash_ok_message(__('HybridAuth updated correctly', 'HybridAuth'), 'admin');
		osc_redirect_to(osc_admin_render_plugin_url('HybridAuth/HybridAuthSettings.php'));
	}
}
osc_add_hook('init_admin', 'HybridAuth_settings');

/* HybridAuth Init  */
function HybridAuth_init(){
	$providers = array('Google','Facebook','Twitter','Vkontakte','Odnoklassniki','Draugiem','Mailru','Yandex','Instagram');
	$provider = Params::getParam('login');
	if (in_array($provider, $providers)) {
		HybridAuthClass::newInstance()->loginwith($provider);
	}
	if(Params::getParam('endpoint') == 'true'){
		HybridAuthClass::newInstance()->endpoint();
	}
}
osc_add_hook( 'before_html', 'HybridAuth_init' ) ;
 
/* HybridAuth Logout */
function HybridAuth_logout(){
	HybridAuthClass::newInstance()->logout();
}

/* HybridAuth Login url */
function HybridAuth_Login(){
	require_once(osc_plugins_path() . 'HybridAuth/login.php');
}

osc_add_hook('logout','HybridAuth_logout');

/* Add CSS */
function HybridAuth_CSS() {
	?>
	<link href="<?php echo osc_plugin_url('HybridAuth/css/style.css'). 'style.css'; ?>" rel="stylesheet" type="text/css" />
	<?php
}
osc_add_hook('header', 'HybridAuth_CSS', 10);

/* Admin Menu */
function HybridAuth_Admin() {
	echo '<h3><a href="#">HybridAuth</a></h3>
	<ul>
		<li><a href="'.osc_admin_render_plugin_url('HybridAuth/HybridAuthSettings.php').'">&raquo; ' . __('HybridAuth', 'HybridAuth') . '</a></li>
		<li><a href="'.osc_admin_render_plugin_url('HybridAuth/help.php').'">&raquo; ' . __('Help / FAQ', 'HybridAuth') . '</a></li>
	</ul>';
}
osc_add_hook('admin_menu', 'HybridAuth_Admin');

/* Configure */
function HybridAuth_Configure() {
	osc_admin_render_plugin('HybridAuth/HybridAuthSettings.php');
}
osc_add_hook(osc_plugin_path(__FILE__)."_configure", 'HybridAuth_Configure');

?>