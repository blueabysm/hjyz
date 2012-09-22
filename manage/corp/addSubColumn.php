<?php
session_start();
include_once("../../util/commonFunctions.php");
canAcesssThisPage(20); 

include_once("../../database/mysqlDAO.php");
include("addSubColumnClass.inc.php");

$myPageClass = new addSubColumnClass($_POST,$_GET,$mysqldao);
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
		<title>添加栏目</title>		
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<LINK href="../manage.css" type="text/css" rel="stylesheet">
		<script>
		  function checkData()
		  {
			  var tmpobj = document.getElementsByName('column_id[]');
			  selc=0;
			  for(i=0;i<tmpobj.length;i++)
			  {
				  if (tmpobj[i].checked) selc++;
			  }
			  if (selc <= 0)
			  {
				  alert('至少要选择一个栏目');
				  return false;
			  }
			  return true;
		  }
		</script>			
	</HEAD>
	<body >
	<br>
		<form id="addPart" name="addPart" method="post"  onsubmit="return checkData()">
			<table id="FormTable" cellSpacing="1" cellPadding="0" width="98%" align="center" bgColor="#ffffff"
				border="0">
				<tr>
					<td class="FormCaption" align="center" bgColor="#668cd9">添加栏目</td>
				</tr>
				<tr>
					<td vAlign="middle" align="center" bgColor="#f1f3f5">
						<table cellSpacing="1" cellPadding="0" width="99%" align="center" bgColor="#ebebeb"
							border="0">
							<TR>
								<TD class="FormLabel" align="center" colspan="2">
								<a href='manageSubColumns.php?s_type=<?=$myPageClass->s_type?>&corp_id=<?=$myPageClass->corp_id?>&id=<?=$myPageClass->objID?>'>返回</a>								
								</TD>
							</TR>
							<tr>
								<td class="FormLabel" align="right">选择栏目:</td>
								<td class="FormLabel">
								<?php										  
								  	for($i=0;$i<count($myPageClass->colList);$i++)
							     	 {
				     			  		echo '<input type="checkbox" name="column_id[]" id="obj_'.$myPageClass->colList[$i]["columns_id"].'" value="'.$myPageClass->colList[$i]["columns_id"] . '"/>';				     			  		
				     			  		echo $myPageClass->colList[$i]["columns_name"];
				     			  		echo '<br>';					     			  		
					     			 }					     			  						     			  						     			 
					     		  ?>
					     		<font color="red">*</font>									
								</td>
							</tr>																	
							<TR>
								<TD class="FormLabel" align="right">序号:</TD>
								<TD class="FormLabel">
								<input type="text" maxlength="4" name="sub_order" id="sub_order" style="width: 300px;" value="<?=$myPageClass->sub_order?>"/>
								显示顺序，值越小顺序越靠前
								</TD>
							</TR>							
							<tr>
								<td class="FormLabel" colSpan="2">
									<input type="submit" name="btnAdd" id="btnAdd" value="添加"/>									
									<input type="hidden" name="corp_id" id="corp_id" value="<?=$myPageClass->corp_id?>"/>																		
									<input type="hidden" name="s_type" id="s_type" value="<?=$myPageClass->s_type?>"/>
									<input type="hidden" name="objID" id="objID" value="<?=$myPageClass->objID?>"/>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</form>
	</body>
</HTML>
