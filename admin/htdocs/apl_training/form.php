<?php
global $PANKZ;
global $thisForm;
global $FTAG_NAME;
global $sess_key;
global $_util;
global $_training;
global $_trainingList;

// ページネーション＋ソート関連のオブジェクト
global $pageObj;
global $page;
global $limit;
// global $mode;

if (isset($_SESSION[$sess_key])) {
    unset($_SESSION[$sess_key]);
}

// ページネーション＋ソートの設定
require_once 'pageViewClass.php';
$pageObj = new pageView();

$pageObj->setConfig([
    'formType' => 'post',
    'formname' => $FTAG_NAME,
    'limitType' => [1 => 10, 2 => 20, 3 => 50, 4 => 100],
    'sortType' => [1 => 'sid'],
    'sort' => $_util->RequestVal('sort', 0),
    'order' => $_util->RequestVal('order', 0),
    'page' => $_util->RequestVal('page'),
    'limit' => $_util->RequestVal('limit'),
    'maxCount' => $_training->getTrainingListCount(),
]);
$params = $pageObj->getSQLparamArray();
if ($params) {
    if (isset($params['order'])) {
        $_training->setSQL_order($params['order']);
    } else {
        $_training->setSQL_order('sid DESC');
    }
    if (isset($params['limit'])) {
        $_training->setSQL_limit($params['limit']);
    }
    if (isset($params['offset'])) {
        $_training->setSQL_offset($params['offset']);
    }
}

//アンケート一覧を取得
$_trainingList = $_training->getTrainingList();
$pageObj->preloadPage();
