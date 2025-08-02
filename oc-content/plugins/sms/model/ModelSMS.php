<?php
class ModelSMS extends DAO {
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

public function getTable_item() {
  return DB_TABLE_PREFIX.'t_item';
}

public function getTable_item_location() {
  return DB_TABLE_PREFIX.'t_item_location';
}

public function getTable_sms_log() {
  return DB_TABLE_PREFIX.'t_sms_log';
}

public function getTable_sms_verification() {
  return DB_TABLE_PREFIX.'t_sms_verification';
}



public function import($file) {
  $path = osc_plugin_resource($file);
  $sql = file_get_contents($path);

  if(!$this->dao->importSQL($sql) ){
    throw new Exception("Error importSQL::ModelSMS<br>" . $file . "<br>" . $this->dao->getErrorLevel() . " - " . $this->dao->getErrorDesc() );
  }
}


public function install($version = '') {
  if($version == '') {
    $this->import('sms/model/struct.sql');

    osc_set_preference('version', 100, 'plugin-sms', 'INTEGER');
  }
}


public function uninstall() {
  // DELETE ALL TABLES
  //$this->dao->query(sprintf('DROP TABLE %s', $this->getTable_attribute()));


  // DELETE ALL PREFERENCES
  $db_prefix = DB_TABLE_PREFIX;
  $query = "DELETE FROM {$db_prefix}t_preference WHERE s_section = 'plugin-sms'";
  $this->dao->query($query);
}


public function insertLog($data) {
  $this->dao->insert($this->getTable_sms_log(), $data);
  return $this->dao->insertedId();
}


public function createVerification($data) {
  $this->dao->replace($this->getTable_sms_verification(), $data);
}

public function updateVerification($data) {
  $this->dao->update($this->getTable_sms_verification(), $data, array('s_phone_number' => $data['s_phone_number']));
}

public function updateItem($data) {
  $this->dao->update($this->getTable_item(), $data, array('pk_i_id' => $data['pk_i_id']));
}

public function updateUser($data) {
  $this->dao->update($this->getTable_user(), $data, array('pk_i_id' => $data['pk_i_id']));
}

public function verifyNumber($phone_number, $code) {
  $this->dao->select();
  $this->dao->from($this->getTable_sms_verification());
  $this->dao->where('s_phone_number', $phone_number);
  $this->dao->where('s_token', $code);
  
  $result = $this->dao->get();

  if($result) { 
    $data = $result->row();
    
    if(isset($data['s_phone_number']) && $data['s_phone_number'] <> '') {
      return true;
    }
  }

  return false;
}


public function checkTable($theme) {
  $this->dao->select();
  $this->dao->from('information_schema.tables');
  $this->dao->where('table_name', DB_TABLE_PREFIX . 't_item_' . $theme);
  $this->dao->limit(1);

  $result = $this->dao->get();

  if($result) { 
    $data = $result->row();

    if(@$data['TABLE_NAME'] == DB_TABLE_PREFIX . 't_item_' . $theme) {
      return true;
    }
  }

  return false;
}


public function updateItemPhone($data) {
  $item_id = @$data['fk_i_item_id'];
  $phone_number = @$data['s_phone'];
  $theme = osc_current_web_theme();

  if($this->checkTable($theme)) {
    $this->dao->update(DB_TABLE_PREFIX . 't_item_' . $theme, array('s_phone' => $phone_number, 'fk_i_item_id' => $item_id), array('fk_i_item_id' => $item_id));

  } else if($theme == 'zara') {
    $this->dao->update($this->getTable_item_location(), array('s_city_area' => $phone_number, 'fk_i_item_id' => $item_id), array('fk_i_item_id' => $item_id));

  }
}


public function getItemThemeNumber($item_id, $theme) {
  $this->dao->select();
  $this->dao->from(DB_TABLE_PREFIX . 't_item_' . $theme);
  $this->dao->where('fk_i_item_id', $item_id);
  
  $result = $this->dao->get();

  if($result) { 
    $data = $result->row();
    
    if(isset($data['s_phone']) && $data['s_phone'] <> '') {
      return $data['s_phone'];
    }
  }

  return false;
}


public function getVerification($phone_number, $email = '') {
  $this->dao->select();
  $this->dao->from($this->getTable_sms_verification());
  $this->dao->where('s_phone_number', $phone_number);

  if($email <> '') {
    $this->dao->where('s_email', $email);
  }
  
  $result = $this->dao->get();

  if($result) { 
    $data = $result->row();
    return $data;
  }

  return false;
}


public function getSmsLogs($limit = 5000) {
  $this->dao->select();
  $this->dao->from($this->getTable_sms_log());


  if($limit > 0) {
    $this->dao->limit($limit);
  }
  
  $this->dao->orderby('pk_i_id', 'desc');

  $result = $this->dao->get();

  if($result) { 
    $data = $result->result();
    return $data;
  }

  return false;
}



// FIND USER BY PHONE NUMBER
public function findUserByPhone($phone, $advanced = true) {
  if($phone == '') {
    return false; 
  }

  $this->dao->select();
  $this->dao->from($this->getTable_user());

  if(!$advanced) {
    //$this->dao->where('s_phone_mobile', $phone);
    $this->dao->where('(s_phone_mobile = "' . $phone . '" OR s_phone_land = "' . $phone . '")');
  } else {
    $this->dao->where(sprintf('(trim(LEADING "0" FROM replace(replace(replace(replace(replace(replace(s_phone_mobile, "+", ""), ")", ""), "(", ""), "-", ""), "/", ""), " ", ""))="%s" or trim(LEADING "0" FROM replace(replace(replace(replace(replace(replace(s_phone_land, "+", ""), ")", ""), "(", ""), "-", ""), "/", ""), " ", ""))="%s")', $phone, $phone));
  }
  
  $this->dao->where('pk_i_id != ' . osc_logged_user_id());
  
  
  $this->dao->limit(1);

  $result = $this->dao->get();
  
  if($result) {
    $data = $result->row();
    
    if(isset($data['pk_i_id'])) {
      return $data;
    }
  }

  return false;
}


public function getVerificationLogs($limit = 5000) {
  $this->dao->select();
  $this->dao->from($this->getTable_sms_verification());


  if($limit > 0) {
    $this->dao->limit($limit);
  }
  
  $this->dao->orderby('dt_date', 'desc');

  $result = $this->dao->get();

  if($result) { 
    $data = $result->result();
    return $data;
  }

  return false;
}


// REMOVE VERIFICATION BY USER EMAIL
public function deleteVerificationByEmail($email) {
  $email = trim($email);
  
  if($email <> '') {
    return $this->dao->delete($this->getTable_sms_verification(), array('s_email' => $email));
  }
}

// REMOVE VERIFICATION BY USER EMAIL
public function deleteVerificationByPhone($phone) {
  $phone = trim(str_replace('+', '', $phone));

  if($phone <> '') {  
    $this->dao->query(sprintf('DELETE FROM %s WHERE s_phone_number = "%s" OR s_phone_number = "%s"', $this->getTable_sms_verification(), $phone, '+' . $phone));
  }
}

}
?>