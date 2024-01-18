<?php
	if(!isset($ERROR_COLOR)){$ERROR_COLOR = "color=#CC3300";}

	function ckm($prm){
		global $m;
		global $ERROR_COLOR;
		if(!empty($m[$prm])){
			return ($ERROR_COLOR);
		}
	};

	function disv($r,$val=null) {
		if(dv($r)==$val){return 'disabled';}
		return null;
	}
	function needv($r){
		if(afconf_val($r,'need')){return 'x';}
		return null;
	}
	function checkv($r){
		return afconf_val($r,'check');
	}
	function helpv($r){
		global $thisPage;
		if(afconf_val($r,'help')){
			return '<p class="tool" href="javascript:void(0);"><img src="'.$thisPage->shared_path.'/images/icon_help.png" class="icon" /><span style="bottom:1.5em; left:-5em;">'.afconf_val($r,'help').'</span></p>';
		}
		return null;
	}
	function commentv($r){
		if(afconf_val($r,'comment')){
			return '<br />'.afconf_val($r,'comment');
		}
		return null;
	}
	function afconf_val($r,$attr){
		global $afconf;
		if(isset($afconf[$r][$attr])){return $afconf[$r][$attr];}
		return null;
	}

	function dv($r){
		global $thisForm;
		if(isset($thisForm->_v[$r])){
			return $thisForm->_v[$r];
		}
		if(isset($_REQUEST[$r])){
			return $_REQUEST[$r];
		}
		return null;
	}

    function pdv($r,$value) {
		global $thisForm;
		if(isset($thisForm->_v[$r])){$rvalue = $thisForm->_v[$r];}else{$rvalue='';}
		if($value == $rvalue){
			return(" value=\"{$value}\" selected");
		}else{
			return(" value=\"{$value}\"");
		}
	}

    function cbv($r,$value){
		global $thisForm;
		if(isset($thisForm->_v[$r])){$rvalue = $thisForm->_v[$r];}else{$rvalue='';}
		//var_dump($rvalue);
		if($value == $rvalue){
			return("value=\"{$value}\" checked");
		}else{
			return("value=\"{$value}\"");
		}
	}
	
?>
