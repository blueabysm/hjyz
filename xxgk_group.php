<?php
include("database/mysqlDAO.php");
include("functions.php");
if (isset($_GET["id"]))
{
	$args= array($_GET["id"],$_GET["id"]); 
}
else
{
	header("location:index.php");
	exit;
}

$colmnusNames = CreateArrayFromDBList(getAllColumnsName($mysqldao),'columns_id','columns_title');
$tmpstr = "select columns_name,columns_id,sub_id,(select count(*) from article where article_state=1 and  item_id='%%s') have_article from columns where columns_id='%%s'";

$baseInfo = $mysqldao->findOneRec($tmpstr,$args);
if ($baseInfo == -1)
{
	header("location:index.php");
	exit;
}
$cols = array();

if ($baseInfo["have_article"]>0){
	$cols[] = $_GET["id"];
}
if (strlen($baseInfo["sub_id"])<1){
	header("location:index.php");
	exit;
}
$tmpList = explode(',',$baseInfo["sub_id"]);
for($i=0;$i<count($tmpList);$i++){
	if (strlen($tmpList[$i])>0){	
		$tmpstr = 'select columns_id from columns where (columns_type_id=1 or columns_type_id=13) and columns_id='.$tmpList[$i];
		$baseInfo = $mysqldao->findOneRec($tmpstr);
		if ($baseInfo == -1)
		{
			continue;
		}
		$cols[]=$tmpList[$i];
	}
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
        <?php for($i=0;$i<count($cols);$i++){?>
        <h2 style="font-size:11pt;"><?=$colmnusNames[$cols[$i]]?> (<a style="font-size: 9pt" href="xxgk_more.php?id=<?=$cols[$i]?>">>>更多</a>)</h2>
        <?php showxxgkByID($mysqldao,$cols[$i],'ul','','y-m-d',10,38); ?>       
        <?php }?>
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

