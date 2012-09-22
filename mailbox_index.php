<?php
include_once("database/mysqlDAO.php");
include_once("functions.php");
include_once("util/commonFunctions.php");
include_once("database/mysqlDAO.php");


$colmnusNames = CreateArrayFromDBList(getAllColumnsName($mysqldao),'columns_id','columns_title');

$tmpstr = "select article_column_id,part_name,part_master,part_phone,part_monitor_phone,part_note from columns_partlist where columns_partlist_id='%%s'";
$args[]= $_GET["id"];
$baseInfo = $mysqldao->findOneRec($tmpstr,$args);
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
	<?php include("left.php") ?>
    <div class="box1">
	  <div class="list">
        <h2>校长信箱</h2>
       <?php include("mailbox.php") ?>
        </div>
        <div class="clean3"></div>
    <div class="box1" align="center"> </div>
    </div>    
</div>

<div class="clean2"></div>
<?php include("bottom.php") ?> 
</body>
</html>

