<?php
    require_once(__DIR__.'/conf.php');

    $PANKZ[]=array('name'=>'ユーザ管理一覧','link'=>null);

    $mode = $_util->RequestVal('mode');
    // require_once 'infoAplPushNotificationClass.php';
    require_once "accountClass.php";
    // $_apl_push_notification = new infoAplPushNotification();
    $_info = new account();
    $FTAG_NAME='formmain';
    //ar_dump($_info->getAplUserListCount());
    require_once 'formdecorder.php';
    $thisForm = new formdecorder();

    $thisForm->_error = false;

    $thisForm->set('FORM_HTML', 'form.html');
    $thisForm->set('FORM_PROC_PHP', 'form.php');
    $thisForm->set('FORM_NAME', 'form');
    $thisForm->set('FORM_TITLE', '一覧');

    $CONTENT = $thisForm->getContent();
    //var_dump($CONTENT);
    $selectedmenu = "apl_user";

    require($BASE_HTML);
