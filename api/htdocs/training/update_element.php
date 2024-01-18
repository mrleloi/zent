<?php
require_once 'infoTrainingClass.php';
$_training = new infoTraining();
$sid = $_POST['sid'];
$title = $_POST['title'];
$avatar = $_POST['avatar'];
$description = $_POST['description'];
$uploader = $_POST['uploader'];
$video_id = $_POST['video_id'];
$resultSet = $_training->updateTraining($sid,$title,$avatar,$description,$uploader,$video_id);
if($resultSet&&(count($_POST) == 6)){
  $dbReference->sendResponse(200,'[{"success_message":'.json_encode($resultSet).'}]');
} else {
  $dbReference->sendResponse(200,'[{"error_message":'.json_encode($dbReference->getStatusCodeMeeage(400)).'}]');
}
?>
