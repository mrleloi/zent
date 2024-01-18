<?php
include(__DIR__.'/../conf.php');
$TITLE = $thisPage->site_title;
$thisPage->page_title = "動画新規";
$thisPage->head_title = "【動画システム】".$thisPage->page_title." - ".$TITLE;

$sess_key = "video_edit";

require_once 'infoMovieClass.php';

$_movie = new infoMovie();

// require_once 'infoUserProfileClass.php';
// $user_profile = new infoUserProfile();

$_upfile = $_movie;

$afconf = array(
    1 => array(
        'title' => 'タイトル',
        'need' => 1,
        'check' => 'str',
        'help' => 0,
        'maxlength' => 100),
    2 => array(
        'title' => 'url',
        'need'=>1,
        'check' => 'video',
        'help' => 0,
        'maxlength' => 100),
    3 => array(
        'title' => '内容',
        'need'=>1,
        'check' => 'str',
        'help' => 0,
        'maxlength' => 100),
    4 => array(
        'title' => '期間',
        'need'=>1,
        'check' => 'time',
        'help' => 0,
        'maxlength' => 100),
    5 => array(
        'title' => 'サムネイル小',
        'need' => 1,
        'check' => 'image',
        'help' => 0,
        'maxlength' => 30),
    6 => array(
        'title' => 'サムネイル大',
        'need' => 1,
        'check' => 'image',
        'help' => 0,
        'maxlength' => 100),
    7 => array(
        'title' => 'アップローダー',
        'need' => 1,
        'check' => 'str',
        'help' => 0,
        'maxlength' => 100),
        );
