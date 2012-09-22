<?php
include_once("database/mysqlDAO.php");
include_once("functions.php");
include_once("util/commonFunctions.php");
//先赋初值为0
$corp_id = 0;
//只有存在该参数情况时才从URL取值
if (isset($_REQUEST["id"])){
	$corp_id = $_REQUEST["id"];
}
//如果为0 或者不是一个纯数字，则表示是非法参数
if ( ($corp_id == 0) || (IsNumber($corp_id) == 0)){
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
	<?php include("left_part.php") ?>
    <div class="box1">
	  <div class="list">
        <h2>学校领导</h2>
       <?php showHeadListById($mysqldao,$corp_id,'text_list3','more4',0); ?>
        </div>
        <div class="clean3"></div>
    </div>
    
</div>

<div class="canyu">
 <?php showZybjlmById($mysqldao,29); ?>
</div>
<div class="clean2"></div>

<?php include("bottom.php") ?> 
</body>
</html>

