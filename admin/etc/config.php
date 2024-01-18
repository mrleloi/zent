<?php
//Environment settings
    $thisPage->site_title = "ZENT";
    $thisPage->head_title = $thisPage->site_title;

    $thisPage->header_html = $thisPage->shared_dir."header.html";
    $thisPage->pankz_html = $thisPage->shared_dir."pankz.html";
    $thisPage->menu_html = $thisPage->shared_dir."menu.html";
    $thisPage->footer_html = $thisPage->shared_dir."footer.html";

    $BASE_HTML = $thisPage->shared_dir."frame.html";
    $SHARED_PATH = $thisPage->shared_path;

    $LOGIN_PANEL = "login.html";
    $LOGIN_CSS = $thisPage->shared_path."/css/login.css";

//--------

    $ADMIN_BACKUP_MAIL = array(
        'y.suzuki@canvas-works.jp',
        );

	$PermissionList = array(
		1 => '管理者',
		2 => 'メンバー'
	);
