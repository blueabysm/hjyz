<?
session_start();
include("../../util/commonFunctions.php");
canAcesssThisPage(17);

include_once("../../database/mysqlDAO.php");

if($_REQUEST["id"]){
	$comments_id = $_REQUEST["id"];
	$findAllRec = "select * from article_comments where comments_id=".$comments_id;
	$row = $mysqldao -> findOneRec($findAllRec);
}

if($_REQUEST["op"]){
	$op = $_REQUEST["op"];
	$id = $_REQUEST["id"];
	if($op=="mod"){		
		$findAllRec = "UPDATE article_comments SET comments_state=1 WHERE comments_id='$id'";
		$rst = $mysqldao -> updateRec($findAllRec);
		
		$returnInfo="已通过！";
	}
	if($op=="del"){
		$findAllRec="DELETE FROM article_comments  WHERE  comments_id='$id'";
		$mysqldao->deleteRec($findAllRec);
		
		$returnInfo="已删除！";
	}
	GoToPage("comments_list.php",$returnInfo);
}




?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" >
<HTML>
<HEAD>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>SysTools</title>
<LINK href="../manage.css" type="text/css" rel="stylesheet">
<script src="../../js/function.js"></script>
</HEAD>
<body >

<table width="98%" border="0" align="center" cellpadding="0" cellspacing="1" bgcolor="#ffffff" >
	<tr>
		<td align="center" bgcolor="#668cd9" class="FormCaption">文章评论管理</td>
	</tr>
	<tr>
		<td bgcolor="#f1f3f5">


<TABLE cellSpacing="1" cellPadding="1" width="100%"	 border="0">
 
   <?
  
	   
   		$modLink="<A HREF=\"javascript:PopConfirm('comments_list.php?op=mod&id=".$row["comments_id"]."','您确定要通过 ".$row["comments_title"]." 的审批吗？\\n该操作会将评论显示在网站上！');\" class=\"b12\">通过</A>"."&nbsp";
   		$deleteLink="<A HREF=\"javascript:PopConfirm('comments_list.php?op=del&id=".$row["comments_id"]."','您确定要删除 ".$row["comments_title"]." 吗？');\" class=\"b12\">删除</A>"."&nbsp";
		$backLink="<A HREF=\"#\" onClick=\"window.history.back();\">返回</A>";

	
   
   ?>
   	<tr class='TableTd' > 
    	<td width="35%"  height="22" align="center" ><strong>评论标题</strong></td> 
        <td width="65%"  height="22" align="left" >&nbsp;<?=$row["comments_title"]?></td> 
    </tr>   
    <tr class='TableTd' > 
    	<td  height="22" align="center" ><strong>评论人姓名</strong></td>  
		<td  height="22" align="left" >&nbsp;<?=$row["comments_guest_name"]?></td>
    </tr>   
    <tr class='TableTd' > 
    	<td  height="22" align="center" ><strong>评论时间</strong></td>  
        <td  height="22" align="left" >&nbsp;<?=$row["comments_time"]?></td>	
    </tr> 
    <tr class='TableTd' > 
    	<td  height="22" align="center" ><strong>评论人IP</strong></td>  
        <td  height="22" align="left" >&nbsp;<?=$row["comments_guest_ip"]?></td>	
    </tr> 
    <tr class='TableTd' > 
    	<td  height="22" align="center" ><strong>评论类容</strong></td>  
        <td  height="22" align="left" ><textarea name="comments_content" rows="4" cols="50" readonly>&nbsp;<?=$row["comments_content"]?></textarea></td>	
    </tr> 
    <tr class='TableTd' > 
    	<td  align="center" height="22"  colspan="2">&nbsp;<?=$modLink.$deleteLink.$backLink?></td>
    </tr>

   
   
   
   
  
</table>