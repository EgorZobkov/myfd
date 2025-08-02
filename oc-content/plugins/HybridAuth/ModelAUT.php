<?php
class ModelAUT extends DAO {
private static $instance;

public static function newInstance() {
  if( !self::$instance instanceof self ) {
    self::$instance = new self;
  }
  return self::$instance;
}

function __construct() {
  parent::__construct();
}


public function getTable_user() {
  return DB_TABLE_PREFIX.'t_user';
}



public function getTable_profile_picture() {
  return DB_TABLE_PREFIX.'t_profile_picture';
}



public function import($file) {
  $path = osc_plugin_resource($file);
  $sql = file_get_contents($path);

  if(!$this->dao->importSQL($sql) ){
    throw new Exception("Error importSQL::ModelAUT<br>" . $file . "<br>" . $this->dao->getErrorLevel() . " - " . $this->dao->getErrorDesc() );
  }
}



public function test(){
    echo "test";
}



public function getUserToken($user_id) {
  $this->dao->select();
  $this->dao->from($this->getTable_aut_token());

  $this->dao->where('fk_i_user_id', $user_id);
  $this->dao->limit(1);

  $result = $this->dao->get();

  if($result) { 
    $data = $result->row();

    if(@$data['s_token'] <> '') {
      return $data['s_token'];
    }
  }

  return null;
}



public function insertUserToken($user_id, $token) {
  $values = array(
    'fk_i_user_id' => $user_id,
    's_token' => $token
  );

  $this->dao->insert($this->getTable_aut_token(), $values);
  return $this->dao->insertedId();
}


public function updateUserToken($user_id, $token) {
  $values = array(
    'fk_i_user_id' => $user_id,
    's_token' => $token
  );
  
  $where = array(
    'fk_i_user_id' => $user_id
  );

  $this->dao->update($this->getTable_aut_token(), $values, $where);
}


public function updateUserIdentity($data) {
  $this->dao->replace($this->getTable_aut_identity(), $data);
}


public function createUser($user_data) {
  $user_regular = User::newInstance()->findByEmail($user_data['user_email']);

  if($user_regular && isset($user_regular['pk_i_id']) && $user_regular['pk_i_id'] > 0) {
    // user is already registered
    $user_id = $user_regular['pk_i_id'];

  } else {
    // user is not registered
    $pass = osc_genRandomPassword();
    $value_user = array(
      's_name' => $user_data['user_full_name'],
      's_email' => $user_data['user_email'],
      's_secret' => osc_genRandomPassword(),
      's_password' => osc_hash_password($pass),
      'b_enabled' => 1,
      'b_active' => 1,
      'dt_access_date' => date("Y-m-d H:i:s"),
      'dt_mod_date' => date("Y-m-d H:i:s"),
      'dt_reg_date' => date("Y-m-d H:i:s")
    );


    $this->dao->insert($this->getTable_user(), $value_user);
    $user_id = $this->dao->insertedId();

    if(osc_notify_new_user()) {
      osc_run_hook('hook_email_admin_new_user', User::newInstance()->findByPrimaryKey($user_id));
    }

    osc_run_hook('user_register_completed', $user_id);

    $this->dao->update($this->getTable_user(), array('s_username' => $user_id), array('pk_i_id' => $user_id));
  }
  
  return $user_id;
}


public function updateUserSecret( $user_id, $secret ) {
  return $this->update($this->getTable_user(), array('s_secret'  => $secret), array('pk_i_id'  => $user_id));
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



// UPDATE PROFILE PICTURE
public function updateProfilePicture($user_id, $img_url) {
  $img = $this->getProfilePicture($user_id);
  $ext = pathinfo($img_url, PATHINFO_EXTENSION);
  $ext = strtok($ext, '?');


  // new way of getting img
  if($ext == '') {
    $update = array(
      'user_id' => $user_id,
      'pic_ext' => '.jpg'
    );

    // clear old image if exists
    if($img && @$img['user_id'] > 0 && file_exists(osc_plugins_path() . 'profile_picture/images/profile' . $user_id . '.jpg')) {
      return false;  // do nothing if user has image already

      //unlink(osc_plugins_path() . 'profile_picture/images/profile' . $img['user_id'] . $img['pic_ext']);
      //$this->dao->delete($this->getTable_profile_picture(), array('pk_i_id' => $img['id']));
      //$this->dao->delete($this->getTable_profile_picture(), array('user_id' => $img['user_id']));
    }

    $fb_img = file_get_contents($img_url);
    $file = osc_plugins_path() . 'profile_picture/images/profile' . $user_id . '.jpg';
    file_put_contents($file, $fb_img);

    return $this->dao->insert($this->getTable_profile_picture(), $update);
  
  } else {
     // old way
 
    $update = array(
      'user_id' => $user_id,
      'pic_ext' => '.' . $ext
    );

    // clear old image if exists
    if($img && @$img['user_id'] > 0 && file_exists(osc_plugins_path() . 'profile_picture/images/profile' . $user_id . '.jpg')) {
      return false;  // do nothing if user has image already

      //unlink(osc_plugins_path() . 'profile_picture/images/profile' . $img['user_id'] . $img['pic_ext']);
      //$this->dao->delete($this->getTable_profile_picture(), array('pk_i_id' => $img['id']));
      //$this->dao->delete($this->getTable_profile_picture(), array('user_id' => $img['user_id']));
    }

    copy($img_url, osc_plugins_path() . 'profile_picture/images/profile' . $user_id . '.' . $ext);


    return $this->dao->insert($this->getTable_profile_picture(), $update);
  }
}


}
?>