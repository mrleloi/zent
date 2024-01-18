<?php
    $mode = $_util->RequestVal('mode');

    $sid = (int)$_util->RequestVal('sid', 0);

    require_once(__DIR__.'/conf.php');

    $relate_cnt=8;
    	for($i=0;$i<$relate_cnt;$i++){
    		$r_nm[$i]='r'.$i;
    		$r_prm[$i]=array();
    		if(isset($_REQUEST['edit_'.$r_nm[$i]])){
    			$r_prm[$i]=$_REQUEST['edit_'.$r_nm[$i]];
    		}elseif(isset($_REQUEST[$r_nm[$i]])){
    			$r_prm[$i]=$_REQUEST[$r_nm[$i]];
    		}
    	}

    $PANKZ[]=array('name'=>'会員一覧','link'=>'../../apl_user_profile/');

    $FTAG_NAME='formmain';

    require_once 'formlib.php';
    require_once 'formdecorder.php';
    $thisForm = new formdecorder();
    $thisForm->imagecnt = 1;
    $thisForm->_error = false;

    $thisForm->set('FORM_HTML', 'form.html');
    $thisForm->set('FORM_PROC_PHP', 'form.php');
    $thisForm->set('FORM_NAME', 'form');
    if (empty($mode)) {
        $thisForm->set('FORM_TITLE', '変更');
      }else{
        $thisForm->set('FORM_TITLE', '新規追加');
      }

    $thisForm->set('CONFIRM_HTML', 'confirm.html');
    $thisForm->set('CONFIRM_PROC_PHP', 'confirm.php');
    $thisForm->set('CONFIRM_NAME', 'confirm');
    $thisForm->set('CONFIRM_TITLE', '確認する');
    $thisForm->set('FINISH_HTML', 'finish.html');
    $thisForm->set('FINISH_PROC_PHP', 'finish.php');
    $thisForm->set('FINISH_NAME', 'finish');
    $thisForm->set('FINISH_TITLE', '登録する');
    $thisForm->set('INIT_HTML', $thisForm->get('FORM_HTML'));
    $thisForm->set('INIT_PROC_PHP', $thisForm->get('FORM_PROC_PHP'));
    $thisForm->set('INIT_NAME', 'reset');
    $thisForm->set('INIT_TITLE', 'リセット');
    $thisForm->set('MODIFY_HTML', $thisForm->get('FORM_HTML'));
    $thisForm->set('MODIFY_PROC_PHP', $thisForm->get('FORM_PROC_PHP'));
    $thisForm->set('MODIFY_NAME', 'modify');
    $thisForm->set('MODIFY_TITLE', '戻る');
    $thisForm->set('DELETE_HTML', $thisForm->get('CONFIRM_HTML'));
    $thisForm->set('DELETE_PROC_PHP', $thisForm->get('FORM_PROC_PHP'));
    $thisForm->set('DELETE_NAME', 'delete');
    $thisForm->set('DELETE_TITLE', '削除');

    $thisForm->set('CHECK_PROC_PHP', 'check.php');

    $CONFIRM_MSG = '以下の内容で登録します。内容をお確かめの上、画面の指示に従ってお進みください。';
    if (isset($_REQUEST[$thisForm->get('DELETE_NAME')])) {
        $CONFIRM_MSG = "以下の内容を削除します。内容をお確かめください。";
        $thisForm->set('FORM_TITLE', '削除');
        $thisForm->set('FINISH_TITLE', '削除する');
        $thisForm->set('CHECK_PROC_PHP', null);
    }
   // if (isset($_REQUEST[$thisForm->get('MODIFY_NAME')])) {
   //   echo "string";
   // }

    $CONTENT = $thisForm->getContent();

    //var_dump($thisForm->_error);
    $selectedmenu = "user_profile_edit";

    require($BASE_HTML);
