<?
include("database/mysqlDAO.php");
include("util/commonFunctions.php");
include("functions.php");
//先赋初值为0
$article_id = 0;
//只有存在该参数情况时才从URL取值
if (isset($_REQUEST["id"])){
	$article_id = $_REQUEST["id"];
}
//如果为0 或者不是一个纯数字，则表示是非法参数
if ( ($article_id == 0) || (IsNumber($article_id) == 0)){
	header("location:index.php");
	exit;
}

$findAllRec="select a.*,(select count(*) from article_comments b where b.article_id=a.article_id) c_count from article a where a.article_state=1 and a.article_id='%%s'";
$args[]= $article_id;
$article = $mysqldao->findOneRec($findAllRec,$args);	
if ($article == -1){
	$info = "未找到文章";
} else {
	$columnsId = $article["item_id"];
	$article_title = $article["article_title"];		 
	$article_time = $article["article_time"];
	$article_from =$article["article_from"];
	$article_key= $article["article_key"];
	$article_ath = $article["article_ath"];
	$click_count = $article["click_count"]+1;
	$article_state  = $article["article_state"];
	$c_count =  $article["c_count"];
	//增加点击量
	$upfindAllRec="UPDATE article SET click_count='%%s' where article_id='%%s'";
	$args = array($click_count,$article_id);
	$mysqldao->updateRec($upfindAllRec,$args);
	//取内容
	$args = array($article_id);
	$article_content = $mysqldao -> findOneRec("select article_content from article_content where article_id='%%s'",$args);
	$article_content = htmlspecialchars_decode($article_content["article_content"]);
	
	//上一条
	$findAllRec="select article_id,article_title from article where item_id='".$columnsId."' and article_id>'".$article_id."' order by article_time asc limit 1";
    $pntext = $mysqldao->findOneRec($findAllRec);
    //print_r($pntext);
	if ($pntext == -1){
		$ptext = "没有了";
	} else {
	    $text=cutstr($pntext["article_title"],25,1);
		$ptext="<a target='_self' href='article.php?id=".$pntext["article_id"]."' title='".$pntext["article_title"]."'>".$text."</a>";
	}
	
	//下一条
	$findAllRec="select article_id,article_title from article where item_id='".$columnsId."' and article_id<'".$article_id."' order by article_time desc limit 1";
    $pntext = $mysqldao->findOneRec($findAllRec);
	if ($pntext == -1){
		$ntext = "没有了";
	} else {
	    $text=cutstr($pntext["article_title"],25,1);
		$ntext="<a target='_self' href='article.php?id=".$pntext["article_id"]."' title='".$pntext["article_title"]."'>".$text."</a>";
	}
	
}	 
?>
<?php include("top_article.php") ?>
<script>
function check(){
	var me=document.commentsForm;
	if(IsEmpty(me.comments_guest_name,"请填写姓名！")) return false;
	if(IsEmpty(me.comments_title,"请填写评论标题！")) return false;
	if(IsEmpty(me.comments_content,"请填写评论内容！")) return false;
	if(Trim(me.comments_content.value).length<6){
		alert("评论类容字数太少！");
		me.comments_content.focus();
		return false;
	}
	return confirm("您确定要提交吗？");
}
</script>
<div class="content">
  <div style="background-color:#F3EFE6;padding:50 10 50 20"><h5>信息名称：<?=$article_title?> <br>
  <span style="text-align:left">信息类别：<?=$article_ath?> 发文机构：<?=$article_from?> 公开时间：<?=$article_time?>  浏览次数：<?=$click_count?><hr>内容概述：<?=$article_key?></h5></div>
  <div class="information">
   <?=$article_content?>
  </div>
  <div class="messsage"><span style="float:left">上一页：<?=$ptext?></span> <span style="float:right">下一页：<?=$ntext?></span> </div>
 </div> 
               
   
<? if( (ARTICLE_COMMENTS_FLAG==true) && ($article["comments_type"]==2||$article["comments_type"]==3)){?>
<div class="content">
  <div class="messsage"></div>
  <div class="information"> 
<form id="form1" name="commentsForm" method="post" action="comments_list.php" onsubmit="return check();">
  <table width="600" border="0" cellspacing="0" cellpadding="0" class="tabel" align="left">
    <tr>
      <td width="30%" align="right">姓名:</td>
      <td width="70%" align="left"><label>
        <input type="text" name="comments_guest_name" class="input" maxlength="45"/>
      </label></td>
    </tr>
    <tr>
      <td align="right">标题:</td>
      <td align="left"><input type="text" name="comments_title" class="input" maxlength="120"/></td>
    </tr>
    <tr>
      <td align="right">内容:</td>
      <td align="left"><label>
        <textarea cols="50" rows="4" name="comments_content" ></textarea>
      </label></td>
    </tr>
    <tr>
      <td colspan="2" align="center">
        <input type="submit"  name="submit" value="发表评论" />
        <input type="hidden" name="op" value="add" />
        <a style="font-size:9pt;" href="comments_list.php?id=<?=$article_id?>">查看评论</a>
      </td>
    </tr>
    <input type="hidden" name="article_id" value="<?=$article_id?>"/>
  </table>
 </form>
 
  </div>
</div>  
   <? }?>
   
<?php include('bottom.php') ?>
</body>
</html>
