<?php
$TITLE = $thisPage->site_title;
$thisPage->page_title = "ユーザ管理";
$thisPage->head_title = "【ZENT】" . $thisPage->page_title . " - " . $TITLE;
$thisPage->setAddHeader('<link href="' . $thisPage->shared_path . '/css/viewer.min.css" rel="stylesheet">');
$thisPage->setAddHeader('<link href="' . $thisPage->shared_path . '/css/modal.css" rel="stylesheet">');
$thisPage->setAddHeader('<script src="https://cdnjs.cloudflare.com/ajax/libs/viewerjs/1.3.6/viewer.min.js" charset="UTF-8"></script>');
$thisPage->setAddHeader('<link rel="stylesheet" href="' . $thisPage->css_path . '/customtable.css?' . CACHE_CLEAR . '" type="text/css" media="screen" />');
$sortTitle=array(
  array(
    array("key"=>1,"field"=>"sid","sort"=>0,"title"=>"連番",'kw'=>0),
  ),
  array(
    array("key"=>2,"field"=>"name","sort"=>0,"title"=>"氏名",'kw'=>0),
  ),
  array(
    array("key"=>3,"field"=>"account","sort"=>0,"title"=>"アカウント",'kw'=>0),
  ),
  array(
    array("key"=>4,"field"=>"authority","sort"=>0,"title"=>"権限",'kw'=>0),
  ),
  array(
    array("key"=>5,"field"=>"","sort"=>0,"title"=>"編集",'kw'=>0)
  ),
);
