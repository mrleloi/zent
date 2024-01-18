<?php
    if (!defined('TB_ACCOUNT_USER')) {
        define("TB_ACCOUNT_USER","account_user");
    }
    if (!defined('TB_ACCOUNT_LOG')) {
        define("TB_ACCOUNT_LOG","account_log");
    }
    if (!defined('TB_ACCOUNT_ALLOW')) {
        define("TB_ACCOUNT_ALLOW","account_allow");
    }
    if (!defined('TB_ACCOUNT_URL')) {
        define("TB_ACCOUNT_URL","account_url");
    }
    if (!defined('TB_ACCOUNT_URLMAP')) {
        define("TB_ACCOUNT_URLMAP","account_urlmap");
    }

    $dbname = 'zent';
    $dbuser = 'root';
    $dbpass = '';

	$DB_CONFIG = array(
		'master' => array(
			'type'=> 'mysql',
			'host' => 'localhost',
			'port' => 3306,
			'user' => $dbuser,
			'passwd' => $dbpass,
			'name' => $dbname,
			),
		'slave' => array(
			'type'=> 'mysql',
			'host' => 'localhost',
			'port' => 3306,
			'user' => $dbuser,
			'passwd' => $dbpass,
			'name' => $dbname,
			),
		'auth_master' => array(
			'type'=> 'mysql',
			'host' => 'localhost',
			'port' => 3306,
			'user' => $dbuser,
			'passwd' => $dbpass,
			'name' => $dbname,
			),
		'auth_slave' => array(
			'type'=> 'mysql',
			'host' => 'localhost',
			'port' => 3306,
			'user' => $dbuser,
			'passwd' => $dbpass,
			'name' => $dbname,
			),
		);

//for auth_access Class
    if (!defined('DBDSN_AUTH_MASTER')) {
        define("DBDSN_AUTH_MASTER","mysql:host=".$DB_CONFIG['auth_master']['host'].";port=".$DB_CONFIG['auth_master']['port'].";dbname=".$DB_CONFIG['auth_master']['name']);
    }
    if (!defined('DBUSER_AUTH')) {
        define("DBUSER_AUTH",$DB_CONFIG['auth_master']['user']);
    }
    if (!defined('DBPASSWD_AUTH')) {
        define("DBPASSWD_AUTH",$DB_CONFIG['auth_master']['passwd']);
    }


?>
