<?php
    require_once(__DIR__.'/conf.php');

    $PANKZ[]=array('name'=>'会員一覧','link'=>null);

    $mode = $_util->RequestVal('mode');
    // require_once 'infoUserProfileClass.php';
    // $user_profile = new infoUserProfile();
    require_once "accountClass.php";
    $user_profile = new account();
    $FTAG_NAME='formmain';

    require_once 'formdecorder.php';
    $thisForm = new formdecorder();

    $thisForm->_error = false;

    $thisForm->set('FORM_HTML', 'form.html');
    $thisForm->set('FORM_PROC_PHP', 'form.php');
    $thisForm->set('FORM_NAME', 'form');
    $thisForm->set('FORM_TITLE', '一覧');

    $CONTENT = $thisForm->getContent();
    //var_dump($CONTENT);
    $selectedmenu = "user_profile";

    require($BASE_HTML);
