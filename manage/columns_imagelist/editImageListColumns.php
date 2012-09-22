<?php
session_start();
include_once("../../util/commonFunctions.php");
canAcesssThisPage(38); 

include_once("../../database/mysqlDAO.php");
include("editImageListColumnsClass.inc.php");

$myPageClass = new editImageListColumnsClass($_POST,$_GET,$mysqldao);
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
		<title>添加/修改图片</title>		
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
				if ( confirm("你确定要删除该图片吗？") == false) return false;				
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
				tmpobj.innerHTML = "<a href='" + furl + "' target='_blank'><img width='100' height='100' border='0' src='" + furl + "' /></a> <a onclick='return delImg();' href='../changeFileState.php?file_id=" + fid + "' target='changeFileState'>删除图片</a>";
				tmpobj = document.getElementById("file_id");
				tmpobj.value = fid;
				tmpobj = document.getElementById("file_url");
				tmpobj.value = furl;
			}
			function onChangeFileStateEnd()
			{
				var tmpobj = document.getElementById("imageDiv");
				tmpobj.innerHTML = "<input type='button' onclick='uploadImg()' value='上传图片'/>";
				tmpobj = document.getElementById("file_id");
				tmpobj.value = 0;
				tmpobj = document.getElementById("file_url");
				tmpobj.value = "";
			}			
		</script>		
	</HEAD>
	<body >
	<div id="divMainForm">
	<br>
		<form id="editLink" name="editLink" method="post">
			<table id="FormTable" cellSpacing="1" cellPadding="0" width="98%" align="center" bgColor="#ffffff"
				border="0">
				<tr>
					<td class="FormCaption" align="center" bgColor="#668cd9">添加/修改图片</td>
				</tr>
				<tr>
					<td vAlign="middle" align="center" bgColor="#f1f3f5">
						<table cellSpacing="1" cellPadding="0" width="99%" align="center" bgColor="#ebebeb"
							border="0">
							<TR>
								<TD class="FormLabel" align="center" colspan="2">
								 <a href='manageImageListColumns.php?id=<?=$myPageClass->columns_id?>&retURL=<?=$myPageClass->retURL?>'>返回</a>								
								</TD>
							</TR>
							<TR>
								<TD class="FormLabel" align="right">栏目名称:</TD>
								<TD class="FormLabel"><?=$myPageClass->columns_name?></TD>
							</TR>
							<tr>
								<td class="FormLabel" align="right">标题:</td>
								<td class="FormLabel">
								<input type="text" maxlength="200" name="item_title" id="item_title" style="width: 300px;" value="<?=$myPageClass->item_title?>"/>								
								<font color="red">*</font>
								</td>
							</tr>
							<tr>
								<td class="FormLabel" align="right">地址:</td>
								<td class="FormLabel">
								<input type="text" maxlength="200" name="item_link" id="item_link" style="width: 300px;" value="<?=$myPageClass->item_link?>"/>								
								</td>
							</tr>							
							<TR>
								<TD class="FormLabel" align="right">序号:</TD>
								<TD class="FormLabel">
								<input type="text" maxlength="4" name="item_order" id="item_order" style="width: 300px;" value="<?=$myPageClass->item_order?>"/>
								链接条的显示顺序，值越小顺序越靠前
								</TD>
							</TR>
							<tr>
								<td class="FormLabel" align="right">图片:</td>
								<td class="FormLabel">
								<div id="imageDiv">
								<?php
									if ($myPageClass->file_id == 0)
									{
										echo "<input type='button' onclick='uploadImg()' value='上传图片'/>";
									} 
									else
									{
										echo "<a href='$myPageClass->file_url' target='_blank'><img width='100' height='100' border='0' src='$myPageClass->file_url' /></a> <a  onclick='return delImg();' href='../changeFileState.php?file_id=$myPageClass->file_id' target='changeFileState'>删除图片</a>";
									}
								?>
								</div>
								<font color="red">*</font>
								<iframe name="changeFileState" id="changeFileState" src="" width="1" height="1" frameborder="0" marginheight="0" marginwidth="0"></iframe>																
								</td>
							</tr>
							<tr>
								<td class="FormLabel" colSpan="2">
									<input type="submit" name="btnSave" id="btnSave" value="保存"/>
																		
									<input type="hidden" name="columns_id" id="columns_id" value="<?=$myPageClass->columns_id?>"/>
									<input type="hidden" name="columns_imagelist_id" id="columns_imagelist_id" value="<?=$myPageClass->columns_imagelist_id?>"/>
									<input type="hidden" name="file_id" id="file_id" value="<?=$myPageClass->file_id?>"/>
									<input type="hidden" name="file_url" id="file_url" value="<?=$myPageClass->file_url?>"/>
									<input type="hidden" name="retURL" id="retURL" value="<?=$myPageClass->retURL?>"/>
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
