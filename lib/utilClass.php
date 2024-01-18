<?php
class util {
	function __construct() {
	}

	function Atag($str,$url,$target=FALSE){
		$tag=$str;
		if($url){
			$trg='';
			if($target){
				$trg.=' target="'.$target.'"';
			}
			$tag='<a href="'.$url.'"'.$trg.'>'.$tag.'</a>';
		}
		//var_dump($tag);
		return $tag;
	}

	function RequestVal($key,$default=null) {
		$val = $default;
		if (isset($_REQUEST[$key])) {
			if(is_array($_REQUEST[$key])){
				$val = array();
				foreach($_REQUEST[$key] as $lkey => $lval){
                    if(is_array($lval)){
                        foreach($lval as $lkey2 => $lval2){
                            if(is_array($lval2)){
                                foreach($lval2 as $lkey3 => $lval3){
                                    if(is_array($lval3)){
                                        foreach($lval3 as $lkey4 => $lval4){
                                            $val[$lkey][$lkey2][$lkey3][$lval4] = $this->replaceStr($lval4);
                                        }
                                    }else{
                                        $val[$lkey][$lkey2][$lkey3] = $this->replaceStr($lval3);
                                    }
                                }
                            }else{
                                $val[$lkey][$lkey2] = $this->replaceStr($lval2);
                            }
                        }
                    }else{
                        $val[$lkey] = $this->replaceStr($lval);
                    }
				}
			}else{
				$val = $this->replaceStr($_REQUEST[$key]);
			}
		}
		return $val;
	}

    function replaceStr($str){
        $_mb_wquote = '”';
        $_mb_quote = '’';
        $_mb_semicolon = '；';
        $_mb_yen = '￥';
        $_mb_parcent = '％';

        $str = str_replace('"',$_mb_wquote,$str);
        $str = str_replace("'",$_mb_quote,$str);
        $str = str_replace(';',$_mb_semicolon,$str);
        $str = str_replace('\\',$_mb_yen,$str);
        return htmlspecialchars($str);
    }

    function decodeStr($str){
        $_mb_wquote = '”';
        $_mb_quote = '’';
        $_mb_semicolon = '；';
        $_mb_yen = '￥';
        $_mb_parcent = '％';

        $str = mb_ereg_replace($_mb_wquote,'"',$str);
        $str = mb_ereg_replace($_mb_quote,"'",$str);
        $str = mb_ereg_replace($_mb_semicolon,';',$str);
        $str = mb_ereg_replace($_mb_yen,'\\',$str);
        return htmlspecialchars_decode($str);
    }

	function statusNum($cstatus,$start=FALSE,$end=FALSE) {
		if($cstatus==30) {
			return 0;
		}
		if(!empty($start) AND !empty($end)){
			$now=time();//$thisSite->gettime();
			if($start>$now) {
				return 2;
			}else if($end<$now) {
				return 3;
			}
		}
		return 1;
	}
	function statusMbname($status,$mb=FALSE) {
		if(empty($mb)){
			$mb=array(
				0=>'下書き',
				1=>'公開中',
				2=>'未公開',
				3=>'終了',
				);
		}
		if(isset($mb[$status])){
			return $mb[$status];
		}
		return null;
	}

	function et_string($time,$format='Y/m/d H:i',$str='無期限') {
		$ut=strtotime($time);
		if(INDEFINITE == date("Y",$ut)){
			return $str;
		}
		return date($format,$ut);
	}

	function is_valid($val){
		if(is_null($val)){
			return false;
		}
		$val = trim($val);
		if(!strlen($val)){
			return false;
		}
		return true;
	}

// ----------------------------------------------------------------

	function mb_enc_mimeheader( $str ) {
		$str = mb_convert_encoding($str,"JIS");
		$str = '=?'.'iso-2022-jp?B?'. base64_encode($str) .'?=';

		return $str;
	}
	function mb_mail( $To, $Subject, $body, $headers=NULL, $add_param=NULL ) {
		$Subject = mb_encode_mimeheader($Subject);
		$body = mb_convert_encoding($body,"JIS");

		$headers .= "Mime-Version: 1.0\n";
		$headers .= "Content-Transfer-Encoding: 7bit\n";
		$headers .= "Content-Type: text/plain; charset=iso-2022-jp\n";

		//$Ret = mail($To, $Subject, $body, $headers, $add_param);
		$Ret = mail($To, $Subject, $body, $headers /*, $add_param */);
		//$Ret = mb_send_mail($To, $Subject, $body, $headers /*, $add_param */);


		return $Ret;
	}

	function make_uniqkey( $Mode, $len=NULL ) {
		settype($len,"int");

		switch( $Mode ) {
			case "N":
				$Val = mt_rand();
			break;
			case "NN":
				$Val = mt_rand() . mt_rand();
			break;
			case "A":
				$Val = md5( uniqid(mt_rand(),1) );
			break;
			case "TS":
				$Val = date("YmdHis");
			break;
			case "MT":
				$Val = str_replace(' ','',substr(microtime(),2));
			break;
			case "C":
				$Chr = "abcdefghkmnpqrstuvwxyzABCDEFGHJKLMNPQRSTUVWXYZ2345679";
				srand((double)microtime() * 54234853);
				$Val = str_shuffle($Chr);
				/**
				PHP_VERSION < 4.3.0
				$Buff = preg_split("//", $Chr, -1, PREG_SPLIT_NO_EMPTY);
				shuffle( $Buff );
				$Val = implode("",$Buff);
				**/
			break;
			case "C2":
				$Chr = "abcdefghkmnpqrstuvwxyzABCDEFGHJKLMNPQRSTUVWXYZ2345679!#$%&()=-@_";
				srand((double)microtime() * 54234853);
				$Val = str_shuffle($Chr);
				/**
				PHP_VERSION < 4.3.0
				$Buff = preg_split("//", $Chr, -1, PREG_SPLIT_NO_EMPTY);
				shuffle( $Buff );
				$Val = implode("",$Buff);
				**/
			break;
			default:
				$Val = "9999999999";
			break;
		}

		if ( $len ) {
			return substr($Val,0,$len);
		} else {
			return $Val;
		}
	}

}
?>
