#!/usr/local/bin/php
<?php
require_once('cmd_prepend.php');

	/** セマフォ **/
  // $prcs_on_file = __DIR__."/../bin/apl_push_notification_deliver.sem-on";
	$prcs_on_file = __DIR__."/apl_push_notification_deliver.sem-on";

	if(file_exists($prcs_on_file)){
    #Hàm strtotime() sẽ phân tích bất kỳ chuỗi thời gian bằng tiếng anh thành một số nguyên chính là timestamp của thời gian đó.
		$nowTime = date("Y/m/d H:i:s",strtotime("-2 hour"));
    # Hàm filemtime() trả về thời điểm lần thay đổi nội dung cuối cùng của một tập tin được chỉ định.
		if(date("Y/m/d H:i:s",filemtime($prcs_on_file))<$nowTime){
			unlink($prcs_on_file);
		}
	}
  #Create and open for writing only;(x)
	// if(!@fopen($prcs_on_file,"x")){
	// 	return;
	// }
	$MainFile = 'apl_push_notification_main.php';
  #Hàm unlink() sẽ xóa file dựa vào đường dẫn đã truyền vào.
	include( $MainFile );
	unlink($prcs_on_file);
?>
