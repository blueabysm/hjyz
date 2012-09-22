<?php
session_start();
include_once("../../util/commonFunctions.php");
canAcesssThisPage(11); 

include_once("../../database/mysqlDAO.php");
include("manageUserGroupClass.inc.php");

$myPageClass = new manageUserGroupClass($mysqldao);
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
<title>用户组管理</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<LINK href="../manage.css" type="text/css" rel="stylesheet">
<script type="">
  	function delUserGroup(id)
	{
		if ( confirm("你确定要删除该用户组吗？") == false) return false;
		window.location="deleteUserGroup.php?id=" + id;
		return false;
	}
</script>
</HEAD>
<body >
<br>
<table id="FormTable" cellSpacing="1" cellPadding="0" width="98%"
	align="center" bgColor="#ffffff" border="0">
	<tr>
		<td class="FormCaption" align="center" bgColor="#668cd9">用户组管理</td>
	</tr>
	<tr>
		<td vAlign="middle" align="center" bgColor="#f1f3f5">
		<table height="99%" cellSpacing="1" cellPadding="0" width="100%"
			align="center" bgColor="#ebebeb" border="0">
			<tr>
				<td class="FormLabel" align="left" width="75%">
				<a href='editUserGroup.php'>添加用户组</a>			
				</td>
			</tr>
			<tr>
				<td align="center" valign="top">
				<TABLE cellSpacing="1" cellPadding="1" width="100%"	bgColor="#ffffff" border="0">
					<tr>
						<td class="TableTdCaption" width="10%" align="center"></td>
						<td class="TableTdCaption" width="70%" align="center">名称</td>
						<td class="TableTdCaption" width="30%" align="center">操作</td>
					</tr>
					<?php
					for ($i=0;$i<count($myPageClass->userGroupList);$i++)
					{
						if ( ($i % 2) == 0){
							$tmpstr = "";
						} else {							
							$tmpstr = " style='background: #F0F0F0;' ";
						}						
						echo "<tr>\n<td class='TableTd' align='center' $tmpstr>";
						echo ($i+1);
						echo "</td>\n<td class='TableTd' $tmpstr>";
						echo $myPageClass->userGroupList[$i]["group_name"];						
						echo "</td>\n<td class='TableTd' align='center' $tmpstr>";
						echo "<a href='editUserGroup.php?id=".$myPageClass->userGroupList[$i]["group_id"]."'>修改</a> ";
						if ($myPageClass->userList[$i]["user_name"] != 'admin'){						
						echo "<a href='#' onclick='return delUserGroup(".$myPageClass->userGroupList[$i]["group_id"].")'>删除</a>";
						}						
						echo "</td>\n</tr>";						
					}					   
					?>					
				</TABLE>
				</td>
			</tr>
		</table>
		</td>
	</tr>
</table>
</body>
</HTML>
