<?php
    global $thisForm;
    global $PANKZ;
    global $Ret;
    global $sess_key;
    global $sid;
    global $_util;
    global $mode;
    global $r_prm;
    global $_push_notification;

    $Ret = false;

    if (isset($_SESSION[$sess_key])) {
        return;
    }

    $PANKZ[]=array('name'=>$thisForm->get('FORM_TITLE'),'link'=>null);
    // 新規登録のケースしかない
    $_push_notification->use_connect('master');
    $_push_notification->begin();

    if (isset($_REQUEST[$thisForm->get('DELETE_NAME')])) {
        // 削除
        $Ret = $_push_notification->deleteAplPushNotification($sid);
    } else {
        $values = $thisForm->_v;
        // var_dump($values);
        if($thisForm->_v[3] != '0'){
          $values1 = $thisForm->_v[4]."-".($thisForm->_v[6]+1)."-".$thisForm->_v[7]." ".$thisForm->_v[8].":".$thisForm->_v[9];
        } else {
          $currentDateTime = date('Y-m-d H:i:s');
          $values1 = $currentDateTime;
        }
        if($thisForm->_v[1] == 1){
          $type = $_push_notification->_device_type[$thisForm->_v[1]];
        } else if($thisForm->_v[1] == 2||$thisForm->_v[1] == 3||$thisForm->_v[1] == 4){
          var_dump($thisForm->_v[1]);
          // var_dump($_push_notification->_device_type[$thisForm->_v[1]]);
          $type = "flatforms/".$_push_notification->_device_type[$thisForm->_v[1]];
        } else if($thisForm->_v[1] == 5){
          $type = "topics/".$thisForm->_v[10];
        } else if($thisForm->_v[1] == 6){
          $type = "tokens/".$thisForm->_v[10];
        }
        // var_dump($thisForm->_v[1]);
        // if (isset($_REQUEST[$thisForm->get('MODIFY_NAME')])) {
        if (empty($mode)) {
          $Ret = $_push_notification->updateAplPushNotification($sid,$type,$thisForm->_v[2],$thisForm->_v[3],$values1,$thisForm->_v[5]);
          if (!$Ret) {
              $_push_notification->rollback();
              return;
          }
        } else {
          $Ret = $_push_notification->insertAplPushNotification($type,$thisForm->_v[2],$thisForm->_v[3],$values1,$thisForm->_v[5]);
          if (!$Ret) {
              $_push_notification->rollback();
              return;
          }
          $sid = $_push_notification->lastInsertId();
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
        $_push_notification->commit();
        $_SESSION[$sess_key] = $Ret;
    } else {
        $_push_notification->rollback();
    }
