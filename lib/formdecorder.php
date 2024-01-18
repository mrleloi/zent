<?php

if(!isset($okmes)){$okmes = "<font $ERROR_COLOR>内容をご確認ください</font><br>";}

class formdecorder {
	var $_param;
	var $_form;
	var $_v;
	var $_m;

	public $_message;
	public $_error;

	function __construct(){
		$this->_message = null;
		$this->_error = false;

		$this->_internal_encoding = mb_internal_encoding();

		$this->_multipart = false;
		if(isset($_SERVER["CONTENT_TYPE"])){
			if(strpos($_SERVER["CONTENT_TYPE"],"multipart/form-data") === 0){
				$this->_multipart = true;
				$this->_httpinput_encoding = mb_http_input();
				if($this->_httpinput_encoding == "auto"){
					$this->_httpinput_encoding = mb_http_output();
					if($this->_httpinput_encoding == "pass"){
						$this->_httpinput_encoding = mb_internal_encoding();
					}
				}
			}
		}
	}

	function set($key,$val){
		if(!empty($val)){
			$this->_form[$key] = $val;
		}else{
			if(isset($this->_form[$key])){
				unset($this->_form[$key]);
			}
		}
	}
	function get($key){
		if(isset($this->_form[$key])){
			return $this->_form[$key];
		}
		return null;
	}

	function getv($key){
		if(isset($this->_v) AND isset($this->_v[$key])){
			return $this->_v[$key];
		}
		return null;
	}
	function getm($key){
		if(isset($this->_m) AND isset($this->_m[$key])){
			return $this->_m[$key];
		}
		return null;
	}

	function getContent(){
		global $okmes;

		$this->_message = null;
		$this->_v = array();
		$this->_m = array();
		//var_dump($this->_m);
		$_checkEnable = false;
		$_requiredProc = null;

		$finish_name = $this->get('FINISH_NAME');
		if(!empty($finish_name) AND (isset($_REQUEST[$finish_name]) OR isset($_REQUEST[$finish_name . "_x"]))){
			$_checkEnable = true;
			$_form["FINISH"] = true;
		}

		$confirm_name = $this->get('CONFIRM_NAME');
		if(!empty($confirm_name) AND (isset($_REQUEST[$confirm_name]) OR isset($_REQUEST[$confirm_name . "_x"]))){
			$_checkEnable = true;
			$_form["CONFIRM"] = true;
		}

		$delete_name = $this->get('DELETE_NAME');
		if(!empty($delete_name) AND (isset($_REQUEST[$delete_name]) OR isset($_REQUEST[$delete_name . "_x"]))){
			$_checkEnable = true;
			$_form["DELETE"] = true;
		}

		$form_name = $this->get('FORM_NAME');
		if(!empty($form_name) AND (isset($_REQUEST[$form_name]) OR isset($_REQUEST[$form_name . "_x"]))){
			$_checkEnable = false;
			$_form["FORM"] = true;
		}

		$preview_name = $this->get('PREVIEW_NAME');
		if(!empty($preview_name) AND (isset($_REQUEST[$preview_name]) OR isset($_REQUEST[$preview_name . "_x"]))){
			$_checkEnable = false;
			$_form["PREVIEW"] = true;
		}

		$modify_name = $this->get('MODIFY_NAME');
		if(!empty($modify_name) AND (isset($_REQUEST[$modify_name]) OR isset($_REQUEST[$modify_name . "_x"]))){
			$_checkEnable = true;
			$_form["MODIFY"] = true;
		}

        $init_name = $this->get('INIT_NAME');
		if(!empty($init_name) AND (isset($_REQUEST[$init_name]) OR isset($_REQUEST[$init_name . "_x"]))){
			$_checkEnable = false;
			$_form["INIT"] = true;
		}

		if(!empty($_form["FINISH"])){
			$CONTENT = $this->get('FINISH_HTML');
			if($this->get('FINISH_PROC_PHP')){
				$_requiredProc = $this->get('FINISH_PROC_PHP');
			}
		}else if(!empty($_form["CONFIRM"])){
			$CONTENT = $this->get('CONFIRM_HTML');
			if($this->get('CONFIRM_PROC_PHP')){
				$_requiredProc = $this->get('CONFIRM_PROC_PHP');
			}
		}else if(!empty($_form["DELETE"])){
			$CONTENT = $this->get('DELETE_HTML');
			if($this->get('DELETE_PROC_PHP')){
				$_requiredProc = $this->get('DELETE_PROC_PHP');
			}
		}else if(!empty($_form["PREVIEW"])){
			$CONTENT = $this->get('PREVIEW_HTML');
			if($this->get('PREVIEW_PROC_PHP')){
				$_requiredProc = $this->get('PREVIEW_PROC_PHP');
			}
		}else if(!empty($_form["MODIFY"])){
			$CONTENT = $this->get('MODIFY_HTML');
			if($this->get('MODIFY_PROC_PHP')){
				$_requiredProc = $this->get('MODIFY_PROC_PHP');
			}
		}else if(!empty($_form["INIT"])){
			$CONTENT = $this->get('INIT_HTML');
			if($this->get('INIT_PROC_PHP')){
				$_requiredProc = $this->get('INIT_PROC_PHP');
			}
		}else{
			$CONTENT = $this->get('FORM_HTML');
			if($this->get('FORM_PROC_PHP')){
				$_requiredProc = $this->get('FORM_PROC_PHP');
			}
		}

		if(isset($_REQUEST)){
			$this->decode($_REQUEST);
		}

		if(!empty($_checkEnable)){
			$checkProc = $this->get('CHECK_PROC_PHP');
			if(!empty($checkProc)){require $checkProc;}
			if(empty($_form["MODIFY"]) AND !empty($this->_error)){
				$this->_message = $ckmes;
				$CONTENT = $this->get('FORM_HTML');
			}else if(!empty($_form["CONFIRM"])){
				$this->_message = $okmes;
			}
		}

		if(!empty($_requiredProc)){
			require($_requiredProc);
		}

		return $CONTENT;
	}

	function convert($val){
        if(is_array($val)){return null;}

		$af_mb_wquot = '”';
		$af_mb_quot  = '’';
		$af_mb_semicolon = '；';
		$af_mb_yen  = '￥';
		$af_mb_parcent = '％';
		$af_mb_times = '×';

		//$val = urldecode($val);
		$val = trim($val);
		if(!empty($this->_multipart)){
			if($this->_httpinput_encoding){
				$val = mb_convert_encoding($val,$this->_internal_encoding,$this->_httpinput_encoding);
			}
		}

		$val = str_replace("\r\n","\n",$val);

		//ALLOW_TAGS
		//$val = strip_tags($val);
		//$val = str_replace('%',$af_mb_parcent,$val);

		//ALLOW_QUOT
		$val = str_replace('&quot;',$af_mb_wquot,$val);
		$val = str_replace('"',$af_mb_wquot,$val);
		$val = str_replace("'",$af_mb_quot,$val);

		//ALLOW_SEMICOLON
		$val = str_replace(';',$af_mb_semicolon,$val);

		//$ALLOW_YENSIGN
		$val = str_replace('\\',$af_mb_yen,$val);

		return $val;
	}

	function decode($vars){

		if(empty($vars)){return;}

		reset($vars);
		// while(list($key,$val) = each($vars)){
		// 	if(is_array($val)){
		// 		foreach($val as $k=>$v){
		// 			$val[$k]=$this->convert($v);
		// 		}
		// 		//continue;
		// 	}else{
    //             $val=$this->convert($val);
    //         }
		foreach($vars as $key=>$val){
			if(is_array($val)){
				foreach($val as $k=>$v){
					$val[$k]=$this->convert($v);
				}
				continue;
			}
      $val=$this->convert($val);
			//var_dump($key);
			$key_array=explode(':',$key,3);
      //var_dump($key_array);
			if(count($key_array) != 3){
				//var_dump("asdsad");
				continue;}
				//var_dump("asdsad123");
      //var_dump(count($key_array));
			//var_dump("minhlb".$this->_v[$key_array[2]]);
			$this->_v[$key_array[2]] = $val;

			if($key_array[1] != ""){
				if($val != ""){
					$this->_m[$key_array[2]] = false;
				}else{
					//var_dump($key_array);
					$this->_m[$key_array[2]] = true;
					$this->_error = true;
					$this->_mes1 = $this->_inputbad;
					//エラーが出てとりあえず宣言がなさそうなのでコメントアウト
					//$this->_mes1 = $this->_inputbad;
				}
			}else{
				$this->_m[$key_array[2]] = false;
			}
		}
	}

    function request2hidden($ignores=null) {
        $ignorelist = array(
            session_name(),
            $this->get('INIT_NAME'),
            $this->get('PRELOAD_NAME'),
            $this->get('CONFIRM_NAME'),
            $this->get('MODIFY_NAME'),
            $this->get('FINISH_NAME'),
            $this->get('FORTH_NAME'),
            $this->get('NEXT_NAME'),
            $this->get('EXIT_NAME'),

            $this->get('INIT_NAME') . "_x",
            $this->get('PRELOAD_NAME') . "_x",
            $this->get('CONFIRM_NAME') . "_x",
            $this->get('MODIFY_NAME') . "_x",
            $this->get('FINISH_NAME') . "_x",
            $this->get('FORTH_NAME') . "_x",
            $this->get('NEXT_NAME') . "_x",
            $this->get('EXIT_NAME') . "_x",
            );
        if(!empty($ignores)){
            if(is_array($ignores)){
                $ignorelist = array_merge($ignorelist,$ignores);
            }else{
                $ignorelist[] = $ignores;
            }
        }

        $cnt = count($_REQUEST);
        reset($_REQUEST);
        while(list($key,$val) = each($_REQUEST)){
            if(in_array($key,$ignorelist)){continue;}

//            $array = array();
//            $ret = $this->request2hidden_sub($key,$val,$array);

            if(is_array($val)){
                foreach($val as $key2 => $val2){
                    if(is_array($val2)){
                        foreach($val2 as $key3 => $val3){
                            if(is_array($val3)){
                                foreach($val3 as $key4 => $val4){
                                    if(is_array($val4)){
                                        foreach($val4 as $key5 => $val5){
                                            $val5 = $this->convert($val5);
                                            print("<input type=\"hidden\" name=\"{$key}[{$key2}][{$key3}][{$key4}][{$key5}]\" value=\"{$val5}\" />\n");
                                        }
                                    }else{
                                        $val4 = $this->convert($val4);
                                        print("<input type=\"hidden\" name=\"{$key}[{$key2}][{$key3}][{$key4}]\" value=\"{$val4}\" />\n");
                                    }
                                }
                            }else{
                                $val3 = $this->convert($val3);
                                print("<input type=\"hidden\" name=\"{$key}[{$key2}][{$key3}]\" value=\"{$val3}\" />\n");
                            }
                        }
                    }else{
                        $val2 = $this->convert($val2);
                        print("<input type=\"hidden\" name=\"{$key}[{$key2}]\" value=\"{$val2}\" />\n");
                    }
                }
            }else{
                $val = $this->convert($val);
                print("<input type=\"hidden\" name=\"{$key}\" value=\"{$val}\" />\n");
            }
        }
    }

//    function request2hidden_sub($key,$val,$array){
//        if(is_array($val)){
//            foreach($val as $key2 => $val2){
//                $keystr = $key."[{$key2}]";
//                $ret = $this->request2hidden_sub($keystr,$val2,$array);
//            }
//        }else{
//            $array[$key] = $this->convert($val);
//        }
//        return true;
//    }
}
?>
