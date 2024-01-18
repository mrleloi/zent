<?php
//--------------------------------
// initialize session
	session_start();

//--------------------------------
// initialize global object
	require_once 'pageClass.php';
	$thisPage = new page();

	require_once 'utilClass.php';
	$_util = new util();
	
//--------------------------------
// include global defines

//--------------------------------
// include site's configuration files
	require_once 'db_config.php';
	require_once 'config.php';
	require_once 'define.php';
	// require_once 'cmd_config.php';

//--------------------------------
// include common libraries
	require_once 'formlib.php';
	require_once 'commonlib.php';

//--------------------------------
// initialize

//--------------------------------
// authentication
//	include 'prepend_auth.php';
?>
