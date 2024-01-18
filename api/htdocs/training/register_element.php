<?php
require_once 'infoTrainingregisterClass.php';
$_trainingregister = new infoTrainingregister();
$training_id = $_POST['training_id'];
$user_id = $_POST['user_id'];
$resultSet = $_trainingregister->insertTrainingregister($user_id,$training_id);
if($resultSet&&(count($_POST) == 2)){
  $dbReference->sendResponse(200,'[{"success_message":'.json_encode($resultSet).'}]');
} else {
  $dbReference->sendResponse(200,'[{"error_message":'.json_encode($dbReference->getStatusCodeMeeage(400)).'}]');
}
?>
