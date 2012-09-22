<?php
include_once("database/mysqlDAO.php");
include_once("functions.php");
if (isset($_GET["id"]))
{
	$id= $_GET["id"]; 
}
else
{
	header("location:index.php");
	exit;
}

$colmnusNames = CreateArrayFromDBList(getAllColumnsName($mysqldao),'columns_id','columns_title');

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
        <h2 ><?=$colmnusNames[$id]?></h2>
        <?php showDclmByID($mysqldao,$id,'') ?>   
         <div class="clean3"></div>
    </div>
    
</div>




<?php include("bottom.php") ?> 
</body>
</html>

