<?php
session_start();
include_once("../../util/commonFunctions.php");
canAcesssThisPage(43); 

include_once("../../database/mysqlDAO.php");
include("manageNewNoticeClass.inc.php");

$myPageClass = new manageNewNoticeClass($_POST,$_GET,$mysqldao);
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
<title>会议通知管理-未发布通知管理</title>
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
		<td class="FormCaption" align="center" bgColor="#668cd9">未发布通知管理 - <?=$myPageClass->columnsName?></td>
	</tr>
	<tr>
		<td vAlign="middle" align="center" bgColor="#f1f3f5">
		<table height="99%" cellSpacing="1" cellPadding="0" width="100%"
			align="center" bgColor="#ebebeb" border="0">
			<tr>
				<td class="FormLabel" align="center" width="75%">				
				<a href="<?=$myPageClass->retURL?>">返回</a>
				</td>
			</tr>			
			<tr>
				<td class="FormLabel" align="left" width="75%">
				<a href='addNotice.php?cid=<?=$myPageClass->columnsID?>&page=<?=$myPageClass->to_page?>&retURL=<?=$myPageClass->retURL?>'>添加新通知</a>			
				
				<a href='manageOldNotice.php?id=<?=$myPageClass->columnsID?>&retURL=<?=$myPageClass->retURL?>'>进入已发布通知管理</a>
				</td>
			</tr>
			<tr>
				<td align="center" valign="top">
				<TABLE cellSpacing="1" cellPadding="1" width="100%"	bgColor="#ffffff" border="0">
					<tr>
						<td class="TableTdCaption" width="10%" align="center"></td>
						<td class="TableTdCaption" width="40%" align="center">标题</td>
						<td class="TableTdCaption" width="10%" align="center">发起人</td>
						<td class="TableTdCaption" width="20%" align="center">创建时间</td>
						<td class="TableTdCaption" width="20%" align="center">操作</td>
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
						echo $myPageClass->newNoticeList[$i]["title"];						
						echo "</td>\n<td class='TableTd' align='center' $tmpstr>";
						echo $myPageClass->newNoticeList[$i]["user_realname"];						
						echo "</td>\n<td class='TableTd' align='center' $tmpstr>";
						echo $myPageClass->newNoticeList[$i]["create_time"];						
						echo "</td>\n<td class='TableTd' align='center' $tmpstr>";
						echo "<a href='editNotice.php?s=1&id=".$myPageClass->newNoticeList[$i]["notice_id"]."&cid=$myPageClass->columnsID&page=$myPageClass->to_page&retURL=$myPageClass->retURL'>修改</a> ";						
						echo "<a href='#' onclick='return delNotice(".$myPageClass->newNoticeList[$i]['notice_id'].")'>删除</a>";
						echo "</td>\n</tr>";						
					}					   
					?>					
				</TABLE>
				<div align="right">
				  <span class="blue12">
					共<?echo $myPageClass->page_num?>页
					第<?echo $myPageClass->to_page?>页
					<a href="manageNewNotice.php?id=<?=$myPageClass->columnsID?>&page=<?=$myPageClass->first_page?>&retURL=<?=$myPageClass->retURL?>" class="blue12">首页</A>
					<a href="manageNewNotice.php?id=<?=$myPageClass->columnsID?>&page=<?=$myPageClass->up_page?>&retURL=<?=$myPageClass->retURL?>" class="blue12">上页</A>
					<a href="manageNewNotice.php?id=<?=$myPageClass->columnsID?>&page=<?=$myPageClass->next_page?>&retURL=<?=$myPageClass->retURL?>" class="blue12">下页</A>
					<a href="manageNewNotice.php?id=<?=$myPageClass->columnsID?>&page=<?=$myPageClass->last_page?>&retURL=<?=$myPageClass->retURL?>" class="blue12">末页</A>
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
