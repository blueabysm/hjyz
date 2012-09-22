<?php
session_start();
include_once("../../util/commonFunctions.php");
canAcesssThisPage(41); 

include_once("../../database/mysqlDAO.php");
include("addTopticColumnsClass.inc.php");

$myPageClass = new addTopticColumnsClass($_POST,$_GET,$mysqldao);
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
		<title>添加专题</title>		
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
			function delImg(divID,imgHiddenID,imgHiddenURLID)
			{
				nowDIVID = divID;
				nowImgHiddenID = imgHiddenID;
				nowImgHiddenURLID = imgHiddenURLID;
				if ( confirm("你确定要删除该图片吗？") == false) return false;				
				return true;
			}
			function uploadImg(divID,imgHiddenID,imgHiddenURLID)
			{
				nowDIVID = divID;
				nowImgHiddenID = imgHiddenID;
				nowImgHiddenURLID = imgHiddenURLID;				
				changeDiv("divMainForm");
				changeDiv("divUploadForm");	
			}			
			function onUploadEnd(ftype,fid,furl,fnote)
			{
				changeDiv("divMainForm");
				changeDiv("divUploadForm");
				var tmpobj = document.getElementById(nowDIVID);				
				tmpobj.innerHTML = "<a href='" + furl + "' target='_blank'><img width='100' height='100' border='0' src='" + furl + 
				"' /></a> <a onclick=\"return delImg('"+nowDIVID+"','"+nowImgHiddenID+"','"+nowImgHiddenURLID+"');\" href='../changeFileState.php?file_id=" + fid + "' target='changeFileState'>删除图片</a>";
				tmpobj = document.getElementById(nowImgHiddenID);				
				tmpobj.value = fid;
				tmpobj = document.getElementById(nowImgHiddenURLID);				
				tmpobj.value = furl;				
			}
			function onChangeFileStateEnd()
			{
				var tmpobj = document.getElementById(nowDIVID);				
				tmpobj.innerHTML = "<input type='button' onclick=\"uploadImg('"+nowDIVID+"','"+nowImgHiddenID+"','"+nowImgHiddenURLID+"')\" value='上传图片'/>";				
				tmpobj = document.getElementById(nowImgHiddenID);				
				tmpobj.value = 0;
				tmpobj = document.getElementById(nowImgHiddenURLID);				
				tmpobj.value = "";
			}
			var nowDIVID,nowImgHiddenID,nowImgHiddenURLID;
						
		</script>				
	</HEAD>
	<body >
	<div id="divMainForm">
	<br>
		<form id="addToptic" name="addToptic" method="post">
			<table id="FormTable" cellSpacing="1" cellPadding="0" width="98%" align="center" bgColor="#ffffff"
				border="0">
				<tr>
					<td class="FormCaption" align="center" bgColor="#668cd9">添加专题</td>
				</tr>
				<tr>
					<td vAlign="middle" align="center" bgColor="#f1f3f5">
						<table cellSpacing="1" cellPadding="0" width="99%" align="center" bgColor="#ebebeb"
							border="0">
							<TR>
								<TD class="FormLabel" align="center" colspan="2">
								<a href='manageTopticColumns.php?id=<?=$myPageClass->columns_id?>'>返回</a>								
								</TD>
							</TR>
							<TR>
								<TD class="FormLabel" align="right" width="20%">栏目名称:</TD>
								<TD class="FormLabel" width="80%">
									<?=$myPageClass->columns_name?>
									<iframe name="changeFileState" id="changeFileState" src="" width="1" height="1" frameborder="0" marginheight="0" marginwidth="0"></iframe>
								</TD>
								
							</TR>
							<TR>
								<TD class="FormLabel" align="right">专题名称:</TD>
								<td class="FormLabel">
								<input type="text" maxlength="100" name="toptic_name" id="toptic_name" style="width: 300px;" value="<?=$myPageClass->toptic_name?>"/>
								<font color="red">*</font>
								</td>
							</TR>
							<tr>
								<td class="FormLabel" align="right">专题链接:</td>
								<td class="FormLabel">
								<input type="text" maxlength="200" name="toptic_href" id="toptic_href" style="width: 300px;" value="<?=$myPageClass->toptic_href?>"/>
								(不推荐,仅当你需要点击该专题转到指定的链接时填写)							
								</td>
							</tr>
							<tr>
								<td class="FormLabel" align="right">序号:</td>
								<td class="FormLabel">
								<input type="text" maxlength="4" name="toptic_order" id="toptic_order" style="width: 300px;" value="<?=$myPageClass->toptic_order?>"/>								
								</td>
							</tr>
							<TR>
								<TD class="FormLabel" align="right">专题导读:</TD>
								<td class="FormLabel">
								<input type="text" maxlength="220" name="toptic_note" id="toptic_note" style="width: 300px;" value="<?=$myPageClass->toptic_note?>"/>								
								</td>
							</TR>
							<tr>
								<td class="FormLabel" align="right">首页图片:</td>
								<td class="FormLabel">								
								<div id="imageDivSmall">
								  <?php
									if ($myPageClass->small_img_id == 0)
									{
										echo "<input type='button' onclick=\"uploadImg('imageDivSmall','small_img_id','small_img_url')\" value='上传图片'/>";
									} 
									else
									{
										echo "<a href='$myPageClass->small_img_url' target='_blank'><img width='100' height='100' border='0' src='$myPageClass->small_img_url' /></a> <a  onclick=\"return delImg('imageDivSmall','small_img_id','small_img_url');\" href='../changeFileState.php?file_id=$myPageClass->small_img_id' target='changeFileState'>删除图片</a>";
									}
								?>
								</div>
								<font color="red">*</font>
								</td>
							</tr>
							<tr>
								<td class="FormLabel" align="right">首页图片大小:</td>
								<td class="FormLabel">
								高度<input type="text" maxlength="4" name="small_img_height" id="small_img_height" style="width: 50px;" value="<?=$myPageClass->small_img_height?>"/><font color="red">*</font>
								宽度<input type="text" maxlength="4" name="small_img_width" id="small_img_width" style="width: 50px;" value="<?=$myPageClass->small_img_width?>"/>
								<font color="red">*</font>
								</td>
							</tr>
							<tr>
								<td class="FormLabel" align="right">标题图片:</td>
								<td class="FormLabel">
								<div id="imageDivBig">								 
								  <?php
									if ($myPageClass->big_img_id == 0)
									{
										echo "<input type='button' onclick=\"uploadImg('imageDivBig','big_img_id','big_img_url')\" value='上传图片'/>";
									} 
									else
									{
										echo "<a href='$myPageClass->big_img_url' target='_blank'><img width='100' height='100' border='0' src='$myPageClass->big_img_url' /></a> <a  onclick=\"return delImg('imageDivBig','big_img_id','big_img_url');\" href='../changeFileState.php?file_id=$myPageClass->big_img_id' target='changeFileState'>删除图片</a>";
									}
								?>
								</div>
								<font color="red">*</font>
								</td>
							</tr>
							<tr>
								<td class="FormLabel" align="right">标题图片大小:</td>
								<td class="FormLabel">
								高度<input type="text" maxlength="4" name="big_img_height" id="big_img_height" style="width: 50px;" value="<?=$myPageClass->big_img_height?>"/><font color="red">*</font>
								宽度<input type="text" maxlength="4" name="big_img_width" id="big_img_width" style="width: 50px;" value="<?=$myPageClass->big_img_width?>"/>
								<font color="red">*</font>
								</td>
							</tr>
							<tr>
								<td class="FormLabel" align="right">幻灯片栏目名称:</td>
								<td class="FormLabel">
								<input type="text" maxlength="100" name="slide_name" id="slide_name" style="width: 300px;" value="<?=$myPageClass->slide_name?>"/>
								<font color="red">*</font>
								</td>
							</tr>
							<tr>
								<td class="FormLabel" align="right">最新消息栏目名称:</td>
								<td class="FormLabel">
								<input type="text" maxlength="100" name="article_column_name" id="article_column_name" style="width: 300px;" value="<?=$myPageClass->article_column_name?>"/>
								<font color="red">*</font>
								</td>
							</tr>
							<tr>
								<td class="FormLabel" align="right">专题介绍栏目名称:</td>
								<td class="FormLabel">
								<input type="text" maxlength="100" name="html_column_name" id="html_column_name" style="width: 300px;" value="<?=$myPageClass->html_column_name?>"/>
								<font color="red">*</font>
								</td>
							</tr>
							<tr>
								<td class="FormLabel" align="right">图片新闻栏目名称:</td>
								<td class="FormLabel">
								<input type="text" maxlength="100" name="imagetable_name" id="imagetable_name" style="width: 300px;" value="<?=$myPageClass->imagetable_name?>"/>
								<font color="red">*</font>
								</td>
							</tr>
							<tr>
								<td class="FormLabel" colSpan="2">
									<input type="submit" name="btnAdd" id="btnAdd" value="添加"/>									
									<input type="hidden" name="columns_id" id="columns_id" value="<?=$myPageClass->columns_id?>"/>
									<input type="hidden" name="small_img_id" id="small_img_id" value="<?=$myPageClass->small_img_id?>"/>									
									<input type="hidden" name="big_img_id" id="big_img_id" value="<?=$myPageClass->big_img_id?>"/>
									<input type="hidden" name="small_img_url" id="small_img_url" value="<?=$myPageClass->small_img_url?>"/>									
									<input type="hidden" name="big_img_url" id="big_img_url" value="<?=$myPageClass->big_img_url?>"/>									
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
