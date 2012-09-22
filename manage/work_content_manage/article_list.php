<?
session_start();
header("Content-Type: text/html; charset=UTF-8");
include("../../util/commonFunctions.php");
canAcesssThisPage(23);

include_once("../../database/mysqlDAO.php");

//include_once("../../TmpWrite/function.php");
include_once ("../../util/columnsFunctions.php");

//读取要显示的列表
//if($sfindAllRecWhere){
	//$sfindAllRecWhere=" where ".substr($sfindAllRecWhere,0,strlen($sfindAllRecWhere)-4);
//} 
$sQueryWhere=" where 1=1";
$sQueryWhere.=" order by article_order desc, article_time desc ";
$sQuery="select work.* from work ";
//$rsArticle = $sql->findAllRec($sfindAllRec);

$sQueryCount="select count(article_id) from work ";
$sRsVarName="rsArticle";
include ("../../util/cut_page.php");
//取得要显示的文章列表))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))结束


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

<br/>
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="1" bgcolor="#ffffff" >
	<tr>
		<td align="center" bgcolor="#668cd9" class="FormCaption">网上办事内容管理</td>
	</tr>
	<tr>
		<td bgcolor="#f1f3f5">



	
		<TABLE cellSpacing="1" cellPadding="1" width="100%"	bgColor="#ffffff" border="0">	
		
		<tr width="100%" align="right" > 
        	<td align="left" class="FormLabel"><A HREF="article_tab.php?op=add" class="red12">添加</A></td>
			<td colspan="50" class="FormLabel">
				<?
				$cs="&".$sCutPage;
				$span_class="blue12";
				$link_class="blue12";
				include ("../../util/fenye_css.php");
				?>
			</td>
		</tr>

		<tr class="TableTdCaption" > 
			<td width="39%" align="center"><B>标题</B></td>
			<td width="18%" align="center"><B>所属栏目</B></td>
			<td width="18%" align="center"><B>上传时间</B></td>
			<td width="25%" align="center"><B>操作</B></td>
		</tr>



	<?

	for($i=0;$i<count($rsArticle);$i++){
		

		//是否是置顶
		$sTop="";
		if($rsArticle[$i]["article_order"]==1000){
			$sTop="<span class=\"red12\">[置顶]</span>";
		}
		
		//预览
		$sProviewLink="<A HREF=\"../article.php?article_id=".$rsArticle[$i]["article_id"]."\" target=\"_blank\" class=\"b12\">预览</A>&nbsp;";
				
		//修改
		$sModLink="<A HREF=\"article_tab.php?op=mod&id=".$rsArticle[$i]["article_id"]."\" class=\"b12\">修改</A>&nbsp;";
		


		//删除
		$sDeleteLink="<A href=\"javascript:PopConfirm('article_post.php?op=del&id=".$rsArticle[$i]["article_id"]."','您确定要删除 ".$rsArticle[$i]["article_title"]." 这篇文章吗？');\" class=\"b12\">删除</A>";
		
		
		
		//文章所属栏目		
		$sArticleItem = $mysqldao->findOneRec("select columns_name from work_columns where columns_id=".$rsArticle[$i]["columns_id"]);
		$sArticleItem = $sArticleItem[0];
		
		if ( ($i % 2) == 0){
			$tmpstr = "";
		} else {							
			$tmpstr = " style='background: #F0F0F0;' ";
		}
		


	?>
		<tr  width="100%" align="center"  class='TableTd' <?=$tmpstr?>> 
			<td><?=$sTop.$rsArticle[$i]["article_title"]?></td>
			<td><?=$sArticleItem?></td>
			<td><?=$rsArticle[$i]["article_time"]?></td>
			<td>
				<?=$sModLink.$sDeleteLink?>
			</td>
		</tr>

	<?
	}
	?>



		<tr width="100%" align="right" > 
			<td colspan="50" class="FormLabel">
				<?
				$cs="&".$sCutPage;
				$span_class="blue12";
				$link_class="blue12";
				include ("../../util/fenye_css.php");
				?>
			</td>
		</tr>

		</table>
	</td>
</tr>
</table>

