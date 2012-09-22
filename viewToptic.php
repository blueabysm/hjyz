<?php
include_once("database/mysqlDAO.php");
include_once("functions.php");

$tmpstr = "select (select file_name from upload_files u where u.file_id=big_img_id) b_file_name,big_img_width,big_img_height,slide_id,article_column_id,html_column_id,imagetable_id,toptic_name,toptic_href,toptic_note from columns_toptic where columns_toptic_id='%%s'";
$args[]= $_GET["id"];
$baseInfo = $mysqldao->findOneRec($tmpstr,$args);
if ($baseInfo == -1)
{
	header("location:".WEB_DIRECTORY_NAME."error.php?No=004");
	exit;
}

$tmpstr = trim($baseInfo["toptic_href"]);
if (strlen($tmpstr))
{
	header("location:$tmpstr");
	exit;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml"> 
<head> 
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" /> 
<title><?=WEB_SITE_NAME?>-<?=$baseInfo["toptic_name"]?></title> 
<link href="<?=skin?>css/style.css" rel="stylesheet" type="text/css"/>
<script src="js/slider.js"></script>
</head>
 
<body> 
<!--header--> 
<!--top-->
<?php include("top.php") ?>
 
<!--中间 all--> 
<div class="content">
  <div class="box">
   <p ><a href="index.php" class="red12">首页 </a><span class="red12"> >>  <?php showColumnsNameByID($mysqldao,3);?></p>
 </div>
 <?php
 	echo "<img src='" .$baseInfo["b_file_name"];
 	echo "' width='" .$baseInfo["big_img_width"] . "' height='" . $baseInfo["big_img_height"] . "'/>";
 ?>
  

   <table border="0" cellpadding="0" cellspacing="0" align="center" width="100%">
   <tr>
	   <td width="30%" valign="top" align="left" style="position: relative">
	     <?php showTphdp($mysqldao,$baseInfo["slide_id"],5); ?> 
	   </td>
   	<td valign="top" align="left" width="35%">
   	   <h2 align="center" style="height:24px;line-height: 16pt;"><?php showWzlmOneRec($mysqldao,$baseInfo["article_column_id"],15);?></h2>
   	   <hr style="height: 2px;width: 99%"></hr>
   	   <p style="color: #3480ac;font-size: 9pt;line-height: 8pt;">
		<? if($baseInfo["toptic_note"]!=""){?>导读: <?=$baseInfo["toptic_note"]?><br/><br/><? }?>
       </p> 
   	   <p style="font-weight: normal">
	     <?php showWzlmByID($mysqldao,$baseInfo["article_column_id"],'','','',5,27); ?>
	   </p>
   	</td>
   <td width="30%" valign="top" align="left" height="275px">
   <div class="tongji2" style="height: 100%;width: 97%">
	      <h3><?php showColumnsNameByID($mysqldao,$baseInfo["html_column_id"]);?></h3> 
	      <?php showZybjlmById($mysqldao,$baseInfo["html_column_id"]);?>
       </div>
    
   </td>
   </tr>
   </table>
   <table border="0" cellpadding="0" cellspacing="0" align="center" width="100%">
   <tr>
	   <td width="50%" valign="top" align="left">
	      <div class="tongji2" style="height: 100%">
	      <h3><?php showColumnsNameByID($mysqldao,$baseInfo["imagetable_id"]);?></h3> 
	     <?php showTpbglmById($mysqldao,$baseInfo["imagetable_id"],''); ?>
       </div>
	   </td>
   	<td valign="top" align="left" width="50%" height="300px">
	  <div class="tongji2" style="height: 100%;width: 98%">
	     <h3><?php showColumnsNameByID($mysqldao,$baseInfo["article_column_id"]);?></h3> 
	      <?php showWzlmByID($mysqldao,$baseInfo["article_column_id"],'ul','','y-m-d',10,30); ?>
	       <a href='article_more.php?id=<?=$baseInfo["article_column_id"]?>'>&nbsp;更多...</a>
       </div>
   	</td>
   </tr>
   </table>

 </div> 
 
<!--foot-->   
<?php include("bottom.php") ?>
</body> 
</html> 