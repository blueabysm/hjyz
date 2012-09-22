<?php
session_start();
include_once("../../util/commonFunctions.php");
canAcesssThisPage(36); 

include_once("../../database/mysqlDAO.php");
include("editHtmlColumnsClass.inc.php");

$myPageClass = new editHtmlColumnsClass($_POST,$_GET,$mysqldao);
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
		<title>自由编辑栏目管理</title>		
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta http-equiv="Pragma" content="no-cache">
		<meta http-equiv="no-cache">
		<meta http-equiv="Expires" content="-1">
		<meta http-equiv="Cache-Control" content="no-cache">
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
		<form id="editHtml" name="editHtml" onsubmit="return GetData();"  method="post">
			<table id="FormTable" cellSpacing="1" cellPadding="0" width="98%" align="center" bgColor="#ffffff"
				border="0">
				<tr>
					<td class="FormCaption" align="center" bgColor="#668cd9">修改 <?=$myPageClass->columns_name?> 栏目信息</td>
				</tr>
				<tr>
					<td vAlign="middle" align="center" bgColor="#f1f3f5">
						<table cellSpacing="1" cellPadding="0" width="99%" align="center" bgColor="#ebebeb"
							border="0">
							<TR>
								<TD class="FormLabel" align="center" colspan="2">
								<a href='<?=$myPageClass->retURL?>'>返回</a>								
								</TD>
							</TR>
							<tr>
								<td class="FormLabel" colSpan="2">
								<input name="columns_contents" id="columns_contents" type="hidden" value="<?=$myPageClass->columns_contents?>" />
									<script type="text/javascript">
										var editor = new WLEditor("editor");
										editor.hiddenName = "columns_contents";
										editor.width = "100%";
										editor.height = "400px";
										editor.imagePath = '../editor/images/';
										editor.uploadFileFunction = 'localFileClick();';
										editor.uploadImageFunction = 'localImageClick();';										
										editor.show();
										function GetData()
										{  
											var tmpobj = document.getElementById("columns_contents");											
											tmpobj.value = editor.data();																					
											return true;
										}																			
									</script>
								</td>
							</tr>
							<tr>
								<td class="FormLabel" colSpan="2">
									<input type="submit" name="btnSave" id="btnSave" value="保存"/>		
									<input type="hidden" name="columns_id" id="columns_id" value="<?=$myPageClass->columns_id?>"/>
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
		<iframe name="uploadIframe" id="uploadIframe" src="" height="100%" width="100%" frameborder="0" marginheight="0" marginwidth="0"></iframe>
	</div>
	</body>
</HTML>

