<?php

class FileAnalytics{
	var $info,$f;


	function __construct($f){
		$this->file = $f;

	}

	function getFileInfo(){
		return $this->getFileData(array('name'=>basename($this->file),'type'=>'file','mime'=>mime_content_type($this->file),'path'=>$this->file));
	}

	function getFileData($args){
		$map = array(
			'application/pdf' => 'PdfFile',
			'image/jpeg' => 'ImageFile',
		);

		if(array_key_exists($args['mime'],$map)){
			$file = new $map[$args['mime']]($args['path']);
			$file->getMeta();
			return array_merge($args,$file->info);
		}else{
			return $args;
		}
	}

	function getPreview(){
		$this->generatePreview();
		return ROOT_URL_TMP.$this->getPreviewName();
	}

	function generatePreview(){
		if(!file_exists(ROOT_TMP.$this->getPreviewName()) && !copy($this->file, ROOT_TMP.$this->getPreviewName())){
			die("Can't generate file ".$this->file);
		}
	}
	function getPreviewName(){
		$ext = pathinfo($this->file, PATHINFO_EXTENSION);
		return md5($this->file).".$ext";
	}
}

?>