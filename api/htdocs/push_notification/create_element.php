<?php
require_once 'infoAplPushNotificationClass.php';
$_apl_push_notification = new infoAplPushNotification();
$title = $_POST['title'];
$body = $_POST['body'];
$time_delivery = $_POST['time_delivery'];
$cstatus = $_POST['status'];
$resultSet = $_apl_push_notification->insertAplPushNotification($title,$body,$time_delivery,$cstatus);
if($resultSet&&((count($_POST) == 4))){
  $dbReference->sendResponse(200,'[{"success_message":'.json_encode($resultSet).'}]');
} else {
  $dbReference->sendResponse(200,'[{"error_message":'.json_encode($dbReference->getStatusCodeMeeage(400)).'}]');
}
?>
