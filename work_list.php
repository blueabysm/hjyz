<?
include_once("database/mysqlDAO.php");
//取得栏目名称
$findAllRec = "select columns_name from work_columns where columns_id='%%s'";
$args= array($id);
$columns_name = $mysqldao->findOneRec($findAllRec,$args);	

//取得该栏目下的文章
$findAllRec = "select article_id,article_title,article_time from work where columns_id='%%s' order by article_time desc";
$rst = $mysqldao->findAllRec($findAllRec,$args);	
?>
<div id="mid_jyyw_zi"><h2><?=$columns_name["columns_name"]?></h2></div>
		<?
		echo "<ul>";
		for($i=0;$i<count($rst);$i++){
			$article_time = substr($rst[$i]["article_time"],0,10);
			$article_title = $rst[$i]["article_title"];
			$article_id = $rst[$i]["article_id"];
		?>
  <li><span class="f_r"><?=$article_time?></span>·<a href="work.php?id=<?=$article_id?>" target="_blank"><?=$article_title?></a></li>
<? }
echo "</ul>";
?> 
