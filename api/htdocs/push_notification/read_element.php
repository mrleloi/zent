<?php
require_once 'infoAplPushNotificationClass.php';
$_apl_push_notification = new infoAplPushNotification();
$resultSet = $_apl_push_notification->getAplPushNotificationList();
if($resultSet&&(count($_POST) == 0)){
  $dbReference->sendResponse(200,''.json_encode($resultSet).'');
} else {
  $dbReference->sendResponse(200,'[{"error_message":'.json_encode($dbReference->getStatusCodeMeeage(400)).'}]');
}
?>
