<?php if (!defined('ABS_PATH')) { exit('ABS_PATH is not loaded. Direct access is not allowed.'); };

class SCModel extends DAO {

    private static $instance;

    public static function newInstance()
    {
        if ( !self::$instance instanceof self ) {
            self::$instance = new self;
        }

        return self::$instance;
    }

    function __construct()
    {
        parent::__construct();
        $this->setTableName( 't_social_connect' );
        $this->setPrimaryKey( 'pk_i_id' );
        $this->setFields( array( 'pk_i_id', 'fk_i_user_id', 'i_provider_username', 'i_provider_id', 's_provider', 's_picture_profile' ) );
    }

    public function import($file)
    {
        $sql = file_get_contents($file);

        if(! $this->dao->importSQL($sql) ){
            throw new Exception( "Error importSQL::SCModel: " . $file ) ;
        }
    }

    public function install() {
        $this->import(SC_PATH . 'struct.sql');
        osc_set_preference('version', '100', 'socialconnect', 'INTEGER');
    }

    public function uninstall() {
        $this->dao->query(sprintf('DROP TABLE %s', $this->getTableName()) );
        Preference::newInstance()->delete(array('s_section' => 'socialconnect'));
    }

    public function find($providerId, $provider) {
        $this->dao->select('*') ;
        $this->dao->from($this->getTableName());
        $this->dao->where('i_provider_id', $providerId);
        $this->dao->where('s_provider', $provider);
        $result = $this->dao->get();
        if($result) {
            return $result->row();
        }
        return array();
    }

    public function findByUserId($userId) {
        $this->dao->select('*') ;
        $this->dao->from($this->getTableName());
        $this->dao->where('fk_i_user_id', $userId);
        $result = $this->dao->get();
        if($result) {
            return $result->result();
        }
        return array();
    }

    public function findByUserIdProvider($userId, $provider=null) {
        $this->dao->select('*') ;
        $this->dao->from($this->getTableName());
        $this->dao->where('fk_i_user_id', $userId);
        if($provider!=null) {
            $this->dao->where('s_provider', $provider);
        }
        $this->dao->where('s_picture_profile <> ""');
        $result = $this->dao->get();
        if($result) {
            return $result->row();
        }
        return array();
    }

    public function linked($userId, $provider) {
        $this->dao->select('*') ;
        $this->dao->from($this->getTableName());
        $this->dao->where('fk_i_user_id', $userId);
        $this->dao->where('s_provider', $provider);
        $result = $this->dao->get();
        if($result) {
            $row = $result->row();
            if(isset($row['i_provider_id'])) {
                return true;
            }
        }
        return false;
    }

    public function getStats() {
        $this->dao->select('s_provider, count(1) total');
        $this->dao->from($this->getTableName());
        $this->dao->groupBy('s_provider');
        $this->dao->orderBy('total', 'desc');
        $result = $this->dao->get();
        if($result) {
            return $result->result();
        }
        return array();
    }
}
