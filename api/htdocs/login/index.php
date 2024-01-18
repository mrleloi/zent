<?php
require_once 'accountClass.php';

$_info = new account();
// require_once 'infoAplPushNotificationClass.php';
require_once 'systemConfig.php';
require_once 'jwt.php';
$dbReference = new systemConfig();

// $_push_notification = new infoAplPushNotification();
$resultSet = array();

// $token = $dbReference->getBearerToken();
$_create = $_GET["register"];

if(isset($_create)&&empty($_create)){

} else {
  $loginid = $_POST['login_id'];

  $loginpwd = $_POST['login_pwd'];

  $resultSet = $_info->auth_login($loginid,$loginpwd,true);

  if($resultSet){
    $token = array();
    $token["login_id"] = $loginid;
    $token["login_pwd"] = $loginpwd;
    $token["random"] = bin2hex(openssl_random_pseudo_bytes(16));
    $jsonwebtoken = JWT::encode($token, "secret_key");
    $stmt = $_info->update_tokenPrepare();
    $_info->bind($stmt,'sid',$_info->authInfo->sid);
    $Ret = $_info->update_token($stmt,$jsonwebtoken);
    $dbReference->sendResponse(200,'[{"success_message":'.json_encode($resultSet).',"token":'.json_encode($jsonwebtoken).',"sid":'.json_encode($_info->authInfo->sid).'}]');
  } else {
    $dbReference->sendResponse(200,'[{"error_message":'.json_encode($dbReference->getStatusCodeMeeage(400)).'}]');
  }
}

// var_dump($token);
// if(isset($_POST['sid'])){
//
//   $sid = $_POST['sid'];
//
//   $resultSet = $_info->getContent($sid);
//
//   // var_dump($resultSet);
//
//   if($resultSet == null){
//
//     $dbReference->sendResponse(200,'[{"error_message":'.json_encode($dbReference->getStatusCodeMeeage(204)).'}]');
//
//   } else {
//
//     $dbReference->sendResponse(200,''.json_encode($resultSet).'');
//
//   }
//
// }
// else
// {
//   $dbReference->sendResponse(200,'[{"error_message":'.json_encode($dbReference->getStatusCodeMeeage(400)).'}]');
// }

?>
