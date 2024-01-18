<?php
    global $thisForm;
    global $PANKZ;
    global $Ret;
    global $sess_key;
    global $sid;
    global $_util;
    global $mode;
    global $r_prm;
    global $_movie;
    global $_upfile;

    $Ret = false;
    $pid=2;
    if (isset($_SESSION[$sess_key])) {
        return;
    }

    $PANKZ[]=array('name'=>$thisForm->get('FORM_TITLE'),'link'=>null);
    // 新規登録のケースしかない
    $_movie->use_connect('master');
    $_movie->begin();

    if (isset($_REQUEST[$thisForm->get('DELETE_NAME')])) {
        // 削除
        $Ret = $_movie->deleteVideo($sid);
    } else {
        $values = $thisForm->_v;
        $title = $thisForm->_v[1];
        $description = $thisForm->_v[3];
        $duration = $thisForm->_v[4];
        $uploader = $thisForm->_v[7];
        $filepath = $_upfile->_upfileDir;
        var_dump($imagecnt);
        for($i=0;$i<$thisForm->imagecnt;$i++){
          if(!empty($r_prm[$i+1][0])){
            $file=$r_prm[$i+1][0];
            $filename = $_upfile->filecheck($file,array($sid,$i+1),$filepath, IMAGE_MAX_WIDTH_FOR_SLIDE_BANNER, IMAGE_MAX_HEIGHT_FOR_SLIDE_BANNER);
            $thisForm->_v[2]=$filename;
            $url = $thisForm->_v[2];
          }

          if(!empty($r_prm[$i+1][1])){
            $file=$r_prm[$i+1][1];
            $filename = pathinfo($file)['filename'].".".pathinfo($file,PATHINFO_EXTENSION);
            // $filename = $_upfile->filecheck($file,array($sid,$i+2),$filepath, IMAGE_MAX_WIDTH_FOR_SLIDE_BANNER, IMAGE_MAX_HEIGHT_FOR_SLIDE_BANNER);
            $thisForm->_v[5]=$filename;
            $thumbnail_small = $thisForm->_v[5];
          }
          if(!empty($r_prm[$i+1][2])){
            $file=$r_prm[$i+1][2];
            $filename = pathinfo($file)['filename'].".".pathinfo($file,PATHINFO_EXTENSION);
            // pathinfo(
            // $filename = $_upfile->filecheck($file,array($sid,$i+3),$filepath, IMAGE_MAX_WIDTH_FOR_SLIDE_BANNER, IMAGE_MAX_HEIGHT_FOR_SLIDE_BANNER);
            $thisForm->_v[6]=$filename;
            $thumbnail_large = $thisForm->_v[6];
          }
        }
        if (empty($mode)) {
          var_dump($sid." ".$title." ".$url." ".$description." ".$duration." ".$thumbnail_small." ".$thumbnail_large." ".$uploader);
          $Ret = $_movie->updateVideo($sid,$title,$url,$description,"dds",$thumbnail_small,$thumbnail_large,$uploader);
          if (!$Ret) {
              $_movie->rollback();
              return;
          }
        } else {
          $Ret = $_movie->insertVideo($title,$url,$description,$duration,$thumbnail_small,$thumbnail_large,$uploader);
          if (!$Ret) {
              $_movie->rollback();
              return;
          }
          $sid = $_movie->lastInsertId();
        }
    }

    if ($Ret) {
        $_movie->commit();
        $_SESSION[$sess_key] = $Ret;
    } else {
        $_movie->rollback();
    }
