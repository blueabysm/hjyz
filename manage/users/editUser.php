<?php
session_start();
include_once("../../util/commonFunctions.php");
canAcesssThisPage(44); 

include_once("../../database/mysqlDAO.php");
include("editUserClass.inc.php");

$myPageClass = new editUserClass($_POST,$_GET,$mysqldao);
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
		<title>修改用户信息</title>		
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
			  var tmpobj = document.getElementById('user_company');
			  if (tmpobj.value == 0)
			  {
				  alert('必须选择单位');
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
					<td class="FormCaption" align="center" bgColor="#668cd9">修改用户信息</td>
				</tr>
				<tr>
					<td vAlign="middle" align="center" bgColor="#f1f3f5">
						<table cellSpacing="1" cellPadding="0" width="99%" align="center" bgColor="#ebebeb"
							border="0">
							<TR>
								<TD class="FormLabel" align="center" colspan="2">
								<a href='manageUser.php'>返回</a>								
								</TD>
							</TR>
							<tr>
								<td class="FormLabel" align="right">用户名:</td>
								<td class="FormLabel"><?=$myPageClass->user_name?></td>
							</tr>
							<tr>
								<td class="FormLabel" align="right">密码:</td>
								<td class="FormLabel">
								<input type="password"" maxlength="16" name="user_pwd" id="user_pwd" style="width: 120px;" value="<?=$myPageClass->user_pwd?>"/>
								5-16位	,不改密码,请留空							
								</td>
							</tr>
							<tr>
								<td class="FormLabel" align="right">重输密码:</td>
								<td class="FormLabel">
								<input type="password"" maxlength="16" name="user_pwd2" id="user_pwd2" style="width: 120px;" value="<?=$myPageClass->user_pwd2?>"/>
								5-16位	,不改密码,请留空	
								</td>
							</tr>							
							<tr>
								<td class="FormLabel" align="right">用户类型:</td>
								<td class="FormLabel">
									<select name="user_type" id="user_type">
					     			<?php
					     			  for($i=0;$i<count($myPageClass->user_type_list);$i+=2)
					     			  {
					     			  	if ($myPageClass->user_type_list[$i] == $myPageClass->user_type){
					     			  		echo "<option value='".$myPageClass->user_type_list[$i]."' selected='selected'>".$myPageClass->user_type_list[$i+1]."</option>\n";
					     			  	} else {
					     			  		echo "<option value='".$myPageClass->user_type_list[$i]."'>".$myPageClass->user_type_list[$i+1]."</option>\n";     			  		
					     			  	}
					     			  } 
					     			?>
					     		</select>																
								</td>
							</tr>
							<tr>
								<td class="FormLabel" align="right">用户状态:</td>
								<td class="FormLabel">
									<select name="user_state" id="user_state">
					     			<?php
					     			  for($i=0;$i<count($myPageClass->user_state_list);$i+=2)
					     			  {
					     			  	if ($myPageClass->user_state_list[$i] == $myPageClass->user_state){
					     			  		echo "<option value='".$myPageClass->user_state_list[$i]."' selected='selected'>".$myPageClass->user_state_list[$i+1]."</option>\n";
					     			  	} else {
					     			  		echo "<option value='".$myPageClass->user_state_list[$i]."'>".$myPageClass->user_state_list[$i+1]."</option>\n";     			  		
					     			  	}
					     			  } 
					     			?>
					     		</select>																
								</td>
							</tr>
							<tr>
								<td class="FormLabel" align="right">姓名:</td>
								<td class="FormLabel">
								<input type="text" maxlength="16" name="user_realname" id="user_realname" style="width: 200px;" value="<?=$myPageClass->user_realname?>"/>
								<font color="red">*</font>								
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
								<TD class="FormLabel" align="right" width="20%" valign="top">单位和部门:</TD>
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
								  
								   function selCorp(corp_id,corp_name,part_id,part_name)
								   {
									   var tmpobj = document.getElementById('user_company');
									   tmpobj.value = corp_id;
									   tmpobj = document.getElementById('user_part');
									   tmpobj.value = part_id;
									   var str = '';
									   if (corp_id == 0){
										   str = '未选单位';
									   } else {
										   str = '单位:'+corp_name;
									   }
									   str +=' ';
									   if (part_id == 0){
										   str += '未选部门';
									   } else {
										   str += '部门:'+part_name;
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
									<input type="submit" name="btnSave" id="btnSave" value="保存"/>
									<input type="hidden" name="user_id" id="user_id" value="<?=$myPageClass->user_id?>"/>
									<input type="hidden" name="user_company" id="user_company" value="<?=$myPageClass->user_company?>"/>
									<input type="hidden" name="user_part" id="user_part" value="<?=$myPageClass->user_part?>"/>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</form>
		<script>
		 selCorp(<?=$myPageClass->user_company?>,'<?=$myPageClass->user_company_name?>',<?=$myPageClass->user_part?>,'<?=$myPageClass->user_part_name?>');	
		</script>
	</body>
</HTML>
