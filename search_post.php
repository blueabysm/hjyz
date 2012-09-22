<?php include("database/mysqlDAO.php")?>
<?php include("functions.php")?>
<?
$keyword=trim($_POST["keyword"]);
if (strlen($keyword) <=0) {
	$info = "未输入要查找的关键字";
} else {	
	$sql = "select article_id,article_title,article_time,article_from,s_id from article where  article_state=1 and article_title like '%%%s%' order by article_time desc";	
	$args[]= $keyword;
    $articleList = $mysqldao->findAllRec($sql,$args);
	if ( ($articleList == -1) || (count($articleList) <= 0) ) {
		$info = '未找到与 “<font color="red">'.$keyword.'</font>” 有关的信息';
	} else {
		$info = -1;
	}
		
}
?>
<?php include("top_base.php") ?>


<div class="content">
<?php
  if ($info == -1) {
  	$seaCount = count($articleList);
  	for($i=0;$i<$seaCount;$i++){
  		$title = $articleList[$i]['article_title'];
  		$title = str_replace($keyword, '<font color="red">'.$keyword.'</font>', $title);
  		$id = $articleList[$i]['s_id'];
  		if ($id == 0) {$id = $articleList[$i]['article_id'];}
  		echo '<a href="article.php?id='.$id.'" style="color:blue;font-size:11pt;">'.$title.'</a><br>';
  		echo '[ 来源：'.$articleList[$i]['article_from'].' ] [ 时间：'.$articleList[$i]['article_time'].' ]<br><br>';
  	}
  } else {
  	echo $info;
  }
?>
</div>

 <?php include('bottom.php') ?>
</body>
</html>
