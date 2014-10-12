<?php

class DirAnalytics{
	var $dir;
	function __construct($dir){
		$this->dir = $dir;

	}

	function listFiles(){
		return $this->listFilesIn($this->dir);
	}

	function listFilesIn($dir) { 
	   $result = array();
	   if(!is_dir($dir))
	   	return $result;
	   $cdir = scandir($dir); 
	   foreach ($cdir as $key => $value) 
	   { 
	      if (!in_array($value,array(".",".."))) 
	      { 
	      	 $fullpath = $dir . DIRECTORY_SEPARATOR . $value;
	         if (is_dir($fullpath)) 
	         { 
	            $result[$value] = array('name'=>$value,'type'=>'dir','path'=>$fullpath); 
	         } 
	         else 
	         { 
	            $result[$value] = $this->getFileInfo(array('name'=>$value,'type'=>'file','mime'=>mime_content_type($fullpath),'path'=>$fullpath));
	         } 
	      } 
	   } 
	   
	   return $result; 
	}

	function getFileInfo($args){
		$map = array(
			'application/pdf' => 'PdfFile'
		);

		if(array_key_exists($args['mime'],$map)){
			$file = new $map[$args['mime']]($args['path']);
			$file->getMeta();
			return array_merge($args,$file->info);
		}else{
			return $args;
		}
	}

	function listAllFiles($dir) { 
	   $result = array(); 
	   $cdir = scandir($dir); 
	   foreach ($cdir as $key => $value) 
	   { 
	      if (!in_array($value,array(".",".."))) 
	      { 
	         if (is_dir($dir . DIRECTORY_SEPARATOR . $value)) 
	         { 
	            $result[$value] = array('name'=>$value,'type'=>'dir','files'=>$this->dirToArray($dir . DIRECTORY_SEPARATOR . $value)); 
	         } 
	         else 
	         { 
	            $result[] = array('name'=>$value,'type'=>'file','mime'=>'');
	         } 
	      } 
	   } 
	   
	   return $result; 
	} 
}

?>