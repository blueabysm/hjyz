<?
include("database/mysqlDAO.php");
include("functions.php");

function GetIP(){
   if (getenv("HTTP_CLIENT_IP") && strcasecmp(getenv("HTTP_CLIENT_IP"), "unknown"))
           $ip = getenv("HTTP_CLIENT_IP");
       else if (getenv("HTTP_X_FORWARDED_FOR") && strcasecmp(getenv("HTTP_X_FORWARDED_FOR"), "unknown"))
           $ip = getenv("HTTP_X_FORWARDED_FOR");
       else if (getenv("REMOTE_ADDR") && strcasecmp(getenv("REMOTE_ADDR"), "unknown"))
           $ip = getenv("REMOTE_ADDR");
       else if (isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], "unknown"))
           $ip = $_SERVER['REMOTE_ADDR'];
       else
           $ip = "unknown";
   return($ip);
}

if (isset($_REQUEST["id"])){
	$article_id = $_REQUEST["id"];
} else {
	$article_id = $_POST["article_id"];
}

$args = array($article_id);
$findAllRec="select article_title,comments_type,item_id from article  where article_state=1 and article_id='%%s'";
$article = $mysqldao->findOneRec($findAllRec,$args);	
if ($article == -1){
	$article_title = "未找到文章";
} else {
	$article_title = $article["article_title"];	
	
    $op = $_REQUEST["op"];
	if ((ARTICLE_COMMENTS_FLAG==true) && ($op=="add")){	
		$article_id = $_POST["article_id"];
		$comments_guest_ip = GetIP();
		$comments_type = $article["comments_type"];
		$comments_title = strip_tags(trim($_POST["comments_title"]));
		$comments_content = strip_tags($_POST["comments_content"]);
		$comments_guest_name = strip_tags($_POST["comments_guest_name"]);
		
		$comments_state = 2;//评论状态默认为：关闭，不显示
		if($comments_type==3){
			$comments_state = 1;
		}
		$item_id = $article["comments_type"];
		$findAllRec="INSERT INTO article_comments (comments_title,comments_content,article_id,comments_time,comments_guest_ip,comments_state,comments_guest_name,item_id) VALUES ('%%s','%%s','%%s',now(),'$comments_guest_ip','$comments_state','%%s','$item_id') ";
		
		$args = array($comments_title,$comments_content,$article_id,$comments_guest_name);
		$mysqldao->insertRec($findAllRec,$args);
	}
	$args = array($article_id);
	$findAllRec = "select * from article_comments where article_id='%%s' and comments_state=1 order by comments_time desc";
    $rsComments = $mysqldao->findAllRec($findAllRec,$args);
}

	 
?>
<?php include("top_article.php") ?>
<div class="content">
  <div class="txtline">
    <h2>对 “<a href="article.php?id=<?=$article_id?>" style="color:blue"><?=$article_title?></a>” 的评论</h2>
  </div>
  <div class="messsage"></div>
  <div class="information">
  <?php  for($i=0;$i<count($rsComments);$i++){
		?>
	 <hr/>	
	  [#<?=$i+1?>] <b style="color: black"><?=$rsComments[$i]["comments_title"]?></b><br/>
	  
      	&nbsp;&nbsp;<font style="color: black"><?=$rsComments[$i]["comments_content"]?></font>
      	<br>
      	<font style="font-size: 9pt">
      评论人：<?=$rsComments[$i]["comments_guest_name"]?>&nbsp; 评论时间：<?=$rsComments[$i]["comments_time"]?>
      </font>
      <hr/></br>
      <? }?>
  </div>
  <div class="messsage"></div>
 </div> 
 
   
<?php include('bottom.php') ?>
</body>
</html>