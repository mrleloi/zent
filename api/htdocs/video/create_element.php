<?php
require_once 'infoMovieClass.php';
$_movie = new infoMovie();
$title = $_POST['title'];
$url = $_POST['url'];
$description = $_POST['description'];
$duration = $_POST['duration'];
$thumbnail_small = $_POST['thumbnail_small'];
$thumbnail_large = $_POST['thumbnail_large'];
$uploader = $_POST['uploader'];
$resultSet = $_movie->insertVideo($title,$url,$description,$duration,$thumbnail_small,$thumbnail_large,$uploader);
if($resultSet&&((count($_POST) == 7))){
  $dbReference->sendResponse(200,'[{"success_message":'.json_encode($resultSet).'}]');
} else {
  $dbReference->sendResponse(200,'[{"error_message":'.json_encode($dbReference->getStatusCodeMeeage(400)).'}]');
}
?>
