<?php
    global $thisForm;
    global $PANKZ;
    global $Ret;
    global $sess_key;
    global $sid;
    global $_util;
    global $mode;
    global $r_prm;
    global $user_profile;
    global $_upfile;

    $Ret = false;
    $pid=2;
    if (isset($_SESSION[$sess_key])) {
        return;
    }

    $PANKZ[]=array('name'=>$thisForm->get('FORM_TITLE'),'link'=>null);
    // 新規登録のケースしかない
    $user_profile->use_connect('master');
    $user_profile->begin();

    if (isset($_REQUEST[$thisForm->get('DELETE_NAME')])) {
        // 削除
        $Ret = $user_profile->deleteUserProfile($sid);
    } else {
        // if (isset($_REQUEST[$thisForm->get('MODIFY_NAME')])) {
        if (empty($mode)) {
          $thisForm->_v[$pid]=crypt($thisForm->_v[$pid]);
          $filepath = $_upfile->_upfileDir;
          for($i=0;$i<$thisForm->imagecnt;$i++){
            if(!empty($r_prm[$i+1][0])){
              $file=$r_prm[$i+1][0];
              $filename = $_upfile->filecheck($file,array($sid,$i+1),$filepath, IMAGE_MAX_WIDTH_FOR_SLIDE_BANNER, IMAGE_MAX_HEIGHT_FOR_SLIDE_BANNER);
              $thisForm->_v[6]=$filename;
            }
          }
          // var_dump($thisForm->_v);
          $stmt = $user_profile->update_profilePrepare();
          $user_profile->bind($stmt,'sid',$sid);
          $Ret = $user_profile->update_profile($stmt,$thisForm->_v);
          // $Ret = $_push_notification->updateAplPushNotification($sid,$thisForm->_v[1],$thisForm->_v[2],$values1,$thisForm->_v[4]);
          // if (!$Ret) {
          //     $_push_notification->rollback();
          //     return;
          // }
        } else {
          $thisForm->_v[$pid]=crypt($thisForm->_v[$pid]);
          $filepath = $_upfile->_upfileDir;
          for($i=0;$i<$thisForm->imagecnt;$i++){
            if(!empty($r_prm[$i+1][0])){
              $file=$r_prm[$i+1][0];
              $filename = $_upfile->filecheck($file,array($sid,$i+1),$filepath, IMAGE_MAX_WIDTH_FOR_SLIDE_BANNER, IMAGE_MAX_HEIGHT_FOR_SLIDE_BANNER);
              $thisForm->_v[6]=$filename;
            }
          }
          // $thisForm->_v[6] = date("Y-m-d", strtotime($thisForm->getv(6)));
          // var_dump($thisForm->_v[6]);
          $stmt = $user_profile->addPrepare_userprofile();
          $Ret = $user_profile->add_userprofile($stmt,$thisForm->_v);
          $sid= $user_profile->lastInsertId();
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
        $user_profile->commit();
        $_SESSION[$sess_key] = $Ret;
    } else {
        $user_profile->rollback();
    }
