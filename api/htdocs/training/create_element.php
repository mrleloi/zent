<?php
require_once 'infoTrainingClass.php';
$_training = new infoTraining();
$title = $_POST['title'];
$avatar = $_POST['avatar'];
$description = $_POST['description'];
$uploader = $_POST['uploader'];
$video_id = $_POST['video_id'];
$user_id = $_POST['user_id'];
$resultSet = $_training->insertTraining($title,$avatar,$description,$uploader,$video_id,$user_id);
if($resultSet&&((count($_POST) == 6))){
  $dbReference->sendResponse(200,'[{"success_message":'.json_encode($resultSet).'}]');
} else {
  $dbReference->sendResponse(200,'[{"error_message":'.json_encode($dbReference->getStatusCodeMeeage(400)).'}]');
}
?>
