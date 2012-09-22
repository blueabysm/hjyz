<?
include("util/commonFunctions.php");
include_once("database/mysqlDAO.php");
include_once("functions.php");

//先赋初值为0
$id = 0;
//只有存在该参数情况时才从URL取值
if (isset($_REQUEST["id"])){
	$id = $_REQUEST["id"];
}
//如果为0 或者不是一个纯数字，则表示是非法参数
if ( ($id == 0) || (IsNumber($id) == 0)){
	header("location:".WEB_DIRECTORY_NAME."error.php?No=003");
	exit;
}
		$findAllRec="select * from work where article_id='%%s'";
		$args= array($id);
		$article =$mysqldao->findOneRec($findAllRec,$args);	
     
		$columnsId = $article["item_id"];
		$article_title = $article["article_title"];		 
		$article_time = $article["article_time"];
		$article_from = $article["article_from"];
		$article_ath = $article["article_ath"];
		$click_count = $article["click_count"]+1;
		$article_state  = $article["article_state"];
		
		if($article_state==2){
			die("找不到该文章！");
		}
		$upfindAllRec="UPDATE work SET click_count='$click_count' where article_id='%%s'";		
		$mysqldao->updateRec($upfindAllRec,$args);	//增加点击量
		
		$article_content = $mysqldao->findOneRec("select work_content from work_content where work_id='%%s'",$args);
		$article_content = htmlspecialchars_decode($article_content["work_content"]);
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

<?php include("top.php") ?>

<div class="content">
  <div class="txtline">
    <h2><?=$article_title?></h2>
  </div>
  <div class="messsage"> <span> 来源：<?=$article_from?> 发表时间] <?=$article_time?> 阅读次数：<?=$click_count?> </span> </div>
  <div class="information">
   <?=$article_content?>
  </div>
 </div> 

<div class="clean2"></div>
<?php include("bottom.php") ?> 

</body>
</html>
