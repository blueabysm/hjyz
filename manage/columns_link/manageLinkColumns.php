<?php
session_start();
include_once("../../util/commonFunctions.php");
canAcesssThisPage(35); 

include_once("../../database/mysqlDAO.php");
include("manageLinkColumnsClass.inc.php");

$myPageClass = new manageLinkColumnsClass($_POST,$_GET,$mysqldao);
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
<title>导航条栏目管理</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<LINK href="../manage.css" type="text/css" rel="stylesheet">
<script type="">
  	function delLink(id,cid)
	{
		if ( confirm("你确定要删除该导航吗？") == false) return false;
		window.location="deleteLinkColumns.php?id=" + id + "&cid=" + cid + "&retURL=" + "<?=$myPageClass->retURL?>";
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
				<a href="<?=$myPageClass->retURL?>">返回</a>
				</td>
			</tr>
			<tr>
				<td class="FormLabel" align="left" width="75%">
				<a href='editLinkColumns.php?columns_id=<?=$myPageClass->columnsID?>&retURL=<?=$myPageClass->retURL?>'>添加新导航</a>			
				</td>
			</tr>
			<tr>
				<td align="center" valign="top">
				<TABLE cellSpacing="1" cellPadding="1" width="100%"	bgColor="#ffffff" border="0">
					<tr>
						<td class="TableTdCaption" width="40%" align="center">标题</td>
						<td class="TableTdCaption" width="40%" align="center">地址</td>
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
						echo $myPageClass->linkList[$i]["item_title"];
						echo "</td>\n<td class='TableTd' $tmpstr>";
						echo $myPageClass->linkList[$i]["item_link"];						
						echo "</td>\n<td class='TableTd' align='center' $tmpstr>";
						echo "<a href='editLinkColumns.php?columns_id=".$myPageClass->columnsID."&columns_link_id=".$myPageClass->linkList[$i]["columns_link_id"]."&retURL=".$myPageClass->retURL."'>修改</a> ";
						echo "<a href='#' onclick='return delLink(".$myPageClass->linkList[$i]["columns_link_id"].",".$myPageClass->columnsID.")'>删除</a>";						
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
