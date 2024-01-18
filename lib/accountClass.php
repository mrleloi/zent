<?php
require_once("storageClass.php");

class account extends storage {
	var $_logfile;
	var $_table;
	var $_table_log;

	protected $loginErrorMessage = "Login Error";
	protected $systemErrorMessage = "System Error";
	protected $statusMessage;

	function __construct ($db_no='auth_slave') {//db_connection number
		$this->_table = $this->_table_user = TB_ACCOUNT_USER;
		$this->_table_log=TB_ACCOUNT_LOG;

		$this->authInfo=FALSE;
		if(isset($_SESSION['authInfo'])){
			$this->authInfo = $_SESSION['authInfo'];
		}

		parent::__construct($db_no);
		$this->_upfileDir = UP_IMAGE_DIR.$this->_table.'/';
    $this->_uppath = UP_IMAGE_PATH.'/'.$this->_table;
	}

	function setTable( $val ) {
		$this->_table = $val;
	}
	function getAuthUser(){
		return $this->authInfo;
	}
	function getTable() {
		return $this->_table;
	}

	function setLoginErrorMessage($message){
		$this->loginErrorMessage = $message;
	}
	function setSystemErrorMessage($message){
		$this->systemErrorMessage = $message;
	}
	function getStatusMessage(){
		return $this->statusMessage;
	}

	function nowTime() {
		return date("Y-m-d H:i:s");
	}

	function getContent($id) {
		$SQL = "SELECT * FROM ".$this->getTable()." WHERE sid=".$id;
		$stmt = $this->search($SQL);
		$Cont = $this->getObjList($stmt);
		if(count($Cont)) {
			return $Cont[0];
		}
		return FALSE;
	}

	function checkToken($loginid,$token) {
		$SQL = "SELECT * FROM ".$this->getTable()." WHERE loginid="."'$loginid'"." and token="."'$token'";
		$stmt = $this->search($SQL);
		$Cont = $this->getObjList($stmt);
		if(count($Cont)) {
			return TRUE;
		}
		return FALSE;
	}

	function getContentList () {
		$SQL = "SELECT * FROM ".$this->getTable();
		$SQL .= $this->getSQLparam();
		return $this->search($SQL);
	}

	function setWebParam() {
		$today = date('Y-m-d H:i:s',$this->site->gettime());
		$this->setSQL_where('active=1');
		$this->setSQL_where('starttime<="'.$today.'"');
		$this->setSQL_where('endtime>="'.$today.'"');
		$this->setSQL_order('ordernum asc');
		$this->setSQL_order('starttime desc');
		$this->setSQL_limit(8);
	}
	function getContentList_forWeb() {
		$this->setWebParam();
		$stmt = $this->getContentList();
		return $this->getObjList($stmt);
	}

	function getMaxNo () {
		$this->setSQL_order('sid desc');
		$this->setSQL_limit(1);
		$SQL = "SELECT sid FROM ".$this->getTable();
		$SQL .= $this->getSQLparam();
		$stmt = $this->search($SQL);
		$obj = $this->getObjList($stmt);
		if(isset($obj[0])) {
			return $obj[0]->sid;
		}
		return FALSE;
	}

	function alreadyck($no) {
		if(!$no) { return FALSE; }
		$this->setSQL_where("sid=".$no);
		return $this->countRecord();
	}
	function alreadyck_loginid($no) {
		if(!$no) { return FALSE; }
		$this->setTable(TB_ACCOUNT_USER);
		$this->setSQL_where('loginid="'.$no.'"');
		return $this->countRecord();
	}

	function addPrepare_url() {
		$SQL = "insert into ".$this->_table_url;
		$SQL .= " (category,gid,name,url,active,mtime,ctime) values ";
		$SQL .= " (:category,:gid,:name,:url,:active,:mtime,:ctime)";
		return $this->preparation($SQL);
	}
	function add_url($stmt,$v) {
		$mtime = $this->nowTime();
		$this->bind($stmt,'category',$v[0]);
		$this->bind($stmt,'name',$v[2]);
		$this->bind($stmt,'gid',$v[3]);
		$this->bind($stmt,'url',$v[100]);
		$this->bind($stmt,'active',1);
		$this->bind($stmt,'title',$v[4]);
		$this->bind($stmt,'mtime',$mtime);
		$this->bind($stmt,'ctime',$mtime);
		return $this->change($stmt);
	}
	function updatePrepare_url(){
		$SQL = "update ".$this->_table_url;
		$SQL .= " SET category=:category,gid=:gid,name=:name,url=:url,mtime=:mtime";
		$SQL .= " WHERE sid=:sid";
		return $this->preparation($SQL);
	}
	function update_url($stmt,$v) {
		$mtime = $this->nowTime();
		$this->bind($stmt,'category',$v[0]);
		$this->bind($stmt,'name',$v[2]);
		$this->bind($stmt,'gid',$v[3]);
		$this->bind($stmt,'url',$v[100]);
		$this->bind($stmt,'mtime',$mtime);
		return $this->change($stmt);
	}
	function addPrepare_user() {
		$SQL = "insert into ".$this->_table_user;
		$SQL .= " (loginid,loginpwd,name,u_kind,mtime,ctime) values ";
		$SQL .= " (:loginid,:loginpwd,:name,:u_kind,:mtime,:ctime)";
		return $this->preparation($SQL);
	}

	function addPrepare_userprofile() {
		$SQL = "insert into ".$this->_table_user;
		$SQL .= " (loginid,loginpwd,u_kind,name,katakana,avatar,sex,age,birthday,address,tel,mobile,mtime,ctime) values ";
		$SQL .= " (:loginid,:loginpwd,:u_kind,:name,:katakana,:avatar,:sex,:age,:birthday,:address,:tel,:mobile,:mtime,:ctime)";
		return $this->preparation($SQL);
	}

	function add_userprofile($stmt,$v) {
		$mtime = $this->nowTime();
		$this->bind($stmt,'loginid',$v[1]);
		$this->bind($stmt,'loginpwd',$v[2]);
		$this->bind($stmt,'u_kind',$v[3]);
		$this->bind($stmt,'name',$v[4]);
		$this->bind($stmt,'katakana',$v[5]);
		$this->bind($stmt,'avatar',$v[6]);
		$this->bind($stmt,'sex',$v[7]);
		$this->bind($stmt,'age',$v[8]);
		$this->bind($stmt,'birthday',$v[9]);
		$this->bind($stmt,'address',$v[10]);
		$this->bind($stmt,'tel',$v[11]);
		$this->bind($stmt,'mobile',$v[12]);
		$this->bind($stmt,'mtime',$mtime);
		$this->bind($stmt,'ctime',$mtime);
		return $this->change($stmt);
	}

	function add_user($stmt,$v) {
		$mtime = $this->nowTime();
		$this->bind($stmt,'loginid',$v[1]);
		$this->bind($stmt,'loginpwd',$v[2]);
		$this->bind($stmt,'name',$v[3]);
		$this->bind($stmt,'u_kind',$v[4]);
		$this->bind($stmt,'mtime',$mtime);
		$this->bind($stmt,'ctime',$mtime);
		return $this->change($stmt);
	}

	function addPrepare_allow() {
		$SQL = "insert into ".$this->_table_allow;
		$SQL .= " (unum,urlnum) values ";
		$SQL .= " (:unum,:urlnum)";
		return $this->preparation($SQL);
	}
	function add_allow($stmt,$v) {
		$this->bind($stmt,'unum',$v['unum']);
		$this->bind($stmt,'urlnum',$v['urlnum']);
		return $this->change($stmt);
	}

	function updatePrepare(){
		$SQL = "update ".$this->_table_user;
		$SQL .= " SET loginid=:loginid,loginpwd=:loginpwd,mtime=:mtime";
		$SQL .= ",name=:name";
		$SQL .= ",u_kind=:u_kind";
		$SQL .= " WHERE sid=:sid";
		return $this->preparation($SQL);
	}

	function update_tokenPrepare(){
		$SQL = "update ".$this->_table_user;
		$SQL .= " SET token=:token,mtime=:mtime";
		$SQL .= " WHERE sid=:sid";
		return $this->preparation($SQL);
	}

	function update_token($stmt,$v) {
		$mtime = $this->nowTime();
		$this->bind($stmt,'token',$v);
		$this->bind($stmt,'mtime',$mtime);
		return $this->change($stmt);
	}

	function update_profilePrepare(){
		$SQL = "update ".$this->_table_user;
		$SQL .= " SET loginid=:loginid,loginpwd=:loginpwd,u_kind=:u_kind,name=:name,katakana=:katakana,avatar=:avatar,sex=:sex,age=:age,birthday=:birthday,address=:address,tel=:tel,mobile=:mobile,mtime=:mtime";
		$SQL .= " WHERE sid=:sid";
		return $this->preparation($SQL);
	}

	function update_profile($stmt,$v) {
		$mtime = $this->nowTime();
		$this->bind($stmt,'loginid',$v[1]);
		$this->bind($stmt,'loginpwd',$v[2]);
		$this->bind($stmt,'u_kind',$v[3]);
		$this->bind($stmt,'name',$v[4]);
		$this->bind($stmt,'katakana',$v[5]);
		$this->bind($stmt,'avatar',$v[6]);
		$this->bind($stmt,'sex',$v[7]);
		$this->bind($stmt,'age',$v[8]);
		$this->bind($stmt,'birthday',$v[9]);
		$this->bind($stmt,'address',$v[10]);
		$this->bind($stmt,'tel',$v[11]);
		$this->bind($stmt,'mobile',$v[12]);
		$this->bind($stmt,'mtime',$mtime);
		return $this->change($stmt);
	}

	function update($stmt,$v) {
		$mtime = $this->nowTime();
		$this->bind($stmt,'loginid',$v[1]);
		$this->bind($stmt,'loginpwd',$v[2]);
		$this->bind($stmt,'name',$v[3]);
		$this->bind($stmt,'u_kind',$v[4]);
		$this->bind($stmt,'mtime',$mtime);
		return $this->change($stmt);
	}

//-----------
	function deleteRecordPrepare () {
		$SQL = "update ".$this->getTable();
		$SQL .= " SET active=:active";
		$SQL .= " WHERE sid=:sid";
		return $this->preparation($SQL);
	}
	function delete ($stmt,$sid) {
		$this->bind($stmt,'active',0);
		$this->bind($stmt,'sid',$sid);
		return $this->change($stmt);
	}
	function deleteStatusPrepare() {
		$SQL = "update ".$this->getTable();
		$SQL .= " SET active=:active";
		$SQL .= " WHERE sid=:sid";
		return $this->preparation($SQL);
	}
	function deleteStatus($stmt,$sid) {
		$this->bind($stmt,'active',0);
		$this->bind($stmt,'sid',$sid);
		return $this->change($stmt);
	}
//----------
	function deleteRecordPrepare_gid () {
		$SQL = "update ".$this->getTable();
		$SQL .= " WHERE gid=:gid";
		return $this->preparation($SQL);
	}
	function delete_gid ($stmt,$gid) {
		$this->bind($stmt,'active',0);
		$this->bind($stmt,'gid',$gid);
		return $this->change($stmt);
	}
	function deleteStatusPrepare_gid() {
		$SQL = "update ".$this->getTable();
		$SQL .= " SET active=:active";
		$SQL .= " WHERE gid=:gid";
		return $this->preparation($SQL);
	}
	function deleteStatus_gid($stmt,$gid) {
		$this->bind($stmt,'active',0);
		$this->bind($stmt,'gid',$gid);
		return $this->change($stmt);
	}
//-----------
	function deleteRecordPrepare_unum() {
		$SQL = "update ".$this->getTable();
		$SQL .= " WHERE unum=:unum";
		return $this->preparation($SQL);
	}
	function delete_unum($stmt,$sid) {
		$this->bind($stmt,'active',0);
		$this->bind($stmt,'unum',$sid);
		return $this->change($stmt);
	}
	function deleteStatusPrepare_unum() {
		$SQL = "update ".$this->getTable();
		$SQL .= " SET active=:active";
		$SQL .= " WHERE unum=:unum";
		return $this->preparation($SQL);
	}
	function deleteStatus_unum($stmt,$id) {
		$this->bind($stmt,'active',0);
		$this->bind($stmt,'unum',$id);
		return $this->change($stmt);
	}
//--------

	function getObjListSort($stmt,$nums) {
		/**$nums=$sid=>$ordernum**/
		$list=array();
		while($obj = $stmt->fetchObject()) {
			if(!isset($list[$nums[$obj->sid]])) {
				$list[$nums[$obj->sid]] = $obj;
			}else{
				$i=$nums[$obj->sid];
				$isset=TRUE;
				while($isset) {
					$i++;
					if(!isset($list[$i])) {
						$list[$i]=$obj;
						$isset=FALSE;
					}
				}
			}
		}
		ksort($list);
		return $list;
	}
	function getObjListGid($stmt) {
		$this->cont_count=0;
		$list=array();
		while($obj = $stmt->fetchObject()) {
			$list[$obj->gid][] = $obj;
			$this->cont_count++;
		}
		ksort($list);
		return $list;
	}
//------------------------
	function checkAuth(){
		if ( isset($_REQUEST['login']) ) {
			return $this->login( $_REQUEST['login_id'], $_REQUEST['login_pwd'],1);
		}else if(isset($_REQUEST['logout']) ) {
			return $this->logout();
		}else{
			if ( isset($_REQUEST['logout']) ) {
				return $this->logout();
			}else if($this->authInfo){
				return $this->login( $this->authInfo->loginid, $this->authInfo->loginpwd);
			}else{
				return FALSE;
			}
		}
	}
	function login( $id, $pwd, $crypt=false ) {
		#$authInfo=$this->auth_login( $id, $pwd );
		$ret=$this->auth_login( $id, $pwd,$crypt );
		$this->setUserName($id);

		if($this->authInfo) {
			$_SESSION['name'] = $this->getUserName();
			$_SESSION['authInfo'] = $this->authInfo;
			if($ret){
				return TRUE;
			}
		}
		return FALSE;
	}
	function logout(){
		$_SESSION = array();
		session_destroy();
		return FALSE;
	}
	function auth_login( $id, $pwd,$crypt=false ) {
		$this->statusMessage = null;
		if ( $id AND $pwd ) {
			try {
				$SQL = "SELECT * FROM {$this->_table_user} WHERE loginid=:loginid";
				$SQL .= " AND active=:active";
				$stmt = $this->preparation($SQL);
				$this->bind($stmt,array('loginid'=>$id,'active'=>1));
				$ret = $this->change($stmt);
				$this->authInfo = $stmt->fetchObject();
			}catch (PDOException $e){
				$this->statusMessage = $this->systemErrorMessage;
				return false;
			}
		}
		if($this->authInfo){
			if($crypt){
				if (crypt($pwd,$this->authInfo->loginpwd) == $this->authInfo->loginpwd) {
					return true;
				}
			}else{
				if($pwd==$this->authInfo->loginpwd){
					return true;
				}
			}
		}
		$this->statusMessage = $this->loginErrorMessage;
		return false;
	}

	function setUserName($name){
		$this->userName = $name;
	}

	function setName($name_sei, $name_mei){
		$this->name_sei = $name_sei;
		$this->name_mei = $name_mei;
	}

	function getUserName(){
		return $this->userName;
	}

	function getUserNum(){
		if($this->authInfo){
			return $this->authInfo->sid;
		}
		return 0;
	}

	function accountLogWrite($str=NULL,$mode=0){
		if(isset($_SERVER["HTTP_X_FORWARDED_FOR"])){
			$ip=$_SERVER["HTTP_X_FORWARDED_FOR"];
		}else{
			$ip=$_SERVER["REMOTE_ADDR"];
		}
		if(isset($_SERVER["HTTP_REFERER"])){
			$ref=$_SERVER["HTTP_REFERER"];
		} else {
			$ref=NULL;
		}

		$SQL = "insert into ".$this->_table_log;
		$SQL .= " (ipaddress,port,agent,reffer,script,name,filler,intime) values ";
		$SQL .= " (:ipaddress,:port,:agent,:reffer,:script,:name,:filler,:intime)";
		$stmt=$this->preparation($SQL);

		$this->bind($stmt,'ipaddress',$ip);
		$this->bind($stmt,'port',$_SERVER["REMOTE_PORT"]);
		$this->bind($stmt,'agent',$_SERVER["HTTP_USER_AGENT"]);
		$this->bind($stmt,'reffer',$ref);
		$this->bind($stmt,'script',$_SERVER["SCRIPT_NAME"]);
		$this->bind($stmt,'name',$_SESSION["name"]);
		$this->bind($stmt,'filler',$str);
		$this->bind($stmt,'intime',$this->nowTime());
		return $this->change($stmt);
	}

//<-start for tsuruha site method
	function getUsers() {
		$list=array();
		$SQL = "SELECT * FROM ".$this->_table_user." WHERE active=1";
		$stmt = $this->search($SQL);
		while($obj = $stmt->fetchObject()) {
			$list[$obj->sid]=$obj->name;
		}
		return $list;
	}

	function getAplUserListCount() {
			$sql = "SELECT ";
			$sql .= " COUNT(*) cnt ";
			$sql .= "FROM ";
			$sql .= $this->_table_user."  ";
			$sql .= "WHERE ";
			$sql .= "   active = 1 ";
			$list = $this->getObjList($this->search($sql));
			if (!empty($list)) {
					return $list[0]->cnt;
			}
			return false;
	}

	function uploadOneFile($file,$iid){
		if(empty($file["name"][$iid]) OR !file_exists($file['tmp_name'][$iid])){
			return null;
		}

		$ext = $this->getFileExtension($file['tmp_name'][$iid]);
		if(empty($ext)){
			$ext = '.'.pathinfo($file['name'][$iid],PATHINFO_EXTENSION);
		}
		$name = pathinfo($file['name'][$iid],PATHINFO_FILENAME);
		$un=$name;
		$name .= $ext;
		$path = rtrim($this->_upfileDir,'/').'/'.$name;
		$this->makeDirs($this->_upfileDir);
		if (FALSE == move_uploaded_file($file["tmp_name"][$iid],$path)) {
			$this->errDisp($file["error"][$iid]);
		}
		chmod($path,0666);
		return $name;
	}

	function getFileExtension($filepath){
		if(empty($filepath) OR !file_exists($filepath)){
			return null;
		}
		$ext=null;
		switch(exif_imagetype($filepath)){
		case IMAGETYPE_GIF:
			$ext='.gif';
			break;
		case IMAGETYPE_JPEG:
			$ext='.jpg';
			break;
		case IMAGETYPE_PNG:
			$ext='.png';
			break;
		case IMAGETYPE_BMP:
			$ext='.bmp';
			break;
		default:
			$tmp = pathinfo($filepath);
			if(!empty($tmp['extension'])){
				$ext='.'.$tmp['extension'];
			}
		}
		return $ext;
	}

	//creates directory tree recursively
		function makeDirs($strPath,$mode=0755) {
			return is_dir($strPath) or ($this->makeDirs(dirname($strPath),$mode) and mkdir($strPath,$mode));
		}

		function filecheck($filename,$nums=array(0,0),$filepath=null){
			if(empty($filename)){return false;}
			$path=rtrim($this->_upfileDir,'/').'/';
			if(file_exists($path.$filename)){
				$ext=$this->getFileExtension($path.$filename);
				if(empty($ext)){
					$ext = '.'.pathinfo($path.$filename,PATHINFO_EXTENSION);
				}
				$newfile=sprintf("%04d-%02d-%s",$nums[0],$nums[1],date("YmdHis"));
				$newfile.=$ext;
				if(!empty($filepath)){
					$newpath=rtrim($filepath,'/').'/';
				}else{
					$newpath=$path;
				}

				$this->makeDirs($newpath);
				$ret=rename($path.$filename,$newpath.$newfile);
				if($ret){
					chmod($newpath.$newfile,0666);

					//横長画像は横360に、縦長画像は縦240にリサイズ
					//$newpath = $this->resize($newpath.$newfile,360,240);
					//$newfile=pathinfo($newpath,PATHINFO_BASENAME);
					return $newfile;
				}
			}
			return $filename;
		}

//->hattam 20130722 for debug
	function trace($buf){
		if (empty($this->_logfile)) {return;}
		$fp = fopen($this->_logfile,"a");
		if ($fp) {
			if (is_string($buf)) {
				fwrite($fp,date("[Y/m/d H:i:s]").$buf."\n");
			} else {
				fwrite($fp,date("[Y/m/d H:i:s]").var_export($buf,TRUE)."\n");
			}
		}
		fclose($fp);
	}
//<-hattam
}
?>
