<?php
global $thisForm;
global $sid;
global $mode;
global $sess_key;
global $r_prm;
global $_movie;
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

  $row = $_movie->getVideoListById($sid);

  if (!empty($row)) {
    // sid
    $thisForm->_v[100] = $row>sid;

    $thisForm->_v[1] = $row->title;

    $thisForm->_v[2] = $row->url;

    $thisForm->_v[3] = $row->description;
    // タイトル
    $thisForm->_v[4] = $row->duration;
    // ステータス
    $thisForm->_v[5] = $row->thumbnail_small;

    $thisForm->_v[6] = $row->thumbnail_large;

    $thisForm->_v[7] = $row->uploader;

    $thisForm->_v[8] = $row->active;

    $thisForm->_v[9] = $row->ctime;

    $thisForm->_v[10] = $row->mtime;
    // $thisForm->_v[14] = $row->account_id;
    $r_prm[1][0] = $row->url;
    $r_prm[2][1] = $row->thumbnail_small;
    $r_prm[3][2] = $row->thumbnail_large;
    // var_dump($r_prm[1][0]);
  }
}
