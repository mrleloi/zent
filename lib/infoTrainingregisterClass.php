<?php

require_once 'infoContentsBaseClass.php';

class infoTrainingregister extends infoContentsBase {

  public $_fieldMap = array(
    'user_id'             => array(1, FIELD_TYPE_NUMERIC),
    'training_id'             => array(2, FIELD_TYPE_NUMERIC),
    'active'            => array(3, FIELD_TYPE_NUMERIC),
    'ctime'            => array(4, FIELD_TYPE_DATETIME),
    'mtime'            => array(5, FIELD_TYPE_DATETIME),
  );

  // 公開
  public $CSTATUS_LIST = array(
    10 => '公開',
    99 => '非公開',
  );

  function __construct($db_target = 'slave') {
    parent::__construct($db_target);

    $this->_table = 'apl_register_training';
    $this->_upfileDir = UP_IMAGE_DIR . $this->_table . '/';
    $this->_uppath = UP_IMAGE_PATH . '/' . $this->_table;
  }

  //check_element
  public function getTrainingListBy($user_id,$training_id) {
    $sql = "SELECT ";
    $sql .= " sid";
    $sql .= ",user_id";
    $sql .= ",training_id";
    $sql .= ",active";
    $sql .= ",ctime";
    $sql .= ",mtime ";
    $sql .= "FROM ";
    $sql .= $this->_table."  ";
    $sql .= "WHERE ";
    $sql .= "  active = 1 ";
    $sql .= "  and user_id = ".$user_id;
    $sql .= "  and training_id = ".$training_id;
    $sql .= $this->getSQL_order();
    $list = $this->getObjList($this->search($sql));
    if (!empty($list)) {
      return $list[0];
    }
    return false;
  }

  //check_element
  public function getTrainingListregistered($user_id) {
    $sql = "SELECT ";
    $sql .= " sid";
    $sql .= ",user_id";
    $sql .= ",training_id";
    $sql .= ",active";
    $sql .= ",ctime";
    $sql .= ",mtime ";
    $sql .= "FROM ";
    $sql .= $this->_table."  ";
    $sql .= "WHERE ";
    $sql .= "  active = 1 ";
    $sql .= "  and user_id = ".$user_id;
    $sql .= $this->getSQL_order();
    $list = $this->getObjList($this->search($sql));
    if (!empty($list)) {
      return $list[0];
    }
    return false;
  }

  //create_element
  function insertTrainingregister($user_id,$training_id) {
    $ctime=$mtime= date('Y-m-d H:i:s',$this->_site->gettime());
    $sql='insert into '. $this->_table.' (user_id,training_id,active,ctime,mtime) values (:user_id,:training_id,:active,:ctime,:mtime)';
    $prm = array(
      'user_id' => $user_id,
      'training_id' => $training_id,
      'active' => 1,
      'ctime' => $ctime,
      'mtime' => $mtime,
    );
    $stmt=$this->preparation($sql);
    $this->bind($stmt,$prm);
    return $this->change($stmt);
  }

}
