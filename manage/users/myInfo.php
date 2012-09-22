<?php
session_start();
include_once("../../util/commonFunctions.php");
canAcesssThisPage(12); 

include_once("../../database/mysqlDAO.php");
include("myInfoClass.inc.php");

$myPageClass = new myInfoClass($_POST,$_GET,$mysqldao);
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
		<title>修改个人信息</title>		
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<LINK href="../manage.css" type="text/css" rel="stylesheet">		
	</HEAD>
	<body >
	<br>
		<form id="editInfo" name="editInof" method="post">
			<table id="FormTable" cellSpacing="1" cellPadding="0" width="98%" align="center" bgColor="#ffffff"
				border="0">
				<tr>
					<td class="FormCaption" align="center" bgColor="#668cd9">修改个人信息</td>
				</tr>
				<tr>
					<td vAlign="middle" align="center" bgColor="#f1f3f5">
						<table cellSpacing="1" cellPadding="0" width="99%" align="center" bgColor="#ebebeb"
							border="0">							
							<TR>
								<TD class="FormLabel" align="right">用户名:</TD>
								<TD class="FormLabel"><?=$myPageClass->user_name?></TD>
							</TR>
							<tr>
								<td class="FormLabel" align="right">姓名:</td>
								<td class="FormLabel">
								<input type="text" maxlength="16" name="user_realname" id="user_realname" style="width: 200px;" value="<?=$myPageClass->user_realname?>"/>								
								</td>
							</tr>
							<tr>
								<td class="FormLabel" align="right">联系电话:</td>
								<td class="FormLabel">
								<input type="text" maxlength="100" name="user_phone" id="user_phone" style="width: 200px;" value="<?=$myPageClass->user_phone?>"/>								
								</td>
							</tr>
							<tr>
								<td class="FormLabel" align="right">电子邮箱:</td>
								<td class="FormLabel">
								<input type="text" maxlength="200" name="user_email" id="user_email" style="width: 200px;" value="<?=$myPageClass->user_email?>"/>								
								</td>
							</tr>							
							<tr>
								<td class="FormLabel" align="right">密码:</td>
								<td class="FormLabel">
								<input type="password"" maxlength="16" name="user_pwd" id="user_pwd" style="width: 200px;" value="<?=$myPageClass->user_pwd?>"/>
								不改密码,请留空
								</td>
							</tr>
							<tr>
								<td class="FormLabel" align="right">重输密码:</td>
								<td class="FormLabel">
								<input type="password"" maxlength="16" name="user_pwd2" id="user_pwd2" style="width: 200px;" value="<?=$myPageClass->user_pwd2?>"/>
								</td>
							</tr>
							<tr>
								<td class="FormLabel" colSpan="2">
									<input type="submit" name="btnSave" id="btnSave" value="保存"/>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</form>
	</body>
</HTML>
