<?
session_start();
include("../../util/commonFunctions.php");
canAcesssThisPage(5,0,"../login.php");

include_once("../../database/mysqlDAO.php");

?>

<script src="../../js/function.js"></script>
<script>>
<!--
	function JumpMe(id){
		document.location.href="<?=$_SERVER["PHP_SELF"]?>?pid="+id;
	}
//-->
</script>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" >
<HTML>
<HEAD>
<LINK href="../manage.css" type="text/css" rel="stylesheet">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
</HEAD>
<body >

<br/>

<?
$findAllRec = "select * from work_columns";

if($_REQUEST["pid"]==""){
	$pid = "0";
}else{
	$pid = $_REQUEST["pid"];
}

if($pid != "0"){
	$back = "&nbsp;<a href=\"javascript:JumpMe('0')\">返回</a>";
}

$findAllRec = "select * from work_columns where columns_pid=$pid";
//echo $findAllRec;
$rsItem = $mysqldao -> findAllRec($findAllRec);

?>
<table cellSpacing="1" cellPadding="0" width="99%" align="center" bgColor="#ebebeb" border="0"  class="FormLabel">
	<tr>
		<td align="center" bgcolor="#668cd9" class="FormCaption">网上办事基本设置管理</td>
	</tr>
	<tr>
		<td bgcolor="#f1f3f5">
<table cellSpacing="1" cellPadding="0" width="99%" align="center" bgColor="#ebebeb" border="0"  class="FormLabel">    
	<tr align="center"> 
        <td   align="left"></td>
        <td   align="right"><a href="base_mod.php?op=add&pid=<?=$pid?>">添加</a><?=$back?></td>
    </tr>
</table>

<TABLE cellSpacing="1" cellPadding="1" width="100%"	bgColor="#ffffff" border="0">	
	<tr class="TableTdCaption"> 
		<td  height="22" align="center" ><b> ID</b> </td>
		<td  height="22" align="center" ><b>对象名称</b></td>
        <td  height="22" align="center" ><b>句柄</b></td>
		<td  align="center" height="22" ><b>操作</b></td>
    </tr> 
   <?
   for($i=0;$i<count($rsItem);$i++){
   		$modLink="<A HREF=\"base_mod.php?op=mod&id=".$rsItem[$i]["columns_id"]."&pid=".$pid."\" class=\"b12\">修改</A>&nbsp;";
   		$deleteLink="<A HREF=\"javascript:PopConfirm('base_post.php?op=del&id=".$rsItem[$i]["columns_id"]."&pid=".$pid."','您确定要删除 ".$rsItem[$i]["columns_name"]." 吗？');\" class=\"b12\">删除</A>";
   
   if ( ($i % 2) == 0){
		$tmpstr = "";
	} else {							
		$tmpstr = " style='background: #F0F0F0;' ";
	}
   ?>
   	<tr  class='TableTd' <?=$tmpstr?>> 
		<td  height="22" align="center" >&nbsp;<?=$rsItem[$i]["columns_id"]?></td>
		<td  height="22" align="center" >&nbsp;<A HREF="javascript:JumpMe(<?=$rsItem[$i]["columns_id"]?>)" class="SubMenuText"><?=$rsItem[$i]["columns_name"]?></A></td> 
        <td  height="22" align="center" >&nbsp;<?=$rsItem[$i]["columns_handle"]?></td>
		<td  align="center" height="22" >&nbsp;<?=$modLink.$deleteLink?></td>
    </tr>
   <? }?>
   
   
   
   
  
</table>