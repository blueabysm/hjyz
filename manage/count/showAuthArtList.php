<?php
session_start();
include_once("../../util/commonFunctions.php");
canAcesssThisPage(51); 

include_once("../../database/mysqlDAO.php");
include("showAuthArtListClass.inc.php");

$myPageClass = new showAuthArtListClass($_POST,$_GET,$mysqldao);
$myPageClass->Page_Load();
if(strlen($myPageClass->errorMessage)>=1){
	echo "<script>";
  	echo "window.alert('".$myPageClass->errorMessage."');";  	
  	echo "</script>";
}
if(strlen($myPageClass->toURL)>=1){
	echo "<script>";
  	echo "window.location='$myPageClass->toURL';";  	
  	echo "</script>";
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" >
<HTML>
<HEAD>
<title><?=$myPageClass->autherName?>文章列表</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<LINK href="../manage.css" type="text/css" rel="stylesheet">
</HEAD>
<body >
<br>
<table id="FormTable" cellSpacing="1" cellPadding="0" width="98%"
	align="center" bgColor="#ffffff" border="0">
	<tr>
		<td class="FormCaption" align="center" bgColor="#668cd9"><?=$myPageClass->autherName?>文章列表</td>
	</tr>
	<tr>
		<td vAlign="middle" align="center" bgColor="#f1f3f5">
		<table height="99%" cellSpacing="1" cellPadding="0" width="100%"
			align="center" bgColor="#ebebeb" border="0">			
			<tr>
				<td align="center" valign="top">
				<TABLE cellSpacing="1" cellPadding="1" width="100%"	bgColor="#ffffff" border="0">
					<tr>
						<td class="TableTdCaption" width="70%" align="center">标题</td>
						<td class="TableTdCaption" width="30%" align="center">发表时间</td>
					</tr>
					<?php					
					for ($i=0;$i<count($myPageClass->artList);$i++)
					{
						if ( ($i % 2) == 0){
							$tmpstr = "";
						} else {							
							$tmpstr = " style='background: #F0F0F0;' ";
						}						
						echo "<tr>\n<td class='TableTd' $tmpstr>";
						echo '<a href="../article/viewArticle.php?id='.$myPageClass->artList[$i]["article_id"].'" target="_blank">';
						echo $myPageClass->artList[$i]["article_title"];
						echo '</a>';
						echo "</td>\n<td class='TableTd' $tmpstr>";
						echo $myPageClass->artList[$i]["article_time"];						
						echo "</td>\n</tr>";					
						
					}					   
					?>
					
				</TABLE>
				</td>
			</tr>
		</table>
		</td>
	</tr>
</table>
</body>
</HTML>
