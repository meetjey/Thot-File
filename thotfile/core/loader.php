<?php
define('ROOT_PATH',$_SERVER['DOCUMENT_ROOT'].'/');
define('ROOT_TMP',ROOT_PATH.'tmp/');
define('ROOT_URL','http://www.thotfile.com/');
define('ROOT_URL_TMP',ROOT_URL.'tmp/');
require_once "libs/PDFInfo.php";
require_once "libs/formating.php";
require_once "libs/image.utils.php";
require_once "class/file.analytics.class.php";
require_once "class/ext/pdf.class.php";
require_once "class/ext/image.class.php";
require_once "class/dir.analytics.class.php";
?>