<?php

/*
Plugin Name: HybridAuth
Plugin URI: http://www.osclass.org/
Description: HybridAuth A PHP Library for authentication through Facebook, Twitter, Google
Version: 1.0.0
Author: RajaSekar
Author URI: http://rajasekar.co.in/
Plugin update URI: hybridauth
*/ 
class HybridAuthClass{
	

	public $hybridauth = null;
    public $adapter = null;
	public $provider = null;
    private static $instance ;
	
    public static function newInstance() {
        if( !self::$instance instanceof self ) {
            self::$instance = new self ;
        }
        return self::$instance ;
    }
    private function init(){
	   require_once(osc_plugins_path() . 'HybridAuth/hybridauth-2.10.0/hybridauth/Hybrid/Auth.php');
	   echo osc_plugins_path();
		
       $config = array(
            "base_url" => osc_base_url(true).'?endpoint=true',
            "providers" => array(
				"Google" => array(
					"enabled" => osc_get_preference('GoogleEnabled', 'HybridAuth'),
					"keys" => array("id" => osc_get_preference('GoogleId', 'HybridAuth'),"secret" => osc_get_preference('GoogleSecrect', 'HybridAuth'))
				),
				'Facebook' => array(
					"enabled" => osc_get_preference('FacebookEnabled', 'HybridAuth'),
					"keys" => array("id" => osc_get_preference('FacebookId', 'HybridAuth'),"secret" => osc_get_preference('FacebookSecrect', 'HybridAuth'))
				),
				'Twitter' => array(
					"enabled" => osc_get_preference('TwitterEnabled', 'HybridAuth'),
					"keys" => array("key" => osc_get_preference('TwitterId', 'HybridAuth'),"secret" => osc_get_preference('TwitterSecrect', 'HybridAuth'))
				),
				'Vkontakte' => array(
					"enabled" => osc_get_preference('VkontakteEnabled', 'HybridAuth'),
					"keys" => array("id" => osc_get_preference('VkontakteId', 'HybridAuth'),"secret" => osc_get_preference('VkontakteSecrect', 'HybridAuth'))
				),
				'Odnoklassniki' => array(
					"enabled" => osc_get_preference('OdnoklassnikiEnabled', 'HybridAuth'),
					"keys" => array("id" => osc_get_preference('OdnoklassnikiId', 'HybridAuth'),"key" => osc_get_preference('OdnoklassnikiSecrect', 'HybridAuth'),"secret" => osc_get_preference('OdnoklassnikiPublic', 'HybridAuth'))
				),
				'Draugiem' => array(
					"enabled" => osc_get_preference('DraugiemEnabled', 'HybridAuth'),
					"keys" => array("id" => osc_get_preference('DraugiemId', 'HybridAuth'),"secret" => osc_get_preference('DraugiemSecrect', 'HybridAuth'))
				),
				'Mailru' => array(
					"enabled" => osc_get_preference('MailruEnabled', 'HybridAuth'),
					"keys" => array("id" => osc_get_preference('MailruId', 'HybridAuth'),"secret" => osc_get_preference('MailruSecrect', 'HybridAuth'))
						),
				'Instagram' => array(
					"enabled" => osc_get_preference('InstagramEnabled', 'HybridAuth'),
					"keys" => array("id" => osc_get_preference('InstagramId', 'HybridAuth'),"secret" => osc_get_preference('InstagramSecrect', 'HybridAuth'))
						),

				'Yandex' => array(
					"enabled" => osc_get_preference('YandexEnabled', 'HybridAuth'),
					"keys" => array("id" => osc_get_preference('YandexId', 'HybridAuth'),"secret" => osc_get_preference('YandexSecrect', 'HybridAuth'))
				)
			),
            "debug_mode" => osc_get_preference('HybridAuthDebug', 'HybridAuth'),
			"debug_file" => osc_plugins_path() . '/HybridAuth/log'
			
        );
        $this->hybridauth = new Hybrid_Auth( $config );
    }

// GET PROFILE PICTURE
public function getProfilePicture($user_id) {
  $this->dao->select();
  $this->dao->from($this->getTable_profile_picture());

  $this->dao->where('user_id', $user_id);

  $result = $this->dao->get();
  
  if($result) {
    return $result->row();
  }

  return false;
}


	public function loginwith($provider){
		try{
			if( !$this->hybridauth ) $this->init();
			$this->provider = $provider;
			$this->adapter = $this->hybridauth->authenticate($this->provider);
			$user_profile = (array)$this->adapter->getUserProfile();

 			//break; 

			$manager = User::newInstance();
			$oscUser = $manager->findByEmail($user_profile['email']);
			
			//UPDATE Profile picture modf sz 2019
			ModelAUT::newInstance()->updateProfilePicture($oscUser['pk_i_id'], $user_profile['photoURL']);
		
			if( count($oscUser) > 0 ) {
			     
				$manager->update( array('b_active' => '1'),array('pk_i_id' => $oscUser['pk_i_id']) ) ;
				osc_add_flash_ok_message( __( "Вы успешно авторизовались", 'HybridAuth' ) ) ;
				require_once osc_lib_path() . 'osclass/UserActions.php';
				$uActions = new UserActions( false );
				$logged = $uActions->bootstrap_login( $oscUser['pk_i_id'] );
			} else {
				$this->register_user($user_profile) ;
			}
		}
		catch( Exception $e ){
			switch( $e->getCode() ){
				case 0 : 
					osc_add_flash_error_message( __( "Неизвестная ошибка.", 'HybridAuth' ) ) ;
					break;
				case 1 :
					osc_add_flash_error_message( __( "Hybriauth ошибка конфигурации.", 'HybridAuth' ) ) ;
					break;
				case 2 :
					osc_add_flash_error_message( __( "Провайдер не правильно настроен.", 'HybridAuth' ) ) ;
					break;
				case 3 :
					osc_add_flash_error_message( __( "Неизвестный или отключен провайдером.", 'HybridAuth' ) ) ;
					break;
				case 4 :
					osc_add_flash_error_message( __( "Отсутствует учетные данные приложения провайдера.", 'HybridAuth' ) ) ;
					break;
				case 5 : 
					osc_add_flash_error_message( __( "Ошибка аутентификации. Пользователь отменил проверку подлинности или поставщик отклонил соединение.", 'HybridAuth' ) ) ;
					break;
				case 6 : 
					osc_add_flash_error_message( __( "Запрос Профиля пользователя не удался. Скорее всего, пользователь не подключен к провайдеру и он должен аутентифицироваться снова.", 'HybridAuth' ) ) ;
				//	$twitter->logout();
					break;
				case 7 : 
					osc_add_flash_error_message( __( "Пользователь не подключен к провайдеру.", 'HybridAuth' ) ) ;
				//	$twitter->logout();
					break;
				case 8 : 
					osc_add_flash_error_message( __( "Провайдер не поддерживает эту функцию.", 'HybridAuth' ) ) ;
					break;
			}
		}
		
	redirect_url();
	    
}


	
	public function endpoint(){
		require_once(osc_plugins_path() . 'HybridAuth/hybridauth-2.10.0/hybridauth/Hybrid/Endpoint.php');
		if( !$this->hybridauth ) $this->init();
        Hybrid_Endpoint::process();
    }
	
	public function logout(){
		if( !$this->hybridauth ) $this->init();
		Hybrid_Auth::logoutAllProviders();
	}
	
    private function register_user($user_profile){
        $manager = User::newInstance();
        $input['s_name']      = $user_profile['displayName'];
        $input['s_username'] = $user_profile['displayName'];
		$input['u_vkID'] = $user_profile['displayName'];
        $input['s_email']     = $user_profile['email'];
        $input['s_password']  = sha1( osc_genRandomPassword() ) ;
        $input['dt_reg_date'] = date( 'Y-m-d H:i:s' ) ;
        $input['s_secret']    = osc_genRandomPassword();
		
        $email_taken = $manager->findByEmail( $input['s_email'] ) ;
        $manager->insert( $input ) ;
        $userID = $manager->dao->insertedId() ;
		$manager->update(['s_username' => $userID], ['pk_i_id' => $userID]);

        osc_run_hook( 'user_register_completed', $userID ) ;
        $userDB = $manager->findByPrimaryKey( $userID ) ;
        if( osc_notify_new_user() ) {
            osc_run_hook( 'hook_email_admin_new_user', $userDB ) ;
        }
        $manager->update( array('b_active' => '1'),array('pk_i_id' => $userID) ) ;
        osc_run_hook('hook_email_user_registration', $userDB) ;
        osc_run_hook('validate_user', $userDB) ;
        osc_add_flash_ok_message( sprintf( __('Your account has been created successfully', 'HybridAuth' ), osc_page_title() ) ) ;
        require_once osc_lib_path() . 'osclass/UserActions.php';
		$uActions = new UserActions( false );
		$logged = $uActions->bootstrap_login($userID);
    }
	
	public function googleurl(){
		return '<a href="'.osc_base_url(true) . '?login=Google" class="hybrid_btn google"><i class="fa fa-google-plus"></i> '.__( 'Вход через Google', 'HybridAuth' ).'</a>';
	}
	
	public function facebookurl(){
		return '<a href="'.osc_base_url(true) . '?login=Facebook" class="hybrid_btn facebook"><i class="fa fa-facebook"></i> '.__( 'Вход через Facebook', 'HybridAuth' ).'</a>';
	}
	
	public function twitterurl(){
		return '<a href="'.osc_base_url(true) . '?login=Twitter" class="hybrid_btn twitter"><i class="fa fa-twitter"></i> '.__( 'Вход через Twitter', 'HybridAuth' ).'</a>';
	}
	
	public function vkontakteurl(){
		return '<a href="'.osc_base_url(true) . '?login=Vkontakte" class="hybrid_btn Vkontakte"><i class="fa fa-vk"></i></a>';
	}
		public function odnoklassnikiurl(){
		return '<a href="'.osc_base_url(true) . '?login=Odnoklassniki" class="hybrid_btn Odnoklassniki"><i class="fa fa-odnoklassniki"></i> '.__( 'Вход через Одноклассники', 'HybridAuth' ).'</a>';
	}
		public function draugiemurl(){
		return '<a href="'.osc_base_url(true) . '?login=Draugiem" class="hybrid_btn Odnoklassniki"><i class="fa fa-odnoklassniki"></i> '.__( 'Вход через Draugiem', 'HybridAuth' ).'</a>';
	}
	public function mailruurl(){
		return '<a href="'.osc_base_url(true) . '?login=Mailru" class="hybrid_btn Mailru"><i class="fa fa-envelope"></i> '.__( 'Вход через Mailru', 'HybridAuth' ).'</a>';
	}
	public function yandexurl(){
		return '<a href="'.osc_base_url(true) . '?login=Yandex" class="hybrid_btn Yandex"><i class="fa fa-envelope"></i></a>';
	}

	public function instaurl(){
		return '<a href="'.osc_base_url(true) . '?login=Instagram" class="hybrid_btn Instagram"><i class="fa fa-instagram"></i> '.__( 'Вход через Instagram', 'HybridAuth' ).'</a>';
	}
	
}
?>