<?php
session_start();
include_once("../../util/commonFunctions.php");
canAcesssThisPage(43); 

include_once("../../database/mysqlDAO.php");
include("manageOldNoticeClass.inc.php");

$myPageClass = new manageOldNoticeClass($_POST,$_GET,$mysqldao);
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
<title>会议通知管理-已发布通知管理</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<LINK href="../manage.css" type="text/css" rel="stylesheet">
<script type="">
  	function delNotice(id)
	{
		if ( confirm("你确定要删除该通知吗？") == false) return false;
		window.location="deleteNotice.php?cid=<?=$myPageClass->columnsID?>&page=<?=$myPageClass->to_page?>&id="+id+"&retURL=<?=$myPageClass->retURL?>";
		return false;
	}
</script>
</HEAD>
<body >
<br>
<table id="FormTable" cellSpacing="1" cellPadding="0" width="98%"
	align="center" bgColor="#ffffff" border="0">
	<tr>
		<td class="FormCaption" align="center" bgColor="#668cd9">已发布通知管理 - <?=$myPageClass->columnsName?></td>
	</tr>
	<tr>
		<td vAlign="middle" align="center" bgColor="#f1f3f5">
		<table height="99%" cellSpacing="1" cellPadding="0" width="100%"
			align="center" bgColor="#ebebeb" border="0">
			<tr>
				<td class="FormLabel" align="left" width="75%">				
				<a href='manageNewNotice.php?id=<?=$myPageClass->columnsID?>&retURL=<?=$myPageClass->retURL?>'>进入未发布通知管理</a>
				</td>
			</tr>
			<tr>
				<td align="center" valign="top">
				<TABLE cellSpacing="1" cellPadding="1" width="100%"	bgColor="#ffffff" border="0">
					<tr>
						<td class="TableTdCaption" width="5%" align="center"></td>
						<td class="TableTdCaption" width="30%" align="center">标题</td>
						<td class="TableTdCaption" width="10%" align="center">发起人</td>
						<td class="TableTdCaption" width="15%" align="center">发布时间</td>
						<td class="TableTdCaption" width="25%" align="center">概况</td>
						<td class="TableTdCaption" width="15%" align="center">操作</td>
					</tr>
					<?php
					for ($i=0;$i<count($myPageClass->oldNoticeList);$i++)
					{
						if ( ($i % 2) == 0){
							$tmpstr = "";
						} else {							
							$tmpstr = " style='background: #F0F0F0;' ";
						}						
						echo "<tr>\n<td class='TableTd' align='center' $tmpstr>";
						echo ($i+1);
						echo "</td>\n<td class='TableTd' align='left' $tmpstr>";
						echo "<a href='listNoticeUser.php?id=".$myPageClass->oldNoticeList[$i]["notice_id"]."&cid=$myPageClass->columnsID&page=$myPageClass->to_page&retURL=$myPageClass->retURL'>";
						echo $myPageClass->oldNoticeList[$i]["title"];
						echo'</a>';						
						echo "</td>\n<td class='TableTd' align='center' $tmpstr>";
						echo $myPageClass->oldNoticeList[$i]["user_realname"];						
						echo "</td>\n<td class='TableTd' align='center' $tmpstr>";
						echo $myPageClass->oldNoticeList[$i]["send_time"];			
						echo "</td>\n<td class='TableTd' align='left' $tmpstr>";
						echo '人数:['.$myPageClass->oldNoticeList[$i]["user_num"].']';
						if ($myPageClass->oldNoticeList[$i]["user_num"] > 0){
							echo ', 阅读:[';
							echo $myPageClass->oldNoticeList[$i]["user_num"]-$myPageClass->oldNoticeList[$i]["read_num"];
							echo '未读 ';
							echo $myPageClass->oldNoticeList[$i]["read_num"];
							echo '已读] ,回复:[';
							echo $myPageClass->oldNoticeList[$i]["user_num"]-$myPageClass->oldNoticeList[$i]["come_num"]-$myPageClass->oldNoticeList[$i]["lost_num"];
							echo '未回复 ';
							echo $myPageClass->oldNoticeList[$i]["come_num"];
							echo '参会 ';
							echo $myPageClass->oldNoticeList[$i]["lost_num"];
							echo '不参会]';
						}
						
						echo "</td>\n<td class='TableTd' align='center' $tmpstr>";						
						echo "<a href='listNoticeUser.php?id=".$myPageClass->oldNoticeList[$i]["notice_id"]."&cid=$myPageClass->columnsID&page=$myPageClass->to_page&retURL=$myPageClass->retURL'>详细</a> ";
						echo "<a href='editNotice.php?s=2&id=".$myPageClass->oldNoticeList[$i]["notice_id"]."&cid=$myPageClass->columnsID&page=$myPageClass->to_page&retURL=$myPageClass->retURL'>修改</a> ";						
						echo "<a href='#' onclick='return delNotice(".$myPageClass->oldNoticeList[$i]['notice_id'].")'>删除</a>";
						echo "</td>\n</tr>";						
					}					   
					?>					
				</TABLE>
				<div align="right">
				  <span class="blue12">
					共<?echo $myPageClass->page_num?>页
					第<?echo $myPageClass->to_page?>页
					<a href="manageOldNotice.php?id=<?=$myPageClass->columnsID?>&page=<?=$myPageClass->first_page?>&retURL=<?=$myPageClass->retURL?>" class="blue12">首页</A>
					<a href="manageOldNotice.php?id=<?=$myPageClass->columnsID?>&page=<?=$myPageClass->up_page?>&retURL=<?=$myPageClass->retURL?>" class="blue12">上页</A>
					<a href="manageOldNotice.php?id=<?=$myPageClass->columnsID?>&page=<?=$myPageClass->next_page?>&retURL=<?=$myPageClass->retURL?>" class="blue12">下页</A>
					<a href="manageOldNotice.php?id=<?=$myPageClass->columnsID?>&page=<?=$myPageClass->last_page?>&retURL=<?=$myPageClass->retURL?>" class="blue12">末页</A>
				  </span>
				</div>
				</td>
			</tr>
		</table>
		</td>
	</tr>
</table>
</body>
</HTML>
