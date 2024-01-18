<?php
//Environment settings
/*
	$thisPage->site_title = "CePiC";

	if (strpos($_SERVER["REQUEST_URI"], 'add_user') === false) {
		$thisPage->head_title = $thisPage->site_title."主催者機能";
		$thisPage->header_html = $thisPage->shared_dir."header.html";
	} else {
		$thisPage->head_title = $thisPage->site_title."ユーザ登録";
		$thisPage->header_html = $thisPage->shared_dir."header_user_add.html";
	}
*/

	$BASE_HTML = $thisPage->shared_dir."frame.html";
	$SHARED_PATH = $thisPage->shared_path;

	$LOGIN_PANEL = "login.html";
	$LOGIN_CSS = $thisPage->shared_path."/css/login.css";

//--------

?>
