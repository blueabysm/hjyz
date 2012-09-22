<?php
session_start();
include_once("../../util/commonFunctions.php");
canAcesssThisPage(7); 

include_once("../../database/mysqlDAO.php");
include("manageSubSiteClass.inc.php");

$myPageClass = new manageSubSiteClass($mysqldao);
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
<title>子网站管理</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<LINK href="../manage.css" type="text/css" rel="stylesheet">
<script type="">
  	function delSite(id)
	{
		if ( confirm("你确定要删除该子网站吗？") == false) return false;
		window.location="deleteSubSite.php?id=" + id;
		return false;
	}
</script>
</HEAD>
<body >
<br>
<table id="FormTable" cellSpacing="1" cellPadding="0" width="98%"
	align="center" bgColor="#ffffff" border="0">
	<tr>
		<td class="FormCaption" align="center" bgColor="#668cd9">子网站管理</td>
	</tr>
	<tr>
		<td vAlign="middle" align="center" bgColor="#f1f3f5">
		<table height="99%" cellSpacing="1" cellPadding="0" width="100%"
			align="center" bgColor="#ebebeb" border="0">
			<tr>
				<td class="FormLabel" align="left" width="75%">
				<a href='addSubSite.php'>添加子网站</a>			
				</td>
			</tr>
			<tr>
				<td align="center" valign="top">
				<TABLE cellSpacing="1" cellPadding="1" width="100%"	bgColor="#ffffff" border="0">
					<tr>
						<td class="TableTdCaption" width="10%" align="center"></td>
						<td class="TableTdCaption" width="50%" align="center">子网站名称(链接)</td>
						<td class="TableTdCaption" width="10%" align="center">状态</td>
						<td class="TableTdCaption" width="20%" align="center">管理员(用户名)</td>
						<td class="TableTdCaption" width="10%" align="center">操作</td>
					</tr>
					<?php
					for ($i=0;$i<count($myPageClass->subSiteList);$i++)
					{
						if ( ($i % 2) == 0){
							$tmpstr = "";
						} else {							
							$tmpstr = " style='background: #F0F0F0;' ";
						}						
						echo "<tr>\n<td class='TableTd' $tmpstr>";
						echo ($i+1);
						echo "</td>\n<td class='TableTd' $tmpstr>";
						echo $myPageClass->subSiteList[$i]["site_name"];
						if (strlen(trim($myPageClass->subSiteList[$i]["site_href"])) > 0)
						  echo "(<font color='blue'>".$myPageClass->subSiteList[$i]["site_href"]."</font>)";
						echo "</td>\n<td class='TableTd' align='center' $tmpstr>";
						if ($myPageClass->subSiteList[$i]["site_state"] == 1){
							echo "<font color='green'>正常</font>";
						}else {
							echo "<font color='red'>关停</font>";
						}
						echo "</td>\n<td class='TableTd' $tmpstr>";
						echo $myPageClass->subSiteList[$i]["admin_name"];																								
						echo "</td>\n<td class='TableTd' align='center' $tmpstr>";
						echo "<a href='editSubSite.php?id=".$myPageClass->subSiteList[$i]["sub_sites_id"]."'>修改</a> ";						
						echo "<a href='#' onclick='return delSite(".$myPageClass->subSiteList[$i]["sub_sites_id"].")'>删除</a>";						
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
