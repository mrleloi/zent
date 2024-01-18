<?php
require_once 'infoContentsBaseClass.php';

class infoAplPushNotification extends infoContentsBase
{
  public $_fieldMap = array(
    'type'             => array(1, FIELD_TYPE_STRING),
    'title'             => array(2, FIELD_TYPE_STRING),
    'body'            => array(3, FIELD_TYPE_STRING),
    'status'            => array(4, FIELD_TYPE_NUMERIC),
    'active'            => array(5, FIELD_TYPE_NUMERIC),
    'user_id'            => array(6, FIELD_TYPE_NUMERIC),
    'time_delivery'            => array(7, FIELD_TYPE_DATETIME),
    'ctime'            => array(8, FIELD_TYPE_DATETIME),
    'mtime'            => array(9, FIELD_TYPE_DATETIME),
  );

  public $_device_type = array(
    1=>"global",
    2=>"ios",
    3=>"android",
    4=>"web",
    5=>"topics",
    6=>"tokens",
  );

  public $_cstatus = array(
    10=>"承認済み",
    99=>"下書き",
    100=>"送信完了",
  );

  public function __construct($db_target='slave') {
    parent::__construct($db_target);

    $this->_table = 'apl_push_notification';
    $this->_upfileDir = UP_IMAGE_DIR.$this->_table.'/';
    $this->_uppath = UP_IMAGE_PATH.'/'.$this->_table;
  }

  public function getAplPushNotificationList() {
    $sql = "SELECT ";
    $sql .= " sid";
    $sql .= ",type";
    $sql .= ",title";
    $sql .= ",body";
    $sql .= ",status";
    $sql .= ",user_id";
    $sql .= ",time_delivery";
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

  public function getAplPushNotificationListCount() {
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

  function insertAplPushNotification($type,$title, $body,$time_delivery,$cstatus,$user_id = null) {
    $ctime=$mtime= date('Y-m-d H:i:s',$this->_site->gettime());
    $time_delivery = date('Y-m-d H:i:s',strtotime($time_delivery));
    $sql='insert into '. $this->_table.' (type,title,body,status,active,user_id,time_delivery,ctime,mtime) values (:type,:title,:body,:status,:active,:user_id,:time_delivery,:ctime,:mtime)';
    $prm = array(
      'type' => $type,
      'title' => $title,
      'body' => $body,
      'status'  => $cstatus,
      'active' => 1,
      'user_id' => $user_id,
      'time_delivery' => $time_delivery,
      'ctime' => $ctime,
      'mtime' => $mtime,
    );
    $stmt=$this->preparation($sql);
    $this->bind($stmt,$prm);
    return $this->change($stmt);
  }

  public function getAplPushNotificationListById($sid) {
    $sql = "SELECT ";
    $sql .= " sid";
    $sql .= ",type";
    $sql .= ",title";
    $sql .= ",body";
    $sql .= ",status";
    $sql .= ",user_id";
    $sql .= ",time_delivery";
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

  function updateAplPushNotification($sid,$type,$title,$body,$time_delivery,$cstatus) {
    $mtime = date('Y-m-d H:i:s',$this->_site->gettime());
    $time_delivery = date('Y-m-d H:i:s',strtotime($time_delivery));
    $sql='update '. $this->_table.' SET type = :type,title = :title, body = :body ,time_delivery = :time_delivery, status = :status, mtime = :mtime WHERE sid = :sid';
    $prm = array(
      'sid' => $sid,
      'type' => $type,
      'title' => $title,
      'body' => $body,
      'status' => $cstatus,
      'time_delivery' => $time_delivery,
      'mtime' => $mtime,
    );
    $stmt=$this->preparation($sql);
    $this->bind($stmt,$prm);
    return $this->change($stmt);
  }

  function deleteAplPushNotification($sid) {
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

  function updateStasus($today){
  		$mtime = date('Y-m-d H:i:s',$this->_site->gettime());
    	$sql=' UPDATE ';
  		$sql .= $this->_table." ";
  		$sql.=' SET status = 100, mtime= :mtime ';
  		$sql.=' WHERE  ';
  		$sql.=' status = 10 ';
  		$sql.=' AND  ';
  		$sql.=' active = 1  ';
  		$sql.=' AND ';
  	 	$sql .= "time_delivery<='".$today."' ";
  		$prm = array(
          	'mtime' => $mtime,
    		);
  		$stmt=$this->preparation($sql);
    		$this->bind($stmt,$prm);
    		return $this->change($stmt);
  	}

  public function getSendlist($today){
		$sql = "SELECT m.* FROM ";
		$sql .= $this->_table." m ";
		$sql .= " WHERE ";
		$sql .= " m.active = 1 ";
	 	$sql .= " and m.status = 10";
	 	$sql .= " and m.time_delivery <= '".$today."' ";
		$list = $this->getObjList($this->search($sql));
		if (!empty($list)) {
		  return $list;
		}
	}

}
