<?php
global $r_prm;
global $thisPage;
global $thisForm;
global $_upfile;

if(!empty($_FILES) OR !isset($_REQUEST[$thisForm->get('FINISH_NAME')])){
	$r_imgnum=array(
		1=>array('af'=>2,'need'=>1),
		2=>array('af'=>5,'need'=>1),
		3=>array('af'=>6,'need'=>1),
		);
	$extlist=array(
		1=>array('mp3','wav','ogg','mp4','m4v','mov'),
		2=>array('gif','png','jpg','jpeg'),
		3=>array('gif','png','jpg','jpeg'),
		);

		if(!empty($r_imgnum)){
			foreach($r_imgnum as $i=>$sts){
				$imgs=$r_prm[$i];
				if($imgs){
					$ck_need=true;
					foreach($imgs as $ord=>$nm){
						if(isset($_REQUEST['delfile'.$i][$ord])){
							$r_prm[$i][$ord]='';
						}
						if(!empty($_FILES['file'.$i]['name'][$ord])){
							$f=strtolower($_FILES['file'.$i]['name'][$ord]);
							$isCheck = true;
							if(!empty($extlist[$i])){
								if(!preg_match("/\.(".implode('|',$extlist[$i]).")/",$f)){
									$error=$m[$sts['af']]=true;
									if(isset($afconf[$sts['af']]['title'])){
										$ckmes .= $afconf[$sts['af']]['title'].'に登録できる形式は、'.implode('/',$extlist[$i]).'になります<br>';
										$thisForm->_m[$sts['af']]=true;
										$thisForm->_error=true;
										$r_prm[$i][$ord]='';
										$isCheck = false;
									}
								}
							}
							
							if($isCheck && file_exists($_FILES['file'.$i]['tmp_name'][$ord])){
								var_dump($_upfile);
								$name=$_upfile->uploadOneFile($_FILES['file'.$i],$ord);
								$r_prm[$i][$ord] = $name;
	    						$nm = $name;
							}
						}
						if(empty($r_prm[$i][$ord])){$ck_need=false;}
					}
					if($sts['need'] && !$ck_need){
						$error=$m[$sts['af']]=true;
						if(isset($afconf[$sts['af']]['title'])){
							$ckmes .= $afconf[$sts['af']]['title'].'を選択してください<br>';
							$thisForm->_m[$sts['af']]=true;
							$thisForm->_error=true;
						}
					}
				}
			}
		}
}
?>
