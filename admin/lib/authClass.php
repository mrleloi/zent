<?php
require_once 'authBaseClass.php';

class auth extends authBase {

	private $loginPanel; // if loginPanel is empty then execute parent's authentication

	function __construct($dsn,$authTable,$dbuser=null,$dbpasswd=null) {
		$this->loginPanel = null;
		$this->authInfo=null;
		if(isset($_SESSION['authInfo'])){
			$this->authInfo = $_SESSION['authInfo'];
		}

		parent::__construct($dsn,$authTable,$dbuser,$dbpasswd);
	}

	function login($id,$pwd){
		parent::login($id,$pwd);
		$_SESSION['authInfo'] = $this->authInfo;
		$this->setLoginId($id);
	}

	function logout(){
		$this->authInfo=null;
		$_SESSION = array();
		@session_destroy();
		if($this->loginPanel){
			$this->loginPanel();
		}else{
			parent::logOut();
		}
	}

	function setLoginPanel($loginPanel){
		$this->loginPanel = $loginPanel;
		return $this;
	}

	function loginPanel(){
		if($this->loginPanel){
			extract($GLOBALS);
			unset($_SESSION['authInfo']);
			require($this->loginPanel);
			die();
		}else{
			parent::loginPanel();
		}
	}

	function setAuthInfo($authInfo) {
		$this->authInfo = $authInfo;
		$_SESSION['authInfo'] = $this->authInfo;
	}

	function getAuthInfo($key=null) {
		if(empty($key)){return $this->authInfo;}
		if(empty($this->authInfo->{$key})){return false;}
		return $this->authInfo->{$key};
	}

	function checkLogin(){
		if(!isset($_SESSION['authInfo'])){
			parent::checkLogin();
		}
	}

	function checkAuth() {
		if(isset($_REQUEST['login'])){
			$this->login($_REQUEST['login_id'],$_REQUEST['login_pwd']);
			$_SESSION['name'] = $this->getLoginId();
			$this->unsetRequest('login');
			$this->unsetRequest('login_id');
			$this->unsetRequest('login_pwd');
		}else if(isset($_REQUEST['logout'])){
			$this->unsetRequest('logout');
			$this->logout();
		}else if(isset($_SESSION['uname'])){
			$this->getAuthInfo($_SESSION['uname']);
		}else{
			parent::checkAuth();
		}
	}

	function getUserKind() {
		return $this->getAuthInfo('u_kind');
	}
}
?>
