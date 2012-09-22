<?php
session_start();
include_once("../../util/commonFunctions.php");
canAcesssThisPage(20); 

include_once("../../database/mysqlDAO.php");
include("editHeadClass.inc.php");

$myPageClass = new editHeadClass($_POST,$_GET,$mysqldao);
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
		<title>添加领导信息</title>		
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<LINK href="../manage.css" type="text/css" rel="stylesheet">
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
			function delImg()
			{
				if ( confirm("你确定要删除该相片吗？") == false) return false;				
				return true;
			}
			function uploadImg()
			{							
				changeDiv("divMainForm");
				changeDiv("divUploadForm");	
			}			
			function onUploadEnd(ftype,fid,furl,fnote)
			{
				changeDiv("divMainForm");
				changeDiv("divUploadForm");
				var tmpobj = document.getElementById("imageDiv");
				tmpobj.innerHTML = "<a href='" + furl + "' target='_blank'><img width='73' height='103' border='0' src='" + furl + "' /></a> <a onclick='return delImg();' href='../changeFileState.php?file_id=" + fid + "' target='changeFileState'>删除相片</a>";
				tmpobj = document.getElementById("head_photo");
				tmpobj.value = fid;
				tmpobj = document.getElementById("file_url");
				tmpobj.value = furl;
			}
			function onChangeFileStateEnd()
			{
				var tmpobj = document.getElementById("imageDiv");
				tmpobj.innerHTML = "<input type='button' onclick='uploadImg()' value='上传图片'/>";
				tmpobj = document.getElementById("head_photo");
				tmpobj.value = 0;
				tmpobj = document.getElementById("file_url");
				tmpobj.value = "";
			}			
		</script>				
	</HEAD>
	<body >
	<div id="divMainForm">
	<br>
		<form id="addPart" name="addPart" method="post">
			<table id="FormTable" cellSpacing="1" cellPadding="0" width="98%" align="center" bgColor="#ffffff"
				border="0">
				<tr>
					<td class="FormCaption" align="center" bgColor="#668cd9">添加领导信息</td>
				</tr>
				<tr>
					<td vAlign="middle" align="center" bgColor="#f1f3f5">
						<table cellSpacing="1" cellPadding="0" width="99%" align="center" bgColor="#ebebeb"
							border="0">
							<TR>
								<TD class="FormLabel" align="center" colspan="2">
								<a href='manageHead.php?id=<?=$myPageClass->corp_id?>'>返回</a>								
								</TD>
							</TR>
							<TR>
								<TD class="FormLabel" align="right">单位名称:</TD>
								<TD class="FormLabel"><?=$myPageClass->corp_name?></TD>
							</TR>
							<TR>
								<TD class="FormLabel" align="right">领导姓名:</TD>
								<td class="FormLabel">
								<input type="text" maxlength="100" name="head_name" id="head_name" style="width: 300px;" value="<?=$myPageClass->head_name?>"/>
								<font color="red">*</font>
								</td>
							</TR>
							<tr>
								<td class="FormLabel" align="right">领导相片:</td>
								<td class="FormLabel">
								<div id="imageDiv">
								<?php
									if ($myPageClass->head_photo == 0)
									{
										echo "<input type='button' onclick='uploadImg()' value='上传图片'/>";
									} 
									else
									{
										echo "<a href='$myPageClass->file_url' target='_blank'><img width='73' height='103' border='0' src='$myPageClass->file_url' /></a> <a  onclick='return delImg();' href='../changeFileState.php?file_id=$myPageClass->head_photo' target='changeFileState'>删除相片</a>";
									}
								?>
								</div>
								<iframe name="changeFileState" id="changeFileState" src="" width="1" height="1" frameborder="0" marginheight="0" marginwidth="0"></iframe>																
								</td>
							</tr>
							<tr>
								<td class="FormLabel" align="right">首个栏目:</td>
								<td class="FormLabel">
								<select name="article_column_id" id="article_column_id">
					     			<?php
					     			  if (count($myPageClass->colList) > 0){
						     			  for($i=0;$i<count($myPageClass->colList);$i++)
						     			  {
						     			  	$sel = '';
						     			  	if ($myPageClass->colList[$i]['column_id'] == $myPageClass->article_column_id){
						     			  		$sel = "selected='selected'";
						     			  	}
						     			  	echo "<option value='".$myPageClass->colList[$i]['column_id']."' $sel>".$myPageClass->colList[$i]['columns_name'].'</option>\n';
						     			  } 
					     			  } else {
					     			  	echo '<option value="0">尚未指定栏目</option>';;
					     			  }
					     			?>
					     		</select>									
								</td>
							</tr>
							<tr>
								<td class="FormLabel" align="right">职务:</td>
								<td class="FormLabel">
								<input type="text" maxlength="300" name="head_post" id="head_post" style="width: 300px;" value="<?=$myPageClass->head_post?>"/>
								<font color="red">*</font>
								</td>
							</tr>
							<tr>
								<td class="FormLabel" align="right">分管:</td>
								<td class="FormLabel">
								<input type="text" maxlength="300" name="head_post2" id="head_post2" style="width: 300px;" value="<?=$myPageClass->head_post2?>"/>
								</td>
							</tr>																				
							<TR>
								<TD class="FormLabel" align="right">序号:</TD>
								<TD class="FormLabel">
								<input type="text" maxlength="4" name="head_order" id="head_order" style="width: 300px;" value="<?=$myPageClass->head_order?>"/>
								显示顺序，值越小顺序越靠前
								</TD>
							</TR>
							<tr>
								<td class="FormLabel" align="right">领导简历:</td>
								<td class="FormLabel">
								<textarea name="head_note" id="head_note"  style="width: 300px;height:80px;"><?=$myPageClass->head_note?></textarea>
								</td>
							</tr>							
							<tr>
								<td class="FormLabel" align="right">电子邮箱:</td>
								<td class="FormLabel">
								<input type="text" maxlength="255" name="head_mail" id="head_mail" style="width: 300px;" value="<?=$myPageClass->head_mail?>"/>
								</td>
							</tr>
							<tr>
								<td class="FormLabel" colSpan="2">
									<input type="submit" name="btnSave" id="btnSave" value="保存"/>									
									<input type="hidden" name="corp_id" id="corp_id" value="<?=$myPageClass->corp_id?>"/>
									<input type="hidden" name="head_id" id="head_id" value="<?=$myPageClass->head_id?>"/>
									<input type="hidden" name="head_photo" id="head_photo" value="<?=$myPageClass->head_photo?>"/>
									<input type="hidden" name="file_url" id="file_url" value="<?=$myPageClass->file_url?>"/>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</form>
		</div>
	    <div id="divUploadForm" style="display: none;">
		  <iframe name="uploadIframe" id="uploadIframe" src="../upload.php?it=1&nt=2" height="100%" width="100%" frameborder="0" marginheight="0" marginwidth="0"></iframe>
	    </div>
	</body>
</HTML>
