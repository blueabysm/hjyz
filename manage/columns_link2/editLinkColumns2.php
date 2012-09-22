<?php
session_start();
include_once("../../util/commonFunctions.php");
canAcesssThisPage(42); 

include_once("../../database/mysqlDAO.php");
include("editLinkColumns2Class.inc.php");

$myPageClass = new editLinkColumns2Class($_POST,$_GET,$mysqldao);
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
		<title>添加/修改子链接条</title>		
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<LINK href="../manage.css" type="text/css" rel="stylesheet">		
	</HEAD>
	<body >
	<br>
		<form id="editLink" name="editLink" method="post">
			<table id="FormTable" cellSpacing="1" cellPadding="0" width="98%" align="center" bgColor="#ffffff"
				border="0">
				<tr>
					<td class="FormCaption" align="center" bgColor="#668cd9">添加/修改子链接条</td>
				</tr>
				<tr>
					<td vAlign="middle" align="center" bgColor="#f1f3f5">
						<table cellSpacing="1" cellPadding="0" width="99%" align="center" bgColor="#ebebeb"
							border="0">
							<TR>
								<TD class="FormLabel" align="center" colspan="2">
								<a href='manageLinkColumns2.php?id=<?=$myPageClass->columns_id?>'>返回</a>								
								</TD>
							</TR>
							<TR>
								<TD class="FormLabel" align="right">栏目名称:</TD>
								<TD class="FormLabel"><?=$myPageClass->columns_name?></TD>
							</TR>
							<TR>
								<TD class="FormLabel" align="right">子链接条名称:</TD>
								<td class="FormLabel">
								<input type="text" maxlength="100" name="sub_link_name" id="sub_link_name" style="width: 300px;" value="<?=$myPageClass->sub_link_name?>"/>
								<font color="red">*</font>
								</td>
							</TR>
							<tr>
								<td class="FormLabel" align="right">标题:</td>
								<td class="FormLabel">
								<input type="text" maxlength="200" name="item_title" id="item_title" style="width: 300px;" value="<?=$myPageClass->item_title?>"/>								
								<font color="red">*</font>
								</td>
							</tr>
							<tr>
								<td class="FormLabel" align="right">地址:</td>
								<td class="FormLabel">
								<input type="text" maxlength="200" name="item_link" id="item_link" style="width: 300px;" value="<?=$myPageClass->item_link?>"/>								
								</td>
							</tr>							
							<TR>
								<TD class="FormLabel" align="right">序号:</TD>
								<TD class="FormLabel">
								<input type="text" maxlength="4" name="item_order" id="item_order" style="width: 300px;" value="<?=$myPageClass->item_order?>"/>
								链接条的显示顺序，值越小顺序越靠前
								</TD>
							</TR>
							<tr>
								<td class="FormLabel" colSpan="2">
									<input type="submit" name="btnSave" id="btnSave" value="保存"/>									
									<input type="hidden" name="columns_id" id="columns_id" value="<?=$myPageClass->columns_id?>"/>
									<input type="hidden" name="sub_columns_id" id="sub_columns_id" value="<?=$myPageClass->sub_columns_id?>"/>									
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</form>
	</body>
</HTML>
