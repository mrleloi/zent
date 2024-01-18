<?php
$TITLE = $thisPage->site_title;
$thisPage->page_title = "お知らせ";
$thisPage->head_title = "【ZENT】" . $thisPage->page_title . " - " . $TITLE;
$thisPage->setAddHeader('<link href="' . $thisPage->shared_path . '/css/viewer.min.css" rel="stylesheet">');
$thisPage->setAddHeader('<link href="' . $thisPage->shared_path . '/css/modal.css" rel="stylesheet">');
$thisPage->setAddHeader('<script src="https://cdnjs.cloudflare.com/ajax/libs/viewerjs/1.3.6/viewer.min.js" charset="UTF-8"></script>');
$thisPage->setAddHeader('<link rel="stylesheet" href="' . $thisPage->css_path . '/customtable.css?' . CACHE_CLEAR . '" type="text/css" media="screen" />');
$sortTitle=array(
  array(
    array("key"=>1,"field"=>"sid","sort"=>0,"title"=>"連番",'search'=>0),
  ),
  array(
    array("key"=>2,"field"=>"type","sort"=>0,"title"=>"種類",'search'=>0),
  ),
  array(
    array("key"=>3,"field"=>"date","sort"=>0,"title"=>"日付",'search'=>0),
  ),
  array(
    array("key"=>4,"field"=>"title","sort"=>0,"title"=>"タイトル",'search'=>0),
  ),
  array(
    array("key"=>5,"field"=>"body","sort"=>0,"title"=>"ボディー",'search'=>0)
  ),
  array(
    array("key"=>6,"field"=>"","sort"=>0,"title"=>"編集",'search'=>0)
  ),
);
