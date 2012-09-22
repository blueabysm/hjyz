<?php
session_start();
include_once("../../util/commonFunctions.php");
canAcesssThisPage(37); 

include_once("../../database/mysqlDAO.php");
include("manageSurveyClass.inc.php");

$myPageClass = new manageSurveyClass($_POST,$_GET,$mysqldao);
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
<title>调查栏目管理</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<LINK href="../manage.css" type="text/css" rel="stylesheet">
<script type="">
  	function delItem(cid,id)
	{
		if ( confirm("你确定要删除该条备选答案吗？") == false) return false;
		window.location="deleteSurveyItem.php?id=" + id + "&cid=" + cid;
		return false;
	}
</script>
</HEAD>
<body >
<br>
<form name="Form1" method="post" id="Form1">
<table id="FormTable" cellSpacing="1" cellPadding="0" width="98%"
	align="center" bgColor="#ffffff" border="0" height="100%">
	<tr>
		<td class="FormCaption" align="center" bgColor="#668cd9">管理  <?=$myPageClass->columns_name?> 栏目信息</td>
	</tr>
	<tr>
		<td vAlign="top" align="center" bgColor="#f1f3f5">
		<table height="99%" cellSpacing="1" cellPadding="0" width="100%"
			align="center" bgColor="#ebebeb" border="0">
			<tr>
				<td class="FormLabel" align="center" colspan="2">				
				<a href="<?=$myPageClass->retURL?>">返回</a>
				</td>
			</tr>
			<tr>
				<td class="FormLabel" align="right">答案类型:</td>
				<td class="FormLabel">
					<select name="survey_type" id="survey_type">
		     			<?php
		     			  for($i=0;$i<count($myPageClass->survey_type_list);$i+=2)
		     			  {
		     			  	if ($myPageClass->survey_type_list[$i] == $myPageClass->survey_type){
		     			  		echo "<option value='".$myPageClass->survey_type_list[$i]."' selected='selected'>".$myPageClass->survey_type_list[$i+1]."</option>\n";
		     			  	} else {
		     			  		echo "<option value='".$myPageClass->survey_type_list[$i]."'>".$myPageClass->survey_type_list[$i+1]."</option>\n";     			  		
		     			  	}
		     			  } 
		     			?>
		     		</select>
				</td>
			</tr>
			<tr>
				<td class="FormLabel" align="right">结果显示方式:</td>
				<td class="FormLabel">
					<select name="text_display_mode" id="text_display_mode">     			
		     			<?php
		     			  for($i=0;$i<count($myPageClass->text_display_mode_list);$i+=2)
		     			  {
		     			  	if ($myPageClass->text_display_mode_list[$i] == $myPageClass->text_display_mode){
		     			  		echo "<option value='".$myPageClass->text_display_mode_list[$i]."' selected='selected'>".$myPageClass->text_display_mode_list[$i+1]."</option>\n";
		     			  	} else {
		     			  		echo "<option value='".$myPageClass->text_display_mode_list[$i]."'>".$myPageClass->text_display_mode_list[$i+1]."</option>\n";     			  		
		     			  	}
		     			  } 
		     			?>
		     		</select>
				</td>
			</tr>
			<tr>
				<td class="FormLabel" align="right">调查的内容:</td>
				<td class="FormLabel">
					<textarea name="survey_contents" id="survey_contents"  style="width: 300px;height:80px;"><?=$myPageClass->survey_contents?></textarea>
					<font color="red">*</font>
				</td>
			</tr>			
			<tr>
				<td class="FormLabel" align="right"></td>
				<td class="FormLabel" align="left">				
				<input type="submit" name="btnSave" id="btnSave" value="保存"/>
				<input type="hidden" name="display_type" id="display_type" value="<?=$myPageClass->display_type?>"/>
     			<input type="hidden" name="columns_id" id="columns_id" value="<?=$myPageClass->columns_id?>"/>
     			<input type="hidden" name="retURL" id="retURL" value="<?=$myPageClass->retURL?>"/>
				</td>
			</tr>
			<tr>
				<td class="FormLabel" align="center" colspan="2"> </td>
			</tr>
			<tr>
				<td class="FormLabel" align="left" colspan="2">
				<a href='editSurveyItem.php?id=<?=$myPageClass->columns_id?>'>添加备选答案</a>				
				</td>
			</tr>
			<tr>
				<td align="center" valign="top" colspan="2">
				<TABLE cellSpacing="1" cellPadding="1" width="100%"	bgColor="#ffffff" border="0">
					<tr>
						<td class="TableTdCaption" colspan="4" align="center">备选答案一览表</td>
					</tr>
					<tr>
						<td class="TableTdCaption" width="10%" align="center">序号</td>
						<td class="TableTdCaption" width="50%" align="center">备选答案内容</td>						
						<td class="TableTdCaption" width="20%" align="center">是否自填</td>
						<td class="TableTdCaption" width="20%" align="center">操作</td>
					</tr>
					 <?php
			   		   for($i=0;$i<count($myPageClass->surveyItemList);$i++)
			   		   {
			   		   	if ( ($i % 2) == 0){
							$tmpstr = "";
						} else {							
							$tmpstr = " style='background: #F0F0F0;' ";
						}	
						
			   		   	echo "<tr>\n"; 
			   		   	echo "<td  align='center' class='TableTd' $tmpstr>".$myPageClass->surveyItemList[$i]["display_order"]."</td>\n";
			   		   	echo "<td class='TableTd' $tmpstr>".$myPageClass->surveyItemList[$i]["item_contents"]."</td>\n";
			   		   	echo "<td  align='center' class='TableTd' $tmpstr>";   		   	
			   		   	if ($myPageClass->surveyItemList[$i]["item_type"] == 3) echo "是";
			   		   	else echo "否"; 
			   		   	echo "</td>\n";
			   		   	echo "<td align='center' class='TableTd' $tmpstr>";   		   	
			   		   	echo "<a href='editSurveyItem.php?id=$myPageClass->columns_id&i_id=".$myPageClass->surveyItemList[$i]["survey_item_id"]."'>修改</a> ";
			   		   	echo "<a href='#' onclick='return delItem($myPageClass->columns_id,".$myPageClass->surveyItemList[$i]["survey_item_id"].")'>删除</a>";
			   		   	echo "</td>";
			   		   	echo "\n</tr>";   		   	 
			   		   } 
			   		 ?>
				</TABLE>
				</td>
			</tr>
		</table>
		</td>
	</tr>
</table>
</form>
</body>
</HTML>
