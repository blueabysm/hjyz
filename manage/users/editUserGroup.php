<?php
session_start();
include_once("../../util/commonFunctions.php");
canAcesssThisPage(11); 

include_once("../../database/mysqlDAO.php");
include("editUserGroupClass.inc.php");

$myPageClass = new editUserGroupClass($_POST,$_GET,$mysqldao);
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
		<title>添加修改用户组信息</title>		
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<LINK href="../manage.css" type="text/css" rel="stylesheet">
	</HEAD>
	<body >
	<br>
		<form id="addSubSite" name="addSubSite" method="post">
			<table id="FormTable" cellSpacing="1" cellPadding="0" width="98%" align="center" bgColor="#ffffff"
				border="0">
				<tr>
					<td class="FormCaption" align="center" bgColor="#668cd9">添加修改用户组信息</td>
				</tr>
				<tr>
					<td vAlign="middle" align="center" bgColor="#f1f3f5">
						<table cellSpacing="1" cellPadding="0" width="99%" align="center" bgColor="#ebebeb"
							border="0">
							<TR>
								<TD class="FormLabel" align="center" colspan="2">
								<a href='manageUserGroup.php'>返回</a>								
								</TD>
							</TR>							
							<tr>
								<td class="FormLabel" align="right">名称:</td>
								<td class="FormLabel">
								<input type="text" maxlength="100" name="group_name" id="group_name" style="width: 200px;" value="<?=$myPageClass->group_name?>"/>
								<font color="red">*</font>								
								</td>
							</tr>
							<tr>
								<td class="FormLabel" align="right">成员:</td>
								<td class="FormLabel">
								  <?php
									$str1= ','.$myPageClass->groupUsers.',';		  
								  	for($i=0;$i<count($myPageClass->allUserList);$i++)
							     	 {
				     			  		$str2= ','.$myPageClass->allUserList[$i]["user_id"].',';
				     			  		$find = strpos($str1,$str2);
				     			  		echo '<input type="checkbox" name="selUserList[]" id="user_'.$myPageClass->allUserList[$i]["user_id"].'" value="'.$myPageClass->allUserList[$i]["user_id"] . '" ';
				     			  		if (!($find ===false)){
					     			  			echo 'checked="checked" ';
					     			  		}
				     			  		echo '/>';
				     			  		echo $myPageClass->allUserList[$i]["user_realname"];
				     			  		echo '<br>';					     			  		
					     			 }					     			  						     			  						     			 
					     					?>				
								<font color="red">*</font>								
								</td>
							</tr>											
								
							<tr>
								<td class="FormLabel" colSpan="2">
									<input type="submit" name="btnSave" id="btnSave" value="保存"/>
									<input type="hidden" name="group_id" id="group_id" value="<?=$myPageClass->group_id?>"/>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</form>
	</body>
</HTML>
