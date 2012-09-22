<?php
session_start();
include_once("../util/commonFunctions.php");
canAcesssThisPage(0); 

include("../database/mysqlDAO.php");
include("uploadClass.inc.php");

$myPageClass = new uploadClass($_POST,$_GET,$mysqldao);
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
		<title>文件上传</title>		
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<LINK href="manage.css" type="text/css" rel="stylesheet">
		<script type="text/javascript">
			function dataCheck()
			{				
				var fileTypes = '<?=$myPageClass->jsFileType?>';
				
				var tmpobj = document.getElementById("myUploadFile");
				var tmpstr = tmpobj.value.toString().toLowerCase();				
				var i= 0;

				if (tmpstr.length == 0){
					alert("请选择文件");
					return false;
				}				
				i = tmpstr.lastIndexOf('.');
				if ( (i<0) || (i == tmpstr.length -1) ){
					alert("错误的文件类型,请重新选择文件");
					return false;
				}
				tmpstr = tmpstr.substring(i + 1);
				if (fileTypes.indexOf(","+tmpstr+",") < 0){
					alert("不允许上传此类型的文件,请重新选择文件");
					return false;
				}
				tmpobj = document.getElementById("file_note");
				tmpstr = tmpobj.value;
				if (tmpstr.length < 1){
					alert("请填写文件说明");
					return false;
				}
				return true;
			}
			function btnCancel()
			{
				if (window.parent != window.self)
				{					
					window.parent.changeDiv("divUploadForm");
					window.parent.changeDiv("divMainForm");					
				}		
				return false;					
			}			
		</script>		
	</HEAD>
	<body >
	<br>
		<form id="fileUpload" name="fileUpload" method="post" enctype="multipart/form-data" onsubmit="return dataCheck();">
			<table id="FormTable" cellSpacing="1" cellPadding="0" width="98%" align="center" bgColor="#ffffff"
				border="0">
				<tr>
					<td class="FormCaption" align="center" bgColor="#668cd9">文件上传</td>
				</tr>
				<tr>
					<td vAlign="middle" align="center" bgColor="#f1f3f5">
						<table cellSpacing="1" cellPadding="0" width="99%" align="center" bgColor="#ebebeb"
							border="0">
							<tr>
								<td class="FormLabel" align="right">选择文件:</td>
								<td class="FormLabel">								
								<input type="file" name="myUploadFile" id="myUploadFile" />								
								</td>
							</tr>
							<tr>
								<td class="FormLabel" align="right">文件说明:</td>
								<td class="FormLabel">
								<input type="text" maxlength="200" name=file_note id="file_note" style="width: 200px;" value="<?=$myPageClass->file_note?>"/>								
								<font color="red">*</font>
								</td>
							</tr>
							<tr>
								<td class="FormLabel" colSpan="2">
									<input type="submit" name="btnSave" id="btnSave" value="上传"/>									
									<input type="button" onClick="btnCancel()" value="取消"/>
									<input type="hidden" name="nowIncludeType" id="nowIncludeType" value="<?=$myPageClass->nowIncludeType?>"/>			
									<input type="hidden" name="needFileType" id="needFileType" value="<?=$myPageClass->needFileType?>"/>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</form>
		<?php
			echo $myPageClass->processOnSuccess; 
		?>
	</body>
</HTML>