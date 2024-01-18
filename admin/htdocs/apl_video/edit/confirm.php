<?php
    global $thisForm;
    global $sid;
    global $mode;
    global $_movie;
    global $PANKZ;
    if (empty($mode)) {
    			$PANKZ[]=array('name'=>$thisForm->get('FORM_TITLE'),'link'=>null);
          $CONFIRM_MSG = "以下の内容を更新します。内容をお確かめください。";
          $thisForm->set('FORM_TITLE', '更新');
          $thisForm->set('FINISH_TITLE', '更新する');
          $thisForm->set('CHECK_PROC_PHP', null);
    		} else {
    			$PANKZ[]=array('name'=>'新規追加','link'=>null);
    }

  ?>
