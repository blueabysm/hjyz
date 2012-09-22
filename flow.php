<?
include("util/commonFunctions.php");
include_once("database/mysqlDAO.php");
include_once("functions.php");
//先赋初值为0
$article_id = 0;
//只有存在该参数情况时才从URL取值
if (isset($_REQUEST["id"])){
	$article_id = $_REQUEST["id"];
}
//如果为0 或者不是一个纯数字，则表示是非法参数
if ( ($article_id == 0) || (IsNumber($article_id) == 0)){
	header("location:".WEB_DIRECTORY_NAME."error.php?No=003");
	exit;
}




		$findAllRec="select * from article where article_id='%%s'";
		$args = array($article_id);
		$article = $mysqldao->findOneRec($findAllRec,$args);	
     
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
		 
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?=WEB_SITE_NAME?></title>
<link href="<?=skin?>css/style.css" rel="stylesheet" type="text/css"/>
<script src="js/slider.js"></script>
<script src="js/function.js"></script>
<script>
<!--
function check(){
	var me=document.commentsForm;
	if(IsEmpty(me.comments_guest_name,"请填写姓名！")) return false;
	if(IsEmpty(me.comments_title,"请填写评论标题！")) return false;
	if(IsEmpty(me.comments_content,"请填写评论类容！")) return false;
	if(Trim(me.comments_content.value).length<6){
		alert("评论类容字数太少！");
		me.comments_content.focus();
		return false;
	}
	return confirm("您确定要提交吗？");
}

//-->
</script>
</head>
<body>

<!--top-->
<?php include("top.php") ?>

<div class="content">
  <div class="txtline">
    <h2></h2>
  </div>
  <div class="messsage"> <span></div>
  <div class="information">
   <table width="850" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr> 
          <td><img src="images/liuchengtu_001.gif" width="800" height="908" border="0" usemap="#Map">
            <map name="Map">
              <area shape="rect" coords="306,160,507,201" href="work_consent.php?id=<?=$id?>#apply" target="_blank"/>
              <area shape="rect" coords="568,836,759,878" href="work_list.php" target="_blank"/>
              <area shape="rect" coords="293,238,522,287" href="work_consent.php?id=<?=$id?>#findAllRec" target="_blank"/>
              <area shape="rect" coords="287,355,526,392" href="work_consent.php?id=<?=$id?>#findAllRec" target="_blank"/>
              <area shape="rect" coords="591,351,734,395" href="work_consent.php?id=<?=$id?>#findAllRec" target="_blank"/>
              <area shape="rect" coords="336,429,722,471" href="work_consent.php?id=<?=$id?>#findAllRec" target="_blank"/>
              <area shape="rect" coords="446,508,629,550" href="work_consent.php?id=<?=$id?>#findAllRec" target="_blank"/>
              <area shape="rect" coords="476,586,602,628" href="work_consent.php?id=<?=$id?>#findAllRec" target="_blank"/>
              <area shape="rect" coords="303,690,504,732" href="work_consent.php?id=<?=$id?>#findAllRec" target="_blank"/>
              <area shape="rect" coords="595,690,728,732" href="work_consent.php?id=<?=$id?>#findAllRec" target="_blank"/>
              <area shape="rect" coords="445,757,611,800" href="work_consent.php?id=<?=$id?>#findAllRec" target="_blank"/>
          </map></td>
        </tr>
      </table>
  </div>
  
  
  
 </div> 

<div class="clean2"></div>
<?php include("bottom.php") ?> 

</body>
</html>
