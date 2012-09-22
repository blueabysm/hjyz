<?php
include("database/mysqlDAO.php");
include("functions.php");
include("util/commonFunctions.php");

//先赋初值为0
$id = 0;
//只有存在该参数情况时才从URL取值
if (isset($_REQUEST["id"])){
	$id = $_REQUEST["id"];
}
//如果为0 或者不是一个纯数字，则表示是非法参数
if ( ($id == 0) || (isNumber($id) == 0)){
	header("location:".WEB_DIRECTORY_NAME."error.php?No=003");
	exit;
}

$args = array($id);
$row = $mysqldao -> findOneRec("select * from survey where columns_id='%%s'",$args);
//总票数

if($_REQUEST["t"]==1){
	if($row["survey_type"]==1){//多选
		//$survey_item_id = $_POST["$survey_item_id"];
		$survey_item_id = $_POST["dcItem"];	
		for($i=0;$i<count($survey_item_id);$i++){
			$item_count =  $mysqldao->findOneField("select item_count from survey_item where survey_item_id=".$survey_item_id[$i]);
			$item_count = $item_count+1;
			$findAllRec = "update survey_item set item_count=$item_count where survey_item_id=".$survey_item_id[$i];
			$mysqldao->updateRec($findAllRec);
		}
	}else if($row["survey_type"]==2){//单选		
		$survey_item_id = $_POST["dcItem"];
		$args = array($survey_item_id);
		$findAllRec = "select item_type,item_count from survey_item where survey_item_id='%%s'";
		$row1 = $mysqldao -> findOneRec($findAllRec,$args);
		//答案数量加1
		$item_count = $row1["item_count"]+1;
		$findAllRec = "update survey_item set item_count=$item_count where survey_item_id='%%s'";
		$mysqldao->updateRec($findAllRec,$args);
	}
	
	if(isset($_POST["dcItemzt"])){//自填答案
		$custom_contents=$_POST["dcItemzt"];
		$survey_item_id=$_POST["dcItemztID"];
		$args = array($custom_contents,$survey_item_id);
		$findAllRec = "insert into survey_custom (custom_contents,survey_item_id) values ('%%s','%%s')";
		$mysqldao->insertRec($findAllRec,$args);		
	}
}
$args = array($id);
$countNum=$mysqldao -> findOneField("select sum(item_count) from  survey_item where columns_id='%%s'",$args);


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

<!--页头-->
<?php include("top.php") ?>

<div class="content">
  <div class="txtline">
    <h2>投　票　结　果</h2>
  </div>
  <div class="messsage"> <span>调查题目：【 <?=$row["survey_contents"]; ?> 】</span> </div>
  <div class="information">
   <table width="500" border="3" cellspacing="0" cellpadding="3" align="center">
            <? if($row["text_display_mode"]==2||$row["text_display_mode"]==3){?>
	  	      <tr bgcolor=#CCCCCC>
		        <td colspan=3 align=center>共计票数:<font color=#FF0033> <?=$countNum?> </font></td>
		      </tr>
            <? }?>  
			  <?php
			  $rst = $mysqldao->findAllRec("select * from survey_item where columns_id='$id'");	
			  for($i=0;$i<count($rst);$i++){
			  ?>
		      <TR>
		        <TD align=right>&nbsp;<?=$rst[$i]["item_contents"]?>&nbsp;</TD>				
				<TD>
                <IMG align=middle height=16 src="images/option_0.gif" width=<?=$rst[$i]["item_count"] ?>>&nbsp;
				<? if($row["text_display_mode"]==2||$row["text_display_mode"]==3){?><?=$rst[$i]["item_count"] ?>票&nbsp;<? }?>
				<? if($row["text_display_mode"]==1||$row["text_display_mode"]==3){?>				
				<?
				if($rst[$i]["item_count"]!=0) {
				   $now_count=round($rst[$i]["item_count"]/$countNum*100,2);
				   if($now_count<1) {
				     echo "占0".$now_count;
				   } else {
				     echo "占".$now_count;
				   }
                } else {
				   echo "占0";
				}
				?>%</b>
				<? }?></TD>
                
                
		      </TR>
			  <?  } ?>
		    </table>
  </div>
 </div> 
 
<?php include('bottom.php') ?>
</body>
</html>
