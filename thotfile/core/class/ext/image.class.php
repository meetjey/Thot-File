<?php

class ImageFile extends FileAnalytics{
	var $file,$info;

	function __construct($file){
		$this->file = $file;

	}

	function getMeta(){
		$exif = exif_read_data($this->file, 'IFD0');

		//$this->info = array('title'=>$p->title,'author'=>$p->author,'pages'=>$p->pages);
	}

	
}

?>