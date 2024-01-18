<?php
    global $thisForm;
    global $PANKZ;
    global $Ret;
    global $sess_key;
    global $sid;
    global $_util;
    global $mode;
    global $r_prm;
    global $_info;

    $Ret = false;
    $pid=2;
    if (isset($_SESSION[$sess_key])) {
        return;
    }

    $PANKZ[]=array('name'=>$thisForm->get('FORM_TITLE'),'link'=>null);
    // 新規登録のケースしかない
    $_info->use_connect('auth_master');
    $_info->begin();

    if (isset($_REQUEST[$thisForm->get('DELETE_NAME')])) {
        // 削除
        $stmt = $_info->deleteStatusPrepare();
		    $Ret = $_info->deleteStatus($stmt,$sid);
    } else {
        // if (isset($_REQUEST[$thisForm->get('MODIFY_NAME')])) {
        if (empty($mode)) {
          if(!empty($thisForm->_v[$pid])){
            $thisForm->_v[$pid]=crypt($thisForm->_v[$pid]);
          }else{
            $thisForm->_v[$pid]=$thisForm->getv(4);
          }
          $stmt = $_info->updatePrepare();
          var_dump($stmt);
          $_info->bind($stmt,'sid',$sid);
          $Ret = $_info->update($stmt,$thisForm->_v);
          // $Ret = $_push_notification->updateAplPushNotification($sid,$thisForm->_v[1],$thisForm->_v[2],$values1,$thisForm->_v[4]);
          // if (!$Ret) {
          //     $_push_notification->rollback();
          //     return;
          // }
        } else {
          $thisForm->_v[$pid]=crypt($thisForm->_v[$pid]);
          $stmt = $_info->addPrepare_user();
          $Ret = $_info->add_user($stmt,$thisForm->_v);
          $sid=$_info->lastInsertId();
        }
        // if (!empty($mode)) {
        //   echo "string";
        //     $Ret = $_push_notification->updateAplPushNotification($sid,$thisForm->_v[1],$thisForm->_v[2],$values1);
        //     if (!$Ret) {
        //         $_push_notification->rollback();
        //         return;
        //     }
        // } else {
        //   echo "string1";
        //   $Ret = $_push_notification->insertAplPushNotification($thisForm->_v[1],$thisForm->_v[2],$values1);
        //   if (!$Ret) {
        //       $_push_notification->rollback();
        //       return;
        //   }
        //   $sid = $_push_notification->lastInsertId();
          //$sid = $_push_notification->lastInsertId();
          // いま追加した販促物のsid
          // $Ret = $_questionnaire->insertAplPushNotification($sid, $values);
        //}

    }

    if ($Ret) {
        $_info->commit();
        $_SESSION[$sess_key] = $Ret;
    } else {
        $_info->rollback();
    }
