<?
session_start();
include("../database/mysqlDAO.php");
$name=$_POST["userName"];
$pass=$_POST["pass"];
if($name!="" && $pass!=""){
		$newmima=md5($pass);
		$sqlstr = "update admins set user_pwd='".$newmima."' where user_name='".$name."'";
		echo $name."你的新密码已生效";
}
?>
<html> 
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"> 
<title>教育政务网站管理系统管理员入口</title>
<link href="<?=skin?>css/style.css" rel="stylesheet" type="text/css">
</head>
<body>
<div align="center">
	<div style="text-align:left;float:none; width:300px;width:323px;background:#9c9c9c;border:1px solid #78a3d3;padding:12px"  align="center"> 
		<div class="loginname">重设密码</div>
		<form action="getpass.php" method="post" name="loginForm">			
		
		<div style="height:25px;padding-top: 10px;"> 
			<label for="UserName" class="column">用户名：</label>
			<input type="text" id="userName" name="userName" tabindex="1" style="ime-mode: disabled;" class="text" maxlength="16"/>
		</div>
		<div style="height:25px;padding-top: 10px;"> 
			<label for="UserName" class="column">新密码：</label>
			<input type="text" id="pass" name="pass" tabindex="1" style="ime-mode: disabled;" class="text" maxlength="16"/>
		</div>				
		  <div style="padding:12px 0 0 60px;clear:both;height:27px!important;height:;">
		  <input type="submit" class="btn" style="font:bold 12px Verdana;padding-top:2px!important;padding-top:5px;" value="查询" id="btnLogin" name="btnLogin" tabindex="4"/>
		  </div>
		  </FORM>
	</div>
</div>
</body>
</html>