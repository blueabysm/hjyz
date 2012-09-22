<?
include_once("database/mysqlDAO.php");
include("util/commonFunctions.php");
session_start();

$mail_vocation = $_POST["mail_vocation"];
$mail_age = $_POST["mail_age"];
$mail_email = $_POST["mail_email"];
$mail_phone = $_POST["mail_phone"];
$mail_name = $_POST["mail_name"];
$mail_address = $_POST["mail_address"];
	 
$mail_type = $_POST["mail_type"];
$mail_content = $_POST["mail_content"];
$mail_title = $_POST["mail_title"];
$mail_field = $_POST["mail_field"];
$mail_area = $_POST["mail_area"];
$mail_sex = $_POST["mail_sex"];
               
$mail_open = $_POST["mail_open"];

$validate = $_SESSION["sessRandomNumber"];
session_unregister("sessRandomNumber");
if($validate!=$_POST["validate"]){
	GoToPage("mailbox_index.php","验证码错误！");
	exit;
}

$query="INSERT INTO mail (mail_vocation,mail_age,mail_email,mail_phone,mail_name,mail_address,mail_type,mail_content,mail_title,mail_field,mail_area,mail_open,write_time,mail_sex) values ('$mail_vocation','$mail_age','$mail_email','$mail_phone','$mail_name','$mail_address','$mail_type','$mail_content','$mail_title','$mail_field','$mail_area','$mail_open',now(),'$mail_sex') ";

$mysqldao->insertRec($query);


$mail_id=mysql_insert_id();
$findAllRec = "select mail_title,write_time from mail where mail_id='%%s'";
$args = array($mail_id);
$mail = $mysqldao->findOneRec($findAllRec,$args);


//加入查询码
$query_code = substr(md5($mail["write_time"]),-17); 
$findAllRec = "update mail set query_code='$query_code' where mail_id='%%s'";					   
$mysqldao->updateRec($findAllRec,$args);
?>
 
 
 
 
 
 
 
<HTML>
<HEAD>
<TITLE>网上诉求子系统（局长信箱）</TITLE>
<META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=UTF-8">
<script type="text/javascript" src="scripts/pubjs/pubjs.js"></script>
<style type="text/css"> 
<!--
.style1 {
	color: #FFFFFF;
	font-size: 16px;
	font-weight: bold;
}
.style2 {
	font-size: 14px;
	font-weight: bold;
}
.style3 {font-size: 12px}
-->
</style>
</HEAD>
<BODY BGCOLOR=#FFFFFF LEFTMARGIN=0 TOPMARGIN=0 MARGINWIDTH=0 MARGINHEIGHT=0>
<br>
<br>
<br>
 
<table width="476" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr background="images/xtts_4.png">
    <td width="12"><img src="images/xtts_3.png" width="12" height="40"></td>
    <td width="452" background="images/xtts_4.png"><span class="style1">查询信息提示&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
   <a   class="style1" href="#" onClick=history.go(-1)>
    返回</a></span></td>
    <td width="12"><div align="right"><img src="images/xtts_6.png" width="12" height="40"></div></td>
  </tr>
  <tr>
    <td colspan="3"><table width="476" border="0" cellspacing="1" bgcolor="7CCADA">
      <tr>
        <td bgcolor="F6FCFD"><blockquote>
          <table width="375" border="0" align="center">
            <tr>
              <td height="40"><div align="center"><img src="images/chengong.jpg" width="227" height="90"></div></td>
            </tr>
              <tr>
              <td height="50"><div align="center" class="style2">主题：<?=$mail["mail_title"]?></div></td>
            </tr>
            <tr>
              <td height="50"><div align="center" class="style2">查询码：<?=$query_code?></div></td>
            </tr>
            <tr>
              <td height="40"><div align="center" class="style3">
                <div align="left">提示：查询码（英文字母区分大小写）是您查询此信件办理状态及回复意见的唯一标识，您可以手工记录查询码，也可以：</div>
              </div></td>
            </tr>
            <tr>
              <td height="25"><div align="right" class="style3"><!--<a target="_blank" href="/jzxxAcceptOutViewer.qd?id=117687">下载保存</a>  -->
             <a href="#" onClick="javascript:window.print();">在线打印</a></div></td>
            </tr>
          </table>
          </blockquote></td>
      </tr>
    </table></td>
  </tr>
</table>
</BODY>
</HTML>
