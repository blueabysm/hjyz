<?php
session_start();
include_once("../../util/commonFunctions.php");
canAcesssThisPage(40); 

include_once("../../database/mysqlDAO.php");
include("editSlideImageColumnsClass.inc.php");

$myPageClass = new editSlideImageColumnsClass($_POST,$_GET,$mysqldao);
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
		<title>编辑图片幻灯片栏目</title>		
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<LINK href="../manage.css" type="text/css" rel="stylesheet">
	</HEAD>
	<body >	
	<br>
		<form id="editSlideImage" name="editSlideImage" method="post">
			<table id="FormTable" cellSpacing="1" cellPadding="0" width="98%" align="center" bgColor="#ffffff"
				border="0">
				<tr>
					<td class="FormCaption" align="center" bgColor="#668cd9">编辑图片幻灯片栏目</td>
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
								<td class="FormLabel" align="right">栏目名称:</td>
								<td class="FormLabel"><?=$myPageClass->columns_name?></td>
							</tr>
							<tr>
								<td class="FormLabel" align="right">文章栏目:</td>
								<td class="FormLabel">
								<select name="columns_imagelist_id" id="columns_imagelist_id">					
									<?php
									  	 echo "<option value='0' ";
										 if ($myPageClass->columns_imagelist_id == 0) {
										 	echo " selected='selected'";
										 }
										 echo ">请选择文章栏目</option>\n";
										  
										 for($i=0;$i<count($myPageClass->my_imagelist);$i++)
										  {
										     	if ($myPageClass->my_imagelist[$i]["columns_id"] == $myPageClass->columns_imagelist_id){
										     		$tmpstr = "selected='selected'";										     		
										     	} else {
										     		$tmpstr = "";										     		     			  		
										     	}
										     	echo "<option value='".$myPageClass->my_imagelist[$i]["columns_id"]."' $tmpstr>".$myPageClass->my_imagelist[$i]["columns_name"]."</option>\n";
										  } 
									?>
								</select>
								如果没有可选的文章栏目，请创建一个文章栏目								
								</td>
							</tr>
							<tr>
								<td class="FormLabel" align="right">标题文字区域高度:</td>
								<td class="FormLabel">
								<input type="text" maxlength="6" name="text_height" id="text_height" style="width: 100px;" value="<?=$myPageClass->text_height?>"/>								
								</td>
							</tr>
							<tr>
								<td class="FormLabel" align="right">单个图片宽度:</td>
								<td class="FormLabel">
								<input type="text" maxlength="6" name="img_width" id="img_width" style="width: 100px;" value="<?=$myPageClass->img_width?>"/>								
								显示在页面中的图片宽度 单位:像素
								</td>
							</tr>
							<tr>
								<td class="FormLabel" align="right">单个图片高度:</td>
								<td class="FormLabel">
								<input type="text" maxlength="6" name="img_heigth" id="img_heigth" style="width: 100px;" value="<?=$myPageClass->img_heigth?>"/>								
								显示在页面中的图片高度 单位:像素
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
	</body>
</HTML>
