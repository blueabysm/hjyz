<?
session_start();
include("../../util/commonFunctions.php");
canAcesssThisPage(29);
include_once("../../database/mysqlDAO.php");
$file_url = $_GET["file_url"];
$file_sid = $_GET["file_sid"];

$query = "update down_remes set   admin_read =1  where file_sid = '".$file_sid."'";
$mysqldao ->updateRec($query);

header("location:".$file_url);
?>
