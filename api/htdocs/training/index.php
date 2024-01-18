<?php
require_once 'systemConfig.php';
require_once 'jwt.php';
require_once 'accountClass.php';
$_info = new account();
$dbReference = new systemConfig();
$token = $dbReference->getBearerToken();
$json = JWT::decode($token, "secret_key", true);
$_check = $_info->checkToken($json->login_id,$token);

if(isset($token)&&$_check){

  $_create = $_GET["create"];
  $_update = $_GET["update"];
  $_delete = $_GET["delete"];
  $_register = $_GET["register"];
  $_readbyvideo = $_GET["readbyvideo"];
  $_checkregister = $_GET["check"];
  $_checkregistered = $_GET["registered"];

  if(isset($_create)&&empty($_create)){
    require_once 'create_element.php';
  } else if(isset($_update)&&empty($_update)){
    require_once 'update_element.php';
  } else if(isset($_delete)&&empty($_delete)){
    require_once 'delete_element.php';
  } else if(isset($_register)&&empty($_register)){
    require_once 'register_element.php';
  } else if(isset($_checkregister)&&empty($_checkregister)){
    require_once 'checkregister_element.php';
  } else if(isset($_readbyvideo)&&empty($_readbyvideo)){
    require_once 'read_elementbyvideo.php';
  } else if(isset($_checkregistered)&&empty($_checkregistered)){
    require_once 'read_elementregistered.php';
  } else {
    require_once 'read_element.php';
  }
} else {

}

?>
