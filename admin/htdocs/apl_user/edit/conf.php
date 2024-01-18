<?php
include(__DIR__.'/../conf.php');
$TITLE = $thisPage->site_title;
$thisPage->page_title = "ユーザ管理新規";
$thisPage->head_title = "【ユーザ管理システム】".$thisPage->page_title." - ".$TITLE;

$sess_key = "user-edit";

require_once 'accountClass.php';
$_info = new account();

$afconf = array(
    1 => array(
        'title' => 'ログインアカウント',
        'need'=>1,
        'check' => 'str',
        'help' => 0,
        'maxlength' => 100),
    2 => array(
        'title' => 'ログインパスワード',
        'need' => 1,
        'check' => 'str',
        'help' => 0,
        'minlength' => 6,
        'maxlength' => 30),
    3 => array(
        'title' => '氏名',
        'need' => 1,
        'check' => 'str',
        'help' => 0,
        'maxlength' => 100),
    4 => array(
        'title' => '権限',
        'need' => 1,
        'check' => 'select',
        'help' => 0,
        'maxlength' => 0),
        );
