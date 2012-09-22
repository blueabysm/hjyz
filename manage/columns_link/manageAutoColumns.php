<?php
session_start();
include_once("../../util/commonFunctions.php");
canAcesssThisPage(3,1,"../login.php"); 

include_once("../../database/mysqlDAO.php");
include("manageAutoColumnsClass.inc.php");

$myPageClass = new manageAutoColumnsClass($_POST,$_GET,$mysqldao);
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
<title>自动栏目管理</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<LINK href="../manage.css" type="text/css" rel="stylesheet">
</HEAD>
<body >
<br>
<form name="Form1" method="post" id="Form1">
<table id="FormTable" cellSpacing="1" cellPadding="0" width="98%"
	align="center" bgColor="#ffffff" border="0">
	<tr>
		<td class="FormCaption" align="center" bgColor="#668cd9">管理  <?=$myPageClass->autoColumnsName?></td>
	</tr>
	<tr>
		<td vAlign="middle" align="center" bgColor="#f1f3f5">
		<table height="99%" cellSpacing="1" cellPadding="0" width="100%"
			align="center" bgColor="#ebebeb" border="0">
			<tr>
				<td class="FormLabel" align="center" width="75%">				
				<a href="<?=$myPageClass->retURL?>">返回</a>
				</td>
			</tr>
			<tr>
				<td class="FormLabel" align="center" width="75%">
				栏目名称:
				<input type="text" maxlength="100" name="autoColumnsName" id="autoColumnsName" style="width: 300px;" value="<?=$myPageClass->autoColumnsName?>"/>
				<input type="submit" value="改名" name="btnReName" id="btnReName" />
				<input type="hidden" name="columnsID" id="columnsID" value="<?=$myPageClass->columnsID?>"/>
				<input type="hidden" name="retURL" id="retURL" value="<?=$myPageClass->retURL?>"/>
				</td>
			</tr>
		</table>
		</td>
	</tr>
</table>
</form>
</body>
</HTML>
