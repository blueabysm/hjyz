<?php
session_start();
include_once("../../util/commonFunctions.php");
canAcesssThisPage(10); 

include_once("../../database/mysqlDAO.php");
include("managePurviewClass.inc.php");

$myPageClass = new managePurviewClass($mysqldao);
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
<title>权限管理</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<LINK href="../manage.css" type="text/css" rel="stylesheet">
</HEAD>
<body >
<br>
<table id="FormTable" cellSpacing="1" cellPadding="0" width="98%"
	align="center" bgColor="#ffffff" border="0">
	<tr>
		<td class="FormCaption" align="center" bgColor="#668cd9">权限管理</td>
	</tr>
	<tr>
		<td vAlign="middle" align="center" bgColor="#f1f3f5">
		<table height="99%" cellSpacing="1" cellPadding="0" width="100%"
			align="center" bgColor="#ebebeb" border="0">			
			<tr>
				<td align="center" valign="top">
				<TABLE cellSpacing="1" cellPadding="1" width="100%"	bgColor="#ffffff" border="0">
					<tr>
						<td class="TableTdCaption" width="5%" align="center"></td>
						<td class="TableTdCaption" width="10%" align="center">登录名</td>
						<td class="TableTdCaption" width="15%" align="center">姓名</td>
						<td class="TableTdCaption" width="15%" align="center">类型</td>
						<td class="TableTdCaption" width="35%" align="center">单位</td>
						<td class="TableTdCaption" width="20%" align="center">操作</td>
					</tr>
					<?php
					for ($i=0;$i<count($myPageClass->userList);$i++)
					{
						if ( ($i % 2) == 0){
							$tmpstr = "";
						} else {							
							$tmpstr = " style='background: #F0F0F0;' ";
						}						
						echo "<tr>\n<td class='TableTd' align='center' $tmpstr>";
						echo ($i+1);
						echo "</td>\n<td class='TableTd' $tmpstr>";
						echo $myPageClass->userList[$i]["user_name"];						
						echo "</td>\n<td class='TableTd' align='center' $tmpstr>";
						echo $myPageClass->userList[$i]["user_realname"];
						echo "</td>\n<td class='TableTd' align='center' $tmpstr>";						
						if ($myPageClass->userList[$i]["user_type"] == 5){
							echo "网站管理员";
						} else {
							echo "网站会员";
						}
						echo "</td>\n<td class='TableTd' $tmpstr>";	
						echo $myPageClass->userList[$i]["user_company_name"];																																		
						echo "</td>\n<td class='TableTd' align='center' $tmpstr>";
						echo "<a href='editBasePurview.php?uid=".$myPageClass->userList[$i]["user_id"]."'>基本权限</a> ";
						echo "<a href='editObjectPurview.php?uid=".$myPageClass->userList[$i]["user_id"]."'>对象权限</a> ";
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
