<?php if (!defined('ABS_PATH')) { exit('ABS_PATH is not loaded. Direct access is not allowed.'); };

class SCClass {

    private static $auth = null;

    private static $instance;

    public static function newInstance() {
        if( !self::$instance instanceof self ) {
            self::$instance = new self ;
        }
        return self::$instance ;
    }

    public static function provider_id($p) {
        $array = array(
             'Facebook' => 'fb',
             'Google' => 'google',
             'Twitter' => 'twitter',
             'LinkedIn' => 'linkedin',
             'Instagram' => 'instagram',
             'Live' => 'live',
        );
        return isset($array[$p]) ? $array[$p] : '';
    }
    public static function providers() {
        $sorder = osc_get_preference('order_providers', 'socialconnect');
        if($sorder=='') {
            // default order
            return array(
                'fb' => 'Facebook',
                'google' => 'Google',
                'twitter' => 'Twitter',
                'linkedin' => 'LinkedIn',
                'instagram' => 'Instagram',
                'live' => 'Live',
            );
        }

        $providers = array();
        $aOrder = explode(',', $sorder);
        foreach($aOrder as $p) {
            switch ($p) {
                case 'fb':
                    $providers['fb'] = 'Facebook';
                    break;
                case 'google':
                    $providers['google'] = 'Google';
                    break;
                case 'twitter':
                    $providers['twitter'] = 'Twitter';
                    break;
                case 'instagram':
                    $providers['instagram'] = 'Instagram';
                    break;
                case 'linkedin':
                    $providers['linkedin'] = 'Linkedin';
                    break;
                case 'live':
                    $providers['live'] = 'Live';
                    break;
            }
        }
        return $providers;
    }

    public static function _init() {
        $filename = osc_content_path() . '/socialconnect.log';
        $debug = osc_get_preference('debug', 'socialconnect');
        if($debug==1) {
            if (!file_exists($filename)) {
                touch($filename); // Create blank file
                chmod($filename,0666);
                if (!file_exists($filename)) {
                    $debug = 0;
                }
            }
        }
        $config = array(
            "base_url" => osc_route_url('sc-endpoint'),
            "providers" => array(
                'Facebook' => array(
                    "enabled" => osc_get_preference('enabled_fb', 'socialconnect'),
                    "keys" => array(
                        "id" => osc_get_preference('fb_app_id', 'socialconnect'),
                        "secret" => osc_get_preference('fb_app_secret', 'socialconnect')
                    ),
                    "scope"   => "email"
                ),
                'Google' => array(
                    "enabled" => osc_get_preference('enabled_google', 'socialconnect'),
                    "keys" => array(
                        "id" => osc_get_preference('google_app_id', 'socialconnect'),
                        "secret" => osc_get_preference('google_app_secret', 'socialconnect')
                    ),
                    "scope" => "profile email"
                ),
                'Twitter' => array(
                    "enabled" => osc_get_preference('enabled_twitter', 'socialconnect'),
                    "keys" => array(
                        "key" => osc_get_preference('twitter_app_id', 'socialconnect'),
                        "secret" => osc_get_preference('twitter_app_secret', 'socialconnect')
                    )
                ),
                'LinkedIn' => array(
                    "enabled" => osc_get_preference('enabled_linkedin', 'socialconnect'),
                    "keys" => array(
                        "key" => osc_get_preference('linkedin_app_id', 'socialconnect'),
                        "secret" => osc_get_preference('linkedin_app_secret', 'socialconnect')
                    )
                ),
                'Instagram' => array(
                    "enabled" => osc_get_preference('enabled_instagram', 'socialconnect'),
                    "keys" => array(
                        "id" => osc_get_preference('instagram_app_id', 'socialconnect'),
                        "secret" => osc_get_preference('instagram_app_secret', 'socialconnect')
                    )
                ),
                'Live' => array(
                    "enabled" => osc_get_preference('enabled_live', 'socialconnect'),
                    "keys" => array(
                        "id" => osc_get_preference('live_app_id', 'socialconnect'),
                        "secret" => osc_get_preference('live_app_secret', 'socialconnect')
                    )
                ),
            ),
            "debug_mode" => $debug==1?true:false,
            "debug_file" => $filename
        );

        self::$auth = new Hybrid_Auth( $config );
    }

    public function login($provider){
        try {
            if(self::$auth==null) {
                self::_init();
            }
            $valid_provider = false;
            $adapter        = self::$auth->authenticate($provider);
            $user_provider  = $adapter->getUserProfile();
            $aProviders     = $this->providers();
            foreach($aProviders as $p) {
                if($p==$provider){
                    $valid_provider = true;
                    break;
                }
            }
            if($valid_provider) {
                return $this->_login($user_provider, $provider);
            } else {
                osc_add_flash_error_message(__('Social provider not allowed', 'socialconnect'));
                return false;
            }
        }
        catch( Exception $e ) {
            osc_add_flash_error_message(__('Something went wrong', 'socialconnect'));

            // --- force logout if any error occurred ---
            if(self::$auth==null) {
                self::_init();
            }
            $adapter        = self::$auth->authenticate($provider);
            $adapter->logout();
            // ---------------------------------------
            return false;
        }
        return false;
    }

    private function _login($user, $provider) {

        $email = "";
        if(isset($user->email) && trim($user->email)!="") {
            $email = trim($user->email);
        } else if(isset($user->emailVerified) && trim($user->emailVerified)!="") {
            $email = trim($user->emailVerified);
        }

        if(!isset($user->identifier)) {
            osc_add_flash_error_message(__('Something went wrong, not a valid user', 'socialconnect'));
            return false;
        }

        $id = $user->identifier;

        $name = "";
        if($name=="" && ($user->firstName!='' || $user->lastName!='')) {
            $name = $user->firstName . " " . $user->lastName;
        }
        if($name=="" && $user->displayName!="") {
            $name = $user->displayName;
        }
        if($name=="") {
            $name = 'user name';
        }

        $s_picture_profile = $user->photoURL;

        require_once LIB_PATH . 'osclass/UserActions.php';

        // USER IS ALREADY LOGGED
        if(osc_is_web_user_logged_in()) {
            // LINK ACCOUNT OR SOMETHING?
            if(SCModel::newInstance()->linked(osc_logged_user_id(), $provider)) {
                // LINKED, DO NOTHING
            } else {
                // NOT LINKED, => LINK ACCOUNT
                $sc_user = SCModel::newInstance()->find($id, $provider);
                if(isset($sc_user['fk_i_user_id'])) {
                    // EXIST
                    if($sc_user['fk_i_user_id']!=osc_logged_user_id()) {
                        // ACCOUNT LINKED TO OTHER USER!
                        osc_add_flash_error_message(__('Account linked to another user user', 'socialconnect'));
                        return false;
                    } else {
                        // ALREADY LINKED TO THE USER (THIS SHOULD NOT HAPPEN), DO NOTHING (ALREADY LOGGED)
                    }
                } else {
                    SCModel::newInstance()->insert(array(
                        'fk_i_user_id' => osc_logged_user_id(),
                        'i_provider_id' => $id,
                        's_provider' => $provider,
                        's_picture_profile' => $s_picture_profile
                    ));
                    return true;
                }
            }
        } else {

            $sc_user = SCModel::newInstance()->find($id, $provider);
            // USER ACCOUNT EXIST
            if(isset($sc_user['fk_i_user_id'])) {
                $userActions = new UserActions(true);
                $success = $userActions->bootstrap_login($sc_user['fk_i_user_id']);
                return $success==3;
            } else {
                // NOT LOGGED AND NOT EXISTS, AUTO-REGISTER USER?
                if(osc_get_preference('autoregister', 'socialconnect')==1) {
                    if ($email=="") {
                        $email = $id.'@'.$provider.'.com';
                    }

                    $random_password = osc_genRandomPassword(40);
                    Params::setParam('s_password', $random_password);
                    Params::setParam('s_password2', $random_password);
                    Params::setParam('s_name', $name);
                    Params::setParam('s_email', $email);

                    if (!osc_users_enabled()) {
                        osc_add_flash_error_message(_m('Users are not enabled', 'socialconnect'));
                        return false;
                    }

                    osc_run_hook('before_user_register');

                    $banned = osc_is_banned(Params::getParam('s_email'));
                    if ($banned == 1) {
                        osc_add_flash_error_message(_m('Your current email is not allowed', 'socialconnect'));
                        return false;
                    } else if ($banned == 2) {
                        osc_add_flash_error_message(_m('Your current IP is not allowed', 'socialconnect'));
                        return false;
                    }

                    $userActions = new UserActions(true); // (true), be sure recaptcha is not blocking here
                    $success = $userActions->add();
                    if ($success == 1 || $success==2) {
                        $osc_user = User::newInstance()->findByEmail($email);

                        if(isset($osc_user['pk_i_id'])) {
                            $result = SCModel::newInstance()->insert(array(
                                'fk_i_user_id' => $osc_user['pk_i_id'],
                                'i_provider_id' => $id,
                                's_provider' => $provider,
                                's_picture_profile' => $s_picture_profile
                            ));

                            if($result!==false) {
                                osc_add_flash_ok_message(_m('Your account has been created successfully', 'socialconnect') );

                                $userActions = new UserActions(true);
                                $success_login = $userActions->bootstrap_login($osc_user['pk_i_id']);
                                return $success_login == 3;
                            } else {
                                osc_add_flash_error_message(__('Error linking your account.', 'socialconnect'));
                                return false;
                            }
                        } else {
                            osc_add_flash_error_message(__('Error linking your account..', 'socialconnect'));
                            return false;
                        }
                    } else {
                        osc_add_flash_error_message($success);
                        return false;
                    }
                } else {
                    osc_add_flash_error_message(__('Error, account not linked to any user', 'socialconnect'));
                    return false;
                }
            }
        }
        return false;
    }

    public function endpoint() {
        try {
            if(self::$auth==null) {
                self::_init();
            }
            Hybrid_Endpoint::process();
        }
        catch( Exception $e ) {
            var_dump($e);
        }
    }
}
