<?
session_start();
include("../../util/commonFunctions.php");
canAcesssThisPage(29);


include_once("../../database/mysqlDAO.php");

$sQueryWhere =" order by mes_pass ,mes_id desc ";
$sQuery="select * from down_mes ";

$sQueryCount="select count(mes_id) from down_mes ";
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
		<td align="center" bgcolor="#668cd9" class="FormCaption">下载中心管理</td>
	</tr>
	<tr>
		<td bgcolor="#f1f3f5">
<table cellSpacing="1" cellPadding="0" width="100%" align="center" bgColor="#ebebeb" border="0"  class="FormLabel">

    <tr align="center" > 
	  <td  align="left"><A HREF="applyTab.php" class="blue12">添 加</A></td>    
        <td   align="right"> </td>
    </tr>
</table>

<TABLE cellSpacing="1" cellPadding="1" width="100%"	bgColor="#ffffff" border="0">	

		<tr  width="100%" align="center" class="TableTdCaption"> 
		 	<td width="5%"><B>序号</B></td>
			<td width="35%"><B>名称</B></td>
            <td width="17%"><B>公开程度</B></td>
			<td width="23%"><B>发布时间</B></td>
            <td width="10%"><B>状态</B></td>
			<td width="15%"><B>操作</B></td>
		</tr>

	<?

	for($i=0;$i<count($rst);$i++){			
		//修改
		$sModLink="<A HREF=\"applyTab.php?mesHandle=edit&id=".$rst[$i]["mes_id"]."\" class=\"b12\">修改</A>&nbsp;";		
		//删除
		$sDeleteLink="<A href=\"javascript:PopConfirm('applyTab.php?mesHandle=del&del_sid=".$rst[$i]["file_sid"]."&id=".$rst[$i]["mes_id"]."','您确定要删除 该记录吗？');\" class=\"b12\">删除</A>";
		
	if($rst[$i]["mes_pass"] == 1){
		$mespass = "有效";
	}else{
		$mespass = "<font color=red>无效</font>";
	}
	
	if ( ($i % 2) == 0){
		$tmpstr = "";
	} else {							
		$tmpstr = " style='background: #F0F0F0;' ";
	}

	if($rst[$i]["mes_recive"] == '0'){
		$tmpStrOpen = '完全公开';
	}else{
		$tmpStrOpen = '不完全公开&nbsp;'."<A HREF=\"mesRecive.php?id=".$rst[$i]["mes_id"]." \" class=\"b12\">(查看)</A>";
	}
	?>
		<tr  width="100%" align="center"  class='TableTd' <?=$tmpstr?>>
			<td><?=$i+1?></td> 
			<td class="blue12"><?=$rst[$i]["mes_title"]?></td>
			<td><?=$tmpStrOpen?></td>
            <td><?=$rst[$i]["mes_time"]?></td>
			<td><?=$mespass?></td>
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

