<?php
require_once 'siteBaseClass.php';

class site extends siteBase {
	protected $_db_config;
	protected $_db_conn;
	protected $_db_type;

	protected $add_header;
	protected $add_footer;

	protected $pankz_title;
	protected $pankz_link;

	function __construct(){
		parent::__construct();

		$this->initDb();
		$this->initAddHeader();
		$this->initAddFooter();
		$this->initPankz();
	}

//--------------------------------
	function initDb() {
		$this->_db_conn = null;
		$this->_db_type = null;
	}

	function setDb_config($var){
		$this->_db_config = $var;
	}
	function getDb_config($key=null){
		if(!empty($this->_db_config[$key])){
			return $this->_db_config[$key];
		}
		return false;
	}
	function setDb_conn($key,$var){
		$this->_db_conn[$key]=$var;
	}
	function getDb_conn($key=null){
		if(!empty($this->_db_conn[$key])){
			return $this->_db_conn[$key];
		}
		return false;
	}
	function setDb_type($key,$var){
		$this->_db_type[$key]=$var;
	}
	function getDb_type($key=null){
		if(!empty($this->_db_type[$key])) {
			return $this->_db_type[$key];
		}
		return $this->_db_type;
	}

//--------------------------------
	function initAddHeader() {
		$this->add_header = array();
	}
	function setAddHeader($str) {
		$this->add_header[] = $str;
	}
	function getAddHeader() {
		if (!empty($this->add_header)) {
			return implode("\n",$this->add_header);
		}
		return null;
	}
	function initAddFooter() {
		$this->add_footer = array();
	}
	function setAddFooter($str) {
		$this->add_footer[] = $str;
	}
	function getAddFooter() {
		if (!empty($this->add_footer)) {
			return implode("\n",$this->add_footer);
		}
		return null;
	}
	function initPankz() {
		$this->pankz_title = array();
		$this->pankz_link = array();
	}
	function popPankz() {
		if(!empty($this->pankz_title)){
			$title = array_pop($this->pankz_title);
		}else{
			$title = null;
		}
		if(!empty($this->pankz_link)){
			$link = array_pop($this->pankz_link);
		}else{
			$link = null;
		}
		return array('title' => $title,'link' => $link);
	}
	function setPankz($str,$link=null) {
		if(!empty($str)){
			$this->pankz_title[] = $str;
			$this->pankz_link[] = $link;
		}
	}
	function getPankzText($sep='＞'){
		$p_array = array();
		foreach($this->pankz_title as $i => $title){
			if (!empty($this->pankz_link[$i])) {
				$atagOpen = '<a href="'.$this->pankz_link[$i].'">';
				$atagClose = '</a>';
			} else {
				$atagOpen = null;
				$atagClose = null;
			}
			$p_array[] = $atagOpen . $title .$atagClose;
		}
		return implode($sep,$p_array);
	}
}
?>
