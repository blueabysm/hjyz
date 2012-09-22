<?php
session_start();
include_once("../../util/commonFunctions.php");
canAcesssThisPage(20); 

include_once("../../database/mysqlDAO.php");
include("managePartClass.inc.php");

$myPageClass = new managePartClass($_POST,$_GET,$mysqldao);
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
<title>单位机构设置</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<LINK href="../manage.css" type="text/css" rel="stylesheet">
</HEAD>
<body >
<br>
<form name="Form1" method="post" id="Form1">
<table id="FormTable" cellSpacing="1" cellPadding="0" width="98%"
	align="center" bgColor="#ffffff" border="0">
	<tr>
		<td class="FormCaption" align="center" bgColor="#668cd9">管理  <?=$myPageClass->corpName?> 的机构设置</td>
	</tr>
	<tr>
		<td vAlign="middle" align="center" bgColor="#f1f3f5">
		<table height="99%" cellSpacing="1" cellPadding="0" width="100%"
			align="center" bgColor="#ebebeb" border="0">
			<tr>
				<td class="FormLabel" align="center" width="75%">				
				<a href="partSet.php">返回</a>
				</td>
			</tr>
			<tr>
				<td class="FormLabel" align="left" width="75%">
				<a href='addPart.php?corp_id=<?=$myPageClass->corpID?>'>添加机构</a>			
				</td>
			</tr>
			<tr>
				<td align="center" valign="top">
				<TABLE cellSpacing="1" cellPadding="1" width="100%"	bgColor="#ffffff" border="0">
					<tr>
						<td class="TableTdCaption" width="5%" align="center"></td>
						<td class="TableTdCaption" width="40%" align="center">机构名称</td>
						<td class="TableTdCaption" width="30%" align="center">负责人</td>
						<td class="TableTdCaption" width="25%" align="center">操作</td>
					</tr>
					<?php
					for ($i=0;$i<count($myPageClass->partList);$i++)
					{
						if ( ($i % 2) == 0){
							$tmpstr = "";
						} else {							
							$tmpstr = " style='background: #F0F0F0;' ";
						}						
						echo "<tr>\n<td class='TableTd' $tmpstr>";
						echo ($i+1);
						echo "</td>\n<td class='TableTd' $tmpstr>";
						echo $myPageClass->partList[$i]["part_name"];
						echo "</td>\n<td class='TableTd' $tmpstr>";
						echo $myPageClass->partList[$i]["part_master"];												
						echo "</td>\n<td class='TableTd' align='center' $tmpstr>";
						echo "<a href='editPart.php?corp_id=".$myPageClass->corpID."&part_id=".$myPageClass->partList[$i]["part_id"]."'>修改</a> ";
						echo "<a href='manageSubColumns.php?s_type=1&corp_id=".$myPageClass->corpID."&id=".$myPageClass->partList[$i]["part_id"]."'>子栏目</a> ";
						echo "<a href='deletePart.php?id=".$myPageClass->partList[$i]["part_id"].'&cid='.$myPageClass->corpID.'\' onclick=\'return confirm("确定要删除此机构吗？")\'>删除</a>';						
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
