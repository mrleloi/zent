<?php

require_once 'infoContentsBaseClass.php';

class infoMovie extends infoContentsBase {

  public $_fieldMap = array(
    'title'             => array(1, FIELD_TYPE_STRING),
    'url'             => array(2, FIELD_TYPE_STRING),
    'description'            => array(3, FIELD_TYPE_STRING),
    'duration'            => array(4, FIELD_TYPE_STRING),
    'thumbnail_small'            => array(5, FIELD_TYPE_STRING),
    'thumbnail_large'            => array(6, FIELD_TYPE_STRING),
    'uploader'            => array(7, FIELD_TYPE_STRING),
    'active'            => array(8, FIELD_TYPE_NUMERIC),
    'ctime'            => array(9, FIELD_TYPE_DATETIME),
    'mtime'            => array(10, FIELD_TYPE_DATETIME),
  );
  // 公開
  public $CSTATUS_LIST = array(
    10 => '公開',
    99 => '非公開',
  );

  function __construct($db_target = 'slave') {
    parent::__construct($db_target);

    $this->_table = 'apl_video';
    $this->_upfileDir = UP_IMAGE_DIR . $this->_table . '/';
    $this->_uppath = UP_IMAGE_PATH . '/' . $this->_table;
  }

//read_element
  public function getVideoList() {
    $sql = "SELECT ";
    $sql .= " sid";
    $sql .= ",title";
    $sql .= ",url";
    $sql .= ",description";
    $sql .= ",duration";
    $sql .= ",thumbnail_small";
    $sql .= ",thumbnail_large";
    $sql .= ",uploader";
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

  public function getVideoListCount() {
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

  public function getVideoListById($sid) {
    $sql = "SELECT ";
    $sql .= " sid";
    $sql .= ",title";
    $sql .= ",url";
    $sql .= ",description";
    $sql .= ",duration";
    $sql .= ",thumbnail_small";
    $sql .= ",thumbnail_large";
    $sql .= ",uploader";
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
  function insertVideo($title,$url,$description,$duration,$thumbnail_small,$thumbnail_large,$uploader) {
    $ctime=$mtime= date('Y-m-d H:i:s',$this->_site->gettime());
    $sql='insert into '. $this->_table.' (title,url,description,duration,thumbnail_small,thumbnail_large,uploader,active,ctime,mtime) values (:title,:url,:description,:duration,:thumbnail_small,:thumbnail_large,:uploader,:active,:ctime,:mtime)';
    $prm = array(
      'title' => $title,
      'url' => $url,
      'description' => $description,
      'duration'  => $duration,
      'thumbnail_small' => $thumbnail_small,
      'thumbnail_large' => $thumbnail_large,
      'uploader' => $uploader,
      'active' => 1,
      'ctime' => $ctime,
      'mtime' => $mtime,
    );
    $stmt=$this->preparation($sql);
    $this->bind($stmt,$prm);
    return $this->change($stmt);
  }
  //update_element
  function updateVideo($sid,$title,$url,$description,$duration,$thumbnail_small,$thumbnail_large,$uploader) {
    $mtime = date('Y-m-d H:i:s',$this->_site->gettime());
    $sql='UPDATE '. $this->_table.' SET title = :title,url = :url,description = :description, duration = :duration ,thumbnail_small = :thumbnail_small, thumbnail_large = :thumbnail_large, uploader = :uploader, mtime = :mtime WHERE sid = :sid';
    $prm = array(
      'sid' => $sid,
      'title' => $title,
      'url' => $url,
      'description' => $description,
      'duration'  => $duration,
      'thumbnail_small' => $thumbnail_small,
      'thumbnail_large' => $thumbnail_large,
      'uploader' => $uploader,
      'mtime' => $mtime,
    );
    $stmt=$this->preparation($sql);
    $this->bind($stmt,$prm);
    var_dump($this->bind($stmt,$prm));
    return $this->change($stmt);
  }
  //delete_element
  function deleteVideo($sid) {
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
