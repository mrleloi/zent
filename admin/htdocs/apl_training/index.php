<?php
    require_once(__DIR__.'/conf.php');

    $PANKZ[]=array('name'=>'トレーニング一覧','link'=>null);

    $mode = $_util->RequestVal('mode');
    // require_once 'infoUserProfileClass.php';
    // $user_profile = new infoUserProfile();
    require_once 'infoTrainingClass.php';
    $_training = new infoTraining();
    $tableName = $_training->_table;
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
    $selectedmenu = "トレーニング";

    require($BASE_HTML);
