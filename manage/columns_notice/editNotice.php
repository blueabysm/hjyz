<?php
session_start();
include_once("../../util/commonFunctions.php");
canAcesssThisPage(43); 

include_once("../../database/mysqlDAO.php");
include("editNoticeClass.inc.php");

$myPageClass = new editNoticeClass($_POST,$_GET,$mysqldao);
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
		<title>修改会议通知</title>		
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<LINK href="../manage.css" type="text/css" rel="stylesheet">
		<script src="../editor/WLEditor.js" type="text/javascript"></script>
		<script type="text/javascript">
			function changeDiv(objID)
			{
				var tmpobj = document.getElementById(objID);				
				if (tmpobj.style.display == "none"){
					tmpobj.style.display="";
				} else {
					tmpobj.style.display="none";
				}
			}
			function localImageClick()
			{
				var tmpobj = document.getElementById("uploadIframe");						
				tmpobj.src = "../upload.php?it=1&nt=2";				
				changeDiv("divMainForm");
				changeDiv("divUploadForm");	
			}
			function localFileClick()
			{
				var tmpobj = document.getElementById("uploadIframe");
				tmpobj.src = "../upload.php?it=1&nt=1";
				changeDiv("divMainForm");
				changeDiv("divUploadForm");	
			}
			function onUploadEnd(ftype,fid,furl,fnote)
			{
				changeDiv("divMainForm");
				changeDiv("divUploadForm");
				
				if (ftype == 1) 
				{
					WLinsertFile(furl,fnote); 
				}
				else
				{
					WLinsertRecImage(furl, 0, 0, 0);
				}
			}
			function selectUser(id,c)
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
	<div id="divMainForm">
	<br>
		<form id="addSubSite" name="addSubSite" method="post"  onsubmit="return GetData();">
			<table id="FormTable" cellSpacing="1" cellPadding="0" width="98%" align="center" bgColor="#ffffff"
				border="0">
				<tr>
					<td class="FormCaption" align="center" bgColor="#668cd9">修改会议通知 - <?=$myPageClass->columnsName?></td>
				</tr>
				<tr>
					<td vAlign="middle" align="center" bgColor="#f1f3f5">
						<table cellSpacing="1" cellPadding="0" width="99%" align="center" bgColor="#ebebeb"
							border="0">
							<TR>
								<TD class="FormLabel" align="center" colspan="2">
								<a href='manageNewNotice.php?id=<?=$myPageClass->columnsID?>&page=<?=$myPageClass->page?>&retURL=<?=$myPageClass->retURL?>'>返回</a>								
								</TD>
							</TR>							
							<tr>
								<td class="FormLabel" align="right">标题:</td>
								<td class="FormLabel">
								<input type="text" maxlength="250" name="title" id="title" style="width: 400px;" value="<?=$myPageClass->title?>"/>
								<font color="red">*</font>								
								</td>
							</tr>
							<tr>
								<td class="FormLabel" align="right">状态:</td>
								<td class="FormLabel">
									<select name="state" id="state">
					     			<?php
					     			  for($i=0;$i<count($myPageClass->stateList);$i+=2)
					     			  {
					     			  	if ($myPageClass->stateList[$i] == $myPageClass->state){
					     			  		echo "<option value='".$myPageClass->stateList[$i]."' selected='selected'>".$myPageClass->stateList[$i+1]."</option>\n";
					     			  	} else {
					     			  		echo "<option value='".$myPageClass->stateList[$i]."'>".$myPageClass->stateList[$i+1]."</option>\n";     			  		
					     			  	}
					     			  } 
					     			?>
					     		</select>																
								</td>
							</tr>
							<tr>
								<td class="FormLabel" align="right">内容:</td>
								<td class="FormLabel">
								<input name="content" id="content" type="hidden" value="<?=$myPageClass->content?>" />
									<script type="text/javascript">
										var editor = new WLEditor("editor");
										editor.hiddenName = "content";
										editor.width = "85%";
										editor.height = "350px";
										editor.imagePath = '../editor/images/';
										editor.uploadFileFunction = 'localFileClick();';
										editor.uploadImageFunction = 'localImageClick();';										
										editor.show();
										function GetData()
										{  
											var tmpobj = document.getElementById("content");											
											tmpobj.value = editor.data();																					
											return true;
										}																			
									</script>								
								<font color="red">*</font>								
								</td>
							</tr>
							<tr>
								<td class="FormLabel" align="right">接收人:</td>
								<td class="FormLabel" >
								     	提示:请直接选择用户或组，系统会自动排除相同的用户
									 <TABLE cellSpacing="1" cellPadding="1" width="400" bgColor="#ffffff" border="0">
											<tr>
												<td class="TableTdCaption" width="60%" align="center">用户组</td>
												<td class="TableTdCaption" width="40%" align="center">姓名</td>
											</tr>
											<?php
											  for($i=0;$i<count($myPageClass->userGroupList);$i++)
							     			  {
							     			  	echo '<tr>';
							     			  	echo '<td class="TableTd">';
							     			  	echo '<input type="checkbox" onclick="selectUser('.$myPageClass->userGroupList[$i]["group_id"].',this.checked)"/>';
							     			  	echo $myPageClass->userGroupList[$i]["group_name"];
							     			  	echo '</td>';							     			  	
							     			  	echo '<td class="TableTd">';
							     			  	$str1= ','.$myPageClass->userGroupList[$i]["group_users"].',';							     			  
							     			  	for($j=0;$j<count($myPageClass->allUserList);$j++){
							     			  		$str2= ','.$myPageClass->allUserList[$j]["user_id"].',';
							     			  		$find = strpos($str1,$str2);
							     			  		if (!($find ===false)){
								     			  		echo '<input type="checkbox" name="selUserList[]" id="gu'.$myPageClass->userGroupList[$i]["group_id"].'" value="'.$myPageClass->allUserList[$j]["user_id"] . '" ';
								     			  		if ($myPageClass->isSelected($myPageClass->allUserList[$j]["user_id"]) == 1){
									     			  			echo 'checked="checked" ';
									     			  		}
								     			  		echo '/>';
								     			  		echo $myPageClass->allUserList[$j]["user_realname"];
								     			  		echo '<br>';
							     			  		}
							     			  	}
							     			  	echo '</td>';							     			  	
							     			  	echo '</tr>';
							     			  }							     			  						     			 
					     					?>											
									 </TABLE>
									 <font color="red">*</font>
								</td>
							</tr>
																		
								
							<tr>
								<td class="FormLabel" colSpan="2">
									<input type="submit" name="btnSave" id="btnSave" value="保存"/>
									<input type="hidden" name="notice_id" id="notice_id" value="<?=$myPageClass->notice_id?>"/>
									<input type="hidden" name="columnsID" id="columnsID" value="<?=$myPageClass->columnsID?>"/>
									<input type="hidden" name="retURL" id="retURL" value="<?=$myPageClass->retURL?>"/>
									<input type="hidden" name="page" id="page" value="<?=$myPageClass->page?>"/>				
									<input type="hidden" name="s" id="s" value="<?=$myPageClass->s?>"/>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</form>
		</div>
	<div id="divUploadForm" style="display: none;">
		<iframe name="uploadIframe" id="uploadIframe" src="" height="100%" width="100%" frameborder="0" marginheight="0" marginwidth="0"></iframe>
	</div>
	</body>
</HTML>
