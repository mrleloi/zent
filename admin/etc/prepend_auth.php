<?php
	require_once 'config.php';

	$DBHOST = $DB_CONFIG['auth_master']['host'];
	$DBPORT = $DB_CONFIG['auth_master']['port'];
	$DBNAME = $DB_CONFIG['auth_master']['name'];
	$DBUSER = $DB_CONFIG['auth_master']['user'];
	$DBPASSWORD = $DB_CONFIG['auth_master']['passwd'];

//	$DBTABLE_AUTH = 'account_user';
	$DBTABLE_AUTH = TB_ACCOUNT_USER;

	$dsn = "mysql:host={$DBHOST};port={$DBPORT};dbname={$DBNAME}";

	require_once 'authExClass.php';
	$_auth = new authEx($dsn,$DBTABLE_AUTH,$DBUSER,$DBPASSWORD);

//auth
	$_auth->setLoginPanel($LOGIN_PANEL);
	$_auth->setLoginErrorMessage("ログインIDまたはパスワードが違います");
	$_auth->setSystemErrorMessage("現在混雑しております");
	$_auth->checkAuth();
?>
