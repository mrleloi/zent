<?php
require_once 'infoTrainingClass.php';
$_training = new infoTraining();
$video_id = $_POST['video_id'];
$resultSet = $_training->getTrainingListByVideoId($video_id);
if($resultSet&&(count($_POST) == 1)){
  $dbReference->sendResponse(200,''.json_encode($resultSet).'');
} else {
  $dbReference->sendResponse(200,'[{"error_message":'.json_encode($dbReference->getStatusCodeMeeage(400)).'}]');
}
?>
