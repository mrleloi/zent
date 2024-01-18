<?php
include(__DIR__.'/../conf.php');
$TITLE = $thisPage->site_title;
$thisPage->page_title = "お知らせ新規";
$thisPage->head_title = "【お知らせシステム】".$thisPage->page_title." - ".$TITLE;

$sess_key = "pushnotification";

require_once 'infoAplPushNotificationClass.php';
$_push_notification = new infoAplPushNotification();

$afconf = array(
    1 => array(
        'title' => '種類',
        'need'=>1,
        'check' => 'select',
        'help' => 0,
        'maxlength' => 0),
    2 => array(
        'title' => 'タイトル',
        'need'=>1,
        'check' => 'str',
        'help' => 0,
        'maxlength' => 100),
    3 => array(
        'title' => 'ボディー',
        'need' => 1,
        'check' => 'str',
        'help' => 0,
        'maxlength' => 100),
    4 => array(
        'title' => '時間配達',
        'need' => 0,
        'check' => 'select',
        'help' => 0,
        'maxlength' => 0),
    5 => array(
        'title' => 'ステータス',
        'need' => 1,
        'check' => 'select',
        'help' => 0,
        'maxlength' => 0),
        );
