<?php
require_once 'infoTrainingClass.php';
$_training = new infoTraining();
$resultSet = $_training->getTrainingList();
if($resultSet&&(count($_POST) == 0)){
  $dbReference->sendResponse(200,''.json_encode($resultSet).'');
} else {
  $dbReference->sendResponse(200,'[{"error_message":'.json_encode($dbReference->getStatusCodeMeeage(400)).'}]');
}
?>
