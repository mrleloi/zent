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
	protected $sid;

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
				$sql .= " WHERE loginid=:loginid";
				$stmt = $this->dbh->prepare($sql);
				$stmt->bindValue(':loginid',$id);
				try{
					$stmt->execute();
				}catch (Exception $e){
                    var_dump($e);
				}
				$this->authInfo = $stmt->fetchObject();
				$this->statusMessage = null;
			}catch (PDOException $e){
				$this->statusMessage = $this->systemErrorMessage;
				$this->loginPanel();
			}
		}
		echo "02";
		// var_dump(crypt($pwd,$this->authInfo->loginpwd));
		if($this->authInfo){
			if(!$this->authInfo->loginpwd){
				echo "03";
				$this->statusMessage = $this->loginErrorMessage;
				$this->loginPanel();
			}else if(!hash_equals($this->authInfo->loginpwd,crypt($pwd,$this->authInfo->loginpwd))){
				echo "04";
				$this->statusMessage = $this->loginErrorMessage;
				$this->loginPanel();
			}
			// $token = array();
			// $token["login_id"] = $id;
      // $token["login_pwd"] = $pwd;
			// $jsonwebtoken = JWT::encode($token, "secret_key");
			// $user_profile = new account();
			// $stmt = $user_profile->update_tokenPrepare();
			// $user_profile->bind($stmt,'sid',$this->authInfo->sid);
			// $Ret = $user_profile->update_token($stmt,$jsonwebtoken);
			echo "05";
		}else{
			echo "06";
			$this->statusMessage = $this->loginErrorMessage;
			$this->loginPanel();
		}
		return $this;
	}

	function loginPanel(){
		header("WWW-Authenticate: Basic realm=\"{$this->realm}\"");
		header("HTTP/1.0 401 Unauthorized");
		die();
	}

	function logout(){
		echo "11111";
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
		}else if(isset($_SERVER['PHP_AUTH_USER'])){
			$this->login($_SERVER['PHP_AUTH_USER'],$_SERVER['PHP_AUTH_PW']);
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

	function unsetRequest($key){
		unset($_REQUEST[$key]);
		unset($_POST[$key]);
	}

}

?>
