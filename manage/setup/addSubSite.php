<?php
session_start();
include_once("../../util/commonFunctions.php");
canAcesssThisPage(7); 

include_once("../../database/mysqlDAO.php");
include("addSubSiteClass.inc.php");

$myPageClass = new addSubSiteClass($_POST,$_GET,$mysqldao);
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
		<title>添加子网站</title>		
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<LINK href="../manage.css" type="text/css" rel="stylesheet">
		<script src="../tree/TreeView.js"></script>
		<style>
		a, A:link, a:visited, a:active, A:hover
		{color: #000000; text-decoration: none; font-family: Tahoma, Verdana; font-size: 12px}
		</style>
		<script>
		  function checkData()
		  {
			  var tmpobj = document.getElementById('corp_id');
			  if (tmpobj.value == 0)
			  {
				  alert('必须选择单位');
				  return false;
			  }
			  tmpobj = document.getElementById('user_id');
			  if (tmpobj.value == 0)
			  {
				  alert('必须选择管理员');
				  return false;
			  }			  
			  return true;
		  }
		</script>
	</HEAD>
	<body >
	<br>
		<form id="addSubSite" name="addSubSite" method="post" onsubmit="return checkData()">
			<table id="FormTable" cellSpacing="1" cellPadding="0" width="98%" align="center" bgColor="#ffffff"
				border="0">
				<tr>
					<td class="FormCaption" align="center" bgColor="#668cd9">添加子网站</td>
				</tr>
				<tr>
					<td vAlign="middle" align="center" bgColor="#f1f3f5">
						<table cellSpacing="1" cellPadding="0" width="99%" align="center" bgColor="#ebebeb"
							border="0">
							<TR>
								<TD class="FormLabel" align="center" colspan="2">
								<a href='manageSubSite.php'>返回</a>								
								</TD>
							</TR>
							<tr>
								<td class="FormLabel" align="right" width="15%">网站名称:</td>
								<td class="FormLabel"  width="85%">
								<input type="text" maxlength="30" name="site_name" id="site_name" style="width: 200px;" value="<?=$myPageClass->site_name?>"/>
								<font color="red">*</font>
								</td>
							</tr>
							<tr>
								<td class="FormLabel" align="right">网站链接</td>
								<td class="FormLabel">
								<input type="text" maxlength="200" name="site_href" id="site_href" style="width: 200px;" value="<?=$myPageClass->site_href?>"/>								
								(不推荐,当需要子网站被访问时转向另一个网址时填写)
								</td>
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
								<TD class="FormLabel" align="right" width="20%" valign="top">单位和管理员:</TD>
								<TD class="FormLabel">
								<br/>
								<div id="selDiv">
								</div>
								<br/>
								<TABLE cellSpacing="1" cellPadding="1" width="300" bgColor="#000000" border="0">
									<tr>
										<td class="TableTdCaption" align="center">请点击下方列表以选择</td>
									</tr>
									<tr>
										<td class="TableTd" align="left" style="background-color: white;">
										<script>
								   var TREE_ITEMS = <?=$myPageClass->treeItemStr?>;
								   var cTree = getNewTree(TREE_ITEMS);
								  
								   function selCorp(corp_id,corp_name,user_id,user_name)
								   {
									   var tmpobj = document.getElementById('corp_id');
									   tmpobj.value = corp_id;
									   tmpobj = document.getElementById('user_id');
									   tmpobj.value = user_id;
									   var str = '';
									   if (corp_id == 0){
										   str = '未选单位';
									   } else {
										   str = '单位:'+corp_name;
									   }
									   str +=' ';
									   if (user_id == 0){
										   str += '未选管理员';
									   } else {
										   str += '管理员:'+user_name;
									   }
									   tmpobj = document.getElementById('selDiv');
									   tmpobj.innerHTML = str;
								   }
								   					   
								</script>
										</td>
									</tr>											
								 </TABLE>
								</TD>
							</tr>					
							<tr>
								<td class="FormLabel" colSpan="2">
									<input type="submit" name="btnAdd" id="btnAdd" value="添加"/>
									<input type="hidden" name="corp_id" id="corp_id" value="<?=$myPageClass->corp_id?>"/>
									<input type="hidden" name="user_id" id="user_id" value="<?=$myPageClass->user_id?>"/>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</form>
		<script>
		selCorp(0,'',0,'');	
		</script>
	</body>
</HTML>
