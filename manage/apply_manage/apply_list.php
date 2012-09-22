<?
session_start();
include("../../util/commonFunctions.php");
canAcesssThisPage(27);




include_once("../../database/mysqlDAO.php");

$sQueryWhere =" order by xm_pass ,time desc ";
$sQuery="select * from apply ";

$sQueryCount="select count(id) from apply ";
$sRsVarName="rst";
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

<table cellSpacing="1" cellPadding="0" width="99%" align="center" bgColor="#ebebeb" border="0"  class="FormLabel">
	
    <table width="98%" border="0" align="center" cellpadding="0" cellspacing="1" bgcolor="#ffffff" id="FormTable">
	<tr>
		<td align="center" bgcolor="#668cd9" class="FormCaption">网上申报管理</td>
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
			<td width="29%"><B>项目名称</B></td>
            <td width="23%"><B>申请人姓名</B></td>
			<td width="23%"><B>申请时间</B></td>
            <td width="10%"><B>状态</B></td>
			<td width="15%"><B>操作</B></td>
		</tr>



	<?

	for($i=0;$i<count($rst);$i++){		
		
				
		//修改
		$sModLink="<A HREF=\"apply_tab.php?op=mod&id=".$rst[$i]["id"]."\" class=\"b12\">查看处理</A>&nbsp;";		

		//删除
		$sDeleteLink="<A href=\"javascript:PopConfirm('apply_tab.php?op=del&id=".$rst[$i]["id"]."','您确定要删除 ".$rst[$i]["xm_name"]." 这这项调查吗？');\" class=\"b12\">删除</A>";
		
		
	switch ($rst[$i]["xm_pass"]){
		case 3: $xm_pass = "已处理";  break;
		case 2: $xm_pass = "处理中";  break;
		case 1: $xm_pass = "未处理";  break;
		default:  $xm_pass = "未处理";
	}
	
	
	
	if ( ($i % 2) == 0){
		$tmpstr = "";
	} else {							
		$tmpstr = " style='background: #F0F0F0;' ";
	}


	?>
		<tr  width="100%" align="center"  class='TableTd' <?=$tmpstr?>> 
			<td><?=$rst[$i]["xm_name"]?></td>
            <td><?=$rst[$i]["user_name"]?></td>
			<td><?=$rst[$i]["time"]?></td>
            <td><?=$xm_pass?></td>
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

