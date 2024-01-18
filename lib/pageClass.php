<?php
require_once 'siteClass.php';

class page extends site {

	public $meta_description;
	public $meta_keywords;
	public $meta_title;
	public $meta_type;
	public $meta_url;
	public $meta_site_name;
	public $meta_image;
	public $app_id;
	public $site_title;
	public $head_title;
	public $page_title;
	public $corner_title;
	public $copyright;
	public $header_html;
	public $head_html;
	public $footer_html;
	public $error404_html;
	public $pankz_html;

	function __construct(){
		parent::__construct();

		$this->header_html = null;
		$this->head_html = null;
		$this->footer_html = null;
		$this->error404_html = null;
		$this->pankz_html = null;

		$this->meta_description = null;
		$this->meta_keywords = null;
		$this->meta_title = null;
		$this->meta_type = null;
		$this->meta_url = null;
		$this->meta_site_name = null;
		$this->meta_image = null;
		$this->app_id = null;
		$this->site_title = null;
		$this->head_title = null;
		$this->page_title = null;
		$this->corner_title = null;
		$this->copyright = null;
	}

	function getMetaDescription() {
		if (!empty($this->meta_description)) {
			return '<meta name="description" content="'.$this->meta_description.'" />';
		}
		return null;
	}
	function getMetaKeywords() {
		if (!empty($this->meta_keywords)) {
			return '<meta name="keywords" content="'.$this->meta_keywords.'" />';
		}
		return null;
	}
	function getMetaTitle() {
		if (!empty($this->meta_title)) {
			return '<meta name="title" content="'.$this->meta_title.'" />';
		}
		return null;
	}

	function getRequestUrl(){
		list($protocol,$hoge) = explode('/',strtolower($_SERVER['SERVER_PROTOCOL']));
		$url=$protocol."://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
		return $url;
	}
	function parseRequestUrl($url=false){
		if(!$url){$url=$this->getRequestUrl();}
		$data['url']=$url;
		$prms=@parse_url($url);
		if($prms==false){
			preg_match('/^((https?):\/\/)?([^\/]*)?(\/[^\?]+)\??(.*)$/',$url,$match);
			if($match){
				$prms['scheme']=$match[2];
				$prms['host']=$match[3];
				$prms['path']=$match[4];
				$prms['query']=$match[5];
			}
		}
		if(!empty($prms['scheme'])){
			$data['scheme']=$prms['scheme'];
		}else{
			list($data['scheme'],$hoge) = explode('/',strtolower($_SERVER['SERVER_PROTOCOL']));
		}
		if(!empty($prms['host'])){
			$data['host']=$prms['host'];
		}else{
			$data['host']=$_SERVER['HTTP_HOST'];
		}
		if(!empty($prms['path'])){
			$lastslash=strrpos($prms['path'],"/");
			$data['path']=substr($prms['path'],0,$lastslash);
			$data['file']=ltrim(substr($prms['path'],$lastslash),"/");
			$data['ext']=pathinfo(basename($prms['path']),PATHINFO_EXTENSION);
		}
		if(!empty($prms['query'])){
			$data['query']=$prms['query'];
		}
		return $data;
	}
}

?>
