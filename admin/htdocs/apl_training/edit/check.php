<?php
function r($s)
{
  $s = str_replace('<', '＜', $s);
  $s = str_replace('>', '＞', $s);
  $s = str_replace('&', '＆', $s);
  $s = str_replace('"', '”', $s);
  $s = str_replace("'", "’", $s);
  $s = str_replace("\\", "￥", $s);
  $s = str_replace("~", "～", $s);
  return $s;
}

global $thisForm;
global $error, $ckmes;
global $afconf;
global $r_prm;
global $_util;
global $mode;
global $sid;

$default_error = false;
if ($error) {
  $default_error = true;
}

// 共通エラーチェック
foreach ($afconf as $key => $val) {
  // チェックタイプが画像の場合はチェックを行わない。
  if ($val["check"] == "image") {
    continue;
  }

  if ($val["check"] == "video") {
    continue;
  }

  $checkVal = $thisForm->getv($key);

  if ($val["check"] === "bool") {
    // チェックなしの場合は$checkVal=NULL
    // チェックありの場合は$checkVal=1
    if (empty($checkVal)) {
      $thisForm->_v[$key] = 0; // チェックなし
    } else {
      $thisForm->_v[$key] = 1; // チェックあり
    }
    continue;
  }

  // チェックタイプが文字・数字入力の場合、自動変換を行う
  if ($val["check"] == "str" || $val["check"] == "number") {
    $checkVal = mb_convert_kana($checkVal, "asKV");
  }

  // 文字変換
  $checkVal = str_replace('<', '＜', $checkVal);
  $checkVal = str_replace('>', '＞', $checkVal);
  $checkVal = str_replace('&', '＆', $checkVal);
  $checkVal = str_replace('"', '”', $checkVal);
  $checkVal = str_replace("'", "’", $checkVal);
  $checkVal = str_replace("\\", "￥", $checkVal);
  $checkVal = str_replace("~", "～", $checkVal);
  $thisForm->_v[$key] = $checkVal;
  // var_dump($checkVal);
  // if(pathinfo($r_prm[1][1])['filename'] == pathinfo($r_prm[1][2])['filename']){
  //   $ckmes .= $afconf[5]['title'] . "には数値を入力してください。<br>";
  //   $thisForm->_m[$key] = true;
  //   $thisForm->_error = true;
  // }
  if (empty($checkVal)) {
    if ($val["need"] == 1) {
      $errorType = "入力";
      if ($val["check"] == "select") {
        $errorType = "選択";
      }
      $ckmes .= $afconf[$key]['title'] . "を" .$errorType ."してください<br>";
      // if($afconf[$key]['title'] != "url" && $afconf[$key]['title'] != "サムネイル小" && $afconf[$key]['title'] != "サムネイル大"){
      //   $ckmes .= $afconf[$key]['title'] . "を" .$errorType ."してください<br>";
      // }
      // if(strlen($login_passwd)<6 OR strlen($login_passwd)>30) {
      // }
      // if($afconf[$key]['title'] == "url"){
      //   continue;
      // }
      $thisForm->_m[$key] = true;
      $thisForm->_error = true;
    }
  } else {
    // 数値チェック
    // var_dump(pathinfo($r_prm[1][1])['filename']." ".pathinfo($r_prm[1][2])['filename']);
    // if(pathinfo($r_prm[1][1])['filename'] == pathinfo($r_prm[1][2])['filename']){
    //   $ckmes .= $afconf[5]['title'] . "には数値を入力してください。<br>";
    //   $thisForm->_m[$key] = true;
    //   $thisForm->_error = true;
    // }
    if ($val["check"] == "number") {
      if (!is_numeric($checkVal)) {
        $ckmes .= $afconf[$key]['title'] . "には数値を入力してください。<br>";
        $thisForm->_m[$key] = true;
        $thisForm->_error = true;
      }
      // 文字列チェック
    } elseif ($val["check"] == "str") {
      if (mb_strlen($checkVal) > $val["maxlength"]) {
        $ckmes .= $afconf[$key]['title'] . "は最大" .$val["maxlength"] ."文字までで入力してください。<br>";
        $thisForm->_m[$key] = true;
        $thisForm->_error = true;
      }
      // 日付チェック
    } elseif ($val["check"] == "date") {
      if (preg_match("/^([0-9]{4})-([0-9]{2})-([0-9]{2})$/", $checkVal, $matches)) {
        $year = intval($matches[1]);
        $month = intval($matches[2]);
        $day = intval($matches[3]);
        $hour = intval($matches[4]);
        $minutes = intval($matches[5]);

        if (!checkdate($month, $day, $year)) {
          $ckmes .= $afconf[$key]['title'] . "の形式が正しくありません。<br>";
          $thisForm->_m[$key] = true;
          $thisForm->_error = true;
        } elseif ($hour < 0 || $hour >=24 || $minutes < 0 || $minutes >= 60) {
          $ckmes .= $afconf[$key]['title'] . "の形式が正しくありません。<br>";
          $thisForm->_m[$key] = true;
          $thisForm->_error = true;
        }
      } else {
        $ckmes .= $afconf[$key]['title'] . "の形式が正しくありません。<br>";
        $thisForm->_m[$key] = true;
        $thisForm->_error = true;
      }
    } elseif ($val["check"] == "email") {
      if(!filter_var($checkVal, FILTER_VALIDATE_EMAIL)){
        $ckmes .= $afconf[$key]['title'] . "の形式が正しくありません。<br>";
        $thisForm->_m[$key] = true;
        $thisForm->_error = true;
      }
    } elseif ($val["check"] == "phone") {
      // if(!preg_match("/^[0-9]{3}[0-9]{4}[0-9]{4}$/", $checkVal)) {
      if (!is_numeric($checkVal)) {
        // if(!preg_match("/^[0-9][0-9][0-9]$/", $checkVal)) {
        $ckmes .= $afconf[$key]['title'] . "の形式が正しくありません。<br>";
        $thisForm->_m[$key] = true;
        $thisForm->_error = true;
      }
    } elseif ($val["check"] == "katakana") {
      if(!(preg_match('/[\x{30A0}-\x{30FF}]/u', $checkVal) > 0)){
        $ckmes .= $afconf[$key]['title'] . "にはカタカナを入力してください。<br>";
        $thisForm->_m[$key] = true;
        $thisForm->_error = true;
      }
    } elseif ($val["check"] == "time") {
      if (preg_match("/^([0-1]\d|20|21|22|23):[0-5]\d$/", $checkVal, $matches)) {
        $hour = intval($matches[1]);
        $minutes = intval($matches[2]);
        if ($hour < 0 || $hour > 23 || !is_numeric($hour)) {
          $ckmes .= $afconf[$key]['title'] . "の形式が正しくありません。<br>";
          $thisForm->_m[$key] = true;
          $thisForm->_error = true;
        } elseif ($minutes < 0 || $minutes > 59 || !is_numeric($minutes)) {
          $ckmes .= $afconf[$key]['title'] . "の形式が正しくありません。<br>";
          $thisForm->_m[$key] = true;
          $thisForm->_error = true;
        }
      }else {
        $ckmes .= $afconf[$key]['title'] . "の形式が正しくありません。<br>";
        $thisForm->_m[$key] = true;
        $thisForm->_error = true;
      }
    }
  }
}

//file uploader
include_once('upfile.php');

//=================================================================================
// その他エラー
//=================================================================================
