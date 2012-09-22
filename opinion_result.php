<?

include_once("database/mysqlDAO.php");
include_once("functions.php");

if(!$_REQUEST["id"])die("参数错误");
$subject_id = $_REQUEST["id"];
$subject_title = $mysqldao->findOneField("select subject_title from opinion_subject where subject_id='$subject_id'");

$args = array($subject_id);
$rs=$mysqldao -> findOneField("select count(opinion_id) from opinion where subject_id='$subject_id'");
$rs_pass=$mysqldao->findOneField("select count(opinion_id) from opinion where subject_id='$subject_id' and opinion_pass=3");
$rs_unpass=$mysqldao->findOneField("select count(opinion_id) from opinion where subject_id='$subject_id' and opinion_pass=2");

if ($rs ==0){
 $pass=0;	
 $unpass=0;
} else {
 $pass=substr($rs_pass*100/$rs,0,4);
  $unpass=substr($rs_unpass*100/$rs,0,4);
}

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

<!--top-->
<?php include("top.php") ?>

<div class="content">
  <div class="txtline">
    <h2><?=$subject_title?></h2>
  </div>
  <div class="messsage"></div>
  <div class="information">
    <table width="520" border="0" cellpadding="0" cellspacing="1" bgcolor="#E6E6E6">
              <tr bgcolor="#FFFFFF"> 
                <td height="24" colspan="2">意见征集结果分析：</td>
              </tr>
              <tr bgcolor="#FFFFFF"> 
                <td height="24" colspan="2">&nbsp;&nbsp;&nbsp;&nbsp;本文件的网上征集意见数共 
                  <?=$rs?>
                  条，其中采纳了 
                  <?=$rs_pass?>
                  条，占总征集数的 
                  <?=$pass?>
                  % ；处理中的网上征集数有 
                  <?=$rs_unpass?>
                  条，占总征集数的 
                  <?=$unpass?>
                  % 。 </td>
              </tr>
              <tr bgcolor="#FFFFFF"> 
                <td width="240" height="24">&nbsp;&nbsp;&nbsp;&nbsp;征集意见采纳数(
                  <?=$rs_pass?>
                  ) </td>
                <td width="280" height="24" align="left">&nbsp;<IMG align=middle height=16 src="images/option_0.gif" width=<?php
				if($pass!=0) {
				   echo round($pass)*2;
				} else {
				   echo "0";
				}
				?>>
                &nbsp;&nbsp;<?=$pass?>%
                </td>
              </tr>
              <tr bgcolor="#FFFFFF"> 
                <td height="24">&nbsp;&nbsp;&nbsp;&nbsp;征集意见处理中数(
                  <?=$rs_unpass?>
                  )</td>
                <td  height="24" align="left">&nbsp;<IMG align=middle height=16 src="images/option_0.gif" width=<?php
				if($unpass!=0) {
				   echo round($unpass)*2;
				} else {
				   echo "0";
				}
				?>>
                &nbsp;&nbsp;<?=$unpass?>%</td>
              </tr>
              <tr bgcolor="#FFFFFF"> 
                <td  height="24">&nbsp;&nbsp;&nbsp;&nbsp;意见征集总数(
                  <?=$rs?>
                  ) </td>
                <td  height="24" align="left">&nbsp;<IMG align=middle height=16 src="images/option_0.gif" width=<?php
				
				   echo round(100)*2;
				
				?>>
                &nbsp;&nbsp;100%</td>
              </tr>
            </table> 
  </div>
 </div> 

<?php include('bottom.php') ?>
</body>
</html>
