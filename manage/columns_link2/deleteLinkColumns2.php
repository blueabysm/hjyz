<?php
session_start();
include_once("../../util/commonFunctions.php");
canAcesssThisPage(42); 

include_once("../../database/mysqlDAO.php");
include("deleteLinkColumns2Class.inc.php");

$myPageClass = new deleteLinkColumns2Class($_POST,$_GET,$mysqldao);
$myPageClass->Page_Load();
if(strlen($myPageClass->errorMessage)>=1){
	echo "<script>";
  	echo "window.alert('".$myPageClass->errorMessage."');";
  	echo "</script>";
}
if(strlen($myPageClass->toURL)>=1){
	echo "<script>";
  	echo "window.location='$myPageClass->toURL';";  	
  	echo "</script>";
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" >
<HTML>
<HEAD>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
</HEAD>
<body>
</body>
</HTML>