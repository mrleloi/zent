<?php
include(__DIR__.'/../conf.php');
$TITLE = $thisPage->site_title;
$thisPage->page_title = "トレーニング新規";
$thisPage->head_title = "【トレーニングシステム】".$thisPage->page_title." - ".$TITLE;

$sess_key = "training_edit";

require_once 'infoTrainingClass.php';

$_training = new infoTraining();

// require_once 'infoUserProfileClass.php';
// $user_profile = new infoUserProfile();

$_upfile = $_training;

$afconf = array(
    1 => array(
        'title' => 'タイトル',
        'need' => 1,
        'check' => 'str',
        'help' => 0,
        'maxlength' => 100),
    2 => array(
        'title' => 'アバター',
        'need'=>1,
        'check' => 'image',
        'help' => 0,
        'maxlength' => 100),
    3 => array(
        'title' => '内容',
        'need'=>1,
        'check' => 'str',
        'help' => 0,
        'maxlength' => 1000000000000000),
    4 => array(
        'title' => 'アップローダー',
        'need'=>1,
        'check' => 'str',
        'help' => 0,
        'maxlength' => 100),
    5 => array(
        'title' => '動画',
        'need' => 1,
        'check' => 'number',
        'help' => 0,
        'maxlength' => 30),
        );
