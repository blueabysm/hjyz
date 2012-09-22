<?
session_start();
include("../../util/commonFunctions.php");
canAcesssThisPage(26);




include_once("../../database/mysqlDAO.php");

$sQueryWhere =" order by opinion_pass , opinion_time desc ";
$sQuery="select * from opinion ";
//$rsArticle = $mysqldao->findAllRec($sfindAllRec);

$sQueryCount="select count(opinion_id) from opinion ";
$sRsVarName="rst";
include ("../../util/cut_page.php");
//取得要显示的文章列表))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))结束


?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" >
<HTML>
<HEAD>
<title>SysTools</title>
<LINK href="../manage.css" type="text/css" rel="stylesheet">
<script src="../../js/function.js"></script>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
</HEAD>
<body >

<br/>

<table cellSpacing="1" cellPadding="0" width="99%" align="center" bgColor="#ebebeb" border="0"  class="FormLabel">
	
    <table width="98%" border="0" align="center" cellpadding="0" cellspacing="1" bgcolor="#ffffff" id="FormTable">
	<tr>
		<td align="center" bgcolor="#668cd9" class="FormCaption">民意征集结果管理</td>
	</tr>
	<tr>
		<td bgcolor="#f1f3f5">
<table cellSpacing="1" cellPadding="0" width="99%" align="center" bgColor="#ebebeb" border="0"  class="FormLabel">

    <tr align="center" >       
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
			<td width="29%"><B>标题</B></td>
            <td width="28%"><B>针对题目</B></td>
			<td width="13%"><B>发表时间</B></td>
            <td width="9%"><B>状态</B></td>
			<td width="21%"><B>操作</B></td>
		</tr>



	<?

	for($i=0;$i<count($rst);$i++){		
		
				
		//修改
		$sModLink="<A HREF=\"opinion_result_tab.php?op=mod&id=".$rst[$i]["opinion_id"]."\" class=\"b12\">查看修改</A>&nbsp;";		

		//删除
		$sDeleteLink="<A href=\"javascript:PopConfirm('opinion_result_tab.php?op=del&id=".$rst[$i]["opinion_id"]."','您确定要删除 ".$rst[$i]["subject_title"]." 这这项调查吗？');\" class=\"b12\">删除</A>";
		
		$subject_title = $mysqldao->findOneRec("select subject_title from opinion_subject where subject_id=".$rst[$i]["subject_id"]);
		$subject_title = $subject_title["subject_title"];
	switch ($rst[$i]["opinion_pass"]){
		case 3: $opinion_pass = "已采纳";  break;
		case 2: $opinion_pass = "处理中";  break;
		case 1: $opinion_pass = "未处理";  break;
		default:  $opinion_pass = "未处理";
	}
	
	
	
	if ( ($i % 2) == 0){
		$tmpstr = "";
	} else {							
		$tmpstr = " style='background: #F0F0F0;' ";
	}


	?>
		<tr  width="100%" align="center"  class='TableTd' <?=$tmpstr?>> 
			<td><?=$sTop.$rst[$i]["opinion_title"]?></td>
            <td><?=$subject_title?></td>
			<td><?=$rst[$i]["opinion_time"]?></td>
            <td><?=$opinion_pass?></td>
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

