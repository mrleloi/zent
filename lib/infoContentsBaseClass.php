<?php
include_once 'infoBaseClass.php';

define("FIELD_TYPE_STRING",1);
define("FIELD_TYPE_NUMERIC",2);
define("FIELD_TYPE_DATETIME",3);
define("FIELD_TYPE_GEOMETRY",4);
define("FIELD_TYPE_TIME",5);

class infoContentsBase extends infoBase {
	var $_serverParam = array();
	var $_table = null;
	var $_fields = array();
	var $_fieldMap = array();

	function __construct ($db_no='slave') {//db_connection number
		$this->_upfileDir=false;
		$this->_uppath=null;

		parent::__construct($db_no);
		$this->setServerParam();
	}

// -------------------------------------------------------------

	function getFieldAttribute($fieldname) {
		if(isset($this->_fieldMap[$fieldname])){
			return $this->_fieldMap[$fieldname];
		}
		return null;
	}
	function getFieldKey($fieldname) {
		$attr = $this->getFieldAttribute($fieldname);
		if(!empty($attr) AND isset($attr[0])){
			return $attr[0];
		}
		return null;
	}
	function getFieldType($fieldname) {
		$attr = $this->getFieldAttribute($fieldname);
		if(!empty($attr) AND isset($attr[1])){
			return $attr[1];
		}
		return null;
	}

// -------------------------------------------------------------
// for admin
	function setAdminParam(){
		$this->setSQL_where('active=1');
		$this->setSQL_where('cstatus=10');
		$this->setSQL_order('direct_order ASC');
		$this->setSQL_order('starttime DESC');
	}

// -------------------------------------------------------------
// server param method
	function initServerParam(){
		$this->_serverParam['ipaddress'] = null;
		$this->_serverParam['host'] = null;
		$this->_serverParam['port'] = 0;
		$this->_serverParam['script'] = null;
		$this->_serverParam['ipf'] = null;
		$this->_serverParam['reffer'] = null;
		$this->_serverParam['agent'] = null;
	}

	function setServerParam(){
		$this->initServerParam();
		if(isset($_SERVER['REMOTE_ADDR'])){
			$this->_serverParam['ipaddress'] = $_SERVER['REMOTE_ADDR'];
		}
		if(isset($_SERVER['REMOTE_HOST'])){
			$this->_serverParam['host'] = $_SERVER['REMOTE_HOST'];
		}
		if(isset($_SERVER['REMOTE_PORT'])){
			$this->_serverParam['port'] = $_SERVER['REMOTE_PORT'];
		}
		if(isset($_SERVER['SCRIPT_NAME'])){
			$this->_serverParam['script'] = $_SERVER['SCRIPT_NAME'];
		}
		if(isset($_SERVER['HTTP_X_FORWARDED_FOR'])){
			$this->_serverParam['ipf'] = $_SERVER['HTTP_X_FORWARDED_FOR'];
		}
		if(isset($_SERVER['HTTP_REFERER'])){
			$this->_serverParam['reffer'] = $_SERVER['HTTP_REFERER'];
		}
		if(isset($_SERVER['HTTP_USER_AGENT'])){
			$this->_serverParam['agent'] = $_SERVER['HTTP_USER_AGENT'];
		}
	}

	function getServerParam($key){
		if(isset($this->_serverParam[$key])){
			return $this->_serverParam[$key];
		}
		return null;
	}

	function isServerParam($key){
		if(!empty($key) && array_key_exists($key,$this->_serverParam)){
			return true;
		}
		return false;
	}

	function setWebParam() {
		$today = date('Y-m-d H:i:s',$this->_site->gettime());
		$this->setSQL_where('cstatus=10');
		$this->setSQL_where('active=1');
		$this->setSQL_where('starttime<="'.$today.'"');
		$this->setSQL_where('endtime>="'.$today.'"');
		$this->setSQL_order('direct_order asc');
		$this->setSQL_order('starttime desc');
		if(!empty($this->_viewCnt)){
			$this->setSQL_limit($this->_viewCnt);
		}
	}

// -------------------------------------------------------------
// sql method

	function setQueryparam($prm,$v){
		$datetime_arr = array('starttime','endtime','ctime',);
		$now = date('Y-m-d H:i:s',$this->_site->gettime());
		foreach($this->_fieldMap as $field => $val){
			if($this->isServerParam($field)){
				$prm[$field] = $this->getServerParam($field);
			}else{
				$key=$this->getFieldKey($field);
				if(array_key_exists($key,$v)){
					$prm[$field] = $v[$key];
				}else if(FIELD_TYPE_NUMERIC==$this->getFieldType($field)){
					$prm[$field] = 0;
				}else if(FIELD_TYPE_DATETIME==$this->getFieldType($field) AND empty($v[$key])){
					$prm[$field] = $now;
				}else{
					$prm[$field] = null;
				}
			}
		}
		return $prm;
	}

	function addSQL($fields=false){
		if(!$fields){
			$fields = array_keys($this->_fieldMap);
		}
		foreach(array('active','ctime','mtime') as $fld){
			if(!in_array($fld,$fields)){
				$fields[] = $fld;
			}
		}
		return "insert into ".$this->getTable()." (".implode(',',$fields).') values (:'.implode(',:',$fields).')';
	}
	function add ($stmt,$v=array()) {
		$mtime = date('Y-m-d H:i:s',$this->_site->gettime());
		$prm = array(
			'active'	=> 1,
			'ctime'		=> $mtime,
			'mtime'		=> $mtime,
		);
		$prm=$this->setQueryParam($prm,$v);
		return parent::add($stmt,$prm);
	}

	function updateSQL($fields=false,$where=array('sid')){
		if(!$fields){
			$fields = array_keys($this->_fieldMap);
		}
		foreach(array('mtime','active') as $fld){
			if(!in_array($fld,$fields)){
				$fields[] = $fld;
			}
		}
		$sql='';
		$wsql='';
		foreach($fields as $fn){
			if($sql){
				$sql.=','.$fn.'=:'.$fn;
			}else{
				$sql=$fn.'=:'.$fn;
			}
		}
		if($where){
			$sql.=' where ';
			foreach($where as $fn){
				if($wsql){
					$wsql.=','.$fn.'=:'.$fn;
				}else{
					$wsql=$fn.'=:'.$fn;
				}
			}
		}
		return "update ".$this->getTable()." set ".$sql.$wsql;
	}
	function update($stmt,$v=array()) {
		$mtime = date('Y-m-d H:i:s',$this->_site->gettime());
		$prm = array(
			'mtime' => $mtime,
			'active'=>1,
		);
		$prm=$this->setQueryParam($prm,$v);
		return parent::update($stmt,$prm);
	}

	function deleteSQL($field='sid'){
		$sql = "update ".$this->getTable();
		$sql .= " SET active=:active";
		$sql .= ", mtime=:mtime";
		$sql .= " WHERE ".$field."=:".$field;
		return $sql;
	}
	function delete($stmt,$sid,$field='sid') {
		$mtime = date('Y-m-d H:i:s',$this->_site->gettime());
		$prm=array(
			'active'=>0,
			'mtime'=>$mtime,
			$field=>$sid,
		);
		$this->bind($stmt,$prm);
		return $this->change($stmt);
	}

// -------------------------------------------------------------
// filesystem method

	function uploadOneFile($file,$iid){
		if(empty($file["name"][$iid]) OR !file_exists($file['tmp_name'][$iid])){
			return null;
		}

		$ext = $this->getFileExtension($file['tmp_name'][$iid]);
		if(empty($ext)){
			$ext = '.'.pathinfo($file['name'][$iid],PATHINFO_EXTENSION);
		}
		$name = pathinfo($file['name'][$iid],PATHINFO_FILENAME);
		$un=$name;
		$name .= $ext;
		$path = rtrim($this->_upfileDir,'/').'/'.$name;
		$this->makeDirs($this->_upfileDir);
		if (FALSE == move_uploaded_file($file["tmp_name"][$iid],$path)) {
			$this->errDisp($file["error"][$iid]);
		}
		chmod($path,0666);
		return $name;
	}

	function filecheck($filename,$nums=array(0,0),$filepath=null){
		if(empty($filename)){return false;}
		$path=rtrim($this->_upfileDir,'/').'/';
		if(file_exists($path.$filename)){
			$ext=$this->getFileExtension($path.$filename);
			if(empty($ext)){
				$ext = '.'.pathinfo($path.$filename,PATHINFO_EXTENSION);
			}
			$newfile=sprintf("%04d-%02d-%s",$nums[0],$nums[1],date("YmdHis"));
			$newfile.=$ext;
			if(!empty($filepath)){
				$newpath=rtrim($filepath,'/').'/';
			}else{
				$newpath=$path;
			}

			$this->makeDirs($newpath);
			$ret=rename($path.$filename,$newpath.$newfile);
			if($ret){
				chmod($newpath.$newfile,0666);

				//横長画像は横360に、縦長画像は縦240にリサイズ
				//$newpath = $this->resize($newpath.$newfile,360,240);
				//$newfile=pathinfo($newpath,PATHINFO_BASENAME);
				return $newfile;
			}
		}
		return $filename;
	}

	function resize($filepath,$width,$height){
		if(empty($width) OR empty($height)){return $filepath;}

		$pathinfo=pathinfo($filepath);
		$newpath=$pathinfo['dirname'];
		$newpath.='/'.$pathinfo['filename'].'_r.'.$pathinfo['extension'];

		$size=GetImageSize($filepath);
		$ratio=$size[0]/$size[1];
		if($ratio > 1){
			//横長
			$height = $width / $ratio;//元画像の比率に合わせて高さを調整
		}else{
			//縦長
			$width = $height * $ratio;//元画像の比率に合わせて幅を調整
		}

		$file_type=exif_imagetype($filepath);
		switch($file_type){
		case IMAGETYPE_GIF:
			$in=ImageCreateFromGIF($filepath);
			$out=ImageCreateTrueColor($width,$height);

			$alpha=imagecolortransparent($in);
			imagefill($out,0,0,$alpha);
			imagecolortransparent($out,$alpha);
			break;
		case IMAGETYPE_JPEG:
			$in=ImageCreateFromJPEG($filepath);
			$out=ImageCreateTrueColor($width,$height);
			break;
		case IMAGETYPE_PNG:
			$in=ImageCreateFromPNG($filepath);
			$out=ImageCreateTrueColor($width,$height);
			break;
		default:
			return $filepath;
			break;
		}

		ImageCopyResampled($out,$in,0,0,0,0,$width,$height,$size[0],$size[1]);

		switch($file_type){
		case IMAGETYPE_GIF:
			ImageGIF($out,$newpath);
			break;
		case IMAGETYPE_JPEG:
			ImageJpeg($out,$newpath);
			break;
		case IMAGETYPE_PNG:
			ImagePNG($out,$newpath);
			break;
		}

		chmod($newpath,0666);
		return $newpath;
	}

	function getFileExtension($filepath){
		if(empty($filepath) OR !file_exists($filepath)){
			return null;
		}
		$ext=null;
		switch(exif_imagetype($filepath)){
		case IMAGETYPE_GIF:
			$ext='.gif';
			break;
		case IMAGETYPE_JPEG:
			$ext='.jpg';
			break;
		case IMAGETYPE_PNG:
			$ext='.png';
			break;
		case IMAGETYPE_BMP:
			$ext='.bmp';
			break;
		default:
			$tmp = pathinfo($filepath);
			if(!empty($tmp['extension'])){
				$ext='.'.$tmp['extension'];
			}
		}
		return $ext;
	}

	function getInprmFormat_starttime($y,$m,$d,$h,$i){
		if($y){
			return date('Y-m-d H:i:00',mktime($h,$i,0,$m,$d,$y));
		}else{
			return date('Y-m-d H:i:00');
		}
	}
	function getInprmFormat_endtime($y,$m,$d,$h,$i){
		if($y==INDEFINITE) {
			return INDEFINITE."-12-31 23:59:59";
		}else{
			return date('Y-m-d H:i:59',mktime($h,$i,0,$m,$d,$y));
		}
	}
	function getObjListSort($stmt,$nums,$field='sid') {
		/**$nums=$sid=>$direct_order**/
		$list=array();
		while($obj = $stmt->fetchObject()) {
			if(isset($nums[$obj->{$field}]) AND !isset($list[$nums[$obj->{$field}]])) {
				$list[$nums[$obj->{$field}]] = $obj;
			}else{
				if(isset($nums[$obj->{$field}])){
					$i=$nums[$obj->{$field}];
				}else{
					$i=0;
				}
				$isset=TRUE;
				while($isset) {
					$i++;
					if(!isset($list[$i])) {
						$list[$i]=$obj;
						$isset=FALSE;
					}
				}
			}
		}
		ksort($list);
		return $list;
	}
	function changeLine($line) {
		$order  = array("\r\n", "\n", "\r");
		return str_replace($order, "<br>", $line);
	}
//relate----


//creates directory tree recursively
	function makeDirs($strPath,$mode=0755) {
		return is_dir($strPath) or ($this->makeDirs(dirname($strPath),$mode) and mkdir($strPath,$mode));
	}

	// 大画像パスの取得
    function GetResizePathL($filepath) {
        $WIDTH = 750;
        $HEIGHT = 750;
        $suffix = "l";
        return $this->resizeSuffix($filepath, $suffix, $WIDTH, $HEIGHT);
    }

		// 指定パスの末尾指定リサイズ画像生成・パス文字列返却(既に画像が存在している場合、生成せずに末尾指定を追加した画像パスを返す)
		    private function resizeSuffix($filepath, $suffix, $width = 600, $height = 600) {

		        $pathinfo = pathinfo($filepath);
		        $returnPath = $pathinfo['dirname'] . "/" . $pathinfo["filename"] . "_" . $suffix . "." . $pathinfo["extension"];     // 表示用のパス
		        $newpath = rtrim($_SERVER["var_dir"], "/") . $returnPath;        // 生成用のパス
		        // リサイズ済みの画像がある場合、生成せずに画像パスを返す
		        if (file_exists($newpath)) {
		            return $returnPath;
		        }

		        $imgCheckPath = rtrim($_SERVER["SITE_URL"], "/") . $filepath;
		        $size = @getimagesize($imgCheckPath);
		        // 取得失敗
		        if (empty($size)) {
		            return false;
		        }
		        $ratio = $size[0] / $size[1];
		        if ($ratio > 1) {
		            //横長
		            $height = $width / $ratio; //元画像の比率に合わせて高さを調整
		        } else {
		            //縦長
		            $width = $height * $ratio; //元画像の比率に合わせて幅を調整
		        }

		        // リサイズ後のサイズが、元サイズよりも大きくならないようにする。
		        if ($width > $size[0] || $height > $size[1]) {
		            $width = $size[0];
		            $height = $size[1];
		        }

		        $file_type = exif_imagetype($imgCheckPath);
		        switch ($file_type) {
		            case IMAGETYPE_GIF:
		                $in = ImageCreateFromGIF($imgCheckPath);
		                $out = ImageCreateTrueColor($width, $height);

		                $alpha = imagecolortransparent($in);
		                imagefill($out, 0, 0, $alpha);
		                imagecolortransparent($out, $alpha);
		                break;
		            case IMAGETYPE_JPEG:
		                $in = ImageCreateFromJPEG($imgCheckPath);
		                $out = ImageCreateTrueColor($width, $height);
		                break;
		            case IMAGETYPE_PNG:
		                $in = ImageCreateFromPNG($imgCheckPath);
		                $out = ImageCreateTrueColor($width, $height);
		                break;
		            default:
		                return false;
		                break;
		        }

		        ImageCopyResampled($out, $in, 0, 0, 0, 0, $width, $height, $size[0], $size[1]);

		        switch ($file_type) {
		            case IMAGETYPE_GIF:
		                ImageGIF($out, $newpath);
		                break;
		            case IMAGETYPE_JPEG:
		                ImageJpeg($out, $newpath);
		                break;
		            case IMAGETYPE_PNG:
		                ImagePNG($out, $newpath);
		                break;
		        }

		        chmod($newpath, 0666);
		        return $returnPath;
		    }

}
?>
