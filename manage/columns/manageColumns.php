<?php
session_start();
include_once("../../util/commonFunctions.php");
canAcesssThisPage(3,1,"../login.php"); 

include_once("../../database/mysqlDAO.php");
include("manageColumnsClass.inc.php");

$myPageClass = new manageColumnsClass($_POST,$_GET,$mysqldao);
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
<title>我的栏目</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<LINK href="../manage.css" type="text/css" rel="stylesheet">
<script type="">
  	function toPage(page)
	{
		var tmpobj = document.getElementById("to_page");
		tmpobj.value=page;
        document.forms[0].submit();
	}
</script>
</HEAD>
<body >
<br>
<form name="Form1" method="post" action="manageColumns.php" id="Form1">
<table id="FormTable" cellSpacing="1" cellPadding="0" width="98%"
	align="center" bgColor="#ffffff" border="0">
	<tr>
		<td class="FormCaption" align="center" bgColor="#668cd9">我的栏目-列表式 </td>
	</tr>
	<tr>
		<td vAlign="middle" align="center" bgColor="#f1f3f5">
		<table height="99%" cellSpacing="1" cellPadding="0" width="100%"
			align="center" bgColor="#ebebeb" border="0">
			<tr>
				<td class="FormLabel" align="center" width="75%">
				栏目类型:
				<select name="nowColumnsType" id="nowColumnsType" onchange="javascript:document.forms[0].submit();">					
					<?php
					  	 echo "<option value='0' ";
						 if ($myPageClass->nowColumnsType == 0) {
						 	echo " selected='selected'";
						 }
						 echo ">所有栏目</option>\n";
						  
						 for($i=0;$i<count($myPageClass->columnsTypeList);$i++)
						  {
						     	if ($myPageClass->columnsTypeList[$i]["columns_type_id"] == $myPageClass->nowColumnsType){
						     		echo "<option value='".$myPageClass->columnsTypeList[$i]["columns_type_id"]."' selected='selected'>".$myPageClass->columnsTypeList[$i]["type_name"]."</option>\n";
						     	} else {
						     		echo "<option value='".$myPageClass->columnsTypeList[$i]["columns_type_id"]."'>".$myPageClass->columnsTypeList[$i]["type_name"]."</option>\n";     			  		
						     	}
						  } 
					?>
				</select>
				&nbsp;&nbsp;&nbsp;&nbsp;
				<?php
					echo "<input type='checkbox'  name='showAll' id='showAll'  value='ok' onchange='javascript:document.forms[0].submit();' ";
					if ($myPageClass->showAll == 1){
						echo " checked='checked' ";
					}
					echo "/>";     			  
				?>
				显示程序自动创建的子栏目
				</td>
			</tr>
			<tr>
				<td align="center" valign="top">
				<TABLE cellSpacing="1" cellPadding="1" width="100%"	bgColor="#ffffff" border="0">
					<tr>
						<td class="TableTdCaption" width="5%" align="center">ID</td>
						<td class="TableTdCaption" width="5%" align="center">句柄</td>
						<td class="TableTdCaption" width="50%" align="center">栏目名称</td>
						<td class="TableTdCaption" width="20%" align="center">栏目类型</td>
						<td class="TableTdCaption" width="10%" align="center">创建者</td>						
						<td class="TableTdCaption" width="15%" align="center">操作</td>
					</tr>
					<?php
					for ($i=0;$i<count($myPageClass->columnsList);$i++)
					{
						if ( ($i % 2) == 0){
							$tmpstr = "";
						} else {							
							$tmpstr = " style='background: #F0F0F0;' ";
						}						
						echo "<tr><td align='center' class='TableTd' $tmpstr>";
						echo $myPageClass->columnsList[$i]["columns_id"];
						echo "</td>\n<td class='TableTd' $tmpstr>";
						echo $myPageClass->columnsList[$i]["columns_handle"];
						echo "</td>\n<td class='TableTd' $tmpstr>";
						echo $myPageClass->columnsList[$i]["columns_name"];
						echo "</td>\n<td class='TableTd' $tmpstr>";
						echo $myPageClass->columnsList[$i]["type_name"];
						echo "</td>\n<td class='TableTd' $tmpstr>";
						if ($myPageClass->columnsList[$i]["create_type"] == 0)
						{
							echo "系统管理员";
						} else if ($myPageClass->columnsList[$i]["create_type"] == 1)
						{
							echo "用户";
						} else {
							echo "程序";
						}						
						echo "</td>\n<td class='TableTd' align='center' $tmpstr>";						
						echo "<a href='".$myPageClass->columnsList[$i]["manage_url"]."?id=".$myPageClass->columnsList[$i]["columns_id"]."'>修改</a> ";						
						echo "</td>\n</tr>";					
						
					}					   
					?>
					
				</TABLE>
				<div align="right">
				  <span class="blue12">
					共<?echo $myPageClass->page_num?>页
					第<?echo $myPageClass->to_page?>页
					<a href="#" onclick="toPage(<?echo $myPageClass->first_page?>)" class="blue12">首页</A>
					<a href="#" onclick="toPage(<?echo $myPageClass->up_page?>)"  class="blue12">上页</A>
					<a href="#" onclick="toPage(<?echo $myPageClass->next_page?>)"  class="blue12">下页</A>
					<a href="#" onclick="toPage(<?echo $myPageClass->last_page?>)"  class="blue12">末页</A>
				  </span>
				</div>
				</td>
			</tr>
		</table>
		</td>
	</tr>
</table>
<input type="hidden" name="to_page" id="to_page" value="<?=$myPageClass->to_page?>"/>
</form>
</body>
</HTML>
