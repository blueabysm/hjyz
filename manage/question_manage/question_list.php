<?
session_start();
include("../../util/commonFunctions.php");
canAcesssThisPage(28);




include_once("../../database/mysqlDAO.php");

$sQueryWhere =" order by question_state desc,question_time desc ";
$sQuery="select * from question ";
//$rsArticle = $sql->findAllRec($sfindAllRec);

$sQueryCount="select count(question_id) from question ";
$sRsVarName="rst";
include ("../../util/cut_page.php");
//取得要显示的文章列表))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))结束


?>




<script src="../../js/function.js"></script>


<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" >
<HTML>
<HEAD>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>SysTools</title>
<LINK href="../manage.css" type="text/css" rel="stylesheet">
</HEAD>
<body >

<br/>

<table cellSpacing="1" cellPadding="0" width="99%" align="center" bgColor="#ebebeb" border="0"  class="FormLabel">
	
    <table width="98%" border="0" align="center" cellpadding="0" cellspacing="1" bgcolor="#ffffff" id="FormTable">
	<tr>
		<td align="center" bgcolor="#668cd9" class="FormCaption">网上答疑管理</td>
	</tr>
	<tr>
		<td bgcolor="#f1f3f5">
<table cellSpacing="1" cellPadding="0" width="99%" align="center" bgColor="#ebebeb" border="0"  class="FormLabel">

    <tr align="center" > 
        <td   align="left"><A HREF="question_tab.php?op=add" class="red12">添加</A></td>
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
			<td width="37%"><B>问题</B></td>
			<td width="13%"><B>时间</B></td>
            <td width="17%"><B>类型</B></td>
        <td width="14%"><B>状态</B></td>
			<td width="19%"><B>操作</B></td>
		</tr>



	<?

	for($i=0;$i<count($rst);$i++){	
		//对应网上办事的类型
		$question_type=$mysqldao->findOneRec("select article_title from work where  article_id=".$rst[$i]["consent_id"]);
		$question_type = $question_type[0];

		//状态
		switch ($rst[$i]["question_state"]){
			case 1: $question_state = "未回答";  break;
			case 2: $question_state = "已回答";  break;
			default:  $question_state = "未回答";
		}
		//修改
		$sModLink="<A HREF=\"question_tab.php?op=mod&id=".$rst[$i]["question_id"]."\" class=\"b12\">修改</A>&nbsp;";
		
		//回答
		$sAnswerLink="<A HREF=\"answer_tab.php?id=".$rst[$i]["question_id"]."\" class=\"b12\">回答</A>&nbsp;";

		//删除
		$sDeleteLink="<A href=\"javascript:PopConfirm('question_tab.php?op=del&id=".$rst[$i]["question_id"]."','您确定要删除 ".$rst[$i]["question_content"]." 这这项调查吗？');\" class=\"b12\">删除</A>";
		
		
		
	if ( ($i % 2) == 0){
		$tmpstr = "";
	} else {							
		$tmpstr = " style='background: #F0F0F0;' ";
	}


	?>
		<tr  width="100%" align="center"  class='TableTd' <?=$tmpstr?>> 
			<td><?=$rst[$i]["question_content"]?></td>
			<td><?=$rst[$i]["question_time"]?></td>
            <td><?=$question_type?></td>
            <td><?=$question_state?></td>
			<td><?=$sAnswerLink.$sModLink.$sDeleteLink?></td>
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

