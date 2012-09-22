<?php
session_start();
include_once("../../util/commonFunctions.php");
canAcesssThisPage(14); 

include_once("../../database/mysqlDAO.php");
include("manageColumnsAdminTreeClass.inc.php");

$myPageClass = new manageColumnsAdminTreeClass($_POST,$_GET,$mysqldao,MAX_COLUMNS_DEPTH);
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
<title>栏目管理-树式</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<LINK href="../manage.css" type="text/css" rel="stylesheet">
<script src="../tree/TreeView.js"></script>
		<style>
		a, A:link, a:visited, a:active, A:hover
		{color: #000000; text-decoration: none; font-family: Tahoma, Verdana; font-size: 12px}
		</style>
<script type="">
  	function delCol(id)
	{
		if ( confirm("你确定要删除该栏目吗？") == false) return false;
		window.location="deleteColumns.php?id=" + id + "&page=<?echo $myPageClass->to_page?>";
		return false;
	}    
</script>
</HEAD>
<body >
<br>
<form name="Form1" method="post" action="manageColumnsAdmin.php" id="Form1">
<table id="FormTable" cellSpacing="1" cellPadding="0" width="98%"
	align="center" bgColor="#ffffff" border="0" height="100%">
	<tr>
		<td class="FormCaption" align="center" bgColor="#668cd9">栏目管理-树式 </td>
	</tr>
	<tr>
		<td vAlign="middle" align="center" bgColor="#f1f3f5">
		<table height="99%" cellSpacing="1" cellPadding="0" width="100%"
			align="center" bgColor="#ebebeb" border="0">
			<tr>
				<td class="FormLabel" align="center" width="75%" colspan="2">
				
				</td>
			</tr>
			<tr>
				<td class="FormLabel" align="left" colspan="2">
				<a href='addColumns.php?retURL=../blank.php' target="treeTarFrame">添加栏目</a>			
				</td>
			</tr>
			<tr>
			 <td align="left" valign="top" bgcolor="white" width="15%">
				<script>
					   var TREE_ITEMS = <?=$myPageClass->treeItemStr?>;
					   TREE_TPL['target'] = 'treeTarFrame';
					   var cTree = getNewTree(TREE_ITEMS);
								   	   
				</script>				
			 </td>
			 <td valign="top" align="center">
				  <iframe name="treeTarFrame" src="../blank.php" height="100%" width="100%" frameborder="0" ></iframe>
			</td>
			</tr>
		</table>
		</td>
	</tr>
</table>
</form>
</body>
</HTML>
