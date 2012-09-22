<?
//取得栏目名称
$findAllRec = "select columns_id,columns_name from work_columns where columns_handle='xzxk'";
$row = $mysqldao->findOneRec($findAllRec);
$columns_name = $row["columns_name"];
$id = $row["columns_id"];
//取得该栏目下的文章
$findAllRec = "select article_id,article_title,article_time from work where columns_id='%%s' order by article_time desc";

$args = array($id);
$rst = $mysqldao->findAllRec($findAllRec,$args);	
?>
<div id="mid_jyyw_zi"><h2><?=$columns_name?></h2></div>
<?
echo "<ul>";
for($i=0;$i<count($rst);$i++){
	$article_time = substr($rst[$i]["article_time"],0,10);
	$article_title = $rst[$i]["article_title"];
	$article_id = $rst[$i]["article_id"];
?>
      <li><span class="f_r">[<a href="flow.php?id=<?=$article_id?>"  target="_blank" class="gray12">流程图示</a>] [<a href="work_consent.php?id=<?=$article_id?>"  target="_blank" class="gray12">办事指南</a>] [<a href="work_consent.php?id=<?=$article_id?>#apply"  target="_blank" class="gray12">我要申报</a>] [<a href="work_consent.php?id=<?=$article_id?>#work"  target="_blank" class="gray12">表格下载</a>] [<a href="work_consent.php?id=<?=$article_id?>#question"  target="_blank" class="gray12">常见问题</a>]</span>·<a href="work_consent.php?id=<?=$article_id?>" target="_blank"><?=$article_title?></a></li>
      
<? }
echo "</ul>";
?>