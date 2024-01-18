<?php
require_once("storageClass.php");

class infoBase extends storage {
	function __construct ($db_no='slave') {//db_connection number
		parent::__construct($db_no);
		$this->_viewCnt=0;
		$this->_fileCnt=0;
	}

	function getViewCnt(){
		return $this->_viewCnt;
	}
	function getFileCnt(){
		return $this->_fileCnt;
	}
	function getContent($id,$field='sid'){
		$this->setSQL_where($field."=".$id);
		$SQL = "SELECT * FROM ".$this->getTable();
		$SQL .= $this->getSQLparam();
		$stmt = $this->search($SQL);
		$obj = $stmt->fetchObject();
		if($obj) {
			return $obj;
		}
		return FALSE;
	}
	function getContentList(){
		$sql = "SELECT * FROM ".$this->getTable();
		$sql .= $this->getSQLparam();
		return $this->search($sql);
	}
	function getIdList($field='name',$id='sid'){
		$this->setWebParam();
		$SQL = "SELECT * FROM ".$this->getTable();
		$SQL .= $this->getSQLparam();
		$stmt = $this->search($SQL);
		$list=array();
		while($obj = $stmt->fetchObject()) {
			$list[$obj->$id] = $obj->$field;
		}
		return $list;
	}
	function setWebParam(){
		$this->setSQL_where('cstatus=10');
		$this->setSQL_where('active=1');
		$this->setSQL_order('direct_order asc');
		if(!empty($this->_viewCnt)){
			$this->setSQL_limit($this->_viewCnt);
		}
	}
	function getContentList_forWeb(){
		$this->setWebParam();
		$stmt = $this->getContentList();
		return $this->getObjList($stmt);
	}
	//max
	function getMaxNo($field='sid'){
		$SQL = "SELECT max(".$field.") as maxnum FROM ".$this->getTable();
		$SQL .= $this->getSQLparam();
		$stmt = $this->search($SQL);
		$obj = $this->getObjList($stmt);
		if(isset($obj[0])) {
			return $obj[0]->maxnum;
		}
		return FALSE;
	}
	function alreadyck($no,$field='sid'){
		if(!$no) { return FALSE; }
		if(is_numeric($no)){
			$this->setSQL_where($field.'='.$no);
		}else{
			$this->setSQL_where($field.'="'.$no.'"');
		}
		return $this->countRecord();
	}
	//add table
	function addSQL(){
		return false;
	}
	function addPrepare(){
		$sql=$this->addSQL();
		if(!$sql){return false;}
		return $this->preparation($sql);
	}
	function add($stmt,$v=array()){
		$this->bind($stmt,$v);
		return $this->change($stmt);
	}
	//up table
	function updateSQL(){
		return false;
	}
	function updatePrepare(){
		$sql=$this->updateSQL();
		if(!$sql){return false;}
		return $this->preparation($sql);
	}
	function update ($stmt,$v) {
		$this->bind($stmt,$v);
		return $this->change($stmt);
	}
	//delete
	function deleteSQL($field='sid'){
		$sql = "update ".$this->getTable();
		$sql .= " SET active=:active";
		$sql .= " WHERE ".$field."=:".$field;
		return $sql;
	}
	function deletePrepare($field='sid') {
		$sql=$this->deleteSQL($field);
		if(!$sql){return false;}
		return $this->preparation($sql);
	}
	function delete($stmt,$sid,$field='sid') {
		$prm=array(
			'active'=>0,
			$field=>$sid,
		);
		$this->bind($stmt,$prm);
		return $this->change($stmt);
	}
/**tmp**/
	function deleteStatusPrepare($field='sid') {
		return $this->deletePrepare($field);
	}
	function deleteStatus($stmt,$sid) {
		return $this->delete($stmt,$sid);
	}
/**tmp end**/
	//up direct_order
	function updateOrderSQL($field='sid'){
		$sql = "update ".$this->getTable();
		$sql .= " SET direct_order=:direct_order";
		$sql .= " WHERE ".$field."=:".$field;
		return $sql;
	}
	function updateOrderPrepare($field='sid'){
		$sql=$this->updateOrderSQL($field);
		if(!$sql){return false;}
		return $this->preparation($sql);
	}
}
?>
