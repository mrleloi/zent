<?php
    global $thisForm;
    global $sid;
    global $mode;
    global $sess_key;
    global $r_prm;
    global $_info;
    global $PANKZ;
    // global $flag;
    if (isset($_SESSION[$sess_key])) {
        unset($_SESSION[$sess_key]);
    }

    $PANKZ[]=array('name'=>$thisForm->get('FORM_TITLE'),'link'=>null);
    // $mode1 = $_util->et_string();
    // var_dump($mode1);
    //$ys=$ye=date('Y')
    //var_dump("SplMinHeap".date('Y'));
    // var_dump($thisForm->_error);
    // if(isset($_REQUEST[$thisForm->get('MODIFY_NAME')])){
    //   echo "string";
    //   $thisForm->_error = true;
    // }
    //$thisForm->_error =f
    //var_dump("minh".$_REQUEST[$thisForm->get('MODIFY_NAME')]);
    if ((empty($mode) && !empty($sid) && isset($_REQUEST[$thisForm->get('MODIFY_NAME')]) && !$thisForm->_error)
        || $mode === "del"||(empty($mode) && !empty($sid) && !isset($_REQUEST[$thisForm->get('MODIFY_NAME')]) && !$thisForm->_error)) {
        // if(isset($_REQUEST[$thisForm->get('MODIFY_NAME')])){
        //   $thisForm->_m[$key] = false;
        //   $thisForm->_error = false;
        // }

        $row = $_info->getContent($sid);

        if (!empty($row)) {
            // sid
            $thisForm->_v[100] = $row>sid;
            // タイトル
            $thisForm->_v[1] = $row->loginid;
            // ステータス
            $thisForm->_v[2] = $row->loginpwd;

            $thisForm->_v[3] = $row->name;

            $thisForm->_v[4] = $row->u_kind;

            $thisForm->_v[5] = $row->active;

            $thisForm->_v[6] = $row->ctime;

            $thisForm->_v[7] = $row->mtime;
        }
    }
