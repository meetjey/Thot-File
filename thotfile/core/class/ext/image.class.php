<?php

class ImageFile extends FileAnalytics{
	var $file;

	function __construct($file){
		$this->file = $file;

	}

	function getMeta(){

		$this->info = array('title'=>"",'author'=>"",'pages'=>"");
		$this->info['exif'] = cs_read_image_metadata ($this->file);
		$this->info['preview'] = '<img class="img-responsive" src="'.$this->getPreview().'" />';
	}

	function getPreviewName(){
		$ext = pathinfo($this->file, PATHINFO_EXTENSION);
		return md5($this->file).".$ext";
	}


	
}

?>