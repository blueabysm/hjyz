<?php
session_start();
include_once("../../util/commonFunctions.php");
canAcesssThisPage(15); 

include_once("../../database/mysqlDAO.php");
include("manageColumnsTreeClass.inc.php");

$myPageClass = new manageColumnsTreeClass($_POST,$_GET,$mysqldao,MAX_COLUMNS_DEPTH);
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
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<HTML>
<HEAD>
<title>我的栏目-树式</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<LINK href="../manage.css" type="text/css" rel="stylesheet">
<script src="../tree/TreeView.js"></script>
		<style>
		a, A:link, a:visited, a:active, A:hover
		{color: #000000; text-decoration: none; font-family: Tahoma, Verdana; font-size: 12px}
		</style>
</HEAD>
<body >
<br>
<table id="FormTable" cellSpacing="1" cellPadding="0" width="98%"
	align="center" bgColor="#ffffff" border="0" height="100%">
	<tr>
		<td class="FormCaption" align="center" bgColor="#668cd9">我的栏目(树式浏览) </td>
	</tr>
	<tr>
		<td vAlign="top" align="center" bgColor="#f1f3f5" height="100%">
		<table height="99%" cellSpacing="1" cellPadding="0" width="100%"
			align="center" bgColor="#ebebeb" border="0">			
			<tr>
				<td align="left" valign="top" bgcolor="white" width="15%" height="100%">
				<script>
					   var TREE_ITEMS = <?=$myPageClass->treeItemStr?>;
					   TREE_TPL['target'] = 'treeTarFrame';
					   var cTree = getNewTree(TREE_ITEMS);								   	   
				</script>				
				</td>
				<td valign="top" align="center" height="*">
				  <iframe name="treeTarFrame" id="subframe" src="../blank.php" height="1000px" width="100%" frameborder="0" ></iframe>
				</td>
			</tr>
		</table>
		</td>
	</tr>
</table>
</body>
</HTML>
