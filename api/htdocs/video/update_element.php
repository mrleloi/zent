<?php
require_once 'infoMovieClass.php';
$_movie = new infoMovie();
$sid = $_POST['sid'];
$title = $_POST['title'];
$url = $_POST['url'];
$description = $_POST['description'];
$duration = $_POST['duration'];
$thumbnail_small = $_POST['thumbnail_small'];
$thumbnail_large = $_POST['thumbnail_large'];
$uploader = $_POST['uploader'];
$resultSet = $_apl_push_notification->updateVideo($sid,$title,$url,$description,$duration,$thumbnail_small,$thumbnail_large,$uploader);
if($resultSet&&(count($_POST) == 8)){
  $dbReference->sendResponse(200,'[{"success_message":'.json_encode($resultSet).'}]');
} else {
  $dbReference->sendResponse(200,'[{"error_message":'.json_encode($dbReference->getStatusCodeMeeage(400)).'}]');
}
?>
