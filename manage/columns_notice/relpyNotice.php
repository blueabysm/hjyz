<?php
session_start();
include_once("../../util/commonFunctions.php");
canAcesssThisPage(21); 

include_once("../../database/mysqlDAO.php");
include("relpyNoticeClass.inc.php");

$myPageClass = new relpyNoticeClass($_POST,$_GET,$mysqldao);
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
		<title>回复会议通知</title>		
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<LINK href="../manage.css" type="text/css" rel="stylesheet">
		<script type="text/javascript">
  			function checkData(id,c)
			{  				
				var sel = document.getElementsByName("selUserList[]");				
				for(i=0;i<sel.length;i++)
				{
					if(sel[i].id == "gu"+id)
					{
						sel[i].checked =c;
					}
				}
			}
		</script>
	</HEAD>
	<body >
	<br>
		<form id="addSubSite" name="addSubSite" method="post">
			<table id="FormTable" cellSpacing="1" cellPadding="0" width="98%" align="center" bgColor="#ffffff"
				border="0">
				<tr>
					<td class="FormCaption" align="center" bgColor="#668cd9">回复会议通知</td>
				</tr>
				<tr>
					<td vAlign="middle" align="center" bgColor="#f1f3f5">
						<table cellSpacing="1" cellPadding="0" width="99%" align="center" bgColor="#ebebeb"
							border="0">
							<TR>
								<TD class="FormLabel" align="center" colspan="2">
								<a href='myNewNotice.php'>返回</a>								
								</TD>
							</TR>							
							<tr>
								<td class="FormLabel" align="right">标题:</td>
								<td class="FormLabel"><?=$myPageClass->title?></td>
							</tr>
							<tr>
								<td class="FormLabel" align="right">内容:</td>
								<td class="FormLabel"><?=$myPageClass->content?></td>
							</tr>
							<tr>
								<td class="FormLabel" align="right">发布人:</td>
								<td class="FormLabel"><?=$myPageClass->user_realname?></td>
							</tr>
							<tr>
								<td class="FormLabel" align="right">发布时间:</td>
								<td class="FormLabel"><?=$myPageClass->send_time?></td>
							</tr>
							<tr>
								<td class="FormLabel" align="right">回复选项:</td>
								<td class="FormLabel">
									<select name="reply_type" id="reply_type">
					     			<?php
					     			  for($i=0;$i<count($myPageClass->relpyTypeList);$i+=2)
					     			  {
					     			  	if ($myPageClass->relpyTypeList[$i] == $myPageClass->reply_type){
					     			  		echo "<option value='".$myPageClass->relpyTypeList[$i]."' selected='selected'>".$myPageClass->relpyTypeList[$i+1]."</option>\n";
					     			  	} else {
					     			  		echo "<option value='".$myPageClass->relpyTypeList[$i]."'>".$myPageClass->relpyTypeList[$i+1]."</option>\n";     			  		
					     			  	}
					     			  } 
					     			?>
					     		</select>																
								</td>
							</tr>
							<tr>
								<td class="FormLabel" align="right">说明:</td>
								<td class="FormLabel">
								<input type="text" maxlength="250" name="note" id="note" style="width: 400px;" value="<?=$myPageClass->note?>"/>
								仅在不能参会时填写							
								</td>
							</tr>
							<tr>
								<td class="FormLabel" colSpan="2">
									<input type="submit" name="btnSave" id="btnSave" value="提交"/>
									<input type="hidden" name="notice_id" id="notice_id" value="<?=$myPageClass->notice_id?>"/>
									<input type="hidden" name="relpy_id" id="relpy_id" value="<?=$myPageClass->relpy_id?>"/>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</form>
	</body>
</HTML>
