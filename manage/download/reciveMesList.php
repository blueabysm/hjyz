<?
session_start();
include("../../util/commonFunctions.php");
canAcesssThisPage(49);
include_once("../../database/mysqlDAO.php");

$sWritePath = WEB_DIRECTORY_NAME.WEB_SITE_UPLOAD_URL;
$user_id = $_SESSION["sess_user_id"];
$tmpStrUid = ','.$user_id.',';

$sQueryWhere =" where mes_recive like '%".$tmpStrUid."%' and mes_pass=1 order by  mes_id desc ";
$sQuery="select * from down_mes ";

$sQueryCount="select count(mes_id) from down_mes where mes_recive like '%".$tmpStrUid."%' and mes_pass=1 ";
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
	  <td  align="left"> </td>      
     </tr>
</table>
<TABLE cellSpacing="1" cellPadding="1" width="100%"	bgColor="#ffffff" border="0">	

		<tr  width="100%" align="center" class="TableTdCaption"> 
		 	<td width="4%"><B>序号</B></td>
			<td width="25%"><B>名称</B></td>
            <td width="10%"><B>附件</B></td>
			<td width="23%"><B>备注</B></td>
            <td width="10%"><B>发布时间</B></td>
             <td width="10%"><B>状态</B></td>
			<td width="10%"><B>操作</B></td>
		</tr>

	<?
 for($i=0;$i<count($rst);$i++){	
 	$tmpMesId = $rst[$i]["mes_id"];		
		
	//是否已回复
	$sRemes = $mysqldao->findOneRec(" select remes_id ,admin_read from down_remes where mes_id = '".$tmpMesId."' and user_id=$user_id ");
	//echo " select remes_id ,admin_read from down_remes where mes_id = '".$tmpMesId."' and user_id=$user_id ";
	//print_r($sRemes);
	$iRemesId = $sRemes["remes_id"];
	 $fAdminRead = $sRemes["admin_read"];//管理员是否已读
	//附件下载
	$sFilePath =  $mysqldao -> findOneField("select file_path from down_files where file_sid = '".$rst[$i]["file_sid"]."'");
		//状态
	$sReciveHandle = '未回复	';
	$mesHandle = 'no';
	if($iRemesId <> ''){//已回复
		$mesHandle = 'ok';
		if($fAdminRead == 0){
			$sReciveHandle = '已回复(管理员未读)';
		}else{
			$sReciveHandle = '已回复(管理员已读)';
		}
	}
	//回传
	$sModLink="<A HREF=\"reciveApplyTab.php?mesHandle=".$mesHandle."&r_id=".$iRemesId."&mes_id=".$rst[$i]["mes_id"]."\" class=\"b12\">回复</A>&nbsp;";
	if ( ($i % 2) == 0){
		$tmpstr = "";
	} else {			
		$tmpstr = " style='background: #F0F0F0;' ";
	}

	?>
		<tr  width="100%" align="center"  class='TableTd' <?=$tmpstr?>>
			<td><?=$i+1?></td> 
			<td><?=$rst[$i]["mes_title"]?></td>
			<td><a href="<?=$sWritePath.$sFilePath?>" class=b12>下载</a></td>
            <td><?=substr($rst[$i]["mes_note"],0,20)?></td>
			<td><?=substr($rst[$i]["mes_time"],0,10)?></td>
			<td><?php echo $sReciveHandle;?></td>
			<td><?=$sModLink?></td>
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

