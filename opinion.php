<?
$subject_id = $_REQUEST["id"];

include("util/commonFunctions.php");
include_once("database/mysqlDAO.php");
include_once("functions.php");


		$findAllRec="select * from opinion_subject where subject_id='%%s'";
		$args = array($subject_id);
		$opinion = $mysqldao->findOneRec($findAllRec,$args);	
     
		$click_count = $opinion["click_count"]+1;		

		$upfindAllRec="UPDATE opinion_subject SET click_count='%%s' where subject_id='%%s'";
		$args = array($click_count,$subject_id);
		$mysqldao->updateRec($upfindAllRec,$args);//累加点击量		 
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



<body>
<!--top-->
<?php include("top.php") ?>

<div class="content">
  <div class="txtline">
    <h2><?=$opinion["subject_title"]?></h2>
  </div>
  <div class="messsage"> <span> 来源：<?=$opinion["subject_from"]?> 发表时间] <?=$opinion["subject_time"]?> 阅读次数：<?=$opinion["click_count"]?> </span> </div>
  <div class="information">
   <?=$opinion["subject_content"]?>
  </div>
  
  <table width="80%" border="0" cellpadding="0" cellspacing="1" bgcolor="#DBDBDB" align="center">
      <tr > 
                <td width="25%">&nbsp;</td>
                <td width="12%" height="25" align="center" bgcolor="#F3F3F3"><a href="opinion_tab.php?id=<?=$subject_id?>" class="black12" target="_blank">发表意见</a></td>
                    
                  
                <td width="8%">&nbsp;</td>            
                <td width="12%" align="center" bgcolor="#F3F3F3"><a href="opinion_list.php?id=<?=$subject_id?>" class="black12" target="_blank">意见公示</a></td>
                 
                <td width="8%">&nbsp;</td>
                 <td width="12%" height="25" align="center" bgcolor="#F3F3F3"><a href="opinion_result.php?id=<?=$subject_id?>" class="black12" target="_blank">结果分析</a></td>
                 <td width="25%">&nbsp;</td>
        </tr>           
</table>
  
 </div> 

<div class="clean2"></div>
<?php include("bottom.php") ?> 

</body>
</html>
