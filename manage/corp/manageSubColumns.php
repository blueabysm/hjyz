<?php
session_start();
include_once("../../util/commonFunctions.php");
canAcesssThisPage(20); 

include_once("../../database/mysqlDAO.php");
include("manageSubColumnsClass.inc.php");

$myPageClass = new manageSubColumnsClass($_POST,$_GET,$mysqldao);
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
<title>管理子栏目</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<LINK href="../manage.css" type="text/css" rel="stylesheet">
</HEAD>
<body >
<br>
<form name="Form1" method="post" id="Form1">
<table id="FormTable" cellSpacing="1" cellPadding="0" width="98%"
	align="center" bgColor="#ffffff" border="0">
	<tr>
		<td class="FormCaption" align="center" bgColor="#668cd9">管理  <?=$myPageClass->corpName?> 的  <?=$myPageClass->objName?> 的栏目</td>
	</tr>
	<tr>
		<td vAlign="middle" align="center" bgColor="#f1f3f5">
		<table height="99%" cellSpacing="1" cellPadding="0" width="100%"
			align="center" bgColor="#ebebeb" border="0">
			<tr>
				<td class="FormLabel" align="center" width="75%">				
				<a href="<?=$myPageClass->page_name?>?id=<?=$myPageClass->corp_id?>">返回</a>
				</td>
			</tr>
			<tr>
				<td class="FormLabel" align="left" width="75%">
				<a href='addSubColumn.php?s_type=<?=$myPageClass->s_type?>&corp_id=<?=$myPageClass->corp_id?>&objID=<?=$myPageClass->objID?>'>添加栏目</a>			
				</td>
			</tr>
			<tr>
				<td align="center" valign="top">
				<TABLE cellSpacing="1" cellPadding="1" width="100%"	bgColor="#ffffff" border="0">
					<tr>
						<td class="TableTdCaption" width="20%" align="center"></td>
						<td class="TableTdCaption" width="40%" align="center">栏目名称</td>
						<td class="TableTdCaption" width="40%" align="center">操作</td>
					</tr>
					<?php
					for ($i=0;$i<count($myPageClass->subColumnsList);$i++)
					{
						if ( ($i % 2) == 0){
							$tmpstr = "";
						} else {							
							$tmpstr = " style='background: #F0F0F0;' ";
						}						
						echo "<tr>\n<td class='TableTd' $tmpstr>";
						echo ($i+1);
						echo "</td>\n<td class='TableTd' $tmpstr>";
						echo $myPageClass->subColumnsList[$i]["columns_name"];																	
						echo "</td>\n<td class='TableTd' align='center' $tmpstr>";
						echo "<a href='editSubColumn.php?s_type=$myPageClass->s_type&corp_id=$myPageClass->corp_id&objID=$myPageClass->objID&sub_id=".$myPageClass->subColumnsList[$i]["sub_id"]."'>修改</a> ";						
						echo "<a href='deleteSubColumn.php?s_type=$myPageClass->s_type&corp_id=$myPageClass->corp_id&objID=$myPageClass->objID&sub_id=".$myPageClass->subColumnsList[$i]["sub_id"]."' onclick='return confirm(\"确定要删除对栏目的引用吗？\\n提示：此删除操作只删除引用不会删除栏目本身\")'>删除</a>";
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
