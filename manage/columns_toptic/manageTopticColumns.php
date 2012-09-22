<?php
session_start();
include_once("../../util/commonFunctions.php");
canAcesssThisPage(41); 

include_once("../../database/mysqlDAO.php");
include("manageTopticColumnsClass.inc.php");

$myPageClass = new manageTopticColumnsClass($_POST,$_GET,$mysqldao);
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
<title>专题栏目管理</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<LINK href="../manage.css" type="text/css" rel="stylesheet">
<script type="">
  	function delPart(id,cid)
	{
		if ( confirm("你确定要删除该专题吗？") == false) return false;
		window.location="deleteTopticColumns.php?id=" + id + "&cid=" + cid;
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
		<td class="FormCaption" align="center" bgColor="#668cd9">管理  <?=$myPageClass->partColumnsName?></td>
	</tr>
	<tr>
		<td vAlign="middle" align="center" bgColor="#f1f3f5">
		<table height="99%" cellSpacing="1" cellPadding="0" width="100%"
			align="center" bgColor="#ebebeb" border="0">
			<tr>
				<td class="FormLabel" align="center" width="75%">				
				<a href="../columns/manageColumns.php">返回栏目管理</a>
				</td>
			</tr>			
			<tr>
				<td class="FormLabel" align="left" width="75%">
				<a href='addTopticColumns.php?columns_id=<?=$myPageClass->columnsID?>'>添加专题</a>			
				</td>
			</tr>
			<tr>
				<td align="center" valign="top">
				<TABLE cellSpacing="1" cellPadding="1" width="100%"	bgColor="#ffffff" border="0">
					<tr>
						<td class="TableTdCaption" width="5%" align="center"></td>
						<td class="TableTdCaption" width="40%" align="center">专题名称(链接)</td>
						<td class="TableTdCaption" width="5%" align="center">首页</td>
						<td class="TableTdCaption" width="40%" align="center">子栏目管理</td>
						<td class="TableTdCaption" width="10%" align="center">操作</td>
					</tr>
					<?php
					for ($i=0;$i<count($myPageClass->topticList);$i++)
					{
						if ( ($i % 2) == 0){
							$tmpstr = "";
						} else {							
							$tmpstr = " style='background: #F0F0F0;' ";
						}						
						echo "<tr>\n<td class='TableTd' $tmpstr>";
						echo ($i+1);
						echo "</td>\n<td class='TableTd' $tmpstr>";
						echo $myPageClass->topticList[$i]["toptic_name"];
						if (strlen(trim($myPageClass->topticList[$i]["toptic_href"])) > 0)
						  echo "(<font color='blue'>".$myPageClass->topticList[$i]["toptic_href"]."</font>)";
						echo "</td>\n<td class='TableTd' $tmpstr align='center'>";
						if ($myPageClass->topticList[$i]["to_index"] == 1){
							echo "<font color='red'>是</font>";
						}else {
							echo "否";
						}
						echo "</td>\n<td class='TableTd' align='center' $tmpstr>";
						echo "<a href='../columns_slideimage/editSlideImageColumns.php?id=".$myPageClass->topticList[$i]["slide_id"]."&retURL=../columns_toptic/manageTopticColumns.php?id=$myPageClass->columnsID'>幻灯片</a> ";
						echo "<a href='../article/manageArticle.php?id=".$myPageClass->topticList[$i]["article_column_id"]."&retURL=../columns_toptic/manageTopticColumns.php?id=$myPageClass->columnsID'>最新消息</a> ";
						echo "<a href='../columns_html/editHtmlColumns.php?id=".$myPageClass->topticList[$i]["html_column_id"]."&retURL=../columns_toptic/manageTopticColumns.php?id=$myPageClass->columnsID'>专题介绍</a> ";
						echo "<a href='../columns_imagetable/editImageTableColumns.php?id=".$myPageClass->topticList[$i]["imagetable_id"]."&retURL=../columns_toptic/manageTopticColumns.php?id=$myPageClass->columnsID'>图片新闻</a>";																		
						echo "</td>\n<td class='TableTd' align='center' $tmpstr>";
						echo "<a href='editTopticColumns.php?columns_id=".$myPageClass->columnsID."&columns_toptic_id=".$myPageClass->topticList[$i]["columns_toptic_id"]."'>修改</a> ";						
						echo "<a href='#' onclick='return delPart(".$myPageClass->topticList[$i]["columns_toptic_id"].",".$myPageClass->columnsID.")'>删除</a>";						
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
