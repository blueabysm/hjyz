<?
session_start();
include("../../util/commonFunctions.php");
canAcesssThisPage(25);




include_once("../../database/mysqlDAO.php");

$sQueryWhere.=" order by subject_time desc ";
$sQuery="select * from opinion_subject ";
//$rsArticle = $sql->findAllRec($sfindAllRec);

$sQueryCount="select count(subject_id) from opinion_subject ";
$sRsVarName="rst";
include ("../../util/cut_page.php");
//取得要显示的文章列表))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))结束


?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" >
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<HTML>
<HEAD>
<title>SysTools</title>
<LINK href="../manage.css" type="text/css" rel="stylesheet">
<script src="../../js/function.js"></script>
</HEAD>
<body >

<br/>

<table cellSpacing="1" cellPadding="0" width="99%" align="center" bgColor="#ebebeb" border="0"  class="FormLabel">
	
    <table width="98%" border="0" align="center" cellpadding="0" cellspacing="1" bgcolor="#ffffff" id="FormTable">
	<tr>
		<td align="center" bgcolor="#668cd9" class="FormCaption">民意征集题目管理</td>
	</tr>
	<tr>
		<td bgcolor="#f1f3f5">
<table cellSpacing="1" cellPadding="0" width="99%" align="center" bgColor="#ebebeb" border="0"  class="FormLabel">

    <tr align="center" > 
        <td   align="left"><A HREF="opinion_subject_tab.php?op=add" class="red12">添加</A></td>
        <td   align="right"><?
				$cs="&".$sCutPage;
				$span_class="blue12";
				$link_class="blue12";
				include ("../../util/fenye_css.php");
				?> </td>
    </tr>
</table>

<TABLE cellSpacing="1" cellPadding="1" width="100%"	bgColor="#ffffff" border="0">	


		<tr  width="100%" align="center" class="TableTdCaption"> 
			<td width="39%"><B>标题</B></td>
			<td width="18%"><B>征集时间</B></td>
			<td width="25%"><B>操作</B></td>
		</tr>



	<?

	for($i=0;$i<count($rst);$i++){
		

		//是否是置顶
		$sTop="";
		if($rsArticle[$i]["article_order"]==1000){
			$sTop="<span class=\"red12\">[置顶]</span>";
		}
		
		
				
		//修改
		$sModLink="<A HREF=\"opinion_subject_tab.php?op=mod&id=".$rst[$i]["subject_id"]."\" class=\"b12\">查看修改</A>&nbsp;";
		

		

		//删除
		$sDeleteLink="<A href=\"javascript:PopConfirm('opinion_subject_tab.php?op=del&id=".$rst[$i]["subject_id"]."','您确定要删除 ".$rst[$i]["subject_title"]." 这这项调查吗？');\" class=\"b12\">删除</A>";
		
		
		
	if ( ($i % 2) == 0){
		$tmpstr = "";
	} else {							
		$tmpstr = " style='background: #F0F0F0;' ";
	}


	?>
		<tr  width="100%" align="center"  class='TableTd' <?=$tmpstr?>> 
			<td><?=$sTop.$rst[$i]["subject_title"]?></td>
			<td><?=$rst[$i]["subject_time"]?></td>
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

