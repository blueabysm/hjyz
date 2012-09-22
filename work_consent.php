<?
session_start();
include_once("util/commonFunctions.php");
include_once("functions.php");
include_once("database/mysqlDAO.php");
//先赋初值为0
$id = 0;
//只有存在该参数情况时才从URL取值
if (isset($_REQUEST["id"])){
	$id = $_REQUEST["id"];
}
//如果为0 或者不是一个纯数字，则表示是非法参数
if ( ($id == 0) || (IsNumber($id) == 0)){
	header("location:index.php");
	exit;
}

		$findAllRec="select * from work where article_id='%%s'";
		$args[]= $id;
		$article = $mysqldao->findOneRec($findAllRec,$args);	
     
		$columnsId = $article["item_id"];
		$article_title = $article["article_title"];		 
		$article_time = $article["article_time"];
		$article_from = $article["article_from"];
		$article_ath = $article["article_ath"];
		$guide = $article["guide"];
		$click_count = $article["click_count"]+1;
		$article_state  = $article["article_state"];
		
		if($article_state==2){
			die("找不到该文章！");
		}
		$upfindAllRec="UPDATE work SET click_count=='%%s' where article_id='%%s'";
		$args = array($click_count,$id);
		$mysqldao->updateRec($upfindAllRec,$args);//增加点击量
		
		$args = array($id);
		$workcontent =$mysqldao->findOneRec("select work_content from work_content where work_id='%%s'",$args); 
		$article_content = htmlspecialchars_decode($workcontent["work_content"]); 
		//echo $article_content;
		
		 
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
    <h2>事项：<?=$article_title?></h2>
  </div>
  <div class="messsage"> <span> 办事指南 </span> </div>
  
   <div class="information">
   <p ><?=$guide?></p>
  </div>
  <div class="messsage"> <span> 内容附件 </span> </div>
    <div class="information">
   <p ><?=$article_content?></p>
  </div>
   <div class="information">
   <p><a name="findAllRec"></a>
   <? include("search_query.php");?></p>
   <p><a name="findAllRec"></a>
   <?  include("search_result.php");?></p>
  
   <p><a name="apply"></a>
    <? include("apply.php");?></p>
    
    <p><a name="question"></a>
    <? include("question_list.php");?>
    </p>
  </div>
  </div> 

<div class="clean2"></div>
<?php include("bottom.php") ?> 

</body>
</html>