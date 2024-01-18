<?php

class authBase{
	protected $dsn;
	protected $dbuser;
	protected $dbpasswd;
	protected $authTable;
	protected $authInfo;
	protected $loginErrorMessage = "Login Error";
	protected $systemErrorMessage = "PDO error";
	protected $statusMessage;
	protected $realm = "Authentication";
	protected $loginid;
	protected $userName;
	protected $name_sei;
	protected $name_mei;

	function __construct($dsn,$authTable,$dbuser=null,$dbpasswd=null) {
		$this->dsn = $dsn;
		$this->authTable = $authTable;
		$this->dbuser = $dbuser;
		$this->dbpasswd = $dbpasswd;
	}

	function login($id,$pwd) {
		if(!empty($id) AND !empty($pwd)){
			try{
				$this->dbh = new PDO($this->dsn,$this->dbuser,$this->dbpasswd);
				$this->dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
				$this->dbh->query('SET NAMES binary');

				$sql = "SELECT * FROM {$this->authTable}";
				$sql .= " WHERE loginid=:loginid AND active=1";
				$stmt = $this->dbh->prepare($sql);
				$stmt->bindValue(':loginid',$id);
				try{
					$stmt->execute();
				}catch (Exception $e){
                    var_dump($e);
				}
				$this->authInfo = $stmt->fetchObject();
				$this->name_sei = $stmt->authInfo->name_sei;
				$this->name_mei = $stmt->authInfo->name_mei;
				$this->statusMessage = null;
			}catch (PDOException $e){
				$this->statusMessage = $this->systemErrorMessage;
				$this->loginPanel();
			}
		}
		if($this->authInfo){
			echo $this->authInfo->loginpwd;die();
			if(!$this->authInfo->loginpwd){
				$this->statusMessage = $this->loginErrorMessage;
				$this->loginPanel();
			}else if(!$this->password_check($pwd)){
					$this->statusMessage = $this->loginErrorMessage;
					$this->loginPanel();
			}
		}else{
			$this->statusMessage = $this->loginErrorMessage;
			$this->loginPanel();
		}
		return $this;
	}

	function password_check($pwd){
		return password_verify($pwd, $this->authInfo->loginpwd);
	}

	function loginPanel(){
		header("WWW-Authenticate: Basic realm=\"{$this->realm}\"");
		header("HTTP/1.0 401 Unauthorized");
		die();
	}

	function logout(){
		header("WWW-Authenticate: Basic realm=\"". $this->realm ."\"");
		header("HTTP/1.0 401 Unauthorized");
		header("Location: http://" . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'] );
		die();
	}

	function checkLogin(){
		$this->loginPanel();
	}

	function checkAuth(){
		if(isset($_REQUEST['logout'])){
			$this->unsetRequest('logout');
			$this->logout();
		// }else if(isset($_SERVER['PHP_AUTH_USER'])){
		// 	$this->login($_SERVER['PHP_AUTH_USER'],$_SERVER['PHP_AUTH_PW']);
		}else{
			$this->checkLogin();
		}
	}

	function setRealm($realm){
		$this->realm = $realm;
		return $this;
	}

	function setLoginErrorMessage($message){
		$this->loginErrorMessage = $message;
		return $this;
	}

	function setSystemErrorMessage($message){
		$this->systemErrorMessage = $message;
		return $this;
	}

	function getStatusMessage(){
		return $this->statusMessage;
	}
	function setStatusMessage($message){
		$this->statusMessage = $message;
	}

	function setLoginId($name){
		$this->loginid = $name;
	}

	function getLoginId(){
		return $this->loginid;
	}

	function setUserName($name){
		$this->userName = $name;
	}

	function getUserName(){
		return $this->userName;
	}

	function setName($name_sei, $name_mei){
		$this->name_sei = $name_sei;
		$this->name_mei = $name_mei;
	}
	function getName(){
		return $this->name_sei.$this->name_mei;
	}

	function unsetRequest($key){
		unset($_REQUEST[$key]);
		unset($_POST[$key]);
	}

}

?>
