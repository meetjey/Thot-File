<?php
require_once "core/loader.php";
if(isset($_GET['ajax'])){
	if($_GET['action']=='list'){
		$request_body = file_get_contents('php://input');
		$data = json_decode($request_body,true);
		if(!isset($data['where']))
			return;
		$dir = new DirAnalytics($data['where']);
		echo json_encode($dir->listFiles());
	}else if($_GET['action']=='fileInfo'){
		$request_body = file_get_contents('php://input');
		$data = json_decode($request_body,true);
		if(!isset($data['file']))
			return;
		$file = new FileAnalytics($data['file']);
		echo json_encode($file->getFileInfo());
	}
}else{
	require_once "view/index.html";
}
?>