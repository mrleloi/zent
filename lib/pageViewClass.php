<?php
/****
version 2.07a lastmod 2010.08.27

2013.02.12	'$this->pagenumber_style_open_on' add by hattam
2012.06.29	'$this->pagenumber_style_open' add by hattam
			'$this->pagenumber_style_close' add by hattam
2010.08.27   multibyte-text put construct.
2010.08.02   method「setOrderType」add.
2010.07.30  「$this->pagepulldown」onChange "page"value reset.
2010.04.05   no limitType add.
2010.03.23 「$this->pagelink_nexttext」add.
				「$this->pagelink_backtext」add.
				「$this->pagenumber_ontext」add.
				「$this->pagenumber_offtext」add.
				「$this->pagenumber_separator」add.
2010.03.18   "function sortTitle" is modify for Ajax.
                「$this->sortorder_tmpprm」add.
2010.01.25 「$this->querys」add.
                「$this->numlist_start_cnt」 & 「$this->numlist_end_cnt」 add.
****/
class pageView {
	function __construct () {
		$this->sort=0;
		$this->order = 0;
		$this->page = 1;
		$this->limit = 1;
		$this->sortType=FALSE;
		$this->limitType = array(
				1=>50,
		);
		$this->limitStr=FALSE;
		$this->orderType = array(
				0=>'DESC',
				1=>'ASC',
		);
		$this->count=0;
		$this->otherParam=array();
		$this->maxpage=0;
		$this->pagepulldown='';
		$this->pagelink_next='';
		$this->pagelink_back='';
		$this->pagelink_next_for_sp='';
		$this->pagelink_next_for_new='';
		$this->pagelink_back_for_sp='';
		$this->pagelink_back_for_new='';
		$this->pagelink_nexttext="次の";
		$this->pagelink_backtext="前の";
		$this->pagelink_nexttext_for_sp="»";
		$this->pagelink_backtext_for_sp="«";
		$this->pagelink_basename='';
		$this->arrow_up='△';
		$this->arrow_down='▽';
		$this->startendtime_check=FALSE;
		$this->pageNumberlist='';
		$this->pageNumberlist_for_sp='';
		$this->pageNumberlist_for_new='';
		$this->pagenumber_ontext=$this->pagenumber_offtext=array();
		$this->pagenumber_separator='';
		$this->pagenumber_style_open='';
		$this->pagenumber_style_close='';
		$this->pagenumber_style_open_on='';
		$this->numlist_start_cnt=5;
		$this->numlist_end_cnt=5;

		$this->limitview_on=FALSE;
		$this->pagelist_on=TRUE;
		$this->formtype='get';
		$this->formname='form1';
		$this->defaultprm_on=FALSE;
		$this->page_defaultprm=array(
			'page',
			'limit',
			'order',
			'sort',
		);
		$this->pageStartnumber=0;
		$this->pageEndnumber=0;
		$this->querys=array();

		$this->sortorder_tmpprm=array();
	}

	function setFormname($prm) {
		$this->formname=$prm;
	}
	function setFormtype($prm){
		if(strtolower($prm)=='get' OR strtolower($prm)=='post'){
			$this->formtype=strtolower($prm);
		}
	}
	function setSortType($ary) {
		$this->sortType=$ary;
	}
	function setSort($prm) {
		$this->sort=$prm;
	}
	function setOrderType($ary){
		$this->orderType=$ary;
	}
	function setOrder($prm) {
		$this->order=$prm;
	}
	function setPage($prm) {
		if($prm) {
			$this->page=$prm;
		}
	}
	function setLimitType($ary,$str=FALSE) {
		$this->limitType=$ary;
		if($str){
			$this->limitStr=$str;
		}
	}
	function setLimit($prm) {
		$this->limit=$prm;
	}
	function setCount($prm) {
		$this->count=$prm;
	}
	function setMaxCount($prm) {
		$this->count=$prm;
	}
	function setOtherParam($key,$val) {
		$this->otherParam[$key]=$val;
	}
	function setLimitview_on() {
		$this->limitview_on = TRUE;
	}
	function setPagelist_on() {
		$this->pagelist_on = TRUE;
	}
	function setDefaultprm_on() {
		$this->defaultprm_on = TRUE;
	}
	function setNumlist_start_cnt($prm){
		$this->numlist_start_cnt=(int)$prm;
	}
	function setNumlist_end_cnt($prm){
		$this->numlist_end_cnt=(int)$prm;
	}
	function setPagelink_nexttext($prm) {
		$this->pagelink_nexttext=$prm;
	}
	function setPagelink_backtext($prm) {
		$this->pagelink_backtext=$prm;
	}
	function setPagelink_nexttext_for_sp($prm) {
		$this->pagelink_nexttext_for_sp=$prm;
	}
	function setPagelink_backtext_for_sp($prm) {
		$this->pagelink_backtext_for_sp=$prm;
	}
	function setPagelink_basename($prm) {
		$this->pagelink_basename=$prm;
	}
	function setPagenumber_ontext($prm) {
		$this->pagenumber_ontext=$prm;
	}
	function setPagenumber_offtext($prm) {
		$this->pagenumber_offtext=$prm;
	}
	function setPagenumber_separator($prm) {
		$this->pagenumber_separator=$prm;
	}
	function setPagenumber_style($opentag,$closetag,$opentag_on=null) {
		$this->pagenumber_style_open=$opentag;
		$this->pagenumber_style_close=$closetag;
		$this->pagenumber_style_open_on=$opentag_on;
	}

	function getSortType() {
		return $this->sortType;
	}
	function getSort() {
		return $this->sort;
	}
	function getOrder() {
		return $this->order;
	}
	function getPage() {
		return $this->page;
	}
	function getLimit() {
		return $this->limit;
	}
	function getLimitType() {
		return $this->limitType;
	}
	function getCount() {
		return $this->count;
	}
	function getMaxCount() {
		return $this->count;
	}
	function getRealLimit() {
		if(isset($this->limitType[$this->limit])){
			return $this->limitType[$this->limit];
		}
		return 0;
	}
	function getOffset() {
		return ($this->page -1) * $this->getRealLimit();
	}

	function getLimitview_on() {
		return $this->limitview_on;
	}
	function getPagelist_on() {
		return $this->pagelist_on;
	}

	function startendtimeCK() {
		$ck=FALSE;
		if(is_array($this->sortType)) {
			$ck = array_search('startendtime',$this->sortType);
		}
		if($ck!==FALSE) {
			if($this->order) {
				$this->sortType[$ck] = 'endtime';
			}else{
				$this->sortType[$ck] = 'starttime';
			}
		}
		$this->startendtime_check=TRUE;
	}
	function getSQLparam() {
		if(!$this->startendtime_check) {
			$this->startendtimeCK();
		}
		$offset = $this->getOffset();
		$SQL = '';
		if(isset($this->sortType[$this->sort]) && $this->sortType[$this->sort]) {
			$SQL .= "order by ".$this->sortType[$this->sort]." ".$this->orderType[$this->order]." ";
		}
		if($this->limitType && isset($this->limitType[$this->limit])){
			$SQL .= "limit ".$this->limitType[$this->limit]." offset ".$offset;
		}
		return $SQL;
	}
	function getSQLparamAry() {
		if(!$this->startendtime_check) {
			$this->startendtimeCK();
		}
		$offset = $this->getOffset();
		$SQL = FALSE;
		if(isset($this->sortType[$this->sort])) {
			$SQL['order'] = "order by ".$this->sortType[$this->sort]." ".$this->orderType[$this->order]." ";
		}
		if($this->limitType && isset($this->limitType[$this->limit])){
			$SQL['limit'] = "limit ".$this->limitType[$this->limit]." offset ".$offset;
		}
		return $SQL;
	}
	function getSQLparamArray() {
		if(!$this->startendtime_check) {
			$this->startendtimeCK();
		}
		$SQL = FALSE;
		$offset = $this->getOffset();
		if($offset) {
			$SQL['offset'] = $offset;
		}
		if(isset($this->sortType[$this->sort])) {
			$SQL['order'] = $this->sortType[$this->sort]." ".$this->orderType[$this->order];
		}
		if($this->limitType && isset($this->limitType[$this->limit])){
			$SQL['limit'] = $this->limitType[$this->limit];
		}
		return $SQL;
	}
	function sortTitle($title,$key) {
		$Ret = '';
		if(!$this->sortorder_tmpprm){
			if($this->otherParam){
				$prm=$this->otherParam;
			}else{
				$prm=array();
			}
			$prm['limit']=$this->limit;
			$prm['page']=$this->page;
			$prm['order']=$this->order;
		}else{
			$prm=$this->sortorder_tmpprm;
		}
		$prm['sort']=$key;
		if($key==$this->sort){
			($prm['order'])?$prm['order']=0:$prm['order']=1;
			$mark = array(0 =>$this->arrow_down,1 =>$this->arrow_up);
			$title= "<strong>".$title."</strong>";
		}
		$this->sortorder_tmpprm=$prm;
		if($this->formtype=='get'){
			if(isset($mark)){
				$Ret =$title.'<a href="./'.$this->pagelink_basename.'?'.htmlspecialchars(http_build_query($prm)).'">'.$mark[$prm['order']].'</a>';
			}else{
				$Ret ='<a href="./'.$this->pagelink_basename.'?'.htmlspecialchars(http_build_query($prm)).'">'.$title.'</a>';
			}
		}else{
			$prm_keys=array_keys($prm);
			$make_hidden='';
			foreach($prm_keys as $k){
				if(!in_array($k,$this->page_defaultprm)){
					$make_hidden.="make_hidden('".$k."','".$prm[$k]."','".$this->formname."');";
				}
			}
			if(isset($mark)){
				$Ret =$title.'<a href="javascript:void(0);" onclick="'.$make_hidden."chgValue_name('order',".$prm['order'].');'.$this->formname.'.submit();return false;">'.$mark[$prm['order']].'</a>';
			}else{
				$Ret ='<a href="javascript:void(0);" onclick="'.$make_hidden."chgValue_name('sort',".$prm['sort'].');'.$this->formname.'.submit();return false;">'.$title.'</a>';
			}
		}
		return $Ret;
	}

	function preloadPage() {
#		if($this->count) {
			$option=array();
			if($this->sortType) {
				$option['sort']=$this->sort;
				$option['order']=$this->order;
			}
			if($this->otherParam) {
				foreach($this->otherParam as $key=>$val){
					$option[$key]=$val;
				}
			}
			$this->preMaxpage();
			$this->prePagelink($option);
			$this->prePulldown($option);
			$this->prePageNumber($option);

			$this->querys=$option;
			$this->querys['limit']=$this->limit;
			$this->querys['page']=$this->page;
#		}
	}
	function preMaxpage() {
//		$this->maxpage = ceil($this->count / $this->limitType[$this->limit]);
		if($this->limitType && isset($this->limitType[$this->limit])){
			$this->maxpage = ceil($this->count / $this->limitType[$this->limit]);
		}else{
			$this->maxpage=1;
		}
	}
	function prePagelink($prm) {
		$prm['limit']=$this->limit;
		$next_style = ' class="pagenation-back-next pagenation-next" ';
		$back_style = ' class="pagenation-back-next pagenation-back" ';
		$numPerPage = $this->limitType[$this->limit];
		if($this->formtype=='get'){
			$L1 = $this->pagenumber_style_open.'<a href="./'.$this->pagelink_basename.'?';
			$L2 = '">';
			$L3 = '</a>'.$this->pagenumber_style_close;
			if(($this->page + 1) > $this->maxpage) {
				$n = $this->maxpage;
				$next_style = ' class="pagenation-back-next pagenation-next v-hidden" ';
				$this->pagelink_next = $L1."page=".$n."&".htmlspecialchars(http_build_query($prm)).$next_style.$L2.$this->pagelink_nexttext.$numPerPage."件 ＞".$L3;
				$this->pagelink_next_for_sp = '<li><a href="./'.$this->pagelink_basename.'?"'." page=".$n."&".htmlspecialchars(http_build_query($prm)).$L2.$this->pagelink_nexttext_for_sp.'</a></li>';
				$this->pagelink_next_for_new = '<li><a href="./'.$this->pagelink_basename.'?"'." page=".$n."&".htmlspecialchars(http_build_query($prm)).$L2.$this->pagelink_nexttext_for_sp.'</a></li>';
			}else{
				$n = $this->page +1;
				$this->pagelink_next = $L1."page=".$n."&".htmlspecialchars(http_build_query($prm)).$next_style.$L2.$this->pagelink_nexttext.$numPerPage."件 ＞".$L3;
				$this->pagelink_next_for_sp = '<li><a href="./'.$this->pagelink_basename.'?"'." page=".$n."&".htmlspecialchars(http_build_query($prm)).$L2.$this->pagelink_nexttext_for_sp.'</a></li>';
				$this->pagelink_next_for_new = '<li><a href="./'.$this->pagelink_basename.'?"'." page=".$n."&".htmlspecialchars(http_build_query($prm)).$L2.$this->pagelink_nexttext_for_sp.'</a></li>';
			}
			if(($this->page - 1) < 1) {
				$b = 1;
				$back_style = ' class="pagenation-back-next pagenation-back v-hidden" ';
				$this->pagelink_back = $L1."page=".$b."&".htmlspecialchars(http_build_query($prm)).$back_style.$L2."＜ ".$this->pagelink_backtext.$numPerPage."件".$L3;
				$this->pagelink_back_for_sp = '<li><a href="./'.$this->pagelink_basename.'?"'." page=".$b."&".htmlspecialchars(http_build_query($prm)).$L2.$this->pagelink_backtext_for_sp.'</a></li>';
				$this->pagelink_back_for_new = '<li><a href="./'.$this->pagelink_basename.'?"'." page=".$b."&".htmlspecialchars(http_build_query($prm)).$L2.$this->pagelink_backtext_for_sp.'</a></li>';
			}else{
				$b = $this->page -1;
				$this->pagelink_back = $L1."page=".$b."&".htmlspecialchars(http_build_query($prm)).$back_style.$L2."＜ ".$this->pagelink_backtext.$numPerPage."件".$L3;
				$this->pagelink_back_for_sp = '<li><a href="./'.$this->pagelink_basename.'?"'." page=".$b."&".htmlspecialchars(http_build_query($prm)).$L2.$this->pagelink_backtext_for_sp.'</a></li>';
				$this->pagelink_back_for_new = '<li><a href="./'.$this->pagelink_basename.'?"'." page=".$b."&".htmlspecialchars(http_build_query($prm)).$L2.$this->pagelink_backtext_for_sp.'</a></li>';
			}
		}else{
//-----
				$prm_keys=array_keys($prm);
				$make_hidden='';
				foreach($prm_keys as $key){
					if(!in_array($key,$this->page_defaultprm)){
						$make_hidden.="make_hidden('".$key."','".$prm[$key]."','".$this->formname."');";
					}
				}
//-----
			$L1 = $this->pagenumber_style_open.'<a href="javascript:void(0);"';
			$L2 = '>';
			$L3 = '</a>'.$this->pagenumber_style_close;
			if(($this->page + 1) > $this->maxpage) {
				$n = $this->maxpage;
				$next_style = ' class="pagenation-back-next pagenation-next v-hidden" ';
				$this->pagelink_next = $L1.' onclick="'.$make_hidden."chgValue_name('page',".$n.');'.$this->formname.'.submit();return false;"'.$next_style.$L2.$this->pagelink_nexttext.$numPerPage."件 ＞".$L3;
				$this->pagelink_next_for_sp = '<li><a href="./'.$this->pagelink_basename.'?"'.' onclick="'.$make_hidden."chgValue_name('page',".$n.');'.$this->formname.'.submit();return false;"'.$L2.$this->pagelink_nexttext_for_sp.'</a></li>';
				$this->pagelink_next_for_new = '<li><a href="./'.$this->pagelink_basename.'?"'.' onclick="'.$make_hidden."chgValue_name('page',".$n.');'.$this->formname.'.submit();return false;"'.$L2.$this->pagelink_nexttext_for_sp.'</a></li>';
			}else{
				$n = $this->page +1;
				$this->pagelink_next = $L1.' onclick="'.$make_hidden."chgValue_name('page',".$n.');'.$this->formname.'.submit();return false;"'.$next_style.$L2.$this->pagelink_nexttext.$numPerPage."件 ＞".$L3;
				$this->pagelink_next_for_sp = '<li><a href="./'.$this->pagelink_basename.'?"'.' onclick="'.$make_hidden."chgValue_name('page',".$n.');'.$this->formname.'.submit();return false;"'.$L2.$this->pagelink_nexttext_for_sp.'</a></li>';
				$this->pagelink_next_for_new = '<li><a href="./'.$this->pagelink_basename.'?"'.' onclick="'.$make_hidden."chgValue_name('page',".$n.');'.$this->formname.'.submit();return false;"'.$L2.$this->pagelink_nexttext_for_sp.'</a></li>';
			}
			if(($this->page - 1) < 1) {
				$b = 1;
				$back_style = ' class="pagenation-back-next pagenation-back v-hidden" ';
				$this->pagelink_back = $L1.' onclick="'.$make_hidden."chgValue_name('page',".$b.');'.$this->formname.'.submit();return false;"'.$back_style.$L2."＜ ".$this->pagelink_backtext.$numPerPage."件".$L3;
				$this->pagelink_back_for_sp = '<li><a href="./'.$this->pagelink_basename.'?"'.' onclick="'.$make_hidden."chgValue_name('page',".$b.');'.$this->formname.'.submit();return false;"'.$L2.$this->pagelink_backtext_for_sp.'</a></li>';
				$this->pagelink_back_for_new = '<li><a href="./'.$this->pagelink_basename.'?"'.' onclick="'.$make_hidden."chgValue_name('page',".$b.');'.$this->formname.'.submit();return false;"'.$L2.$this->pagelink_backtext_for_sp.'</a></li>';
			}else{
				$b = $this->page -1;
				$this->pagelink_back = $L1.' onclick="'.$make_hidden."chgValue_name('page',".$b.');'.$this->formname.'.submit();return false;"'.$back_style.$L2."＜ ".$this->pagelink_backtext.$numPerPage."件".$L3;
				$this->pagelink_back_for_sp = '<li><a href="./'.$this->pagelink_basename.'?"'.' onclick="'.$make_hidden."chgValue_name('page',".$b.');'.$this->formname.'.submit();return false;"'.$L2.$this->pagelink_backtext_for_sp.'</a></li>';
				$this->pagelink_back_for_new = '<li><a href="./'.$this->pagelink_basename.'?"'.' onclick="'.$make_hidden."chgValue_name('page',".$b.');'.$this->formname.'.submit();return false;"'.$L2.$this->pagelink_backtext_for_sp.'</a></li>';
			}
		}
	}
	function prePulldown($prm) {
		if($this->limitType && isset($this->limitType[$this->limit])){
			$prm['page']=1;
			if($this->formtype=='get'){
				$this->pagepulldown = "<select name='limit' onChange='location.href=value'>";
				for ($i=1;$i<=count($this->limitType);$i++) {
					$checked='';
					$pullstr=$this->limitType[$i];
					if($this->limitStr && isset($this->limitStr[$i])){
						$pullstr=$this->limitStr[$i];
					}
					if($i==$this->limit) {
						$checked = ' selected';
					}
					//$this->pagepulldown .= '<option value="./?limit='.$i.'&'.htmlspecialchars(http_build_query($prm)).'"'.$checked.'>'.$pullstr.'</option>';
					$this->pagepulldown .= '<option value="./?limit='.$i.'&'.http_build_query($prm).'"'.$checked.'>'.$pullstr.'</option>';
				}
				$this->pagepulldown .= "</select>";
			}else{
//-----
					$prm_keys=array_keys($prm);
					$make_hidden='';
					foreach($prm_keys as $key){
						if(!in_array($key,$this->page_defaultprm)){
							$make_hidden.="make_hidden('".$key."','".$prm[$key]."','".$this->formname."');";
						}
					}
//-----
				$this->pagepulldown = '<select name="limit" onChange="'.$make_hidden."chgValue_name('limit',value);chgValue_name('page',1);".$this->formname.'.submit();return false;">';
				for ($i=1;$i<=count($this->limitType);$i++) {
					$checked='';
					$pullstr=$this->limitType[$i];
					if($this->limitStr && isset($this->limitStr[$i])){
						$pullstr=$this->limitStr[$i];
					}
					if($i==$this->limit) {
						$checked = ' selected';
					}
					$this->pagepulldown .= '<option value="'.$i.'"'.$checked.'>'.$pullstr.'</option>';
				}
				$this->pagepulldown .= "</select>";
			}
		}else{
			$this->limitview_on=FALSE;
		}
	}
	function prePageNumber($prm) {
		$startcnt=$this->numlist_start_cnt;
		$endcnt=$this->numlist_end_cnt;
		if(($startcnt+$endcnt+1) > $this->maxpage) {
			if($startcnt >= $this->maxpage) {
				$endcnt=0;
				$startcnt = $this->maxpage -1;
			}else{
				$endcnt = ($this->maxpage - $startcnt) - 1;
				if($endcnt < 0) {
					$endcnt = 0;
				}
			}
		}

		if(($this->page - $startcnt) < 1) {
			$startnumber = 1;
			$startremain = ($startcnt+1) - $this->page;
		}else{
			$startnumber = ($this->page - $startcnt);
			$startremain = 0;
		}
		if(($this->page + $endcnt) > $this->maxpage) {
			$endnumber = $this->maxpage;
			$endremain = $endcnt - ($this->maxpage - $this->page);
		}else{
			$endnumber = ($this->page + $endcnt);
			$endremain = 0;
		}
		$this->pageStartnumber = ($startnumber - $endremain);
		$this->pageEndnumber = ($endnumber + $startremain);

		//add 2009.10.08
		if($this->pageStartnumber!=$this->pageEndnumber){
			$prm['limit']=$this->limit;
			if($this->formtype=='get'){
				$L1 = '<a href="./'.$this->pagelink_basename.'?';
				$L2 = '">';
				$L2_on = '" class="on">';//->hattam 20101227 add
				$L3 =	'</a>';
				$pagelist='';
				$pagelist_for_sp='';
				$pagelist_for_new='';
				for($n=$this->pageStartnumber;$n<=$this->pageEndnumber;$n++){
					$str=$n;
					$on_page=false;
					if($this->page==$n){
						$on_page=true;
						if(isset($this->pagenumber_ontext[$n])){
							$str=$this->pagenumber_ontext[$n];
						}
					}else{
						if(isset($this->pagenumber_offtext[$n])){
							$str=$this->pagenumber_offtext[$n];
						}
					}
					if(!$pagelist){
						if($on_page){
//->hattam 20101227
//							$pagelist.=$str;
							$pagelist.=$L1."page=".$n.'&'.htmlspecialchars(http_build_query($prm)).$L2_on.$str.$L3;
							$pagelist_for_sp.='<li>'.$L1."page=".$n.'&'.htmlspecialchars(http_build_query($prm)).$L2_on.$str.$L3.'</li>';
							$pagelist_for_new.='<li class="current"><span>'.$str.'</span></li>';
//<-hattam
						}else{
							$pagelist.=$L1."page=".$n.'&'.htmlspecialchars(http_build_query($prm)).$L2.$str.$L3;
							$pagelist_for_sp.='<li>'.$L1."page=".$n.'&'.htmlspecialchars(http_build_query($prm)).$L2.$str.$L3.'</li>';
							$pagelist_for_new.='<li>'.$L1."page=".$n.'&'.htmlspecialchars(http_build_query($prm)).$L2.$str.$L3.'</li>';
						}
					}else{
						if($on_page){
//->hattam 20101227
//							$pagelist.=$this->pagenumber_separator.$str;
							$pagelist.=$this->pagenumber_separator.$L1."page=".$n.'&'.htmlspecialchars(http_build_query($prm)).$L2_on.$str.$L3;
							$pagelist_for_sp.='<li>'.$this->pagenumber_separator.$L1."page=".$n.'&'.htmlspecialchars(http_build_query($prm)).$L2_on.$str.$L3.'</li>';
							$pagelist_for_new.='<li class="current"><span>'.$str.'</span></li>';
//<-hattam
						}else{
							$pagelist.=$this->pagenumber_separator.$L1."page=".$n.'&'.htmlspecialchars(http_build_query($prm)).$L2.$str.$L3;
							$pagelist_for_sp.='<li>'.$this->pagenumber_separator.$L1."page=".$n.'&'.htmlspecialchars(http_build_query($prm)).$L2.$str.$L3.'</li>';
							$pagelist_for_new.='<li>'.$this->pagenumber_separator.$L1."page=".$n.'&'.htmlspecialchars(http_build_query($prm)).$L2.$str.$L3.'</li>';
						}
					}
				}
			}else{
//-----
				$prm_keys=array_keys($prm);
				$make_hidden='';
				foreach($prm_keys as $key){
					if(!in_array($key,$this->page_defaultprm)){
						$make_hidden.="make_hidden('".$key."','".$prm[$key]."','".$this->formname."');";
					}
				}
//-----
				$L1 = $this->pagenumber_style_open.'<a href="javascript:void(0);"';
				$L1_on = $this->pagenumber_style_open_on.'<a href="javascript:void(0);"';
				$L2 = '>';
				$L2_on = ' class="on">';//->hattam 20110204 add
				$L3 = '</a>'.$this->pagenumber_style_close;
				$pagelist='';
				$pagelist_for_sp='';
				$pagelist_for_new='';
				for($n=$this->pageStartnumber;$n<=$this->pageEndnumber;$n++){
					$str=$n;
					$on_page=false;
					if($this->page==$n){
						$on_page=true;
						if(isset($this->pagenumber_ontext[$n])){
							$str=$this->pagenumber_ontext[$n];
						}
					}else{
						if(isset($this->pagenumber_offtext[$n])){
							$str=$this->pagenumber_offtext[$n];
						}
					}
					if(!$pagelist){
						if($on_page){
//->hattam 20110204
//							$pagelist.=$str;
							if(!empty($this->pagenumber_style_open_on)){
								$pagelist.=$L1_on.$L2.$str.$L3;
								$pagelist_for_sp.='<li>'.$L1_on.$L2.$str.$L3.'</li>';
								$pagelist_for_new.='<li class="current"><span>'.$str.'</span></li>';
							}else{
								$pagelist.=$L1.$L2_on.$str.$L3;
								$pagelist_for_sp.='<li>'.$L1.$L2_on.$str.$L3.'</li>';
								$pagelist_for_new.='<li class="current"><span>'.$str.'</span></li>';
							}
//<-hattam
						}else{
							$pagelist.=$L1.' onclick="'.$make_hidden."chgValue_name('page',".$n.');'.$this->formname.'.submit();return false;"'.$L2.$str.$L3;
							$pagelist_for_sp.='<li>'.$L1.' onclick="'.$make_hidden."chgValue_name('page',".$n.');'.$this->formname.'.submit();return false;"'.$L2.$str.$L3.'</li>';
							$pagelist_for_new.='<li>'.$L1.' onclick="'.$make_hidden."chgValue_name('page',".$n.');'.$this->formname.'.submit();return false;"'.$L2.$str.$L3.'</li>';
						}
					}else{
						if($on_page){
//->hattam 20110204
//							$pagelist.=$this->pagenumber_separator.$str;
							if(!empty($this->pagenumber_style_open_on)){
								$pagelist.=$this->pagenumber_separator.$L1_on.$L2.$str.$L3;
								$pagelist_for_sp.='<li>'.$this->pagenumber_separator.$L1_on.$L2.$str.$L3.'</li>';
								$pagelist_for_new.='<li class="current"><span>'.$str.'</span></li>';
							}else{
								$pagelist.=$this->pagenumber_separator.$L1.$L2_on.$str.$L3;
								$pagelist_for_sp.='<li>'.$this->pagenumber_separator.$L1.$L2_on.$str.$L3.'</li>';
								$pagelist_for_new.='<li class="current"><span>'.$str.'</span></li>';
							}
//<-hattam
						}else{
							$pagelist.=$this->pagenumber_separator.$L1.' onclick="'.$make_hidden."chgValue_name('page',".$n.');'.$this->formname.'.submit();return false;"'.$L2.$str.$L3;
							$pagelist_for_sp.='<li>'.$this->pagenumber_separator.$L1.' onclick="'.$make_hidden."chgValue_name('page',".$n.');'.$this->formname.'.submit();return false;"'.$L2.$str.$L3.'</li>';
							$pagelist_for_new.='<li>'.$this->pagenumber_separator.$L1.' onclick="'.$make_hidden."chgValue_name('page',".$n.');'.$this->formname.'.submit();return false;"'.$L2.$str.$L3.'</li>';
						}
					}
				}
			}
			$this->pageNumberlist=$pagelist;
			$this->pageNumberlist_for_sp=$pagelist_for_sp;
			$this->pageNumberlist_for_new=$pagelist_for_new;
		}
	}
	function printPageHidden(){
#$this->formname
	}

	function getMaxpage() {
		return $this->maxpage;
	}
	function getPagepulldown() {
		return $this->pagepulldown;
	}
	function getPagelink_next() {
		return $this->pagelink_next;
	}
	function getPagelink_back() {
		return $this->pagelink_back;
	}
	function getPagelink_next_for_sp() {
		return $this->pagelink_next_for_sp;
	}
	function getPagelink_next_for_new() {
		return $this->pagelink_next_for_new;
	}
	function getPagelink_back_for_sp() {
		return $this->pagelink_back_for_sp;
	}
	function getPagelink_back_for_new() {
		return $this->pagelink_back_for_new;
	}
	function getPagelink_nexttext() {
		return $this->pagelink_nexttext;
	}
	function getPagelink_backtext() {
		return $this->pagelink_backtext;
	}
	function getPagelink_nexttext_for_sp() {
		return $this->pagelink_nexttext_for_sp;
	}
	function getPagelink_backtext_for_sp() {
		return $this->pagelink_backtext_for_sp;
	}
	function getOtherParam() {
		return $this->otherParam;
	}
	function getPageStartnumber() {
		return $this->pageStartnumber;
	}
	function getPageEndnumber() {
		return $this->pageEndnumber;
	}
	function getPagePeriod($page) {
		if($this->limitType && isset($this->limitType[$this->limit])){
			$cnt = $this->limitType[$this->limit]*$page;
		}else{
			return $this->count;
		}
		if($this->count < $cnt) {
			return $this->count;
		}
		return $cnt;
	}
	function getPageNumberList(){
		return $this->pageNumberlist;
	}
	function getPageNumberList_for_sp(){
		return $this->pageNumberlist_for_sp;
	}
	function getPageNumberList_for_new(){
		return $this->pageNumberlist_for_new;
	}
	function getFormname(){
		return $this->formname;
	}
	function getFormtype(){
		return $this->formtype;
	}
	function getQuerys(){
		return $this->querys;
	}

	function setConfig($config) {
		if (!empty($config['formType'])) {
			$this->setFormtype($config['formType']);
		}

		if (!empty($config['formname'])) {
			$this->setFormname($config['formname']);
		}

		$this->setLimitview_on();

		if (!empty($config['limitType'])) {
			$this->setLimitType($config['limitType']);
		}

		if (!empty($config['sortType'])) {
			$this->setSortType($config['sortType']);
		}

		if (!empty($config['sort'])) {
			$this->setSort($config['sort']);
		}

		if (!empty($config['order'])) {
			$this->setOrder($config['order']);
		}

		if (!empty($config['page'])) {
			$this->setPage($config['page']);
		}

		if (!empty($_POST["submit_btn"])) {
			$this->setPage(1);
		}

		if (!empty($config['limit'])) {
			$this->setLimit($config['limit']);
		} else {
			$this->setLimit(2);
		}

		$this->setMaxCount($config['maxCount']);
	}
}
?>
