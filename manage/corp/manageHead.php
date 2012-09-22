<?php
session_start();
include_once("../../util/commonFunctions.php");
canAcesssThisPage(20); 

include_once("../../database/mysqlDAO.php");
include("manageHeadClass.inc.php");

$myPageClass = new manageHeadClass($_POST,$_GET,$mysqldao);
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
<title>单位领导信息管理</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<LINK href="../manage.css" type="text/css" rel="stylesheet">
</HEAD>
<body >
<br>
<form name="Form1" method="post" id="Form1">
<table id="FormTable" cellSpacing="1" cellPadding="0" width="98%"
	align="center" bgColor="#ffffff" border="0">
	<tr>
		<td class="FormCaption" align="center" bgColor="#668cd9">管理  <?=$myPageClass->corpName?> 的领导信息</td>
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
				<a href='addHead.php?corp_id=<?=$myPageClass->corpID?>'>添加领导信息</a>			
				</td>
			</tr>
			<tr>
				<td align="center" valign="top">
				<TABLE cellSpacing="1" cellPadding="1" width="100%"	bgColor="#ffffff" border="0">
					<tr>
						<td class="TableTdCaption" width="5%" align="center"></td>
						<td class="TableTdCaption" width="25%" align="center">领导姓名</td>
						<td class="TableTdCaption" width="45%" align="center">职务</td>
						<td class="TableTdCaption" width="25%" align="center">操作</td>
					</tr>
					<?php
					for ($i=0;$i<count($myPageClass->headList);$i++)
					{
						if ( ($i % 2) == 0){
							$tmpstr = "";
						} else {							
							$tmpstr = " style='background: #F0F0F0;' ";
						}						
						echo "<tr>\n<td class='TableTd' $tmpstr>";
						echo ($i+1);
						echo "</td>\n<td class='TableTd' $tmpstr>";
						echo $myPageClass->headList[$i]["head_name"];
						echo "</td>\n<td class='TableTd' $tmpstr>";
						echo $myPageClass->headList[$i]["head_post"];												
						echo "</td>\n<td class='TableTd' align='center' $tmpstr>";
						echo "<a href='editHead.php?corp_id=".$myPageClass->corpID."&head_id=".$myPageClass->headList[$i]["head_id"]."'>修改</a> ";
						echo "<a href='manageSubColumns.php?s_type=2&corp_id=".$myPageClass->corpID."&id=".$myPageClass->headList[$i]["head_id"]."'>子栏目</a> ";
						echo "<a href='deleteHead.php?id=".$myPageClass->headList[$i]["head_id"].'&cid='.$myPageClass->corpID.'\' onclick=\'return confirm("确定要删除该领导的信息吗？")\'>删除</a>';						
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
