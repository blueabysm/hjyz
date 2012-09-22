<?php
include_once("database/mysqlDAO.php");
include_once("functions.php");
$tmpstr = "select sub_columns_id,item_title from columns_link2 where columns_id=34 order by item_order";
$rst = $mysqldao->findAllRec($tmpstr); 
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

<!--中间 all-->

<div class="content">
  <div class="txtline">
    <h2><?php showColumnsNameByID($mysqldao,34);?></h2>
  </div>
  <div class="messsage"></div>
  <div class="information">
   <? for($i=0;$i<count($rst);$i++){?>
		<table width="790" border="0" cellspacing="0" cellpadding="0"
			class="black12">
			<tr>
				<td height="30" bgcolor="#EFEFEF" align="left"><img
					src="images/dot3.gif" width="6" height="9" align="absmiddle"><b> </b><span
					class="red12"><strong><?=$rst[$i]["item_title"]?></strong></span></td>
			</tr>
			<tr>
				<td height="30" align="left">
		<? 
				$sub_columns_id = $rst[$i]["sub_columns_id"];
				$args = array($sub_columns_id);
				$rst1 = $mysqldao->findAllRec("select * from columns_link where columns_id='%%s' order by item_order desc",$args);
				
				for($j=0;$j<count($rst1);$j++){

			  ?> <a class='black12' style='color:black;' href='<?=$rst1[$j]["item_link"]?>'><? echo $rst1[$j]["item_title"];echo " &nbsp; &nbsp; &nbsp;";if(($j+1)%8==0)echo "<br>";?></a>
			  <? }?>			  
			  </td>
			</tr>
			<tr>
				<td height="20"></td>

			</tr>
		</table>
		<? }?>
  </div>
 </div> 
<div class="clean2"></div>
<?php include("bottom.php") ?>
</body>
</html>
