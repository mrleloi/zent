<?php
global $PANKZ;
global $thisForm;
global $FTAG_NAME;
global $sess_key;
global $_util;
global $user_profile;
global $user_profileList;

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
    'maxCount' => $user_profile->getAplUserListCount(),
]);
$params = $pageObj->getSQLparamArray();
if ($params) {
    if (isset($params['order'])) {
        $user_profile->setSQL_order($params['order']);
    } else {
        $user_profile->setSQL_order('sid DESC');
    }
    if (isset($params['limit'])) {
        $user_profile->setSQL_limit($params['limit']);
    }
    if (isset($params['offset'])) {
        $user_profile->setSQL_offset($params['offset']);
    }
}

//アンケート一覧を取得
// $user_profileList = $user_profile->getUserProfileList();
$user_profile->setSQL_where('active=1');
$stmt = $user_profile->getContentList();
$user_profileList = $user_profile->getObjList($stmt);
$pageObj->preloadPage();
