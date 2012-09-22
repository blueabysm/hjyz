<?

$sQueryWhere =" where question_state=2 order by question_time desc";
$sQuery="select * from question ";

$sQueryCount="select count(question_id) from question ";
$sRsVarName="rst";
include ("util/cut_page.php");

		
?>
<div id="mid_jyyw_zi"><h2>常见问题</h2></div>
		<?
		echo "<ul>";
   
		for($i=0;$i<count($rst);$i++){
		$question_content=$rst[$i]["question_content"];
		$question_content = "<a href='question.php?id=".$rst[$i]["question_id"]."' target='_blank'>".$question_content."</a>";
		$question_time = $rst[$i]["question_time"];
		
		$findAllRec1="select * from answer where question_id='%%s'";
		$args = array($rst[$i]["question_id"]);
		$row1=$mysqldao -> findOneRec($findAllRec1,$args);
		$answer=$row1["answer_content"];
		$answer_time=$row1["answer_time"];
		
		
		?>
  <li><span class="f_r"><?=$question_time?></span>·<font color=red>[问:]</font><font class="h12"><?=$question_content?></font></li>
  <li><span class="f_r"><?=$answer_time?></span>·<font color=blue>[答:]</font><font class="h12"><?=$answer?></font></li>
<? }

		
		echo "</ul>";
		

?> 
<div align="right">
<?
	echo "</br>";
	$cs="&".$sCutPage;
	$span_class="blue12";
	$link_class="blue12";
	include ("util/fenye_css.php");
?>
</div>