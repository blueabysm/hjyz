 <?
	$findAllRec = "select * from opinion_subject order by subject_order desc,subject_time desc";
	$rst = $mysqldao -> findAllRec($findAllRec);
 ?>
<div id="mid_jyyw_zi"><h2>民意征集</h2></div>
<?
  echo "<ul>";
   for($i=0;$i<count($rst);$i++){
?>
<li><span class="f_r"><?=$rst[$i]["subject_time"]?></span>·<a href="opinion.php?id=<?=$rst[$i]["subject_id"]?>" target="_blank"><?=$rst[$i]["subject_title"]?></a></li>      
       
<? }
echo "</ul>";
?>  
