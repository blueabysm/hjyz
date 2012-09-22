<?php
session_start();
include_once("../../util/commonFunctions.php");
canAcesssThisPage(0); 

include_once("../../database/mysqlDAO.php");
include("myNewNoticeClass.inc.php");

$myPageClass = new myNewNoticeClass($mysqldao);
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
<title>最新会议通知</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<LINK href="../manage.css" type="text/css" rel="stylesheet">
</HEAD>
<body >
<br>
<table id="FormTable" cellSpacing="1" cellPadding="0" width="98%"
	align="center" bgColor="#ffffff" border="0">
	<tr>
		<td class="FormCaption" align="center" bgColor="#668cd9">最新会议通知</td>
	</tr>
	<tr>
		<td vAlign="middle" align="center" bgColor="#f1f3f5">
		<table height="99%" cellSpacing="1" cellPadding="0" width="100%"
			align="center" bgColor="#ebebeb" border="0">
			<tr>
				<td class="FormLabel" align="left" width="75%">				
				  <a href='myOldNotice.php'>查看已回复会议通知</a>
				</td>
			</tr>
			<tr>
				<td align="center" valign="top">
				<TABLE cellSpacing="1" cellPadding="1" width="100%"	bgColor="#ffffff" border="0">
					<tr>
						<td class="TableTdCaption" width="10%" align="center"></td>
						<td class="TableTdCaption" width="50%" align="center">标题</td>
						<td class="TableTdCaption" width="10%" align="center">发起人</td>
						<td class="TableTdCaption" width="20%" align="center">发布时间</td>
						<td class="TableTdCaption" width="10%" align="center">操作</td>
					</tr>
					<?php
					for ($i=0;$i<count($myPageClass->newNoticeList);$i++)
					{
						if ( ($i % 2) == 0){
							$tmpstr = "";
						} else {							
							$tmpstr = " style='background: #F0F0F0;' ";
						}						
						echo "<tr>\n<td class='TableTd' align='center' $tmpstr>";
						echo ($i+1);
						echo "</td>\n<td class='TableTd' align='left' $tmpstr>";
						echo "<a href='relpyNotice.php?id=".$myPageClass->newNoticeList[$i]["notice_id"]."'>";
						echo $myPageClass->newNoticeList[$i]["title"];						
						echo'</a>';
						echo "</td>\n<td class='TableTd' align='center' $tmpstr>";
						echo $myPageClass->newNoticeList[$i]["user_realname"];						
						echo "</td>\n<td class='TableTd' align='center' $tmpstr>";
						echo $myPageClass->newNoticeList[$i]["send_time"];						
						echo "</td>\n<td class='TableTd' align='center' $tmpstr>";
						echo "<a href='relpyNotice.php?id=".$myPageClass->newNoticeList[$i]["notice_id"]."'>查看</a>";
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
