<?php
session_start();
include_once("../../util/commonFunctions.php");
canAcesssThisPage(42); 

include_once("../../database/mysqlDAO.php");
include("manageLinkColumns2Class.inc.php");

$myPageClass = new manageLinkColumns2Class($_POST,$_GET,$mysqldao);
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
<title>二级导航条栏目管理</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<LINK href="../manage.css" type="text/css" rel="stylesheet">
<script type="">
  	function delLink(id,cid)
	{
		if ( confirm("你确定要删除子导航条吗？") == false) return false;
		window.location="deleteLinkColumns2.php?id=" + id + "&cid=" + cid;
		return false;
	}
</script>
</HEAD>
<body >
<br>
<form name="Form1" method="post" id="Form1">
<table id="FormTable" cellSpacing="1" cellPadding="0" width="98%"
	align="center" bgColor="#ffffff" border="0">
	<tr>
		<td class="FormCaption" align="center" bgColor="#668cd9">管理  <?=$myPageClass->linkColumnsName?></td>
	</tr>
	<tr>
		<td vAlign="middle" align="center" bgColor="#f1f3f5">
		<table height="99%" cellSpacing="1" cellPadding="0" width="100%"
			align="center" bgColor="#ebebeb" border="0">
			<tr>
				<td class="FormLabel" align="center" width="75%">				
				<a href="../columns/manageColumnsTree.php">返回</a>
				</td>
			</tr>
			<tr>
				<td class="FormLabel" align="left" width="75%">
				<a href='editLinkColumns2.php?columns_id=<?=$myPageClass->columnsID?>'>添加一级导航条</a>			
				</td>
			</tr>
			<tr>
				<td align="center" valign="top">
				<TABLE cellSpacing="1" cellPadding="1" width="100%"	bgColor="#ffffff" border="0">
					<tr>
						<td class="TableTdCaption" width="20%" align="center">名称</td>
						<td class="TableTdCaption" width="30%" align="center">导航标题</td>
						<td class="TableTdCaption" width="30%" align="center">导航地址</td>
						<td class="TableTdCaption" width="20%" align="center">操作</td>
					</tr>
					<?php
					for ($i=0;$i<count($myPageClass->linkList);$i++)
					{
						if ( ($i % 2) == 0){
							$tmpstr = "";
						} else {							
							$tmpstr = " style='background: #F0F0F0;' ";
						}						
						echo "<tr>\n<td class='TableTd' $tmpstr>";
						echo $myPageClass->linkList[$i]["sub_link_name"];
						echo "</td>\n<td class='TableTd' $tmpstr>";
						echo $myPageClass->linkList[$i]["item_title"];
						echo "</td>\n<td class='TableTd' $tmpstr>";
						echo $myPageClass->linkList[$i]["item_link"];						
						echo "</td>\n<td class='TableTd' align='center' $tmpstr>";
						echo "<a href='editLinkColumns2.php?columns_id=".$myPageClass->columnsID."&sub_columns_id=".$myPageClass->linkList[$i]["sub_columns_id"]."'>修改</a> ";
						echo "<a href='../columns_link/manageLinkColumns.php?id=".$myPageClass->linkList[$i]["sub_columns_id"]."&retURL=../columns_link2/manageLinkColumns2.php?id=$myPageClass->columnsID'>子导航</a> ";
						echo "<a href='#' onclick='return delLink(".$myPageClass->linkList[$i]["sub_columns_id"].",".$myPageClass->columnsID.")'>删除</a>";						
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
</form>
</body>
</HTML>
