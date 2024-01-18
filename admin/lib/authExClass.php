<?php
require_once 'authBaseClass.php';
require_once 'jwt.php';
require_once 'accountClass.php';
define('AUTH_KIND_ADMIN',1);

class authEx extends authBase {

	function __construct($dsn,$authTable,$dbuser=null,$dbpasswd=null) {
		if(isset($_SESSION['admin']['authInfo'])){
			$this->authInfo = $_SESSION['admin']['authInfo'];
		}

		parent::__construct($dsn,$authTable,$dbuser,$dbpasswd);
	}

	function login($id,$pwd){
		parent::login($id,$pwd);
		$_SESSION['admin']['authInfo'] = $this->authInfo;
		$this->setLoginId($id);
	}

	function getUserName() {
		if(isset($this->authInfo->name)){
			return $this->authInfo->name;
		}
		return null;
	}

	function isAdmin(){
		if(!isset($this->authInfo->u_kind)){
			return false;
		}
		if(AUTH_KIND_ADMIN == $this->authInfo->u_kind){
			return true;
		}
		return false;
	}
	function isShopAdmin(){
		if (isAdmin()) {
			return true;
		}
		if(!isset($this->authInfo->u_kind)){
			return false;
		}
		return false;
	}

	function setLoginPanel($loginPanel){
		$this->loginPanel = $loginPanel;
		//echo $this->loginPanel;
		return $this;
	}

	function loginPanel(){
		if($this->loginPanel){
			extract($GLOBALS);
			unset($_SESSION['admin']['authInfo']);
			//echo $this->loginPanel;
			require($this->loginPanel);
			die();
		}else{
			parent::loginPanel();
		}
	}

	function checkAuth() {
		// var_dump($_REQUEST['login']);
		if(isset($_REQUEST['login'])){
			$this->login($_REQUEST['login_id'],$_REQUEST['login_pwd']);
			$_SESSION['name_admin'] = $this->getLoginId();
			// $token = array();
			// $token["login_id"] = $id;
      // $token["login_pwd"] = $pwd;
			// $token["random"] = bin2hex(openssl_random_pseudo_bytes(16));
			// $jsonwebtoken = JWT::encode($token, "secret_key");
			// $user_profile = new account();
			// $stmt = $user_profile->update_tokenPrepare();
			// $user_profile->bind($stmt,'sid',$this->authInfo->sid);
			// $Ret = $user_profile->update_token($stmt,$jsonwebtoken);
			$this->unsetRequest('login');
			$this->unsetRequest('login_id');
			$this->unsetRequest('login_pwd');
		}else if(isset($_REQUEST['logout'])){
			$this->unsetRequest('logout');
			$this->logout();
		}else if(isset($_SESSION['name_admin'])){
			$this->getAuthInfo($_SESSION['name_admin']);
		}else{
			parent::checkAuth();
		}
	}

	function logout(){
		$this->authInfo=null;
		unset($_SESSION['admin']['authInfo']);
		unset($_SESSION['name_admin']);
		if($this->loginPanel){
			$this->loginPanel();
		}else{
			parent::logOut();
		}
	}

	function setAuthInfo($authInfo) {
		$this->authInfo = $authInfo;
		$_SESSION['admin']['authInfo'] = $this->authInfo;
	}

	function getAuthInfo($key=null) {
		if(empty($key)){return $this->authInfo;}
		if(empty($this->authInfo->{$key})){return false;}
		return $this->authInfo->{$key};
	}

	function checkLogin(){
		if(!isset($_SESSION['admin']['authInfo'])){
			parent::checkLogin();
		}
	}

	function getUserKind() {
		return $this->getAuthInfo('u_kind');
	}

	function alreadyck_loginid($no) {
		if(empty($no)){return false;}
		$this->setTable(TB_ACCOUNT_USER);
		$this->setSQL_where('sid!='.$sid);
		$this->setSQL_where('active=1');
		$this->setSQL_where('loginid="'.$no.'"');
		return $this->countRecord();
	}
	function countRecord() {
		$SQL = "SELECT count(*) AS cnt FROM ".$this->getTable();
		$SQL .= $this->getSQLparam();
		$stmt = $this->preparation($SQL);
		$stmt = $this->search($SQL);
		$obj = $this->getObjList($stmt);
		if(isset($obj[0]->cnt)){
			return $obj[0]->cnt;
		}
		return 0;
	}
}
?>
