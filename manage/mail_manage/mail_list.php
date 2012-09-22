<?
session_start();
include("../../util/commonFunctions.php");
canAcesssThisPage(24);

include_once("../../database/mysqlDAO.php");
if($_REQUEST["op"]){
	$op = $_REQUEST["op"];
	$id = $_REQUEST["id"];
	if($op=="mod"){		
		$findAllRec = "UPDATE article_comments SET comments_state=1 WHERE comments_id='$id'";
		$rst = $mysqldao -> updateRec($findAllRec);
	}
	if($op=="del"){
		$findAllRec="DELETE FROM mail  WHERE  mail_id='$id'";
		$mysqldao->deleteRec($findAllRec);
	}
}


$findAllRec = "select * from mail  order by back_type, write_time desc";
$rst = $mysqldao -> findAllRec($findAllRec);

?>

<script src="../../js/function.js"></script>



<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" >
<HTML>
<HEAD>
<title>SysTools</title>
<LINK href="../manage.css" type="text/css" rel="stylesheet">
</HEAD>
<body >
<br/>
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="1" bgcolor="#ffffff" >
	<tr>
		<td align="center" bgcolor="#668cd9" class="FormCaption">网上诉求管理</td>
	</tr>
	<tr>
		<td bgcolor="#f1f3f5">


<TABLE cellSpacing="1" cellPadding="1" width="100%"	bgColor="#ffffff" border="0">
	<tr class="TableTdCaption"> 
        <td  height="22" align="center"><b>标题</b></td>
		<td  height="22" align="center"><b>发信人姓名</b></td>
        <td  height="22" align="center"><b>发信人电话</b></td>
        <td  height="22" align="center"><b>发信人地址</b></td>
        <td  height="22" align="center"><b>信件类型</b></td>
        <td  height="22" align="center"><b>涉及领域</b></td>
        <td  height="22" align="center"><b>写信时间</b></td>
        <td  height="22" align="center"><b>状态</b></td>
		<td  align="center" height="22"><b>操作</b></td>
    </tr> 
   <?
   for($i=0;$i<count($rst);$i++){
	   	//$checkArticle="<A HREF=\"../../template/sys/1/article.php?id=".$rst[$i]["comments_id"]."\" class=\"b12\" target=\"_blank\">原文章</A>"."&nbsp";
		//$content="<A HREF=\"comments_content.php?id=".$rst[$i]["comments_id"]."\" class=\"b12\" >评论类容</A>"."&nbsp";
   		//$modLink="<A HREF=\"javascript:PopConfirm('comments_list.php?op=mod&id=".$rst[$i]["comments_id"]."&state=".$rst[$i]["comments_state"]."','您确定要更改 ".$rst[$i]["comments_title"]." 的状态吗？');\" class=\"b12\">通过</A>"."&nbsp";
   		
		$viewLink="<A HREF=\"mail_view.php?id=".$rst[$i]["mail_id"]."\" class=\"b12\">查看</A>"."&nbsp";
		$backLink="<A HREF=\"mail_content.php?id=".$rst[$i]["mail_id"]."\" class=\"b12\">回复</A>"."&nbsp";
		$deleteLink="<A HREF=\"javascript:PopConfirm('mail_list.php?op=del&id=".$rst[$i]["mail_id"]."','您确定要删除 ".$rst[$i]["mail_title"]." 吗？');\" class=\"b12\">删除</A>";
		
		


	switch ($rst[$i]["mail_type"]){
		case 1: $mail_type = "建议";  break;
		case 2: $mail_type = "求助";  break;
		case 3: $mail_type = "投诉";  break;
		case 4: $mail_type = "批评";  break;
		case 5: $mail_type = "咨询";  break;
		case 6: $mail_type = "其他";  break;
		default:  $mail_type = "其他";
	}

	if ( ($i % 2) == 0){
		$tmpstr = "";
	} else {							
		$tmpstr = " style='background: #F0F0F0;' ";
	}	
   
   $backType="未回复";
   if($rst[$i]["back_type"]=="2"){
	  $backType="已回复";
   }
   ?>
   	<tr class='TableTd' <?=$tmpstr?>> 
    	<td  height="22" align="center" >&nbsp;<?=$rst[$i]["mail_title"]?></td> 
		<td  height="22" align="center" >&nbsp;<?=$rst[$i]["mail_name"]?></td>
        <td  height="22" align="center" >&nbsp;<?=$rst[$i]["mail_phone"]?></td>
		<td  height="22" align="center" >&nbsp;<?=$rst[$i]["mail_address"]?></td>
        <td  height="22" align="center" >&nbsp;<?=$mail_type?></td>
        <td  height="22" align="center" >&nbsp;<?=$rst[$i]["mail_field"]?></td>
        <td  height="22" align="center" >&nbsp;<?=$rst[$i]["write_time"]?></td>
        <td  height="22" align="center" >&nbsp;<?=$backType?></td>
		<td  align="center" height="22" >&nbsp;<?=$viewLink.$backLink.$deleteLink?></td>
    </tr>
   <? }?>
   
   
   
   
  
</table>