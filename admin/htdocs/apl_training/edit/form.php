<?php
global $thisForm;
global $sid;
global $mode;
global $sess_key;
global $r_prm;
global $_training;
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

  $row = $_training->getTrainingListById($sid);

  if (!empty($row)) {
    // sid
    $thisForm->_v[100] = $row>sid;

    $thisForm->_v[1] = $row->title;

    $thisForm->_v[2] = $row->avatar;

    $thisForm->_v[3] = $row->description;
    // タイトル
    $thisForm->_v[4] = $row->uploader;
    // ステータス
    $thisForm->_v[5] = $row->video_id;

    $thisForm->_v[6] = $row->user_id;

    $thisForm->_v[7] = $row->active;

    $thisForm->_v[8] = $row->ctime;

    $thisForm->_v[9] = $row->mtime;

    $r_prm[1][0] = $row->avatar;

  }
}
