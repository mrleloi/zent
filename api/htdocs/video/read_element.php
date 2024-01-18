<?php
require_once 'infoMovieClass.php';
$_movie = new infoMovie();
$resultSet = $_movie->getVideoList();
if($resultSet&&(count($_POST) == 0)){
  $dbReference->sendResponse(200,''.json_encode($resultSet).'');
} else {
  $dbReference->sendResponse(200,'[{"error_message":'.json_encode($dbReference->getStatusCodeMeeage(400)).'}]');
}
?>
