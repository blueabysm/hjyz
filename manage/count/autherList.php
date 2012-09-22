<?php
session_start();
include_once("../../util/commonFunctions.php");
canAcesssThisPage(51); 

include_once("../../database/mysqlDAO.php");
include("autherListClass.inc.php");

$myPageClass = new autherListClass($_POST,$_GET,$mysqldao);
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
<title>作者文章数据统计</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<LINK href="../manage.css" type="text/css" rel="stylesheet">
</HEAD>
<body >
<br>
<table id="FormTable" cellSpacing="1" cellPadding="0" width="98%"
	align="center" bgColor="#ffffff" border="0">
	<tr>
		<td class="FormCaption" align="center" bgColor="#668cd9">作者文章数据统计</td>
	</tr>
	<tr>
		<td vAlign="middle" align="center" bgColor="#f1f3f5">
		<form id="editInfo" name="editInof" method="post">
		 开始时间:<input type="text" maxlength="8" name="startDate" id="startDate" value="<?=$myPageClass->startDate?>"/>
		 结束时间:<input type="text" maxlength="8" name="endDate" id="endDate" value="<?=$myPageClass->endDate?>"/>
		 时间格式举例：2010年元月1号写为 20100101
		 <input type="submit" name="btnSave" id="btnSave"/>
		</form>
		<table height="99%" cellSpacing="1" cellPadding="0" width="100%"
			align="center" bgColor="#ebebeb" border="0">			
			<tr>
				<td align="center" valign="top">
				<TABLE cellSpacing="1" cellPadding="1" width="100%"	bgColor="#ffffff" border="0">
					<tr>
						<td class="TableTdCaption" width="20%" align="center"></td>
						<td class="TableTdCaption" width="60%" align="center">作者</td>
						<td class="TableTdCaption" width="20%" align="center">文章数</td>
					</tr>
					<?php
					
					for ($i=0;$i<count($myPageClass->autherList);$i++)
					{
						if ( ($i % 2) == 0){
							$tmpstr = "";
						} else {							
							$tmpstr = " style='background: #F0F0F0;' ";
						}						
						echo "<tr>\n<td class='TableTd' $tmpstr>";
						echo ($i+1);
						echo "</td>\n<td class='TableTd' $tmpstr>";
						echo "<a href='showAuthArtList.php?n=".urlencode($myPageClass->autherList[$i][0])."' target='_blank'>";
						echo $myPageClass->autherList[$i][0];		
						echo '</a>';				
						echo "</td>\n<td class='TableTd' align='center' $tmpstr>";
						echo $myPageClass->autherList[$i][1];
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
