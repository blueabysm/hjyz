<?php
session_start();
include_once("../../util/commonFunctions.php");
canAcesssThisPage(19); 

include_once("../../database/mysqlDAO.php");
include("manageCorpClass.inc.php");

$myPageClass = new manageCorpClass($mysqldao);
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
<title>单位列表</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<LINK href="../manage.css" type="text/css" rel="stylesheet">
</HEAD>
<body >
<br>
<table id="FormTable" cellSpacing="1" cellPadding="0" width="98%"
	align="center" bgColor="#ffffff" border="0">
	<tr>
		<td class="FormCaption" align="center" bgColor="#668cd9">单位列表</td>
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
						<td class="TableTdCaption" width="25%" align="center">单位名称(简称)</td>
						<td class="TableTdCaption" width="20%" align="center">联系电话</td>
						<td class="TableTdCaption" width="25%" align="center">地址</td>
						<td class="TableTdCaption" width="10%" align="center">首页显示</td>
						<td class="TableTdCaption" width="15%" align="center">操作</td>
					</tr>
					<?php
					for ($i=0;$i<count($myPageClass->corpList);$i++)
					{
						if ( ($i % 2) == 0){
							$tmpstr = "";
						} else {							
							$tmpstr = " style='background: #F0F0F0;' ";
						}						
						echo "<tr>\n<td class='TableTd' align='center' $tmpstr>";
						echo ($i+1);
						echo "</td>\n<td class='TableTd' $tmpstr>";
						echo $myPageClass->corpList[$i]["corp_name"].'('.$myPageClass->corpList[$i]["short_name"].')';
						echo "</td>\n<td class='TableTd' $tmpstr>";
						echo $myPageClass->corpList[$i]["phone"];						
						echo "</td>\n<td class='TableTd' $tmpstr>";
						echo $myPageClass->corpList[$i]["addr"];
						echo "</td>\n<td class='TableTd' $tmpstr>";
						if($myPageClass->corpList[$i]["to_index"]==1){echo '是';}else{echo '否';}
						echo "</td>\n<td class='TableTd' align='center' $tmpstr>";
						echo "<a href='editCorp.php?id=".$myPageClass->corpList[$i]["c_id"]."'>修改</a> ";
						echo "<a href='deleteCorp.php?id=".$myPageClass->corpList[$i]["c_id"].'\' onclick=\'return confirm("确定要删除此单位吗？")\'>删除</a>';
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
