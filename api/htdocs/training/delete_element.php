<?php
require_once 'infoTrainingClass.php';
$_training = new infoTraining();
$sid = $_POST['sid'];
$resultSet = $_training->deleteTraining($sid);
if($resultSet&&(count($_POST) == 1)){
  $dbReference->sendResponse(200,'[{"success_message":'.json_encode($resultSet).'}]');
} else {
  $dbReference->sendResponse(200,'[{"error_message":'.json_encode($dbReference->getStatusCodeMeeage(400)).'}]');
}
?>
