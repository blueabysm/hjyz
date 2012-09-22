<?php
session_start();
include_once("../../util/commonFunctions.php");
canAcesssThisPage(10); 

include_once("../../database/mysqlDAO.php");
include("addPartSetPurviewClass.inc.php");

$myPageClass = new addPartSetPurviewClass($_POST,$_GET,$mysqldao);
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
		<title>增加单位机构设置管理权</title>		
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<LINK href="../manage.css" type="text/css" rel="stylesheet">
		<script src="../tree/TreeView.js"></script>
		<style>
		a, A:link, a:visited, a:active, A:hover
		{color: #000000; text-decoration: none; font-family: Tahoma, Verdana; font-size: 12px}
		</style>
		<script>
		  function checkData()
		  {
			  var tmpobj = document.getElementsByName('selPurList[]');
			  selc=0;
			  for(i=0;i<tmpobj.length;i++)
			  {
				  if (tmpobj[i].checked) selc++;
			  }
			  if (selc <= 0)
			  {
				  alert('至少要选择一个权限');
				  return false;
			  }
			  tmpobj = document.getElementsByName('selObjList[]');
			  selc=0;
			  for(i=0;i<tmpobj.length;i++)
			  {
				  if (tmpobj[i].checked) selc++;
			  }
			  if (selc <= 0)
			  {
				  alert('至少要选择一个单位');
				  return false;
			  }
			  return true;
		  }
		</script>		
	</HEAD>
	<body >
	<br>
		<form id="addColumns" name="addColumns" method="post" onsubmit="return checkData()">
			<table id="FormTable" cellSpacing="1" cellPadding="0" width="98%" align="center" bgColor="#ffffff"
				border="0">
				<tr>
					<td class="FormCaption" align="center" bgColor="#668cd9">增加单位机构设置管理权</td>
				</tr>
				<tr>
					<td vAlign="middle" align="center" bgColor="#f1f3f5">
						<table cellSpacing="1" cellPadding="0" width="99%" align="center" bgColor="#ebebeb"
							border="0">
							<TR>
								<TD class="FormLabel" align="center" colspan="2">
								 <a href='editObjPartSetPurview.php?id=<?=$myPageClass->id?>&uid=<?=$myPageClass->uid?>&page=<?=$myPageClass->page?>'>返回</a>								
								</TD>
							</TR>
							<tr>
								<TD class="FormLabel" align="right" width="20%">权限名称:</TD>
								<TD class="FormLabel"><?=$myPageClass->menu_name?></TD>
							</tr>							
							<TR>
								<TD class="FormLabel" align="right">权限:</TD>
								<TD class="FormLabel">
								<?php		  
								  	for($i=0;$i<count($myPageClass->purList);$i++)
							     	 {				     			  		
				     			  		echo '<input type="checkbox" name="selPurList[]" id="selPurList_'.$myPageClass->purList[$i]["p_id"].'" value="'.$myPageClass->purList[$i]["p_id"] . '"/>';
				     			  		echo $myPageClass->purList[$i]["p_name"];
				     			  		echo '<br>';					     			  		
					     			 }					     			  						     			  						     			 
					     		 ?>
								<font color="red">*</font>
								</TD>
								
							</TR>							
							<tr>
								<TD class="FormLabel" align="right" width="20%" valign="top">选择单位:</TD>
								<TD class="FormLabel">
								<?php										  
								  	for($i=0;$i<count($myPageClass->objList);$i++)
							     	 {
				     			  		echo '<input type="checkbox" name="selObjList[]" id="obj_'.$myPageClass->objList[$i]["c_id"].'" value="'.$myPageClass->objList[$i]["c_id"] . '"/>';				     			  		
				     			  		echo $myPageClass->objList[$i]["short_name"];
				     			  		echo '<br>';					     			  		
					     			 }					     			  						     			  						     			 
					     		  ?>	
								<font color="red">*</font>
								</TD>
							</tr>		
							<tr>
								<td class="FormLabel" colSpan="2">
									<input type="submit" name="btnAdd" id="btnAdd" value="添加"/>									
									<input type="hidden" name="id" id="id" value="<?=$myPageClass->id?>"/>
									<input type="hidden" name="uid" id="uid" value="<?=$myPageClass->uid?>"/>
									<input type="hidden" name="page" id="page" value="<?=$myPageClass->page?>"/>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</form>
	</body>
</HTML>
