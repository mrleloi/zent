<?php
$TITLE = $thisPage->site_title;
$thisPage->page_title = "トレーニング";
$thisPage->head_title = "【ZENT】" . $thisPage->page_title . " - " . $TITLE;
$thisPage->setAddHeader('<link href="' . $thisPage->shared_path . '/css/viewer.min.css" rel="stylesheet">');
$thisPage->setAddHeader('<link href="' . $thisPage->shared_path . '/css/modal.css" rel="stylesheet">');
$thisPage->setAddHeader('<script src="https://cdnjs.cloudflare.com/ajax/libs/viewerjs/1.3.6/viewer.min.js" charset="UTF-8"></script>');
$thisPage->setAddHeader('<link rel="stylesheet" href="' . $thisPage->shared_path . '/css/jquery.datetimepicker.css?' . CACHE_CLEAR . '" type="text/css" />');
// $thisPage->setAddHeader('<link rel="stylesheet" href="' . $thisPage->css_path . '/layout.css?' . CACHE_CLEAR . '" type="text/css" media="screen" />');
$thisPage->setAddHeader('<link rel="stylesheet" href="' . $thisPage->css_path . '/customtable.css?' . CACHE_CLEAR . '" type="text/css" media="screen" />');
$sortTitle=array(
	array(
		array("key"=>1,"field"=>"sid","sort"=>0,"title"=>"連番","search"=>1),
	),
	array(
		array("key"=>2,"field"=>"name","sort"=>0,"title"=>"名前","search"=>1),
	),
	array(
		array("key"=>3,"field"=>"avatar","sort"=>0,"title"=>"アバター","search"=>1),
	),
	array(
		array("key"=>4,"field"=>"description","sort"=>0,"title"=>"本文","search"=>1),
	),
	array(
		array("key"=>5,"field"=>"uploader","sort"=>0,"title"=>"アップローダー","search"=>1),
	),
	array(
		array("key"=>6,"field"=>"startdate","sort"=>0,"title"=>"掲載開始日","search"=>1),
	),
	array(
		array("key"=>7,"field"=>"enddate","sort"=>0,"title"=>"掲載終了日","search"=>1),
	),
	array(
		array("key"=>8,"field"=>"","sort"=>0,"title"=>"編集","search"=>1)
	),
);

$_sex = array(
	1=>"男性",
	2=>"女性",
);
