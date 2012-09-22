<?php
session_start();
include_once("../../util/commonFunctions.php"); 
canAcesssThisPage(34);

include_once("../../database/mysqlDAO.php");
include("editArticleClass.inc.php");

$myPageClass = new editArticleClass($_POST,$_GET,$mysqldao);
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
		<title>添加/修改信息公开</title>		
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
					WLInsertImage(furl, 0, 0, 0);
				}
			}			
		</script>
	</HEAD>
	<body >
	<div id="divMainForm">
	<br>
		<form id="editArticle" name="editArticle" onsubmit="return GetData();"  method="post">
			<table id="FormTable" cellSpacing="1" cellPadding="0" width="98%" align="center" bgColor="#ffffff"
				border="0">
				<tr>
					<td class="FormCaption" align="center" bgColor="#668cd9">添加/修改公开信息</td>
				</tr>
				<tr>
					<td vAlign="middle" align="center" bgColor="#f1f3f5">
						<table cellSpacing="1" cellPadding="0" width="99%" align="center" bgColor="#ebebeb"
							border="0">
							<TR>
								<TD class="FormLabel" align="center" colspan="2">
								<a href='manageArticle.php?id=<?=$myPageClass->item_id?>&page=<?echo $myPageClass->to_page?>&retURL=<?=$myPageClass->retURL?>'>返回公开信息列表</a>								
								</TD>
							</TR>
							<TR>
								<TD class="FormLabel" align="right">公开信息栏目名称:</TD>
								<TD class="FormLabel"><?=$myPageClass->columns_name?></TD>
							</TR>
							<tr>
								<td class="FormLabel" align="right">信息名称:</td>
								<td class="FormLabel">
								<input type="text" maxlength="200" name="article_title" id="article_title" style="width: 300px;" value="<?=$myPageClass->article_title?>"/>
								<font color="red">*</font>
								</td>
							</tr>
							<tr>
								<td class="FormLabel" align="right">内容概述:</td>
								<td class="FormLabel">
								<input type="text" maxlength="200" name="article_key" id="article_key" style="width: 300px;" value="<?=$myPageClass->article_key?>"/>								
								</td>
							</tr>
							<tr>
								<td class="FormLabel" align="right">信息类别:</td>
								<td class="FormLabel">
								<input type="text" maxlength="200" name="article_ath" id="article_ath" style="width: 300px;" value="<?=$myPageClass->article_ath?>"/>
								</td>
							</tr>
							<TR>
								<TD class="FormLabel" align="right">发文机构:</TD>
								<TD class="FormLabel">
								<input type="text" maxlength="200" name="article_from" id="article_from" style="width: 300px;" value="<?=$myPageClass->article_from?>"/>
								</TD>
							</TR>
							<TR>
								<TD class="FormLabel" align="right">序号:</TD>
								<TD class="FormLabel">
								<input type="text" maxlength="4" name="article_order" id="article_order" style="width: 300px;" value="<?=$myPageClass->article_order?>"/>
								文章在栏目中的显示顺序，值越小顺序越靠前
								</TD>
							</TR>
							<TR>
								<TD class="FormLabel" align="right">信息状态:</TD>
								<TD class="FormLabel">
									<select name="article_state" id="article_state">
						     			<?php
						     			  for($i=0;$i<count($myPageClass->article_state_list);$i+=2)
						     			  {
						     			  	if ($myPageClass->article_state_list[$i] == $myPageClass->article_state){
						     			  		echo "<option value='".$myPageClass->article_state_list[$i]."' selected='selected'>".$myPageClass->article_state_list[$i+1]."</option>\n";
						     			  	} else {
						     			  		echo "<option value='".$myPageClass->article_state_list[$i]."'>".$myPageClass->article_state_list[$i+1]."</option>\n";     			  		
						     			  	}
						     			  } 
						     			?>
						     		</select>
						     		只有处于“发布”状态的文章才会在网站上显示
								</TD>
							</TR>
							<?php if (strlen($myPageClass->back_text) > 0){?>
							<tr>
								<td class="FormLabel" align="right">退回说明:</td>
								<td class="FormLabel"><?=$myPageClass->back_text?></td>
							</tr>
							<?php }?>
							<tr>
								<td class="FormLabel" align="right">图片url:</td>
								<td class="FormLabel">
								<input type="text" maxlength="200" name="img_url" id="img_url" style="width: 300px;" value="<?=$myPageClass->img_url?>"/>							
								
								</td>
							</tr>
							<tr>
								<td class="FormLabel" colSpan="2">
								<input name="article_content" id="article_content" type="hidden" value="<?=$myPageClass->article_content?>" />
									<script type="text/javascript">
										var editor = new WLEditor("editor");
										editor.hiddenName = "article_content";
										editor.width = "100%";
										editor.height = "400px";
										editor.imagePath = '../editor/images/';
										editor.uploadFileFunction = 'localFileClick();';
										editor.uploadImageFunction = 'localImageClick();';	
										editor.show();
										function GetData()
										{  
											var tmpobj = document.getElementById("article_content");											
											tmpobj.value = editor.data();																					
											return true;
										}										
									</script>
								</td>
							</tr>
							<tr>
								<td class="FormLabel" colSpan="2">
									<input type="submit" name="btnSave" id="btnSave" value="保存"/>									
									<input type="hidden" name="article_id" id="article_id" value="<?=$myPageClass->article_id?>"/>
									<input type="hidden" name="item_id" id="item_id" value="<?=$myPageClass->item_id?>"/>
									<input type="hidden" name="retURL" id="retURL" value="<?=$myPageClass->retURL?>"/>
									<input type="hidden" name="to_page" id="to_page" value="<?=$myPageClass->to_page?>"/>
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
