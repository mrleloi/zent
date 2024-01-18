<?php
global $thisForm;
global $sid;
global $mode;
global $sess_key;
global $r_prm;
global $_push_notification;
global $PANKZ;

if (isset($_SESSION[$sess_key])) {
  unset($_SESSION[$sess_key]);
}
$PANKZ[]=array('name'=>$thisForm->get('FORM_TITLE'),'link'=>null);
if ((empty($mode) && !empty($sid) && isset($_REQUEST[$thisForm->get('MODIFY_NAME')]) && !$thisForm->_error)
|| $mode === "del"||(empty($mode) && !empty($sid) && !isset($_REQUEST[$thisForm->get('MODIFY_NAME')]) && !$thisForm->_error)) {

  $row = $_push_notification->getAplPushNotificationListById($sid);

  if (!empty($row)) {
    // sid
    $thisForm->_v[100] = $row>sid;

    $thisForm->_v[1] = $row->type;
    // タイトル
    $thisForm->_v[2] = $row->title;
    // ステータス
    $thisForm->_v[3] = $row->body;

    $thisForm->_v[4] = $row->time_delivery;

    $thisForm->_v[5] = $row->status;

    $thisForm->_v[6] = $row->ctime;

    $thisForm->_v[7] = $row->active;

    $thisForm->_v[8] = $row->mtime;
  }
}
