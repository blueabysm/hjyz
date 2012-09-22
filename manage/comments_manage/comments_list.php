<?
session_start();
include("../../util/commonFunctions.php");
canAcesssThisPage(17);

include_once("../../database/mysqlDAO.php");

if (isset($_REQUEST["id"])){
	$id = $_REQUEST["id"];
	//如果为0 或者不是一个纯数字，则表示是非法参数
	if ( ($id == 0) || (IsNumber($id) == 0)){
		header("location:".WEB_DIRECTORY_NAME."error.php?No=003");
		exit;
	}
}

if($_REQUEST["op"]){
	$op = $_REQUEST["op"];	
	if($op=="mod"){		
		$findAllRec = "UPDATE article_comments SET comments_state=1 WHERE comments_id='$id'";
		$rst = $mysqldao -> updateRec($findAllRec);
	}
	if($op=="del"){
		$findAllRec="DELETE FROM article_comments  WHERE  comments_id='$id'";
		$mysqldao->deleteRec($findAllRec);
	}
}


$findAllRec = "select * from article_comments where comments_state=2 and item_id in(select columns_id from columns where admin_id='".$_SESSION["sess_user_id"]."') order by  comments_time desc";
$rst = $mysqldao -> findAllRec($findAllRec);
?>

<script src="../../js/function.js"></script>



<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" >
<HTML>
<HEAD>
<title>SysTools</title>
<LINK href="../manage.css" type="text/css" rel="stylesheet">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
</HEAD>
<body >
<br/>
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="1" bgcolor="#ffffff" >
	<tr>
		<td align="center" bgcolor="#668cd9" class="FormCaption">文章评论管理</td>
	</tr>
	<tr>
		<td bgcolor="#f1f3f5">


<TABLE cellSpacing="1" cellPadding="1" width="100%"	bgColor="#ffffff" border="0">
	<tr class="TableTdCaption"> 
        <td width="20%"  height="22" align="center"><b>评论人姓名</b></td>
		<td width="41%"  height="22" align="center"><b>评论标题</b></td>
        <td width="16%"  height="22" align="center"><b>评论时间</b></td>
		<td width="23%" height="22"  align="center"><b>操作</b></td>
    </tr> 
   <?
   for($i=0;$i<count($rst);$i++){
   	    if ($_SESSION['sess_user_sub_id'] == 0)
   	    {
	   		$checkArticle="<A HREF=\"../../template/sys/1/article.php?id=".$rst[$i]["comments_id"]."\" class=\"b12\" target=\"_blank\">原文章</A>"."&nbsp";
   	    }
   	    else
   	    {
   	    	$checkArticle="<A HREF=\"../../template/sub/1/article.php?s=".$_SESSION['sess_user_sub_id']."&id=".$rst[$i]["comments_id"]."\" class=\"b12\" target=\"_blank\">原文章</A>"."&nbsp";
   	    }
		$content="<A HREF=\"comments_content.php?id=".$rst[$i]["comments_id"]."\" class=\"b12\" >评论内容</A>"."&nbsp";
   		$modLink="<A HREF=\"javascript:PopConfirm('comments_list.php?op=mod&id=".$rst[$i]["comments_id"]."&state=".$rst[$i]["comments_state"]."','您确定要通过 ".urlencode($rst[$i]["comments_title"])." 的审批吗？\\n该操作会将评论显示在网站上！');\" class=\"b12\">通过</A>"."&nbsp";
   		$deleteLink="<A HREF=\"javascript:PopConfirm('comments_list.php?op=del&id=".$rst[$i]["comments_id"]."','您确定要删除 ".urlencode($rst[$i]["comments_title"])." 吗？');\" class=\"b12\">删除</A>";
		
	if ( ($i % 2) == 0){
		$tmpstr = "";
	} else {							
		$tmpstr = " style='background: #F0F0F0;' ";
	}	
   
   ?>
   	<tr class='TableTd' <?=$tmpstr?>> 
    	<td  height="22" align="center" >&nbsp;<?=$rst[$i]["comments_guest_name"]?></td> 
		<td  height="22" align="center" >&nbsp;<?=$rst[$i]["comments_title"]?></td>
        <td  height="22" align="center" >&nbsp;<?=$rst[$i]["comments_time"]?></td>
		<!--<td  height="22" align="center" >&nbsp;<A HREF="../../template/sys/1/comments.php?id=<?=$rst[$i]["comments_id"]?>" class="blue12" target="_blank"><?=$rst[$i]["comments_title"]?></A></td> -->
		<td  align="center" height="22" >&nbsp;<?=$checkArticle.$content.$modLink.$deleteLink?></td>
    </tr>
   <? }?>
   
   
   
   
  
</table>