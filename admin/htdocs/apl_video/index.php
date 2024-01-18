<?php
    require_once(__DIR__.'/conf.php');

    $PANKZ[]=array('name'=>'動画一覧','link'=>null);

    $mode = $_util->RequestVal('mode');
    
    require_once 'infoMovieClass.php';
    $_movie = new infoMovie();
    $tableName = $_movie->_table;
    $FTAG_NAME='formmain';

    require_once 'formdecorder.php';
    $thisForm = new formdecorder();

    $thisForm->_error = false;

    $thisForm->set('FORM_HTML', 'form.html');
    $thisForm->set('FORM_PROC_PHP', 'form.php');
    $thisForm->set('FORM_NAME', 'form');
    $thisForm->set('FORM_TITLE', '一覧');

    $CONTENT = $thisForm->getContent();

    $selectedmenu = "動画";

    require($BASE_HTML);
