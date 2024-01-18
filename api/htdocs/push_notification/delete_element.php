<?php
require_once 'infoAplPushNotificationClass.php';
$_apl_push_notification = new infoAplPushNotification();
$sid = $_POST['sid'];
$resultSet = $_apl_push_notification->deleteAplPushNotification($sid);
if($resultSet&&(count($_POST) == 1)){
  $dbReference->sendResponse(200,'[{"success_message":'.json_encode($resultSet).'}]');
} else {
  $dbReference->sendResponse(200,'[{"error_message":'.json_encode($dbReference->getStatusCodeMeeage(400)).'}]');
}
?>
