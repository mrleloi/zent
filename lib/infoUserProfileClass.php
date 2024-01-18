<?php
require_once 'infoContentsBaseClass.php';

class infoUserProfile extends infoContentsBase
{
  public $_fieldMap = array(
    'name'           => array(1, FIELD_TYPE_STRING),
    'katakana'          => array(2, FIELD_TYPE_STRING),
    'avatar'          => array(3, FIELD_TYPE_STRING),
    'sex'          => array(4, FIELD_TYPE_STRING),
    'age'            => array(5, FIELD_TYPE_NUMERIC),
    'birthday'           => array(6, FIELD_TYPE_DATETIME),
    'address'          => array(7, FIELD_TYPE_STRING),
    'tel'          => array(8, FIELD_TYPE_STRING),
    'mobile'          => array(9, FIELD_TYPE_STRING),
    'email'            => array(10, FIELD_TYPE_STRING),
    'active'          => array(11, FIELD_TYPE_NUMERIC),
    'ctime'          => array(12, FIELD_TYPE_DATETIME),
    'mtime'            => array(13, FIELD_TYPE_DATETIME),
    'account_id'            => array(14, FIELD_TYPE_NUMERIC),
  );

  public $_status = array(
    1=>"未確認",
    2=>"確認済み",
  );

  public $_sex = array(
    1=>"男性",
    2=>"女性",
  );

  public function __construct($db_target='slave') {
    parent::__construct($db_target);

    $this->_table = 'account_user_profile';
    $this->_upfileDir = UP_IMAGE_DIR.$this->_table.'/';
    $this->_uppath = UP_IMAGE_PATH.'/'.$this->_table;
  }

  public function getUserProfileList() {
    $sql = "SELECT ";
    $sql .= " sid";
    $sql .= ",name";
    $sql .= ",katakana";
    $sql .= ",avatar";
    $sql .= ",sex";
    $sql .= ",age";
    $sql .= ",birthday";
    $sql .= ",address";
    $sql .= ",tel";
    $sql .= ",mobile";
    $sql .= ",email";
    $sql .= ",active";
    $sql .= ",ctime";
    $sql .= ",mtime ";
    $sql .= ",account_id ";
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

  public function getUserProfileListById($sid) {
    $sql = "SELECT ";
    $sql .= " sid";
    $sql .= ",name";
    $sql .= ",katakana";
    $sql .= ",avatar";
    $sql .= ",sex";
    $sql .= ",age";
    $sql .= ",birthday";
    $sql .= ",address";
    $sql .= ",tel";
    $sql .= ",mobile";
    $sql .= ",email";
    $sql .= ",active";
    $sql .= ",ctime";
    $sql .= ",mtime ";
    $sql .= ",account_id ";
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

  function insertUserProfile($name, $katakana,$avatar,$sex,$age,$birthday,$address,$tel,$mobile,$email,$account_id) {
      $ctime=$mtime= date('Y-m-d H:i:s',$this->_site->gettime());
      $time_delivery = date('Y-m-d H:i:s',strtotime($time_delivery));
      $sql='insert into '. $this->_table.' (name,katakana,avatar,sex,age,birthday,address,tel,mobile,email,active,ctime,mtime,account_id) values (:name,:katakana,:avatar,:sex,:age,:birthday,:address,:tel,:mobile,:email,:active,:ctime,:mtime,:account_id)';
      $prm = array(
        'name' => $name,
        'katakana' => $katakana,
        'avatar'  => $avatar,
        'sex' => $sex,
        'age' => $age,
        'birthday' => $birthday,
        'address' => $address,
        'tel'  => $tel,
        'mobile' => $mobile,
        'email' => $email,
        'active' => 1,
        'ctime' => $ctime,
        'mtime' => $mtime,
        'account_id' => $account_id,
      );
      $stmt=$this->preparation($sql);
      $this->bind($stmt,$prm);
      return $this->change($stmt);
    }

  public function getUserProfileListCount() {
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

  function deleteUserProfile($sid) {
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
