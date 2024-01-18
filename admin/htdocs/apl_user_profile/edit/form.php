<?php
    global $thisForm;
    global $sid;
    global $mode;
    global $sess_key;
    global $r_prm;
    global $user_profile;
    global $PANKZ;
    global $_upfile;
    global $defaultRegistDateDate;
    // global $flag;
    if (isset($_SESSION[$sess_key])) {
        unset($_SESSION[$sess_key]);
    }

    $PANKZ[]=array('name'=>$thisForm->get('FORM_TITLE'),'link'=>null);

    $defaultRegistDateDate = date("Y/m/d");

    if ((empty($mode) && !empty($sid) && isset($_REQUEST[$thisForm->get('MODIFY_NAME')]) && !$thisForm->_error)
        || $mode === "del"||(empty($mode) && !empty($sid) && !isset($_REQUEST[$thisForm->get('MODIFY_NAME')]) && !$thisForm->_error)) {

        // $row = $user_profile->getUserProfileListById($sid);
        $row = $user_profile->getContent($sid);

        if (!empty($row)) {
            // sid
            $thisForm->_v[100] = $row>sid;

            $thisForm->_v[1] = $row->loginid;

            $thisForm->_v[2] = $row->loginpwd;

            $thisForm->_v[3] = $row->u_kind;
            // タイトル
            $thisForm->_v[4] = $row->name;
            // ステータス
            $thisForm->_v[5] = $row->katakana;

            $thisForm->_v[6] = $row->avatar;

            $thisForm->_v[7] = $row->sex;

            $thisForm->_v[8] = $row->age;

            $thisForm->_v[9] = $row->birthday;

            $thisForm->_v[10] = $row->address;

            $thisForm->_v[11] = $row->tel;

            $thisForm->_v[12] = $row->mobile;

            $thisForm->_v[13] = $row->email;

            $thisForm->_v[14] = $row->active;

            $thisForm->_v[15] = $row->ctime;

            $thisForm->_v[16] = $row->mtime;

            // $thisForm->_v[14] = $row->account_id;

            $r_prm[1][0] = $row->avatar;
            // var_dump($r_prm[1][0]);
        }
    }
