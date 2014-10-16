<?php

class FileAnalytics{
	var $info,$f,$db;

	function __construct($f=false){
		global $base;
		if($f)
			$this->file = $f;
		$this->db = $base->selectDB(CURRENT_BASE);
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

	function indexIt(){
		$return = array('status'=>'success');
		$query = array( "path" => $this->file);
		$return['action'] = 'find';
		$fileIndex = $this->db->files->findOne($query);
		if(!$fileIndex){
			$fileInfo = $this->getFileInfo();
			$this->db->files->insert($fileInfo);
			$return['action'] = 'insert';
		}
		return $return;
	}
	function findIt($q){
		$return = array('status'=>'success');
		$where = array('$or'=>
			array(
			)
		);
		if(substr($q,0,1)=='/'){
			$q = substr($q,1);
			$q = str_replace(' ','([A-Za-z0-9-_\.\/]+)',$q);
			$where['$or'][] = array('path' => array('$regex' => new MongoRegex('/'.$q.'/i')));
		}else{
			$q = str_replace(' ','([A-Za-z0-9-_\.\/]+)',$q);
			$where['$or'][] = array('name' => array('$regex' => new MongoRegex('/'.$q.'/i')));
			$where['$or'][] = array('keywords' => array('$regex' => new MongoRegex('/'.$q.'/i')));
		}
		$fileIndex = $this->db->files->find($where);
		$results = array();
		while ($fileIndex->hasNext())
		{ 
        	$temp = $fileIndex->getNext(); 
        	$results[$temp['name']] = $temp; 
		}
		$return['results'] = $results;
		return $return;
	}
}

?>