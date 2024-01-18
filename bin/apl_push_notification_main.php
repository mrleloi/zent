<?php

require_once('define.php');

// require_once(__DIR__.'/../lib/qdmail.php');
// $qdmail = new Qdmail();

require_once ('infoAplPushNotificationClass.php');
$_push_notification = new infoAplPushNotification();

require_once('infoUserProfileClass.php');
$_user = new infoUserProfile();
// -------------------------------------------------------------

$today = date('Y-m-d H:i:s');
echo ">>> {$today} START"."\n";
/** 配信対象者、配信記事を抽出 **/
$cnt = 0;
$today = date('Y-m-d H:i:s');
$today = '2020-05-01 17:27:00';
$list = $_push_notification->getSendlist($today);

if(!empty($list)){
  $cnt = count($list);
  // ステータス更新
  $_push_notification->updateStasus($today);
}
// プッシュ通知
for ($i=0;$i<$cnt;$i++) {
  $listInfo = $list[$i];
  // プッシュ通知
  $description = $listInfo->body;
  $title = $listInfo->title;

  $base_url = BASE_URL;
  $api_key  = API_KEY;      // iosの場合、「クラウドメッセージング」の「Server key」
  $type = $listInfo->type;
  if($type == "global"){
    $to = "/topics/".$type;
  } else if(explode("/", $type)[0] == "flatforms"){
    $to = "/topics/".$type;
  } else if(explode("/", $type)[0] == "topics"){
    $to = "/".$type;
  } else if(explode("/", $type)[0] == "tokens"){
    $to = explode("/", $type)[1];
  }
  // $to = "/topics/global";   // デバイストークン指定で個別送信 、アプリ側で設定したtopicsグループ宛に送ることも可能 (global:全体 jan - dec: 各月誕生日ユーザ宛)
  // iOS
  $data = array(
    "to"           => $to,
    "priority"     => "high",       // iosはhighにする必要有り
    //        "content_available" => true,    // 必要か不明
    "notification" => array(        // iosの場合、「data」ではなく、「notification」ではないと動かない?
      "title"  => $title,
      "body"  => $description,
      "sound" => "default",
      "icon" => "notification"
    )
  );

  send($api_key,$base_url,$data);
  /*
  // android
  $data = array(
  "to"           => $to,
  "priority"     => "high",
  "data" => array(
  "body"  => $description
  )
);
send($api_key,$base_url,$data);
*/
}

function send($api_key,$base_url,$data) {
  echo "api_key:".$api_key."\n";
  echo "base_url:".$base_url."\n";
  echo "data:".$data."\n";
  $header = array(
    "Content-Type:application/json"
    ,"Authorization:key=".$api_key
  );
  $context = stream_context_create(array(
    "http" => array(
      'method' => 'POST'
      ,'header' => implode("\r\n",$header)
      ,'content'=> json_encode($data)
    )
  ));
  file_get_contents($base_url,false,$context);
}

echo $cnt."件送信しました\n";

$nowTime = date("Y/m/d H:i:s");
echo "<<< {$today} END"."\n\n";

?>
