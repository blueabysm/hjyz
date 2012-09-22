<?php
session_start();
include_once("../../util/commonFunctions.php");
canAcesssThisPage(37); 

include_once("../../database/mysqlDAO.php");
include("editSurveyItemClass.inc.php");

$myPageClass = new editSurveyItemClass($_POST,$_GET,$mysqldao);
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
		<title>添加/修改调查备选答案</title>		
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<LINK href="../manage.css" type="text/css" rel="stylesheet">
	</HEAD>
	<body >
	<br>
		<form id="editSurveyItem" name="editSurveyItem" method="post">
			<table id="FormTable" cellSpacing="1" cellPadding="0" width="98%" align="center" bgColor="#ffffff"
				border="0">
				<tr>
					<td class="FormCaption" align="center" bgColor="#668cd9">添加/修改调查备选答案</td>
				</tr>
				<tr>
					<td vAlign="middle" align="center" bgColor="#f1f3f5">
						<table cellSpacing="1" cellPadding="0" width="99%" align="center" bgColor="#ebebeb"
							border="0">
							<TR>
								<TD class="FormLabel" align="center" colspan="2">
								<a href='manageSurvey.php?id=<?=$myPageClass->columns_id?>'>返回</a>								
								</TD>
							</TR>
							<TR>
								<TD class="FormLabel" align="right">栏目名称:</TD>
								<TD class="FormLabel"><?=$myPageClass->columns_name?></TD>
							</TR>
							<tr>
								<td class="FormLabel" align="right">备选答案内容:</td>
								<td class="FormLabel">
								<input type="text" maxlength="200" name="item_contents" id="item_contents" style="width: 200px;" value="<?=$myPageClass->item_contents?>"/>
								<font color="red">*</font>
								</td>
							</tr>
							<tr>
								<td class="FormLabel" align="right">允许自填:</td>
								<td class="FormLabel">
									<?php
						     			  echo "<input type='checkbox'  name='isInput' id='isInput'  value='ok' ";
						     			  if ($myPageClass->isInput == 1){
						     			  	echo " checked='checked' ";
						     			  }
						     			  echo "/>";     			  
						     		?>
						     		选中此选项,允许用户自己填写该备选答案内容
								</td>
							</tr>							
							<TR>
								<TD class="FormLabel" align="right">序号:</TD>
								<TD class="FormLabel">
									<input type="text" maxlength="3" name="display_order" id="display_order" style="width: 200px;" value="<?=$myPageClass->display_order?>"/>								
								</TD>
							</TR>
							<tr>
								<td class="FormLabel" colSpan="2">
									<input type="submit" name="btnSave" id="btnSave" value="保存"/>
									<input type="hidden" name="item_type" id="item_type" value="<?=$myPageClass->item_type?>"/> 									
									<input type="hidden" name="columns_id" id="columns_id" value="<?=$myPageClass->columns_id?>"/>
									<input type="hidden" name="survey_item_id" id="survey_item_id" value="<?=$myPageClass->survey_item_id?>"/>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</form>
	</body>
</HTML>
