<?php
require_once 'infoMovieClass.php';
$_movie = new infoMovie();
$sid = $_POST['sid'];
$resultSet = $_movie->deleteVideo($sid);
if($resultSet&&(count($_POST) == 1)){
  $dbReference->sendResponse(200,'[{"success_message":'.json_encode($resultSet).'}]');
} else {
  $dbReference->sendResponse(200,'[{"error_message":'.json_encode($dbReference->getStatusCodeMeeage(400)).'}]');
}
?>
