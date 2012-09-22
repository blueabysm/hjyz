<?
session_start();
include("../../util/commonFunctions.php");
canAcesssThisPage(5,0,"../login.php");

include_once("../../database/mysqlDAO.php");

$op = $_REQUEST["op"];

if($op=="mod"){	
	$findAllRec = "select * from work_columns where columns_id=".$_REQUEST["id"];
	$itItem = $mysqldao -> findOneRec($findAllRec);
}

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" >
<HTML>
<HEAD>
<title>SysTools</title>
<LINK href="../manage.css" type="text/css" rel="stylesheet">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<script src="../../js/function.js"></script>
<script>
<!--
function check(){
	var me=document.itemForm;
	
	if(IsEmpty(me.columns_name,"请填写对象名称！")) return false;
	if(IsEmpty(me.columns_handle,"请填写句柄！")) return false;
	
	return confirm("您确定要提交吗？");
}
//-->
</script>
</HEAD>
<body >

<table width="98%" border="0" align="center" cellpadding="0" cellspacing="1" bgColor="#ebebeb" class="FormLabel" id="FormTable">
	<tr>
		<td align="center" bgcolor="#668cd9" class="FormCaption">网上办事栏目管理</td>
	</tr>
	<tr>
		<td bgcolor="#f1f3f5">
        <FORM action="base_post.php" name="itemForm" method="post" onsubmit="return check();">
		<table width="99%" cellSpacing="1" cellPadding="1" border="0" bgColor="#ffffff" >

	<tr width="99%" class='TableTd'> 
		<td width="38%"  height="22" align="center" ><b>对象名称</b> </td>
        <td ><input type="text" name="columns_name" value="<?=$itItem["columns_name"]?>"/></td>
    </tr> 
    <tr width="99%" class='TableTd'> 
		<td width="38%"  height="22" align="center" ><b>句柄</b> </td>
        <td ><input type="text" name="columns_handle" value="<?=$itItem["columns_handle"]?>"/></td>
    </tr>

</table>
<table width="99%"   >
	<tr>  
		<td width="49%"  height="22" align="center" >
        	<input type="submit" name="submit" value="提交" /> &nbsp;<input type="button" name="back" value="返回" onClick="window.history.back();"/>
        </td>
    </tr> 
     <tr>  
		<td width="49%"  height="22" align="center" >
        <input type="hidden" name="op" value="<?=$op?>" /> 
        <input type="hidden" name="id" value="<?=$itItem["columns_id"]?>" /> 
        <input type="hidden" name="pid" value="<?=$_REQUEST["pid"]?>" /> 
        </td>
    </tr> 
   
</table></FORM> 
		</td>
	</tr>
</table>