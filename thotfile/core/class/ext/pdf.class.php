<?php

class PdfFile extends FileAnalytics{
	var $file;

	function __construct($file){
		$this->file = $file;

	}

	function getMeta(){
		$p = new PDFInfo();
		$p->load($this->file);

		$this->info = array('title'=>$p->title,'author'=>$p->author,'pages'=>$p->pages);
		$this->info['preview'] = '<iframe width="100%" src="'.$this->getPreview().'"></iframe>';
	}



}

?>