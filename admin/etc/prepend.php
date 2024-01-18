<?php
//ini_set('display_errors',1);
//error_reporting(-1);


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
require_once 'define.php';

//--------------------------------
// include site's configuration files
require_once 'db_config.php';
require_once 'config.php';

//--------------------------------
// include common libraries
require_once 'formlib.php';
require_once 'commonlib.php';

//--------------------------------
// initialize

//--------------------------------
// authentication
if ($thisPage->developOnly()) {
	//require_once 'basicAuth.php';
}
include 'prepend_auth.php';
