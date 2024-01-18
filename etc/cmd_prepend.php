<?php

	$myHostname = getenv("HOST");
	if(empty($myHostname)){
		$myHostname = `hostname`;
		$myHostname = rtrim($myHostname);
	}
	// if hostname starts with 'ip', it is DEVELOP site.
	if(strpos($myHostname,'ip')===0){
		$develop = true;
	}else{
		$develop = false;
	}
	//
	// if($develop OR (isset($argv[1]) && $argv[1] == "develop")){
	// 	$_SERVER["DEVELOP_SITE"]	= 1;
	// 	$_SERVER["TEST_SITE"]		= 0;
	// 	$_SERVER["SERVICE_SITE"]	= 0;
	// 	$SERVER_NAME  = "tut.canvas-works.info";
	 	$_SERVER['ENVFROM_MAIL']	= 'verp-test-tut@canvas-works.info';
	// 	$_SERVER['NOT_REPLY_MAIL']	= 'do_not_reply@tulip-tv.co.jp';
	// }else{
	// 	$_SERVER["DEVELOP_SITE"]	= 0;
	// 	$_SERVER["TEST_SITE"]		= 0;
	// 	$_SERVER["SERVICE_SITE"]	= 1;
	// 	$SERVER_NAME  = "www.tulib-tv.co.jp";
	// 	$_SERVER['ENVFROM_MAIL']	= 'verp@tulip-tv.co.jp';
	// 	$_SERVER['NOT_REPLY_MAIL']	= 'do_not_reply@tulip-tv.co.jp';
	// }
	//
	// error_reporting(-1);
	// ini_set('display_errors','On');
	//
//	if($develop OR (isset($argv[1]) && $argv[1] == "develop")){
	 	define("TOP_SYSDIR", "/home/happy-club.tv");
//	}else{
//		define("TOP_SYSDIR", "/data/www/data/tw");
//	}

	// $_SERVER['top_path']		= null;
	// $_SERVER['sys_dir']			= TOP_SYSDIR.'/';
	// $_SERVER['var_dir']			= TOP_SYSDIR.'/var/';
	$_SERVER['tmp_dir']			= TOP_SYSDIR.'/tmp/';
	// $_SERVER['log_dir']			= TOP_SYSDIR.'/log/';
	// $_SERVER['cache_dir']		= TOP_SYSDIR.'/cache/';
	//
	// $REPLICA_SERVER = NULL;
	// if(!empty($_SERVER['REPLICA_SERVER'])){
	// 	$REPLICA_SERVER=explode(' ',$_SERVER['REPLICA_SERVER']);
	// }

 require_once (__DIR__.'/../lib/pageClass.php');
	$thisPage = new page();
require_once (__DIR__.'/../lib/utilClass.php');
	$_util = new util();
	require_once 'db_config.php';

	$thisPage->site_mode = 'admin';
	$thisPage->setDb_config($DB_CONFIG);

	$thisPage->sys_dir=TOP_SYSDIR.'/';
	require_once 'cmd_config.php';
?>
