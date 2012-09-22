<?
session_start();
include("../../util/commonFunctions.php");
canAcesssThisPage(49);

include_once("../../database/mysqlDAO.php");
$sWritePath = WEB_DIRECTORY_NAME.WEB_SITE_UPLOAD_URL;
//取得参数
if (isset($_REQUEST["id"])){
	$id = $_REQUEST["id"];
	//如果为0 或者不是一个纯数字，则表示是非法参数
	if ( ($id == 0) || (IsNumber($id) == 0)){
		header("location:".WEB_DIRECTORY_NAME."error.php?No=003");
		exit;
	}
}

$row = $mysqldao-> findOneRec("select mes_title,mes_recive,mes_readover  from down_mes where   mes_id=$id ");

$strMesTitle = $row["mes_title"];
//发送对象id 和 已读对象id转换成数组
$aRecive = explode(',',substr($row["mes_recive"],1,strlen($row["mes_recive"])-2));
$aReadOver = explode(',',substr($row["mes_readover"],1,strlen($row["mes_readover"])-2));

$rows = $mysqldao-> findAllRec("select user_id,user_realname from admins where (user_type<>5 and user_type<>9)");
$aRows = CreateArrayFromRs($rows,'user_id');
?>

<html>
<head>
<title>反馈情况表</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<style type="text/css">
<!--
td {  font-size: 9pt}
-->
</style>
</head>

<body bgcolor="#ffffff" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<table border=0 cellpadding=1 cellspacing=1   width=700 vspace="10" bgcolor="#666666">
 <tr   valign=center bgcolor="#E1E1E1"> 
  <td height=24 colspan="5" align="center" >“<?php echo $strMesTitle;?>”  反馈情况</td>
 </tr>
 <tr   valign=center bgcolor="#CCCCCC"> 
  <td height=24 width="23%"  align="center" >用户名称</td>
  <td  width="10%"  align="center" >是否阅读</td>
  <td  width="36%"  align="center" >反馈信息名称</td>
  <td  width="8%"  align="center" >反馈附件</td>
  <td  width="17%"  align="center" >反馈时间</td>
 </tr>
<?php

  for($i=0;$i<count($aRecive);$i++){
    if(in_array($aRecive[$i],$aReadOver)){//已读
    	$strRead = '已读';
    	//读取回复信息标题
    	$sTitle = $mysqldao->findOneRec(" select mes_title,mes_time,file_sid from down_remes where mes_id = '".$id."' and user_id='".$aRecive[$i]."' ");
    	$sFilePath =  $mysqldao -> findOneField("select file_path from down_files where file_sid = '".$sTitle["file_sid"]."'");
    }else{
    	$strRead = '<font color=red>未读</font>';
    }
    if($i%2==0){
    	$tmpbc = "#E1E1E1";
    }else{	
    	$tmpbc = "#CCCCCC";
    }
    
  ?>
    <tr align=left valign=center bgcolor=<?php echo $tmpbc;?>>
       <td height=21   >&nbsp;
         <?php echo $aRows[$aRecive[$i]]["user_realname"];?>
       </td>
	   <td  align="center" ><?php echo $strRead;?></td>
	   <td  align="center"><?php echo $sTitle["mes_title"];?> </td>
	   <td  align="center"><?
	   if($sFilePath<>''){
	   	echo "<a href=fileload.php?file_sid=".$sTitle["file_sid"]."&file_url=".$sWritePath.$sFilePath." class=b12>下载</a>";
	   }
	   ?></td>
	   <td  align="center"><?php echo substr($sTitle["mes_time"],0,10);?> </td>
  	</tr>
  	<?php
  	unset($sTitle);
  	unset($sFilePath);
	 }?>
	 <tr align=center valign=center bgcolor="#CCCCCC"> 
      <td height=32 colspan="5" align="right"><a href="#" onClick="window.history.back();";><b>返回<b/></a>&nbsp;</td>
  </tr>
   </form>
 </table>
 
</body>
  