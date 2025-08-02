<?php
class ModelREST extends DAO {
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


public function getTable_rest_log() {
  return DB_TABLE_PREFIX.'t_rest_log';
}

public function getTable_rest_key() {
  return DB_TABLE_PREFIX.'t_rest_key';
}


public function getTable_item() {
  return DB_TABLE_PREFIX.'t_item';
}

public function getTable_user() {
  return DB_TABLE_PREFIX.'t_user';
}

public function getTable_category() {
  return DB_TABLE_PREFIX.'t_category';
}


public function import($file) {
  $path = osc_plugin_resource($file);
  $sql = file_get_contents($path);

  if(!$this->dao->importSQL($sql) ){
    throw new Exception("Error importSQL::ModelREST<br>" . $file . "<br>" . $this->dao->getErrorLevel() . " - " . $this->dao->getErrorDesc() );
  }
}


public function install($version = '') {
  if($version == '') {
    $this->import('rest/model/struct.sql');

    osc_set_preference('version', 100, 'plugin-rest', 'INTEGER');
  }
}


public function uninstall() {
  // DELETE ALL TABLES
  //$this->dao->query(sprintf('DROP TABLE %s', $this->getTable_attribute()));


  // DELETE ALL PREFERENCES
  $db_prefix = DB_TABLE_PREFIX;
  $query = "DELETE FROM {$db_prefix}t_preference WHERE s_section = 'plugin-rest'";
  $this->dao->query($query);
}


public function insertLog($data) {
  $this->dao->insert($this->getTable_rest_log(), $data);
  return $this->dao->insertedId();
}

public function insertKey($data) {
  $this->dao->insert($this->getTable_rest_key(), $data);
  return $this->dao->insertedId();
}

public function updateKey($data) {
  $this->dao->update($this->getTable_rest_key(), $data, array('pk_i_id' => $data['pk_i_id']));
}



public function getKey($key) {
  $this->dao->select();
  $this->dao->from($this->getTable_rest_key());
  $this->dao->where('s_key', $key);
  
  $result = $this->dao->get();

  if($result) { 
    $data = $result->row();
    return $data;
  }

  return false;
}

public function getKeyById($key) {
  $this->dao->select();
  $this->dao->from($this->getTable_rest_key());
  $this->dao->where('pk_i_id', $key);
  
  $result = $this->dao->get();

  if($result) { 
    $data = $result->row();
    return $data;
  }

  return false;
}

public function getKeys() {
  $this->dao->select();
  $this->dao->from($this->getTable_rest_key());
  $this->dao->orderby('pk_i_id', 'asc');
  
  $result = $this->dao->get();

  if($result) { 
    $data = $result->result();
    return $data;
  }

  return array();
}


public function getLogs($key = '') {
  $this->dao->select();
  $this->dao->from($this->getTable_rest_log());

  if($key <> '') {
    $this->dao->where('fk_i_key_id', $key);
  }

  $this->dao->orderby('dt_datetime', 'desc');
  $this->dao->limit(1000);
  
  $result = $this->dao->get();

  if($result) { 
    $data = $result->result();
    return $data;
  }

  return array();
}


public function getStats($key = '') {
  $this->dao->select('
    k.pk_i_id "key_id", 
    k.s_name "key", 
    year(l.dt_datetime)*100 + month(l.dt_datetime)*1 "yearmonth", 
    sum(case when l.s_status = "OK" then 1 else 0 end) as calls_success,
    sum(case when l.s_status = "ERROR" then 1 else 0 end) as calls_failed,
    count(l.pk_i_id) as calls_total,
    sum(d_time) as exec_time,
    sum(case when l.s_type = "read" then 1 else 0 end) as calls_read,
    sum(case when l.s_type = "insert" then 1 else 0 end) as calls_insert,
    sum(case when l.s_type = "update" then 1 else 0 end) as calls_update,
    sum(case when l.s_type = "calls_delete" then 1 else 0 end) as calls_delete
  ');
  $this->dao->from($this->getTable_rest_key() . ' as k, ' . $this->getTable_rest_log() . ' as l');
  $this->dao->where('l.fk_i_key_id = k.pk_i_id');

  if($key <> '') {
    $this->dao->where('k.pk_i_id', $key);
  }

  $this->dao->groupby('k.pk_i_id, k.s_name, year(l.dt_datetime)*100 + month(l.dt_datetime)*1');
  $this->dao->orderby('k.pk_i_id asc, year(l.dt_datetime)*100 + month(l.dt_datetime)*1 desc');
  
  $result = $this->dao->get();

  if($result) { 
    $data = $result->result();
    return $data;
  }

  return array();
}


// REMOVE KEY
public function removeKey($id) {
  $this->dao->delete($this->getTable_rest_key(), array('pk_i_id' => $id));
}

// REMOVE KEY LOGS
public function removeKeyLogs($id) {
  $this->dao->delete($this->getTable_rest_log(), array('fk_i_key_id' => $id));
}



}
?>