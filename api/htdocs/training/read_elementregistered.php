<?php
require_once 'infoTrainingClass.php';
$_training = new infoTraining();
$user_id = $_POST['user_id'];
$video_id = $_POST['video_id'];
$resultSet = $_training->getTrainingregisteredList($video_id,$user_id);
if($resultSet&&(count($_POST) == 2)){
  $dbReference->sendResponse(200,''.json_encode($resultSet).'');
} else {
  $dbReference->sendResponse(200,'[{"error_message":'.json_encode($dbReference->getStatusCodeMeeage(400)).'}]');
}
?>
