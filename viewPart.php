<?php
include_once("database/mysqlDAO.php");
include_once("functions.php");
$colmnusNames = CreateArrayFromDBList(getAllColumnsName($mysqldao),'columns_id','columns_title');

$tmpstr = "select corp_id,part_id,article_column_id,part_name,part_master,part_phone,part_monitor_phone,part_note,part_addr,part_mail,(select file_name from upload_files where file_id=master_photo) file_name from corp_part where part_id='%%s'";
$args[]= $_GET["id"];
$baseInfo = $mysqldao->findOneRec($tmpstr,$args);
$tmpstr = "select column_id from corp_part_sub where item_id='%%s' and c_type=1 order by sub_order";	
$coteList = $mysqldao->findAllRec($tmpstr,$args);
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
        <h2><?=$baseInfo["part_name"]?> 职能</h2>
		<p><?=$baseInfo["part_note"]?></p>
		
		<h2>负责人和联系方式</h2>
	<div align="left">
	 <table border="0" cellspacing="0" cellpadding="0"> 
	   <tr bgcolor="#FFFFFF" valign="top">
	    <td>&nbsp;&nbsp;&nbsp;</td> 
          <td align="right"> 
            
			   <?php 
			     if (strlen($baseInfo["file_name"])>1) {
			     	echo '<img width="140" height="180" src="'.$baseInfo["file_name"].'"/>';
			     } 
			   ?>
          </td>
          <td>&nbsp;&nbsp;</td>
          <td>
           <br/>
            <table>
              <tr><td align="right" height="30"><b>负  责  人 :</b></td><td><?=$baseInfo["part_master"]?></td></tr>
              <tr><td align="right" height="30"><b>联系电话:</b></td><td><?=$baseInfo["part_phone"]?></td></tr>
              <tr><td align="right" height="30"><b>监督电话:</b></td><td><?=$baseInfo["part_monitor_phone"]?></td></tr>
              <tr><td align="right" height="30"><b>联系地址:</b></td><td><?=$baseInfo["part_addr"]?></td></tr>
              <tr><td align="right" height="30"><b>邮　　箱:</b></td><td><?=$baseInfo["part_mail"]?></td></tr>
            </table>
          </td>
         </tr>
	 </table>
	 </div>
	
	 <?php for($i=0;$i<count($coteList);$i++){?>
	 <h2><a href="article_more.php?id=<?=$coteList[$i]['column_id']?>" class="more"></a><?=$colmnusNames[$coteList[$i]['column_id']]?></h2>
  	 <?php showWzlmByID($mysqldao,$coteList[$i]['column_id'],'ul','','y-m-d',5,38); ?>
  	 <?php }?>
		
         <div class="clean3"></div>
    </div>
    
</div>

<?php include("bottom.php") ?> 
</body>
</html>

