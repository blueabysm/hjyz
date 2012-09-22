<?php
include_once("database/mysqlDAO.php");
include_once("functions.php");
$colmnusNames = CreateArrayFromDBList(getAllColumnsName($mysqldao),'columns_id','columns_title');

$tmpstr = "select corp_id,head_id,article_column_id,head_name,head_photo,head_post,head_post2,head_note,head_mail,(select file_name from upload_files where file_id=head_photo) file_name from corp_head where head_id='%%s'";
$args[]= $_GET["id"];
$baseInfo = $mysqldao->findOneRec($tmpstr,$args);
$cid = $baseInfo["article_column_id"];
if(isset($_GET["cid"])){			
 $cid = $_GET["cid"];			
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?=WEB_SITE_NAME?></title>
<link href="<?=skin?>css/style.css" rel="stylesheet" type="text/css"/>
<script src="js/slider.js"></script>
</head>
<body>

<!--页头-->
<?php include("top.php") ?>

<div class="content"> 
	<?php include("left_part.php") ?>
    <div class="box1">
	  <div class="list">        
	<div align="left">
	 <table border="0" cellspacing="0" cellpadding="0" width="100%"> 
	   <tr bgcolor="#FFFFFF" valign="top">
	    <td>&nbsp;&nbsp;&nbsp;</td> 
          <td align="left" width="140px"> 
            
			   <?php 
			     if (strlen($baseInfo["file_name"])>1) {
			     	echo '<img width="140" height="180" src="'.$baseInfo["file_name"].'"/>';
			     } else {
			     	echo '<img width="140" height="180" src="images/photo.jpg"/>';
			     } 
			   ?>
          </td>
          <td>&nbsp;&nbsp;</td>
          <td align="left">
           <br/>
            <table width="100%" align="left">
              <tr><td valign="top" align="right" width="20%" height="30"><b>姓　　名:</b></td><td width="80%" valign="top"><?=$baseInfo["head_name"]?></td></tr>
              <tr><td valign="top" align="right" height="30"><b>职　　务:</b></td><td valign="top"><?=$baseInfo["head_post"]?></td></tr>
              <tr><td valign="top" align="right" height="30"><b>分管工作:</b></td><td valign="top"><?=$baseInfo["head_post2"]?></td></tr>
              <tr><td valign="top" align="right" height="30"><b>邮　　箱:</b></td><td valign="top"><?=$baseInfo["head_mail"]?></td></tr>
              <tr><td valign="top" align="right"><b>简　　历:</b></td><td valign="top"><?=$baseInfo["head_note"]?></td></tr>
            </table>
          </td>
         </tr>
	 </table>
	 </div>
	
	<h2><a href="article_more.php?id=<?=$cid?>" class="more"></a><?=$colmnusNames[$cid]?></h2>
  	<?php showWzlmByID($mysqldao,$cid,'ul','','y-m-d',10,38); ?>  	 
		
         <div class="clean3"></div>
    </div>
    
</div>

<?php include("bottom.php") ?> 
</body>
</html>

