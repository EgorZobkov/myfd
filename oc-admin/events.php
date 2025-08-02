<?php
require_once dirname(__FILE__) . '/../oc-load.php';

class CAdminEvents extends AdminSecBaseModel {
  public function __construct() {
    parent::__construct();
    $this->page = 'events';
    $this->action = Params::getParam('action');
  }
  public function doModel() {
    $dbConn = DBConnectionClass::newInstance();
    $conn = $dbConn->getOsclassDb();
    $table = DB_TABLE_PREFIX . 't_events';

    if ($this->action === 'add') {
      if ($conn) {
        $now = date('Y-m-d H:i:s');
        $fields = array(
          'title'            => $conn->real_escape_string(Params::getParam('title')),
          'date_start'       => $conn->real_escape_string(Params::getParam('date_start')),
          'date_end'         => $conn->real_escape_string(Params::getParam('date_end')),
          'submission_start' => $conn->real_escape_string(Params::getParam('submission_start')),
          'submission_end'   => $conn->real_escape_string(Params::getParam('submission_end')),
          'description'      => $conn->real_escape_string(Params::getParam('description')),
          'logo'             => $conn->real_escape_string(Params::getParam('logo')),
          'city'             => $conn->real_escape_string(Params::getParam('city')),
          'link_vk'          => $conn->real_escape_string(Params::getParam('link_vk')),
          'link_tickets'     => $conn->real_escape_string(Params::getParam('link_tickets')),
          'link_telegram'    => $conn->real_escape_string(Params::getParam('link_telegram')),
          'created_at'       => $now,
          'updated_at'       => $now
        );

        $columns = '`' . implode('`,`', array_keys($fields)) . '`';
        $values  = "'" . implode("','", array_values($fields)) . "'";
        $conn->query('INSERT INTO ' . $table . ' (' . $columns . ') VALUES (' . $values . ')');
      }

      $this->redirectTo(osc_admin_base_url(true) . '?page=events');
      return;
    } elseif ($this->action === 'edit') {
      osc_csrf_check();
      $id = (int) Params::getParam('id');
      if ($id && $conn) {
        $now = date('Y-m-d H:i:s');
        $fields = array(
          'title'            => $conn->real_escape_string(Params::getParam('title')),
          'date_start'       => $conn->real_escape_string(Params::getParam('date_start')),
          'date_end'         => $conn->real_escape_string(Params::getParam('date_end')),
          'submission_start' => $conn->real_escape_string(Params::getParam('submission_start')),
          'submission_end'   => $conn->real_escape_string(Params::getParam('submission_end')),
          'description'      => $conn->real_escape_string(Params::getParam('description')),
          'logo'             => $conn->real_escape_string(Params::getParam('logo')),
          'city'             => $conn->real_escape_string(Params::getParam('city')),
          'link_vk'          => $conn->real_escape_string(Params::getParam('link_vk')),
          'link_tickets'     => $conn->real_escape_string(Params::getParam('link_tickets')),
          'link_telegram'    => $conn->real_escape_string(Params::getParam('link_telegram')),
          'updated_at'       => $now
        );
        $set = array();
        foreach ($fields as $col => $val) {
          $set[] = '`' . $col . "`='" . $val . "'";
        }
        $conn->query('UPDATE ' . $table . ' SET ' . implode(',', $set) . ' WHERE id = ' . $id);
        if ($conn->affected_rows > 0) {
          osc_add_flash_ok_message(__('Event updated', 'my_events'), 'admin');
        } else {
          osc_add_flash_error_message(__('Event could not be updated', 'my_events'), 'admin');
        }
      }
      $this->redirectTo(osc_admin_base_url(true) . '?page=events');
      return;
    } elseif ($this->action === 'delete') {
      osc_csrf_check();
      $id = (int) Params::getParam('id');
      if ($id && $conn) {
        $conn->query('DELETE FROM ' . $table . ' WHERE id = ' . $id);
        if ($conn->affected_rows > 0) {
          osc_add_flash_ok_message(__('Event deleted', 'my_events'), 'admin');
        } else {
          osc_add_flash_error_message(__('Event could not be deleted', 'my_events'), 'admin');
        }
      }
      $this->redirectTo(osc_admin_base_url(true) . '?page=events');
      return;
    }

    // fetch events list
    $events = array();
    if ($conn) {
      $sql = 'SELECT * FROM ' . $table;
      $result = $conn->query($sql);
      if ($result) {
        while ($row = $result->fetch_assoc()) {
          $events[] = $row;
        }
      }
    }

    $this->_exportVariableToView('events', $events);
    $this->doView('events/index.php');
  }
}
$do = new CAdminEvents();
$do->doModel();