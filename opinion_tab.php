<?
$subject_id = $_REQUEST["id"];

include("util/commonFunctions.php");
include_once("database/mysqlDAO.php");
include_once("functions.php");
session_start();

$findAllRec="select subject_title from opinion_subject where subject_id='%%s'";
$args = array($subject_id);
$subject_title = $mysqldao ->findOneRec($findAllRec,$args);

if($_POST["op"]=="add"){
	$subject_id = $_POST["id"];
	$opinion_name = $_POST["opinion_name"];
	$opinion_address = $_POST["opinion_address"];
	$opinion_mphone = $_POST["opinion_mphone"];
	$opinion_phone = $_POST["opinion_phone"];
	$opinion_code = $_POST["opinion_code"];
	$opinion_email = $_POST["opinion_email"];
	$opinion_title = $_POST["opinion_title"];
	$opinion_content = $_POST["opinion_content"];	
	
	$validate = $_SESSION["sessRandomNumber"];
	session_unregister("sessRandomNumber");
	if($validate!=$_POST["validate"]){
		GoToPage("opinion_tab.php","验证码错误！");
		exit;
	}
	
	$findAllRec="insert into opinion (subject_id,opinion_name,opinion_address,opinion_mphone,opinion_phone,opinion_code,opinion_email,opinion_title,opinion_content,opinion_time) values ('$subject_id','$opinion_name','$opinion_address','$opinion_mphone','$opinion_phone','$opinion_code','$opinion_email','$opinion_title','$opinion_content',now())";
	$mysqldao->insertRec($findAllRec);
	$returnInfo="已提交！";

	GoToPage("opinion_list.php?id=".$subject_id,$returnInfo);
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
<script type="text/javascript"> 
<!--
function check(){
	var me=document.form1;
	
	if(IsEmpty(me.opinion_name,"请填写姓名！")) return false;
	if(IsEmpty(me.opinion_phone,"请填写联系电话！")) return false;
	if(IsEmpty(me.opinion_title,"请填写标题！")) return false;
	if(IsEmpty(me.opinion_content,"请填写内容！")) return false;
	if(IsEmpty(me.validate,"请填写验证码！")) return false;
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
    <h2><?=$subject_title["subject_title"]?></h2>
  </div>
  <div class="messsage">请就该文件发表意见：<span class="red12">（*号为必填内容） </div>
  <div class="information">
   <table width="80%" border="0" cellspacing="1" cellpadding="0" bgcolor="#E6E6E6" align="center">
                  <form name="form1" method="post" action="" onsubmit="return check()">
                    <tr bgcolor="#FFFFFF">
                      <td height="24" width="80">姓&nbsp;&nbsp;&nbsp;&nbsp;名：</td>
                      <td width="180" align="left"><span class="red12">
                        <input type="text" name="opinion_name" class="input">
                        *</span></td>
                      <td width="80">联系地址：</td>
                      <td width="180" align="left"><input type="text" name="opinion_address" class="input"></td>
                    </tr>
                    <tr bgcolor="#FFFFFF">
                      <td height="24">手&nbsp;&nbsp;&nbsp;&nbsp;机：</td>
                      <td align="left"><input type="text" name="opinion_mphone" class="input"></td>
                      <td>联系电话：</td>
                      <td align="left"><input type="text" name="opinion_phone" class="input">
                        <span class="red12"> *</span></td>
                    </tr>
                    <tr bgcolor="#FFFFFF">
                      <td height="24">邮&nbsp;&nbsp;&nbsp;&nbsp;编：</td>
                      <td align="left"><input type="text" name="opinion_code" class="input"></td>
                      <td>Email：</td>
                      <td align="left"><input type="text" name="opinion_email" class="input"></td>
                    </tr>
                    <tr bgcolor="#FFFFFF">
                      <td height="24">标&nbsp;&nbsp;&nbsp;&nbsp;题：</td>
                      <td colspan="3" align="left"><input type="text" name="opinion_title" class="input">
                        <span class="red12"> *</span></td>
                    </tr>
                    <tr bgcolor="#FFFFFF">
                      <td height="24">内&nbsp;&nbsp;&nbsp;&nbsp;容：</td>
                      <td colspan="3" align="left"><textarea name="opinion_content" cols="62" rows="4" class="black12"></textarea>
                        <span class="red12">*</span></td>
                    </tr>
                    <tr bgcolor="#FFFFFF">
                      <td height="24">验&nbsp;证&nbsp;码：</td>
                      <td colspan="3" align="left"><input 
                   maxlength=4 size=7 name=validate class="input">
                        &nbsp;&nbsp;<img src="util/gd_admin.php" width="48" height="20" border=0 align="absbottom"> &nbsp; &nbsp;&nbsp;&nbsp;
                        <input type="submit" name="submit" value="提 交" class="btn2">
                        <input type="hidden" name="op"  value="add">
                  		<input type="hidden" name="id"  value="<?=$subject_id?>">
                        </td>
                        
                    </tr>
                  </form>
                </table>
  </div>
 </div> 

<div class="clean2"></div>
<?php include("bottom.php") ?> 
</body>
</html>

