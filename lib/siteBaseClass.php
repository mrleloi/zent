<?php

class siteBase {
	public $site_mode;

	public $site_top;
	public $sys_dir;
	public $top_dir;
	public $site_dir;
	public $common_dir;
	public $depend_dir;
	public $shared_dir;
	public $var_dir;
	public $cache_dir;
	public $db_dir;
	public $tmp_dir;
	public $embed_dir;
	public $flv_dir;
	public $mailtemplate_dir;
	public $template_dir;
	public $log_dir;
	public $bin_dir;

	public $top_path;
	public $shared_path;
	public $image_path;
	public $css_path;
	public $js_path;
	public $embed_path;
	public $flv_path;

	public $fitter_path;
	public $template_path;
	public $images_path;
	public $lang_path;

	public $subUri;
	public $lang;
	public $nomenu;

	protected $timestamp;
	protected $redirectStaus;

	protected $siteDomain;
	protected $adminTop;
	protected $mailDomain;
	protected $inquiryMail;
	protected $inquiryBackupMail;

	public $sslHost;
	public $sslUrl;
	public $siteUrl;
	public $mobileUrl;
	public $webUrl;//公開側URL
	public $previewUrl;
	public $clientNumber;
	public $site_number;
	public $mymenu_path;
	public $mymenu_unregist_path;
	public $hitaiou_path;
	public $toruca_path;
	public $cache_enable;

	public $useRewrite;

	protected $developSite;
	protected $testSite;

	function __construct(){
		if(isset($_SERVER['DOMAIN_NAME'])){
			$this->siteDomain = $_SERVER['DOMAIN_NAME'];
		}
		if(isset($_SERVER['admin_top'])){
			$this->adminTop = $_SERVER['admin_top'];
		}
		if(isset($_SERVER['MAIL_DOMAIN'])){
			$this->mailDomain = $_SERVER['MAIL_DOMAIN'];
		}
		if(isset($_SERVER['INQUIRY_MAIL'])){
			$this->inquiryMail = $_SERVER['INQUIRY_MAIL'];
		}
		if(isset($_SERVER['ENVFROM_MAIL'])){
			$this->envfromMail = $_SERVER['ENVFROM_MAIL'];
		}
		if(isset($_SERVER['SSL_HOST'])){
			$this->sslHost = $_SERVER['SSL_HOST'];
		}
		if(isset($_SERVER['SSL_URL'])){
			$this->sslUrl = $_SERVER['SSL_URL'];
		}
		if(isset($_SERVER['SITE_URL'])){
			$this->siteUrl = $_SERVER['SITE_URL'];
		}
		if(isset($_SERVER['MOBILE_URL'])){
			$this->mobileUrl = $_SERVER['MOBILE_URL'];
		}
		if(isset($_SERVER['WEB_URL'])){
			$this->webUrl = $_SERVER['WEB_URL'];
		}
		if(isset($_SERVER['ADMIN_URL'])){
			$this->adminUrl = $_SERVER['ADMIN_URL'];
		}
		if(isset($_SERVER['PREVIEW_URL'])){
			$this->previewUrl = $_SERVER['PREVIEW_URL'];
		}
		if(isset($_SERVER['ext1_url'])){
			$this->ext1_url = $_SERVER['ext1_url'];
		}
		if(isset($_SERVER['ext2_url'])){
			$this->ext2_url = $_SERVER['ext2_url'];
		}
		if(isset($_SERVER['ext3_url'])){
			$this->ext3_url = $_SERVER['ext3_url'];
		}

		if(isset($_SERVER['use_rewrite'])){
			$this->useRewrite = $_SERVER['use_rewrite'];
		}
		if(isset($_SERVER['site_mode'])){
			$this->site_mode = $_SERVER['site_mode'];
		}
		if(isset($_SERVER['sys_dir'])){
			$this->sys_dir = $_SERVER['sys_dir'];
		}
		if(isset($_SERVER['top_dir'])){
			$this->top_dir = $_SERVER['top_dir'];
		}
		if(isset($_SERVER['site_dir'])){
			$this->site_dir = $_SERVER['site_dir'];
		}
		if(isset($_SERVER['common_dir'])){
			$this->common_dir = $_SERVER['common_dir'];
		}
		if(isset($_SERVER['depend_dir'])){
			$this->depend_dir = $_SERVER['depend_dir'];
		}
		if(isset($_SERVER['shared_dir'])){
			$this->shared_dir = $_SERVER['shared_dir'];
		}
		if(isset($_SERVER['var_dir'])){
			$this->var_dir = $_SERVER['var_dir'];
		}
		if(isset($_SERVER['cache_dir'])){
			$this->cache_dir = $_SERVER['cache_dir'];
		}
		if(isset($_SERVER['db_dir'])){
			$this->db_dir = $_SERVER['db_dir'];
		}
		if(isset($_SERVER['tmp_dir'])){
			$this->tmp_dir = $_SERVER['tmp_dir'];
		}
		if(isset($_SERVER['embed_dir'])){
			$this->embed_dir = $_SERVER['embed_dir'];
		}
		if(isset($_SERVER['flv_dir'])){
			$this->flv_dir = $_SERVER['flv_dir'];
		}
		if(isset($_SERVER['mailtemplate_dir'])){
			$this->mailtemplate_dir = $_SERVER['mailtemplate_dir'];
		}
		if(isset($_SERVER['template_dir'])){
			$this->template_dir = $_SERVER['template_dir'];
		}
		if(isset($_SERVER['log_dir'])){
			$this->log_dir = $_SERVER['log_dir'];
		}
		if(isset($_SERVER['bin_dir'])){
			$this->bin_dir = $_SERVER['bin_dir'];
		}
		if(isset($_SERVER['top_path'])){
			$this->top_path = $_SERVER['top_path'];
		}
		if(isset($_SERVER['shared_path'])){
			$this->shared_path = $_SERVER['shared_path'];
		}
		if(isset($_SERVER['css_path'])){
			$this->css_path = $_SERVER['css_path'];
		}
		if(isset($_SERVER['js_path'])){
			$this->js_path = $_SERVER['js_path'];
		}
		if(isset($_SERVER['embed_path'])){
			$this->embed_path = $_SERVER['embed_path'];
		}
		if(isset($_SERVER['flv_path'])){
			$this->flv_path = $_SERVER['flv_path'];
		}
		if(isset($_SERVER['fitter_path'])){
			$this->fitter_path = $_SERVER['fitter_path'];
		}
		if(isset($_SERVER['template_path'])){
			$this->template_path = $_SERVER['template_path'];
		}
		if(isset($_SERVER['images_path'])){
			$this->images_path = $_SERVER['images_path'];
		}

		if(isset($_SERVER['category_root'])){
			$this->category_root = $_SERVER['category_root'];
		}else{
			$this->category_root = "01";
		}

		if(isset($_SERVER['REQUEST_URI'])){
			$this->subUri = substr($_SERVER['REQUEST_URI'],4);
		}

		if(isset($_SESSION['timestamp'])){
			$this->timestamp = $_SESSION['timestamp'];
		}

		if(isset($_SERVER['nomenu'])){
			$this->nomenu = true;
		}

        if(isset($_SESSION['lang'])){
            $this->lang = $_SESSION['lang'];
        }

		if(isset($_SERVER["REDIRECT_STATUS"])){
			$this->redirectStaus = $_SERVER["REDIRECT_STATUS"];
		}

		if(isset($_SERVER['site_top'])){
			$this->site_top = $_SERVER['site_top'];
		}

		if(isset($_SERVER['no_direct_add_cart'])){
			$this->no_direct_add_cart = $_SERVER['no_direct_add_cart'];
		}

		if(isset($_SERVER['no_add_cart'])){
			$this->no_add_cart = $_SERVER['no_add_cart'];
		}

		if(isset($_SERVER['mymenu_path'])){
			$this->mymenu_path = $_SERVER['mymenu_path'];
		}
		if(isset($_SERVER['mymenu_unregist_path'])){
			$this->mymenu_unregist_path = $_SERVER['mymenu_unregist_path'];
		}
		if(isset($_SERVER['hitaiou_path'])){
			$this->hitaiou_path = $_SERVER['hitaiou_path'];
		}
		if(isset($_SERVER['toruca_path'])){
			$this->toruca_path = $_SERVER['toruca_path'];
		}

		if(isset($_SESSION['cache_enable'])){
			$this->cache_enable = $_SESSION['cache_enable'];
		} else {
			$this->cache_enable = true;
		}

		if(!empty($_SERVER['test_mode'])){
			$this->testMode = true;
		}

		if(!empty($_SERVER['DEVELOP_SITE'])){
			$this->developSite = true;
		} else {
			$this->developSite = false;
		}
		if(!empty($_SERVER['TEST_SITE'])){
			$this->testSite = true;
		} else {
			$this->testSite = false;
		}

		if(isset($_SERVER["HTTP_X_FORWARDED_PROTO"])){
			$this->protocol = $_SERVER["HTTP_X_FORWARDED_PROTO"];
		}else{
			$this->protocol = "http";
		}

		$this->image_path = $this->relativePath("/images") . "/";
		$this->lang_path = $this->relativePath("/". $this->lang ) . "/";

		if(isset($_SERVER["REWRITE_TOP"])){
			$this->myPath=substr(dirname($_SERVER['PHP_SELF']),strlen($_SERVER["REWRITE_TOP"]));
		}elseif(isset($_SERVER['REQUEST_URI'])){
			$tmp=parse_url($_SERVER['REQUEST_URI']);
			$req=explode("/",rtrim($tmp['path'],'/'));
			$cur=explode("/",dirname($_SERVER['PHP_SELF']));
			krsort($req);#krsort($cur);
			$path='';
			foreach($req as $str){
				$cur_str=array_pop($cur);
				if($str!=$cur_str){break;}
				if($str){
					$path='/'.$str.$path;
				}
			}
			$this->myPath=$path;
		}

		$pre_include_path='';
		if(isset($this->depend_base)){
			$this->depend_my_base = rtrim($this->depend_base,'/').$this->myPath;
			$pre_include_path .= PATH_SEPARATOR . $this->depend_my_base;
		}
		if(isset($this->common_base)&&$this->common_base){
			$this->common_my_base = rtrim($this->common_base,'/').$this->myPath;
			$pre_include_path .= PATH_SEPARATOR . $this->common_my_base;
		}
		if(isset($this->site_base)&&$this->site_base){
			$this->site_my_base = rtrim($this->site_base,'/').$this->myPath;
			$pre_include_path .= PATH_SEPARATOR . $this->site_my_base;
		}
		if($pre_include_path){
			$newpath='.'.$pre_include_path.PATH_SEPARATOR.str_replace('.'.PATH_SEPARATOR,'',get_include_path());
			set_include_path($newpath);
		}
	}

	function settime($timestamp){
		$this->timestamp = $timestamp;
		$_SESSION['timestamp'] = $this->timestamp;
		return $this->timestamp;
	}
	function gettime(){
		if(isset($this->timestamp)){
			return $this->timestamp;
		}
		return time();
	}
	function resetTime(){
		if(isset($this->timestamp)){
			unset($this->timestamp);
		}
		if(isset($_SESSION['timestamp'])){
			unset($_SESSION['timestamp']);
		}
		return time();
	}

	function isMyDomain($url){
		if(strpos($url,"/")==0){
			return true;
		}else if(strpos($url,$_SERVER['HTTP_HOST'],7)===7){
			return true;
		}
		return false;
	}

	function is404redirected(){
		if($this->redirectStaus == 404){
			return true;
		}else{
			return false;
		}
	}

	function relativePath($RedPath) {
		if(substr($RedPath, 0, 1) == "/") {
			$SysPath = dirname($_SERVER['PHP_SELF']);
			if(substr($RedPath, -1) == "/"){
				$RedPath = substr($RedPath, 0, -1);
			}

			if(strlen($SysPath) == 1){
				return ".".$RedPath;
			}elseif(strcmp($SysPath,$RedPath) == 0){
				return "./";
			} else {
				$s_tmp = explode("/", $SysPath);
				$r_tmp = explode("/", $RedPath);
				$i = 0;
				while(($r_tmp[$i] == $s_tmp[$i]) && $i < 10){
					$i++;
					$tp = explode("/", $RedPath, ($i+1));
					$t_RedPath = end($tp);

					if($i == count($s_tmp)){
						return "./".$t_RedPath;
					}else{
						return str_repeat("../", count($s_tmp)-$i).$t_RedPath;
					}
				}
			}
		}else{
			return $RedPath;
		}
	}

//------------------------------------------------------------

	function GetDomainName() {
		return $this->siteDomain;
	}
	function GetMailDomain() {
		if (!empty($this->mailDomain)) {
			return $this->mailDomain;
		}
		return "example.com";
	}
	function SetInquiryMail($val) {
		$this->inquiryMail = $val;
	}
	function GetInquiryMail() {
		if (!empty($this->inquiryMail)) {
			return $this->inquiryMail;
		}
		return "no-reply@example.com";
	}
	function SetInquiryBackupMail($val) {
		$this->inquiryBackupMail = $val;
	}
	function GetInquiryBackupMail() {
		if (!empty($this->inquiryBackupMail)) {
			return $this->inquiryBackupMail;
		}
		return null;
	}
	function SetEnvfromMail($val) {
		$this->envfromMail = $val;
	}
	function GetEnvfromMail() {
		if (!empty($this->envfromMail)) {
			return $this->envfromMail;
		}
		return "verp@example.com";
	}
	function GetAdminTop() {
		return $this->adminTop;
	}
	function GetSiteUrl() {
		if (!empty($this->siteUrl)) {
			return $this->siteUrl;
		}
		return "/";//default
	}
	function GetMobileUrl() {
		if (!empty($this->mobileUrl)) {
			return $this->mobileUrl;
		}
		return "/";//default
	}
	function GetSSLUrl() {
		if (!empty($this->sslUrl)) {
			return $this->sslUrl;
		}
		return "/";//default
	}
	function developOnly() {
		return $this->developSite;
	}
	function testAndDevelopOnly() {
		if ($this->developSite OR $this->testSite) {
			return true;
		}
		return false;
	}
#preview func
	function setCacheEnable($status){
		$this->cache_enable = $status;
		$_SESSION['cache_enable'] = $this->cache_enable;
		return $this->cache_enable;
	}

	function isCacheEnable(){
		if(isset($this->cache_enable)){
			return $this->cache_enable;
		}
		return false;
	}

	function isPreview(){
		if(!empty($_SESSION['timestamp'])){
			return true;
		}
		return false;
	}

    function setLang($lang){
        $this->lang = $lang;
        $_SESSION['lang'] = $lang;
    }
    function getLang(){
        if(!empty($this->lang)){
            if(strpos($this->lang,'ja') !== FALSE){
                return 'ja';
            }else if(strpos($this->lang,'en') !== FALSE){
                return 'en';
            }else if(strlen($this->lang) > 2){
                return substr($this->lang,0,2);
            }else{
                return $this->lang;
            }
        }
        return 'ja';//default
    }
}

?>
