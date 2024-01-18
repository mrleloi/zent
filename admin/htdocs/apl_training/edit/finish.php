<?php
    global $thisForm;
    global $PANKZ;
    global $Ret;
    global $sess_key;
    global $sid;
    global $_util;
    global $mode;
    global $r_prm;
    global $_training;
    global $_upfile;

    $Ret = false;
    $pid=2;
    if (isset($_SESSION[$sess_key])) {
        return;
    }

    $PANKZ[]=array('name'=>$thisForm->get('FORM_TITLE'),'link'=>null);
    // 新規登録のケースしかない
    $_training->use_connect('master');
    $_training->begin();

    if (isset($_REQUEST[$thisForm->get('DELETE_NAME')])) {
        // 削除
        $Ret = $_training->deleteTraining($sid);
    } else {
        $values = $thisForm->_v;
        var_dump($values);
        $title = $thisForm->_v[1];
        $description = $thisForm->_v[3];
        $uploader = $thisForm->_v[4];
        $video_id = $thisForm->_v[5];
        $filepath = $_upfile->_upfileDir;
        for($i=0;$i<$thisForm->imagecnt;$i++){
          if(!empty($r_prm[$i+1][0])){
            $file=$r_prm[$i+1][0];
            $filename = $_upfile->filecheck($file,array($sid,$i+1),$filepath, IMAGE_MAX_WIDTH_FOR_SLIDE_BANNER, IMAGE_MAX_HEIGHT_FOR_SLIDE_BANNER);
            $thisForm->_v[2]=$filename;
            $avatar = $thisForm->_v[2];
          }
        }
        if (empty($mode)) {
          $Ret = $_training->updateTraining($sid,$title,$avatar,$description,$uploader,$video_id);
          if (!$Ret) {
              $_training->rollback();
              return;
          }
        } else {
          $Ret = $_training->insertTraining($title,$avatar,$description,$uploader,$video_id);
          if (!$Ret) {
              $_training->rollback();
              return;
          }
          $sid = $_training->lastInsertId();
        }
    }

    if ($Ret) {
        $_training->commit();
        $_SESSION[$sess_key] = $Ret;
    } else {
        $_training->rollback();
    }
