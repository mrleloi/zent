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

  if(isset($_create)&&empty($_create)){
    require_once 'create_element.php';
  } else if(isset($_update)&&empty($_update)){
    require_once 'update_element.php';
  } else if(isset($_delete)&&empty($_delete)){
    require_once 'delete_element.php';
  } else {
    require_once 'read_element.php';
  }
} else {

}

?>
