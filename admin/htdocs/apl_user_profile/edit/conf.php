<?php
include(__DIR__.'/../conf.php');
$TITLE = $thisPage->site_title;
$thisPage->page_title = "会員新規";
$thisPage->head_title = "【会員システム】".$thisPage->page_title." - ".$TITLE;

$sess_key = "user_profile_edit";

require_once 'accountClass.php';

$user_profile = new account();
// require_once 'infoUserProfileClass.php';
// $user_profile = new infoUserProfile();

$_upfile = $user_profile;

$afconf = array(
    1 => array(
        'title' => 'ログインID',
        'need' => 1,
        'check' => 'email',
        'help' => 0,
        'maxlength' => 100),
    2 => array(
        'title' => 'パスワード',
        'need'=>1,
        'check' => 'str',
        'help' => 0,
        'maxlength' => 100),
    3 => array(
        'title' => '役割',
        'need'=>1,
        'check' => 'select',
        'help' => 0,
        'maxlength' => 100),
    4 => array(
        'title' => '名前',
        'need'=>1,
        'check' => 'str',
        'help' => 0,
        'maxlength' => 100),
    5 => array(
        'title' => 'カタカナ',
        'need' => 1,
        'check' => 'katakana',
        'help' => 0,
        'minlength' => 6,
        'maxlength' => 30),
    6 => array(
        'title' => 'アバター',
        'need' => 1,
        'check' => 'image',
        'help' => 0,
        'maxlength' => 100),
    7 => array(
        'title' => '性別',
        'need' => 1,
        'check' => 'str',
        'help' => 0,
        'maxlength' => 100),
    8 => array(
        'title' => '年齢',
        'need' => 1,
        'check' => 'number',
        'help' => 0,
        'maxlength' => 100),
    9 => array(
        'title' => '誕生日',
        'need' => 1,
        'check' => 'date',
        'help' => 0,
        'maxlength' => 100),
    10 => array(
        'title' => '住所',
        'need' => 1,
        'check' => 'str',
        'help' => 0,
        'maxlength' => 100),
    11 => array(
        'title' => '電話',
        'need' => 1,
        'check' => 'phone',
        'help' => 0,
        'maxlength' => 100),
    12 => array(
        'title' => '携帯電話',
        'need' => 1,
        'check' => 'phone',
        'help' => 0,
        'maxlength' => 100),
        );
