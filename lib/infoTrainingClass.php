<?php

require_once 'infoContentsBaseClass.php';

class infoTraining extends infoContentsBase {

  public $_fieldMap = array(
    'title'             => array(1, FIELD_TYPE_STRING),
    'avatar'             => array(2, FIELD_TYPE_STRING),
    'description'            => array(3, FIELD_TYPE_STRING),
    'uploader'            => array(4, FIELD_TYPE_STRING),
    'video_id'            => array(5, FIELD_TYPE_NUMERIC),
    'active'            => array(6, FIELD_TYPE_NUMERIC),
    'ctime'            => array(7, FIELD_TYPE_DATETIME),
    'mtime'            => array(8, FIELD_TYPE_DATETIME),
  );
  // 公開
  public $CSTATUS_LIST = array(
    10 => '公開',
    99 => '非公開',
  );

  function __construct($db_target = 'slave') {
    parent::__construct($db_target);

    $this->_table = 'apl_training';
    $this->_upfileDir = UP_IMAGE_DIR . $this->_table . '/';
    $this->_uppath = UP_IMAGE_PATH . '/' . $this->_table;
  }

  //read_element
  public function getTrainingregisteredList($video_id,$user_id) {
    $sql = "SELECT * ";
    $sql .= "FROM ";
    $sql .= $this->_table." AS T1 INNER JOIN apl_register_training AS T2 ON T1.sid = T2.training_id ";
    $sql .= "WHERE ";
    $sql .= "   T1.active = 1 ";
    $sql .= "  and T2.user_id = ".$user_id;
    $sql .= "  and T1.video_id = ".$video_id;
    $sql .= $this->getSQL_order();
    $sql .= $this->getSQL_limit();
    $sql .= $this->getSQL_offset();
    $list = $this->getObjList($this->search($sql));
    return $list;
  }

  //read_element
  public function getTrainingList() {
    $sql = "SELECT ";
    $sql .= " sid";
    $sql .= ",title";
    $sql .= ",avatar";
    $sql .= ",description";
    $sql .= ",uploader";
    $sql .= ",video_id";
    $sql .= ",active";
    $sql .= ",ctime";
    $sql .= ",mtime ";
    $sql .= "FROM ";
    $sql .= $this->_table." ";
    $sql .= "WHERE ";
    $sql .= "   active = 1 ";
    $sql .= $this->getSQL_order();
    $sql .= $this->getSQL_limit();
    $sql .= $this->getSQL_offset();
    $list = $this->getObjList($this->search($sql));
    return $list;
  }

  //read_element
  public function getTrainingList_register() {
    $sql = "SELECT ";
    $sql .= " sid";
    $sql .= ",title";
    $sql .= ",avatar";
    $sql .= ",description";
    $sql .= ",uploader";
    $sql .= ",video_id";
    $sql .= ",active";
    $sql .= ",ctime";
    $sql .= ",mtime ";
    $sql .= "FROM ";
    $sql .= $this->_table." ";
    $sql .= "WHERE ";
    $sql .= "   active = 1 ";
    $sql .= $this->getSQL_order();
    $sql .= $this->getSQL_limit();
    $sql .= $this->getSQL_offset();
    $list = $this->getObjList($this->search($sql));
    return $list;
  }

  //read_element
  public function getTrainingListByVideoId($video_id) {
    $sql = "SELECT ";
    $sql .= " sid";
    $sql .= ",title";
    $sql .= ",avatar";
    $sql .= ",description";
    $sql .= ",uploader";
    $sql .= ",video_id";
    $sql .= ",active";
    $sql .= ",ctime";
    $sql .= ",mtime ";
    $sql .= "FROM ";
    $sql .= $this->_table." ";
    $sql .= "WHERE ";
    $sql .= "   active = 1 ";
    $sql .= "  and video_id = ".$video_id;
    $sql .= $this->getSQL_order();
    $sql .= $this->getSQL_limit();
    $sql .= $this->getSQL_offset();
    $list = $this->getObjList($this->search($sql));
    return $list;
  }

  public function getTrainingListCount() {
    $sql = "SELECT ";
    $sql .= " COUNT(*) cnt ";
    $sql .= "FROM ";
    $sql .= $this->_table."  ";
    $sql .= "WHERE ";
    $sql .= "   active = 1 ";
    $list = $this->getObjList($this->search($sql));
    if (!empty($list)) {
      return $list[0]->cnt;
    }
    return false;
  }

  public function getTrainingListById($sid) {
    $sql = "SELECT ";
    $sql .= " sid";
    $sql .= ",title";
    $sql .= ",avatar";
    $sql .= ",description";
    $sql .= ",uploader";
    $sql .= ",video_id";
    $sql .= ",active";
    $sql .= ",ctime";
    $sql .= ",mtime ";
    $sql .= "FROM ";
    $sql .= $this->_table."  ";
    $sql .= "WHERE ";
    $sql .= "  active = 1 ";
    $sql .= "  and sid = ".$sid;
    $sql .= $this->getSQL_order();
    $list = $this->getObjList($this->search($sql));
    if (!empty($list)) {
      return $list[0];
    }
    return false;
  }

  //create_element
  function insertTraining($title,$avatar,$description,$uploader,$video_id) {
    $ctime=$mtime= date('Y-m-d H:i:s',$this->_site->gettime());
    $sql='insert into '. $this->_table.' (title,avatar,description,uploader,video_id,active,ctime,mtime) values (:title,:avatar,:description,:uploader,:video_id,:active,:ctime,:mtime)';
    $prm = array(
      'title' => $title,
      'avatar' => $avatar,
      'description' => $description,
      'uploader'  => $uploader,
      'video_id' => $video_id,
      'active' => 1,
      'ctime' => $ctime,
      'mtime' => $mtime,
    );
    $stmt=$this->preparation($sql);
    $this->bind($stmt,$prm);
    return $this->change($stmt);
  }
  //update_element
  function updateTraining($sid,$title,$avatar,$description,$uploader,$video_id) {
    $mtime = date('Y-m-d H:i:s',$this->_site->gettime());
    $sql='UPDATE '. $this->_table.' SET title = :title,avatar = :avatar,description = :description, uploader = :uploader ,video_id = :video_id, mtime = :mtime WHERE sid = :sid';
    $prm = array(
      'sid' => $sid,
      'title' => $title,
      'avatar' => $avatar,
      'description' => $description,
      'uploader'  => $uploader,
      'video_id' => $video_id,
      'mtime' => $mtime,
    );
    $stmt=$this->preparation($sql);
    $this->bind($stmt,$prm);
    var_dump($this->bind($stmt,$prm));
    return $this->change($stmt);
  }
  //delete_element
  function deleteTraining($sid) {
    $mtime = date('Y-m-d H:i:s',$this->_site->gettime());
    $sql = 'update '.$this->_table.' set ';
    $sql .= ' active = 0, ';
    $sql .= ' mtime = :mtime ';
    $sql .= ' where ';
    $sql .= ' sid = :sid ';
    $prm = array(
      'sid' => $sid,
      'mtime' => $mtime,
    );
    $stmt=$this->preparation($sql);
    $this->bind($stmt,$prm);
    return $this->change($stmt);
  }

}
