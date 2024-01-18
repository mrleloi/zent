<?php
$TITLE = $thisPage->site_title;
$thisPage->page_title = "個人情報";
$thisPage->head_title = "【ZENT】" . $thisPage->page_title . " - " . $TITLE;
$thisPage->setAddHeader('<link href="' . $thisPage->shared_path . '/css/viewer.min.css" rel="stylesheet">');
$thisPage->setAddHeader('<link href="' . $thisPage->shared_path . '/css/modal.css" rel="stylesheet">');
$thisPage->setAddHeader('<script src="https://cdnjs.cloudflare.com/ajax/libs/viewerjs/1.3.6/viewer.min.js" charset="UTF-8"></script>');
$thisPage->setAddHeader('<link rel="stylesheet" href="' . $thisPage->shared_path . '/css/jquery.datetimepicker.css?' . CACHE_CLEAR . '" type="text/css" />');
$thisPage->setAddHeader('<link rel="stylesheet" href="' . $thisPage->css_path . '/customtable.css?' . CACHE_CLEAR . '" type="text/css" media="screen" />');
$sortTitle=array(
	array(
		array("key"=>1,"field"=>"sid","sort"=>0,"title"=>"連番","search"=>1),
	),
	array(
		array("key"=>2,"field"=>"name","sort"=>0,"title"=>"名前","search"=>1),
	),
	array(
		array("key"=>3,"field"=>"sex","sort"=>0,"title"=>"性別","search"=>1),
	),
	array(
		array("key"=>4,"field"=>"birthday","sort"=>0,"title"=>"誕生日","search"=>1),
	),
	array(
		array("key"=>5,"field"=>"address","sort"=>0,"title"=>"住所","search"=>1),
	),
	array(
		array("key"=>6,"field"=>"account","sort"=>0,"title"=>"ログインID","search"=>1),
	),
	array(
		array("key"=>6,"field"=>"mobile","sort"=>0,"title"=>"携帯電話","search"=>1),
	),
	array(
		array("key"=>7,"field"=>"","sort"=>0,"title"=>"編集","search"=>1)
	),
);

$_sex = array(
	1=>"男性",
	2=>"女性",
);
