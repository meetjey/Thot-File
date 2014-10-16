<?php
require_once "core/loader.php";
$isAction = (isset($_GET['ajax']))? true : false;
$action = (isset($_GET['action']))? $_GET['action'] : false;
if($isAction){
	$request_body = file_get_contents('php://input');
	$data = json_decode($request_body,true);
	switch ($action) {
		case 'list':
			if(!isset($data['where']))
				return;
			$dir = new DirAnalytics($data['where']);
			echo json_encode($dir->listFiles());
			break;
		case 'fileInfo':
			if(!isset($data['file']))
				return;
			$file = new FileAnalytics($data['file']);
			echo json_encode($file->getFileInfo());
			break;
		case 'index':
			if(!isset($data['file']))
				return;
			$file = new FileAnalytics($data['file']);
			echo json_encode($file->indexIt());
			break;
		case 'find':
			if(!isset($data['q']))
				return;
			$file = new FileAnalytics();
			echo json_encode($file->findIt($data['q']));
			break;
		default:
			# code...
			break;
	}
}else{
	require_once "view/index.html";
}
?>