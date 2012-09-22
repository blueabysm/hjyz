<?php
session_start();
include_once("../../util/commonFunctions.php");
canAcesssThisPage(13); 

include_once("../../database/mysqlDAO.php");
include("addColumnsClass.inc.php");

$myPageClass = new addColumnsClass($_POST,$_GET,$mysqldao,MAX_COLUMNS_DEPTH);
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
		<script src="../tree/TreeView.js"></script>
		<style>
		a, A:link, a:visited, a:active, A:hover
		{color: #000000; text-decoration: none; font-family: Tahoma, Verdana; font-size: 12px}
		</style>
		<script>
		  function checkData()
		  {
			  var tmpobj = document.getElementById('columns_name');
			  if (tmpobj.value == "")
			  {
				  alert('栏目名称不能为空');
				  return false;
			  }
			  tmpobj = document.getElementById('columns_title');
			  if (tmpobj.value == "")
			  {
				  alert('栏目标题不能为空');
				  return false;
			  }
			  
			  if (selColumns.length == 0) return true;
			  var tmpstr = "";									   
			  for(i=0;i<selColumns.length;i++)
			  {
				   tmpstr += selColumns[i].code + ',';
			  }
			  tmpobj = document.getElementById('sub_id');
			  tmpobj.value = tmpstr.substring(0,tmpstr.length-1);
			  if (tmpobj.value.length > 1000)
			  {
				  alert('父栏目太多');
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
					<td class="FormCaption" align="center" bgColor="#668cd9">添加栏目</td>
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
								<TD class="FormLabel" align="right" width="20%">栏目类型:</TD>
								<TD class="FormLabel">
								<select name="nowColumnsType" id="nowColumnsType">
									<?php									  	
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
								</TD>
							</tr>							
							<TR>
								<TD class="FormLabel" align="right">栏目名称:</TD>
								<TD class="FormLabel">
								<input type="text" maxlength="100" name="columns_name" id="columns_name" style="width: 200px;" value="<?=$myPageClass->columns_name?>"/>
								<font color="red">*</font>
								</TD>
								
							</TR>
							<tr>
								<td class="FormLabel" align="right">栏目标题:</td>
								<td class="FormLabel">
								<input type="text" maxlength="50" name="columns_title" id="columns_title" style="width: 300px;" value="<?=$myPageClass->columns_title?>"/>
								 页面显示用
								 <font color="red">*</font>
								</td>
							</tr>							
							<tr>
								<TD class="FormLabel" align="right" width="20%" valign="top">父栏目:</TD>
								<TD class="FormLabel">
								<TABLE cellSpacing="1" cellPadding="1" width="400" bgColor="#000000" border="0">
									<tr>
										<td class="TableTdCaption" width="60%" align="center">所有栏目</td>
										<td class="TableTdCaption" width="40%" align="center"><div id="divNum">已选栏目(0)</div></td>
									</tr>
									<tr>
										<td class="TableTd" align="left" style="background-color: white;">
										<script>
								   var TREE_ITEMS = <?=$myPageClass->treeItemStr?>;
								   var cTree = getNewTree(TREE_ITEMS);
								   var selColumns = new Array();
								   
								   function addCol(name,id)
								   {
									   var i=0;
									   for(i=0;i<selColumns.length;i++)
									   {   
										   if (selColumns[i].code == id)
										   {
											   alert('该栏目已添加!');
											   return ;
										   }
									   }
									   var tmpobj = new Object();
									   tmpobj.name = name;
									   tmpobj.code = id;									   
									   selColumns[selColumns.length] = tmpobj;
									   updateDiv();
								   }
								   function delCol(id)
								   {									   
									   if (selColumns.length == 0) return;
									   var i=0,j=0;
									   var tmpList = new Array();
									   for(i=0;i<selColumns.length;i++)
									   {
										   if (selColumns[i].code == id) continue;
										   tmpList[j] = selColumns[i];
										   j++;										   
									   }
									   selColumns = tmpList;
									   updateDiv(); 
								   }
								   function updateDiv()
								   {
									   var tmpstr = "";
									   var div = document.getElementById("divNum");
									   div.innerHTML = "已选栏目(0)";
									   div = document.getElementById("selColDiv");
									   div.innerHTML = tmpstr;
									   if (selColumns.length == 0) return;
									   
									   for(i=0;i<selColumns.length;i++)
									   {
										   tmpstr += " <b>" + selColumns[i].name + "</b> <a style='color:red' href='javascript:delCol(" + selColumns[i].code + ")' title='移除'>X</a><br>";
									   }
									   div.innerHTML = tmpstr;
									   div = document.getElementById("divNum");
									   div.innerHTML = "已选栏目("+selColumns.length+')';
								   }								   
								</script>
										</td>
										<td class="TableTd" align="left" style="background-color: white;" valign="top">
										<div align="left" id="selColDiv">
										</div>
										</td>
									</tr>											
								 </TABLE>
								</TD>
							</tr>		
							<tr>
								<td class="FormLabel" colSpan="2">
									<input type="submit" name="btnAdd" id="btnAdd" value="添加"/>									
									<input type="hidden" name="retURL" id="retURL" value="<?=$myPageClass->retURL?>"/>
									<input type="hidden" name="sub_id" id="sub_id" value=""/>
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
