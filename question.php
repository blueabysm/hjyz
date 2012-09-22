<?
include_once("util/commonFunctions.php");
include_once("database/mysqlDAO.php");
include("functions.php");
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



 $findAllRec="select * from question where question_id='%%s'";
 $args = array($id);
   $row=$mysqldao -> findOneRec($findAllRec,$args);	
   $question_id=$row["question_id"];
   $question_content=$row["question_content"];


   $findAllRec1="select * from answer where question_id='%%s'";
 	$args = array($question_id);
	$row1=$mysqldao -> findOneRec($findAllRec1,$args);	
	$answer=$row1["answer_content"];
	$answer_time=substr($row1["answer_time"],5,5);
		 
		 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?=WEB_SITE_NAME?></title>
<link href="<?=skin?>css/style.css" rel="stylesheet" type="text/css"/>
<script src="js/slider.js"></script>
<script src="js/function.js"></script>
</head>
<body>






<body>
<!--top-->
<?php include("top.php") ?>

<div class="content">
  <div class="txtline">
    <h2>常见问题</h2>
  </div>
  <div class="messsage"></div>
  <div class="information">
    <table width="800" border="0" cellspacing="0" cellpadding="0" class="h12">
        <tr> 
          <td height="30" align="left" class="blue14"> <font color=red>[问:]</font><font class="h12">
            <?=$question_content?>
            </font></td>
        </tr>
        <tr> 
          <td height="30" align="left" class="blue14"><font color=10AFCC> [提问时间:]</font><font class="h12">
            <?=$row["question_time"]?>
            </font></td>
        </tr>
        <tr> 
          <td height="30" align="left" class="blue14"> <font color=red>[答:]<font class="blue12">
            <?=$answer?>
            </font></font></td>
        </tr>
        <tr> 
          <td height="30" align="left" class="blue14"><font color=10AFCC> [回复时间:]</font><font class="h12">
            <?=$answer_time?>
            </font></td>
        </tr>
        <tr> 
          <td height=8></td>
        </tr>
      </table>
  </div>
 </div> 


<div class="clean2"></div>
<?php include("bottom.php") ?> 
</body>
</html>
