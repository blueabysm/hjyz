<?php
session_start();
include_once("../../util/commonFunctions.php");
canAcesssThisPage(6); 

include_once("../../database/mysqlDAO.php");
include("mainSiteInfoClass.inc.php");

$myPageClass = new mainSiteInfoClass($_POST,$_GET,$mysqldao);
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
		<title>网站基本信息管理</title>		
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<LINK href="../manage.css" type="text/css" rel="stylesheet">		
	</HEAD>
	<body >
	<br>
		<form id="editInfo" name="editInof" method="post">
			<table id="FormTable" cellSpacing="1" cellPadding="0" width="98%" align="center" bgColor="#ffffff"
				border="0">
				<tr>
					<td class="FormCaption" align="center" bgColor="#668cd9">网站基本信息管理</td>
				</tr>
				<tr>
					<td vAlign="middle" align="center" bgColor="#f1f3f5">
						<table cellSpacing="1" cellPadding="0" width="99%" align="center" bgColor="#ebebeb"
							border="0">
							<tr>
								<td class="FormLabel" align="right">网站名称:</td>
								<td class="FormLabel"><?=WEB_SITE_NAME?></td>
							</tr>
							<tr>
								<td class="FormLabel" align="right">网站域名:</td>
								<td class="FormLabel"><?=WEB_DOMAIN_NAME?></td>								
							</tr>
							<tr>
								<td class="FormLabel" align="right">网站模板:</td>
								<td class="FormLabel">
									<select name="template_dir_name" id="template_dir_name">										
										<?php 										
											 for($i=0;$i<count($myPageClass->templateList);$i++)
											 {
											     if ($myPageClass->templateList[$i]["template_dir_name"] == $myPageClass->template_dir_name){
											     	echo "<option value='".$myPageClass->templateList[$i]["template_dir_name"]."' selected='selected'>".$myPageClass->templateList[$i]["template_name"]."</option>\n";
											     } else {
											     	echo "<option value='".$myPageClass->templateList[$i]["template_dir_name"]."'>".$myPageClass->templateList[$i]["template_name"]."</option>\n";     			  		
											     }
											 } 
										?>
									</select>																
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