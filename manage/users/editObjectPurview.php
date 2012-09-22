<?php
session_start();
include_once("../../util/commonFunctions.php");
canAcesssThisPage(10); 

include_once("../../database/mysqlDAO.php");
include("editObjectPurviewClass.inc.php");

$myPageClass = new editObjectPurviewClass($_GET,$mysqldao);
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
<title>对象权限管理</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<LINK href="../manage.css" type="text/css" rel="stylesheet">
</HEAD>
<body >
<br>
<table id="FormTable" cellSpacing="1" cellPadding="0" width="98%"
	align="center" bgColor="#ffffff" border="0">
	<tr>
		<td class="FormCaption" align="center" bgColor="#668cd9">该用户基本权限中有以下权限涉及具体对象</td>
	</tr>
	<tr>
		<td vAlign="middle" align="center" bgColor="#f1f3f5">
		<table height="99%" cellSpacing="1" cellPadding="0" width="100%"
			align="center" bgColor="#ebebeb" border="0">
			<TR>
					<TD class="FormLabel" align="center" colspan="2">
					<a href='managePurview.php?page=<?=$myPageClass->page?>'>返回</a>								
				</TD>
			</TR>			
			<tr>
				<td align="center" valign="top">
				<TABLE cellSpacing="1" cellPadding="1" width="100%"	bgColor="#ffffff" border="0">
					<tr>
						<td class="TableTdCaption" width="5%" align="center"></td>
						<td class="TableTdCaption" width="75%" align="center">名称</td>
						<td class="TableTdCaption" width="20%" align="center">操作</td>
					</tr>
					<?php
					if ($myPageClass->purList != -1)
					{
						for ($i=0;$i<count($myPageClass->purList);$i++)
						{
							if ( ($i % 2) == 0){
								$tmpstr = "";
							} else {							
								$tmpstr = " style='background: #F0F0F0;' ";
							}						
							echo "<tr>\n<td class='TableTd' align='center' $tmpstr>";
							echo ($i+1);
							echo "</td>\n<td class='TableTd' $tmpstr>";
							echo $myPageClass->purList[$i]["menu_name"];						
							echo "</td>\n<td class='TableTd' align='center' $tmpstr>";
							echo "<a href='".$myPageClass->purList[$i]["pur_edit_url"].$myPageClass->purList[$i]["menu_id"]."&uid=".$myPageClass->uid."&page=".$myPageClass->page."'>管理</a> ";
							echo "</td>\n</tr>";						
						}
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
