<?php 
session_start();
header("Content-Type: text/html; charset=UTF-8");
include("../../util/commonFunctions.php");
include("online_service_lib.inc.php");
canAcesssThisPage(54);


$sUserName = $_SESSION["sess_user_name"];
$sKey = 'zxzf32!2';
$timeOut = '600000';
$siteCode = '10002';
$toUrl = "http://cs.e21.cn/remoteLogin.php?wid=".$siteCode."&s=";
$aRs = array(
	$sUserName,
	$siteCode
);

$oMcrypt = new Mcrypt_class($sKey,$timeOut);
$sParameterValue = $oMcrypt -> Encode($aRs);

$toUrl.=$sParameterValue;
header("location:".$toUrl);

?>
