<?
session_start();
include("../../util/commonFunctions.php");
canAcesssThisPage(24);

include_once("../../database/mysqlDAO.php");

if (isset($_REQUEST["id"])){
	$id = $_REQUEST["id"];
	//如果为0 或者不是一个纯数字，则表示是非法参数
	if ( ($id == 0) || (IsNumber($id) == 0)){
		header("location:".WEB_DIRECTORY_NAME."error.php?No=003");
		exit;
	}
}
if($_REQUEST["id"]){
	//$mail_id = $_REQUEST["id"];
	$findAllRec = "select * from mail where mail_id=".$id;
	$row = $mysqldao -> findOneRec($findAllRec);
}

if($_POST["op"]=="back"){
	$id = $_POST["id"];
	$back_content = $_POST["back_content"];
	$mail_open1 = $_POST["mail_open1"];
	$findAllRec = "UPDATE mail SET back_content='$back_content',mail_open1='$mail_open1', back_type=2,back_time=now() WHERE mail_id='$id'";
	$rst = $mysqldao -> updateRec($findAllRec);
		
	$returnInfo="已回复！";
	

	GoToPage("mail_list.php",$returnInfo);
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
	var me=document.mailForm;
	//if(IsEmpty(me.back_content,"回复不能为空！")) return false;
	
	
	if(Trim(me.back_content.value).length<1) {
		alert("回复不能为空！");
		me.back_content.focus();
		
		return false;
	}
	return confirm("您确定要提交吗？");
}
//-->
</script>
</HEAD>
<body >

<table width="98%" border="0" align="center" cellpadding="0" cellspacing="1" bgcolor="#ffffff" >
	<tr>
		<td align="center" bgcolor="#668cd9" class="FormCaption">网上诉求管理</td>
	</tr>
	<tr>
		<td bgcolor="#f1f3f5">


<TABLE cellSpacing="1" cellPadding="1" width="100%"	 border="0">
 
   <?
  
	switch ($row["mail_type"]){
		case 1: $mail_type = "建议";  break;
		case 2: $mail_type = "求助";  break;
		case 3: $mail_type = "投诉";  break;
		case 4: $mail_type = "批评";  break;
		case 5: $mail_type = "咨询";  break;
		case 6: $mail_type = "其他";  break;
		default:  $mail_type = "其他";
	}
	  
	switch ($row["mail_open"]){
		case 1: $mail_open = "公开";  break;
		case 2: $mail_open = "不公开";  break;
		default:  $mail_open = "不公开";
	}
	
   
   ?>
   <form name="mailForm" action="" method="post" onsubmit="return check();">
   	<tr class='TableTd' > 
    	<td width="14%"  height="22" align="center" ><strong>信件类型</strong></td> 
        <td width="35%"  height="22" align="left" >&nbsp;<?=$mail_type?></td> 
        <td width="14%"  height="22" align="center" ><strong>涉及领域</strong></td> 
        <td width="35%"  height="22" align="left" >&nbsp;<?=$row["mail_field"]?></td>
    </tr>   
    <tr class='TableTd' > 
    	<td  height="22" align="center" ><strong>公开意愿</strong></td>  
		<td  height="22" align="left" >&nbsp;<?=$mail_open?></td>
        <td  height="22" align="center" ><strong>是否公开</strong></td>  
        <td  height="22" align="left">
        <? 
		if($row["mail_open"]==1){
				$checked1="";
				$checked2="";
				if($row["mail_open1"]==1){
					$checked1="checked";					
				}else if($row["mail_open1"]==2){
					$checked2="checked";
				}
					
		?>
                <input type="radio" name="mail_open1" value="1" <?=$checked1?>>公开
                <input type="radio" name="mail_open1" value="2" <?=$checked2?>>不公开
        <? }else{?>
        	不公开<input type="hidden" name="mail_open1" value="2">
        <? }?>
        </td>	
    </tr>   
    <tr class='TableTd' > 
    	<td  height="22" align="center" ><strong>姓名</strong></td>  
		<td  height="22" align="left" >&nbsp;<?=$row["mail_name"]?></td>
    	<td  height="22" align="center" ><strong>性别</strong></td>  
        <td  height="22" align="left" >&nbsp;<?=$row["mail_sex"]?></td>
    </tr> 
    <tr class='TableTd' > 
        <td  height="22" align="center" ><strong>地址</strong></td>  
        <td  height="22" align="left" >&nbsp;<?=$row["mail_address"]?></td>
    	<td  height="22" align="center" ><strong>职业</strong></td>  
        <td  height="22" align="left" >&nbsp;<?=$row["mail_vocation"]?></td>
    </tr> 
    <tr class='TableTd'> 
        <td  height="22" align="center" ><strong>年龄</strong></td>  
        <td  height="22" align="left" >&nbsp;<?=$row["mail_age"]?></td>		

    	<td  height="22" align="center" ><strong>邮箱</strong></td>  
        <td  height="22" align="left" >&nbsp;<?=$row["mail_email"]?></td>
    </tr> 
    <tr class='TableTd' > 
        <td  height="22" align="center" ><strong>电话</strong></td>  
        <td  height="22" align="left" >&nbsp;<?=$row["mail_phone"]?></td>	
    	<td  height="22" align="center" ><strong>主题</strong></td>  
        <td  height="22" align="left">&nbsp;<?=$row["mail_title"]?></td>
    </tr> 
    <tr class='TableTd' > 
    	<td  height="22" align="center" ><strong>内容</strong></td>  
        <td  height="22" align="left" colspan="3"><textarea name="mail_content" rows="7" cols="70" readonly>&nbsp;<?=$row["mail_content"]?></textarea></td>	
    </tr> 
    <tr class='TableTd' > 
    	<td  height="22" align="center" ><strong>回复</strong></td>  
        <td  height="22" align="left" colspan="3"><textarea name="back_content" rows="7" cols="70" ><?=$row["back_content"]?></textarea></td>	
    </tr> 
    <tr class='TableTd' > 
    	<td  align="center" height="22"  colspan="4"><input type="submit" name="submit" value="提交"/>&nbsp;<input type="button" name="back" value="返回" onClick="window.history.back();"/></td>
    </tr>
<input type="hidden" name="id" value="<?=$_REQUEST["id"]?>"/>
<input type="hidden" name="op" value="back"/>
</form>   
   
   
   
  
</table>