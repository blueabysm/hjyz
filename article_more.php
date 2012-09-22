<?php
include("database/mysqlDAO.php");
include("functions.php");
$colmnusNames = CreateArrayFromDBList(getAllColumnsName($mysqldao),'columns_id','columns_title');
$tmpstr = "select columns_name,columns_id from columns where ";
if (isset($_GET["id"]))
{
	$tmpstr = $tmpstr . "columns_id='%%s'";
	$args[]= $_GET["id"]; 
}
else if (isset($_GET["h"]))
{
	$tmpstr = $tmpstr . "columns_handle='%%s'";
	$args[]= $_GET["h"];
}
else
{
	header("location:index.php");
	exit;
}
$baseInfo = $mysqldao->findOneRec($tmpstr,$args);
if ($baseInfo == -1)
{
	header("location:index.php");
	exit;
}
$page=1;
if (isset($_GET["page"]))
{	
	$page= $_GET["page"]; 
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
	<?php include("left.php") ?>
    <div class="box1">
	  <div class="list">
        <h2><?=$baseInfo["columns_name"]?></h2>
       <?php $pageStr = showwzlmByIDToPage($mysqldao,$baseInfo["columns_id"],'ul','Y-m-d',35,0,$page); ?>
        </div>
        <div class="clean3"></div>
    <div class="box1" align="center">    
    <?=$pageStr?>	
    </div>
    </div>
    
</div>

<div class="canyu">
 <?php showZybjlmById($mysqldao,29); ?>
</div>
<div class="clean2"></div>
<?php include("bottom.php") ?> 
</body>
</html>

