<?
session_start();
include("../database/mysqlDAO.php");
include("loginClass.inc.php");

$myPageClass = new loginClass($_POST,$mysqldao);
$myPageClass->Page_Load();
if(strlen($myPageClass->errorMessage)>=1){
	echo "<script>";
  	echo "window.alert('".$myPageClass->errorMessage."');";  	
  	echo "</script>";
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
		<div class="loginname">教育政务网站管理系统管理员入口</div>
		<form action="login.php" method="post" name="loginForm">			
		
		<div style="height:25px;padding-top: 10px;"> 
			<label for="UserName" class="column">用户名：</label>
			<input type="text" id="userName" name="userName" tabindex="1" style="ime-mode: disabled;" class="text" maxlength="16"/>
		</div>
		<div style="height:25px;margin:8px 0 0 0;clear:left"> 
		  <label for="UserPwd" class="column" >密　码：</label>
		  <input type="password" id="userPwd" name="userPwd" tabindex="2" class="text" maxlength="16"/>		</div> 
				<div style="margin:8px 0 0 0;" id="VerifyArea"> 
						<div style="height:25px"> 
								<label for="userSjm" class="column" >验证码：</label> 
								<input type="text" id="userYzm" size="4" name="userYzm" value="" tabindex="3" style="ime-mode: disabled;" autocomplete="off" maxlength="4" class="text" />
								<IMG title="验证码" SRC="../util/gd_admin.php" WIDTH="35" HEIGHT="18" BORDER="0" ALIGN="absbottom">
						</div>	
				</div> 		 				
		  <div style="padding:12px 0 0 60px;clear:both;height:27px!important;height:;">
		  <input type="submit" class="btn" style="font:bold 12px Verdana;padding-top:2px!important;padding-top:5px;" value="登 录" id="btnLogin" name="btnLogin" tabindex="4"/>
		  </div>
		  </FORM>
	</div>
</div>
</body>
</html>
