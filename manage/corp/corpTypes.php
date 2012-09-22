<?php
session_start();

include_once("../../util/commonFunctions.php");
canAcesssThisPage(47); 

include_once("../../database/mysqlDAO.php");
include("corpTypesClass.inc.php");

$myPageClass = new corpTypesClass($mysqldao);
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
<title>单位类型设置</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<LINK href="../manage.css" type="text/css" rel="stylesheet">
<script src="../../js/ajax.js"></script>
<script src="ajax_method/typesFunction.js"></script>
</HEAD>
<body >

<div id='bottomDiv' class="OpacityDiv" style='position:absolute;background-color: black;height:100%;width:100%;display: none'></div>
<div id='formDiv' style='position:absolute;top:5px;left:5px;padding:10px;background-color:white;border:solid 1px black;height:50px;width:400px;display: none'>
  类型名称：<input type="text" id='t_name' name='t_name' maxlength='50' size='30'/>&nbsp;<button onclick='save()'>保存</button>&nbsp;<button onclick="changeDiv()">取消</button>
</div>
<br>
<table id="FormTable" cellSpacing="1" cellPadding="0" width="98%"
	align="center" bgColor="#ffffff" border="0">
	<tr>
		<td class="FormCaption" align="center" bgColor="#668cd9">单位类型设置</td>
	</tr>
	<tr>
		<td vAlign="middle" align="center" bgColor="#f1f3f5">
		<table height="99%" cellSpacing="1" cellPadding="0" width="100%"
			align="center" bgColor="#ebebeb" border="0">
			<tr>
				<td class="FormLabel" align="left" width="75%">
				 <button id="btnAdd" onclick="add()">添加新类型</button>
				</td>
			</tr>			
			<tr>
				<td align="center" valign="top">
				<TABLE cellSpacing="1" cellPadding="1" width="100%"	bgColor="#ffffff" border="0">
					<tr>
						<td class="TableTdCaption" width="10%" align="center">id</td>
						<td class="TableTdCaption" width="60%" align="center">名称</td>
						<td class="TableTdCaption" width="30%" align="center">操作</td>
					</tr>
					<?php
					for ($i=0;$i<count($myPageClass->typeList);$i++)
					{
						if ( ($i % 2) == 0){
							$tmpstr = "";
						} else {							
							$tmpstr = " style='background: #F0F0F0;' ";
						}						
						echo "<tr>\n<td class='TableTd' align='center' $tmpstr>";
						echo $myPageClass->typeList[$i]["t_id"];
						echo "</td>\n<td class='TableTd' $tmpstr>";
						echo $myPageClass->typeList[$i]["t_name"];																																							
						echo "</td>\n<td class='TableTd' align='center' $tmpstr>";
						echo "<a href='#' onclick='edit(\"".$myPageClass->typeList[$i]['t_name']."\",".$myPageClass->typeList[$i]['t_id'].")'>修改</a> ";
						echo "<a href='#' onclick='del(".$myPageClass->typeList[$i]['t_id'].")'>删除</a> ";
						echo "</td>\n</tr>";						
					}					   
					?>					
				</TABLE>
				</td>
			</tr>
		</table>
		</td>
	</tr>
</table>
</body>
</HTML>