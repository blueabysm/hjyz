<?
include_once("database/mysqlDAO.php");
include_once("functions.php");

$subject_id = $_REQUEST["id"];

$findAllRec="select * from opinion where subject_id='%%s'";
$args = array($subject_id);
$rst = $mysqldao -> findAllRec($findAllRec,$args);	
	
$subject_title = $mysqldao -> findOneField("select subject_title from opinion_subject where subject_id='%%s'",$args);	
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

<!--top-->
<?php include("top.php") ?>


<div class="content">
  <div class="txtline">
    <h2><?=$subject_title?> 征集意见公示：</h2>
  </div>
  <div class="messsage"></div>
  <div class="information">
   <table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#E6E6E6">
              <? for($i=0;$i<count($rst);$i++){?>
			  <tr bgcolor="#F3EFE6"> 
                <td width="70%" height="24" align="left">标题：<?=$rst[$i]["opinion_title"]?></td>
                <td width="30%" class="gray12"  align="right">时间：<?=$rst[$i]["opinion_time"]?></td>
              </tr>
			 <tr bgcolor="#FFFFFF"> 
                <td height="24" colspan="2" align="left">内容：<?=$rst[$i]["opinion_content"]?></td>
              </tr>
			<tr bgcolor="#FFFFFF"> 
                <td height="5" colspan="2" align="left"></td>
              </tr>
               <? }?>           
			               
            </table> 
            
  </div>
 </div> 
            
<div class="clean2"></div>
<?php include("bottom.php") ?> 

</body>
</html>
