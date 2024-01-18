<?php
class storage {
	protected $_site;
	protected $_dbg;
	protected $err_disp=true;

	protected $_table;
	protected $_dbx,$_dbtype,$_dbtarget;
	protected $_dbconfigfile='db_config.php';

	protected $sql_where,$sql_group,$sql_order,$sql_limit,$sql_offset,$sql_other,$sql_field,$sql_last_forcnt_param;

	function __construct($db_target){
		global $thisPage,$dbg;
		$this->_site=$thisPage;
		$this->_dbg=$dbg;

		$this->use_connect($db_target);
	}

	function db_connect($dbconn) {
		global $dbx;

		if(empty($dbx[$this->_dbtarget])){
			try{
				if($dbconn['type']=='sqlite') {
					$dbx[$this->_dbtarget] = new PDO('sqlite:'.$dbconn['name']);
				}elseif($dbconn['type']=='pgsql') {
					$dbx[$this->_dbtarget] = new PDO('pgsql:dbname='.$dbconn['name'].' host='.$dbconn['host'].' port='.$dbconn['port'],$dbconn['user'],$dbconn['passwd']);
				}elseif($dbconn['type']=='mysql') {
					$dbx[$this->_dbtarget] = new PDO('mysql:host='.$dbconn['host'].';port='.$dbconn['port'].';dbname='.$dbconn['name'],$dbconn['user'],$dbconn['passwd']);
				}
				$dbx[$this->_dbtarget]->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			}catch (PDOException $exception){
			}
		}
		if($dbx[$this->_dbtarget]){
			return $dbx[$this->_dbtarget];
		}else{
			if($this->err_disp){
				$txt='';
				if($this->_dbg&&$this->_dbg->isDebugUser()) {
					$txt=$exception.'<br />';
					$txt.='db connection error';
				}else{
					$txt="<html><body>The access concentrates, and is being crowded to the site now.<br>Please access it after a while again.</body></html>";
				}
				exit($txt);
			}
		}
	}

	function use_connect($db_target){
		$this->_dbtarget = $db_target;
		if(!$this->_site->getDb_conn($db_target)){
			$db_config=$this->_site->getDb_config($db_target);
			if(!$db_config){
				@include($this->_dbconfigfile);
				if(!$DB_CONFIG){return;}
				$this->_site->setDb_config($DB_CONFIG);
				$db_config=$this->_site->getDb_config($db_target);
			}
			$this->_dbx=$this->db_connect($db_config);
			$this->_dbtype=$db_config['type'];
			if($this->_dbtype=='mysql'){
				$this->query('SET NAMES binary');
//				$this->query("SET NAMES 'utf8' collate 'utf8_general_ci'");
			}
			$this->_site->setDb_conn($db_target,$this->_dbx);
			$this->_site->setDb_type($db_target,$this->_dbtype);
		}else{
			$this->_dbx=$this->_site->getDb_conn($db_target);
			$this->_dbtype=$this->_site->getDb_type($db_target);
		}
		$this->resetSQL_prm();
	}

	function resetSQL_prm(){
		$this->sql_where=$this->sql_group=$this->sql_order=$this->sql_field=array();
		$this->sql_limit=$this->sql_offset=$this->sql_other=false;
		$this->sql_last_forcnt_param='';
	}
	function setTable($a){
		$this->_table=$a;
	}
	function getTable(){
		return $this->_table;
	}
	function getDBconnect(){
		return $this->_dbx;
	}
	function getDBtype(){
		return $this->_dbtype;
	}

//---------------------
	function begin(){
		return $this->_dbx->beginTransaction();
	}
	function rollback(){
		return $this->_dbx->rollBack();
	}
	function commit(){
		return $this->_dbx->commit();
	}
	function query($a){
		return $this->_dbx->query($a);
	}
	function preparation($a){
		return $this->_dbx->prepare($a);
	}
	function lock($tbl,$mode=null){
		if($mode){
			$sql="LOCK ".$tbl." IN ".$mode." ";
		} else {
			$sql="LOCK ".$tbl." ";
		}
		return $this->_dbx->query($sql);
	}
	function lastInsertId($field=false){
		if($field){
			return $this->_dbx->lastInsertId($field);
		}else{
			return $this->_dbx->lastInsertId();
		}
	}

	function search($a){
		$stmt = $this->_dbx->prepare($a);
		try {
			$stmt->execute();
			return $stmt;
		} catch (PDOException $exception) {
			if($this->err_disp){
				var_dump($exception);
			}
		}
	}
	function change($stmt){
		try {
			$ret = $stmt->execute();
		} catch (PDOException $exception) {
			$ret=false;
			if($this->err_disp){
				var_dump($exception->getMessage());
			}
		}
		return $ret;
	}
	function bind($stmt,$key,$var=null){
		if(is_array($key)&& !$var){
			foreach($key as $k=>$v){
				$stmt->bindValue(":".$k,$v);
			}
		}else{
			$stmt->bindValue(":".$key,$var);
		}
	}
	function pdo_quote($str){
		if($this->dbtype=='sqlite'){
			return sqlite_escape_string($str);
		}else{
			return $this->_dbx->quote($str);
		}
	}
	function setSQL_where($a){$this->sql_where[]=$a;}
	function setSQL_group($a){$this->sql_group[]=$a;}
	function setSQL_order($a){$this->sql_order[]=$a;}
	function setSQL_limit($a){$this->sql_limit=$a;}
	function setSQL_offset($a){$this->sql_offset=$a;}
	function setSQL_other($a){$this->sql_other=$a;}
	function setSQL_field($a){$this->sql_field[]=$a;}
	function setSQL_last_forcnt_param($a){$this->sql_last_forcnt_param=$a;}
	function getSQL_where(){
		$a=$this->sql_where;
		if($a){
			$this->sql_where=array();//init
			return " WHERE ".implode(" AND ",$a);
		}
	}
	function getSQL_group(){
		$a=$this->sql_group;
		if($a){
			$this->sql_group=array();//init
			return " GROUP BY ".implode(',',$a);
		}
	}
	function getSQL_order(){
		$a=$this->sql_order;
		if($a){
			$this->sql_order=array();//init
			return " ORDER BY ".implode(',',$a);
		}
	}
	function getSQL_limit(){
		$a=$this->sql_limit;
		if($a){
			$this->sql_limit=false;//init
			return " LIMIT ".$a;
		}
	}
	function getSQL_offset(){
		$a=$this->sql_offset;
		if($a){
			$this->sql_offset=false;//init
			return " OFFSET ".$a;
		}
	}
	function getSQL_other(){
		$a=$this->sql_other;
		if($a){
			$this->sql_other=false;//init
			return " ".$a;
		}
	}
	function getSQL_field(){
		$string = '*';
		$a=$this->sql_field;
		if($a){
			$this->sql_field=array();//init
			$string=implode(',',$a);
		}
		return $string;
	}
	function getSQL_lastallcnt() {
		return $this->sql_last_forcnt_param;
	}
	function getSQLparam(){
		$a='';
		$a .= $this->getSQL_where();
		$a .= $this->getSQL_group();
		$this->sql_last_forcnt_param=$a;//for maxcount
		$a .= $this->getSQL_order();
		$a .= $this->getSQL_limit();
		$a .= $this->getSQL_offset();
		$a .= $this->getSQL_other();
		return $a;
	}
	function getLastAllCnt($field='*'){
		$this->setSQL_other($this->getSQL_lastallcnt());
		return $this->countRecord($field);
	}

	function getObjList($stmt){
		$list=array();
		while($obj = $stmt->fetchObject()){
			$list[]=$obj;
		}
		return $list;
	}
	function getDataList($stmt,$type=false){
		$list=array();
		if($type){
			while($obj = $stmt->fetch($type)){
				$list[]=$obj;
			}
		}else{
			while($obj = $stmt->fetch()) {
				$list[]=$obj;
			}
		}
		return $list;
	}
	function timeSplit($a){
		return preg_split("/[\-\/:, ]/",$a);
	}
	function countRecord($field='*'){
		$sql = "select count(".$field.") as countrecord from ".$this->getTable();
		$sql .= $this->getSQLparam();
		$stmt = $this->search($sql);
		$obj=$stmt->fetchObject();
		if($obj){
			return $obj->countrecord;
		}
		return 0;
	}
}
?>
