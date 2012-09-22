<?php
session_start();
include_once("../../util/commonFunctions.php");
canAcesssThisPage(14); 

include_once("../../database/mysqlDAO.php");
include("manageColumnsAdminClass.inc.php");

$myPageClass = new manageColumnsAdminClass($_POST,$_GET,$mysqldao);
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
<title>栏目管理</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<LINK href="../manage.css" type="text/css" rel="stylesheet">
<script type="">
  	function delCol(id)
	{
		if ( confirm("你确定要删除该栏目吗？") == false) return false;
		window.location="deleteColumns.php?id=" + id + "&page=<?echo $myPageClass->to_page?>";
		return false;
	}
    function toPage(page)
	{
		var tmpobj = document.getElementById("to_page");
		tmpobj.value=page;
        document.forms[0].submit();
	}
</script>
</HEAD>
<body >
<br>
<form name="Form1" method="post" action="manageColumnsAdmin.php" id="Form1">
<table id="FormTable" cellSpacing="1" cellPadding="0" width="98%"
	align="center" bgColor="#ffffff" border="0">
	<tr>
		<td class="FormCaption" align="center" bgColor="#668cd9">栏目管理 </td>
	</tr>
	<tr>
		<td vAlign="middle" align="center" bgColor="#f1f3f5">
		<table height="99%" cellSpacing="1" cellPadding="0" width="100%"
			align="center" bgColor="#ebebeb" border="0">
			<tr>
				<td class="FormLabel" align="center" width="75%">
				
				</td>
			</tr>
			<tr>
				<td align="center" valign="top">
				<TABLE cellSpacing="1" cellPadding="1" width="100%"	bgColor="#ffffff" border="0">
					<tr>
						<td class="TableTdCaption" width="5%" align="center">序号</td>
						<td class="TableTdCaption" width="40%" align="center">栏目名称</td>
						<td class="TableTdCaption" width="20%" align="center">栏目类型</td>
						<td class="TableTdCaption" width="15%" align="center">级别</td>
						<td class="TableTdCaption" width="10%" align="center">创建者</td>						
						<td class="TableTdCaption" width="10%" align="center">操作</td>
					</tr>
					<?php
					for ($i=0;$i<count($myPageClass->columnsList);$i++)
					{
						if ( ($i % 2) == 0){
							$tmpstr = "";
						} else {							
							$tmpstr = " style='background: #F0F0F0;' ";
						}						
						echo "<tr><td align='center' class='TableTd' $tmpstr>";
						echo $i+1;
						echo "</td>\n<td class='TableTd' $tmpstr>";
						echo $myPageClass->columnsList[$i]["columns_name"];
						echo "</td>\n<td class='TableTd' $tmpstr>";
						echo $myPageClass->columnsList[$i]["type_name"];
						echo "</td>\n<td class='TableTd' align='center' $tmpstr>";
						if ($myPageClass->columnsList[$i]["level"] == 0){
							echo "根栏目";
						} else {
							echo "子栏目";
						}
						echo "</td>\n<td class='TableTd' $tmpstr>";
						if ($myPageClass->columnsList[$i]["create_type"] == 0)
						{
							echo "系统管理员";
						} else if ($myPageClass->columnsList[$i]["create_type"] == 1)
						{
							echo "用户";
						} else {
							echo "程序";
						}						
						echo "</td>\n<td class='TableTd' align='center' $tmpstr>";						
						echo "<a href='editColumnsAdmin.php?id=".$myPageClass->columnsList[$i]["columns_id"]."'>修改</a> ";
						if ($myPageClass->columnsList[$i]["create_type"] == 1)
						{
							echo "<a href='#' onclick='return delCol(".$myPageClass->columnsList[$i]["columns_id"].")'>删除</a>";
						}
						echo "</td>\n</tr>";					
						
					}					   
					?>
					
				</TABLE>
				<div align="right">
				  <span class="blue12">
					共<?echo $myPageClass->page_num?>页
					第<?echo $myPageClass->to_page?>页
					<a href="#" onclick="toPage(<?echo $myPageClass->first_page?>)" class="blue12">首页</A>
					<a href="#" onclick="toPage(<?echo $myPageClass->up_page?>)"  class="blue12">上页</A>
					<a href="#" onclick="toPage(<?echo $myPageClass->next_page?>)"  class="blue12">下页</A>
					<a href="#" onclick="toPage(<?echo $myPageClass->last_page?>)"  class="blue12">末页</A>
				  </span>
				</div>
				</td>
			</tr>
		</table>
		</td>
	</tr>
</table>
<input type="hidden" name="to_page" id="to_page" value="<?=$myPageClass->to_page?>"/>
</form>
</body>
</HTML>
