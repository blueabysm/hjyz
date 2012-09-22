<?php
session_start();
include_once("../util/commonFunctions.php");
canAcesssThisPage(0); 

include_once("../database/mysqlDAO.php");


$fid = 0;
if(isset($_GET["file_id"]))
{
	$fid = trim($_GET["file_id"]);
}
if ( ($fid == 0) || (IsNumber($fid) == 0) ) exit;
$sqlstr = "update upload_files set file_state=2 where is_sys=0 and file_id=$fid";
$mysqldao->updateRec($sqlstr);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" >
<HTML>
<HEAD>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">		
</HEAD>
<body>
<script type="text/javascript">
 if (window.parent != window.self)
{
	 window.parent.onChangeFileStateEnd();
}
</script>
</body>
</HTML>