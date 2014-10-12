<?php
require_once "core/loader.php";
if(isset($_GET['ajax'])){
	$request_body = file_get_contents('php://input');
	$data = json_decode($request_body,true);
	if(!isset($data['where']))
		return;
	$dir = new DirAnalytics($data['where']);
	echo json_encode($dir->listFiles());
}else{
	require_once "view/index.html";
}
?>