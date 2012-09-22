<?php
$rootPath = dirname(__FILE__);
$rootPath = substr($rootPath,0,stripos($rootPath,"database"));
include_once($rootPath."config".DIRECTORY_SEPARATOR."config.inc.php");
include_once($rootPath."database".DIRECTORY_SEPARATOR."GeneralDAO.inc.php");
$mysqldao = new MySQL_DAO(DB_HOST,DB_USER,DB_PASSWORD);
if ($mysqldao->openConn() == -1)
{
	header("location:".WEB_DIRECTORY_NAME."error.php?No=001");
	$mysqldao = NULL;
	exit;
}
if ($mysqldao->selectDB(DB_NAME) == -1)
{
	header("location:".WEB_DIRECTORY_NAME."error.php?No=002");
	$mysqldao = NULL;
	exit;
}
?>